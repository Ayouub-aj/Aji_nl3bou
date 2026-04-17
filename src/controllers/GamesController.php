<?php
/**
 * GamesController - Handles HTTP requests for game-related pages
 * 
 * This controller manages all the pages that show game information.
 * It uses the GameModel to get data from the database.
 * 
 * URL Routes:
 * - GET  /inventory     -> Show all games (admin)
 * - GET  /games/add     -> Show add game form
 * - POST /games/add     -> Process add game form
 * - GET  /games/:id     -> Show single game details
 */

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\GameModel;

class GamesController extends BaseController
{
    // The model for game data operations
    private $gameModel;

    /**
     * Constructor - Initialize the model
     */
    public function __construct()
    {
        parent::__construct();
        $this->gameModel = $this->model('GameModel');
    }

    /**
     * Handle image upload
     * 
     * @return string|false The image URL or false if no image
     */
    private function handleImageUpload()
    {
        // Check if file was uploaded
        if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            return false;
        }
        
        $file = $_FILES['image'];
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime_type = finfo_file($finfo, $file['tmp_name']);
        finfo_close($finfo);
        
        if (!in_array($mime_type, $allowed_types)) {
            return false;
        }
        
        // Validate file size (max 10MB)
        if ($file['size'] > 10 * 1024 * 1024) {
            return false;
        }
        
        // Create upload directory if not exists
        $upload_dir = __DIR__ . '/../../public/uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        // Generate unique filename
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $filename = uniqid('game_') . '_' . time() . '.' . $extension;
        $destination = $upload_dir . $filename;
        
        // Move uploaded file
        if (move_uploaded_file($file['tmp_name'], $destination)) {
            // Return the public URL path
            return '/dashboard/Aji_nl3bou/public/uploads/' . $filename;
        }
        
        return false;
    }

    /**
     * Show all games (inventory page)
     * 
     * This shows the admin inventory page with all games.
     * 
     * @return void
     */
    public function inventory(): void
    {
        // Check for search query in URL
        $searchQuery = $_GET['query'] ?? '';
        
        if (!empty($searchQuery)) {
            // Search for games
            $data['games'] = $this->gameModel->searchGames($searchQuery);
            $data['searchQuery'] = $searchQuery;
        } else {
            // Get all games
            $data['games'] = $this->gameModel->getAllGames();
        }
        
        // Get statistics
        $data['totalGames'] = $this->gameModel->countGames();
        $data['availableGames'] = $this->gameModel->countByStatus('available');
        
        // Load the view
        $this->view('pages/inventory', $data);
    }

    /**
     * Show single game details
     * 
     * @param int $game_id The ID of the game to show
     * @return void
     */
    public function show($game_id): void
    {
        // Get the specific game
        $data['game'] = $this->gameModel->getGameById($game_id);
        
        // If game doesn't exist, show error
        if (!$data['game']) {
            die("Game not found");
        }
        
        $this->view('pages/game_details', $data);
    }

    /**
     * Show the add-game form
     * 
     * @return void
     */
    public function create(): void
    {
        // Get categories for the dropdown
        $data['categories'] = $this->gameModel->getCategories();
        
        $this->view('pages/add_game', $data);
    }

    /**
     * Handle add-game form submission
     * 
     * This is called when the form on add_game.php is submitted.
     * It validates the data and saves it to the database.
     * 
     * @return void
     */
    public function store(): void
    {
        // Only accept POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /dashboard/Aji_nl3bou/games/add');
            exit;
        }
        
        // Get form data
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'min_players' => (int) ($_POST['min_players'] ?? 1),
            'max_players' => (int) ($_POST['max_players'] ?? 5),
            'duration' => (int) ($_POST['duration'] ?? 60),
            'difficulty' => trim($_POST['difficulty'] ?? 'Moyen'),
            'status' => trim($_POST['status'] ?? 'available')
        ];
        
        // Handle image upload
        $image_url = $this->handleImageUpload();
        if ($image_url) {
            $data['image_url'] = $image_url;
        }
        
        // Basic validation
        if (empty($data['title']) || empty($data['category'])) {
            // Reload form with error
            $data['categories'] = $this->gameModel->getCategories();
            $data['error'] = 'Title and Category are required';
            $this->view('pages/add_game', $data);
            return;
        }
        
        // Create the game in database
        $success = $this->gameModel->create($data);
        
        if ($success) {
            // Redirect to inventory page on success
            header('Location: /dashboard/Aji_nl3bou/inventory?success=added');
            exit;
        } else {
            // Show error
            $data['categories'] = $this->gameModel->getCategories();
            $data['error'] = 'Failed to add game. Please try again.';
            $this->view('pages/add_game', $data);
        }
    }

    /**
     * Show edit game form
     * 
     * @param int $game_id The ID of the game to edit
     * @return void
     */
    public function edit($game_id): void
    {
        $data['game'] = $this->gameModel->getGameById($game_id);
        $data['categories'] = $this->gameModel->getCategories();
        
        if (!$data['game']) {
            die("Game not found");
        }
        
        $this->view('pages/edit_game', $data);
    }

    /**
     * Handle edit game form submission
     * 
     * @param int $game_id The ID of the game to update
     * @return void
     */
    public function update($game_id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /dashboard/Aji_nl3bou/games/edit/' . $game_id);
            exit;
        }
        
        // Get current game data first
        $currentGame = $this->gameModel->getGameById($game_id);
        
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'min_players' => (int) ($_POST['min_players'] ?? 1),
            'max_players' => (int) ($_POST['max_players'] ?? 5),
            'duration' => (int) ($_POST['duration'] ?? 60),
            'difficulty' => trim($_POST['difficulty'] ?? 'Moyen'),
            'status' => trim($_POST['status'] ?? 'available')
        ];
        
        // Handle image upload
        $image_url = $this->handleImageUpload();
        if ($image_url) {
            $data['image_url'] = $image_url;
        } else {
            // Keep existing image
            $data['image_url'] = $currentGame['image_url'] ?? null;
        }
        
        $success = $this->gameModel->update($game_id, $data);
        
        if ($success) {
            header('Location: /dashboard/Aji_nl3bou/inventory?success=updated');
            exit;
        } else {
            $data['error'] = 'Failed to update game';
            $data['categories'] = $this->gameModel->getCategories();
            $data['game'] = $currentGame;
            $this->view('pages/edit_game', $data);
        }
    }

    /**
     * Delete a game
     * 
     * @param int $game_id The ID of the game to delete
     * @return void
     */
    public function delete($game_id): void
    {
        // Only allow POST requests for deletion
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /dashboard/Aji_nl3bou/inventory');
            exit;
        }
        
        // Verify CSRF token
        if (!\App\Core\Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            header('Location: /dashboard/Aji_nl3bou/inventory?error=invalid_token');
            exit;
        }
        
        $success = $this->gameModel->delete($game_id);
        
        header('Location: /dashboard/Aji_nl3bou/inventory?success=deleted');
        exit;
    }

    /**
     * Update game status (quick action)
     * 
     * @param int $game_id The ID of the game
     * @return void
     */
    public function updateStatus($game_id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit;
        }
        
        $status = $_POST['status'] ?? 'available';
        $this->gameModel->updateStatus($game_id, $status);
        
        header('Location: /dashboard/Aji_nl3bou/inventory');
        exit;
    }

    /**
     * Get all games as JSON (for AJAX)
     * 
     * @return void Outputs JSON
     */
    public function getAll(): void
    {
        $games = $this->gameModel->getAllGames();
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'games' => $games]);
        exit;
    }
}
