<?php
/**
 * Dacks CMS - Flash Message Partial
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file is a reusable template partial for displaying
 * session-based "flash messages" (e.g., success or error
 * notifications). It unsets the session variables after
 * display to ensure they only appear once.
 * @last_updated  July 5, 2025
 */

//===================================================================
// SECTION 1: DISPLAY SUCCESS MESSAGE
//===================================================================

// Check for a general success message in the session.
if (isset($_SESSION['flash_message'])) {
    // Display the message in a styled 'success' alert box.
    echo '<div class="p-3 mb-4 text-sm text-green-400 bg-green-900/50 rounded-md border border-green-700">' . esc($_SESSION['flash_message']) . '</div>';
    
    // Unset the session variable so the message doesn't show again.
    unset($_SESSION['flash_message']);
}


//===================================================================
// SECTION 2: DISPLAY ERROR MESSAGES
//===================================================================

// Check for an array of error messages in the session.
if (isset($_SESSION['flash_errors']) && !empty($_SESSION['flash_errors'])) {
    // Display the errors in a styled 'error' alert box.
    echo '<div class="p-3 mb-4 text-sm text-red-400 bg-red-900/50 rounded-md border border-red-700">';
    
    // Loop through and display each error message.
    foreach ($_SESSION['flash_errors'] as $error) {
        echo '<div>' . esc($error) . '</div>';
    }
    
    echo '</div>';
    
    // Unset the session variable so the messages don't show again.
    unset($_SESSION['flash_errors']);
}