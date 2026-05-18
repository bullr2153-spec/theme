<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_seed_pages(): array
{
    $page_ids = array();

    foreach (betpro_account_default_pages() as $page_seed) {
        if (! is_array($page_seed) || empty($page_seed['slug']) || empty($page_seed['title'])) {
            continue;
        }

        $slug = sanitize_title((string) $page_seed['slug']);
        $page_content = (string) ($page_seed['content'] ?? '');
        $existing_id = betpro_account_find_page_id_by_slug($slug);

        if ($existing_id > 0) {
            $page_ids[$slug] = $existing_id;
            continue;
        }

        $page_id = wp_insert_post(
            wp_slash(
                array(
                    'post_type' => 'page',
                    'post_status' => 'publish',
                    'post_title' => (string) $page_seed['title'],
                    'post_name' => $slug,
                    'post_excerpt' => (string) ($page_seed['excerpt'] ?? ''),
                    'post_content' => $page_content !== '' ? $page_content : betpro_account_generated_page_content($slug),
                )
            ),
            true
        );

        if (! is_wp_error($page_id)) {
            $page_ids[$slug] = (int) $page_id;
        }
    }

    return $page_ids;
}



function betpro_account_assign_menu(string $location, string $menu_name, array $slugs): void
{
    $locations = get_nav_menu_locations();

    if (! empty($locations[$location])) {
        return;
    }

    $menu = wp_get_nav_menu_object($menu_name);
    $menu_id = $menu ? (int) $menu->term_id : (int) wp_create_nav_menu($menu_name);

    foreach ($slugs as $slug) {
        $page_id = betpro_account_find_page_id_by_slug($slug);

        if ($page_id > 0) {
            wp_update_nav_menu_item($menu_id, 0, array('menu-item-object-id' => $page_id, 'menu-item-object' => 'page', 'menu-item-type' => 'post_type', 'menu-item-status' => 'publish'));
        }
    }

    $locations[$location] = $menu_id;
    set_theme_mod('nav_menu_locations', $locations);
}

function betpro_account_seed_content(): void
{
    $page_ids = betpro_account_seed_pages();

    if (! empty($page_ids['home'])) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $page_ids['home']);
    }

    betpro_account_assign_menu('primary', 'Primary Menu', array('home', 'services', 'how-it-works', 'blog', 'faq', 'contact'));
    betpro_account_assign_menu('footer_quick', 'Footer Quick Links', array('home', 'services', 'how-it-works', 'contact'));
    betpro_account_assign_menu('footer_support', 'Footer Support Links', array('faq', 'contact', 'terms-of-service', 'privacy-policy'));
}

function betpro_account_after_switch_theme(): void
{
    betpro_account_add_post_rewrite_rule();
    betpro_account_seed_content();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'betpro_account_after_switch_theme');
