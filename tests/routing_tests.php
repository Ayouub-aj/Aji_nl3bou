<?php
/**
 * ============================================================
 *  ROUTING TESTS — Aji L3bo Café
 * ============================================================
 *  Run: php tests/routing_tests.php
 *
 *  Sections:
 *   1.  index.php — Front Controller file integrity
 *   2.  .htaccess — Rewrite rules present & correct
 *   3.  RouterController — class & method structure
 *   4.  Route registration — every expected route declared
 *   5.  Static route resolution — exact URL matches
 *   6.  Dynamic route resolution — {id} parameterised patterns
 *   7.  Unknown routes return null (404 guard)
 *   8.  Controller classes & action methods exist
 *   9.  URL_ROOT constant usage in controllers
 *  10.  View files referenced by controllers exist on disk
 *  11.  Entry-point integrity (views don't bypass index.php)
 * ============================================================
 */

declare(strict_types=1);

// ── CLI-safe bootstrap ─────────────────────────────────────────────────────────
define('RUNNING_TESTS', true);

$_SERVER['SCRIPT_NAME']    = $_SERVER['SCRIPT_NAME']    ?? '/index.php';
$_SERVER['REQUEST_URI']    = $_SERVER['REQUEST_URI']    ?? '/';
$_SERVER['REQUEST_METHOD'] = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$_SERVER['HTTP_HOST']      = $_SERVER['HTTP_HOST']      ?? 'localhost';
$_SERVER['DOCUMENT_ROOT']  = $_SERVER['DOCUMENT_ROOT']  ?? dirname(__DIR__);

$projectRoot = realpath(__DIR__ . '/..');

if (!defined('APPROOT'))    { define('APPROOT',    $projectRoot); }
if (!defined('URL_ROOT'))   { define('URL_ROOT',   ''); }
if (!defined('URLROOT'))    { define('URLROOT',    ''); }
if (!defined('SITE_NAME'))  { define('SITE_NAME',  'Aji L3bo Café – Tests'); }
if (!defined('SITENAME'))   { define('SITENAME',   'Aji L3bo Café – Tests'); }
if (!defined('DEBUG_MODE')) { define('DEBUG_MODE',  true); }

// Composer autoloader (needed to resolve controller/model classes)
$autoloadFile = $projectRoot . '/vendor/autoload.php';
if (!file_exists($autoloadFile)) {
    die("FATAL: vendor/autoload.php not found. Run: composer install\n");
}
require_once $autoloadFile;

// Helper stubs
if (!function_exists('url')) {
    function url(string $path = ''): string {
        return (defined('URL_ROOT') ? URL_ROOT : '') . '/' . ltrim($path, '/');
    }
}
if (!function_exists('redirect')) {
    function redirect(string $path = ''): void {
        if (php_sapi_name() !== 'cli') { header('Location: ' . url($path)); exit; }
    }
}

// Load Database class (RouterController and controllers need it to instantiate)
// Only load if MySQL is available, otherwise controllers that auto-connect on
// instantiation will call die().
function mysqlIsRunning(): bool {
    $conn = @fsockopen('127.0.0.1', 3306, $errno, $errstr, 2);
    if ($conn) { fclose($conn); return true; }
    return false;
}
$mysqlAvailable = mysqlIsRunning();

$dbFile = $projectRoot . '/config/db.php';
if (file_exists($dbFile)) {
    require_once $dbFile;
}

// ── Output helpers ─────────────────────────────────────────────────────────────
function isCli(): bool { return php_sapi_name() === 'cli'; }

function clr(string $code, string $text): string {
    return isCli() ? "\033[{$code}m{$text}\033[0m" : $text;
}

