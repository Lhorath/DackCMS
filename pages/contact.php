<?php
/**
 * Dacks CMS - Contact Page Content
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file provides the content for the "Contact Us" page,
 * including a functional contact form.
 * @last_updated  July 5, 2025
 */
?>

<div class="grid grid-cols-1 lg:grid-cols-[250px_1fr] gap-3">

    <main class="lg:col-span-2">
        <div class="mt-3 p-6 shadow-inner bg-[#221502]/40 rounded-md">

            <h1 class="font-heading text-2xl text-[#a1722f]">Contact Us</h1>
            <p class="text-sm text-[#a1722f]/80 mb-6">Have a question or feedback? Fill out the form below to get in touch.</p>

            <?php
            // Displays success or error messages from the session.
            include_once ROOT_PATH . '/includes/partials/flash-messages.php';
            ?>

            <form action="<?php echo get_page_url('action/contact'); ?>" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-[#a1722f]/90">Your Name</label>
                    <input type="text" name="name" id="name" class="mt-1 block w-full bg-[#221502] border border-[#221502]/50 rounded-md shadow-sm py-2 px-3 text-[#a1722f] focus:outline-none focus:ring-[#a1722f] focus:border-[#a1722f] sm:text-sm" required>
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-[#a1722f]/90">Your Email</h3abel>
                    <input type="email" name="email" id="email" class="mt-1 block w-full bg-[#221502] border border-[#221502]/50 rounded-md shadow-sm py-2 px-3 text-[#a1722f] focus:outline-none focus:ring-[#a1722f] focus:border-[#a1722f] sm:text-sm" required>
                </div>
                <div>
                    <label for="subject" class="block text-sm font-medium text-[#a1722f]/90">Subject</label>
                    <input type="text" name="subject" id="subject" class="mt-1 block w-full bg-[#221502] border border-[#221502]/50 rounded-md shadow-sm py-2 px-3 text-[#a1722f] focus:outline-none focus:ring-[#a1722f] focus:border-[#a1722f] sm:text-sm" required>
                </div>
                <div>
                    <label for="message" class="block text-sm font-medium text-[#a1722f]/90">Message</label>
                    <textarea id="message" name="message" rows="4" class="mt-1 block w-full bg-[#221502] border border-[#221502]/50 rounded-md shadow-sm py-2 px-3 text-[#a1722f] focus:outline-none focus:ring-[#a1722f] focus:border-[#a1722f] sm:text-sm" required></textarea>
                </div>
                <div class="pt-2">
                    <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-[#5d170b] hover:bg-[#401a11] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#a1722f]">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </main>
</div>