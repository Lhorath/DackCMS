<?php
/**
 * Dacks CMS - Persistent Right Sidebar
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file contains the content for the persistent right sidebar.
 * This sidebar appears on all pages of the site and typically
 * holds promotional content, quick links, or other secondary
 * information.
 * @last_updated  July 5, 2025
 */
?>

<aside class="space-y-3 hidden xl:block">

    <div class="relative shadow-lg h-40 rounded-md overflow-hidden">
        <img src="https://dnd.nerdygamertools.com/style/images/sheet.jpg" alt="Get the Expansion" class="absolute inset-0 w-full h-full object-cover">
        <div class="relative w-full h-full flex items-end justify-center pb-3 bg-gradient-to-t from-black/80 to-transparent rounded-md">
            <button class="font-heading font-bold text-[#a1722f] px-4 py-2 bg-[#221502] hover:bg-[#401a11] shadow-md text-sm rounded-md">GET THE EXPANSION</button>
        </div>
    </div>

    <div class="font-heading text-[#a1722f] rounded-md overflow-hidden">
        <h2 class="panel-header px-3 py-2 text-lg shadow-lg">Quick Links</h2>
        <div class="bg-[#221502]/50 p-2 shadow-inner">
            <ul class="grid grid-cols-2 gap-x-2 text-sm text-[#a1722f]/90">
                <li><a href="#" class="hover:text-[#a1722f] block py-1.5"><i class="fas fa-user-circle fa-fw mr-2 text-[#a1722f]"></i> Account</a></li>
                <li><a href="#" class="hover:text-[#a1722f] block py-1.5"><i class="fas fa-life-ring fa-fw mr-2 text-[#a1722f]"></i> Support</a></li>
                <li><a href="#" class="hover:text-[#a1722f] block py-1.5"><i class="fas fa-shield-alt fa-fw mr-2 text-[#a1722f]"></i> Parental</a></li>
                <li><a href="#" class="hover:text-[#a1722f] block py-1.5"><i class="fas fa-server fa-fw mr-2 text-[#a1722f]"></i> Realm Status</a></li>
                <li><a href="#" class="hover:text-[#a1722f] block py-1.5"><i class="fas fa-key fa-fw mr-2 text-[#a1722f]"></i> Password</a></li>
                <li><a href="#" class="hover:text-[#a1722f] block py-1.5"><i class="fas fa-file-alt fa-fw mr-2 text-[#a1722f]"></i> Patch Notes</a></li>
            </ul>
        </div>
    </div>

    <div class="shadow-lg bg-[#5d170b] p-0.5 rounded-md">
        <div class="border border-[#221502] bg-[#5d170b]/30 p-3 rounded-md">
            <h3 class="font-heading text-lg text-[#a1722f] mb-2">Screenshot of the Day</h3>
            <a href="#">
                <img src="https://placehold.co/300x150/5d170b/a1722f?text=Dark+Castle" alt="Screenshot of the Day" class="shadow-inner h-36 w-full object-cover rounded">
            </a>
        </div>
    </div>

</aside>