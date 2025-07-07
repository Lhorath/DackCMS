<?php
/**
 * Dacks CMS - Home Page Content
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file provides the full content for the Home page. It dynamically
 * fetches and displays news articles from the database and includes
 * the page-specific left sidebar and main content area.
 * @last_updated  July 5, 2025
 */

//===================================================================
// SECTION 1: DATA FETCHING
//===================================================================
// Fetches the 3 latest news articles from the database to display.

try {
    $stmt = $pdo->query("SELECT title, author, body, publish_date FROM news ORDER BY publish_date DESC LIMIT 3");
    $news_articles = $stmt->fetchAll();
} catch (PDOException $e) {
    // In a production environment, this error should be logged.
    // error_log("Home page news query failed: " . $e->getMessage());
    $news_articles = []; // Ensure the page doesn't crash if the query fails.
    echo "";
}

?>

<div class="grid grid-cols-1 lg:grid-cols-[250px_1fr] gap-3">

    <aside class="w-full lg:w-[250px] space-y-3">
        <nav class="text-[#a1722f] space-y-1" x-data="{
                 openMenu: 'Game Guide',
                 menus: [
                     { name: 'News', icon: 'fa-newspaper' },
                     { name: 'Toolkit', icon: 'fa-wrench' },
                     { name: 'Compendium', icon: 'fa-cogs' },
                     { name: 'Media', icon: 'fa-photo-video' },
                     { name: 'Community', icon: 'fa-users' },
                     { name: 'Support', icon: 'fa-life-ring' }
                 ]
             }">
            <template x-for="menu in menus" :key="menu.name">
                <div class="rounded-md overflow-hidden">
                    <h2 @click="openMenu = (openMenu === menu.name ? '' : menu.name)" class="panel-header px-3 py-2 text-lg flex justify-between items-center shadow-lg font-heading">
                        <div class="flex items-center">
                            <i class="fas fa-fw" :class="menu.icon + ' mr-2'"></i>
                            <span x-text="menu.name"></span>
                        </div>
                        <i class="fas fa-xs" :class="openMenu === menu.name ? 'fa-minus' : 'fa-plus'"></i>
                    </h2>
                    <ul x-show="openMenu === menu.name" x-transition class="text-sm text-[#a1722f]/90 bg-[#221502]/50 p-2 shadow-inner">
                        <template x-if="menu.name === 'News'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5">Latest News</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5">Archived News</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5">Release Notes</a></li>
                            </div>
                        </template>
                        <template x-if="menu.name === 'Toolkit'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Dice Roller</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Initiative Tracker</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Compendium</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Character Sheet</a></li>
                            </div>
                        </template> 
                        <template x-if="menu.name === 'Compendium'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Introduction</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Getting Started</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- The World</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Story</a></li>
                            </div>
                        </template> 
                        <template x-if="menu.name === 'Media'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Screenshots</a></li>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Youtube Videos</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Downloads</a></li>
                            </div>
                        </template>
                        <template x-if="menu.name === 'Community'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Discord</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Forums</a></li>
                            </div>
                        </template>
                        <template x-if="menu.name === 'Support'">
                            <div>
                                <li class="border-b border-[#221502]/60"><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Bug Tracker</a></li>
                                <li><a href="#" class="hover:text-[#a1722f] block py-1.5 pl-4">- Contact</a></li>
                            </div>
                        </template>
                        <template x-if="!['News', 'Account', 'Toolkit', 'Compendium', 'Media', 'Community', 'Support'].includes(menu.name)">
                            <li><a href="#" class="hover:text-[#a1722f] block py-1.5" x-text="`All ${menu.name}`"></a></li>
                        </template>
                    </ul>
                </div>
            </template>
        </nav>
    </aside>

    <main>
        <div x-data="{ activeSlide: 1, totalSlides: 3, interval: 9000 }" x-init="setInterval(() => { activeSlide = (activeSlide % totalSlides) + 1 }, interval)" class="relative w-full h-64 shadow-lg bg-black overflow-hidden rounded-md">
            <div class="slider-container absolute inset-0 flex transition-transform duration-500 ease-in-out" :style="`transform: translateX(-${(activeSlide - 1) * 100}%)`">
                <div class="relative w-full h-full flex-shrink-0">
                    <img src="images/slide_1.jpg" alt="A New Age Dawns" class="absolute inset-0 w-full h-full object-cover">
                    <div class="relative w-full h-full bg-black bg-opacity-50 flex flex-col justify-center items-center text-center p-4">
                        <h3 class="font-heading text-4xl text-[#a1722f] text-shadow">The New 5e Toolkit!</h3>
                        <button class="mt-3 px-5 py-2 font-bold text-[#a1722f] bg-[#221502] hover:bg-[#401a11] shadow-md rounded-md font-heading">See the Tools</button>
                    </div>
                </div>
                <div class="relative w-full h-full flex-shrink-0">
                    <img src="images/slide_2.jpeg" alt="Forge Your Legend" class="absolute inset-0 w-full h-full object-cover">
                    <div class="relative w-full h-full bg-black bg-opacity-50 flex flex-col justify-center items-center text-center p-4">
                        <h3 class="font-heading text-4xl text-[#a1722f] text-shadow">Interactive Character Sheet</h3>
                        <button class="mt-3 px-5 py-2 font-bold text-[#a1722f] bg-[#221502] hover:bg-[#401a11] shadow-md rounded-md font-heading">Create A Character</button>
                    </div>
                </div>
                <div class="relative w-full h-full flex-shrink-0">
                    <img src="images/slide_3.jpg" alt="Enter the Arena" class="absolute inset-0 w-full h-full object-cover">
                    <div class="relative w-full h-full bg-black bg-opacity-50 flex flex-col justify-center items-center text-center p-4">
                        <h3 class="font-heading text-4xl text-[#a1722f] text-shadow">Initiative Tracker</h3>
                        <button class="mt-3 px-5 py-2 font-bold text-[#a1722f] bg-[#221502] hover:bg-[#401a11] shadow-md rounded-md font-heading">Roll For Initiative</button>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-3 right-3 flex space-x-2">
                <button @click="activeSlide = activeSlide > 1 ? activeSlide - 1 : totalSlides" class="px-3 py-1 text-xs bg-black bg-opacity-60 text-white rounded-md shadow-md">&lt;</button>
                <button @click="activeSlide = activeSlide < totalSlides ? activeSlide + 1 : 1" class="px-3 py-1 text-xs bg-black bg-opacity-60 text-white rounded-md shadow-md">&gt;</button>
            </div>
        </div>

        <div class="mt-3 p-4 space-y-4 shadow-inner bg-[#221502]/40 rounded-md">

            <?php if (empty($news_articles)): ?>
                <p class="text-center text-[#a1722f]/90">No news articles found.</p>
            <?php else: ?>
                <?php foreach ($news_articles as $index => $article): ?>
                    <article class="shadow-lg rounded-md overflow-hidden" x-data="{ open: <?php echo $index === 0 ? 'true' : 'false'; ?> }">
                        <header @click="open = !open" class="news-card-header p-3 flex justify-between items-center cursor-pointer">
                            <h1 class="font-heading text-xl"><?php echo esc($article['title']); ?></h1>
                            <button class="text-[#a1722f]/90 hover:text-[#a1722f]"><i class="fas" :class="open ? 'fa-minus' : 'fa-plus'"></i></button>
                        </header>
                        <div x-show="open" x-transition class="p-4 bg-[#5d170b]/50">
                            <p class="text-xs text-[#a1722f]/75 border-b border-[#221502] pb-2 mb-3">
                                Posted by <?php echo esc($article['author']); ?> on <span class="text-[#a1722f]/50"><?php echo date('F j, Y', strtotime($article['publish_date'])); ?></span>
                            </p>
                            <div class="text-[#a1722f]/90 text-sm">
                                <?php echo $article['body']; // Body is assumed to contain safe HTML from a trusted source (e.g., a WYSIWYG editor) ?>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            <?php endif; ?>
            <div class="text-center py-2">
                <button class="px-6 py-2 font-bold font-heading text-[#a1722f] bg-[#221502] hover:bg-[#401a11] shadow-md rounded-md">VIEW NEWS ARCHIVES</button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 my-4">
                <div class="ornate-border p-1 rounded-md">
                    <div class="bg-[#221502]/50 p-3 rounded">
                        <h3 class="font-heading text-[#a1722f] text-center text-lg">The Compendium</h3><img src="images/compendium.jpg" alt="Compendium" class="w-full h-24 object-cover my-2 shadow-inner rounded"><a href="#" class="block text-right text-[#a1722f] hover:text-[#b98d4a] text-sm font-bold font-heading">MORE &raquo;</a>
                    </div>
                </div>
                <div class="ornate-border p-1 rounded-md">
                    <div class="bg-[#221502]/50 p-3 rounded">
                        <h3 class="font-heading text-[#a1722f] text-center text-lg">Initiative Tracker</h3><img src="images/initiative.jpg" alt="Initiative Tracker" class="w-full h-24 object-cover my-2 shadow-inner rounded"><a href="#" class="block text-right text-[#a1722f] hover:text-[#b98d4a] text-sm font-bold font-heading">MORE &raquo;</a>
                    </div>
                </div>
                <div class="ornate-border p-1 rounded-md">
                    <div class="bg-[#221502]/50 p-3 rounded">
                        <h3 class="font-heading text-[#a1722f] text-center text-lg">Dice Roller</h3><img src="images/dice.jpg" alt="Dice Roller" class="w-full h-24 object-cover my-2 shadow-inner rounded"><a href="#" class="block text-right text-[#a1722f] hover:text-[#b98d4a] text-sm font-bold font-heading">MORE &raquo;</a>
                    </div>
                </div>
                <div class="ornate-border p-1 rounded-md">
                    <div class="bg-[#221502]/50 p-3 rounded">
                        <h3 class="font-heading text-[#a1722f] text-center text-lg">Character Sheet</h3><img src="images/sheet.jpg" alt="Character Sheet" class="w-full h-24 object-cover my-2 shadow-inner rounded"><a href="#" class="block text-right text-[#a1722f] hover:text-[#b98d4a] text-sm font-bold font-heading">MORE &raquo;</a>
                    </div>
                </div>
            </div>

            <div class="ornate-border p-1 rounded-md">
                <div class="panel-header p-3 rounded-t-sm">
                    <h2 class="font-heading text-xl text-[#a1722f]">Bug Reports</h2>
                </div>
                <div class="panel-content-dark p-4">
                    <h3 class="font-heading font-bold text-lg text-[#a1722f]">Have You Found A Bug?</h3>
                    <p class="text-xs text-[#a1722f]/75 mb-2">Dackary McDab on 07/05/25</p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="text-sm text-[#a1722f]/90 space-y-3">
                            <p>Have you found a bug in the system? Let us know!</p>
                            <p>Bugs Can Be Reported to <a href="mailto:dnd@nerdygamertools.com" class="text-[#a1722f] hover:underline">dnd@nerdygamertools.com</a>.</p>
                        </div>
                        <img src="https://placehold.co/100x100/221502/a1722f?text=BUGS" alt="Bugs Placeholder" class="w-24 h-24 object-cover shadow-inner flex-shrink-0 rounded">
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>