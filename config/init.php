<?php
/**
 * Shared initialization script for direct-access PHP files.
 * Handles Composer autoloader, Database connection, and URL helpers.
 * 
 * URL_ROOT is automatically detected from the server environment.
 * No configuration needed - works on any machine!
 * 
 * To override for your local setup:
 * 1. Copy config/config.local.example.php to config/config.local.php
 * 2. Uncomment and set your custom URL_ROOT
 */

// Load local config overrides (create config.local.php to customize)
$localConfig = __DIR__ . '/config.php';
if (file_exists($localConfig)) {
    require_once $localConfig;
}

// Only auto-detect if URL_ROOT is not already defined
if (!defined('URL_ROOT')) {
    // Auto-detect base path from SCRIPT_NAME
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/index.php';
    
    // Extract the folder path from SCRIPT_NAME
    $pathInfo = pathinfo($scriptName);
    $basePath = $pathInfo['dirname'] ?? '/';
    
    // Normalize: remove /index.php if present
    $basePath = preg_replace('#/index\.php$#', '', $basePath);
    
    // Normalize: remove /public if present
    $basePath = preg_replace('#/public$#', '', $basePath);
    
    // Ensure it starts with / and doesn't end with /
    $basePath = '/' . ltrim($basePath, '/');
    $basePath = rtrim($basePath, '/');
    
    define('URL_ROOT', $basePath);
}

if (!defined('SITE_NAME')) {
    define('SITE_NAME', 'Aji L3bo Café');
}

/**
 * Generate a URL with the base path
 * 
 * @param string $path The path to append to URL_ROOT
 * @return string The full URL
 */
function url(string $path = ''): string
{
    $base = defined('URL_ROOT') ? URL_ROOT : '';
    return $base . '/' . ltrim($path, '/');
}

/**
 * Redirect to a URL
 * 
 * @param string $path The path to redirect to
 */
function redirect(string $path = ''): void
{
    header('Location: ' . url($path));
    exit;
}

// Load Composer autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load Database configuration
require_once __DIR__ . '/db.php';

// Initialize Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Global Database connection available to all pages
try {
    $pdo = Database::getInstance()->getConnection();
} catch (Exception $e) {
    error_log("Initialization Error: " . $e->getMessage());
    die("A technical error occurred. Please try again later.");
}