function pass(string $label): void {
    echo clr('32', '  ✔') . "  $label\n";
}
function fail(string $label, string $detail = ''): void {
    echo clr('31', '  ✘') . "  $label\n";
    if ($detail !== '') echo clr('33', '       ↳') . "  $detail\n";
}
function skip(string $label, string $reason = ''): void {
    echo clr('33', '  ⊘') . "  [SKIPPED] $label\n";
    if ($reason !== '') echo clr('33', '       ↳') . "  $reason\n";
}
function section(string $title): void {
    $bar = str_repeat('─', 66);
    echo "\n" . clr('1;34', "$bar\n  $title\n$bar") . "\n";
}
function subSection(string $title): void {
    echo "\n" . clr('1;36', "  ▸ $title") . "\n";
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
    $diff = 'Expected: ' . var_export($expected, true) . '  Got: ' . var_export($actual, true);
    ok($expected === $actual, $label, $fix ?: $diff);
}
function summary(): void {
    global $passed, $failed, $skipped;
    $total = $passed + $failed;
    $extra = $skipped ? ", $skipped skipped" : '';
    echo "\n";
    if ($failed === 0) {
        echo clr('1;32', str_repeat('═', 66) . "\n  ALL $total TESTS PASSED ✔$extra\n" . str_repeat('═', 66)) . "\n";
    } else {
        echo clr('1;31', str_repeat('═', 66) . "\n  $passed/$total PASSED — $failed FAILED$extra ✘\n" . str_repeat('═', 66)) . "\n";
    }
}

echo clr('1;35', "\n🗺️   Routing Tests — Aji L3bo Café\n");

// ── File paths used throughout ─────────────────────────────────────────────────
$indexFile    = $projectRoot . '/index.php';
$htaccessFile = $projectRoot . '/.htaccess';
$routerFile   = $projectRoot . '/App/Controllers/RouterController.php';
$viewsDir     = $projectRoot . '/views';
$controllersDir = $projectRoot . '/App/Controllers';

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 1 — index.php Front Controller
// ══════════════════════════════════════════════════════════════════════════════
section('1 · index.php — Front Controller Integrity');

ok(file_exists($indexFile),
    'index.php exists at project root',
    "index.php not found at $projectRoot. It must sit at the root so .htaccess routes all requests through it.");

