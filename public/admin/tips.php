<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';
require_admin();

$page = 'admin';
$page_title = 'Manage Tips';
$message = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? '')) {
        $error = 'Session expired. Please try again.';
    } else {
        $action = $_POST['action'] ?? '';
        try {
            if ($action === 'create') {
                $stmt = db()->prepare('INSERT INTO tips (title, body, reference, category, is_active) VALUES (?, ?, ?, ?, 1)');
                $stmt->execute([
                    trim((string)$_POST['title']),
                    trim((string)$_POST['body']),
                    trim((string)$_POST['reference']) ?: null,
                    trim((string)$_POST['category']) ?: 'general',
                ]);
                $message = 'Tip added.';
            } elseif ($action === 'toggle') {
                $id = (int)$_POST['id'];
                db()->prepare('UPDATE tips SET is_active = 1 - is_active WHERE id = ?')->execute([$id]);
                $message = 'Visibility updated.';
            } elseif ($action === 'delete') {
                $id = (int)$_POST['id'];
                db()->prepare('DELETE FROM tips WHERE id = ?')->execute([$id]);
                $message = 'Tip deleted.';
            }
        } catch (Throwable $e) {
            $error = APP_DEBUG ? $e->getMessage() : 'Action failed.';
        }
    }
}

$tips = db()->query('SELECT * FROM tips ORDER BY id DESC')->fetchAll();
include __DIR__ . '/../../includes/header.php';
?>
<h1>Manage Tips</h1>
<p class="muted">Add, toggle or delete reminders shown across the app.</p>

<?php if ($message): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

<div class="grid grid-2" style="margin-top:18px">
    <form method="post" class="form" style="max-width:none">
        <h2 style="margin-top:0">Add a tip</h2>
        <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
        <input type="hidden" name="action" value="create">
        <div class="field"><label>Title</label><input name="title" required></div>
        <div class="field"><label>Body</label><textarea name="body" rows="4" required></textarea></div>
        <div class="row">
            <div class="field" style="flex:2"><label>Reference</label><input name="reference" placeholder="e.g. Sahih al-Bukhari 6018"></div>
            <div class="field" style="flex:1"><label>Category</label><input name="category" placeholder="general" value="general"></div>
        </div>
        <button class="btn btn-primary" type="submit">Save tip</button>
    </form>

    <div class="card" style="overflow-x:auto">
        <h2 style="margin-top:0">Existing tips</h2>
        <table>
            <thead><tr><th>#</th><th>Title</th><th>Category</th><th>Active</th><th></th></tr></thead>
            <tbody>
            <?php foreach ($tips as $t): ?>
                <tr>
                    <td><?= (int)$t['id'] ?></td>
                    <td><?= e($t['title']) ?></td>
                    <td><?= e($t['category']) ?></td>
                    <td><?= $t['is_active'] ? 'Yes' : '<span class="muted">No</span>' ?></td>
                    <td class="row">
                        <form method="post" style="display:inline">
                            <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="toggle">
                            <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                            <button class="btn btn-ghost" type="submit">Toggle</button>
                        </form>
                        <form method="post" style="display:inline" onsubmit="return confirm('Delete this tip?')">
                            <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                            <button class="btn btn-ghost" type="submit" style="color:var(--danger)">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
