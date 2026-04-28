<?php
/**
 * Hidayah DeenHub — first-run setup.
 *
 * Runs the SQL schema + seed against the configured database. Safe to re-run;
 * it only creates tables/data that do not already exist (uses CREATE TABLE
 * IF NOT EXISTS and INSERT IGNORE where appropriate).
 *
 * Access from a browser: http://localhost:8080/setup.php
 *
 * For production, delete this file after setup.
 */
require_once __DIR__ . '/../includes/config.php';

header('Content-Type: text/plain; charset=utf-8');

echo "Hidayah DeenHub — Setup\n";
echo str_repeat('=', 40) . "\n\n";

try {
    // Connect without specifying database first so we can create it.
    $dsn = sprintf('mysql:host=%s;port=%s;charset=%s', DB_HOST, DB_PORT, DB_CHARSET);
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "[ok] Connected to MySQL as " . DB_USER . "\n";

    $schema = file_get_contents(__DIR__ . '/../sql/schema.sql');
    $pdo->exec($schema);
    echo "[ok] Schema applied (database: " . DB_NAME . ")\n";

    $pdo->exec('USE `' . DB_NAME . '`');

    $seed = file_get_contents(__DIR__ . '/../sql/seed.sql');
    $pdo->exec($seed);
    echo "[ok] Seed data inserted (tips, quiz questions, 99 names).\n";

    // Ensure a default admin exists with a fresh, locally-generated password hash.
    $stmt = $pdo->prepare('SELECT id FROM users WHERE username = ?');
    $stmt->execute(['admin']);
    $existing = $stmt->fetchColumn();
    $hash = password_hash('Admin@123', PASSWORD_DEFAULT);
    if ($existing) {
        $upd = $pdo->prepare('UPDATE users SET password_hash = ?, is_admin = 1 WHERE id = ?');
        $upd->execute([$hash, (int)$existing]);
        echo "[ok] Reset admin account (username: admin, password: Admin@123).\n";
    } else {
        $ins = $pdo->prepare('INSERT INTO users (username, email, password_hash, is_admin, city, country)
                              VALUES (?, ?, ?, 1, ?, ?)');
        $ins->execute(['admin', 'admin@hidayah.local', $hash, DEFAULT_CITY, DEFAULT_COUNTRY]);
        echo "[ok] Created admin account (username: admin, password: Admin@123).\n";
    }

    echo "\nAll done. Open /index.php and enjoy!\n";
    echo "NOTE: For production, delete public/setup.php.\n";
} catch (Throwable $e) {
    http_response_code(500);
    echo "[error] " . $e->getMessage() . "\n";
    echo "\nTips:\n";
    echo "- Confirm MySQL is running and credentials in includes/config.php are correct.\n";
    echo "- For a clean reset: DROP DATABASE " . DB_NAME . "; then reload this page.\n";
}
