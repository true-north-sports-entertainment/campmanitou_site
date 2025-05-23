<?php
/**
 * The base configuration for WordPress
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 * @package WordPress
 */

// Load Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Load environment variables
if (file_exists(__DIR__ . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();
} else {
    error_log('.env file NOT found! Ensure it exists in the root directory.');
}

// Ensure required environment variables are set
$required_env_vars = ['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'DB_HOST'];
foreach ($required_env_vars as $var) {
    if (empty($_ENV[$var]) && empty($_SERVER[$var])) {
        error_log("Missing required environment variable: $var");
        die("Error: Missing required environment variable: $var");
    }
}

// Database settings
define('DB_NAME', $_ENV['DB_NAME'] ?? $_SERVER['DB_NAME'] ?? die('Missing DB_NAME in .env'));
define('DB_USER', $_ENV['DB_USER'] ?? $_SERVER['DB_USER'] ?? die('Missing DB_USER in .env'));
define('DB_PASSWORD', $_ENV['DB_PASSWORD'] ?? $_SERVER['DB_PASSWORD'] ?? die('Missing DB_PASSWORD in .env'));
define('DB_HOST', $_ENV['DB_HOST'] ?? $_SERVER['DB_HOST'] ?? 'localhost');

/** Database charset and collate type */
define('DB_CHARSET', 'utf8mb4');
define('DB_COLLATE', '');

/** Debugging mode */
define('WP_ENV', $_ENV['WP_ENV'] ?? $_SERVER['WP_ENV'] ?? 'production');
define('WP_DEBUG', filter_var($_ENV['WP_DEBUG'] ?? $_SERVER['WP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_LOG', filter_var($_ENV['WP_DEBUG_LOG'] ?? $_SERVER['WP_DEBUG_LOG'] ?? false, FILTER_VALIDATE_BOOLEAN));
define('WP_DEBUG_DISPLAY', filter_var($_ENV['WP_DEBUG_DISPLAY'] ?? $_SERVER['WP_DEBUG_DISPLAY'] ?? false, FILTER_VALIDATE_BOOLEAN));

if (WP_DEBUG) {
    @ini_set('display_errors', 1);
    @ini_set('display_startup_errors', 1);
} else {
    @ini_set('display_errors', 0);
    @ini_set('display_startup_errors', 0);
}

/** Disable file modifications in non-local environments */
if (WP_ENV !== 'local') {
    define('WP_AUTO_UPDATE_CORE', false);
    define('DISALLOW_FILE_MODS', true);
}

/** Unique authentication keys and salts */
define('AUTH_KEY', $_ENV['AUTH_KEY'] ?? $_SERVER['AUTH_KEY'] ?? 'put-your-auth-key-here');
define('SECURE_AUTH_KEY', $_ENV['SECURE_AUTH_KEY'] ?? $_SERVER['SECURE_AUTH_KEY'] ?? 'put-your-secure-auth-key-here');
define('LOGGED_IN_KEY', $_ENV['LOGGED_IN_KEY'] ?? $_SERVER['LOGGED_IN_KEY'] ?? 'put-your-logged-in-key-here');
define('NONCE_KEY', $_ENV['NONCE_KEY'] ?? $_SERVER['NONCE_KEY'] ?? 'put-your-nonce-key-here');
define('AUTH_SALT', $_ENV['AUTH_SALT'] ?? $_SERVER['AUTH_SALT'] ?? 'put-your-auth-salt-here');
define('SECURE_AUTH_SALT', $_ENV['SECURE_AUTH_SALT'] ?? $_SERVER['SECURE_AUTH_SALT'] ?? 'put-your-secure-auth-salt-here');
define('LOGGED_IN_SALT', $_ENV['LOGGED_IN_SALT'] ?? $_SERVER['LOGGED_IN_SALT'] ?? 'put-your-logged-in-salt-here');
define('NONCE_SALT', $_ENV['NONCE_SALT'] ?? $_SERVER['NONCE_SALT'] ?? 'put-your-nonce-salt-here');

/** WordPress site URLs */
defined('WP_HOME') or define('WP_HOME', $_ENV['WP_HOME']);
defined('WP_SITEURL') or define('WP_SITEURL', $_ENV['WP_SITEURL']);

/** Amazon AWS keys */
define('AWS_ACCESS_KEY_ID', $_ENV['AWS_ACCESS_KEY_ID'] ?? $_SERVER['AWS_ACCESS_KEY_ID'] ?? '');
define('AWS_SECRET_ACCESS_KEY', $_ENV['AWS_SECRET_ACCESS_KEY'] ?? $_SERVER['AWS_SECRET_ACCESS_KEY'] ?? '');

/** Database table prefix */
$table_prefix = 'wp_';

/** Allow WordPress to detect HTTPS when used behind AWS CloudFront */
if (isset($_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO']) && $_SERVER['HTTP_CLOUDFRONT_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
}

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory */
if (!defined('ABSPATH')) {
    define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files */
 require_once ABSPATH . 'wp-settings.php';