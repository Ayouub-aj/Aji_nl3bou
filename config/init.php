<?php
/**
 * Shared initialization script for direct-access PHP files.
 * Handles Composer autoloader and Database connection.
 */

// Load Configuration
require_once __DIR__ . '/config.php';

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
