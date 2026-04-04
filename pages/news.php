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
    error_log('News archive query failed: ' . $e->getMessage());
    $news_articles = [];
}
?>

<div class="grid grid-cols-1 lg:grid-cols-[250px_1fr] gap-3">

    <?php include_once ROOT_PATH . '/includes/partials/sidebar-left-docs-nav.php'; ?>

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