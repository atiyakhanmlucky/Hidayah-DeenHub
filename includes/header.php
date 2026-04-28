<?php
require_once __DIR__ . '/auth.php';
$user = current_user();
$page = $page ?? basename($_SERVER['SCRIPT_NAME'], '.php');
$title = isset($page_title) ? $page_title . ' · ' . APP_NAME : APP_NAME;
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title) ?></title>
    <meta name="description" content="Hidayah DeenHub — prayer times, Islamic reminders, quiz and more.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(u('/assets/css/style.css')) ?>">
    <link rel="icon" href="<?= e(u('/assets/img/favicon.svg')) ?>" type="image/svg+xml">
    <script>
        window.HDH_BASE = <?= json_encode(BASE_URL) ?>;
        (function () {
            try {
                var saved = localStorage.getItem('hdh-theme');
                if (saved === 'dark' || (!saved && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                    document.documentElement.dataset.theme = 'dark';
                }
            } catch (e) {}
        })();
    </script>
</head>
<body>
    <header class="site-header">
        <div class="container site-header__inner">
            <a class="brand" href="<?= e(u('/index.php')) ?>">
                <span class="brand__mark" aria-hidden="true">☾</span>
                <span class="brand__text">
                    <strong>Hidayah</strong>
                    <span>DeenHub</span>
                </span>
            </a>
            <nav class="site-nav" aria-label="Primary">
                <a href="<?= e(u('/index.php')) ?>" class="<?= $page === 'index' ? 'active' : '' ?>">Home</a>
                <a href="<?= e(u('/prayer-times.php')) ?>" class="<?= $page === 'prayer-times' ? 'active' : '' ?>">Prayer Times</a>
                <a href="<?= e(u('/tips.php')) ?>" class="<?= $page === 'tips' ? 'active' : '' ?>">Tips</a>
                <a href="<?= e(u('/quiz.php')) ?>" class="<?= $page === 'quiz' ? 'active' : '' ?>">Quiz</a>
                <a href="<?= e(u('/names.php')) ?>" class="<?= $page === 'names' ? 'active' : '' ?>">99 Names</a>
                <a href="<?= e(u('/qibla.php')) ?>" class="<?= $page === 'qibla' ? 'active' : '' ?>">Qibla</a>
                <a href="<?= e(u('/leaderboard.php')) ?>" class="<?= $page === 'leaderboard' ? 'active' : '' ?>">Leaderboard</a>
            </nav>
            <div class="site-actions">
                <button id="theme-toggle" class="icon-btn" aria-label="Toggle dark mode" title="Toggle dark mode">
                    <span class="icon-sun" aria-hidden="true">☀</span>
                    <span class="icon-moon" aria-hidden="true">☾</span>
                </button>
                <?php if ($user): ?>
                    <div class="user-chip">
                        <span><?= e($user['username']) ?></span>
                        <?php if ((int)$user['is_admin']): ?>
                            <a class="chip-link" href="<?= e(u('/admin/index.php')) ?>">Admin</a>
                        <?php endif; ?>
                        <a class="chip-link" href="<?= e(u('/logout.php')) ?>">Logout</a>
                    </div>
                <?php else: ?>
                    <a class="btn btn-ghost" href="<?= e(u('/login.php')) ?>">Login</a>
                    <a class="btn btn-primary" href="<?= e(u('/register.php')) ?>">Sign up</a>
                <?php endif; ?>
            </div>
            <button class="nav-toggle" id="nav-toggle" aria-label="Open menu" aria-expanded="false">☰</button>
        </div>
    </header>
    <main class="site-main container">
