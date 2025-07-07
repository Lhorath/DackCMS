<?php
/**
 * Dacks CMS - Site-wide Header
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file contains the opening HTML structure, the complete
 * <head> section, and the site's main header and navigation
 * bar. It dynamically includes meta tags based on the
 * current page being viewed.
 * @last_updated  July 5, 2025
 */

// Ensure required variables are available with fallbacks
$requested_page = $requested_page ?? 'home';
$meta_data = $meta_data ?? [
    'meta_title' => SITE_TITLE,
    'meta_description' => '',
    'meta_keywords' => '',
    'og_image' => ''
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?php echo esc($meta_data['meta_title'] ?? SITE_TITLE); ?></title>
    <meta name="description" content="<?php echo esc($meta_data['meta_description'] ?? ''); ?>">
    <meta name="keywords" content="<?php echo esc($meta_data['meta_keywords'] ?? ''); ?>">

    <meta property="og:type" content="website">
    <meta property="og:url" content="<?php echo get_page_url($requested_page); ?>">
    <meta property="og:title" content="<?php echo esc($meta_data['meta_title'] ?? SITE_TITLE); ?>">
    <meta property="og:description" content="<?php echo esc($meta_data['meta_description'] ?? ''); ?>">
    <meta property="og:image" content="<?php echo esc($meta_data['og_image'] ?? ''); ?>">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="<?php echo get_page_url($requested_page); ?>">
    <meta property="twitter:title" content="<?php echo esc($meta_data['meta_title'] ?? SITE_TITLE); ?>">
    <meta property="twitter:description" content="<?php echo esc($meta_data['meta_description'] ?? ''); ?>">
    <meta property="twitter:image" content="<?php echo esc($meta_data['og_image'] ?? ''); ?>">

    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700&family=Arial&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>css/style.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>
<body class="bg-[#5d170b] font-body body-background">

    <div class="w-full max-w-screen-xl mx-auto my-0 sm:my-4">

        <div class="w-full flex justify-center py-4">
            <a href="<?php echo BASE_URL; ?>">
                <img src="https://dnd.nerdygamertools.com/style/images/logo.png" alt="<?php echo esc(SITE_TITLE); ?> Logo" class="logo-img">
            </a>
        </div>

        <div class="p-1 page-frame rounded-lg">

            <header class="h-auto bg-black bg-opacity-30 flex flex-col sm:flex-row items-center justify-between px-4 py-2 sm:h-10 border-b-2 border-[#221502]/50 rounded-t-md">
                <div class="flex items-center space-x-4 mb-2 sm:mb-0">
                    <?php if (is_logged_in()): ?>
                        <a href="<?php echo get_page_url('profile'); ?>" class="text-sm font-heading text-[#a1722f] hover:text-[#b98d4a]">Profile</a>
                        <a href="<?php echo get_page_url('logout'); ?>" class="text-sm font-heading text-[#a1722f] hover:text-[#b98d4a]">Logout</a>
                    <?php else: ?>
                        <a href="<?php echo get_page_url('login'); ?>" class="text-sm font-heading text-[#a1722f] hover:text-[#b98d4a]">Login</a>
                        <a href="<?php echo get_page_url('register'); ?>" class="text-sm font-heading text-[#a1722f] hover:text-[#b98d4a]">Register</a>
                    <?php endif; ?>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex">
                        <!-- Search input for site-wide search functionality -->
                        <input type="text" placeholder="Search" class="px-2 py-1 text-sm bg-[#221502] border border-[#221502] text-[#a1722f] focus:outline-none focus:border-[#a1722f] rounded-l-md w-32 sm:w-auto">
                        <button class="px-3 bg-[#221502] hover:bg-[#401a11] border border-[#221502] rounded-r-md font-heading">
                            <i class="fas fa-search text-[#a1722f] text-xs"></i>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Main navigation bar with dropdowns and responsive menu -->
            <nav class="bg-[#221502] border-b-2 border-[#221502]/50" x-data="{ isOpen: false, openDropdown: '' }">
                <div class="mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-center h-16">
                        <div class="hidden md:block">
                            <div class="ml-4 flex items-baseline space-x-1">
                                <!-- Main navigation links -->
                                <a href="<?php echo get_page_url('home'); ?>" class="font-heading text-[#a1722f] hover:text-white px-3 py-2 rounded-md text-xl">Home</a>    
                                <!-- Dropdown for Toolkit section -->
                                <div class="relative" @mouseleave="openDropdown = ''">
                                    <button @mouseover="openDropdown = 'game'" class="font-heading text-[#a1722f] hover:text-white px-3 py-2 rounded-md text-xl">The Toolkit <i class="fas fa-caret-down fa-xs"></i></button>
                                    <div x-show="openDropdown === 'game'" x-transition class="absolute z-10 -ml-4 mt-1 w-48 rounded-md shadow-lg bg-[#221502] ring-1 ring-black ring-opacity-5">
                                        <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                                            <!-- Toolkit dropdown links -->
                                            <a href="<?php echo get_page_url('character_sheet'); ?>" class="block px-4 py-2 text-sm text-[#a1722f]/90 hover:bg-[#5d170b] hover:text-[#a1722f] font-heading" role="menuitem">Character Sheet</a>
                                            <a href="<?php echo get_page_url('dice_roller'); ?>" class="block px-4 py-2 text-sm text-[#a1722f]/90 hover:bg-[#5d170b] hover:text-[#a1722f] font-heading" role="menuitem">Dice Roller</a>
                                            <a href="<?php echo get_page_url('compendium'); ?>" class="block px-4 py-2 text-sm text-[#a1722f]/90 hover:bg-[#5d170b] hover:text-[#a1722f] font-heading" role="menuitem">Compendium</a>
                                            <a href="<?php echo get_page_url('initiative_tracker'); ?>" class="block px-4 py-2 text-sm text-[#a1722f]/90 hover:bg-[#5d170b] hover:text-[#a1722f] font-heading" role="menuitem">Initiative Tracker</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Other navigation links -->
                                <a href="<?php echo get_page_url('news'); ?>" class="font-heading text-[#a1722f] hover:text-white px-3 py-2 rounded-md text-xl">News</a>
                                <a href="<?php echo get_page_url('about'); ?>" class="font-heading text-[#a1722f] hover:text-white px-3 py-2 rounded-md text-xl">About</a>
                                <a href="<?php echo get_page_url('contact'); ?>" class="font-heading text-[#a1722f] hover:text-white px-3 py-2 rounded-md text-xl">Contact</a>
                            </div>
                        </div>
                        <!-- Mobile menu button (hamburger) -->
                        <div class="-mr-2 flex md:hidden">
                            <button @click="isOpen = !isOpen" type="button" class="bg-[#5d170b]/50 inline-flex items-center justify-center p-2 rounded-md text-[#a1722f] hover:text-white hover:bg-[#5d170b] focus:outline-none" aria-controls="mobile-menu" aria-expanded="false">
                                <span class="sr-only">Open main menu</span>
                                <i class="fas" :class="isOpen ? 'fa-times' : 'fa-bars'"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Responsive mobile navigation menu -->
                <div x-show="isOpen" class="md:hidden" id="mobile-menu">
                    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                        <a href="<?php echo get_page_url('home'); ?>" class="font-heading text-[#a1722f] hover:text-white block px-3 py-2 rounded-md text-base">Home</a>
                        <div class="px-3 py-2">
                            <span class="font-heading text-[#a1722f] text-base block mb-2">The Toolkit</span>
                            <div class="pl-4 space-y-1">
                                <!-- Toolkit links for mobile menu -->
                                <a href="<?php echo get_page_url('character_sheet'); ?>" class="font-heading text-[#a1722f]/90 hover:text-white block px-3 py-1 rounded-md text-sm">Character Sheet</a>
                                <a href="<?php echo get_page_url('dice_roller'); ?>" class="font-heading text-[#a1722f]/90 hover:text-white block px-3 py-1 rounded-md text-sm">Dice Roller</a>
                                <a href="<?php echo get_page_url('compendium'); ?>" class="font-heading text-[#a1722f]/90 hover:text-white block px-3 py-1 rounded-md text-sm">Compendium</a>
                                <a href="<?php echo get_page_url('initiative_tracker'); ?>" class="font-heading text-[#a1722f]/90 hover:text-white block px-3 py-1 rounded-md text-sm">Initiative Tracker</a>
                            </div>
                        </div>
                        <a href="<?php echo get_page_url('news'); ?>" class="font-heading text-[#a1722f] hover:text-white block px-3 py-2 rounded-md text-base">News</a>
                        <a href="<?php echo get_page_url('about'); ?>" class="font-heading text-[#a1722f] hover:text-white block px-3 py-2 rounded-md text-base">About</a>
                        <a href="<?php echo get_page_url('contact'); ?>" class="font-heading text-[#a1722f] hover:text-white block px-3 py-2 rounded-md text-base">Contact</a>
                    </div>
                </div>
            </nav>