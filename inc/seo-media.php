<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_rank_math_page_image_map(): array
{
    return array(
        'home' => 'hero-bg.png',
        'services' => 'account-setup.png',
        'how-it-works' => 'verified-account.png',
        'pricing' => 'workspace-flatlay.png',
        'blog' => 'workspace-flatlay.png',
        'faq' => 'hero-bg.png',
        'contact' => 'team-photo.png',
        'terms-of-service' => 'hero-bg.png',
        'privacy-policy' => 'hero-bg.png',
    );
}

function betpro_account_seo_image_url(int $post_id = 0, string $page_slug = ''): string
{
    if ($post_id > 0) {
        $thumbnail_url = get_the_post_thumbnail_url($post_id, 'full');

        if (is_string($thumbnail_url) && $thumbnail_url !== '') {
            return $thumbnail_url;
        }

        $cover_image = (string) get_post_meta($post_id, 'betpro_cover_image', true);

        if ($cover_image !== '') {
            return betpro_account_managed_asset_url('images/' . ltrim($cover_image, '/'));
        }
    }

    if ($page_slug !== '') {
        $image_key = betpro_account_rank_math_page_image_map()[$page_slug] ?? '';

        if ($image_key !== '') {
            return betpro_account_managed_asset_url('images/' . $image_key);
        }
    }

    return betpro_account_default_asset_url('opengraph.jpg');
}

function betpro_account_current_seo_image(): string
{
    $post = betpro_account_current_post_data();

    if (is_array($post) && ! empty($post['id'])) {
        return betpro_account_seo_image_url((int) $post['id']);
    }

    $page = betpro_account_current_page_data();

    if (is_array($page)) {
        return betpro_account_seo_image_url((int) ($page['id'] ?? 0), (string) ($page['slug'] ?? ''));
    }

    if (is_archive()) {
        return betpro_account_seo_image_url(0, 'blog');
    }

    return betpro_account_default_asset_url('opengraph.jpg');
}

function betpro_account_content_metrics(string $html): array
{
    $metrics = array(
        'h1' => preg_match_all('/<h1\b/i', $html),
        'h2' => preg_match_all('/<h2\b/i', $html),
        'img' => preg_match_all('/<img\b/i', $html),
        'internal_links' => 0,
        'external_links' => 0,
    );

    if (preg_match_all('/<a\b[^>]*href=(["\'])([^"\']+)\1/i', $html, $matches) !== false) {
        $site_host = (string) wp_parse_url(home_url('/'), PHP_URL_HOST);

        foreach ($matches[2] as $url) {
            if (! is_string($url) || $url === '' || str_starts_with($url, '#')) {
                continue;
            }

            if (str_starts_with($url, '/')) {
                $metrics['internal_links']++;
                continue;
            }

            if (! betpro_account_is_absolute_url($url)) {
                $metrics['internal_links']++;
                continue;
            }

            $host = (string) wp_parse_url($url, PHP_URL_HOST);

            if ($host !== '' && $host === $site_host) {
                $metrics['internal_links']++;
            } elseif (! str_starts_with($url, 'mailto:') && ! str_starts_with($url, 'tel:')) {
                $metrics['external_links']++;
            }
        }
    }

    return $metrics;
}

function betpro_account_seo_support_block(string $heading, string $description, string $image_url, string $image_alt, array $links): string
{
    ob_start();
    ?>
    <section class="betpro-seo-support mt-12 space-y-6">
        <h2><?php echo esc_html($heading); ?></h2>
        <p><?php echo esc_html($description); ?></p>
        <figure class="wp-block-image size-large">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_alt); ?>" />
        </figure>
        <ul>
            <?php foreach ($links as $link) : ?>
                <li><a href="<?php echo esc_url((string) ($link['url'] ?? '')); ?>"><?php echo esc_html((string) ($link['label'] ?? '')); ?></a></li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php

    return trim((string) ob_get_clean());
}

