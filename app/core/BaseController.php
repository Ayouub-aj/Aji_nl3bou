<?php

namespace App\Core;

/**
 * Base Controller Class
 * 
 * Provides utility methods for all controllers, such as loading views
 * and models, ensuring a consistent structure across the application.
 */
abstract class BaseController
{
    /**
     * Load a model class
     * 
     * @param string $model Name of the model class
     * @return object Instance of the model
     */
    public function model(string $model)
    {
        $modelClass = "App\\Models\\" . $model;
        if (class_exists($modelClass)) {
            return new $modelClass();
        }
        die("Model $modelClass does not exist.");
    }

    /**
     * Load a view file and pass data to it
     * 
     * @param string $view Path to the view file (e.g., 'pages/home')
     * @param array $data Data to be extracted and made available in the view
     */
    public function view(string $view, array $data = [])
    {
        // Extract data to make variables available in the view context
        extract($data);

        $viewFile = __DIR__ . "/../../../views/" . $view . ".php";

        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            die("View $viewFile does not exist.");
        }
    }
}
