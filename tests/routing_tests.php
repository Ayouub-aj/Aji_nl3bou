<?php

/**
 * Routing and Controller Tests
 * 
 * This script verifies that the MVC routing system correctly parses URLs
 * and dispatches them to the intended controllers and methods.
 */

// Autoload classes
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

/**
 * Utility function to display test results
 */
function reportTest($name, $success, $message = '') {
    $status = $success ? "✅ [PASS]" : "❌ [FAIL]";
    echo "$status $name" . ($message ? ": $message" : "") . "\n";
}

/**
 * Test URL Parsing logic
 */
function testUrlParsing() {
    $_GET['url'] = 'games/show/1';
    
    // We create a mock-like class to test getUrl since it's protected/internal
    // or we can just test the effect of it.
    $router = new RouterStub();
    $url = $router->getParsedUrl('games/show/1');
    
    $expected = ['games', 'show', '1'];
    $success = ($url === $expected);
    
    reportTest("URL Parsing", $success, $success ? "URL correctly exploded into parts." : "Explode failed. Got: " . print_r($url, true));
    return $success;
}

/**
 * Test Controller Dispatching
 */
function testControllerDispatch() {
    $_GET['url'] = 'games/index';
    
    ob_start();
    new Router();
    $output = ob_get_clean();
    
    $success = (strpos($output, 'GamesController: index method called successfully') !== false);
    reportTest("Controller Dispatch", $success, $success ? "GamesController@index called from URL." : "Failed to call GamesController@index.");
    return $success;
}

/**
 * Test Parameter Passing
 */
function testParamPassing() {
    $testId = '42';
    $_GET['url'] = "games/show/$testId";
    
    ob_start();
    new Router();
    $output = ob_get_clean();
    
    $success = (strpos($output, "GamesController: show method called with ID: $testId") !== false);
    reportTest("Parameter Passing", $success, $success ? "Parameter '$testId' passed correctly to controller." : "Param passing failed.");
    return $success;
}

/**
 * Test Default Route (GamesController@index)
 */
function testDefaultRoute() {
    unset($_GET['url']);
    
    ob_start();
    new Router();
    $output = ob_get_clean();
    
    $success = (strpos($output, 'GamesController: index method called successfully') !== false);
    reportTest("Default Route", $success, $success ? "Default route resolved to GamesController@index." : "Default route failed.");
    return $success;
}

/**
 * Stub class to test protected methods if necessary
 */
class RouterStub extends Router {
    public function __construct() {} // Don't run the dispatcher
    public function getParsedUrl($input) {
        $_GET['url'] = $input;
        return $this->getUrl();
    }
}

// Run All Tests
echo "--- Starting MVC Routing Tests ---\n";
$all_passed = true;

$all_passed &= testUrlParsing();
$all_passed &= testControllerDispatch();
$all_passed &= testParamPassing();
$all_passed &= testDefaultRoute();

echo "-------------------------------------\n";
if ($all_passed) {
    echo "🎉 RESULT: ALL ROUTING TESTS PASSED!\n";
} else {
    echo "⚠️ RESULT: SOME ROUTING TESTS FAILED!\n";
}
echo "-------------------------------------\n";
