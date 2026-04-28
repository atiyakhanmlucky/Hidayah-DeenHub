<?php
require_once __DIR__ . '/../includes/auth.php';
$page = 'qibla';
$page_title = 'Qibla Finder';
$page_scripts = ['qibla.js'];
include __DIR__ . '/../includes/header.php';
?>
<div class="qibla-wrap">
    <h1>🧭 Qibla Finder</h1>
    <p class="muted">Find the bearing to the Kaaba (Makkah, Saudi Arabia) from your current location. Requires your browser's location permission.</p>

    <div class="compass" id="compass">
        <div class="needle" id="needle"></div>
        <div class="center-dot"></div>
    </div>

    <div class="card" style="text-align:left">
        <div class="row space-between">
            <div><strong>Your location:</strong> <span id="loc">—</span></div>
            <div><strong>Qibla bearing:</strong> <span id="bearing">—</span></div>
        </div>
        <p class="muted" style="margin:12px 0 0">Rotate your device to align the <strong>☪</strong> on the needle with north (N) on a physical compass — it points toward Makkah from your position.</p>
    </div>

    <div id="qibla-err" class="alert alert-error hide" style="margin-top:16px"></div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
