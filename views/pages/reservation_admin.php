<?php
require_once __DIR__ . '/../../config/init.php';
use App\Models\ReservationModel;

$reservationModel = new ReservationModel();
$reservations = $reservationModel->getAllReservations();
$totalCount = count($reservations);

// Get counts by status
$pendingCount = 0;
$confirmedCount = 0;
$canceledCount = 0;

foreach ($reservations as $res) {
    switch ($res['status']) {
        case 'pending': $pendingCount++; break;
        case 'confirmed': $confirmedCount++; break;
        case 'canceled':
        case 'cancelled': $canceledCount++; break;
    }
}

// Filter by status if set
$filter = $_GET['filter'] ?? 'all';
$search = $_GET['query'] ?? '';

if (!empty($search)) {
    $reservations = $reservationModel->search($search);
}

if ($filter !== 'all') {
    $filtered = [];
    foreach ($reservations as $res) {
        if ($res['status'] === $filter) {
            $filtered[] = $res;
        }
    }
    $reservations = $filtered;
}
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Admin Reservations | The Curated Playroom</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="<?= URL_ROOT ?>/public/style/tailwind-config.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= URL_ROOT ?>/public/style/style.css">
</head>

<body class="bg-surface text-on-surface font-body selection:bg-primary selection:text-on-primary">
    <?php include __DIR__ . '/../includes/side_menu.php'; ?>
    <main class="lg:ml-64 admin-main min-h-screen p-8 bg-surface">
        <header class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-10">
            <div class="flex items-center gap-4">
                <button id="menu-toggle" class="lg:hidden text-on-surface-variant flex items-center justify-center p-2 rounded-lg bg-surface-container-low border border-white/5">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <div>
                    <h2 class="text-4xl font-headline font-extrabold tracking-tighter text-on-surface">Reservations</h2>
                    <p class="text-on-surface-variant font-body mt-1">Managing <?= $totalCount ?> bookings</p>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-surface-container-low p-1 rounded-xl">
                <a href="<?= URL_ROOT ?>/reservations">
                    <button class="px-4 py-2 rounded-lg font-medium transition-colors <?= $filter === 'all' ? 'bg-surface-container-highest text-on-surface shadow-sm' : 'text-on-surface-variant hover:text-on-surface' ?>">List View</button>
                </a>
            </div>
        </header>
        
        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-2">
                <a href="<?= URL_ROOT ?>/reservations?filter=all">
                    <button class="px-4 py-2 rounded-full text-sm font-semibold transition-colors <?= $filter === 'all' ? 'bg-primary text-on-primary shadow-lg shadow-primary/20' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-bright border border-outline-variant/10' ?>">
                        All (<?= $totalCount ?>)
                    </button>
                </a>
                <a href="<?= URL_ROOT ?>/reservations?filter=confirmed">
                    <button class="px-4 py-2 rounded-full text-sm font-semibold transition-colors <?= $filter === 'confirmed' ? 'bg-secondary text-on-secondary font-bold' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-bright border border-outline-variant/10' ?>">
                        Confirmed (<?= $confirmedCount ?>)
                    </button>
                </a>
                <a href="<?= URL_ROOT ?>/reservations?filter=pending">
                    <button class="px-4 py-2 rounded-full text-sm font-semibold transition-colors <?= $filter === 'pending' ? 'bg-primary text-on-primary shadow-lg shadow-primary/20' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-bright border border-outline-variant/10' ?>">
                        Pending (<?= $pendingCount ?>)
                    </button>
                </a>
                <a href="<?= URL_ROOT ?>/reservations?filter=canceled">
                    <button class="px-4 py-2 rounded-full text-sm font-semibold transition-colors <?= $filter === 'canceled' ? 'bg-error text-on-error' : 'bg-surface-container-high text-on-surface-variant hover:bg-surface-bright border border-outline-variant/10' ?>">
                        Canceled (<?= $canceledCount ?>)
                    </button>
                </a>
            </div>
            <form method="GET" action="<?= URL_ROOT ?>/reservations" class="relative min-w-[300px]">
                <?php if ($filter !== 'all'): ?>
                <input type="hidden" name="filter" value="<?= htmlspecialchars($filter) ?>">
                <?php endif; ?>
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">search</span>
                <input class="w-full pl-10 pr-4 py-2.5 bg-surface-container-highest border border-outline-variant/15 rounded-xl focus:ring-2 focus:ring-primary focus:outline-none transition-all placeholder:text-on-surface-variant/50 text-on-surface" name="query" placeholder="Search guest or game..." type="text" value="<?= htmlspecialchars($search) ?>" />
            </form>
        </div>
        
        <div class="bg-surface-container-low rounded-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container text-on-surface-variant text-xs uppercase tracking-widest font-bold">
                            <th class="px-6 py-5">Date & Time</th>
                            <th class="px-6 py-5">Guest</th>
                            <th class="px-6 py-5">Phone</th>
                            <th class="px-6 py-5">Table</th>
                            <th class="px-6 py-5">Size</th>
                            <th class="px-6 py-5">Game</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/5">
                        <?php foreach ($reservations as $res): ?>
                        <?php
                            $statusClass = match($res['status']) {
                                'confirmed' => 'bg-secondary-container text-on-secondary-container',
                                'pending' => 'bg-primary-container text-on-primary-container',
                                'canceled', 'cancelled' => 'bg-error-container text-on-error',
                                'completed' => 'bg-surface-container-high text-on-surface-variant',
                                default => 'bg-surface-container-high text-on-surface-variant'
                            };
                            $statusDot = match($res['status']) {
                                'confirmed' => 'bg-secondary',
                                'pending' => 'bg-primary animate-pulse',
                                'canceled', 'cancelled' => 'bg-error',
                                default => 'bg-on-surface-variant'
                            };
                        ?>
                        <tr class="hover:bg-surface-container-high/50 transition-colors group">
                            <td class="px-6 py-5">
                                <div class="flex flex-col">
                                    <span class="text-on-surface font-bold"><?= date('M d, Y', strtotime($res['date'])) ?></span>
                                    <span class="text-xs text-on-surface-variant"><?= date('H:i', strtotime($res['time'])) ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-surface-bright flex items-center justify-center border border-outline-variant/20">
                                        <span class="text-xs font-bold text-secondary"><?= strtoupper(substr($res['client_name'] ?? 'GU', 0, 2)) ?></span>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-on-surface font-semibold"><?= htmlspecialchars($res['client_name'] ?? 'Guest') ?></span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-on-surface-variant text-sm"><?= htmlspecialchars($res['client_phone'] ?? '-') ?></span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-on-surface-variant text-lg">table_restaurant</span>
                                    <span class="text-on-surface">Table <?= $res['table_id'] ?? '-' ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="px-2 py-1 rounded bg-surface-container-highest text-on-surface text-sm font-medium"><?= $res['players_count'] ?? 4 ?> People</span>
                            </td>
                            <td class="px-6 py-5">
                                <div class="flex items-center gap-2">
                                    <span class="material-symbols-outlined text-primary text-lg">casino</span>
                                    <span class="text-on-surface"><?= htmlspecialchars($res['game_title'] ?? '-') ?></span>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-bold <?= $statusClass ?>">
                                    <span class="w-1.5 h-1.5 rounded-full <?= $statusDot ?>"></span>
                                    <?= ucfirst($res['status'] ?? 'Unknown') ?>
                                </span>
                            </td>
                            <td class="px-6 py-5 text-right">
                                <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <?php if ($res['status'] === 'pending'): ?>
                                    <form action="<?= URL_ROOT ?>/reservations/confirm/<?= $res['id'] ?>" method="POST" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCSRFToken() ?>">
                                        <button type="submit" class="p-2 rounded-lg hover:bg-secondary-container text-on-surface-variant hover:text-secondary transition-colors" title="Confirm">
                                            <span class="material-symbols-outlined">check_circle</span>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                    <?php if ($res['status'] !== 'canceled' && $res['status'] !== 'cancelled'): ?>
                                    <form action="<?= URL_ROOT ?>/reservations/cancel/<?= $res['id'] ?>" method="POST" class="inline">
                                        <input type="hidden" name="csrf_token" value="<?= \App\Core\Security::generateCSRFToken() ?>">
                                        <button type="submit" class="p-2 rounded-lg hover:bg-error-container text-on-surface-variant hover:text-error transition-colors" title="Cancel">
                                            <span class="material-symbols-outlined">cancel</span>
                                        </button>
                                    </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        
                        <?php if (empty($reservations)): ?>
                        <tr>
                            <td colspan="8" class="px-6 py-12 text-center">
                                <span class="material-symbols-outlined text-5xl text-on-surface-variant mb-4">event_busy</span>
                                <p class="text-on-surface-variant text-lg">No reservations found</p>
                                <p class="text-on-surface-variant text-sm mt-1">Try adjusting your filters</p>
                            </td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="p-6 bg-surface-container-low border-t border-outline-variant/5 flex items-center justify-between">
                <span class="text-sm text-on-surface-variant font-medium">Showing <?= count($reservations) ?> of <?= $totalCount ?> reservations</span>
            </div>
        </div>
    </main>
    <?php include __DIR__ . '/../includes/footer.php'; ?>
</body>

</html>
