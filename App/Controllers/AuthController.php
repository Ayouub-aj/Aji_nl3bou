<?php
/**
 * AuthController - Handles authentication-related pages
 * 
 * This controller manages:
 * - Login page and form handling
 * - Password setup for new users
 * - Logout functionality
 * 
 * URL Routes:
 * - GET  /login         -> Show login page
 * - POST /login         -> Process login form
 * - GET  /logout       -> Logout and redirect
 * - GET  /add-password  -> Show password setup page
 * - POST /add-password  -> Process password setup
 */

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Security;
use App\Models\UserModel;

class AuthController extends BaseController
{
    // User model for database operations
    private $userModel;

    /**
     * Constructor - Initialize the model
     */
    public function __construct()
    {
        parent::__construct();
        $this->userModel = $this->model('UserModel');
        
        // Start session if not already started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Show the login page
     * 
     * @return void
     */
    public function login(): void
    {
        // If already logged in, redirect to dashboard
        if (isset($_SESSION['user_id'])) {
            $this->redirectBasedOnRole($_SESSION['role'] ?? 'client');
            return;
        }
        
        $this->view('auth/login');
    }

    /**
     * Handle login form submission
     * 
     * Validates credentials and creates a user session.
     * 
     * @return void
     */
    public function handleLogin(): void
    {
        // Only accept POST requests
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /dashboard/Aji_nl3bou/login');
            exit;
        }
        
        // Verify CSRF token for security
        if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $this->view('auth/login', ['error' => 'Invalid request. Please try again.']);
            return;
        }
        
        // Get form data
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        
        // Validate input
        if (empty($username) || empty($password)) {
            $this->view('auth/login', ['error' => 'Please enter both username and password.']);
            return;
        }
        
        // Find user by username or email
        $user = $this->userModel->findByUsernameOrEmail($username);
        
        if (!$user) {
            // User not found
            $this->view('auth/login', ['error' => 'Invalid credentials.']);
            return;
        }
        
        // Verify password
        if (!$this->userModel->verifyPassword($password, $user['password'])) {
            // Wrong password
            $this->view('auth/login', ['error' => 'Invalid credentials.']);
            return;
        }
        
        // Login successful - Create session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['logged_in'] = true;
        
        // Update last login time
        $this->userModel->updateLastLogin($user['id']);
        
        // Redirect based on role
        $this->redirectBasedOnRole($user['role']);
    }

    /**
     * Show the add-password page (for setting password for new account)
     * 
     * @return void
     */
    public function addPassword(): void
    {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /dashboard/Aji_nl3bou/login');
            exit;
        }
        
        $this->view('auth/add_password');
    }

    /**
     * Handle password setup form submission
     * 
     * @return void
     */
    public function handleAddPassword(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /dashboard/Aji_nl3bou/add-password');
            exit;
        }
        
        // Verify CSRF token
        if (!Security::validateCSRFToken($_POST['csrf_token'] ?? '')) {
            $this->view('auth/add_password', ['error' => 'Invalid request.']);
            return;
        }
        
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('Location: /dashboard/Aji_nl3bou/login');
            exit;
        }
        
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        // Validate passwords match
        if ($password !== $confirmPassword) {
            $this->view('auth/add_password', ['error' => 'Passwords do not match.']);
            return;
        }
        
        // Validate password strength (minimum 8 characters)
        if (strlen($password) < 8) {
            $this->view('auth/add_password', ['error' => 'Password must be at least 8 characters.']);
            return;
        }
        
        // Update password
        $success = $this->userModel->updatePassword($_SESSION['user_id'], $password);
        
        if ($success) {
            // Clear the is_new_user flag
            unset($_SESSION['is_new_user']);
            
            // Redirect to client dashboard
            header('Location: /dashboard/Aji_nl3bou/dashboard/client');
            exit;
        } else {
            $this->view('auth/add_password', ['error' => 'Failed to update password. Please try again.']);
        }
    }

    /**
     * Log the user out
     * 
     * Destroys the session and redirects to login page.
     * 
     * @return void
     */
    public function logout(): void
    {
        // Clear all session data
        $_SESSION = [];
        
        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        
        // Destroy the session
        session_destroy();
        
        // Redirect to login page
        header('Location: /dashboard/Aji_nl3bou/login');
        exit;
    }

    /**
     * Redirect user to appropriate dashboard based on their role
     * 
     * @param string $role The user's role ('admin' or 'client')
     * @return void
     */
    private function redirectBasedOnRole($role): void
    {
        if ($role === 'admin') {
            header('Location: /dashboard/Aji_nl3bou/dashboard/admin');
        } else {
            header('Location: /dashboard/Aji_nl3bou/dashboard/client');
        }
        exit;
    }
}
