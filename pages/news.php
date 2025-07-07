<?php
/**
 * Dacks CMS - News Archive Page
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file provides the content for the news archive page.
 * It fetches and displays all news articles from the database
 * alongside the standard left sidebar.
 * @last_updated  July 5, 2025
 */

//===================================================================
// SECTION 1: DATA FETCHING
//===================================================================
// Fetches all news articles from the database, ordered by publish date.

try {
    $stmt = $pdo->query("SELECT title, author, body, image_url, publish_date FROM news ORDER BY publish_date DESC");
    $news_articles = $stmt->fetchAll();
} catch (PDOException $e) {
    // In a production environment, this error should be logged.
    // error_log("News archive query failed: " . $e->getMessage());
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
        <div class="mt-3 p-6 shadow-inner bg-[#221502]/40 rounded-md">

            <h1 class="font-heading text-2xl text-[#a1722f]">News Archive</h1>
            <p class="text-sm text-[#a1722f]/80 mb-6 border-b border-b-[#221502]/50 pb-4">All the latest updates and announcements.</p>

            <div class="space-y-6">
                <?php if (empty($news_articles)): ?>
                    <p class="text-center text-[#a1722f]/90">No news articles have been posted yet.</p>
                <?php else: ?>
                    <?php foreach ($news_articles as $article): ?>
                        <article class="flex flex-col md:flex-row gap-6">
                            <?php if (!empty($article['image_url'])): ?>
                                <div class="md:w-1/3 flex-shrink-0">
                                    <img src="<?php echo esc($article['image_url']); ?>" alt="<?php echo esc($article['title']); ?>" class="w-full h-48 object-cover rounded-md shadow-lg">
                                </div>
                            <?php endif; ?>
                            <div class="flex-grow">
                                <h2 class="font-heading text-xl text-[#a1722f]"><?php echo esc($article['title']); ?></h2>
                                <p class="text-xs text-[#a1722f]/75 mt-1 mb-3">
                                    Posted by <?php echo esc($article['author']); ?> on <span class="text-[#a1722f]/50"><?php echo date('F j, Y', strtotime($article['publish_date'])); ?></span>
                                </p>
                                <div class="text-[#a1722f]/90 text-sm space-y-3">
                                    <?php echo $article['body']; // Assumed to be safe HTML from a WYSIWYG editor ?>
                                </div>
                            </div>
                        </article>
                        <hr class="border-t-2 border-[#221502]/30 last:hidden">
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

        </div>
    </main>
</div>