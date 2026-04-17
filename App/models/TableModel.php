<?php
/**
 * TableModel - Handles all database operations for tables
 * 
 * This model communicates with the "tables" table in the database.
 * It provides methods to check availability, get tables, and update status.
 */

namespace App\Models;

class TableModel
{
    // Database connection (PDO object)
    private $pdo;

    /**
     * Constructor - Gets the database connection when model is created
     * 
     * This uses the Singleton pattern from Database class to get
     * a single, reusable connection to the database.
     */
    public function __construct()
    {
        $this->pdo = \Database::getInstance()->getConnection();
    }

    /**
     * Check if a specific table is available at a given date and time
     * 
     * @param int    $table_id The ID of the table to check
     * @param string $date     The date to check (format: YYYY-MM-DD)
     * @param string $time     The time to check (format: HH:MM:SS)
     * @return bool            True if available, false if already reserved
     */
    public function isTableAvailable($table_id, $date, $time)
    {
        // SQL query to find any conflicting reservations
        $sql = "SELECT * FROM reservations
                WHERE table_id = ?
                AND date = ?
                AND time = ?
                AND status IN ('pending', 'confirmed')";

        // Prepare and execute the query (prevents SQL injection)
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$table_id, $date, $time]);

        // If we found a reservation, the table is NOT available
        if ($stmt->rowCount() > 0) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Get all tables that can fit the required number of players
     * AND are available at the given date and time
     * 
     * @param int    $players_count Minimum capacity needed
     * @param string $date          Date to check
     * @param string $time          Time to check
     * @return array                Array of available tables
     */
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

        // Return all matching rows as an associative array
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get ALL tables from the database
     * 
     * @return array All tables with their details
     */
    public function getAllTables()
    {
        $sql = "SELECT * FROM tables ORDER BY id ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get a single table by its ID
     * 
     * @param int $table_id The table ID to find
     * @return array|false The table data or false if not found
     */
    public function getTableById($table_id)
    {
        $sql = "SELECT * FROM tables WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$table_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Update a table's status
     * 
     * @param int    $table_id The table ID to update
     * @param string $status   New status ('available', 'reserved', 'occupied')
     * @return bool            True if update succeeded
     */
    public function updateTableStatus($table_id, $status)
    {
        $sql = "UPDATE tables SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $table_id]);
    }

    /**
     * Get the current status of a specific table
     * 
     * @param int $table_id The table ID to check
     * @return string|false The status or false if not found
     */
    public function getTableStatus($table_id)
    {
        $sql = "SELECT status FROM tables WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$table_id]);
        return $stmt->fetchColumn();
    }

    /**
     * Count total number of tables
     * 
     * @return int Total table count
     */
    public function countTables()
    {
        $sql = "SELECT COUNT(*) FROM tables";
        $stmt = $this->pdo->query($sql);
        return (int) $stmt->fetchColumn();
    }
}
