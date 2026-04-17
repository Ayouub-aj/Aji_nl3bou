<?php

namespace App\core;

/**
 * RouterController
 * 
 * This is the main router that handles URL routing.
 * It maps URLs to controller methods (actions).
 * 
 * How it works:
 * 1. When a URL is accessed, dispatch() is called
 * 2. It extracts the HTTP method (GET/POST) and the URL path
 * 3. It looks up the path in the routes array
 * 4. If found, it calls the corresponding controller action
 * 5. If not found, it shows a 404 error
 */

class RouterController
{
    /**
     * Routes array - maps URL paths to controller actions
     * 
     * Format: $routes['METHOD']['path'] = ['controller' => 'Name', 'action' => 'methodName']
     * 
     * @var array
     */
    private array $routes = [];

    /**
     * Constructor - Register all application routes
     */
    public function __construct()
    {
        $this->registerRoutes();
    }

    /**
     * Register all routes for the application
     * 
     * Routes are defined using HTTP method + path -> controller + action
     */
    private function registerRoutes(): void
    {
        // ============================================
        // PUBLIC ROUTES
        // ============================================
        
        // Home page
        $this->get('/', 'SessionsController', 'home');
        
        // Login page
        $this->get('/login', 'AuthController', 'login');
        $this->post('/login', 'AuthController', 'handleLogin');
        
        // Logout
        $this->get('/logout', 'AuthController', 'logout');
        
        // ============================================
        // ADMIN DASHBOARD ROUTES
        // ============================================
        
        // Admin dashboard
        $this->get('/dashboard/admin', 'SessionsController', 'adminDashboard');
        
        // Client dashboard
        $this->get('/dashboard/client', 'SessionsController', 'clientDashboard');
        
        // ============================================
        // GAME ROUTES
        // ============================================
        
        // Game inventory (admin)
        $this->get('/inventory', 'GamesController', 'inventory');
        
        // Add game form
        $this->get('/games/add', 'GamesController', 'create');
        $this->post('/games/add', 'GamesController', 'store');
        
        // Edit game
        $this->get('/games/edit/{id}', 'GamesController', 'edit');
        $this->post('/games/edit/{id}', 'GamesController', 'update');
        
        // Delete game
        $this->post('/games/delete/{id}', 'GamesController', 'delete');
        
        // ============================================
        // RESERVATION ROUTES
        // ============================================
        
        // Admin reservation list
        $this->get('/reservations', 'ReservationController', 'adminIndex');
        $this->get('/reservations/add', 'ReservationController', 'create');
        $this->post('/reservations/add', 'ReservationController', 'store');
        
        // Update reservation status
        $this->post('/reservations/status/{id}', 'ReservationController', 'updateStatus');
        
        // Cancel reservation
        $this->post('/reservations/cancel/{id}', 'ReservationController', 'cancel');
        
        // Confirm reservation
        $this->post('/reservations/confirm/{id}', 'ReservationController', 'confirm');
        
        // Delete reservation
        $this->post('/reservations/delete/{id}', 'ReservationController', 'delete');
        
        // ============================================
        // CLIENT BOOKING ROUTES
        // ============================================
        
        // Client booking page
        $this->get('/booking', 'ReservationController', 'clientBooking');
        $this->post('/booking', 'ReservationController', 'book');
        
        // ============================================
        // TABLE ROUTES
        // ============================================
        
        // List all tables
        $this->get('/tables', 'TableController', 'index');
        
        // Table details
        $this->get('/tables/{id}', 'TableController', 'show');
        
        // Available tables (for booking)
        $this->get('/tables/available', 'TableController', 'available');
        
        // Check table availability (AJAX)
        $this->get('/tables/check-availability/{id}', 'TableController', 'checkAvailability');
        
        // Get available tables (AJAX)
        $this->get('/tables/get-available', 'TableController', 'getAvailableTables');
        
        // Update table status
        $this->post('/tables/update-status/{id}', 'TableController', 'updateStatus');
        
        // ============================================
        // AUTHENTICATION ROUTES
        // ============================================
        
        // Add password page
        $this->get('/add-password', 'AuthController', 'addPassword');
        $this->post('/add-password', 'AuthController', 'handleAddPassword');
        
        // ============================================
        // API ROUTES (JSON responses)
        // ============================================
        
        // Get all games as JSON
        $this->get('/api/games', 'GamesController', 'getAll');
        
        // Get available tables as JSON
        $this->get('/api/tables/available', 'ReservationController', 'getAvailableTables');
        
        // Session management
        $this->get('/sessions/end/{id}', 'SessionsController', 'endSession');
    }

