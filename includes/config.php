<?php
/**
 * Dacks CMS - Core Configuration File
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file holds all core configuration settings for the
 * application, including error reporting, path constants,
 * site information, and database credentials.
 * @last_updated  July 5, 2025
 */

//===================================================================
// SECTION 1: ERROR REPORTING & ENVIRONMENT
//===================================================================
// Configures how PHP errors are handled. For development, it's best
// to show all errors. For a live production server, this should be
// set to 0 and errors should be logged to a private file.

// Environment detection - you can set this manually or use a better method
$is_production = ($_SERVER['HTTP_HOST'] ?? '') !== 'localhost';

if ($is_production) {
    // Production settings
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    ini_set('log_errors', 1);
    ini_set('error_log', ROOT_PATH . '/logs/error.log');
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
} else {
    // Development settings
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Set the default timezone to prevent potential date/time errors.
date_default_timezone_set('America/Halifax');


//===================================================================
// SECTION 2: PATH AND URL CONSTANTS
//===================================================================
// Defines crucial path and URL constants for the application.

// Define the absolute server path to the project root.
define('ROOT_PATH', dirname(__DIR__));

// Define the public Base URL - auto-detect or set manually
if (!defined('BASE_URL')) {
    if ($is_production) {
        // Set your production URL here
        define('BASE_URL', 'https://yoursite.com/');
    } else {
        // Auto-detect for development
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $path = dirname($_SERVER['SCRIPT_NAME']) . '/';
        define('BASE_URL', $protocol . '://' . $host . $path);
    }
}


//===================================================================
// SECTION 3: SITE INFORMATION
//===================================================================
// Holds general site-wide information and metadata.

define('SITE_TITLE', 'Modern Fantasy');
define('SITE_AUTHOR', 'Dackary McDab / Zachary MacPhee');
define('SITE_VERSION', 'v.0.0.2');


//===================================================================
// SECTION 4: DATABASE CREDENTIALS
//===================================================================
// All database connection details are stored here. These values are
// used in /includes/db.php to establish a connection.

if ($is_production) {
    // Production database settings
    define('DB_HOST', 'your-production-host');
    define('DB_USER', 'your-production-user');
    define('DB_PASS', 'your-production-password');
    define('DB_NAME', 'your-production-database');
} else {
    // Development database settings
    define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'dackcms');
}


//===================================================================
// SECTION 5: SECURITY SETTINGS
//===================================================================
// Security-related configuration options.

// Session security settings
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', $is_production ? 1 : 0);
ini_set('session.cookie_samesite', 'Lax');

// Define allowed file types for uploads (if you implement file uploads)
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5MB

// CSRF token timeout (in seconds)
define('CSRF_TOKEN_TIMEOUT', 3600); // 1 hour