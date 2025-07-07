<?php
/**
 * Dacks CMS - Registration Page Content
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file provides the HTML structure for the new user registration
 * page. It includes a form that submits credentials to the registration
 * action script and a partial to display any flash messages.
 * @last_updated  July 5, 2025
 */
?>

<div class="grid grid-cols-1 lg:grid-cols-[250px_1fr] gap-3">

    <aside class="w-full lg:w-[250px] space-y-3">
        </aside>

    <main>
        <div class="mt-3 p-6 shadow-inner bg-[#221502]/40 rounded-md">
            <h1 class="font-heading text-2xl text-[#a1722f]">Register</h1>
            <p class="text-sm text-[#a1722f]/80 mb-4">Create a new account to join the community.</p>

            <?php
            // Includes the partial that displays success or error messages from the session.
            include_once ROOT_PATH . '/includes/partials/flash-messages.php';
            ?>

            <form action="<?php echo BASE_URL; ?>actions/register.php" method="POST" class="space-y-4">
                <div>
                    <label for="display_name" class="block text-sm font-medium text-[#a1722f]/90">Display Name</label>
                    <input type="text" name="display_name" id="display_name" class="mt-1 block w-full bg-[#221502] border border-[#221502]/50 rounded-md shadow-sm py-2 px-3 text-[#a1722f] focus:outline-none focus:ring-[#a1722f] focus:border-[#a1722f] sm:text-sm" required>
                </div>
                 <div>
                    <label for="email" class="block text-sm font-medium text-[#a1722f]/90">Email Address</label>
                    <input type="email" name="email" id="email" class="mt-1 block w-full bg-[#221502] border border-[#221502]/50 rounded-md shadow-sm py-2 px-3 text-[#a1722f] focus:outline-none focus:ring-[#a1722f] focus:border-[#a1722f] sm:text-sm" required>
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-[#a1722f]/90">Password (min. 8 characters)</label>
                    <input type="password" name="password" id="password" class="mt-1 block w-full bg-[#221502] border border-[#221502]/50 rounded-md shadow-sm py-2 px-3 text-[#a1722f] focus:outline-none focus:ring-[#a1722f] focus:border-[#a1722f] sm:text-sm" required>
                </div>
                <div>
                    <label for="password_confirm" class="block text-sm font-medium text-[#a1722f]/90">Confirm Password</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="mt-1 block w-full bg-[#221502] border border-[#221502]/50 rounded-md shadow-sm py-2 px-3 text-[#a1722f] focus:outline-none focus:ring-[#a1722f] focus:border-[#a1722f] sm:text-sm" required>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#5d170b] hover:bg-[#401a11] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#a1722f]">
                        Create Account
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>