    /**
     * Register a GET route
     * 
     * @param string $path        URL path (e.g. '/login')
     * @param string $controller Controller class name (without namespace)
     * @param string $action     Method name on the controller
     */
    public function get(string $path, string $controller, string $action): void
    {
        $this->routes['GET'][$path] = [
            'controller' => $controller,
            'action'     => $action,
        ];
    }

    /**
     * Register a POST route
     * 
     * @param string $path        URL path (e.g. '/login')
     * @param string $controller Controller class name (without namespace)
     * @param string $action     Method name on the controller
     */
    public function post(string $path, string $controller, string $action): void
    {
        $this->routes['POST'][$path] = [
            'controller' => $controller,
            'action'     => $action,
        ];
    }

    /**
     * Dispatch the current HTTP request to the matching route
     * 
     * This is called from index.php to handle the request.
     * It:
     * 1. Gets the HTTP method and URL
     * 2. Removes the base path (for subdirectory installations)
     * 3. Looks up the route
     * 4. Calls the controller action
     */
    public function dispatch(): void
    {
        // Get the HTTP method (GET or POST)
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        
        // Get the URL path (remove query string)
        $uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');

        // Strip base path if application is in subdirectory
        $basePath = \URL_ROOT;
        if (!empty($basePath) && strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }
        
        // Default to home page if root
        if ($uri === '') {
            $uri = '/';
        }

        // Check if exact route exists
        if (isset($this->routes[$method][$uri])) {
            $this->executeRoute($this->routes[$method][$uri]);
            return;
        }

        // Try to match dynamic routes (e.g., /games/edit/1)
        foreach ($this->routes[$method] ?? [] as $pattern => $route) {
            $params = $this->matchRoute($uri, $pattern);
            if ($params !== false) {
                $this->executeRoute($route, $params);
                return;
            }
        }

        // No route found - show 404 error
        http_response_code(404);
        echo "<h1>404 — Page Not Found</h1>";
        echo "<p>The page you're looking for doesn't exist.</p>";
        echo "<p><a href='" . \URL_ROOT . "/'>Go to Home</a></p>";
    }

    /**
     * Match a URI against a route pattern
     * 
     * @param string $uri The request URI
     * @param string $pattern The route pattern (e.g., /games/edit/{id})
     * @return array|false The matched parameters or false
     */
    private function matchRoute(string $uri, string $pattern): array|false
    {
        // Convert route pattern to regex
        // {id} becomes (\d+), {slug} becomes ([a-zA-Z0-9-]+)
        $regex = preg_replace('/\{([a-zA-Z_]+)\}/', '([^/]+)', $pattern);
        $regex = '#^' . $regex . '$#';
        
        if (preg_match($regex, $uri, $matches)) {
            // Extract parameter names from pattern
            preg_match_all('/\{([a-zA-Z_]+)\}/', $pattern, $paramNames);
            $paramNames = $paramNames[1] ?? [];
            
            // Combine param names with matched values
            $params = [];
            foreach ($paramNames as $index => $name) {
                $params[$name] = $matches[$index + 1];
            }
            
            return $params;
        }
        
        return false;
    }

    /**
     * Execute a matched route
     * 
     * @param array $route The route configuration
     * @param array $params The matched parameters
     */
    private function executeRoute(array $route, array $params = []): void
    {
        $class = "App\\Controllers\\" . $route['controller'];
        $action = $route['action'];

        if (class_exists($class)) {
            $controller = new $class();
            
            // If we have parameters, pass them as positional arguments
            if (!empty($params)) {
                $controller->$action(...array_values($params));
            } else {
                $controller->$action();
            }
        }
    }
}
