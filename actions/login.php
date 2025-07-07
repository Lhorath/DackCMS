<?php
/**
 * Dacks CMS - Login Action
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file handles the user login form submission. It validates
 * user credentials, verifies the password, and creates a secure
 * session upon successful authentication.
 * @creation_date July 5, 2025
 */

//===================================================================
// SECTION 1: BOOTSTRAP
//===================================================================
// Load only the necessary core files. We use a relative path because
// this file is located inside the /actions/ directory.

require_once '../includes/config.php';
require_once '../includes/db.php';
require_once '../includes/auth.php';
require_once '../includes/functions.php';


//===================================================================
// SECTION 2: PROCESS LOGIN REQUEST
//===================================================================

// Ensure the script is accessed via a POST request.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitize input.
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Basic validation.
    if (empty($email) || empty($password) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['flash_errors'] = ["Invalid email or password."];
        header('Location: ' . get_page_url('login'));
        exit();
    }

    try {
        // Attempt to find the user in the database by their email address.
        $stmt = $pdo->prepare("SELECT id, display_name, password, role_id FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verify that the user exists and the submitted password matches the hashed password in the database.
        if ($user && password_verify($password, $user['password'])) {
            
            // --- LOGIN SUCCESS ---
            
            // Regenerate the session ID to prevent session fixation attacks.
            session_regenerate_id(true);
            
            // Store essential user data in the session.
            $_SESSION['user_id'] = (int)$user['id'];
            $_SESSION['user_role_id'] = (int)$user['role_id'];
            $_SESSION['display_name'] = $user['display_name'];
            
            // Redirect to the user's profile page upon successful login.
            header('Location: ' . get_page_url('profile'));
            exit();

        } else {
            // --- LOGIN FAILURE ---
            $_SESSION['flash_errors'] = ["Invalid email or password."];
            header('Location: ' . get_page_url('login'));
            exit();
        }
    } catch (PDOException $e) {
        // In a production environment, this error should be logged to a file.
        // error_log("Login database error: " . $e->getMessage());
        $_SESSION['flash_errors'] = ["An unexpected error occurred. Please try again later."];
        header('Location: ' . get_page_url('login'));
        exit();
    }
} else {
    // If not a POST request, redirect away to the home page.
    header('Location: ' . get_page_url('home'));
    exit();
}