<?php
/**
 * ============================================================
 *  UNIT TESTS — Aji L3bo Café
 * ============================================================
 *  Run: php tests/unit_test.php
 *
 *  Suites:
 *   GameModel      : A-getAllGames  B-getGameById  C-create
 *                    D-update       E-updateStatus  F-delete
 *                    G-searchGames  H-getGamesByCategory
 *                    I-getAvailableGames  J-getCategories
 *                    K-countGames   L-countByStatus
 *
 *   ReservationModel: M-getAllReservations  N-getReservationById
 *                     O-create  P-update  Q-updateStatus
 *                     R-cancel  S-confirm  T-delete
 *                     U-getByDate  V-getByStatus  W-getByUserId
 *                     X-search  Y-countByStatus  Z-countByDate
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

// Composer autoloader
$autoloadFile = $projectRoot . '/vendor/autoload.php';
if (!file_exists($autoloadFile)) {
    die("FATAL: vendor/autoload.php not found. Run: composer install\n");
}
require_once $autoloadFile;

// Helper stubs (models may pull these in from init.php)
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

// MySQL availability check (Database::__construct calls die() — cannot catch)
function mysqlIsRunning(): bool {
    $conn = @fsockopen('127.0.0.1', 3306, $errno, $errstr, 2);
    if ($conn) { fclose($conn); return true; }
    return false;
}
$mysqlAvailable = mysqlIsRunning();

// Load Database class
$dbFile = $projectRoot . '/config/db.php';
if (!file_exists($dbFile)) { die("FATAL: config/db.php not found.\n"); }
require_once $dbFile;

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
function isArr($v, string $label, string $fix = ''): void {
    ok(is_array($v), $label, $fix ?: "Expected array, got: " . gettype($v));
}
function isInt($v, string $label, string $fix = ''): void {
    ok(is_int($v), $label, $fix ?: "Expected int, got: " . gettype($v) . ' value: ' . var_export($v, true));
}
function atLeast(int $min, $v, string $label, string $fix = ''): void {
    ok(is_numeric($v) && (int)$v >= $min, $label, $fix ?: "Expected >= $min, got: " . var_export($v, true));
}

function summary(): void {
    global $passed, $failed, $skipped;
    $total = $passed + $failed;
    echo "\n";
    $extra = $skipped ? ", $skipped skipped" : '';
    if ($failed === 0) {
        echo clr('1;32', str_repeat('═', 66) . "\n  ALL $total TESTS PASSED ✔$extra\n" . str_repeat('═', 66)) . "\n";
    } else {
        echo clr('1;31', str_repeat('═', 66) . "\n  $passed/$total PASSED — $failed FAILED$extra ✘\n" . str_repeat('═', 66)) . "\n";
    }
}

echo clr('1;35', "\n🧪  Unit Tests — Aji L3bo Café\n");

// ── Early exit if MySQL is down ────────────────────────────────────────────────
if (!$mysqlAvailable) {
    echo "\n" . clr('1;31', "  ✘  MySQL is NOT running on port 3306.") . "\n";
    echo clr('33', "     Start XAMPP MySQL, then re-run: php tests/unit_test.php\n");
    exit(1);
}

// ── Instantiate models ─────────────────────────────────────────────────────────
section('Prerequisites — Model autoloading');

$modelsOk = true;
foreach (['App\\Models\\GameModel', 'App\\Models\\ReservationModel', 'App\\Models\\TableModel', 'App\\Models\\UserModel'] as $cls) {
    $short = substr($cls, strrpos($cls, '\\') + 1);
    if (class_exists($cls)) {
        pass("$short is autoloaded");
        $passed++;
    } else {
        fail("$short is NOT autoloaded",
             "Class $cls not found. Check composer.json psr-4 map: \"App\\\\\" => \"App/\". Then run: composer dump-autoload");
        $failed++;
        $modelsOk = false;
    }
}

if (!$modelsOk) {
    fail('Cannot continue — required model classes are missing.', '');
    summary();
    exit(1);
}

$gameModel        = new App\Models\GameModel();
$reservationModel = new App\Models\ReservationModel();
$tableModel       = new App\Models\TableModel();
$pdo              = getPdo();

// ── Fixture helpers ────────────────────────────────────────────────────────────

/**
 * Get a fresh PDO handle from the Singleton.
 * Re-fetching avoids "MySQL server has gone away" when the connection
 * was touched by a previous test file sharing the same PHP process.
 */
