<?php
require_once __DIR__ . '/../includes/auth.php';
$page = 'quiz';
$page_title = 'Islamic Mini Quiz';
$page_scripts = ['quiz.js'];
include __DIR__ . '/../includes/header.php';
$u = current_user();
?>
<div class="quiz-wrap">
    <div class="row space-between" style="margin-bottom:12px">
        <h1 style="margin:0">Mini Islamic Quiz</h1>
        <span class="muted" id="quiz-meta">—</span>
    </div>
    <p class="muted">Ten random questions. Pick the best answer; you'll see the correct one immediately with a short explanation.</p>

    <div class="quiz-progress" aria-hidden="true"><span id="quiz-progress-bar" style="width:0%"></span></div>

    <div id="quiz-loading" class="card"><p class="muted">Loading questions…</p></div>

    <div id="quiz-stage" class="quiz-card hide">
        <div class="quiz-footer" style="margin-bottom:10px"><span id="q-counter">Question 1 of 10</span><span id="q-timer">00:00</span></div>
        <h2 id="q-text"></h2>
        <div class="quiz-options" id="q-options"></div>
        <div class="quiz-explanation hide" id="q-expl"></div>
        <div class="quiz-footer">
            <span id="q-score">Score: 0</span>
            <button class="btn btn-primary" id="q-next" disabled>Next →</button>
        </div>
    </div>

    <div id="quiz-result" class="quiz-result card hide">
        <div class="score-ring" id="score-ring"><span id="score-text">0/0</span></div>
        <h2 id="result-title">Jazakallahu khayran!</h2>
        <p class="muted" id="result-sub">You've completed the quiz.</p>
        <form id="save-score-form" class="row" style="justify-content:center;margin-top:14px" <?= $u ? '' : '' ?>>
            <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
            <?php if (!$u): ?>
                <input type="text" name="display_name" placeholder="Your name for the leaderboard" maxlength="40" required style="padding:10px 14px;border-radius:10px;border:1px solid var(--border);background:var(--bg-elev);color:var(--text)">
            <?php endif; ?>
            <button class="btn btn-primary" type="submit">Save to leaderboard</button>
            <button class="btn btn-ghost" type="button" id="play-again">Play again</button>
        </form>
        <p class="muted" id="save-msg" style="margin-top:14px"></p>
    </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
