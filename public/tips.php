<?php
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/auth.php';
$page = 'tips';
$page_title = 'Islamic Tips';

$category = isset($_GET['category']) ? trim((string)$_GET['category']) : '';
$sql = 'SELECT id, title, body, reference, category FROM tips WHERE is_active = 1';
$params = [];
if ($category !== '') { $sql .= ' AND category = ?'; $params[] = $category; }
$sql .= ' ORDER BY created_at DESC';
$stmt = db()->prepare($sql);
$stmt->execute($params);
$tips = $stmt->fetchAll();

$cats = db()->query('SELECT DISTINCT category FROM tips WHERE is_active = 1 ORDER BY category')->fetchAll(PDO::FETCH_COLUMN);

include __DIR__ . '/../includes/header.php';
?>
<div class="row space-between" style="margin-bottom:20px">
    <div>
        <h1 style="margin:0">Islamic Tips &amp; Reminders</h1>
        <p class="muted" style="margin:4px 0 0">Curated from the Quran and authentic hadith.</p>
    </div>
    <form method="get" class="row">
        <select name="category" onchange="this.form.submit()" style="padding:10px 14px;border-radius:10px;border:1px solid var(--border);background:var(--bg-elev);color:var(--text)">
            <option value="">All categories</option>
            <?php foreach ($cats as $c): ?>
                <option value="<?= e($c) ?>" <?= $c === $category ? 'selected' : '' ?>><?= e(ucfirst($c)) ?></option>
            <?php endforeach; ?>
        </select>
    </form>
</div>

<?php if (!$tips): ?>
    <div class="card"><p class="muted">No tips found in this category yet.</p></div>
<?php else: ?>
    <div class="grid grid-cards">
        <?php foreach ($tips as $t): ?>
            <article class="card">
                <span class="card-tag"><?= e($t['category']) ?></span>
                <h3><?= e($t['title']) ?></h3>
                <p><?= nl2br(e($t['body'])) ?></p>
                <?php if (!empty($t['reference'])): ?>
                    <p class="muted" style="margin-bottom:0"><em>Source:</em> <?= e($t['reference']) ?></p>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>
