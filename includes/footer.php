<?php
/**
 * Dacks CMS - Site-wide Footer
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file contains the site-wide footer section and closes the main
 * HTML document structure, ensuring the footer is contained within the
 * primary page frame.
 * @last_updated  July 5, 2025
 */
?>
            <footer class="mt-3">
                
                <div class="footer-content grid grid-cols-1 md:grid-cols-3 gap-8 text-[#a1722f]/90 p-6">
                    
                    <div>
                        <h3 class="font-heading text-lg text-[#a1722f] mb-3">About Us</h3>
                        <p class="text-sm mb-4">Welcome to Modern Fantasy, the ultimate destination for adventurers. Explore vast kingdoms, battle fierce monsters, and forge your legend in a world of magic and mystery.</p>
                        <button class="font-heading text-sm font-bold text-[#a1722f] bg-[#221502] hover:bg-[#401a11] px-4 py-2 rounded-md">READ MORE</button>
                    </div>

                    <div>
                        <h3 class="font-heading text-lg text-[#a1722f] mb-3">Quick Links</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="<?php echo get_page_url('home'); ?>" class="hover:text-[#a1722f]">The Game</a></li>
                            <li><a href="<?php echo get_page_url('marketplace'); ?>" class="hover:text-[#a1722f]">Marketplace</a></li>
                            <li><a href="<?php echo get_page_url('scrolls'); ?>" class="hover:text-[#a1722f]">Scrolls</a></li>
                            <li><a href="<?php echo get_page_url('support'); ?>" class="hover:text-[#a1722f]">Support</a></li>
                        </ul>
                    </div>

                    <div>
                        <h3 class="font-heading text-lg text-[#a1722f] mb-3">Legal</h3>
                        <ul class="space-y-2 text-sm">
                            <li><a href="#" class="hover:text-[#a1722f]">Privacy Policy</a></li>
                            <li><a href="#" class="hover:text-[#a1722f]">Terms of Service</a></li>
                            <li><a href="#" class="hover:text-[#a1722f]">Terms of Use</a></li>
                            <li><a href="#" class="hover:text-[#a1722f]">Cookie Policy</a></li>
                        </ul>
                    </div>
                </div>

                <div class="footer-bar flex flex-col sm:flex-row items-center justify-between px-4 py-3 rounded-b-md">
                    <div class="text-xs text-[#a1722f]/75 text-center sm:text-left mb-2 sm:mb-0">
                        &copy; <?php echo date("Y"); ?> <?php echo esc(SITE_TITLE); ?>. All Rights Reserved.
                        <br class="sm:hidden"> Designed by <a href="https://macweb.ca/" target="_blank" class="hover:text-[#b98d4a]">MacWeb Canada</a>.
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-[#a1722f] hover:text-white"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-[#a1722f] hover:text-white"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-[#a1722f] hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-[#a1722f] hover:text-white"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

            </footer>
            
        </div> </div> </body>
</html>