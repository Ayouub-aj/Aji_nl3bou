<?php
/**
 * ReservationController - Handles HTTP requests for reservation pages
 * 
 * This controller manages:
 * - Admin reservation management
 * - Client booking page
 * - Table listing
 * 
 * URL Routes:
 * - GET  /reservations           -> Admin reservation list
 * - GET  /reservations/add      -> Add reservation form
 * - POST /reservations/add       -> Process reservation form
 * - GET  /booking               -> Client booking page
 * - POST /booking               -> Process client booking
 * - GET  /tables                -> List all tables
 */

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\ReservationModel;
use App\Models\TableModel;
use App\Models\GameModel;
use App\Models\UserModel;

class ReservationController extends BaseController
{
    private $reservationModel;
    private $tableModel;
    private $gameModel;
    private $userModel;

    public function __construct()
    {
        parent::__construct();
        
        $this->reservationModel = $this->model('ReservationModel');
        $this->tableModel = $this->model('TableModel');
        $this->gameModel = $this->model('GameModel');
        $this->userModel = $this->model('UserModel');
    }

    /**
     * Show client booking page
     * 
     * @return void
     */
    public function clientBooking(): void
    {
        // Get selected game if any
        $game_id = $_GET['game_id'] ?? null;
        
        // Get available games for selection
        $data['games'] = $this->gameModel->getAvailableGames();
        
        // If game selected, get game details
        if ($game_id) {
            $data['selectedGame'] = $this->gameModel->getGameById($game_id);
        }
        
        $this->view('pages/booking_client', $data);
    }

