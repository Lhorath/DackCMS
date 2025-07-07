<?php
/**
 * Dacks CMS - Database Connection
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file establishes the connection to the database using PDO.
 * It uses the credentials defined in config.php and makes the
 * connection object ($pdo) available to the application.
 * @last_updated  July 5, 2025
 */

//===================================================================
// SECTION 1: PDO CONNECTION OPTIONS
//===================================================================
// Defines the options for the PDO connection to ensure robust error
// handling and consistent data fetching.

$options = [
    // Throw a PDOException on database errors for easy catching.
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    
    // Fetch results as associative arrays by default.
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    
    // Disable emulation of prepared statements for security and performance.
    PDO::ATTR_EMULATE_PREPARES   => false,
];


//===================================================================
// SECTION 2: ESTABLISH CONNECTION
//===================================================================
// Creates the PDO instance using a try-catch block to gracefully
// handle connection failures.

try {
    // The Data Source Name (DSN) combines the driver, host, database name, and charset.
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    
    // Create the new PDO object. This object will be used for all database queries.
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
} catch (PDOException $e) {
    // If the connection fails, terminate the script and display an error.
    // In a production environment, this error should be logged to a private
    // file and a generic error message should be shown to the user.
    // error_log("Database connection failed: " . $e->getMessage());
    die("Error: Unable to connect to the database. Please try again later.");
}