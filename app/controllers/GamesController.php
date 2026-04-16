<?php

namespace App\Controllers;

use App\Core\BaseController;

/**
 * Games Controller
 * 
 * Handles routing for game-related pages and actions.
 */
class GamesController extends BaseController
{
    /**
     * Default method for GamesController
     * Maps to: yoursite.com/games/index or yoursite.com/games/list
     */
    public function index()
    {
        // For testing purposes, we'll just echo a confirmation
        // In a real scenario, this would load a view: $this->view('games/index', ['title' => 'Games List']);
        echo "GamesController: index method called successfully.";
    }

    /**
     * Test method to verify parameter passing
     * Maps to: yoursite.com/games/show/1
     */
    public function show($id = null)
    {
        if ($id) {
            echo "GamesController: show method called with ID: " . htmlspecialchars($id);
        } else {
            echo "GamesController: show method called without ID.";
        }
    }
}