    /**
     * Handle client booking form submission
     * 
     * Flow:
     * 1. Validate form data
     * 2. Check if user exists by phone
     * 3. If user doesn't exist, create new user
     * 4. Create reservation
     * 5. If new user, redirect to add password page
     * 6. If existing user, log them in and go to client dashboard
     * 
     * @return void
     */
    public function book(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . \URLROOT . '/booking');
            exit;
        }
        
        // Get form data
        $client_name = trim($_POST['client_name'] ?? '');
        $client_phone = trim($_POST['client_phone'] ?? '');
        $date = trim($_POST['date'] ?? '');
        $time = trim($_POST['time'] ?? '');
        $players_count = (int) ($_POST['players_count'] ?? 4);
        $game_id = !empty($_POST['game_id']) ? (int) $_POST['game_id'] : null;
        
        // Basic validation
        if (empty($client_name) || empty($client_phone) || empty($date) || empty($time)) {
            $_SESSION['error'] = 'Please fill in all required fields.';
            header('Location: ' . \URLROOT . '/booking');
            exit;
        }
        
        // Find available table
        $availableTables = $this->tableModel->getAvailableTables($players_count, $date, $time);
        
        if (empty($availableTables)) {
            $_SESSION['error'] = 'No tables available for this time. Please try a different time or date.';
            header('Location: ' . \URLROOT . '/booking');
            exit;
        }
        
        // Use the first available table
        $table_id = $availableTables[0]['id'];
        
        // Check if user exists by phone
        $user = $this->userModel->findByPhone($client_phone);
        
        $is_new_user = false;
        
        if (!$user) {
            // Create new user
            $userData = [
                'username' => strtolower(str_replace(' ', '', $client_name)) . '_' . substr($client_phone, -4),
                'email' => 'user_' . time() . '@placeholder.com', // Temporary email
                'password' => bin2hex(random_bytes(8)), // Temporary random password
                'role' => 'client',
                'phone' => $client_phone
            ];
            
            if ($this->userModel->create($userData)) {
                $user = $this->userModel->findByPhone($client_phone);
                $is_new_user = true;
            }
        }
        
        // Create reservation
        $reservationData = [
            'client_name' => $client_name,
            'client_phone' => $client_phone,
            'table_id' => $table_id,
            'game_id' => $game_id,
            'date' => $date,
            'time' => $time,
            'players_count' => $players_count,
            'status' => 'pending',
            'user_id' => $user['id'] ?? null
        ];
        
        $reservation_id = $this->reservationModel->create($reservationData);
        
        if (!$reservation_id) {
            $_SESSION['error'] = 'Failed to create reservation. Please try again.';
            header('Location: ' . \URLROOT . '/booking');
            exit;
        }
        
        // Start session
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($is_new_user) {
            // New user - redirect to set password
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            $_SESSION['pending_reservation_id'] = $reservation_id;
            $_SESSION['is_new_user'] = true;
            
            header('Location: ' . \URLROOT . '/add-password');
            exit;
        } else {
            // Existing user - log them in and go to dashboard
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['logged_in'] = true;
            $_SESSION['pending_reservation_id'] = $reservation_id;
            
            header('Location: ' . \URLROOT . '/dashboard/client');
            exit;
        }
    }

    /**
     * Show admin reservation list
     */
    public function adminIndex(): void
    {
        $searchQuery = $_GET['query'] ?? '';
        
        if (!empty($searchQuery)) {
            $data['reservations'] = $this->reservationModel->search($searchQuery);
            $data['searchQuery'] = $searchQuery;
        } else {
            $data['reservations'] = $this->reservationModel->getAllReservations();
        }
        
        $data['totalToday'] = $this->reservationModel->countByDate(date('Y-m-d'));
        $data['confirmedCount'] = $this->reservationModel->countByStatus('confirmed');
        $data['pendingCount'] = $this->reservationModel->countByStatus('pending');
        
        $this->view('pages/reservation_admin', $data);
    }

    /**
     * Show add reservation form (admin)
     */
    public function create(): void
    {
        $data['tables'] = $this->tableModel->getAllTables();
        $data['games'] = $this->gameModel->getAllGames();
        
        $this->view('pages/add_reservation', $data);
    }

    /**
     * Handle add reservation form submission (admin)
     */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . \URLROOT . '/reservations/add');
            exit;
        }
        
        $data = [
            'client_name' => trim($_POST['client_name'] ?? ''),
            'client_phone' => trim($_POST['client_phone'] ?? ''),
            'table_id' => (int) ($_POST['table_id'] ?? 0),
            'game_id' => !empty($_POST['game_id']) ? (int) $_POST['game_id'] : null,
            'date' => trim($_POST['date'] ?? ''),
            'time' => trim($_POST['time'] ?? ''),
            'players_count' => (int) ($_POST['players_count'] ?? 4),
            'status' => 'pending'
        ];
        
        if (empty($data['client_name']) || empty($data['date']) || empty($data['time'])) {
            $data['tables'] = $this->tableModel->getAllTables();
            $data['games'] = $this->gameModel->getAllGames();
            $data['error'] = 'Name, date, and time are required';
            $this->view('pages/add_reservation', $data);
            return;
        }
        
        $success = $this->reservationModel->create($data);
        
        if ($success) {
            header('Location: ' . \URLROOT . '/reservations?success=added');
            exit;
        } else {
            $data['tables'] = $this->tableModel->getAllTables();
            $data['games'] = $this->gameModel->getAllGames();
            $data['error'] = 'Failed to create reservation';
            $this->view('pages/add_reservation', $data);
        }
    }

    /**
     * Update reservation status
     */
    public function updateStatus($reservation_id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit;
        }
        
        $status = $_POST['status'] ?? '';
        $this->reservationModel->updateStatus($reservation_id, $status);
        
        header('Location: ' . \URLROOT . '/reservations');
        exit;
    }

    /**
     * Cancel a reservation
     */
    public function cancel($reservation_id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit;
        }
        
        $this->reservationModel->cancel($reservation_id);
        
        header('Location: ' . \URLROOT . '/reservations');
        exit;
    }

    /**
     * Confirm a reservation
     */
    public function confirm($reservation_id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit;
        }
        
        $this->reservationModel->confirm($reservation_id);
        
        header('Location: ' . \URLROOT . '/reservations');
        exit;
    }

    /**
     * Delete a reservation
     */
    public function delete($reservation_id): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            exit;
        }
        
        $this->reservationModel->delete($reservation_id);
        
        header('Location: ' . \URLROOT . '/reservations');
        exit;
    }

    /**
     * Show table list page
     */
    public function listTables(): void
    {
        $data['tables'] = $this->tableModel->getAllTables();
        $data['totalTables'] = $this->tableModel->countTables();
        
        $this->view('pages/list_tables', $data);
    }

    /**
     * Get available tables for AJAX
     */
    public function getAvailableTables(): void
    {
        $players = (int) ($_GET['players'] ?? 4);
        $date = $_GET['date'] ?? date('Y-m-d');
        $time = $_GET['time'] ?? '19:00';
        
        $tables = $this->tableModel->getAvailableTables($players, $date, $time);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'tables' => $tables,
            'count' => count($tables)
        ]);
        exit;
    }
}
