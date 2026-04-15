<?php

/**
 * Database Singleton Class
 * 
 * This class manages the connection to the MySQL database using PDO.
 * It implements the Singleton pattern to ensure that only one database 
 * connection is open at any time during the execution of the script, 
 * which optimizes memory usage and performance.
 */
class Database
{
    // Database connection parameters
    private $host = 'localhost';
    private $dbname = 'game_cafe';
    private $user = 'root';
    private $pass = '';

    private static $instance = null;
    private $conn;

    /**
     * Private constructor to prevent direct instantiation from outside the class.
     * Initializes the PDO connection with secure and efficient settings.
     */
    private function __construct()
    {
        // DSN (Data Source Name) contains the information required to connect to the database.
        // We specify the driver (mysql), host, database name, and charset (utf8mb4 for full Unicode support).
        $dsn = "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4";

        // PDO attributes configuration for security and ease of use:
        // 1. ATTR_ERRMODE: Use exceptions to allow proper try-catch handling.
        // 2. ATTR_DEFAULT_FETCH_MODE: Automatically return results as associative arrays.
        // 3. ATTR_EMULATE_PREPARES: Disable emulation to use native prepared statements (more secure).
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            // Create a new PDO instance
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            // If connection fails, log the technical error to the server logs
            error_log("Database Connection Error: " . $e->getMessage());
            
            // Terminate execution with a generic user-friendly message for security
            die("Critical Error: Unable to connect to the database. Please try again later.");
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

?>