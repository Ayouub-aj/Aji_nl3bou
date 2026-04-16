<?php

namespace App\Core;

/**
 * Router Class
 * 
 * Handles URL parsing and dispatches the request to the appropriate
 * controller and method based on the 'url' parameter.
 */
class Router
{
    protected $currentController = 'GamesController';
    protected $currentMethod = 'index';
    protected $params = [];

    public function __construct()
    {
        $url = $this->getUrl();

        // 1. Look in controllers for first value
        if (isset($url[0])) {
            $controllerName = ucwords($url[0]) . 'Controller';
            if (file_exists(__DIR__ . '/../controllers/' . $controllerName . '.php')) {
                $this->currentController = $controllerName;
                unset($url[0]);
            }
        }

        // Require the controller
        $fullControllerPath = "App\\Controllers\\" . $this->currentController;
        
        // Instantiate controller class
        $this->currentController = new $fullControllerPath;

        // 2. Check for second part of url (method)
        if (isset($url[1])) {
            if (method_exists($this->currentController, $url[1])) {
                $this->currentMethod = $url[1];
                unset($url[1]);
            }
        }

        // 3. Get params
        $this->params = $url ? array_values($url) : [];

        // 4. Call method with params
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * Parse the URL from the 'url' GET parameter
     * 
     * @return array|null Exploded URL parts
     */
    public function getUrl(): ?array
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return null;
    }
}
