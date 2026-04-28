<?php
/**
 * Hidayah DeenHub - configuration
 *
 * For local development, create `includes/config.local.php` and `define()` any
 * of the constants below to override them without committing your credentials.
 * `config.local.php` is loaded first, then any constants that were NOT defined
 * by it fall back to the defaults here (or environment variables).
 */

// ---------------------------------------------------------------------------
// Local overrides (loaded first, so it can short-circuit the defines below)
// ---------------------------------------------------------------------------
$__localConfig = __DIR__ . '/config.local.php';
if (file_exists($__localConfig)) {
    require $__localConfig;
}
unset($__localConfig);

// ---------------------------------------------------------------------------
// Database (MySQL / MariaDB)
// ---------------------------------------------------------------------------
if (!defined('DB_HOST'))    define('DB_HOST',    getenv('DB_HOST')    ?: '127.0.0.1');
if (!defined('DB_PORT'))    define('DB_PORT',    getenv('DB_PORT')    ?: '3306');
if (!defined('DB_NAME'))    define('DB_NAME',    getenv('DB_NAME')    ?: 'hidayah_deenhub');
if (!defined('DB_USER'))    define('DB_USER',    getenv('DB_USER')    ?: 'root');
if (!defined('DB_PASS'))    define('DB_PASS',    getenv('DB_PASS')    ?: '');
if (!defined('DB_CHARSET')) define('DB_CHARSET', 'utf8mb4');

// ---------------------------------------------------------------------------
// Application
// ---------------------------------------------------------------------------
if (!defined('APP_NAME'))   define('APP_NAME', 'Hidayah DeenHub');
if (!defined('APP_ENV'))    define('APP_ENV',  getenv('APP_ENV') ?: 'development');
if (!defined('APP_DEBUG')) {
    define('APP_DEBUG', APP_ENV !== 'production');
}

// Default city used for prayer-times when the visitor has not set one.
if (!defined('DEFAULT_CITY'))    define('DEFAULT_CITY',    'Dhaka');
if (!defined('DEFAULT_COUNTRY')) define('DEFAULT_COUNTRY', 'Bangladesh');
if (!defined('DEFAULT_METHOD'))  define('DEFAULT_METHOD',  '1'); // University of Islamic Sciences, Karachi

// How long prayer-time API responses are cached (seconds).
if (!defined('PRAYER_CACHE_TTL')) define('PRAYER_CACHE_TTL', 60 * 60 * 6);

// ---------------------------------------------------------------------------
// BASE_URL — auto-detected so the app works both at the web-root
// (e.g. `php -S 0.0.0.0:8080 -t public` → "") and in a subdirectory
// (e.g. XAMPP at http://localhost/Hidayah-DeenHub/public/ → "/Hidayah-DeenHub/public").
// You can override it by defining BASE_URL in config.local.php.
// ---------------------------------------------------------------------------
if (!defined('BASE_URL')) {
    $__script = $_SERVER['SCRIPT_NAME'] ?? '';
    $__dir = str_replace('\\', '/', dirname($__script));
    // If the current request is in an admin/ or api/ subdirectory,
    // the app's public root is one level above.
    $__dir = preg_replace('#/(admin|api)$#', '', $__dir);
    if ($__dir === '/' || $__dir === '.') {
        $__dir = '';
    }
    define('BASE_URL', rtrim($__dir, '/'));
    unset($__script, $__dir);
}

/**
 * Prefix an app-absolute path (starting with "/") with BASE_URL so that
 * links / assets / redirects work regardless of where the app is mounted.
 */
if (!function_exists('u')) {
    function u(string $path): string {
        if ($path === '' || $path[0] !== '/') {
            $path = '/' . $path;
        }
        return BASE_URL . $path;
    }
}

// ---------------------------------------------------------------------------
// Error reporting
// ---------------------------------------------------------------------------
if (APP_DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);
    ini_set('display_errors', '0');
}
