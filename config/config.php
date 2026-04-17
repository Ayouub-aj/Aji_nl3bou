<?php
/**
 * Global Configuration
 * 
 * This file defines constants used throughout the application.
 */

// App Root - The root of the application on the filesystem
define('APPROOT', dirname(dirname(__FILE__)));

/**
 * URL Root - The base URL of the application
 * 
 * We detect this dynamically so it works on any server (XAMPP, production, etc.)
 * regardless of the folder name.
 */
$scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
$rootPath = str_replace('\\', '/', dirname($scriptName));
// Remove trailing slash if it exists
$urlRoot = rtrim($rootPath, '/');

define('URLROOT', $urlRoot);

// Site Name
define('SITENAME', 'Aji L3bo');

/**
 * Debugging Helper
 * Set to true to show detailed errors, false for production
 */
define('DEBUG_MODE', true);
