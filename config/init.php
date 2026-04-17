<?php
/**
 * Shared initialization script for direct-access PHP files.
 * Handles Composer autoloader, Database connection, and URL helpers.
 */

// Base URL for the application (change this when deploying)
define('URL_ROOT', '/dashboard/Aji_nl3bou');
define('SITE_NAME', 'Aji L3bo Café');

/**
 * Generate a URL with the base path
 * 
 * @param string $path The path to append to URL_ROOT
 * @return string The full URL
 */
function url(string $path = ''): string
{
    return URL_ROOT . '/' . ltrim($path, '/');
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
