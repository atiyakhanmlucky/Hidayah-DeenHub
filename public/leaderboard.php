<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
$page = 'leaderboard';
$page_title = 'Quiz Leaderboard';
include __DIR__ . '/../includes/header.php';

$stmt = db()->query('SELECT id, display_name, score, total_questions, duration_sec, created_at
                     FROM quiz_attempts ORDER BY score DESC, duration_sec ASC, id ASC LIMIT 50');
$rows = $stmt->fetchAll();
$me = current_user();
?>
<div class="row space-between" style="margin-bottom:16px">
    <div>
        <h1 style="margin:0">🏆 Quiz Leaderboard</h1>
        <p class="muted" style="margin:4px 0 0">Top 50 quiz attempts — ranked by score, then fastest time.</p>
    </div>
    <a class="btn btn-primary" href="<?= e(u('/quiz.php')) ?>">Take the Quiz</a>
</div>

<?php if (!$rows): ?>
    <div class="card"><p class="muted">No attempts yet. Be the first!</p></div>
<?php else: ?>
<div class="table-wrap">
    <table>
        <thead>
            <tr><th>#</th><th>Name</th><th>Score</th><th>Time</th><th>Date</th></tr>
        </thead>
        <tbody>
        <?php foreach ($rows as $i => $r):
            $rank = $i + 1;
            $isMe = $me && mb_strtolower($r['display_name']) === mb_strtolower($me['username']);
        ?>
            <tr class="<?= $isMe ? 'you' : '' ?>">
                <td><span class="rank-badge rank-<?= $rank <= 3 ? $rank : 'x' ?>"><?= $rank ?></span></td>
                <td><?= e($r['display_name']) ?><?= $isMe ? ' <span class="tag">you</span>' : '' ?></td>
                <td><?= (int)$r['score'] ?>/<?= (int)$r['total_questions'] ?></td>
                <td><?= gmdate('i:s', (int)$r['duration_sec']) ?></td>
                <td><?= e(date('M j, Y', strtotime($r['created_at']))) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
<?php include __DIR__ . '/../includes/footer.php'; ?>
