<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/db.php';

$_SERVER['REQUEST_URI'] = '/games/edit/1'; // Relative path works with the new Router logic
$_SERVER['REQUEST_METHOD'] = 'GET';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Controllers\RouterController;

$router = new RouterController();
$router->dispatch();
