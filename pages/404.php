<?php
/**
 * Dacks CMS - 404 Not Found Page Content
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file provides the content for the 404 Error page.
 * It is displayed by the router when a requested page is not found,
 * is inactive, or the user does not have permission to view it.
 * @last_updated  July 5, 2025
 */
?>

<div class="grid grid-cols-1 lg:grid-cols-[250px_1fr] gap-3">

    <aside class="w-full lg:w-[250px] space-y-3">
        </aside>

    <main>
        <div class="mt-3 p-6 shadow-inner bg-[#221502]/40 rounded-md text-center">
            
            <h1 class="font-heading text-6xl text-[#a1722f]/50">404</h1>
            
            <h2 class="font-heading text-2xl text-[#a1722f] mt-2">Page Not Found</h2>
            
            <p class="text-[#a1722f]/80 mt-4 max-w-md mx-auto">
                The page you were looking for could not be found. It may have been moved, deleted, or you may not have permission to view it.
            </p>
            
            <div class="mt-6">
                <a href="<?php echo BASE_URL; ?>" class="px-6 py-2 font-bold font-heading text-[#a1722f] bg-[#221502] hover:bg-[#401a11] shadow-md rounded-md">
                    Return to Home
                </a>
            </div>

        </div>
    </main>
</div>