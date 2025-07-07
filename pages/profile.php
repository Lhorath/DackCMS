<?php
/**
 * Dacks CMS - User Profile Page
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file provides the content for the user profile page. It is a
 * protected page that requires a user to be logged in. It fetches
 * the current user's data from the database and displays it.
 * @last_updated  July 5, 2025
 */

//===================================================================
// SECTION 1: ACCESS CONTROL & DATA FETCHING
//===================================================================

// Enforce that only logged-in users can access this page.
// If not logged in, the user will be redirected to the login page.
require_login();

// Get the current user's ID from the session.
$user_id = $_SESSION['user_id'];
$user_data = null;

// Fetch the user's full details from the database.
try {
    $sql = "
        SELECT u.display_name, u.email, u.created_at, r.name AS role_name
        FROM users u
        LEFT JOIN roles r ON u.role_id = r.id
        WHERE u.id = ?
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch();
    
} catch (PDOException $e) {
    // In production, this should be logged.
    // error_log("Profile page query failed: " . $e->getMessage());
    // We can allow the page to render with a null user_data, which will be handled below.
}

// If for any reason the user data could not be fetched, redirect away.
if (!$user_data) {
    // Maybe the user was deleted but the session still exists.
    // In this case, we should log them out.
    header('Location: ' . get_page_url('logout'));
    exit();
}

?>

<div class="grid grid-cols-1 lg:grid-cols-[250px_1fr] gap-3">

    <aside class="w-full lg:w-[250px] space-y-3">
        </aside>

    <main>
        <div class="mt-3 p-6 shadow-inner bg-[#221502]/40 rounded-md">
            
            <h1 class="font-heading text-2xl text-[#a1722f]">User Profile</h1>
            <p class="text-sm text-[#a1722f]/80 mb-6">Your account information.</p>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-[#a1722f]/70">Display Name</label>
                    <p class="mt-1 text-lg text-[#a1722f]"><?php echo esc($user_data['display_name']); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#a1722f]/70">Email Address</label>
                    <p class="mt-1 text-lg text-[#a1722f]"><?php echo esc($user_data['email']); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#a1722f]/70">User Role</label>
                    <p class="mt-1 text-lg text-[#a1722f]"><?php echo esc($user_data['role_name']); ?></p>
                </div>
                <div>
                    <label class="block text-sm font-bold text-[#a1722f]/70">Member Since</label>
                    <p class="mt-1 text-lg text-[#a1722f]"><?php echo date('F j, Y', strtotime($user_data['created_at'])); ?></p>
                </div>
            </div>

            <div class="mt-8 border-t border-[#221502] pt-6">
                <a href="#" class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#5d170b] hover:bg-[#401a11] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#a1722f]">
                    Edit Profile
                </a>
            </div>

        </div>
    </main>
</div>