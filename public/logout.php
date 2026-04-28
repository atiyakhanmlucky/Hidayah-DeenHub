<?php
require_once __DIR__ . '/../includes/auth.php';
logout_user();
header('Location: ' . u('/index.php'));
exit;
