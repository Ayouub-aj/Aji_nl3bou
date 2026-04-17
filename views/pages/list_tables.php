<?php
require_once __DIR__ . '/../../config/init.php';
use App\Models\TableModel;

$tableModel = new TableModel();
$tables = $tableModel->getAllTables();
?>
<!DOCTYPE html>

<html class="dark" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Tables | The Curated Playroom</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script src="/dashboard/Aji_nl3bou/public/style/tailwind-config.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="/dashboard/Aji_nl3bou/public/style/style.css">
</head>

<body class="bg-surface text-on-surface flex min-h-screen">
    <?php include __DIR__ . '/../includes/side_menu.php'; ?>
    
    <main class="lg:ml-64 flex-1 flex flex-col min-h-screen">
        <header class="sticky top-0 z-30 bg-[#0e0e0e]/80 backdrop-blur-xl px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight font-headline text-on-surface">Tables</h2>
                    <p class="text-on-surface-variant text-sm">Manage game tables and capacity</p>
                </div>
            </div>
        </header>

        <section class="p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($tables as $table): ?>
                <?php
                    $statusColor = match($table['status']) {
                        'free', 'available' => 'bg-tertiary-container text-on-tertiary-container',
                        'reserved' => 'bg-primary-container text-on-primary-container',
                        'occupied' => 'bg-secondary-container text-on-secondary-container',
                        default => 'bg-surface-container-high text-on-surface-variant'
                    };
                    $statusIcon = match($table['status']) {
                        'free', 'available' => 'check_circle',
                        'reserved' => 'schedule',
                        'occupied' => 'groups',
                        default => 'help'
                    };
                ?>
                <div class="bg-surface-container-low rounded-xl p-6 border border-outline-variant/10">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold text-on-surface">Table <?= $table['number'] ?></h3>
                        <span class="material-symbols-outlined text-2xl text-on-surface-variant">table_restaurant</span>
                    </div>
                    
                    <?php if (!empty($table['name'])): ?>
                    <p class="text-sm text-on-surface-variant mb-4"><?= htmlspecialchars($table['name']) ?></p>
                    <?php endif; ?>
                    
                    <div class="flex items-center gap-2 mb-4">
                        <span class="material-symbols-outlined text-on-surface-variant">groups</span>
                        <span class="text-on-surface"><?= $table['capacity'] ?> seats</span>
                    </div>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="px-3 py-1 rounded-full text-xs font-bold <?= $statusColor ?>">
                            <span class="material-symbols-outlined text-sm align-middle mr-1"><?= $statusIcon ?></span>
                            <?= ucfirst($table['status']) ?>
                        </span>
                    </div>

                    <!-- Status Update Form -->
                    <form action="/dashboard/Aji_nl3bou/tables/update-status/<?= $table['id'] ?>" method="POST" class="flex gap-2">
                        <select name="status" class="flex-1 bg-surface-container-highest border border-outline-variant/15 rounded-lg px-3 py-2 text-sm text-on-surface focus:ring-2 focus:ring-primary/50 outline-none">
                            <option value="available" <?= ($table['status'] ?? '') === 'available' ? 'selected' : '' ?>>Available</option>
                            <option value="free" <?= ($table['status'] ?? '') === 'free' ? 'selected' : '' ?>>Free</option>
                            <option value="reserved" <?= ($table['status'] ?? '') === 'reserved' ? 'selected' : '' ?>>Reserved</option>
                            <option value="occupied" <?= ($table['status'] ?? '') === 'occupied' ? 'selected' : '' ?>>Occupied</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-primary text-on-primary rounded-lg font-bold text-sm hover:bg-primary-dim transition-colors">
                            Update
                        </button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($tables)): ?>
            <div class="text-center py-12">
                <span class="material-symbols-outlined text-6xl text-on-surface-variant mb-4">table_restaurant</span>
                <p class="text-on-surface-variant text-lg">No tables found</p>
            </div>
            <?php endif; ?>
        </section>
    </main>
</body>

</html>