function betpro_account_default_support_links(): array
{
    return array(
        array('label' => __('Our Services', 'betpro-account'), 'url' => home_url('/services/')),
        array('label' => __('How It Works', 'betpro-account'), 'url' => home_url('/how-it-works/')),
        array('label' => __('FAQ', 'betpro-account'), 'url' => home_url('/faq/')),
        array('label' => __('Contact', 'betpro-account'), 'url' => home_url('/contact/')),
        array('label' => __('Blog', 'betpro-account'), 'url' => home_url('/blog/')),
    );
}

function betpro_account_sync_auto_thumbnail(int $post_id, int $attachment_id, string $source): void
{
    if ($post_id <= 0 || $attachment_id <= 0 || get_post_type($attachment_id) !== 'attachment') {
        return;
    }

    $current_thumbnail_id = (int) get_post_thumbnail_id($post_id);
    $stored_source = (string) get_post_meta($post_id, '_betpro_auto_thumbnail_source', true);
    $stored_thumbnail_id = (int) get_post_meta($post_id, '_betpro_auto_thumbnail_id', true);

    if ($current_thumbnail_id === 0) {
        set_post_thumbnail($post_id, $attachment_id);
        update_post_meta($post_id, '_betpro_auto_thumbnail_source', $source);
        update_post_meta($post_id, '_betpro_auto_thumbnail_id', $attachment_id);
        return;
    }

    if ($current_thumbnail_id === $attachment_id) {
        update_post_meta($post_id, '_betpro_auto_thumbnail_source', $source);
        update_post_meta($post_id, '_betpro_auto_thumbnail_id', $attachment_id);
        return;
    }

    if ($stored_source !== $source) {
        return;
    }

    if ($stored_thumbnail_id > 0 && $current_thumbnail_id === $stored_thumbnail_id) {
        set_post_thumbnail($post_id, $attachment_id);
        update_post_meta($post_id, '_betpro_auto_thumbnail_id', $attachment_id);
        return;
    }

    delete_post_meta($post_id, '_betpro_auto_thumbnail_source');
    delete_post_meta($post_id, '_betpro_auto_thumbnail_id');
}

function betpro_account_sync_rank_math_media_assets(): void
{
    if (! function_exists('betpro_account_media_assignments')) {
        return;
    }

    $assignments = betpro_account_media_assignments();

    if (! is_array($assignments) || empty($assignments)) {
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

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'numberposts' => -1,
        'fields' => 'ids',
        'meta_key' => 'betpro_cover_image',
    );

    if (! empty($blocked_ids)) {
        $args['post__not_in'] = $blocked_ids;
    }

    $posts = get_posts($args);

    foreach ($posts as $post_id) {
        $post_id = (int) $post_id;
        $filename = (string) get_post_meta($post_id, 'betpro_cover_image', true);
        $attachment_id = absint($assignments[$filename] ?? 0);

        if ($filename === '' || $attachment_id <= 0) {
            continue;
        }

        betpro_account_sync_auto_thumbnail($post_id, $attachment_id, 'post-cover:' . $filename);
    }

    foreach (betpro_account_rank_math_page_image_map() as $slug => $filename) {
        $page_id = betpro_account_find_page_id_by_slug($slug);
        $attachment_id = absint($assignments[$filename] ?? 0);

        if ($page_id <= 0 || $attachment_id <= 0) {
            continue;
        }

        betpro_account_sync_auto_thumbnail($page_id, $attachment_id, 'page-cover:' . $slug);
    }
}

function betpro_account_maybe_sync_rank_math_media_assets(): void
{
    if (! function_exists('betpro_account_media_assignments')) {
        return;
    }

    $assignments = betpro_account_media_assignments();
    $encoded = wp_json_encode($assignments);
    $signature = is_string($encoded) ? md5($encoded) : '';

    if ($signature === '') {
        return;
    }

    $option_name = 'betpro_rank_math_media_signature';
    $stored_signature = (string) get_option($option_name, '');

    if ($stored_signature === $signature) {
        return;
    }

    betpro_account_sync_rank_math_media_assets();
    update_option($option_name, $signature, false);
}
add_action('init', 'betpro_account_maybe_sync_rank_math_media_assets', 25);
