<?php
require_once __DIR__ . '/../includes/auth.php';
$page = 'index';
$page_title = 'Home';
$page_scripts = ['home.js'];
include __DIR__ . '/../includes/header.php';
?>
<section class="hero">
    <h1>Assalamu Alaikum<?= $user ? ', ' . e($user['username']) : '' ?> 🌙</h1>
    <p>Your daily Islamic companion — accurate prayer times, reminders from the Quran &amp; Sunnah, an interactive quiz and more. All in one clean, dark-mode friendly place.</p>
    <div class="hero-cta">
        <a class="btn btn-accent" href="<?= e(u('/prayer-times.php')) ?>">View Prayer Times</a>
        <a class="btn btn-ghost" href="<?= e(u('/quiz.php')) ?>" style="color:#fff;border-color:rgba(255,255,255,0.4)">Take the Quiz</a>
    </div>
    <div class="hero-stats">
        <div class="stat"><strong id="stat-next">—</strong><span>Next prayer</span></div>
        <div class="stat"><strong id="stat-hijri">—</strong><span>Hijri date</span></div>
        <div class="stat"><strong id="stat-city">—</strong><span>Location</span></div>
    </div>
</section>

<h2 class="section-title">Today's Reminder</h2>
<div class="card" id="tip-card">
    <span class="card-tag" id="tip-category">tip</span>
    <h3 id="tip-title"><span class="skeleton" style="width:60%"></span></h3>
    <p id="tip-body"><span class="skeleton" style="width:100%"></span><br><span class="skeleton" style="width:85%"></span></p>
    <p class="muted" id="tip-ref"></p>
    <button class="btn btn-ghost" id="new-tip">Another reminder</button>
</div>

<h2 class="section-title">Explore</h2>
<div class="grid grid-cards">
    <a class="card" href="<?= e(u('/prayer-times.php')) ?>">
        <div class="card-icon">🕌</div>
        <h3>Prayer Times</h3>
        <p class="muted">Accurate daily salah times for any city, with the next prayer countdown and Hijri date.</p>
    </a>
    <a class="card" href="<?= e(u('/tips.php')) ?>">
        <div class="card-icon">📖</div>
        <h3>Islamic Tips</h3>
        <p class="muted">Curated reminders from the Quran and authentic hadith — by category.</p>
    </a>
    <a class="card" href="<?= e(u('/quiz.php')) ?>">
        <div class="card-icon">🧠</div>
        <h3>Mini Quiz</h3>
        <p class="muted">Test and sharpen your Islamic knowledge. Earn a spot on the leaderboard.</p>
    </a>
    <a class="card" href="<?= e(u('/names.php')) ?>">
        <div class="card-icon">✨</div>
        <h3>99 Names of Allah</h3>
        <p class="muted">The Asma-ul-Husna — beautiful names with transliteration and meanings.</p>
    </a>
    <a class="card" href="<?= e(u('/qibla.php')) ?>">
        <div class="card-icon">🧭</div>
        <h3>Qibla Finder</h3>
        <p class="muted">Find the direction of the Kaaba from your current location.</p>
    </a>
    <a class="card" href="<?= e(u('/leaderboard.php')) ?>">
        <div class="card-icon">🏆</div>
        <h3>Leaderboard</h3>
        <p class="muted">See top quiz scores and compete with other members of the community.</p>
    </a>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
