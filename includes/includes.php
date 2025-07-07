<?php
/**
 * Dacks CMS - Main Application Controller
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file acts as the primary controller or bootstrap for the
 * application. It handles URL routing based on database rules,
 * checks user permissions, and assembles the final HTML document.
 * @last_updated  July 5, 2025
 */

//===================================================================
// SECTION 1: DATABASE-DRIVEN URL ROUTER WITH PERMISSIONS
//===================================================================

// 1. Get the requested slug from the .htaccess rewrite rule.
$url_slug = trim($_GET['url'] ?? 'home', '/');
if (empty($url_slug)) {
    $url_slug = 'home';
}

// 2. Get the current user's role ID from the authentication system.
$user_role_id = getCurrentUserRole();

// 3. Query the database for an active and permitted page and its meta data.
try {
    // This query joins pages with page_meta. It uses COALESCE to select the
    // page-specific meta data if it exists, otherwise it falls back to the
    // default meta data (where page_id is NULL). It then checks permissions.
    $sql = "
        SELECT
            p.id,
            p.content_path,
            COALESCE(pm.title, dpm.title) AS meta_title,
            COALESCE(pm.description, dpm.description) AS meta_description,
            COALESCE(pm.keywords, dpm.keywords) AS meta_keywords,
            COALESCE(pm.og_image, dpm.og_image) AS og_image
        FROM
            pages p
        LEFT JOIN page_meta pm ON p.id = pm.page_id
        CROSS JOIN page_meta dpm
        WHERE
            p.slug = :slug
            AND p.is_active = 1
            AND dpm.page_id IS NULL
            AND (
                -- Condition 1: The page is public (has no role restrictions).
                NOT EXISTS (SELECT 1 FROM page_permissions pp WHERE pp.page_id = p.id)
                OR
                -- Condition 2: The user's role is explicitly allowed on the page.
                EXISTS (SELECT 1 FROM page_permissions pp WHERE pp.page_id = p.id AND pp.role_id = :user_role_id)
            )
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['slug' => $url_slug, 'user_role_id' => $user_role_id]);
    $page_data = $stmt->fetch();

} catch (PDOException $e) {
    // In a production environment, this error should be logged.
    error_log("Router query failed: " . $e->getMessage());
    $page_data = false;
    die("A critical error occurred while loading page data.");
}

// 4. Determine which page content and metadata to use based on the query result.
if ($page_data) {
    // Page was found and user has permission.
    $requested_page = $url_slug;
    
    // SECURITY: Validate content path to prevent directory traversal
    $content_path = $page_data['content_path'];
    
    // Remove any potential directory traversal attempts
    $content_path = str_replace(['../', '..\\', './'], '', $content_path);
    
    // Ensure the path is within the pages directory
    $page_path = realpath(ROOT_PATH . '/pages/' . $content_path);
    $pages_dir = realpath(ROOT_PATH . '/pages/');
    
    if (!$page_path || !str_starts_with($page_path, $pages_dir)) {
        // Path traversal attempt detected or file doesn't exist
        error_log("Security: Invalid content path attempted: " . $page_data['content_path']);
        $requested_page = '404';
        $page_path = ROOT_PATH . '/pages/404.php';
    }
    
    $meta_data = $page_data;
} else {
    // No permitted page was found, so load the 404 page content.
    $requested_page = '404';
    $page_path = ROOT_PATH . '/pages/404.php';
    
    // For the 404 page, we need to get the default meta data directly.
    try {
        $stmt = $pdo->query("SELECT * FROM page_meta WHERE page_id IS NULL LIMIT 1");
        $meta_data = $stmt->fetch();
    } catch (PDOException $e) {
        error_log("Failed to fetch default meta data: " . $e->getMessage());
        $meta_data = false;
    }
}

// Fallback meta data if database query fails
if (!$meta_data) {
    $meta_data = [
        'meta_title' => SITE_TITLE,
        'meta_description' => 'Welcome to ' . SITE_TITLE,
        'meta_keywords' => '',
        'og_image' => ''
    ];
}

//===================================================================
// SECTION 2: PAGE ASSEMBLY
//===================================================================
// Special case: If the requested page is an action (like logout), include it directly and exit before any output.
$action_pages = ['logout'];
if (in_array($requested_page, $action_pages)) {
    if (file_exists($page_path)) {
        include_once $page_path;
    } else {
        include_once ROOT_PATH . '/pages/404.php';
    }
    exit();
}

// 1. Include the Header.
include_once ROOT_PATH . '/includes/header.php';

?>

<div class="p-2 grid grid-cols-1 xl:grid-cols-[1fr_300px] gap-3 pt-3 bg-[#5d170b]/30">

    <?php
    // 2. Include the Dynamic Page Content.
    // This loads the main content and left-sidebar for the requested page.
    if (file_exists($page_path)) {
        include_once $page_path;
    } else {
        // Fallback to 404 content if the file specified in the DB is missing.
        include_once ROOT_PATH . '/pages/404.php';
    }
    ?>

    <?php
    // 3. Include the persistent Right Sidebar.
    include_once ROOT_PATH . '/includes/sidebar-right.php';
    ?>

</div>

<?php
// 4. Include the Footer to close the page.
include_once ROOT_PATH . '/includes/footer.php';
?>