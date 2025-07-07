<?php
/**
 * Dacks CMS - Authentication & Session Management
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file handles user authentication state, session management,
 * and provides core security functions related to user access.
 * @last_updated  July 5, 2025
 */

//===================================================================
// SECTION 1: SESSION INITIALIZATION
//===================================================================

// Start a secure session on every page load if one is not already active.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


//===================================================================
// SECTION 2: CORE AUTHENTICATION FUNCTIONS
//===================================================================

/**
 * Checks if a user is currently logged in by verifying their session data.
 *
 * @return bool True if the user is logged in, false otherwise.
 */
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

/**
 * Gets the role ID for the current user.
 * This is used throughout the application to check permissions.
 *
 * @return int The role ID of the logged-in user, or 0 for a guest.
 */
function getCurrentUserRole() {
    // Returns the session's role_id, or defaults to 0 (Guest) if not set.
    return $_SESSION['user_role_id'] ?? 0;
}


//===================================================================
// SECTION 3: ACCESS CONTROL
//===================================================================

/**
 * Enforces that a user must be logged in to access a page.
 * If the user is a guest, they are redirected to the login page with
 * an informational message.
 * This function should be called at the top of any restricted page logic.
 */
function require_login() {
    if (!is_logged_in()) {
        // Store an informational message for the user.
        $_SESSION['flash_message'] = "You must be logged in to view that page.";
        
        // Redirect to the login page and terminate script execution.
        header('Location: ' . get_page_url('login'));
        exit();
    }
}