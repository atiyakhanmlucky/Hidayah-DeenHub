<?php
require_once __DIR__ . '/../../includes/db.php';
header('Content-Type: application/json; charset=utf-8');

try {
    $stmt = db()->query('SELECT id, title, body, reference, category FROM tips WHERE is_active = 1 ORDER BY RAND() LIMIT 1');
    $tip = $stmt->fetch();
    echo json_encode(['tip' => $tip ?: null]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['error' => APP_DEBUG ? $e->getMessage() : 'Server error']);
}
