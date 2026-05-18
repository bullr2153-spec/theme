<?php

if (! defined('ABSPATH')) {
    exit;
}

$betpro_account_include_files = array(
    'inc/core.php',
    'inc/document-media.php',
    'inc/settings-assets.php',
    'inc/generated-pages.php',
    'inc/seo-media.php',
    'inc/admin-inquiries.php',
    'inc/content-seeding.php',
    'inc/frontend-data.php',
    'inc/template-tags.php',
    'inc/navigation-template.php',
    'inc/page-hero.php',
    'inc/page-sections.php',
    'inc/post-cards.php',
    'inc/frontend-assets.php',
    'inc/frontend-contact.php',
    'inc/rendering.php',
    'inc/content-releases.php',
);

foreach ($betpro_account_include_files as $betpro_account_include_file) {
    require_once __DIR__ . '/' . $betpro_account_include_file;
}

unset($betpro_account_include_files, $betpro_account_include_file);
