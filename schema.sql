-- DackCMS — database schema and seed data (MySQL 5.7+ / MariaDB 10.2+)
-- Charset: utf8mb4 for full Unicode (emojis, smart quotes in content).
--
-- Create DB (once): mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS dackcms CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
-- Load:          mysql -u root -p dackcms < schema.sql
--
-- This script DROPS existing DackCMS tables in this database, then recreates them.
--
-- Demo logins — password for all accounts: password
--   admin@example.com   — Administrator (role 2)
--   member@example.com  — Member (role 5)
--   mod@example.com     — Moderator (role 3)
-- Bcrypt hash below matches PHP password_verify('password', ...).

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS news;
DROP TABLE IF EXISTS page_permissions;
DROP TABLE IF EXISTS page_meta;
DROP TABLE IF EXISTS pages;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS roles;

SET FOREIGN_KEY_CHECKS = 1;

-- ---------------------------------------------------------------------------
-- Schema
-- ---------------------------------------------------------------------------

CREATE TABLE roles (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    name VARCHAR(64) NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_roles_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE users (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    display_name VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role_id INT UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_users_email (email),
    UNIQUE KEY uq_users_display_name (display_name),
    KEY idx_users_role (role_id),
    CONSTRAINT fk_users_role FOREIGN KEY (role_id) REFERENCES roles (id)
        ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pages (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    slug VARCHAR(128) NOT NULL,
    content_path VARCHAR(255) NOT NULL COMMENT 'Filename under pages/, e.g. home.php',
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_pages_slug (slug),
    KEY idx_pages_active (is_active)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- page_scope: COALESCE(page_id,0) so exactly one site-default row (page_id NULL -> 0) and one meta row per real page.
CREATE TABLE page_meta (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    page_id INT UNSIGNED DEFAULT NULL COMMENT 'NULL = site-wide default meta (one row only)',
    meta_title VARCHAR(255) NOT NULL,
    meta_description TEXT,
    meta_keywords VARCHAR(512) DEFAULT NULL,
    og_image VARCHAR(512) DEFAULT NULL,
    page_scope INT UNSIGNED GENERATED ALWAYS AS (COALESCE(page_id, 0)) STORED,
    PRIMARY KEY (id),
    UNIQUE KEY uq_page_meta_scope (page_scope),
    CONSTRAINT fk_page_meta_page FOREIGN KEY (page_id) REFERENCES pages (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE page_permissions (
    page_id INT UNSIGNED NOT NULL,
    role_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (page_id, role_id),
    CONSTRAINT fk_pp_page FOREIGN KEY (page_id) REFERENCES pages (id)
        ON UPDATE CASCADE ON DELETE CASCADE,
    CONSTRAINT fk_pp_role FOREIGN KEY (role_id) REFERENCES roles (id)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE news (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(120) NOT NULL,
    body MEDIUMTEXT NOT NULL,
    image_url VARCHAR(512) DEFAULT NULL,
    publish_date DATE NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    KEY idx_news_publish_date (publish_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ---------------------------------------------------------------------------
-- Seed: roles (id 5 must stay Member — see register.php default_role_id)
-- ---------------------------------------------------------------------------

INSERT INTO roles (id, name) VALUES
    (1, 'Guest'),
    (2, 'Administrator'),
    (3, 'Moderator'),
    (4, 'Contributor'),
    (5, 'Member');

-- ---------------------------------------------------------------------------
-- Seed: users (password = "password")
-- ---------------------------------------------------------------------------

INSERT INTO users (display_name, email, password, role_id) VALUES
    (
        'Site Admin',
        'admin@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        2
    ),
    (
        'Aldric the Bold',
        'member@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        5
    ),
    (
        'Mod Morgan',
        'mod@example.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        3
    );

-- ---------------------------------------------------------------------------
-- Seed: pages (slug = clean URL segment; content_path = file in /pages/)
-- ---------------------------------------------------------------------------

INSERT INTO pages (id, slug, content_path, is_active) VALUES
    (1, 'home', 'home.php', 1),
    (2, 'about', 'about.php', 1),
    (3, 'contact', 'contact.php', 1),
    (4, 'news', 'news.php', 1),
    (5, 'login', 'login.php', 1),
    (6, 'register', 'register.php', 1),
    (7, 'profile', 'profile.php', 1),
    (8, 'logout', 'logout.php', 1),
    (9, '404', '404.php', 1);

-- ---------------------------------------------------------------------------
-- Seed: page_meta (default row first: page_id NULL; then overrides for pages 2–4)
-- ---------------------------------------------------------------------------

INSERT INTO page_meta (id, page_id, meta_title, meta_description, meta_keywords, og_image) VALUES
    (
        1,
        NULL,
        'Modern Fantasy',
        'Tabletop tools, news, and community for your next campaign.',
        'rpg,dnd,fantasy,tools,news',
        ''
    );

INSERT INTO page_meta (page_id, meta_title, meta_description, meta_keywords, og_image) VALUES
    (2, 'About Us | Modern Fantasy', 'Mission, team, and story behind Modern Fantasy.', 'about,team,mission', ''),
    (3, 'Contact | Modern Fantasy', 'Reach the Modern Fantasy team.', 'contact,support', ''),
    (4, 'News Archive | Modern Fantasy', 'Updates, patch notes, and announcements.', 'news,updates', '');

-- ---------------------------------------------------------------------------
-- Seed: page_permissions — profile restricted to logged-in roles (not Guest / session role 0)
-- ---------------------------------------------------------------------------

INSERT INTO page_permissions (page_id, role_id) VALUES
    (7, 2),
    (7, 3),
    (7, 4),
    (7, 5);

-- ---------------------------------------------------------------------------
-- Seed: news
-- ---------------------------------------------------------------------------

INSERT INTO news (title, author, body, image_url, publish_date) VALUES
    (
        'Welcome to the Realm',
        'Site Admin',
        '<p>We are live! Explore <strong>news</strong>, tools, and community links from the home page.</p><p>Stay tuned for character sheets, dice rollers, and more.</p>',
        NULL,
        '2026-03-15'
    ),
    (
        'Patch Notes v0.0.2',
        'Mod Morgan',
        '<p>Routing and security improvements, clearer error logging, and a working contact form pipeline.</p><ul><li>Database-driven pages</li><li>Role-based access on profile</li></ul>',
        'https://placehold.co/800x400/221502/a1722f?text=Patch+Notes',
        '2026-04-01'
    ),
    (
        'Community Spotlight',
        'Aldric the Bold',
        '<p>Share your best session moments — we will feature standout stories in a future post.</p>',
        NULL,
        '2026-04-03'
    ),
    (
        'Weekend One-Shot Ideas',
        'Site Admin',
        '<p>Need a quick adventure? Try a <em>haunted ferry</em>, a <em>marketplace mystery</em>, or a <em>single-room dungeon</em> with three clues and a twist.</p>',
        NULL,
        '2026-04-04'
    );
