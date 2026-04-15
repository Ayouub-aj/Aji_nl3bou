<?php

namespace Models;

use PDO;
use PDOException;

class Session
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    /**
     * Start a new session for a confirmed reservation
     */
    public function startSession(int $reservationId, int $gameId, int $tableId): int|false
    {
        try {
            $this->db->beginTransaction();

            // Insert new active session
            $stmt = $this->db->prepare("
                INSERT INTO sessions (start_time, end_time, status, reservation_id, game_id, table_id)
                VALUES (NOW(), NULL, 'active', :reservation_id, :game_id, :table_id)
            ");
            $stmt->execute([
                ':reservation_id' => $reservationId,
                ':game_id'        => $gameId,
                ':table_id'       => $tableId,
            ]);
            $sessionId = (int) $this->db->lastInsertId();

            // Mark the table as occupied
            $stmt = $this->db->prepare("
                UPDATE tables SET status = 'occupied' WHERE id = :table_id
            ");
            $stmt->execute([':table_id' => $tableId]);

            // Mark the reservation as confirmed
            $stmt = $this->db->prepare("
                UPDATE reservations SET status = 'confirmed' WHERE id = :reservation_id
            ");
            $stmt->execute([':reservation_id' => $reservationId]);

            $this->db->commit();
            return $sessionId;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('Session::startSession error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * End an active session and free the table
     */
    public function endSession(int $sessionId): bool
    {
        try {
            $this->db->beginTransaction();

            // Get table_id before closing
            $stmt = $this->db->prepare("
                SELECT table_id FROM sessions WHERE id = :id AND status = 'active'
            ");
            $stmt->execute([':id' => $sessionId]);
            $session = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$session) {
                $this->db->rollBack();
                return false;
            }

            // Close the session
            $stmt = $this->db->prepare("
                UPDATE sessions
                SET status = 'finished', end_time = NOW()
                WHERE id = :id
            ");
            $stmt->execute([':id' => $sessionId]);

            // Free the table
            $stmt = $this->db->prepare("
                UPDATE tables SET status = 'free' WHERE id = :table_id
            ");
            $stmt->execute([':table_id' => $session['table_id']]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log('Session::endSession error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all active sessions with related info
     */
    public function getActiveSessions(): array
    {
        $stmt = $this->db->query("
            SELECT
                s.id,
                s.start_time,
                s.status,
                t.number  AS table_number,
                t.capacity,
                g.title   AS game_title,
                g.category,
                g.difficulty,
                u.username,
                r.players_count,
                r.client_phone,
                TIMESTAMPDIFF(MINUTE, s.start_time, NOW()) AS elapsed_minutes
            FROM sessions s
            JOIN tables       t ON s.table_id       = t.id
            JOIN games        g ON s.game_id        = g.id
            JOIN reservations r ON s.reservation_id = r.id
            JOIN users        u ON r.users_id       = u.id
            WHERE s.status = 'active'
            ORDER BY s.start_time ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get a single session by ID
     */
    public function getSessionById(int $id): array|false
    {
        $stmt = $this->db->prepare("
            SELECT
                s.*,
                t.number  AS table_number,
                g.title   AS game_title,
                g.duration AS game_duration,
                u.username,
                r.players_count,
                r.client_phone
            FROM sessions s
            JOIN tables       t ON s.table_id       = t.id
            JOIN games        g ON s.game_id        = g.id
            JOIN reservations r ON s.reservation_id = r.id
            JOIN users        u ON r.users_id       = u.id
            WHERE s.id = :id
        ");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get confirmed reservations that have no active session yet
     */
    public function getPendingReservations(): array
    {
        $stmt = $this->db->query("
            SELECT
                r.id,
                r.date,
                r.time,
                r.players_count,
                r.client_phone,
                r.status,
                t.id     AS table_id,
                t.number AS table_number,
                u.username
            FROM reservations r
            JOIN tables t ON r.table_id = t.id
            JOIN users  u ON r.users_id = u.id
            WHERE r.status IN ('pending', 'confirmed')
              AND r.id NOT IN (
                  SELECT reservation_id FROM sessions WHERE status = 'active'
              )
            ORDER BY r.date ASC, r.time ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get available games (status = available)
     */
    public function getAvailableGames(): array
    {
        $stmt = $this->db->query("
            SELECT id, title, category, difficulty, min_players, max_players, duration
            FROM games
            WHERE status = 'available'
            ORDER BY title ASC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get all finished sessions (history)
     */
    public function getHistory(): array
    {
        $stmt = $this->db->query("
            SELECT
                s.id,
                s.start_time,
                s.end_time,
                s.status,
                t.number AS table_number,
                g.title AS game_title,
                g.category,
                u.username,
                r.players_count,
                TIMESTAMPDIFF(MINUTE, s.start_time, s.end_time) AS duration_minutes
            FROM sessions s
            JOIN tables t ON s.table_id = t.id
            JOIN games g ON s.game_id = g.id
            JOIN reservations r ON s.reservation_id = r.id
            JOIN users u ON r.users_id = u.id
            WHERE s.status = 'finished'
            ORDER BY s.end_time DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}