<?php

require_once __DIR__ . '/../config/db.php';

/**
 * Utility function to display test results
 */
function reportTest($name, $success, $message = '') {
    $status = $success ? "✅ [PASS]" : "❌ [FAIL]";
    echo "$status $name" . ($message ? ": $message" : "") . "\n";
}

/**
 * Test if the Database class follows the Singleton pattern
 */
function testSingleton() {
    $db1 = Database::getInstance();
    $db2 = Database::getInstance();
    
    $isSame = ($db1 === $db2);
    reportTest("Singleton Pattern", $isSame, $isSame ? "Both instances are identical." : "Instances are different!");
    return $isSame;
}

/**
 * Test if the connection is a valid PDO instance
 */
function testConnection() {
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        $isPDO = ($conn instanceof PDO);
        reportTest("Connection Object", $isPDO, $isPDO ? "Valid PDO object returned." : "Connection is not a PDO instance.");
        return $isPDO;
    } catch (Exception $e) {
        reportTest("Connection Object", false, $e->getMessage());
        return false;
    }
}

/**
 * Test if we can execute a simple query
 */
function testQuery() {
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        $stmt = $conn->query("SELECT 1");
        $result = $stmt->fetch();
        
        $success = ($result !== false);
        reportTest("Execute Query (SELECT 1)", $success, $success ? "Query executed successfully." : "Failed to fetch result.");
        return $success;
    } catch (Exception $e) {
        reportTest("Execute Query (SELECT 1)", false, $e->getMessage());
        return false;
    }
}

/**
 * Test if the database 'game_cafe' is accessible
 */
function testDatabaseName() {
    try {
        $db = Database::getInstance();
        $conn = $db->getConnection();
        
        $dbName = $conn->query("SELECT DATABASE()")->fetchColumn();
        
        $success = ($dbName === 'game_cafe');
        reportTest("Database Scope", $success, "Current database: " . ($dbName ?: 'unknown'));
        return $success;
    } catch (Exception $e) {
        reportTest("Database Scope", false, $e->getMessage());
        return false;
    }
}

// Run All Tests
echo "--- Starting PDO Connection Tests ---\n";
$all_passed = true;

$all_passed &= testSingleton();
$all_passed &= testConnection();
$all_passed &= testQuery();
$all_passed &= testDatabaseName();

echo "-------------------------------------\n";
if ($all_passed) {
    echo "🎉 RESULT: ALL TESTS PASSED!\n";
} else {
    echo "⚠️ RESULT: SOME TESTS FAILED!\n";
}
echo "-------------------------------------\n";
