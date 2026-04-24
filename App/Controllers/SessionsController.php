<?php
/**
 * SessionsController - Manages user sessions and dashboard pages
 * 
 * This controller handles:
 * - Session management (start, check login status)
 * - Dashboard pages (admin and client)
 * - Home/landing page
 * 
 * URL Routes:
 * - GET /              -> Home page
 * - GET /dashboard/admin  -> Admin dashboard
 * - GET /dashboard/client -> Client dashboard
 */

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\GameModel;
use App\Models\ReservationModel;
use App\Models\SessionModel;
use App\Models\TableModel;

class SessionsController extends BaseController
{
    // Models for dashboard statistics
    private $gameModel;
    private $reservationModel;
    private $sessionModel;
    private $tableModel;

    /**
     * Constructor - Initialize all models
     */
    public function __construct()
    {
        parent::__construct();
        
        // Initialize models for dashboard data
        $this->gameModel = $this->model('GameModel');
        $this->reservationModel = $this->model('ReservationModel');
        $this->sessionModel = $this->model('SessionModel');
        $this->tableModel = $this->model('TableModel');
        
        // Start session if not already started
        $this->startSession();
    }

    /**
     * Start the PHP session if not already started
     * 
     * This ensures we have an active session to store user data.
     * 
     * @return void
     */
    public function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Check if user is logged in
     * 
     * @return bool True if user is logged in
     */
    private function isLoggedIn(): bool
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    /**
     * Check if current user is admin
     * 
     * @return bool True if user is admin
     */
    private function isAdmin(): bool
    {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    /**
     * Show the public home/landing page
     * 
     * @return void
     */
    public function home(): void
    {
        // Get filter/search parameters from URL
        $search = isset($_GET['search']) ? trim($_GET['search']) : null;
        $category = isset($_GET['category']) ? trim($_GET['category']) : null;
        $difficulty = isset($_GET['difficulty']) ? trim($_GET['difficulty']) : null;
        $players = isset($_GET['players']) ? (int) $_GET['players'] : null;
        
        // Get filtered games
        if ($search || $category || $difficulty || $players) {
            $data['games'] = $this->gameModel->getFiltered($search, $category, $difficulty, $players);
        } else {
            $data['games'] = $this->gameModel->getAvailableGames();
        }
        
        // Get categories for filter dropdown
        $data['categories'] = $this->gameModel->getCategories();
        
        // Pass current filter values to view (for form persistence)
        $data['filters'] = [
            'search' => $search,
            'category' => $category,
            'difficulty' => $difficulty,
            'players' => $players
        ];
        
        // Show home page
        $this->view('pages/home', $data);
    }

    /**
     * Show the admin dashboard
     * 
     * This page shows statistics and overview for administrators.
     * 
     * @return void
     */
    /**
     * Show the admin session management page
     * 
     * @return void
     */
    public function index(): void
    {
        if (!$this->isLoggedIn() || !$this->isAdmin()) {
            header('Location: ' . \URL_ROOT . '/login');
            exit;
        }

        // Get all sessions (active and history)
        $data['activeSessions'] = $this->sessionModel->getActiveSessions();
        $data['allSessions'] = $this->sessionModel->getAllSessions();
        
        $data['stats'] = [
            'total' => count($data['allSessions']),
            'active' => count($data['activeSessions']),
            'today' => count($this->sessionModel->getSessionsByDate(date('Y-m-d')))
        ];

        $this->view('pages/sessions_admin', $data);
    }

    /**
     * Load admin dashboard view
     */
    public function adminDashboard(): void
    {
        // Check if user is logged in and is admin
        if (!$this->isLoggedIn()) {
            header('Location: ' . \URL_ROOT . '/login');
            exit;
        }
        
        if (!$this->isAdmin()) {
            // Non-admin users go to client dashboard
            header('Location: ' . \URL_ROOT . '/dashboard/client');
            exit;
        }
        
        // Get statistics for the dashboard
        $data['totalGames'] = $this->gameModel->countGames();
        $data['availableGames'] = $this->gameModel->countByStatus('available');
        $data['totalReservations'] = $this->reservationModel->countByStatus('confirmed') 
                                    + $this->reservationModel->countByStatus('pending');
        $data['activeSessions'] = $this->sessionModel->countActiveSessions();
        $data['totalTables'] = $this->tableModel->countTables();
        
        // Get today's reservations
        $data['todayReservations'] = $this->reservationModel->getReservationsByDate(date('Y-m-d'));
        
        // Get upcoming reservations (confirmed/pending, future dates)
        $data['upcomingReservations'] = $this->reservationModel->getUpcomingReservations(10);
        
        // Count upcoming
        $data['pendingCount'] = $this->reservationModel->countByStatus('pending');
        $data['totalToday'] = count($data['todayReservations']);
        
        // Get active sessions
        $data['activeSessionsList'] = $this->sessionModel->getActiveSessions();
        
        // Pass user info to view
        $data['user'] = [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? 'Admin',
            'role' => $_SESSION['role'] ?? 'admin'
        ];
        
        $this->view('pages/dashboard_admin', $data);
    }

    /**
     * Show the client dashboard
     * 
     * This page shows reservation history and quick booking for clients.
     * 
     * @return void
     */
    public function clientDashboard(): void
    {
        // Start session if needed
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            header('Location: ' . \URL_ROOT . '/login');
            exit;
        }
        
        // Get user's ID
        $user_id = $_SESSION['user_id'] ?? null;
        
        // Get user's reservations
        $data['reservations'] = $this->reservationModel->getReservationsByUserId($user_id);
        
        // Get user's session history
        $data['sessionHistory'] = $this->sessionModel->getSessionsByUserId($user_id);
        
        // Check if there's a pending reservation to highlight
        if (isset($_SESSION['pending_reservation_id'])) {
            $data['pending_reservation_id'] = $_SESSION['pending_reservation_id'];
            // Clear it from session (only show once)
            unset($_SESSION['pending_reservation_id']);
        }
        
        // Get recent games for quick booking
        $data['recentGames'] = $this->gameModel->getAvailableGames();
        
        // Pass user info
        $data['user'] = [
            'id' => $user_id,
            'username' => $_SESSION['username'] ?? 'Client',
            'role' => $_SESSION['role'] ?? 'client'
        ];
        
        // Show success message if new user
        if (isset($_SESSION['is_new_user'])) {
            $data['welcome_message'] = 'Welcome! Your account has been created. Please set a password to secure your account.';
            unset($_SESSION['is_new_user']);
        }
        
        // Load client dashboard view
        $this->view('pages/dashboard_client', $data);
    }

