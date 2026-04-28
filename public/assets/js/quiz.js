(function () {
    'use strict';

    var loadingEl = document.getElementById('quiz-loading');
    var stageEl   = document.getElementById('quiz-stage');
    var resultEl  = document.getElementById('quiz-result');

    var qCounter  = document.getElementById('q-counter');
    var qText     = document.getElementById('q-text');
    var qOptions  = document.getElementById('q-options');
    var qExpl     = document.getElementById('q-expl');
    var qScore    = document.getElementById('q-score');
    var qTimer    = document.getElementById('q-timer');
    var qNext     = document.getElementById('q-next');
    var progress  = document.getElementById('quiz-progress-bar');
    var scoreRing = document.getElementById('score-ring');
    var scoreText = document.getElementById('score-text');
    var resultTitle = document.getElementById('result-title');
    var resultSub   = document.getElementById('result-sub');
    var saveMsg   = document.getElementById('save-msg');

    var state = { questions: [], idx: 0, score: 0, startedAt: 0, answered: false, timer: null };

    function fetchQuestions() {
        HDH.fetchJSON('/api/quiz.php?count=10')
            .then(function (data) {
                if (!data.questions || !data.questions.length) { loadingEl.textContent = 'No questions available yet.'; return; }
                state.questions = data.questions;
                state.idx = 0; state.score = 0; state.startedAt = Date.now();
                loadingEl.classList.add('hide');
                stageEl.classList.remove('hide');
                resultEl.classList.add('hide');
                render();
                startTimer();
            })
            .catch(function () { loadingEl.textContent = 'Could not load quiz questions.'; });
    }

    function render() {
        state.answered = false;
        var q = state.questions[state.idx];
        qCounter.textContent = 'Question ' + (state.idx + 1) + ' of ' + state.questions.length;
        qText.textContent = q.question;
        qOptions.innerHTML = '';
        qExpl.classList.add('hide');
        qNext.disabled = true;
        progress.style.width = ((state.idx / state.questions.length) * 100) + '%';

        ['A', 'B', 'C', 'D'].forEach(function (letter) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'quiz-option';
            btn.dataset.letter = letter;
            btn.textContent = letter + '. ' + q['option_' + letter.toLowerCase()];
            btn.addEventListener('click', function () { answer(letter, btn, q); });
            qOptions.appendChild(btn);
        });
    }

    function answer(letter, btn, q) {
        if (state.answered) return;
        state.answered = true;
        var options = qOptions.querySelectorAll('.quiz-option');
        options.forEach(function (o) {
            o.disabled = true;
            if (o.dataset.letter === q.correct_option) o.classList.add('correct');
        });
        if (letter === q.correct_option) { state.score += 1; }
        else { btn.classList.add('incorrect'); }
        qScore.textContent = 'Score: ' + state.score;
        if (q.explanation) { qExpl.textContent = q.explanation; qExpl.classList.remove('hide'); }
        qNext.disabled = false;
    }

    function next() {
        state.idx += 1;
        if (state.idx >= state.questions.length) { finish(); return; }
        render();
    }

    function finish() {
        clearInterval(state.timer);
        var total = state.questions.length;
        var pct = Math.round((state.score / total) * 100);
        scoreText.textContent = state.score + '/' + total;
        scoreRing.style.setProperty('--pct', pct + '%');
        stageEl.classList.add('hide');
        resultEl.classList.remove('hide');
        progress.style.width = '100%';
        resultTitle.textContent = pct >= 80 ? 'MashaAllah!' : pct >= 50 ? 'Good effort!' : 'Keep learning!';
        resultSub.textContent = 'Score: ' + state.score + '/' + total + ' · ' + pct + '%';
    }

    function startTimer() {
        var t0 = Date.now();
        state.timer = setInterval(function () {
            var s = Math.floor((Date.now() - t0) / 1000);
            var m = Math.floor(s / 60), r = s % 60;
            qTimer.textContent = (m < 10 ? '0' : '') + m + ':' + (r < 10 ? '0' : '') + r;
        }, 1000);
    }

    document.addEventListener('DOMContentLoaded', function () {
        fetchQuestions();
        qNext.addEventListener('click', next);
        document.getElementById('play-again').addEventListener('click', fetchQuestions);
        document.getElementById('save-score-form').addEventListener('submit', function (e) {
            e.preventDefault();
            var fd = new FormData(this);
            fd.append('score', String(state.score));
            fd.append('total', String(state.questions.length));
            fd.append('duration', String(Math.floor((Date.now() - state.startedAt) / 1000)));
            fetch(HDH.url('/api/quiz.php'), { method: 'POST', body: fd })
                .then(function (r) { return r.json(); })
                .then(function (data) {
                    if (data.ok) {
                        saveMsg.textContent = 'Saved! You are #' + data.rank + ' on the leaderboard.';
                    } else {
                        saveMsg.textContent = data.error || 'Could not save score.';
                    }
                })
                .catch(function () { saveMsg.textContent = 'Network error while saving.'; });
        });
    });
})();