if (file_exists($indexFile)) {
    $idx = file_get_contents($indexFile);

    ok(str_contains($idx, 'require_once') && str_contains($idx, 'init.php'),
        'index.php includes config/init.php (bootstrap)',
        "index.php must contain: require_once __DIR__ . '/config/init.php'; Without it DB, autoloading, and constants are unavailable.");

    ok(str_contains($idx, 'RouterController'),
        'index.php references RouterController',
        "index.php must use App\\Controllers\\RouterController. Add: use App\\Controllers\\RouterController;");

    ok(str_contains($idx, '->dispatch()') || str_contains($idx, '->dispatch('),
        'index.php calls $router->dispatch()',
        "index.php instantiates RouterController but never dispatches. Add: \$router->dispatch();");

    ok(str_contains($idx, 'Database::getInstance'),
        'index.php boots the DB connection',
        "Boot the DB in index.php inside a try/catch. Add: Database::getInstance()->getConnection();");

    ok(str_contains($idx, 'session_start') || str_contains($idx, 'PHP_SESSION_NONE'),
        'index.php starts the session',
        "Add session guard: if (session_status() === PHP_SESSION_NONE) { session_start(); }");

    // Must NOT directly include view files
    $hasDirect = preg_match("#require[_once]*\s+['\"].*views/#", $idx)
              || preg_match("#include[_once]*\s+['\"].*views/#", $idx);
    ok(!$hasDirect,
        'index.php does NOT directly include any view file',
        "index.php must never include views directly. Let RouterController dispatch to a controller which calls \$this->view(). Direct view includes bypass MVC.");
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 2 — .htaccess
// ══════════════════════════════════════════════════════════════════════════════
section('2 · .htaccess — Rewrite Rules');

ok(file_exists($htaccessFile),
    '.htaccess exists at project root',
    ".htaccess missing from $projectRoot. Without it Apache cannot route requests to index.php.");

if (file_exists($htaccessFile)) {
    $htc = file_get_contents($htaccessFile);

    ok(str_contains($htc, 'RewriteEngine On'),
        '.htaccess has "RewriteEngine On"',
        '"RewriteEngine On" must be the first rewrite directive. Without it all other rules are ignored.');

    ok(str_contains($htc, 'index.php'),
        '.htaccess rewrites unmatched requests to index.php',
        'Add: RewriteRule ^ index.php [L]  at the end of .htaccess.');

    ok(str_contains($htc, '-f'),
        '.htaccess skips real files (RewriteCond %{REQUEST_FILENAME} -f)',
        'Real files (CSS/JS/images) must bypass the rewrite. Add: RewriteCond %{REQUEST_FILENAME} -f  with [L] flag.');

    ok(str_contains($htc, '-d'),
        '.htaccess skips real directories (RewriteCond %{REQUEST_FILENAME} -d)',
        'Real directories must bypass the rewrite. Add: RewriteCond %{REQUEST_FILENAME} -d  with [L] flag.');

    ok(str_contains($htc, '[L]'),
        '.htaccess uses [L] (last) flag',
        'The [L] flag stops further rule processing. Without it requests may be rewritten multiple times.');
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 3 — RouterController class structure
// ══════════════════════════════════════════════════════════════════════════════
section('3 · RouterController — Class & Method Structure');

ok(file_exists($routerFile),
    'App/Controllers/RouterController.php exists',
    "Not found at $routerFile. The router is the heart of MVC dispatch.");

ok(class_exists('App\\Controllers\\RouterController'),
    'App\\Controllers\\RouterController autoloads',
    "Class not found by autoloader. Check composer.json psr-4: \"App\\\\\" => \"App/\"  then run: composer dump-autoload");

if (class_exists('App\\Controllers\\RouterController')) {
    $ref = new ReflectionClass('App\\Controllers\\RouterController');

    ok($ref->hasMethod('dispatch'),
        'RouterController::dispatch() method exists',
        "dispatch() is called by index.php — add: public function dispatch(): void {}");

    ok($ref->hasMethod('get'),
        'RouterController::get() method exists',
        "get() registers GET routes — add: public function get(string \$path, string \$ctrl, string \$action): void {}");

    ok($ref->hasMethod('post'),
        'RouterController::post() method exists',
        "post() registers POST routes — add: public function post(string \$path, string \$ctrl, string \$action): void {}");

    ok($ref->getMethod('dispatch')->isPublic(),
        'RouterController::dispatch() is public',
        "dispatch() must be public so index.php can call \$router->dispatch().");

    if ($ref->hasMethod('registerRoutes')) {
        ok($ref->getMethod('registerRoutes')->isPrivate(),
            'RouterController::registerRoutes() is private (internal)',
            "registerRoutes() should be private — it is setup called only from the constructor.");
    }

    $propNames = array_map(fn($p) => $p->getName(), $ref->getProperties());
    ok(in_array('routes', $propNames),
        'RouterController has a $routes property',
        "\$routes is missing. Add: private array \$routes = [];");
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 4 — Route registration completeness
// ══════════════════════════════════════════════════════════════════════════════
section('4 · Route Registration — All Expected Routes Declared');

/**
 * Read the $routes array from RouterController via reflection.
 * Returns ['GET' => [...], 'POST' => [...]] or empty array.
 */
function getRoutes(): array {
    if (!class_exists('App\\Controllers\\RouterController')) return [];
    $router = new App\Controllers\RouterController();
    $ref    = new ReflectionClass($router);
    if (!$ref->hasProperty('routes')) return [];
    $prop = $ref->getProperty('routes');
    $prop->setAccessible(true);
    return (array) $prop->getValue($router);
}

$routes = getRoutes();

/** Assert a route (method + path) maps to the expected controller::action. */
function assertRoute(array $routes, string $method, string $path, string $ctrl, string $action): void {
    global $passed, $failed;
    $m       = strtoupper($method);
    $defined = $routes[$m][$path] ?? null;

    if ($defined === null) {
        fail("$m $path  →  $ctrl::$action()",
             "Route not registered. Add: \$this->" . strtolower($m) . "('$path', '$ctrl', '$action') in registerRoutes().");
        $failed++;
        return;
    }
    if ($defined['controller'] === $ctrl && $defined['action'] === $action) {
        pass("$m $path  →  $ctrl::$action()");
        $passed++;
    } else {
        $got = ($defined['controller'] ?? '?') . '::' . ($defined['action'] ?? '?') . '()';
        fail("$m $path  →  $ctrl::$action()",
             "Mapped to '$got' instead. Fix the controller/action names in registerRoutes().");
        $failed++;
    }
}

subSection('Public routes');
assertRoute($routes, 'GET',  '/',          'SessionsController', 'home');
assertRoute($routes, 'GET',  '/login',     'AuthController',     'login');
assertRoute($routes, 'POST', '/login',     'AuthController',     'handleLogin');
assertRoute($routes, 'GET',  '/logout',    'AuthController',     'logout');

subSection('Dashboard routes');
assertRoute($routes, 'GET', '/dashboard/admin',  'SessionsController', 'adminDashboard');
assertRoute($routes, 'GET', '/dashboard/client', 'SessionsController', 'clientDashboard');

subSection('Game routes');
assertRoute($routes, 'GET',  '/inventory',         'GamesController', 'inventory');
assertRoute($routes, 'GET',  '/games/add',         'GamesController', 'create');
assertRoute($routes, 'POST', '/games/add',         'GamesController', 'store');
assertRoute($routes, 'GET',  '/games/edit/{id}',   'GamesController', 'edit');
assertRoute($routes, 'POST', '/games/edit/{id}',   'GamesController', 'update');
assertRoute($routes, 'POST', '/games/delete/{id}', 'GamesController', 'delete');

subSection('Reservation routes');
assertRoute($routes, 'GET',  '/reservations',              'ReservationController', 'adminIndex');
assertRoute($routes, 'GET',  '/reservations/add',          'ReservationController', 'create');
assertRoute($routes, 'POST', '/reservations/add',          'ReservationController', 'store');
assertRoute($routes, 'POST', '/reservations/status/{id}',  'ReservationController', 'updateStatus');
assertRoute($routes, 'POST', '/reservations/cancel/{id}',  'ReservationController', 'cancel');
assertRoute($routes, 'POST', '/reservations/confirm/{id}', 'ReservationController', 'confirm');
assertRoute($routes, 'POST', '/reservations/delete/{id}',  'ReservationController', 'delete');
assertRoute($routes, 'GET',  '/booking',                   'ReservationController', 'clientBooking');
assertRoute($routes, 'POST', '/booking',                   'ReservationController', 'book');

subSection('Table routes');
assertRoute($routes, 'GET',  '/tables',                         'TableController', 'index');
assertRoute($routes, 'GET',  '/tables/{id}',                    'TableController', 'show');
assertRoute($routes, 'GET',  '/tables/available',               'TableController', 'available');
assertRoute($routes, 'GET',  '/tables/check-availability/{id}', 'TableController', 'checkAvailability');
assertRoute($routes, 'GET',  '/tables/get-available',           'TableController', 'getAvailableTables');
assertRoute($routes, 'POST', '/tables/update-status/{id}',      'TableController', 'updateStatus');

subSection('Auth & password routes');
assertRoute($routes, 'GET',  '/add-password', 'AuthController', 'addPassword');
assertRoute($routes, 'POST', '/add-password', 'AuthController', 'handleAddPassword');

subSection('API routes');
assertRoute($routes, 'GET', '/api/games',            'GamesController',       'getAll');
assertRoute($routes, 'GET', '/api/tables/available', 'ReservationController', 'getAvailableTables');

subSection('Session routes');
assertRoute($routes, 'GET', '/sessions/end/{id}', 'SessionsController', 'endSession');

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 5 — Static route resolution
// ══════════════════════════════════════════════════════════════════════════════
section('5 · Static Route Resolution — Exact URL Matching');

/**
 * Resolve a URI against the routes table — mirrors RouterController's logic.
 */
function resolve(array $routes, string $method, string $uri): ?array {
    $m = strtoupper($method);
    if (isset($routes[$m][$uri])) return $routes[$m][$uri];
    foreach ($routes[$m] ?? [] as $pattern => $route) {
        $regex = preg_replace('/\{([a-zA-Z_]+)\}/', '([^/]+)', $pattern);
        if (preg_match('#^' . $regex . '$#', $uri)) return $route;
    }
    return null;
}

/** Assert a URI dispatches to the expected controller & action. */
function assertDispatches(array $routes, string $method, string $uri, string $ctrl, string $action): void {
    global $passed, $failed;
    $r = resolve($routes, $method, $uri);
    if ($r && $r['controller'] === $ctrl && $r['action'] === $action) {
        pass("$method $uri  →  $ctrl::$action()");
        $passed++;
    } elseif ($r === null) {
        fail("$method $uri  →  $ctrl::$action()",
             "No route matched '$uri'. Check registerRoutes() — route may be missing or pattern is wrong.");
        $failed++;
    } else {
        $got = ($r['controller'] ?? '?') . '::' . ($r['action'] ?? '?') . '()';
        fail("$method $uri  →  $ctrl::$action()",
             "Resolved to '$got' instead. Fix the controller/action in registerRoutes().");
        $failed++;
    }
}

assertDispatches($routes, 'GET',  '/',                 'SessionsController',    'home');
assertDispatches($routes, 'GET',  '/login',            'AuthController',        'login');
assertDispatches($routes, 'POST', '/login',            'AuthController',        'handleLogin');
assertDispatches($routes, 'GET',  '/logout',           'AuthController',        'logout');
assertDispatches($routes, 'GET',  '/inventory',        'GamesController',       'inventory');
assertDispatches($routes, 'GET',  '/games/add',        'GamesController',       'create');
assertDispatches($routes, 'POST', '/games/add',        'GamesController',       'store');
assertDispatches($routes, 'GET',  '/reservations',     'ReservationController', 'adminIndex');
assertDispatches($routes, 'GET',  '/reservations/add', 'ReservationController', 'create');
assertDispatches($routes, 'POST', '/reservations/add', 'ReservationController', 'store');
assertDispatches($routes, 'GET',  '/booking',          'ReservationController', 'clientBooking');
assertDispatches($routes, 'POST', '/booking',          'ReservationController', 'book');
assertDispatches($routes, 'GET',  '/tables',           'TableController',       'index');
assertDispatches($routes, 'GET',  '/add-password',     'AuthController',        'addPassword');
assertDispatches($routes, 'POST', '/add-password',     'AuthController',        'handleAddPassword');
assertDispatches($routes, 'GET',  '/api/games',        'GamesController',       'getAll');
assertDispatches($routes, 'GET',  '/dashboard/admin',  'SessionsController',    'adminDashboard');
assertDispatches($routes, 'GET',  '/dashboard/client', 'SessionsController',    'clientDashboard');

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 6 — Dynamic route resolution ({id} patterns)
// ══════════════════════════════════════════════════════════════════════════════
section('6 · Dynamic Route Resolution — {id} Patterns');

// Games
assertDispatches($routes, 'GET',  '/games/edit/1',       'GamesController', 'edit');
assertDispatches($routes, 'GET',  '/games/edit/999',     'GamesController', 'edit');
assertDispatches($routes, 'POST', '/games/edit/42',      'GamesController', 'update');
assertDispatches($routes, 'POST', '/games/delete/7',     'GamesController', 'delete');

// Reservations
assertDispatches($routes, 'POST', '/reservations/status/1',  'ReservationController', 'updateStatus');
assertDispatches($routes, 'POST', '/reservations/cancel/5',  'ReservationController', 'cancel');
assertDispatches($routes, 'POST', '/reservations/confirm/3', 'ReservationController', 'confirm');
assertDispatches($routes, 'POST', '/reservations/delete/12', 'ReservationController', 'delete');

// Tables
assertDispatches($routes, 'GET',  '/tables/1',                     'TableController', 'show');
assertDispatches($routes, 'GET',  '/tables/check-availability/4',  'TableController', 'checkAvailability');
assertDispatches($routes, 'POST', '/tables/update-status/2',       'TableController', 'updateStatus');

// Sessions
assertDispatches($routes, 'GET', '/sessions/end/1', 'SessionsController', 'endSession');

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 7 — Unknown routes return null (404 guard)
// ══════════════════════════════════════════════════════════════════════════════
section('7 · Unknown Routes — Must Return null (404 guard)');

foreach ([
    ['GET',    '/this/does/not/exist'],
    ['GET',    '/admin/secret'],
    ['POST',   '/games/fly/99'],
    ['GET',    '/reservations/export'],
    ['DELETE', '/games/1'],
    ['GET',    '/inventory/export/csv'],
] as [$m, $uri]) {
    $r = resolve($routes, $m, $uri);
    ok($r === null, "$m $uri correctly returns null (no route match)",
       "$m '$uri' unexpectedly matched: " . var_export($r, true) . ". Remove or tighten the matching pattern.");
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 8 — Controller classes & action methods exist
// ══════════════════════════════════════════════════════════════════════════════
section('8 · Controller Classes & Action Methods Exist');

$controllerMap = [
    'App\\Controllers\\AuthController' => [
        'login', 'handleLogin', 'logout', 'addPassword', 'handleAddPassword',
    ],
    'App\\Controllers\\GamesController' => [
        'inventory', 'create', 'store', 'edit', 'update', 'delete', 'updateStatus', 'getAll',
    ],
    'App\\Controllers\\ReservationController' => [
        'adminIndex', 'create', 'store', 'updateStatus', 'cancel',
        'confirm', 'delete', 'clientBooking', 'book', 'getAvailableTables',
    ],
    'App\\Controllers\\SessionsController' => [
        'home', 'adminDashboard', 'clientDashboard', 'endSession',
    ],
    'App\\Controllers\\TableController' => [
        'index', 'show', 'available', 'checkAvailability', 'getAvailableTables', 'updateStatus',
    ],
    'App\\Controllers\\RouterController' => [
        'dispatch', 'get', 'post',
    ],
];

foreach ($controllerMap as $fqcn => $methods) {
    $short = substr($fqcn, strrpos($fqcn, '\\') + 1);

    ok(class_exists($fqcn), "$short class autoloads",
       "Class $fqcn not found.\n       → File: App/Controllers/$short.php\n       → Namespace must be: namespace App\\Controllers;\n       → Run: composer dump-autoload");

    if (class_exists($fqcn)) {
        foreach ($methods as $method) {
            ok(method_exists($fqcn, $method), "$short::$method() exists",
               "$short::$method() is missing. The registered route will throw a fatal error when dispatched. Add: public function $method(): void {}");
        }
    }
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 9 — URL_ROOT usage in controllers
// ══════════════════════════════════════════════════════════════════════════════
section('9 · URL_ROOT — Defined & Used in Every Redirecting Controller');

ok(defined('URL_ROOT'),
    'URL_ROOT constant is defined (from config/init.php or bootstrap)',
    'URL_ROOT undefined. init.php must define it. Without it, all header(Location:) redirects throw a fatal error.');

if (defined('URL_ROOT')) {
    ok(!str_ends_with(URL_ROOT, '/'),
        "URL_ROOT ('" . URL_ROOT . "') does not end with a trailing slash",
        "URL_ROOT must NOT end with '/'. Controllers build URLs as URL_ROOT.'/path' — a trailing slash creates double-slashes.");
    ok(URL_ROOT === '' || str_starts_with(URL_ROOT, '/'),
        "URL_ROOT is '' (root) or starts with '/' (subdirectory)",
        "URL_ROOT='" . URL_ROOT . "' is invalid. Must be '' for root or '/subfolder' for subdirectory installs.");
}

$ctrlFiles = glob($controllersDir . '/*.php') ?: [];
foreach ($ctrlFiles as $file) {
    $name    = basename($file);
    $content = file_get_contents($file);
    if ($name === 'RouterController.php') continue; // dispatches, doesn't redirect
    if (!str_contains($content, "header('Location:")) continue; // no redirects — skip

    ok(str_contains($content, 'URL_ROOT'),
       "$name uses \\URL_ROOT in redirect headers",
       "$name has header('Location:...) calls without URL_ROOT. Hardcoded paths break subdirectory installs. Replace with: header('Location: ' . \\URL_ROOT . '/path');");
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 10 — View files exist on disk
// ══════════════════════════════════════════════════════════════════════════════
section('10 · View Files — All Controller-Referenced Views Exist');

$viewMap = [
    // Auth
    'auth/login'              => 'AuthController::login()',
    'auth/add_password'       => 'AuthController::addPassword()',
    // Admin pages
    'pages/dashboard_admin'   => 'SessionsController::adminDashboard()',
    'pages/dashboard_client'  => 'SessionsController::clientDashboard()',
    'pages/inventory'         => 'GamesController::inventory()',
    'pages/add_game'          => 'GamesController::create()',
    'pages/edit_game'         => 'GamesController::edit()',
    'pages/reservation_admin' => 'ReservationController::adminIndex()',
    'pages/add_reservation'   => 'ReservationController::create()',
    'pages/booking_client'    => 'ReservationController::clientBooking()',
    'pages/list_tables'       => 'ReservationController::listTables()',
    'pages/home'              => 'SessionsController::home()',
];

foreach ($viewMap as $viewPath => $usedBy) {
    $full = $viewsDir . '/' . $viewPath . '.php';
    ok(file_exists($full),
       "views/$viewPath.php exists  (used by $usedBy)",
       "File not found: views/$viewPath.php\n       $usedBy calls \$this->view('$viewPath'). Create the file or fix the path in the controller.");
}

subSection('Views directory structure');
foreach (['auth', 'pages', 'includes', 'style'] as $dir) {
    ok(is_dir($viewsDir . '/' . $dir),
       "views/$dir/ directory exists",
       "Directory views/$dir/ is missing. The MVC structure requires: views/auth/, views/pages/, views/includes/, views/style/.");
}

subSection('views/includes/ partials');
if (is_dir($viewsDir . '/includes')) {
    $partials = glob($viewsDir . '/includes/*.php') ?: [];
    if (empty($partials)) {
        fail('views/includes/ contains at least one partial file',
             'views/includes/ is empty. Shared header/footer partials should live here.');
        $failed++;
    } else {
        pass('views/includes/ contains ' . count($partials) . ' partial file(s)');
        $passed++;
        foreach ($partials as $p) {
            $name = basename($p);
            $isPhp = str_starts_with(ltrim(file_get_contents($p)), '<?');
            ok($isPhp, "includes/$name is a valid PHP file",
               "includes/$name does not start with <?php — it may be empty or misnamed.");
        }
    }
}

// ══════════════════════════════════════════════════════════════════════════════
//  SECTION 11 — Entry-point integrity
// ══════════════════════════════════════════════════════════════════════════════
section('11 · Entry-Point Integrity — All Requests Must Pass Through index.php');

subSection('View pages do not call session_start() or contain raw auth guards');

if (is_dir($viewsDir . '/pages')) {
    foreach (glob($viewsDir . '/pages/*.php') ?: [] as $pageFile) {
        $name    = basename($pageFile);
        $content = file_get_contents($pageFile);

        ok(!preg_match('/^\s*session_start\(\)/m', $content),
           "views/pages/$name does not call session_start() directly",
           "views/pages/$name calls session_start(). Sessions must be started in config/init.php or controllers — never in view files.");

        if (preg_match('/^\s*if\s*\(\s*!\s*isset\s*\(\s*\$_SESSION\s*\[/m', $content)) {
            fail("views/pages/$name has an inline \$_SESSION auth guard (move to controller)",
                 "$name checks \$_SESSION directly. Auth guards belong in the controller action that loads this view, not in the view itself.");
            $failed++;
        } else {
            pass("views/pages/$name delegates auth to its controller");
            $passed++;
        }
    }
}

subSection('Controllers do not echo raw HTML blocks');
foreach ($ctrlFiles as $file) {
    $name    = basename($file);
    $content = file_get_contents($file);
    $hasHtml = (bool) preg_match('/echo\s+[\'"]<(!DOCTYPE|html|body|div|h[1-6]|form|table)/i', $content);
    ok(!$hasHtml,
       "$name does not echo raw HTML blocks (uses \$this->view() instead)",
       "$name echoes raw HTML. Controllers must never output HTML directly — delegate to \$this->view('path', \$data).");
}

subSection('BaseController::view() is correctly implemented');
$basePath = $projectRoot . '/App/core/BaseController.php';
if (file_exists($basePath)) {
    $base = file_get_contents($basePath);

    ok(str_contains($base, '/views/'),
       'BaseController::view() builds path using the /views/ directory',
       'BaseController::view() must point to views/: $viewFile = __DIR__ . "/../../views/" . $view . ".php";');

    ok(str_contains($base, 'file_exists'),
       'BaseController::view() guards against missing view files',
       'Add: if (file_exists($viewFile)) { require_once $viewFile; } else { die("View not found: $viewFile"); }');

    ok(str_contains($base, 'extract('),
       'BaseController::view() calls extract($data) to expose variables to views',
       'Without extract($data) the view cannot access $games, $reservations, etc. Add: extract($data); before the require_once.');
}

// ── Summary ────────────────────────────────────────────────────────────────────
summary();
