<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/db.php';
$page = 'register';
$page_title = 'Create account';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf($_POST['_csrf'] ?? '')) {
        $error = 'Session expired. Please try again.';
    } else {
        $username = trim((string)($_POST['username'] ?? ''));
        $email    = trim((string)($_POST['email']    ?? ''));
        $password = (string)($_POST['password'] ?? '');
        $city     = trim((string)($_POST['city']    ?? ''));
        $country  = trim((string)($_POST['country'] ?? ''));

        if (!preg_match('/^[A-Za-z0-9_]{3,40}$/', $username)) {
            $error = 'Username must be 3-40 characters (letters, digits, underscore).';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Please enter a valid email.';
        } elseif (strlen($password) < 6) {
            $error = 'Password must be at least 6 characters.';
        } else {
            try {
                $stmt = db()->prepare('INSERT INTO users (username, email, password_hash, city, country) VALUES (?, ?, ?, ?, ?)');
                $stmt->execute([
                    $username,
                    $email,
                    password_hash($password, PASSWORD_DEFAULT),
                    $city ?: null,
                    $country ?: null,
                ]);
                login_user((int)db()->lastInsertId());
                header('Location: ' . u('/index.php'));
                exit;
            } catch (PDOException $e) {
                if ((int)$e->getCode() === 23000) {
                    $error = 'That username or email is already taken.';
                } else {
                    $error = APP_DEBUG ? $e->getMessage() : 'Could not register. Try again.';
                }
            }
        }
    }
}

include __DIR__ . '/../includes/header.php';
?>
<form class="form" method="post" action="<?= e(u('/register.php')) ?>">
    <h1>Create your account</h1>
    <p class="muted">Track quiz scores and personalize your prayer-time location.</p>
    <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
    <input type="hidden" name="_csrf" value="<?= e(csrf_token()) ?>">
    <div class="field">
        <label for="username">Username</label>
        <input id="username" name="username" required value="<?= e($_POST['username'] ?? '') ?>">
    </div>
    <div class="field">
        <label for="email">Email</label>
        <input id="email" name="email" type="email" required value="<?= e($_POST['email'] ?? '') ?>">
    </div>
    <div class="field">
        <label for="password">Password</label>
        <input id="password" name="password" type="password" required minlength="6">
        <div class="hint">At least 6 characters.</div>
    </div>
    <div class="row">
        <div class="field" style="flex:1">
            <label for="city">City (optional)</label>
            <input id="city" name="city" value="<?= e($_POST['city'] ?? '') ?>">
        </div>
        <div class="field" style="flex:1">
            <label for="country">Country (optional)</label>
            <input id="country" name="country" value="<?= e($_POST['country'] ?? '') ?>">
        </div>
    </div>
    <div class="actions">
        <button class="btn btn-primary btn-block" type="submit">Sign up</button>
    </div>
    <div class="divider"></div>
    <p class="muted" style="text-align:center">Already have an account? <a href="<?= e(u('/login.php')) ?>">Log in</a>.</p>
</form>
<?php include __DIR__ . '/../includes/footer.php'; ?>
