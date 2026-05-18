<?php

if (! defined('ABSPATH')) {
    exit;
}

if (! function_exists('str_contains')) {
    function str_contains(string $haystack, string $needle): bool
    {
        if ($needle === '') {
            return true;
        }

        return strpos($haystack, $needle) !== false;
    }
}

if (! function_exists('str_starts_with')) {
    function str_starts_with(string $haystack, string $needle): bool
    {
        if ($needle === '') {
            return true;
        }

        return strpos($haystack, $needle) === 0;
    }
}

if (! function_exists('str_ends_with')) {
    function str_ends_with(string $haystack, string $needle): bool
    {
        if ($needle === '') {
            return true;
        }

        return substr($haystack, -strlen($needle)) === $needle;
    }
}

function betpro_account_asset_dir(): string
{
    return get_template_directory() . '/assets/app';
}

function betpro_account_asset_uri(): string
{
    return get_template_directory_uri() . '/assets/app';
}

function betpro_account_theme_version(): string
{
    $theme = wp_get_theme();
    $version = $theme->get('Version');

    return is_string($version) && $version !== '' ? $version : '1.0.14';
}

function betpro_account_route_base(): string
{
    $path = wp_parse_url(home_url('/'), PHP_URL_PATH);

    if (! is_string($path) || $path === '' || $path === '/') {
        return '';
    }

    return untrailingslashit($path);
}

function betpro_account_rank_math_active(): bool
{
    return defined('RANK_MATH_VERSION');
}

function betpro_account_is_sitemap_request(): bool
{
    return function_exists('is_sitemap') && is_sitemap();
}

function betpro_account_primary_sitemap_url(): string
{
    return home_url(betpro_account_rank_math_active() ? '/sitemap_index.xml' : '/wp-sitemap.xml');
}

function betpro_account_request_path(): string
{
    $request_uri = isset($_SERVER['REQUEST_URI']) ? (string) wp_unslash($_SERVER['REQUEST_URI']) : '';
    $request_path = trim((string) wp_parse_url($request_uri, PHP_URL_PATH), '/');
    $route_base = trim(betpro_account_route_base(), '/');

    if ($route_base === '' || $request_path === '') {
        return $request_path;
    }

    if ($request_path === $route_base) {
        return '';
    }

    if (str_starts_with($request_path, $route_base . '/')) {
        return (string) substr($request_path, strlen($route_base) + 1);
    }

    return $request_path;
}

function betpro_account_theme_setup(): void
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails', array('post', 'page'));
    add_theme_support(
        'html5',
        array(
            'script',
            'style',
            'search-form',
            'gallery',
            'caption',
        )
    );

    register_nav_menus(
        array(
            'primary' => __('Primary Menu', 'betpro-account'),
            'footer_quick' => __('Footer Quick Links', 'betpro-account'),
            'footer_support' => __('Footer Support Links', 'betpro-account'),
        )
    );

    add_post_type_support('page', 'excerpt');
}
add_action('after_setup_theme', 'betpro_account_theme_setup');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'rsd_link');
add_filter('the_generator', '__return_empty_string');
add_filter('xmlrpc_enabled', '__return_false');
add_filter('pre_get_posts', 'betpro_account_hide_test_content');
add_filter('pre_get_posts', 'betpro_account_set_posts_per_page');
add_action('template_redirect', 'betpro_account_404_test_slug');
add_action('init', 'betpro_account_delete_test_post');

function betpro_account_set_posts_per_page(WP_Query $query): void
{
    if (!is_admin() && $query->is_main_query() && (is_home() || is_archive())) {
        $query->set('posts_per_page', 9);
    }
}

function betpro_account_hide_test_content(WP_Query $query): void
{
    if (is_admin() || ! $query->is_main_query()) {
        return;
    }

    $blocked_ids = array();

    $test_by_slug = get_page_by_path('first-testing-post', OBJECT, 'post');
    if ($test_by_slug && $test_by_slug instanceof WP_Post) {
        $blocked_ids[] = $test_by_slug->ID;
    }

    $test_by_title = get_page_by_title('first testing post', OBJECT, 'post');
    if ($test_by_title && $test_by_title instanceof WP_Post) {
        $blocked_ids[] = $test_by_title->ID;
    }

    if (! empty($blocked_ids)) {
        $query->set('post__not_in', $blocked_ids);
    }
}

function betpro_account_delete_test_post(): void
{
    static $deleted = false;

    if ($deleted) {
        return;
    }

    $deleted = true;

    $test_post = get_page_by_path('first-testing-post', OBJECT, 'post');

    if ($test_post && $test_post instanceof WP_Post) {
        wp_delete_post($test_post->ID, true);
        return;
    }

    $test_post_title = get_page_by_title('first testing post', OBJECT, 'post');

    if ($test_post_title && $test_post_title instanceof WP_Post) {
        wp_delete_post($test_post_title->ID, true);
        return;
    }

    if (function_exists('get_posts')) {
        $existing = get_posts(
            array(
                'post_type' => 'post',
                'post_status' => 'any',
                'name' => 'first-testing-post',
                'numberposts' => 1,
                'fields' => 'ids',
            )
        );

        if (! empty($existing)) {
            wp_delete_post((int) $existing[0], true);
        }
    }
}

function betpro_account_404_test_slug(): void
{
    if (is_admin() || wp_doing_ajax()) {
        return;
    }

    $requested_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    $blocked = array('first-testing-post', 'first-testing', 'testing-post', 'test-post');

    foreach ($blocked as $slug) {
        if (strpos($requested_path, $slug) !== false) {
            header('X-Robots-Tag: noindex, nofollow, noarchive', true);
            global $wp_query;
            $wp_query->set_404();
            status_header(404);
            nocache_headers();
            include get_query_template('404');
            exit;
        }
    }
}
