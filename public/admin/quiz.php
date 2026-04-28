<?php
require_once __DIR__ . '/../../includes/auth.php';
require_once __DIR__ . '/../../includes/db.php';
require_admin();

$page = 'admin';
$page_title = 'Manage Quiz';
$message = null;
$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? '')) {
        $error = 'Session expired. Please try again.';
    } else {
        $action = $_POST['action'] ?? '';
        try {
            if ($action === 'create') {
                $correct = strtoupper(trim((string)$_POST['correct_option']));
                if (!in_array($correct, ['A', 'B', 'C', 'D'], true)) {
                    throw new RuntimeException('Correct option must be A, B, C, or D.');
                }
                $stmt = db()->prepare('INSERT INTO quiz_questions
                    (question, option_a, option_b, option_c, option_d, correct_option, explanation, difficulty, is_active)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 1)');
                $stmt->execute([
                    trim((string)$_POST['question']),
                    trim((string)$_POST['option_a']),
                    trim((string)$_POST['option_b']),
                    trim((string)$_POST['option_c']),
                    trim((string)$_POST['option_d']),
                    $correct,
                    trim((string)$_POST['explanation']) ?: null,
                    in_array($_POST['difficulty'] ?? 'easy', ['easy','medium','hard'], true) ? $_POST['difficulty'] : 'easy',
                ]);
                $message = 'Question added.';
            } elseif ($action === 'toggle') {
                db()->prepare('UPDATE quiz_questions SET is_active = 1 - is_active WHERE id = ?')
                    ->execute([(int)$_POST['id']]);
                $message = 'Visibility updated.';
            } elseif ($action === 'delete') {
                db()->prepare('DELETE FROM quiz_questions WHERE id = ?')->execute([(int)$_POST['id']]);
                $message = 'Question deleted.';
            }
        } catch (Throwable $e) {
            $error = $e->getMessage();
        }
    }
}

$questions = db()->query('SELECT * FROM quiz_questions ORDER BY id DESC')->fetchAll();
include __DIR__ . '/../../includes/header.php';
?>
<h1>Manage Quiz Questions</h1>
<p class="muted">Keep the mini-quiz fresh — add, toggle or remove questions.</p>

<?php if ($message): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
<?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>

<form method="post" class="form" style="max-width:none;margin-top:18px">
    <h2 style="margin-top:0">Add a question</h2>
    <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
    <input type="hidden" name="action" value="create">
    <div class="field"><label>Question</label><textarea name="question" rows="2" required></textarea></div>
    <div class="row">
        <div class="field" style="flex:1"><label>Option A</label><input name="option_a" required></div>
        <div class="field" style="flex:1"><label>Option B</label><input name="option_b" required></div>
    </div>
    <div class="row">
        <div class="field" style="flex:1"><label>Option C</label><input name="option_c" required></div>
        <div class="field" style="flex:1"><label>Option D</label><input name="option_d" required></div>
    </div>
    <div class="row">
        <div class="field" style="flex:1"><label>Correct option (A-D)</label><input name="correct_option" required maxlength="1" placeholder="A"></div>
        <div class="field" style="flex:1"><label>Difficulty</label>
            <select name="difficulty"><option value="easy">easy</option><option value="medium">medium</option><option value="hard">hard</option></select>
        </div>
    </div>
    <div class="field"><label>Explanation (optional)</label><textarea name="explanation" rows="2"></textarea></div>
    <button class="btn btn-primary" type="submit">Save question</button>
</form>

<h2 class="section-title">Existing questions (<?= count($questions) ?>)</h2>
<div class="table-wrap">
<table>
    <thead><tr><th>#</th><th>Question</th><th>Correct</th><th>Difficulty</th><th>Active</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($questions as $q): ?>
        <tr>
            <td><?= (int)$q['id'] ?></td>
            <td><?= e($q['question']) ?></td>
            <td><strong><?= e($q['correct_option']) ?></strong></td>
            <td><?= e($q['difficulty']) ?></td>
            <td><?= $q['is_active'] ? 'Yes' : '<span class="muted">No</span>' ?></td>
            <td class="row">
                <form method="post" style="display:inline">
                    <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?= (int)$q['id'] ?>">
                    <button class="btn btn-ghost" type="submit">Toggle</button>
                </form>
                <form method="post" style="display:inline" onsubmit="return confirm('Delete this question?')">
                    <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="id" value="<?= (int)$q['id'] ?>">
                    <button class="btn btn-ghost" type="submit" style="color:var(--danger)">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
</div>
<?php include __DIR__ . '/../../includes/footer.php'; ?>
