<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_normalize_menu_url(string $url): string
{
    $site_host = wp_parse_url(home_url('/'), PHP_URL_HOST);
    $url_host = wp_parse_url($url, PHP_URL_HOST);

    if ($url_host === null || $url_host === $site_host) {
        $relative = wp_make_link_relative($url);

        return $relative !== '' ? $relative : '/';
    }

    return $url;
}

function betpro_account_menu_items(string $location): array
{
    $locations = get_nav_menu_locations();

    if (empty($locations[$location])) {
        return array();
    }

    $items = wp_get_nav_menu_items($locations[$location]);

    if (! is_array($items)) {
        return array();
    }

    $serialized = array();

    foreach ($items as $item) {
        if ((int) $item->menu_item_parent !== 0) {
            continue;
        }

        $serialized[] = array(
            'id' => (int) $item->ID,
            'title' => html_entity_decode((string) $item->title, ENT_QUOTES, get_bloginfo('charset')),
            'url' => betpro_account_normalize_menu_url((string) $item->url),
            'target' => (string) $item->target,
        );
    }

    return $serialized;
}

function betpro_account_serialize_page(WP_Post $post): array
{
    return array(
        'id' => (int) $post->ID,
        'slug' => $post->post_name,
        'title' => get_the_title($post),
        'excerpt' => get_the_excerpt($post),
        'content' => apply_filters('the_content', $post->post_content),
    );
}

function betpro_account_normalize_post_media_value(string $value): string
{
    $value = trim($value);

    if ($value === '') {
        return '';
    }

    if (betpro_account_is_absolute_url($value)) {
        return $value;
    }

    if (str_contains($value, '/')) {
        return betpro_account_managed_asset_url($value);
    }

    return betpro_account_managed_asset_url('images/' . $value);
}

function betpro_account_post_cover_image(WP_Post $post): string
{
    $cover_image = betpro_account_normalize_post_media_value((string) get_post_meta($post->ID, 'betpro_cover_image', true));

    if ($cover_image !== '') {
        return $cover_image;
    }

    $thumbnail_url = get_the_post_thumbnail_url($post, 'full');

    if (is_string($thumbnail_url) && $thumbnail_url !== '') {
        return $thumbnail_url;
    }

    return betpro_account_seo_image_url((int) $post->ID);
}

function betpro_account_post_author_name(WP_Post $post): string
{
    $author_name = trim((string) get_post_meta($post->ID, 'betpro_author_name', true));

    if ($author_name !== '') {
        return $author_name;
    }

    $display_name = trim((string) get_the_author_meta('display_name', (int) $post->post_author));

    if ($display_name !== '' && strtolower($display_name) !== 'admin') {
        return $display_name;
    }

    return __('BetPro Account Team', 'betpro-account');
}

function betpro_account_post_author_title(WP_Post $post): string
{
    $author_title = trim((string) get_post_meta($post->ID, 'betpro_author_title', true));

    if ($author_title !== '') {
        return $author_title;
    }

    return __('BetPro Account Editorial Team', 'betpro-account');
}

function betpro_account_post_author_avatar(WP_Post $post): string
{
    $avatar = betpro_account_normalize_post_media_value((string) get_post_meta($post->ID, 'betpro_author_avatar', true));

    if ($avatar !== '') {
        return $avatar;
    }

    $author_avatar = get_avatar_url(
        (int) $post->post_author,
        array(
            'size' => 96,
            'default' => 'mystery',
        )
    );

    if (is_string($author_avatar) && $author_avatar !== '') {
        return $author_avatar;
    }

    return betpro_account_default_asset_url('favicon.webp');
}

function betpro_account_serialize_post(WP_Post $post): array
{
    $categories = get_the_category($post->ID);
    $category_name = ! empty($categories) ? $categories[0]->name : '';

    return array(
        'id' => (int) $post->ID,
        'slug' => $post->post_name,
        'title' => get_the_title($post),
        'excerpt' => get_the_excerpt($post),
        'category' => $category_name,
        'readTime' => (string) get_post_meta($post->ID, 'betpro_read_time', true),
        'date' => get_the_date('F j, Y', $post),
        'coverImage' => betpro_account_post_cover_image($post),
        'author' => array(
            'name' => betpro_account_post_author_name($post),
            'title' => betpro_account_post_author_title($post),
            'avatar' => betpro_account_post_author_avatar($post),
        ),
        'content' => apply_filters('the_content', $post->post_content),
    );
}

function betpro_account_current_page_data(): ?array
{
    if (is_front_page()) {
        $front_page_id = (int) get_option('page_on_front');

        if ($front_page_id > 0) {
            $front_page = get_post($front_page_id);

            if ($front_page instanceof WP_Post) {
                return betpro_account_serialize_page($front_page);
            }
        }
    }

    if (is_page()) {
        $page = get_queried_object();

        if ($page instanceof WP_Post) {
            return betpro_account_serialize_page($page);
        }
    }

    return null;
}

function betpro_account_current_post_data(): ?array
{
    if (! is_singular('post')) {
        return null;
    }

    $post = get_queried_object();

    return $post instanceof WP_Post ? betpro_account_serialize_post($post) : null;
}

function betpro_account_should_include_blog_posts(): bool
{
    if (is_singular('post')) {
        return true;
    }

    if (! is_page()) {
        return false;
    }

    $page = get_queried_object();

    return $page instanceof WP_Post && $page->post_name === 'blog';
}

function betpro_account_blog_posts_data(): array
{
    if (! betpro_account_should_include_blog_posts()) {
        return array();
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

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'numberposts' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if (! empty($blocked_ids)) {
        $args['post__not_in'] = $blocked_ids;
    }

    $posts = get_posts($args);

    return array_map('betpro_account_serialize_post', $posts);
}
