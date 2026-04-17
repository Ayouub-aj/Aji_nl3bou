<?php
/**
 * SessionModel - Handles all database operations for gaming sessions
 * 
 * This model communicates with the "sessions" table in the database.
 * It provides methods for managing active gaming sessions.
 * 
 * A "session" represents a period when a table is being used for gaming.
 */

namespace App\Models;

class SessionModel
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
     * Get ALL sessions
     * 
     * @return array All sessions with related info
     */
    public function getAllSessions()
    {
        $sql = "SELECT s.*, 
                       t.name as table_name, t.capacity as table_capacity,
                       r.client_name, r.players_count
                FROM sessions s
                LEFT JOIN tables t ON s.table_id = t.id
                LEFT JOIN reservations r ON s.reservation_id = r.id
                ORDER BY s.start_time DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get active sessions (not yet finished)
     * 
     * @return array Active sessions
     */
    public function getActiveSessions()
    {
        $sql = "SELECT s.*, 
                       t.name as table_name, t.capacity as table_capacity,
                       r.client_name, r.players_count
                FROM sessions s
                LEFT JOIN tables t ON s.table_id = t.id
                LEFT JOIN reservations r ON s.reservation_id = r.id
                WHERE s.status = 'active'
                ORDER BY s.start_time DESC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get a single session by ID
     * 
     * @param int $session_id The session's ID
     * @return array|false Session data if found
     */
    public function getSessionById($session_id)
    {
        $sql = "SELECT s.*, t.name as table_name, r.client_name
                FROM sessions s
                LEFT JOIN tables t ON s.table_id = t.id
                LEFT JOIN reservations r ON s.reservation_id = r.id
                WHERE s.id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$session_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Get session by reservation ID
     * 
     * @param int $reservation_id The reservation's ID
     * @return array|false Session data if found
     */
    public function getSessionByReservation($reservation_id)
    {
        $sql = "SELECT s.*, t.name as table_name
                FROM sessions s
                LEFT JOIN tables t ON s.table_id = t.id
                WHERE s.reservation_id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$reservation_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Start a new session (when guests check in)
     * 
     * @param int $reservation_id The reservation ID to start session for
     * @param int $table_id       The table ID being used
     * @return bool True if session was created
     */
    public function startSession($reservation_id, $table_id)
    {
        $sql = "INSERT INTO sessions (reservation_id, table_id, start_time, status) 
                VALUES (?, ?, NOW(), 'active')";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$reservation_id, $table_id]);
    }

    /**
     * End an active session
     * 
     * @param int $session_id The session's ID
     * @return bool True if session was ended
     */
    public function endSession($session_id)
    {
        $sql = "UPDATE sessions SET 
                end_time = NOW(), 
                status = 'finished' 
                WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$session_id]);
    }

    /**
     * Update session notes
     * 
     * @param int    $session_id The session's ID
     * @param string $notes      Notes to add
     * @return bool True if update succeeded
     */
    public function updateNotes($session_id, $notes)
    {
        $sql = "UPDATE sessions SET notes = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$notes, $session_id]);
    }

    /**
     * Get sessions for a specific date
     * 
     * @param string $date Date in YYYY-MM-DD format
     * @return array Sessions for that date
     */
    public function getSessionsByDate($date)
    {
        $sql = "SELECT s.*, t.name as table_name, r.client_name
                FROM sessions s
                LEFT JOIN tables t ON s.table_id = t.id
                LEFT JOIN reservations r ON s.reservation_id = r.id
                WHERE DATE(s.start_time) = ?
                ORDER BY s.start_time ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$date]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Check if a table has an active session
     * 
     * @param int $table_id The table's ID
     * @return bool True if table is currently in use
     */
    public function isTableInUse($table_id)
    {
        $sql = "SELECT COUNT(*) FROM sessions 
                WHERE table_id = ? AND status = 'active'";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$table_id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    /**
     * Count active sessions
     * 
     * @return int Number of active sessions
     */
    public function countActiveSessions()
    {
        $sql = "SELECT COUNT(*) FROM sessions WHERE status = 'active'";
        $stmt = $this->pdo->query($sql);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Get session duration in minutes
     * 
     * @param int $session_id The session's ID
     * @return int Duration in minutes, or 0 if session is still active
     */
    public function getSessionDuration($session_id)
    {
        $sql = "SELECT TIMESTAMPDIFF(MINUTE, start_time, 
                COALESCE(end_time, NOW())) as duration
                FROM sessions WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$session_id]);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Delete a session
     * 
     * @param int $session_id The session's ID to delete
     * @return bool True if deletion succeeded
     */
    public function delete($session_id)
    {
        $sql = "DELETE FROM sessions WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$session_id]);
    }
}
