<?php

require_once __DIR__ . '/../Models/TableModel.php';

class TableController
{
    private $tableModel;

    public function __construct($pdo)
    {
        $this->tableModel = new TableModel($pdo);
    }

    // Check if one table is available
    public function checkTable()
    {
        if (isset($_POST['table_id'], $_POST['date'], $_POST['time'])) {

            $table_id = $_POST['table_id'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            $available = $this->tableModel->isTableAvailable($table_id, $date, $time);

            if ($available) {
                echo "✅ Table is available";
            } else {
                echo "❌ Table is reserved";
            }
        }
    }

    // Get all available tables for players count
    public function listAvailableTables()
    {
        if (isset($_POST['players_count'], $_POST['date'], $_POST['time'])) {

            $players = $_POST['players_count'];
            $date = $_POST['date'];
            $time = $_POST['time'];

            $tables = $this->tableModel->getAvailableTables($players, $date, $time);

            if (count($tables) > 0) {
                foreach ($tables as $table) {
                    echo "Table #" . $table['number'] . " - Capacity: " . $table['capacity'] . "<br>";
                }
            } else {
                echo "No tables available";
            }
        }
    }
}