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
        // Get featured games for the homepage
        $data['featuredGames'] = $this->gameModel->getAvailableGames();
        
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
    public function adminDashboard(): void
    {
        // Check if user is logged in and is admin
        if (!$this->isLoggedIn()) {
            header('Location: ' . \URLROOT . '/login');
            exit;
        }
        
        if (!$this->isAdmin()) {
            // Non-admin users go to client dashboard
            header('Location: ' . \URLROOT . '/dashboard/client');
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
        
        // Get active sessions
        $data['activeSessionsList'] = $this->sessionModel->getActiveSessions();
        
        // Pass user info to view
        $data['user'] = [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? 'Admin',
            'role' => $_SESSION['role'] ?? 'admin'
        ];
        
        // Load admin dashboard view
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
            header('Location: ' . \URLROOT . '/login');
            exit;
        }
        
        // Get user's ID
        $user_id = $_SESSION['user_id'] ?? null;
        
        // Get user's reservations
        $data['reservations'] = $this->reservationModel->getReservationsByUserId($user_id);
        
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
            header('Location: ' . \URLROOT . '/login');
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
            header('Location: ' . \URLROOT . '/login');
            exit;
        }
        
        // Get the reservation
        $reservation = $this->reservationModel->getReservationById($reservation_id);
        
        if ($reservation) {
            // Start the session
            $this->sessionModel->startSession($reservation_id, $reservation['table_id']);
            
            // Update reservation status to confirmed/active
            $this->reservationModel->updateStatus($reservation_id, 'confirmed');
            
            // Update table status to occupied
            $this->tableModel->updateTableStatus($reservation['table_id'], 'occupied');
        }
        
        header('Location: ' . \URLROOT . '/dashboard/admin');
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
            header('Location: ' . \URLROOT . '/login');
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
        
        header('Location: ' . \URLROOT . '/dashboard/admin');
        exit;
    }
}
