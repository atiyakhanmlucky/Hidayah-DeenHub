<?php
require_once __DIR__ . '/../../includes/db.php';
require_once __DIR__ . '/../../includes/auth.php';

header('Content-Type: application/json; charset=utf-8');

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

try {
    if ($method === 'GET') {
        $count = max(1, min(20, (int)($_GET['count'] ?? 10)));
        $stmt = db()->prepare('SELECT id, question, option_a, option_b, option_c, option_d, correct_option, explanation, difficulty
                               FROM quiz_questions WHERE is_active = 1 ORDER BY RAND() LIMIT ' . $count);
        $stmt->execute();
        $qs = $stmt->fetchAll();
        echo json_encode(['questions' => $qs]);
        exit;
    }

    if ($method === 'POST') {
        $token = $_POST['_csrf'] ?? '';
        if (!verify_csrf($token)) {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid session token. Please refresh and try again.']);
            exit;
        }

        $score    = max(0, (int)($_POST['score']    ?? 0));
        $total    = max(1, (int)($_POST['total']    ?? 0));
        $duration = max(0, (int)($_POST['duration'] ?? 0));
        $user     = current_user();
        $display  = $user ? $user['username'] : substr(trim((string)($_POST['display_name'] ?? 'Anonymous')), 0, 40);
        if ($display === '') $display = 'Anonymous';

        if ($score > $total) { $score = $total; }

        $ins = db()->prepare('INSERT INTO quiz_attempts (user_id, display_name, score, total_questions, duration_sec)
                              VALUES (?, ?, ?, ?, ?)');
        $ins->execute([$user['id'] ?? null, $display, $score, $total, $duration]);
        $id = (int)db()->lastInsertId();

        $rk = db()->prepare('SELECT COUNT(*)+1 FROM quiz_attempts WHERE
                              (score > ?) OR (score = ? AND duration_sec < ? AND id <> ?)');
        $rk->execute([$score, $score, $duration, $id]);
        $rank = (int)$rk->fetchColumn();

        echo json_encode(['ok' => true, 'attempt_id' => $id, 'rank' => $rank]);
        exit;
    }

    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => APP_DEBUG ? $e->getMessage() : 'Server error']);
}