    /**
     * Redirect to the correct dashboard based on user role
     * 
     * This is called after login to send the user to the right place.
     * 
     * @return void
     */
    public function redirectToDashboard(): void
    {
        $this->startSession();
        
        if (!$this->isLoggedIn()) {
            header('Location: ' . \URL_ROOT . '/login');
            exit;
        }
        
        $role = $_SESSION['role'] ?? 'client';
        
        if ($role === 'admin') {
            $this->adminDashboard();
        } else {
            $this->clientDashboard();
        }
    }

    /**
     * Start a gaming session (check in)
     * 
     * Called when an admin confirms a reservation and starts a session.
     * 
     * @param int $reservation_id The reservation ID
     * @return void
     */
    public function startSessionForReservation($reservation_id): void
    {
        if (!$this->isAdmin()) {
            header('Location: ' . \URL_ROOT . '/login');
            exit;
        }
        
        // Get the reservation
        $reservation = $this->reservationModel->getReservationById($reservation_id);
        
        if ($reservation) {
            // Check if session already exists for this reservation
            $existingSession = $this->sessionModel->getSessionByReservation($reservation_id);
            if ($existingSession) {
                // If it already exists, just redirect without error
                $redirect = $_GET['redirect'] ?? 'dashboard/admin';
                header('Location: ' . \URL_ROOT . '/' . $redirect);
                exit;
            }

            // Get duration (default to 60, or take from game if exists)
            $duration = 60;
            if (!empty($reservation['game_id'])) {
                $game = $this->gameModel->getGameById($reservation['game_id']);
                if ($game && !empty($game['duration'])) {
                    $duration = $game['duration'];
                }
            }

            // Start the session
            if ($this->sessionModel->startSession($reservation_id, $reservation['table_id'], $duration, $reservation['game_id'])) {
                // Update reservation status to completed/active
                $this->reservationModel->updateStatus($reservation_id, 'confirmed');
                
                // Update table status to occupied
                $this->tableModel->updateTableStatus($reservation['table_id'], 'occupied');
            }
        }
        
        $redirect = $_GET['redirect'] ?? 'dashboard/admin';
        header('Location: ' . \URL_ROOT . '/' . $redirect);
        exit;
    }

    /**
     * End a gaming session (check out)
     * 
     * Called when admin ends a session.
     * 
     * @param int $session_id The session ID
     * @return void
     */
    public function endSession($session_id): void
    {
        if (!$this->isAdmin()) {
            header('Location: ' . \URL_ROOT . '/login');
            exit;
        }
        
        // Get the session
        $session = $this->sessionModel->getSessionById($session_id);
        
        if ($session) {
            // End the session
            $this->sessionModel->endSession($session_id);
            
            // Update table status back to available
            $this->tableModel->updateTableStatus($session['table_id'], 'available');
        }
        
        header('Location: ' . \URL_ROOT . '/dashboard/admin');
        exit;
    }
}
