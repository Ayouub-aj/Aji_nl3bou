<?php

/**
 * Front Controller — single entry point for the application.
 * All HTTP requests are routed here via .htaccess.
 */

// ── Bootstrap ────────────────────────────────────────────────────────────────

require_once __DIR__ . '/config/init.php';

// Start session once
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Establish DB connection (available globally via Database::getInstance())
try {
    Database::getInstance()->getConnection();
} catch (Exception $e) {
    error_log('DB Error: ' . $e->getMessage());
    http_response_code(500);
    die('A technical error occurred. Please try again later.');
}

// ── Router ───────────────────────────────────────────────────────────────────

use App\Controllers\RouterController;

$router = new RouterController();

// ── Dispatch ─────────────────────────────────────────────────────────────────
$router->dispatch();
