<?php
/**
 * Dacks CMS - Registration Action
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file handles the user registration form submission. It validates
 * user input, checks for duplicate accounts, securely hashes the
 * password, and creates a new user in the database.
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
// SECTION 2: PROCESS REGISTRATION REQUEST
//===================================================================

// Ensure the script is accessed via a POST request.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 1. Get and sanitize form data.
    $display_name = trim($_POST['display_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $password_confirm = $_POST['password_confirm'] ?? '';
    $errors = [];

    // 2. Input Validation.
    if (empty($display_name) || empty($email) || empty($password) || empty($password_confirm)) {
        $errors[] = "All fields are required.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "The email address provided is not a valid format.";
    }
    if (strlen($display_name) < 3 || strlen($display_name) > 50) {
        $errors[] = "Display Name must be between 3 and 50 characters.";
    }
    if ($password !== $password_confirm) {
        $errors[] = "The passwords you entered do not match.";
    }
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters long.";
    }

    // 3. Check for existing user (if there are no other validation errors).
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? OR display_name = ?");
            $stmt->execute([$email, $display_name]);
            if ($stmt->fetch()) {
                $errors[] = "An account with that Email or Display Name already exists.";
            }
        } catch (PDOException $e) {
            $errors[] = "A database error occurred while checking for existing users.";
            // In production, log the detailed error: error_log($e->getMessage());
        }
    }
    
    // 4. If all checks pass, proceed with creating the user.
    if (empty($errors)) {
        try {
            // Hash the password for secure storage.
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Set the default role for all new users (ID 5 is for 'Member').
            $default_role_id = 5;

            // Insert the new user into the database.
            $stmt = $pdo->prepare("INSERT INTO users (display_name, email, password, role_id) VALUES (?, ?, ?, ?)");
            $stmt->execute([$display_name, $email, $hashed_password, $default_role_id]);

            // Set a success message and redirect to the login page.
            $_SESSION['flash_message'] = "Registration successful! You may now log in.";
            header('Location: ' . get_page_url('login'));
            exit();

        } catch (PDOException $e) {
            $errors[] = "A critical database error occurred. Could not register user.";
            // In production, log the detailed error: error_log($e->getMessage());
        }
    }

    // 5. If there were any errors, store them in the session and redirect back to the registration page.
    $_SESSION['flash_errors'] = $errors;
    header('Location: ' . get_page_url('register'));
    exit();
    
} else {
    // If not a POST request, redirect away to the home page.
    header('Location: ' . get_page_url('home'));
    exit();
}