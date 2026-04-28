<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
$page = 'names';
$page_title = '99 Names of Allah';
include __DIR__ . '/../includes/header.php';

$q = trim((string)($_GET['q'] ?? ''));
$sql = 'SELECT position, arabic, transliteration, meaning FROM names_of_allah';
$params = [];
if ($q !== '') {
    $sql .= ' WHERE transliteration LIKE ? OR meaning LIKE ?';
    $params[] = '%' . $q . '%';
    $params[] = '%' . $q . '%';
}
$sql .= ' ORDER BY position';
$stmt = db()->prepare($sql);
$stmt->execute($params);
$names = $stmt->fetchAll();
?>
<div class="row space-between" style="margin-bottom:20px">
    <div>
        <h1 style="margin:0">✨ 99 Names of Allah</h1>
        <p class="muted" style="margin:4px 0 0">Asma-ul-Husna — "The most beautiful names belong to Allah, so call upon Him by them." (Quran 7:180)</p>
    </div>
    <form method="get" class="row">
        <input type="text" name="q" value="<?= e($q) ?>" placeholder="Search name or meaning" style="padding:10px 14px;border-radius:10px;border:1px solid var(--border);background:var(--bg-elev);color:var(--text)">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
</div>

<?php if (!$names): ?>
    <div class="card"><p class="muted">No names matched "<?= e($q) ?>".</p></div>
<?php else: ?>
<div class="names-grid">
    <?php foreach ($names as $n): ?>
        <div class="name-card">
            <div class="pos"><?= (int)$n['position'] ?></div>
            <div class="arabic"><?= e($n['arabic']) ?></div>
            <div class="trans"><?= e($n['transliteration']) ?></div>
            <div class="meaning"><?= e($n['meaning']) ?></div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>
