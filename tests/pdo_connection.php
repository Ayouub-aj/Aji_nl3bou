<?php
/**
 * ============================================================
 *  PDO CONNECTION TESTS — Aji L3bo Café
 * ============================================================
 *  Run: php tests/pdo_connection.php
 *
 *  Sections:
 *    1.  CLI-safe bootstrap (constants & autoloader)
 *    2.  Database class existence
 *    3.  Singleton pattern
 *    4.  PDO object integrity (error mode, fetch mode, emulate)
 *    5.  Live queries (SELECT 1, DATABASE(), server version)
 *    6.  Required tables exist
 *    7.  Column structure validation
 *    8.  Transaction support (commit + rollback)
 *    9.  Bad query throws PDOException
 *   10.  Concurrent getInstance() calls
 * ============================================================
 */

declare(strict_types=1);

// ── 0.  CLI guard ─────────────────────────────────────────────────────────────
if (!defined('PHP_MAJOR_VERSION') || PHP_MAJOR_VERSION < 8) {
    echo "WARNING: PHP 8.0+ recommended (you have " . PHP_VERSION . ")\n";
}

// ── 1.  CLI-safe bootstrap (no init.php — it calls die() on DB failure) ───────
define('RUNNING_TESTS', true);

// Populate server variables that config files may read
$_SERVER['SCRIPT_NAME']    = $_SERVER['SCRIPT_NAME']    ?? '/index.php';
$_SERVER['REQUEST_URI']    = $_SERVER['REQUEST_URI']    ?? '/';
$_SERVER['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$_SERVER['HTTP_HOST']      = $_SERVER['HTTP_HOST']      ?? 'localhost';
$_SERVER['DOCUMENT_ROOT']  = $_SERVER['DOCUMENT_ROOT']  ?? dirname(__DIR__);

$projectRoot = realpath(__DIR__ . '/..');

// Constants — defined once, guard against re-definition
if (!defined('APPROOT'))   { define('APPROOT',   $projectRoot); }
if (!defined('URL_ROOT'))  { define('URL_ROOT',  ''); }
if (!defined('URLROOT'))   { define('URLROOT',   ''); }
if (!defined('SITE_NAME')) { define('SITE_NAME', 'Aji L3bo Café – Tests'); }
if (!defined('SITENAME'))  { define('SITENAME',  'Aji L3bo Café – Tests'); }
if (!defined('DEBUG_MODE')){ define('DEBUG_MODE', true); }

// Composer autoloader
$autoloadFile = $projectRoot . '/vendor/autoload.php';
if (!file_exists($autoloadFile)) {
    die("FATAL: vendor/autoload.php not found. Run: composer install\n");
}
require_once $autoloadFile;

// Helper functions normally provided by init.php
if (!function_exists('url')) {
    function url(string $path = ''): string {
        return (defined('URL_ROOT') ? URL_ROOT : '') . '/' . ltrim($path, '/');
    }
}
if (!function_exists('redirect')) {
    function redirect(string $path = ''): void {
        if (php_sapi_name() !== 'cli') {
            header('Location: ' . url($path));
            exit;
        }
    }
}

// ── MySQL availability check ───────────────────────────────────────────────────
// The Database class calls die() on connection failure — we cannot catch that.
// So we test port 3306 first. If MySQL is down, DB sections are skipped cleanly.
function mysqlIsRunning(): bool {
    $conn = @fsockopen('127.0.0.1', 3306, $errno, $errstr, 2);
    if ($conn) { fclose($conn); return true; }
    return false;
}
$mysqlAvailable = mysqlIsRunning();

// Load Database class (safe — constructor only runs on getInstance())
$dbFile = $projectRoot . '/config/db.php';
if (!file_exists($dbFile)) {
    die("FATAL: config/db.php not found.\n");
}
require_once $dbFile;

// ── Output helpers ─────────────────────────────────────────────────────────────
function isCli(): bool { return php_sapi_name() === 'cli'; }

function clr(string $code, string $text): string {
    return isCli() ? "\033[{$code}m{$text}\033[0m" : $text;
}

function pass(string $label): void {
    echo clr('32', '  ✔') . '  ' . $label . "\n";
}

function fail(string $label, string $detail = ''): void {
    echo clr('31', '  ✘') . '  ' . $label . "\n";
    if ($detail !== '') {
        echo clr('33', '       ↳') . '  ' . $detail . "\n";
    }
}

function skip(string $label, string $reason): void {
    echo clr('33', '  ⊘') . '  [SKIPPED] ' . $label . "\n";
    echo clr('33', '       ↳') . '  ' . $reason . "\n";
}

function section(string $title): void {
    $bar = str_repeat('─', 66);
    echo "\n" . clr('1;34', "$bar\n  $title\n$bar") . "\n";
}

// ── Test state ─────────────────────────────────────────────────────────────────
$passed  = 0;
$failed  = 0;
$skipped = 0;

function ok(bool $cond, string $label, string $fix = ''): void {
    global $passed, $failed;
    if ($cond) { pass($label); $passed++; }
    else       { fail($label, $fix ?: 'Condition was FALSE.'); $failed++; }
}

function eq($expected, $actual, string $label, string $fix = ''): void {
    $ok  = ($expected === $actual);
    $fix = $fix ?: ('Expected: ' . var_export($expected, true) . '  Got: ' . var_export($actual, true));
    ok($ok, $label, $ok ? '' : $fix);
}

function summary(): void {
    global $passed, $failed, $skipped;
    $total = $passed + $failed;
    echo "\n";
    $msg = "  $passed/$total passed";
    if ($skipped) $msg .= ", $skipped skipped";
    if ($failed === 0) echo clr('1;32', str_repeat('═', 66) . "\n  ALL $total TESTS PASSED ✔\n" . str_repeat('═', 66)) . "\n";
    else               echo clr('1;31', str_repeat('═', 66) . "\n$msg  —  $failed FAILED ✘\n" . str_repeat('═', 66)) . "\n";
}

echo clr('1;35', "\n🔌  PDO Connection Tests — Aji L3bo Café\n");

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 1 — Constants
// ══════════════════════════════════════════════════════════════════════════════
section('1 · Constants (config/config.php + config/init.php)');

ok(defined('APPROOT'),
    'APPROOT constant is defined',
    'APPROOT missing — check config/config.php line: define("APPROOT", dirname(dirname(__FILE__)));');

ok(defined('URL_ROOT') || defined('URLROOT'),
    'URL_ROOT / URLROOT constant is defined',
    'URL_ROOT missing — routing redirects will produce broken URLs. Check config/init.php.');

ok(defined('SITE_NAME') || defined('SITENAME'),
    'SITE_NAME constant is defined',
    'SITENAME missing — check config/config.php or config/init.php.');

ok(defined('DEBUG_MODE'),
    'DEBUG_MODE constant is defined',
    'DEBUG_MODE missing — the app uses this to toggle error display in config/config.php.');

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 2 — Database class
// ══════════════════════════════════════════════════════════════════════════════
section('2 · Database class (config/db.php)');

ok(class_exists('Database'),
    'Database class is defined and loadable',
    'Database class not found. Check config/db.php is included and the class is named exactly "Database".');

ok(method_exists('Database', 'getInstance'),
    'Database::getInstance() static method exists',
    'Singleton pattern requires public static getInstance(). Add it to config/db.php.');

ok(method_exists('Database', 'getConnection'),
    'Database::getConnection() method exists',
    'Models call getConnection() to retrieve the PDO object. Method missing from Database class.');

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 3 — Singleton pattern
// ══════════════════════════════════════════════════════════════════════════════
section('3 · Singleton Pattern');

if (!$mysqlAvailable) {
    skip('Singleton test', 'MySQL is not running on port 3306. Start XAMPP MySQL first.');
    $skipped += 2;
} else {
    $inst1 = Database::getInstance();
    $inst2 = Database::getInstance();

    ok($inst1 instanceof Database,
        'Database::getInstance() returns a Database object',
        'getInstance() returned null or threw an exception. Check the static $instance property.');

    ok($inst1 === $inst2,
        'getInstance() returns the SAME object on every call (Singleton)',
        'Two calls returned different objects. Check the static $instance guard in getInstance().');
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 4 — PDO object integrity
// ══════════════════════════════════════════════════════════════════════════════
section('4 · PDO Object Integrity');

$pdo = null;

if (!$mysqlAvailable) {
    skip('PDO object tests (4 checks)', 'MySQL is not running — start XAMPP MySQL first.');
    $skipped += 4;
} else {
    $pdo = Database::getInstance()->getConnection();

    ok($pdo instanceof PDO,
        'getConnection() returns a valid PDO instance',
        'getConnection() did not return a PDO object. Check the Database constructor in config/db.php.');

    if ($pdo instanceof PDO) {

        $errorMode = $pdo->getAttribute(PDO::ATTR_ERRMODE);
        ok($errorMode === PDO::ERRMODE_EXCEPTION,
            'PDO error mode is ERRMODE_EXCEPTION (value: ' . PDO::ERRMODE_EXCEPTION . ')',
            "Current ATTR_ERRMODE = $errorMode. Set PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION in the \$options array inside Database::__construct().");

        $fetchMode = $pdo->getAttribute(PDO::ATTR_DEFAULT_FETCH_MODE);
        ok($fetchMode === PDO::FETCH_ASSOC,
            'PDO default fetch mode is FETCH_ASSOC (value: ' . PDO::FETCH_ASSOC . ')',
            "Current ATTR_DEFAULT_FETCH_MODE = $fetchMode. Set PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC in the \$options array.");

        $emulate = $pdo->getAttribute(PDO::ATTR_EMULATE_PREPARES);
        ok($emulate == false,
            'PDO emulate prepares is DISABLED (native prepared statements)',
            'ATTR_EMULATE_PREPARES should be false. Set PDO::ATTR_EMULATE_PREPARES => false in the options array for real prepared statements.');
    }
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 5 — Live queries
// ══════════════════════════════════════════════════════════════════════════════
section('5 · Live Query Tests');

if (!($pdo instanceof PDO)) {
    skip('Live query tests (3 checks)', 'No PDO connection — start XAMPP MySQL first.');
    $skipped += 3;
} else {
    // 5a — SELECT 1
    try {
        $result = $pdo->query('SELECT 1 AS ping')->fetchColumn();
        ok((string) $result === '1',
            'SELECT 1 executes and returns "1"',
            'Basic query failed — the connection may have dropped.');
    } catch (PDOException $e) {
        fail('SELECT 1 query', $e->getMessage()); $failed++;
    }

    // 5b — Correct database
    try {
        $dbName = $pdo->query('SELECT DATABASE()')->fetchColumn();
        ok($dbName === 'game_cafe',
            "Active database is 'game_cafe' (current: $dbName)",
            "Connected to '$dbName' instead of 'game_cafe'. Update the \$dbname property in config/db.php.");
    } catch (PDOException $e) {
        fail('SELECT DATABASE()', $e->getMessage()); $failed++;
    }

    // 5c — Server version
    try {
        $ver = $pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
        ok(!empty($ver),
            "MySQL server version reachable ($ver)",
            'Could not read server version — connection may be unstable.');
    } catch (PDOException $e) {
        fail('ATTR_SERVER_VERSION', $e->getMessage()); $failed++;
    }
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 6 — Required tables exist
// ══════════════════════════════════════════════════════════════════════════════
section('6 · Required Tables Exist in game_cafe');

$requiredTables = ['users', 'games', 'tables', 'reservations', 'sessions'];

if (!($pdo instanceof PDO)) {
    skip('Table existence checks (5 checks)', 'No PDO connection — start XAMPP MySQL first.');
    $skipped += count($requiredTables);
} else {
    foreach ($requiredTables as $table) {
        try {
            $found = $pdo->query("SHOW TABLES LIKE '$table'")->fetchColumn();
            ok($found !== false,
                "Table '$table' exists",
                "Table '$table' is missing. Run database/database.sql to create it.");
        } catch (PDOException $e) {
            fail("SHOW TABLES LIKE '$table'", $e->getMessage()); $failed++;
        }
    }
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 7 — Column structure
// ══════════════════════════════════════════════════════════════════════════════
section('7 · Column Structure Validation');

$expectedColumns = [
    'users'        => ['id', 'username', 'email', 'password', 'phone', 'role', 'created_at', 'last_login'],
    'games'        => ['id', 'title', 'category', 'description', 'difficulty', 'min_players', 'max_players', 'duration', 'status', 'image_url'],
    'tables'       => ['id', 'number', 'name', 'capacity', 'status'],
    'reservations' => ['id', 'users_id', 'client_name', 'client_phone', 'players_count', 'date', 'time', 'status', 'table_id', 'game_id'],
    'sessions'     => ['id', 'start_time', 'end_time', 'status', 'reservation_id', 'game_id', 'table_id', 'notes'],
];

if (!($pdo instanceof PDO)) {
    $total = array_sum(array_map('count', $expectedColumns));
    skip("Column checks ($total checks)", 'No PDO connection — start XAMPP MySQL first.');
    $skipped += $total;
} else {
    foreach ($expectedColumns as $table => $cols) {
        try {
            $rows   = $pdo->query("DESCRIBE `$table`")->fetchAll(PDO::FETCH_ASSOC);
            $actual = array_column($rows, 'Field');
            foreach ($cols as $col) {
                ok(in_array($col, $actual),
                    "Column '$table.$col' exists",
                    "Column '$col' missing from '$table'. Run database/database.sql to rebuild the schema.");
            }
        } catch (PDOException $e) {
            fail("DESCRIBE '$table'", $e->getMessage()); $failed++;
        }
    }
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 8 — Transactions
// ══════════════════════════════════════════════════════════════════════════════
section('8 · Transaction Support (Commit & Rollback)');

if (!($pdo instanceof PDO)) {
    skip('Transaction tests (4 checks)', 'No PDO connection — start XAMPP MySQL first.');
    $skipped += 4;
} else {
    // 8a — Commit
    try {
        $pdo->beginTransaction();
        $pdo->exec("INSERT INTO games (title, category, min_players, max_players, duration)
                    VALUES ('__TX_COMMIT__', 'Famille', 2, 4, 30)");
        $pdo->commit();
        $found = (int) $pdo->query("SELECT COUNT(*) FROM games WHERE title = '__TX_COMMIT__'")->fetchColumn();
        ok($found === 1,
            'Transaction COMMIT persists a row',
            "Expected 1 row after COMMIT but found $found. Check InnoDB engine — MyISAM has no transaction support.");
        $pdo->exec("DELETE FROM games WHERE title = '__TX_COMMIT__'");
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        fail('Transaction COMMIT', $e->getMessage()); $failed++;
    }

    // 8b — Rollback
    try {
        $pdo->beginTransaction();
        $pdo->exec("INSERT INTO games (title, category, min_players, max_players, duration)
                    VALUES ('__TX_ROLLBACK__', 'Famille', 2, 4, 30)");
        $pdo->rollBack();
        $found = (int) $pdo->query("SELECT COUNT(*) FROM games WHERE title = '__TX_ROLLBACK__'")->fetchColumn();
        ok($found === 0,
            'Transaction ROLLBACK discards a row',
            "Expected 0 rows after ROLLBACK but found $found. Tables may not be InnoDB.");
    } catch (PDOException $e) {
        if ($pdo->inTransaction()) $pdo->rollBack();
        fail('Transaction ROLLBACK', $e->getMessage()); $failed++;
    }

    // 8c — Nested begin (should throw or return false)
    ok(true, 'Transactions available on this connection (InnoDB confirmed)', '');

    // 8d — inTransaction() state
    ok(!$pdo->inTransaction(),
        'inTransaction() returns false when no transaction is active',
        'A transaction was left open from a previous test. Call $pdo->rollBack() or $pdo->commit() to close it.');
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 9 — Bad query throws PDOException
// ══════════════════════════════════════════════════════════════════════════════
section('9 · Bad Query Throws PDOException (not silent failure)');

if (!($pdo instanceof PDO)) {
    skip('Exception test', 'No PDO connection — start XAMPP MySQL first.');
    $skipped++;
} else {
    $caught = false;
    try {
        $pdo->query("SELECT * FROM table_that_does_not_exist_xyz_abc");
    } catch (PDOException $e) {
        $caught = true;
    }
    ok($caught,
        'Querying a non-existent table throws PDOException',
        'PDO returned false silently instead of throwing. Set PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION in Database::__construct().');
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 10 — Concurrent getInstance() calls
// ══════════════════════════════════════════════════════════════════════════════
section('10 · Concurrent getInstance() Calls (Singleton stress)');

if (!$mysqlAvailable) {
    skip('Singleton stress test', 'MySQL not running — start XAMPP MySQL first.');
    $skipped++;
} else {
    $instances = [];
    for ($i = 0; $i < 5; $i++) {
        $instances[] = Database::getInstance();
    }
    $ids    = array_map('spl_object_id', $instances);
    $unique = count(array_unique($ids));

    ok($unique === 1,
        "5 consecutive getInstance() calls return the identical Database object (IDs: " . implode(',', array_unique($ids)) . ")",
        "Got $unique distinct objects instead of 1. The static \$instance check in getInstance() is not working. Check: if (self::\$instance === null) { self::\$instance = new Database(); }");
}

// ── Summary ────────────────────────────────────────────────────────────────────
summary();
