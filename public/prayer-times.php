<?php
require_once __DIR__ . '/../includes/auth.php';
$page = 'prayer-times';
$page_title = 'Prayer Times';
$page_scripts = ['prayer.js'];
include __DIR__ . '/../includes/header.php';
$u = current_user();
$initialCity    = $u['city']    ?? DEFAULT_CITY;
$initialCountry = $u['country'] ?? DEFAULT_COUNTRY;
?>
<section class="prayer-hero">
    <div>
        <h2 id="hero-title">Prayer Times</h2>
        <div class="prayer-meta">
            <span id="hero-date">—</span> ·
            <span id="hero-hijri">—</span> ·
            <span id="hero-location"><?= e($initialCity . ', ' . $initialCountry) ?></span>
        </div>
    </div>
    <div class="next-prayer">
        <small>Next Prayer</small>
        <strong id="next-name">—</strong>
        <span id="next-countdown">loading…</span>
    </div>
</section>

<div class="search-bar">
    <input id="city"    type="text" placeholder="City"    value="<?= e($initialCity) ?>">
    <input id="country" type="text" placeholder="Country" value="<?= e($initialCountry) ?>">
    <select id="method" title="Calculation method">
        <option value="1">University of Islamic Sciences, Karachi</option>
        <option value="2">Islamic Society of North America (ISNA)</option>
        <option value="3">Muslim World League</option>
        <option value="4">Umm Al-Qura University, Makkah</option>
        <option value="5">Egyptian General Authority of Survey</option>
        <option value="8">Gulf Region</option>
        <option value="9">Kuwait</option>
        <option value="10">Qatar</option>
        <option value="11">Majlis Ugama Islam Singapura</option>
        <option value="12">Union Organization Islamic de France</option>
        <option value="13">Diyanet İşleri Başkanlığı, Turkey</option>
        <option value="14">Spiritual Administration of Muslims of Russia</option>
    </select>
    <button class="btn btn-primary" id="refresh">Refresh</button>
</div>

<div class="prayer-grid" id="prayer-grid">
    <?php foreach (['Fajr','Sunrise','Dhuhr','Asr','Maghrib','Isha'] as $p): ?>
        <div class="prayer-cell" data-prayer="<?= e($p) ?>">
            <div class="name"><?= e($p) ?></div>
            <div class="time" data-slot="time">—</div>
        </div>
    <?php endforeach; ?>
</div>

<p class="muted" style="margin-top:18px">Data from the <a href="https://aladhan.com/prayer-times-api" target="_blank" rel="noopener">Aladhan Prayer Times API</a>, cached locally for a few hours per city.</p>
<?php include __DIR__ . '/../includes/footer.php'; ?>
