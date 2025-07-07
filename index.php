<?php
/**
 * Dacks CMS - Main Entry Point
 *
 * @project     Dacks CMS
 * @version     v.0.0.2
 * @author      Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description This file serves as the single entry point for all public requests.
 * It initializes the application by loading all core files in the correct
 * order. For a production environment, ensure error reporting settings in
 * 'config.php' are configured to log errors rather than display them.
 * @creation_date July 5, 2025
 */

// ===================================================================
// SECTION 1: GLOBAL CONFIGURATION
// ===================================================================
// Loads essential constants and settings from the /includes/ directory.
require_once 'includes/config.php';


// ===================================================================
// SECTION 2: AUTHENTICATION & SESSION
// ===================================================================
// Starts the session and loads user authentication helper functions.
// This is loaded early as it may be needed by subsequent components.
require_once 'includes/auth.php';


// ===================================================================
// SECTION 3: DATABASE CONNECTION
// ===================================================================
// Establishes the connection to the database, making the $pdo
// object available to the rest of the application.
require_once 'includes/db.php';


// ===================================================================
// SECTION 4: CORE FUNCTIONS
// ===================================================================
// Loads the global functions library, making helper functions like
// get_page_url() and esc() available throughout the application.
require_once 'includes/functions.php';


// ===================================================================
// SECTION 5: APPLICATION BOOTSTRAP
// ===================================================================
// Loads the main controller file. This file handles URL routing,
// permission checks, and assembles the final HTML page by including
// the header, dynamic page content, and footer.
require_once 'includes/includes.php';