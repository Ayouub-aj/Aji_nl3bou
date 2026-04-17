<?php
/**
 * ReservationModel - Handles all database operations for reservations
 * 
 * This model communicates with the "reservations" table in the database.
 * It provides methods for creating, updating, and managing reservations.
 */

namespace App\Models;

class ReservationModel
{
    // Database connection (PDO object)
    private $pdo;

    /**
     * Constructor - Gets the database connection
     */
    public function __construct()
    {
        $this->pdo = \Database::getInstance()->getConnection();
    }

    /**
     * Get ALL reservations
     * 
     * @return array All reservations with related info
     */
    public function getAllReservations()
    {
        $sql = "SELECT r.*, t.name as table_name, t.capacity as table_capacity,
                       g.title as game_title
                FROM reservations r
                LEFT JOIN tables t ON r.table_id = t.id
                LEFT JOIN games g ON r.game_id = g.id
                ORDER BY r.date DESC, r.time DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get reservations for a specific date
     * 
     * @param string $date Date in YYYY-MM-DD format
     * @return array Reservations for that date
     */
    public function getReservationsByDate($date)
    {
        $sql = "SELECT r.*, t.name as table_name, t.capacity as table_capacity,
                       g.title as game_title
                FROM reservations r
                LEFT JOIN tables t ON r.table_id = t.id
                LEFT JOIN games g ON r.game_id = g.id
                WHERE r.date = ?
                ORDER BY r.time ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$date]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get a single reservation by ID
     * 
     * @param int $reservation_id The reservation's ID
     * @return array|false Reservation data if found
     */
    public function getReservationById($reservation_id)
    {
        $sql = "SELECT r.*, t.name as table_name, t.capacity as table_capacity,
                       g.title as game_title
                FROM reservations r
                LEFT JOIN tables t ON r.table_id = t.id
                LEFT JOIN games g ON r.game_id = g.id
                WHERE r.id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$reservation_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get reservations by status
     * 
     * @param string $status Status to filter by ('pending', 'confirmed', 'canceled', 'completed')
     * @return array Reservations with that status
     */
    public function getReservationsByStatus($status)
    {
        $sql = "SELECT r.*, t.name as table_name, g.title as game_title
                FROM reservations r
                LEFT JOIN tables t ON r.table_id = t.id
                LEFT JOIN games g ON r.game_id = g.id
                WHERE r.status = ?
                ORDER BY r.date DESC, r.time DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get reservations for a specific user
     * 
     * @param int $user_id The user's ID
     * @return array User's reservations
     */
    public function getReservationsByUserId($user_id)
    {
        $sql = "SELECT r.*, t.name as table_name, t.capacity as table_capacity,
                       g.title as game_title
                FROM reservations r
                LEFT JOIN tables t ON r.table_id = t.id
                LEFT JOIN games g ON r.game_id = g.id
                WHERE r.users_id = ?
                ORDER BY r.date DESC, r.time DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Create a new reservation
     * 
     * @param array $data Reservation data from the form
     * @return int|bool The new reservation ID or false if failed
     */
    public function create($data)
    {
        $sql = "INSERT INTO reservations 
                (client_name, client_phone, table_id, game_id, date, time, players_count, status, users_id) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        $success = $stmt->execute([
            $data['client_name'],
            $data['client_phone'],
            $data['table_id'],
            $data['game_id'] ?? null,
            $data['date'],
            $data['time'],
            $data['players_count'],
            $data['status'] ?? 'pending',
            $data['user_id'] ?? null
        ]);
        
        if ($success) {
            return (int) $this->pdo->lastInsertId();
        }
        return false;
    }

    /**
     * Update an existing reservation
     * 
     * @param int   $reservation_id The reservation's ID
     * @param array $data           Updated data
     * @return bool True if update succeeded
     */
    public function update($reservation_id, $data)
    {
        $sql = "UPDATE reservations SET 
                client_name = ?, 
                client_phone = ?, 
                table_id = ?, 
                game_id = ?, 
                date = ?, 
                time = ?, 
                players_count = ?, 
                status = ? 
                WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $data['client_name'],
            $data['client_phone'],
            $data['table_id'],
            $data['game_id'] ?? null,
            $data['date'],
            $data['time'],
            $data['players_count'],
            $data['status'],
            $reservation_id
        ]);
    }

    /**
     * Update only the status of a reservation
     * 
     * @param int    $reservation_id The reservation's ID
     * @param string $status         New status
     * @return bool True if update succeeded
     */
    public function updateStatus($reservation_id, $status)
    {
        $sql = "UPDATE reservations SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $reservation_id]);
    }

    /**
     * Cancel a reservation
     * 
     * @param int $reservation_id The reservation's ID
     * @return bool True if cancellation succeeded
     */
    public function cancel($reservation_id)
    {
        return $this->updateStatus($reservation_id, 'canceled');
    }

    /**
     * Confirm a reservation
     * 
     * @param int $reservation_id The reservation's ID
     * @return bool True if confirmation succeeded
     */
    public function confirm($reservation_id)
    {
        return $this->updateStatus($reservation_id, 'confirmed');
    }

    /**
     * Delete a reservation
     * 
     * @param int $reservation_id The reservation's ID to delete
     * @return bool True if deletion succeeded
     */
    public function delete($reservation_id)
    {
        $sql = "DELETE FROM reservations WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$reservation_id]);
    }

    /**
     * Search reservations by client name or phone
     * 
     * @param string $query Search term
     * @return array Matching reservations
     */
    public function search($query)
    {
        $sql = "SELECT r.*, t.name as table_name, g.title as game_title
                FROM reservations r
                LEFT JOIN tables t ON r.table_id = t.id
                LEFT JOIN games g ON r.game_id = g.id
                WHERE r.client_name LIKE ? OR r.client_phone LIKE ?
                ORDER BY r.date DESC, r.time DESC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['%' . $query . '%', '%' . $query . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Count reservations by status
     * 
     * @param string $status Status to count
     * @return int Count
     */
    public function countByStatus($status)
    {
        $sql = "SELECT COUNT(*) FROM reservations WHERE status = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Count total reservations for a specific date
     * 
     * @param string $date Date to count
     * @return int Count
     */
    public function countByDate($date)
    {
        $sql = "SELECT COUNT(*) FROM reservations 
                WHERE date = ? AND status != 'canceled'";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$date]);
        return (int) $stmt->fetchColumn();
    }
}
