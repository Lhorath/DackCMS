<?php
/**
 * Dacks CMS - Logout Action Page
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This script handles the user logout process. It does not
 * render any HTML. Its sole purpose is to destroy the
 * current session and redirect the user.
 * @last_updated  July 5, 2025
 */

//===================================================================
// SECTION 1: BOOTSTRAP
//===================================================================
// Load only the essential files needed for redirection and session handling.
// The full application does not need to be loaded.

require_once ROOT_PATH . '/includes/config.php';
require_once ROOT_PATH . '/includes/functions.php';
require_once ROOT_PATH . '/includes/auth.php'; // This starts the session.


//===================================================================
// SECTION 2: PROCESS LOGOUT
//===================================================================

// Unset all of the session variables.
$_SESSION = [];

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

// Redirect the user to the home page after logging out.
header('Location: ' . get_page_url('home'));
exit(); // Ensure no further code is executed after redirection.