function getPdo(): PDO {
    return Database::getInstance()->getConnection();
}

/** Insert a test game via raw SQL and return its new ID. */
function makeGame(string $tag = ''): int {
    $pdo   = getPdo();
    $title = $pdo->quote('__TEST_' . ($tag ? $tag . '_' : '') . uniqid() . '__');
    $pdo->exec("INSERT INTO games (title, category, description, min_players, max_players, duration, difficulty, status)
                VALUES ($title, 'Famille', 'Automated test fixture', 2, 4, 30, 'Moyen', 'available')");
    return (int) $pdo->lastInsertId();
}

/** Insert a test table row and return its ID. */
function makeTable(): int {
    $pdo = getPdo();
    $num = rand(8000, 8999);
    $pdo->exec("INSERT INTO `tables` (number, name, capacity, status)
                VALUES ($num, '__TEST_TABLE__', 4, 'free')");
    return (int) $pdo->lastInsertId();
}

/** Insert a test reservation and return its ID. */
function makeReservation(int $tableId, ?int $gameId = null, ?int $userId = null): int {
    global $reservationModel;
    $pdo = getPdo();
    $data = [
        'client_name'   => '__TEST_CLIENT_' . uniqid() . '__',
        'client_phone'  => '06' . rand(10000000, 99999999),
        'table_id'      => $tableId,
        'game_id'       => $gameId,
        'date'          => date('Y-m-d', strtotime('+30 days')),
        'time'          => '19:00:00',
        'players_count' => 3,
        'status'        => 'pending',
        'user_id'       => $userId,
    ];
    $id = $reservationModel->create($data);
    return is_int($id) && $id > 0 ? $id : (int) getPdo()->lastInsertId();
}

/** Delete test rows after each suite. */
function cleanup(string $table, array $ids): void {
    if (empty($ids)) return;
    $pdo  = getPdo();
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $stmt = $pdo->prepare("DELETE FROM `$table` WHERE id IN ($placeholders)");
    $stmt->execute($ids);
}

// ══════════════════════════════════════════════════════════════════════════════
//  G A M E   M O D E L   T E S T S
// ══════════════════════════════════════════════════════════════════════════════
section('GAME MODEL — App/models/GameModel.php');

// ── Suite A — getAllGames() ────────────────────────────────────────────────────
subSection('A · getAllGames()');

$all = $gameModel->getAllGames();
isArr($all, 'getAllGames() returns an array',
    'GameModel::getAllGames() must return array. Verify $stmt->fetchAll(PDO::FETCH_ASSOC) is called.');

if (!empty($all)) {
    foreach (['id','title','category','min_players','max_players','duration','status'] as $col) {
        ok(array_key_exists($col, $all[0]),
            "getAllGames() row contains key '$col'",
            "Column '$col' missing. Verify the games table schema matches database/database.sql.");
    }
    $titles = array_column($all, 'title');
    $sorted = $titles; sort($sorted);
    eq($sorted, $titles, 'getAllGames() results are sorted by title ASC',
        'ORDER BY title ASC missing or wrong in GameModel::getAllGames().');
}

// ── Suite B — getGameById() ────────────────────────────────────────────────────
subSection('B · getGameById()');

$idB = makeGame('B');

$found = $gameModel->getGameById($idB);
ok(is_array($found) && !empty($found), "getGameById($idB) returns a non-empty array",
    "getGameById() returned empty/false for an existing ID. Check WHERE id = ? LIMIT 1 in GameModel.");
eq((string)$idB, (string)($found['id'] ?? ''), "getGameById($idB) returns the correct row",
    "Returned row has ID '{$found['id']}' — check the WHERE clause.");

$notFound = $gameModel->getGameById(999999999);
ok(empty($notFound),
    'getGameById(999999999) returns false/empty for non-existent ID',
    'getGameById() should return false when no row exists. Make sure $stmt->fetch() is used (not fetchAll).');

cleanup('games', [$idB]);

// ── Suite C — create() ────────────────────────────────────────────────────────
subSection('C · create() — full field insert');

$newData = [
    'title'       => '__TEST_CREATE_' . uniqid() . '__',
    'category'    => 'Stratégie',
    'description' => 'Unit test — full field insert',
    'min_players' => 2,
    'max_players' => 6,
    'duration'    => 90,
    'difficulty'  => 'Difficile',
    'status'      => 'available',
    'image_url'   => 'https://example.com/game.jpg',
];
$result = $gameModel->create($newData);
$idC    = (int) $pdo->lastInsertId();

ok($result !== false, 'create() returns true on success',
    'GameModel::create() returned false. Check all 9 VALUES bindings match the INSERT columns.');
ok($idC > 0, "create() inserts a row with a valid auto-increment ID ($idC)",
    'lastInsertId() returned 0 — INSERT may have failed silently. Enable ERRMODE_EXCEPTION.');

$row = $gameModel->getGameById($idC);
eq($newData['title'],       $row['title']       ?? '', 'create() persists title',
    "Title mismatch after insert. Check column order in INSERT INTO games (...).");
eq($newData['category'],    $row['category']    ?? '', 'create() persists category',
    "Category mismatch. ENUM accepts: Stratégie, Ambiance, Famille, Experts.");
eq((string)$newData['min_players'], (string)($row['min_players'] ?? ''), 'create() persists min_players', '');
eq((string)$newData['max_players'], (string)($row['max_players'] ?? ''), 'create() persists max_players', '');
eq((string)$newData['duration'],    (string)($row['duration']    ?? ''), 'create() persists duration',    '');
eq($newData['difficulty'],  $row['difficulty']  ?? '', 'create() persists difficulty',
    "Difficulty ENUM: Facile, Moyen, Difficile (case-sensitive).");
eq($newData['status'],      $row['status']      ?? '', 'create() persists status',
    "Expected 'available'. Check ENUM and default in INSERT statement.");

cleanup('games', [$idC]);

// ── Suite D — update() ────────────────────────────────────────────────────────
subSection('D · update()');

$idD = makeGame('D');
$upd = [
    'title'       => '__UPDATED_' . uniqid() . '__',
    'category'    => 'Ambiance',
    'description' => 'Updated by unit test',
    'min_players' => 3,
    'max_players' => 8,
    'duration'    => 120,
    'difficulty'  => 'Facile',
    'status'      => 'unavailable',
    'image_url'   => 'https://example.com/upd.jpg',
];

ok($gameModel->update($idD, $upd) === true, "update($idD) returns true",
    'GameModel::update() returned false. Check all 9 SET columns and that WHERE id = ? is the LAST binding.');

$r = $gameModel->getGameById($idD);
eq($upd['title'],      $r['title']      ?? '', 'update() changes title',      '');
eq($upd['category'],   $r['category']   ?? '', 'update() changes category',   '');
eq((string)$upd['min_players'], (string)($r['min_players'] ?? ''), 'update() changes min_players', '');
eq($upd['status'],     $r['status']     ?? '', 'update() changes status to unavailable',
    "Expected 'unavailable'. Add status to UPDATE SET clause.");

cleanup('games', [$idD]);

// ── Suite E — updateStatus() ──────────────────────────────────────────────────
subSection('E · updateStatus()');

$idE = makeGame('E');

ok($gameModel->updateStatus($idE, 'unavailable') === true, "updateStatus($idE, 'unavailable') returns true",
    "GameModel::updateStatus() returned false. Check UPDATE games SET status = ? WHERE id = ?.");
eq('unavailable', $gameModel->getGameById($idE)['status'] ?? '', 'updateStatus() writes "unavailable"',
    "Status not persisted. Verify prepare/execute binding in updateStatus().");

ok($gameModel->updateStatus($idE, 'available') === true, "updateStatus($idE, 'available') returns true", '');
eq('available', $gameModel->getGameById($idE)['status'] ?? '', 'updateStatus() toggles back to "available"', '');

cleanup('games', [$idE]);

// ── Suite F — delete() ────────────────────────────────────────────────────────
subSection('F · delete()');

$idF = makeGame('F');

ok($gameModel->delete($idF) === true, "delete($idF) returns true",
    "GameModel::delete() returned false. Check DELETE FROM games WHERE id = ?.");
ok(empty($gameModel->getGameById($idF)), "delete() removes the row — getGameById() returns empty",
    "Row $idF still exists after delete(). WHERE clause may be wrong.");

// ── Suite G — searchGames() ───────────────────────────────────────────────────
subSection('G · searchGames()');

$idG     = makeGame('SEARCH');
$marker  = 'UNIQUEMARKER' . uniqid();
$pdo->exec("UPDATE games SET title = 'zzz_{$marker}_zzz' WHERE id = $idG");
$partial = substr($marker, 0, 12);

$res = $gameModel->searchGames($partial);
isArr($res, 'searchGames() returns an array', 'Must return array even with 0 results.');
ok(count($res) >= 1, "searchGames('$partial') finds at least 1 match",
    "0 results for '$partial'. Check: WHERE title LIKE ? with '%'.\$query.'%' binding.");
ok(in_array((string)$idG, array_map('strval', array_column($res, 'id'))),
    "searchGames() result includes game ID $idG",
    "ID $idG missing from results. Confirm the LIKE pattern binds as '%$partial%'.");

$none = $gameModel->searchGames('xXxNO_MATCH_ZZZ_99xXx');
isArr($none, 'searchGames() returns array for no-match query', '');
eq(0, count($none), 'searchGames() returns 0 results for nonsense query',
    "Got " . count($none) . " results instead of 0. LIKE clause is too broad.");

cleanup('games', [$idG]);

// ── Suite H — getGamesByCategory() ────────────────────────────────────────────
subSection('H · getGamesByCategory()');

$idH1 = makeGame('CAT1');
$idH2 = makeGame('CAT2');
$pdo->exec("UPDATE games SET category = 'Stratégie' WHERE id IN ($idH1,$idH2)");

$catRes = $gameModel->getGamesByCategory('Stratégie');
isArr($catRes, 'getGamesByCategory() returns an array', '');
ok(count($catRes) >= 2, "getGamesByCategory('Stratégie') returns >= 2 rows",
    "Expected >= 2 but got " . count($catRes) . ". Check WHERE category = ? in getGamesByCategory().");

if (!empty($catRes)) {
    eq('Stratégie', $catRes[0]['category'] ?? '', "Each row has category = 'Stratégie'",
        "Row has category '{$catRes[0]['category']}'. WHERE clause is not filtering correctly.");
}

$empty = $gameModel->getGamesByCategory('NonExistentXxx999');
isArr($empty, 'getGamesByCategory() returns array for unknown category', '');
eq(0, count($empty), 'getGamesByCategory() returns 0 for an unknown category',
    "Got " . count($empty) . " rows for an invalid category. WHERE clause is incorrect.");

cleanup('games', [$idH1, $idH2]);

// ── Suite I — getAvailableGames() ─────────────────────────────────────────────
subSection('I · getAvailableGames()');

$idIa = makeGame('AVAIL_YES');
$idIb = makeGame('AVAIL_NO');
$pdo->exec("UPDATE games SET status = 'available'   WHERE id = $idIa");
$pdo->exec("UPDATE games SET status = 'unavailable' WHERE id = $idIb");

$avail = $gameModel->getAvailableGames();
isArr($avail, 'getAvailableGames() returns an array', '');

$ids = array_map('strval', array_column($avail, 'id'));
ok(in_array((string)$idIa, $ids),  "getAvailableGames() includes ID $idIa (available)",
    "Available game $idIa missing. Check WHERE status = 'available' in getAvailableGames().");
ok(!in_array((string)$idIb, $ids), "getAvailableGames() excludes ID $idIb (unavailable)",
    "Unavailable game $idIb appeared in results. WHERE clause is too broad.");

cleanup('games', [$idIa, $idIb]);

// ── Suite J — getCategories() ─────────────────────────────────────────────────
subSection('J · getCategories()');

$cats = $gameModel->getCategories();
isArr($cats, 'getCategories() returns an array', '');

if (!empty($cats)) {
    ok(is_string($cats[0]), 'getCategories() returns flat list of strings (not nested arrays)',
        'Got arrays instead of strings. Use fetchAll(PDO::FETCH_COLUMN) not fetchAll(PDO::FETCH_ASSOC).');

    $unique = array_unique($cats);
    eq(count($unique), count($cats), 'getCategories() has no duplicate values',
        'Duplicates found. Use SELECT DISTINCT category FROM games.');

    $sorted = $unique; sort($sorted);
    eq($sorted, $cats, 'getCategories() is sorted alphabetically',
        'Not sorted. Add ORDER BY category ASC to getCategories().');
}

// ── Suite K — countGames() ────────────────────────────────────────────────────
subSection('K · countGames()');

$before = $gameModel->countGames();
isInt($before, 'countGames() returns an integer',
    'Cast fetchColumn() result to (int). GameModel::countGames() must return (int) $stmt->fetchColumn().');
atLeast(0, $before, 'countGames() >= 0', '');

$idK = makeGame('COUNT');
$after = $gameModel->countGames();
eq($before + 1, $after, "countGames() increases by 1 after an insert (was $before, now $after)",
    "Expected " . ($before + 1) . " but got $after. SELECT COUNT(*) is not reflecting the insert.");
cleanup('games', [$idK]);

// ── Suite L — countByStatus() ─────────────────────────────────────────────────
subSection('L · countByStatus()');

$idL = makeGame('STATCNT');
$pdo->exec("UPDATE games SET status = 'available' WHERE id = $idL");

$cnt = $gameModel->countByStatus('available');
isInt($cnt, "countByStatus('available') returns an integer", 'Cast fetchColumn() to (int).');
atLeast(1, $cnt, "countByStatus('available') >= 1 (just inserted)", '');

$cntU = $gameModel->countByStatus('unavailable');
isInt($cntU, "countByStatus('unavailable') returns an integer", '');
atLeast(0, $cntU, "countByStatus('unavailable') >= 0", '');

cleanup('games', [$idL]);

// ══════════════════════════════════════════════════════════════════════════════
//  R E S E R V A T I O N   M O D E L   T E S T S
// ══════════════════════════════════════════════════════════════════════════════
section('RESERVATION MODEL — App/models/ReservationModel.php');

// Shared table fixture (FK required by every reservation row)
$tblId = makeTable();

// ── Suite M — getAllReservations() ────────────────────────────────────────────
subSection('M · getAllReservations()');

$allRes = $reservationModel->getAllReservations();
isArr($allRes, 'getAllReservations() returns an array', '');

if (!empty($allRes)) {
    foreach (['table_name', 'table_capacity', 'game_title'] as $alias) {
        ok(array_key_exists($alias, $allRes[0]),
            "getAllReservations() row contains JOIN alias '$alias'",
            "Alias '$alias' missing. The JOIN must include: t.name AS table_name, t.capacity AS table_capacity, g.title AS game_title.");
    }
}

// ── Suite N — getReservationById() ────────────────────────────────────────────
subSection('N · getReservationById()');

$idN = makeReservation($tblId);

$foundR = $reservationModel->getReservationById($idN);
ok(is_array($foundR) && !empty($foundR), "getReservationById($idN) returns data",
    "getReservationById() returned empty/false. Check WHERE r.id = ? in the JOIN query.");
eq((string)$idN, (string)($foundR['id'] ?? ''), "getReservationById() returns the correct row", '');

$notFoundR = $reservationModel->getReservationById(999999999);
ok(empty($notFoundR), 'getReservationById(999999999) returns false/empty', '');

cleanup('reservations', [$idN]);

// ── Suite O — create() ────────────────────────────────────────────────────────
subSection('O · create() — insert and return ID');

$phone = '0612' . rand(100000, 999999);
$newR = [
    'client_name'   => '__TEST_CREATE_RES__',
    'client_phone'  => $phone,
    'table_id'      => $tblId,
    'game_id'       => null,
    'date'          => date('Y-m-d', strtotime('+60 days')),
    'time'          => '20:00:00',
    'players_count' => 4,
    'status'        => 'pending',
    'user_id'       => null,
];
$idO = $reservationModel->create($newR);

ok(is_int($idO) && $idO > 0, "create() returns a positive integer ID ($idO)",
    "create() must return (int) \$pdo->lastInsertId(). Got: " . var_export($idO, true) . ". Check the return statement in ReservationModel::create().");

$createdR = $reservationModel->getReservationById($idO);
eq('__TEST_CREATE_RES__',  $createdR['client_name']  ?? '', 'create() persists client_name', '');
eq($phone,                 $createdR['client_phone']  ?? '', 'create() persists client_phone', '');
eq('pending',              $createdR['status']        ?? '', 'create() defaults status to "pending"',
    "Expected 'pending' but got '{$createdR['status']}'. Check status default in INSERT VALUES.");
eq((string)$tblId,         (string)($createdR['table_id'] ?? ''), 'create() persists table_id FK', '');

cleanup('reservations', [$idO]);

// ── Suite P — update() ────────────────────────────────────────────────────────
subSection('P · update()');

$idP = makeReservation($tblId);
$updR = [
    'client_name'   => '__UPDATED_CLIENT__',
    'client_phone'  => '0699887766',
    'table_id'      => $tblId,
    'game_id'       => null,
    'date'          => date('Y-m-d', strtotime('+45 days')),
    'time'          => '21:00:00',
    'players_count' => 2,
    'status'        => 'confirmed',
];

ok($reservationModel->update($idP, $updR) === true, "update($idP) returns true",
    'ReservationModel::update() returned false. Check all 8 SET columns and verify WHERE id = ? is last.');

$rp = $reservationModel->getReservationById($idP);
eq('__UPDATED_CLIENT__', $rp['client_name']    ?? '', 'update() changes client_name', '');
eq('confirmed',          $rp['status']         ?? '', 'update() changes status to confirmed',
    "Expected 'confirmed' but got '{$rp['status']}'. Add status to UPDATE SET clause.");
eq('2',                  (string)($rp['players_count'] ?? ''), 'update() changes players_count', '');

cleanup('reservations', [$idP]);

// ── Suite Q — updateStatus() ──────────────────────────────────────────────────
subSection('Q · updateStatus() — all valid states');

$idQ = makeReservation($tblId);

foreach (['confirmed', 'canceled', 'completed', 'pending'] as $status) {
    ok($reservationModel->updateStatus($idQ, $status) === true,
        "updateStatus($idQ, '$status') returns true",
        "updateStatus() returned false for '$status'. Check UPDATE reservations SET status = ? WHERE id = ?.");
    $rq = $reservationModel->getReservationById($idQ);
    eq($status, $rq['status'] ?? '', "updateStatus() writes '$status' to DB",
        "DB shows '{$rq['status']}' not '$status'. PDO did not commit — check ERRMODE_EXCEPTION.");
}

cleanup('reservations', [$idQ]);

// ── Suite R — cancel() ────────────────────────────────────────────────────────
subSection('R · cancel()');

$idR = makeReservation($tblId);
ok($reservationModel->cancel($idR) === true, "cancel($idR) returns true",
    "cancel() must call updateStatus(id, 'canceled'). Returned false.");
eq('canceled', $reservationModel->getReservationById($idR)['status'] ?? '', "cancel() sets status to 'canceled'",
    "Expected 'canceled' — check that cancel() calls updateStatus(\$id, 'canceled') not 'cancelled' (double l).");
cleanup('reservations', [$idR]);

// ── Suite S — confirm() ───────────────────────────────────────────────────────
subSection('S · confirm()');

$idS = makeReservation($tblId);
ok($reservationModel->confirm($idS) === true, "confirm($idS) returns true",
    "confirm() must call updateStatus(id, 'confirmed'). Returned false.");
eq('confirmed', $reservationModel->getReservationById($idS)['status'] ?? '', "confirm() sets status to 'confirmed'",
    "Expected 'confirmed' — check that confirm() calls updateStatus(\$id, 'confirmed').");
cleanup('reservations', [$idS]);

// ── Suite T — delete() ────────────────────────────────────────────────────────
subSection('T · delete()');

$idT = makeReservation($tblId);
ok($reservationModel->delete($idT) === true, "delete($idT) returns true",
    'ReservationModel::delete() returned false. Check DELETE FROM reservations WHERE id = ?.');
ok(empty($reservationModel->getReservationById($idT)), "delete() removes row from DB",
    "Row $idT still exists after delete(). WHERE clause may be wrong.");

// ── Suite U — getReservationsByDate() ─────────────────────────────────────────
subSection('U · getReservationsByDate()');

$dateU  = date('Y-m-d', strtotime('+90 days'));
$dateU2 = date('Y-m-d', strtotime('+91 days'));
$idU1   = makeReservation($tblId);
$idU2   = makeReservation($tblId);
$idU3   = makeReservation($tblId); // different date
$pdo->exec("UPDATE reservations SET date = '$dateU'  WHERE id IN ($idU1,$idU2)");
$pdo->exec("UPDATE reservations SET date = '$dateU2' WHERE id = $idU3");

$byDate = $reservationModel->getReservationsByDate($dateU);
isArr($byDate, 'getReservationsByDate() returns an array', '');
ok(count($byDate) >= 2, "getReservationsByDate('$dateU') returns >= 2 rows",
    "Only " . count($byDate) . " rows. Check WHERE r.date = ? in getReservationsByDate().");

$dateIds = array_map('strval', array_column($byDate, 'id'));
ok(!in_array((string)$idU3, $dateIds), "getReservationsByDate() excludes other-date reservations",
    "ID $idU3 (date $dateU2) leaked into results for $dateU. WHERE clause is too broad.");

if (!empty($byDate)) {
    eq($dateU, $byDate[0]['date'] ?? '', "All returned rows have date = '$dateU'", '');
}

cleanup('reservations', [$idU1, $idU2, $idU3]);

// ── Suite V — getReservationsByStatus() ───────────────────────────────────────
subSection('V · getReservationsByStatus()');

$idV1 = makeReservation($tblId);
$idV2 = makeReservation($tblId);
$pdo->exec("UPDATE reservations SET status = 'pending'   WHERE id = $idV1");
$pdo->exec("UPDATE reservations SET status = 'confirmed' WHERE id = $idV2");

$pendRows = $reservationModel->getReservationsByStatus('pending');
$confRows = $reservationModel->getReservationsByStatus('confirmed');
isArr($pendRows, "getReservationsByStatus('pending') returns array", '');
isArr($confRows, "getReservationsByStatus('confirmed') returns array", '');

$pIds = array_map('strval', array_column($pendRows, 'id'));
$cIds = array_map('strval', array_column($confRows, 'id'));

ok(in_array((string)$idV1, $pIds),   "ID $idV1 (pending) appears in getByStatus('pending')",
    "Reservation $idV1 missing. Check WHERE r.status = ? in getReservationsByStatus().");
ok(!in_array((string)$idV1, $cIds),  "ID $idV1 (pending) excluded from getByStatus('confirmed')",
    "ID $idV1 leaked into confirmed results. WHERE clause is not filtering correctly.");
ok(in_array((string)$idV2, $cIds),   "ID $idV2 (confirmed) appears in getByStatus('confirmed')", '');

cleanup('reservations', [$idV1, $idV2]);

// ── Suite W — getReservationsByUserId() ───────────────────────────────────────
subSection('W · getReservationsByUserId() — client view');

$pdo->exec("INSERT INTO users (username, email, password, role)
            VALUES ('__test_res_user__', '__res@test.com__', 'hash', 'client')");
$testUid = (int) $pdo->lastInsertId();

$idW1 = makeReservation($tblId);
$idW2 = makeReservation($tblId);
$pdo->exec("UPDATE reservations SET users_id = $testUid WHERE id = $idW1");
$pdo->exec("UPDATE reservations SET users_id = NULL    WHERE id = $idW2");

$byUser = $reservationModel->getReservationsByUserId($testUid);
isArr($byUser, 'getReservationsByUserId() returns an array', '');

$uIds = array_map('strval', array_column($byUser, 'id'));
ok(in_array((string)$idW1, $uIds),   "getByUserId($testUid) includes reservation $idW1",
    "Reservation $idW1 (users_id=$testUid) not found. Check WHERE r.users_id = ? in getReservationsByUserId().");
ok(!in_array((string)$idW2, $uIds),  "getByUserId($testUid) excludes null-user reservation $idW2",
    "Reservation $idW2 (users_id=NULL) appeared. WHERE clause is too broad.");

cleanup('reservations', [$idW1, $idW2]);
$pdo->exec("DELETE FROM users WHERE id = $testUid");

// ── Suite X — search() ────────────────────────────────────────────────────────
subSection('X · search() — name & phone (admin + client)');

$uniqName  = 'SEARCHCLIENT' . uniqid();
$uniqPhone = '0633' . rand(100000, 999999);
$idX       = makeReservation($tblId);
$pdo->exec("UPDATE reservations SET client_name = '$uniqName', client_phone = '$uniqPhone' WHERE id = $idX");

// By partial name
$namePartial = substr($uniqName, 6, 10);
$byName      = $reservationModel->search($namePartial);
isArr($byName, 'search() returns array for name query', '');
ok(in_array((string)$idX, array_map('strval', array_column($byName, 'id'))),
    "search() finds reservation by partial name '$namePartial'",
    "ID $idX not found. Check WHERE r.client_name LIKE ? with '%'.\$query.'%'.");

// By partial phone
$phonePartial = substr($uniqPhone, 2, 5);
$byPhone      = $reservationModel->search($phonePartial);
isArr($byPhone, 'search() returns array for phone query', '');
ok(in_array((string)$idX, array_map('strval', array_column($byPhone, 'id'))),
    "search() finds reservation by partial phone '$phonePartial'",
    "ID $idX not found. Check WHERE r.client_phone LIKE ? is included (with OR) in search().");

$none = $reservationModel->search('xXzNO_MATCH_99zXx');
isArr($none,  'search() returns array for nonsense query', '');
eq(0, count($none), 'search() returns 0 results for nonsense query',
    "Got " . count($none) . " results instead of 0. Check both LIKE bindings.");

cleanup('reservations', [$idX]);

// ── Suite Y — countByStatus() ─────────────────────────────────────────────────
subSection('Y · countByStatus()');

$idY = makeReservation($tblId);
$pdo->exec("UPDATE reservations SET status = 'pending' WHERE id = $idY");

$pCnt = $reservationModel->countByStatus('pending');
isInt($pCnt,  "countByStatus('pending') returns int",
    "Cast fetchColumn() to (int) in ReservationModel::countByStatus().");
atLeast(1, $pCnt, "countByStatus('pending') >= 1 after insert", '');

$cCnt = $reservationModel->countByStatus('canceled');
isInt($cCnt,  "countByStatus('canceled') returns int", '');
atLeast(0, $cCnt, "countByStatus('canceled') >= 0", '');

cleanup('reservations', [$idY]);

// ── Suite Z — countByDate() ───────────────────────────────────────────────────
subSection('Z · countByDate()');

$dateZ   = date('Y-m-d', strtotime('+120 days'));
$idZ1    = makeReservation($tblId);
$idZ2    = makeReservation($tblId);
$idZcan  = makeReservation($tblId);
$pdo->exec("UPDATE reservations SET date = '$dateZ', status = 'pending'   WHERE id IN ($idZ1,$idZ2)");
$pdo->exec("UPDATE reservations SET date = '$dateZ', status = 'canceled'  WHERE id = $idZcan");

$cnt = $reservationModel->countByDate($dateZ);
isInt($cnt, "countByDate('$dateZ') returns int",
    "Cast fetchColumn() to (int) in ReservationModel::countByDate().");
atLeast(2, $cnt, "countByDate() counts >= 2 non-canceled rows for that date",
    "Expected >= 2 but got $cnt. Check AND status != 'canceled' in countByDate().");

// Canceled row must not be counted
$directCount = (int) $pdo->query(
    "SELECT COUNT(*) FROM reservations WHERE date = '$dateZ' AND status != 'canceled'"
)->fetchColumn();
eq($directCount, $cnt, "countByDate() excludes canceled reservations",
    "Got $cnt but direct SQL gives $directCount. Add AND status != 'canceled' to WHERE clause.");

cleanup('reservations', [$idZ1, $idZ2, $idZcan]);

// ── Shared table cleanup ───────────────────────────────────────────────────────
cleanup('tables', [$tblId]);

// ── Summary ────────────────────────────────────────────────────────────────────
summary();
