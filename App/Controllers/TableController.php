<?php
/**
 * TableController - Handles HTTP requests for table-related pages
 * 
 * This controller manages all the pages that show table information.
 * It uses the TableModel to get data from the database.
 * 
 * URL Routes:
 * - GET  /tables        -> Show all tables
 * - GET  /tables/:id    -> Show single table details
 */

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\TableModel;

class TableController extends BaseController
{
    // The model for table data operations
    private $tableModel;

    /**
     * Constructor - Initialize the model
     * 
     * This runs when the controller is first created.
     * We create an instance of TableModel to access table data.
     */
    public function __construct()
    {
        // Call parent constructor (BaseController)
        parent::__construct();
        
        // Create the model instance
        $this->tableModel = $this->model('TableModel');
    }

    /**
     * Show all tables (index page)
     * 
     * This is the main tables page showing all available tables.
     * 
     * @return void This method renders a view (doesn't return anything)
     */
    public function index()
    {
        // Get all tables from the database
        $data['tables'] = $this->tableModel->getAllTables();
        
        // Get statistics
        $data['totalTables'] = $this->tableModel->countTables();
        
        // Load the view and pass the data to it
        // The view file is: views/pages/list_tables.php
        $this->view('pages/list_tables', $data);
    }

    /**
     * Show details of a single table
     * 
     * @param int $table_id The ID of the table to show
     * @return void
     */
    public function show($table_id)
    {
        // Get the specific table
        $data['table'] = $this->tableModel->getTableById($table_id);
        
        // If table doesn't exist, show error
        if (!$data['table']) {
            // Could redirect to error page or show 404
            die("Table not found");
        }
        
        // Load the view
        $this->view('pages/table_details', $data);
    }

    /**
     * Show available tables for a given date, time, and player count
     * 
     * This is used when a client is making a booking and needs
     * to see which tables are available.
     * 
     * @return void
     */
    public function available()
    {
        // Get filter parameters from URL query string
        // Example URL: /tables/available?players=4&date=2024-10-24&time=19:30
        $players_count = $_GET['players'] ?? 4;
        $date = $_GET['date'] ?? date('Y-m-d');  // Default to today
        $time = $_GET['time'] ?? '19:00';         // Default to 7 PM
        
        // Get available tables that can fit the group
        $data['tables'] = $this->tableModel->getAvailableTables($players_count, $date, $time);
        
        // Pass the filter parameters to the view
        $data['filters'] = [
            'players' => $players_count,
            'date' => $date,
            'time' => $time
        ];
        
        // Load the view
        $this->view('pages/tables_available', $data);
    }

    /**
     * Get table availability via AJAX
     * 
     * This method returns JSON data for JavaScript to use.
     * It's called from the booking page when checking availability.
     * 
     * @param int $table_id The table ID to check
     * @return void Outputs JSON
     */
    public function checkAvailability($table_id)
    {
        // Get parameters from URL or POST
        $date = $_GET['date'] ?? $_POST['date'] ?? date('Y-m-d');
        $time = $_GET['time'] ?? $_POST['time'] ?? '19:00';
        
        // Check if table is available
        $isAvailable = $this->tableModel->isTableAvailable($table_id, $date, $time);
        
        // Get table info
        $table = $this->tableModel->getTableById($table_id);
        
        // Return as JSON for JavaScript
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'available' => $isAvailable,
            'table' => $table
        ]);
        exit;
    }

    /**
     * Get all available tables as JSON (for AJAX)
     * 
     * Used by JavaScript on the booking page to dynamically
     * update available time slots.
     * 
     * @return void Outputs JSON
     */
    public function getAvailableTables()
    {
        $players_count = $_GET['players'] ?? 4;
        $date = $_GET['date'] ?? date('Y-m-d');
        $time = $_GET['time'] ?? '19:00';
        
        $tables = $this->tableModel->getAvailableTables($players_count, $date, $time);
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'tables' => $tables,
            'filters' => [
                'players' => $players_count,
                'date' => $date,
                'time' => $time
            ]
        ]);
        exit;
    }

    /**
     * Update table status (admin function)
     * 
     * Used by admin to change a table's status manually.
     * 
     * @param int $table_id The table ID to update
     * @return void
     */
    public function updateStatus($table_id)
    {
        // Only allow POST requests for this action
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . \URLROOT . '/tables');
            exit;
        }
        
        // Get the new status from POST data
        $status = $_POST['status'] ?? 'available';
        
        // Validate status value
        $allowedStatuses = ['available', 'reserved', 'occupied', 'maintenance'];
        if (!in_array($status, $allowedStatuses)) {
            die("Invalid status");
        }
        
        // Update the status
        $this->tableModel->updateTableStatus($table_id, $status);
        
        // Redirect back to tables page
        header('Location: ' . URLROOT . '/tables');
        exit;
    }
}
