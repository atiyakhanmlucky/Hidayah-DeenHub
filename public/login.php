<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
$page = 'login';
$page_title = 'Login';

$error = null;
$next  = (string)($_GET['next'] ?? '/index.php');
if (!preg_match('~^/[^\s]*$~', $next)) { $next = '/index.php'; }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? '')) {
        $error = 'Session expired. Please try again.';
    } else {
        $identifier = trim((string)($_POST['identifier'] ?? ''));
        $password   = (string)($_POST['password']   ?? '');
        if ($identifier === '' || $password === '') {
            $error = 'Please enter your username/email and password.';
        } else {
            $stmt = db()->prepare('SELECT id, password_hash FROM users WHERE username = ? OR email = ? LIMIT 1');
            $stmt->execute([$identifier, $identifier]);
            $row = $stmt->fetch();
            if ($row && password_verify($password, $row['password_hash'])) {
                login_user((int)$row['id']);
                header('Location: ' . $next);
                exit;
            }
            $error = 'Invalid credentials.';
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>
<form class="form" method="post" action="<?= e(u('/login.php')) ?>?next=<?= e(urlencode($next)) ?>">
    <h1>Welcome back</h1>
    <p class="muted">Log in to save your quiz scores and manage content.</p>
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
    <div class="field">
        <label for="identifier">Username or Email</label>
        <input id="identifier" name="identifier" required autofocus value="<?= e($_POST['identifier'] ?? '') ?>">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required>
    </div>
    <div class="actions">
        <button class="btn btn-primary btn-block" type="submit">Log in</button>
    </div>
    <div class="divider"></div>
    <p class="muted" style="text-align:center">New here? <a href="<?= e(u('/register.php')) ?>">Create an account</a>.</p>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
