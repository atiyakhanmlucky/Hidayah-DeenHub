<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';
require_admin();

$page = 'admin';
$page_title = 'Admin';

$stats = [
    'tips'     => (int)db()->query('SELECT COUNT(*) FROM tips')->fetchColumn(),
    'quiz'     => (int)db()->query('SELECT COUNT(*) FROM quiz_questions')->fetchColumn(),
    'users'    => (int)db()->query('SELECT COUNT(*) FROM users')->fetchColumn(),
    'attempts' => (int)db()->query('SELECT COUNT(*) FROM quiz_attempts')->fetchColumn(),
];

include __DIR__ . '/../../includes/header.php';
?>
<h1>Admin</h1>
<p class="muted">Manage content and moderate the community.</p>

<div class="grid grid-cards" style="margin-top:20px">
    <div class="card">
        <div class="card-icon">📖</div>
        <h3>Tips</h3>
        <p class="muted">Reminders that appear on the home page and tips page.</p>
        <p><strong><?= $stats['tips'] ?></strong> total</p>
        <a class="btn btn-primary" href="<?= e(u('/admin/tips.php')) ?>">Manage Tips</a>
    </div>
    <div class="card">
        <div class="card-icon">🧠</div>
        <h3>Quiz Questions</h3>
        <p class="muted">Multiple-choice questions used in the quiz.</p>
        <p><strong><?= $stats['quiz'] ?></strong> total</p>
        <a class="btn btn-primary" href="<?= e(u('/admin/quiz.php')) ?>">Manage Questions</a>
    </div>
    <div class="card">
        <div class="card-icon">👥</div>
        <h3>Community</h3>
        <p class="muted">Registered users and quiz attempts.</p>
        <p><strong><?= $stats['users'] ?></strong> users · <strong><?= $stats['attempts'] ?></strong> quiz attempts</p>
        <a class="btn btn-ghost" href="<?= e(u('/leaderboard.php')) ?>">View leaderboard</a>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
