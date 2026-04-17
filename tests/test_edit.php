<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/db.php';

$_SERVER['REQUEST_URI'] = '/dashboard/Aji_nl3bou/games/edit/1';
$_SERVER['REQUEST_METHOD'] = 'GET';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

use App\Controllers\RouterController;

$router = new RouterController();
$router->dispatch();
