<?php
require_once __DIR__ . '/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function current_user(): ?array
{
    if (empty($_SESSION['user_id'])) {
        return null;
    }

    static $cached = null;
    if ($cached !== null && (int)$cached['id'] === (int)$_SESSION['user_id']) {
        return $cached;
    }

    $stmt = db()->prepare('SELECT id, username, email, is_admin, created_at FROM users WHERE id = ? LIMIT 1');
    $stmt->execute([$_SESSION['user_id']]);
    $user = $stmt->fetch();
    $cached = $user ?: null;
    return $cached;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: ' . u('/login.php') . '?next=' . urlencode($_SERVER['REQUEST_URI'] ?? '/'));
        exit;
    }
}

function require_admin(): void
{
    $u = current_user();
    if (!$u || !(int)$u['is_admin']) {
        http_response_code(403);
        echo 'Admin access required.';
        exit;
    }
}

function login_user(int $id): void
{
    session_regenerate_id(true);
    $_SESSION['user_id'] = $id;
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function verify_csrf(?string $token): bool
{
    return !empty($token) && !empty($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}

function e(?string $s): string
{
    return htmlspecialchars((string)$s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
