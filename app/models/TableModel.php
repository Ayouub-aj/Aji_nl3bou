<?php

namespace Src\tables;


class TableModel
{
    private $pdo;

    // constructor
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    // Check if ONE table is available at a date and time
    public function isTableAvailable($table_id, $date, $time)
    {
        $sql = "SELECT * FROM reservations
                WHERE table_id = ?
                AND date = ?
                AND time = ?
                AND status IN ('pending', 'confirmed')";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$table_id, $date, $time]);

        if ($stmt->rowCount() > 0) {
            return false; // table already reserved
        } else {
            return true; // table free
        }
    }

    // Get all tables that are available for players count
    public function getAvailableTables($players_count, $date, $time)
    {
        $sql = "SELECT * FROM tables
                WHERE capacity >= ?
                AND id NOT IN (
                    SELECT table_id FROM reservations
                    WHERE date = ?
                    AND time = ?
                    AND status IN ('pending', 'confirmed')
                )";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$players_count, $date, $time]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Change table status (free, reserved, occupied)
    public function updateTableStatus($table_id, $status)
    {
        $sql = "UPDATE tables SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $table_id]);
    }

    // Get current status of a table
    public function getTableStatus($table_id)
    {
        $sql = "SELECT status FROM tables WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$table_id]);

        return $stmt->fetchColumn();
    }
}