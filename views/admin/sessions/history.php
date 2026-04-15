<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<div class="container">
    <h1>Historique des Sessions</h1>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Date début</th>
                <th>Date fin</th>
                <th>Durée (min)</th>
                <th>Table</th>
                <th>Jeu</th>
                <th>Catégorie</th>
                <th>Joueurs</th>
                <th>Client</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($history)): ?>
                <tr>
                    <td colspan="10" style="text-align: center;">Aucune session terminée.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($history as $session): ?>
                    <tr>
                        <td>#<?= htmlspecialchars($session['id']) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($session['start_time']))) ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y H:i', strtotime($session['end_time']))) ?></td>
                        <td><?= htmlspecialchars($session['duration_minutes'] ?? '-') ?></td>
                        <td>Table <?= htmlspecialchars($session['table_number']) ?></td>
                        <td><?= htmlspecialchars($session['game_title']) ?></td>
                        <td><?= htmlspecialchars($session['category']) ?></td>
                        <td><?= htmlspecialchars($session['players_count']) ?></td>
                        <td><?= htmlspecialchars($session['username']) ?></td>
                        <td><span class="badge badge-success">Terminée</span></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="/dashboard" class="btn">← Retour au tableau de bord</a>
</div>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>