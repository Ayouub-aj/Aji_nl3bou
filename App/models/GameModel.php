<?php
/**
 * GameModel - Handles all database operations for board games
 * 
 * This model communicates with the "games" table in the database.
 * It provides methods for CRUD operations on the game inventory.
 */

namespace App\Models;

class GameModel
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
     * Get ALL games from the database
     * 
     * @return array All games ordered by title
     */
    public function getAllGames()
    {
        $sql = "SELECT * FROM games ORDER BY title ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get a single game by its ID
     * 
     * @param int $game_id The game's ID
     * @return array|false Game data if found, false if not
     */
    public function getGameById($game_id)
    {
        $sql = "SELECT * FROM games WHERE id = ? LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$game_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Search games by title
     * 
     * @param string $query Search term
     * @return array Matching games
     */
    public function searchGames($query)
    {
        $sql = "SELECT * FROM games 
                WHERE title LIKE ? 
                ORDER BY title ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['%' . $query . '%']);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get games by category
     * 
     * @param string $category Category name (e.g., 'Strategy', 'Family')
     * @return array Games in that category
     */
    public function getGamesByCategory($category)
    {
        $sql = "SELECT * FROM games 
                WHERE category = ? 
                ORDER BY title ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$category]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get all unique categories
     * 
     * @return array List of categories
     */
    public function getCategories()
    {
        $sql = "SELECT DISTINCT category FROM games ORDER BY category ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }

    /**
     * Get available games (status = 'available')
     * 
     * @return array Available games
     */
    public function getAvailableGames()
    {
        $sql = "SELECT * FROM games 
                WHERE status = 'available' 
                ORDER BY title ASC";
        
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get games with search and filter options
     * 
     * @param string|null $search Search term (searches title and description)
     * @param string|null $category Filter by category
     * @param string|null $difficulty Filter by difficulty
     * @param int|null $players Filter by minimum players
     * @return array Filtered games
     */
    public function getFiltered($search = null, $category = null, $difficulty = null, $players = null)
    {
        $sql = "SELECT * FROM games WHERE 1=1";
        $params = [];
        
        // Only show available games
        $sql .= " AND status = 'available'";
        
        // Search filter
        if (!empty($search)) {
            $sql .= " AND (title LIKE ? OR description LIKE ?)";
            $params[] = '%' . $search . '%';
            $params[] = '%' . $search . '%';
        }
        
        // Category filter
        if (!empty($category) && $category !== 'all') {
            $sql .= " AND category = ?";
            $params[] = $category;
        }
        
        // Difficulty filter
        if (!empty($difficulty) && $difficulty !== 'all') {
            $sql .= " AND difficulty = ?";
            $params[] = $difficulty;
        }
        
        // Players filter (min_players <= requested players)
        if (!empty($players) && $players > 0) {
            $sql .= " AND min_players <= ?";
            $params[] = (int) $players;
        }
        
        $sql .= " ORDER BY title ASC";
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Create a new game
     * 
     * @param array $data Game data from the form
     * @return bool True if game was created successfully
     */
    public function create($data)
    {
        $sql = "INSERT INTO games 
                (title, category, description, min_players, max_players, duration, difficulty, status, image_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $data['title'],
            $data['category'],
            $data['description'] ?? '',
            $data['min_players'],
            $data['max_players'],
            $data['duration'],
            $data['difficulty'] ?? 'Moyen',
            $data['status'] ?? 'available',
            $data['image_url'] ?? null
        ]);
    }

    /**
     * Update an existing game
     * 
     * @param int   $game_id The game's ID
     * @param array $data   Updated game data
     * @return bool True if update succeeded
     */
    public function update($game_id, $data)
    {
        $sql = "UPDATE games SET 
                title = ?, 
                category = ?, 
                description = ?, 
                min_players = ?, 
                max_players = ?, 
                duration = ?, 
                difficulty = ?, 
                status = ?,
                image_url = ?
                WHERE id = ?";
        
        $stmt = $this->pdo->prepare($sql);
        
        return $stmt->execute([
            $data['title'],
            $data['category'],
            $data['description'] ?? '',
            $data['min_players'],
            $data['max_players'],
            $data['duration'],
            $data['difficulty'],
            $data['status'],
            $data['image_url'] ?? null,
            $game_id
        ]);
    }

    /**
     * Update only the game status
     * 
     * @param int    $game_id The game's ID
     * @param string $status  New status ('available', 'unavailable', 'maintenance')
     * @return bool True if update succeeded
     */
    public function updateStatus($game_id, $status)
    {
        $sql = "UPDATE games SET status = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$status, $game_id]);
    }

    /**
     * Delete a game
     * 
     * @param int $game_id The game's ID to delete
     * @return bool True if deletion succeeded
     */
    public function delete($game_id)
    {
        $sql = "DELETE FROM games WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$game_id]);
    }

    /**
     * Count total games
     * 
     * @return int Total game count
     */
    public function countGames()
    {
        $sql = "SELECT COUNT(*) FROM games";
        $stmt = $this->pdo->query($sql);
        return (int) $stmt->fetchColumn();
    }

    /**
     * Count games by status
     * 
     * @param string $status The status to count
     * @return int Count of games with that status
     */
    public function countByStatus($status)
    {
        $sql = "SELECT COUNT(*) FROM games WHERE status = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$status]);
        return (int) $stmt->fetchColumn();
    }
}
