<?php
/**
 * Dacks CMS - Global Functions Library
 *
 * @project       Dacks CMS
 * @version       v.0.0.2
 * @author        Dackary McDab / Zachary MacPhee (MacWeb Canada | https://macweb.ca/)
 * @description   This file is a library of global helper functions for the Dacks CMS
 * application. Functions defined here are available throughout the
 * site and should be generic and reusable. This file does not
 * produce any HTML output.
 * @last_updated  July 5, 2025
 */


// ===================================================================
// SECTION 1: URL & ROUTING FUNCTIONS
// ===================================================================

/**
 * Generates a clean, full URL for a given page slug.
 *
 * @param string $page The page name/slug (e.g., 'tournaments').
 * @return string The full, clean URL (e.g., http://yoursite.com/tournaments).
 */
function get_page_url($page) {
    // Sanitize the page parameter to prevent injection
    $page = htmlspecialchars($page, ENT_QUOTES, 'UTF-8');
    
    // Remove any potential path traversal attempts
    $page = str_replace(['../', '..\\', './'], '', $page);
    
    // Appends the page name to the dynamic BASE_URL to create a clean URL.
    return BASE_URL . $page;
}


// ===================================================================
// SECTION 2: SECURITY & SANITIZATION FUNCTIONS
// ===================================================================

/**
 * Escapes a string for safe HTML output to prevent Cross-Site Scripting (XSS) attacks.
 * This is a convenient shorthand for the native htmlspecialchars() function.
 *
 * @param string|null $string The raw string to escape.
 * @return string The escaped, safe-to-display string.
 */
function esc($string) {
    // Handle null input gracefully
    if ($string === null) {
        return '';
    }
    
    // Handle non-string types by converting to string first
    if (!is_string($string)) {
        $string = (string) $string;
    }
    
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}


// ===================================================================
// SECTION 3: STRING & FORMATTING FUNCTIONS
// ===================================================================

/**
 * Truncates a string to a specified length and appends an ellipsis
 * if the string exceeds the limit. This function is multi-byte safe,
 * correctly handling special characters.
 *
 * @param string|null $text The input string.
 * @param int $length The maximum length of the string before truncation.
 * @param string $ellipsis The character(s) to append if the string is truncated.
 * @return string The truncated (or original) string.
 */
function truncate_text($text, $length = 100, $ellipsis = '...') {
    // Handle null input gracefully
    if ($text === null) {
        return '';
    }
    
    // Convert to string if not already
    $text = (string) $text;
    
    // Validate length parameter
    if (!is_int($length) || $length < 0) {
        $length = 100;
    }
    
    // If text is shorter than limit, return as-is
    if (mb_strlen($text) <= $length) {
        return $text;
    }
    
    // Truncate and add ellipsis
    $truncated = mb_substr($text, 0, $length);
    return $truncated . $ellipsis;
}


// ===================================================================
// SECTION 4: VALIDATION & UTILITY FUNCTIONS
// ===================================================================

/**
 * Validates if a string is a valid slug (alphanumeric, hyphens, underscores only).
 *
 * @param string $slug The slug to validate.
 * @return bool True if valid, false otherwise.
 */
function is_valid_slug($slug) {
    return preg_match('/^[a-zA-Z0-9_-]+$/', $slug) === 1;
}

/**
 * Sanitizes a filename to prevent directory traversal and invalid characters.
 *
 * @param string $filename The filename to sanitize.
 * @return string The sanitized filename.
 */
function sanitize_filename($filename) {
    // Remove directory traversal attempts
    $filename = str_replace(['../', '..\\', './', '.\\'], '', $filename);
    
    // Remove null bytes
    $filename = str_replace(chr(0), '', $filename);
    
    // Keep only alphanumeric, dots, hyphens, and underscores
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '', $filename);
    
    // Ensure it doesn't start with a dot (hidden file)
    $filename = ltrim($filename, '.');
    
    return $filename;
}