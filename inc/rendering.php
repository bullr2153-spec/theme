<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_render_seo_fallback(): void
{
    if (is_404()) {
        echo '<section class="betpro-seo-fallback max-w-3xl mx-auto px-4 py-12">';
        echo '<h1 class="text-4xl font-extrabold mb-4">' . esc_html__('Page Not Found', 'betpro-account') . '</h1>';
        echo '<p class="text-lg text-muted-foreground mb-6">' . esc_html__('The page you are looking for does not exist or may have moved.', 'betpro-account') . '</p>';
        echo betpro_account_seo_support_block(
            __('Explore BetPro Pages', 'betpro-account'),
            __('Use these internal links to reach our services, blog, and support pages.', 'betpro-account'),
            betpro_account_default_asset_url('opengraph.jpg'),
            __('BetPro Account verified betting accounts and support', 'betpro-account'),
            betpro_account_default_support_links()
        );
        echo '</section>';
        return;
    }

    // Block direct access to test/draft content
    $blocked_slugs = array('first-testing-post', 'first-testing', 'testing-post', 'test-post', 'draft');
    $requested_path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    foreach ($blocked_slugs as $blocked) {
        if (strpos($requested_path, $blocked) !== false) {
            wp_redirect(home_url('/blog/'), 301);
            exit;
        }
    }

    if (is_archive()) {
        $archive_title = trim(wp_strip_all_tags(get_the_archive_title()));
        $archive_description = trim(wp_strip_all_tags(get_the_archive_description()));
        $archive_image = betpro_account_current_seo_image();

        echo '<section class="betpro-seo-fallback max-w-5xl mx-auto px-4 py-12">';
        printf(
            '<figure class="wp-block-image size-large mb-8"><img src="%s" alt="%s" /></figure>',
            esc_url($archive_image),
            esc_attr__('BetPro Account archive page with latest guides and betting account articles', 'betpro-account')
        );

        if ($archive_title !== '') {
            printf('<h1 class="text-4xl font-extrabold mb-6">%s</h1>', esc_html($archive_title));
        }

        if ($archive_description !== '') {
            printf('<p class="text-lg text-muted-foreground mb-8">%s</p>', esc_html($archive_description));
        }

        global $wp_query;

        if ($wp_query instanceof WP_Query && ! empty($wp_query->posts)) {
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
                $wp_query->set('post__not_in', $blocked_ids);
            }

            echo '<div class="space-y-8">';

            foreach ($wp_query->posts as $archive_post) {
                if (! $archive_post instanceof WP_Post) {
                    continue;
                }

                $archive_post_title = get_the_title($archive_post);
                $archive_post_excerpt = get_the_excerpt($archive_post);
                $archive_post_url = get_permalink($archive_post);

                if ($archive_post_title === '' || ! is_string($archive_post_url) || $archive_post_url === '') {
                    continue;
                }

                printf(
                    '<article><h2 class="text-2xl font-bold mb-2"><a href="%s">%s</a></h2>%s</article>',
                    esc_url($archive_post_url),
                    esc_html($archive_post_title),
                    $archive_post_excerpt !== '' ? '<p class="text-muted-foreground">' . esc_html($archive_post_excerpt) . '</p>' : ''
                );
            }

            echo '</div>';
        }

        echo '</section>';
        return;
    }

    $post = betpro_account_current_post_data();

    if (is_array($post)) {
        $title = (string) ($post['title'] ?? '');
        $excerpt = (string) ($post['excerpt'] ?? '');
        $content = (string) ($post['content'] ?? '');
        $content = betpro_account_normalize_managed_html($content);
        $metrics = betpro_account_content_metrics($content);
        $image_url = betpro_account_seo_image_url((int) ($post['id'] ?? 0));

        if ($title === '' && $content === '') {
            return;
        }

        echo '<article class="betpro-seo-fallback max-w-4xl mx-auto px-4 py-12">';
        printf(
            '<figure class="wp-block-image size-large mb-8"><img src="%s" alt="%s" /></figure>',
            esc_url($image_url),
            esc_attr($title !== '' ? $title : __('BetPro Account blog article', 'betpro-account'))
        );

        if ($title !== '') {
            printf('<h1 class="text-4xl font-extrabold mb-6">%s</h1>', esc_html($title));
        }

        if ($excerpt !== '') {
            printf('<p class="text-lg text-muted-foreground mb-8">%s</p>', esc_html($excerpt));
        }

        if ($content !== '') {
            echo $content;
        }

        if ($metrics['internal_links'] === 0 || $metrics['img'] === 0) {
            echo betpro_account_seo_support_block(
                __('Related BetPro Resources', 'betpro-account'),
                __('Keep exploring verified betting account guides, our process, and direct support options from BetPro Account.', 'betpro-account'),
                $image_url,
                $title !== '' ? $title : __('BetPro Account blog article', 'betpro-account'),
                array(
                    array('label' => __('Back to Blog', 'betpro-account'), 'url' => home_url('/blog/')),
                    array('label' => __('Verified Betting Account Services', 'betpro-account'), 'url' => home_url('/services/')),
                    array('label' => __('How It Works', 'betpro-account'), 'url' => home_url('/how-it-works/')),
                    array('label' => __('Contact BetPro Account', 'betpro-account'), 'url' => home_url('/contact/')),
                )
            );
        }

        echo '</article>';
        return;
    }

    $page = betpro_account_current_page_data();

    if (! is_array($page)) {
        return;
    }

    $title = (string) ($page['title'] ?? '');
    $excerpt = (string) ($page['excerpt'] ?? '');
    $content = (string) ($page['content'] ?? '');
    $slug = (string) ($page['slug'] ?? '');
    $image_url = betpro_account_seo_image_url((int) ($page['id'] ?? 0), $slug);

    if (trim($content) === '' && in_array($slug, array('faq', 'contact', 'blog'), true)) {
        $content = betpro_account_generated_page_content($slug);
    }

    $content = betpro_account_normalize_managed_html($content);
    $metrics = betpro_account_content_metrics($content);
    $should_render_title = $title !== '' && $metrics['h1'] === 0;
    $should_render_excerpt = $excerpt !== '' && $content === '';

    echo '<section class="betpro-seo-fallback max-w-5xl mx-auto px-4 py-12">';

    if ($should_render_title) {
        printf('<h1 class="text-4xl font-extrabold mb-6">%s</h1>', esc_html($title));
    }

    if ($should_render_excerpt) {
        printf('<p class="text-lg text-muted-foreground mb-8">%s</p>', esc_html($excerpt));
    }

    if ($content !== '') {
        echo $content;
    }

    if ($metrics['h2'] === 0 || $metrics['img'] === 0 || $metrics['internal_links'] === 0) {
        echo betpro_account_seo_support_block(
            __('Explore More from BetPro Account', 'betpro-account'),
            __('Use these internal links to review our services, how-it-works process, FAQ, and contact options.', 'betpro-account'),
            $image_url,
            $title !== '' ? $title : __('BetPro Account page', 'betpro-account'),
            betpro_account_default_support_links()
        );
    }

    echo '</section>';
}

function betpro_account_render_app_shell(): void
{
    ?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="betpro-theme-version" content="<?php echo esc_attr(betpro_account_theme_version()); ?>">
    <meta name="betpro-theme-build" content="<?php echo esc_attr(betpro_account_frontend_build_id()); ?>">
    <script><?php echo betpro_account_theme_bootstrap_script(); ?></script>
    <style><?php echo betpro_account_loader_styles(); ?></style>
    <script><?php echo betpro_account_loader_bootstrap_script(); ?></script>
    <?php wp_head(); ?>
</head>
<body <?php body_class('betpro-account-theme'); ?>>
<?php
    if (function_exists('wp_body_open')) {
        wp_body_open();
    }
?>
<div id="betpro-shell-loader" role="status" aria-live="polite">
    <div class="betpro-loader-card">
        <div class="betpro-loader-mark" aria-hidden="true">
            <span class="betpro-loader-ring betpro-loader-ring--outer"></span>
            <span class="betpro-loader-ring betpro-loader-ring--inner"></span>
            <span class="betpro-loader-core">BP</span>
        </div>
        <div class="betpro-loader-eyebrow"><?php esc_html_e('Live Support Online', 'betpro-account'); ?></div>
        <div class="betpro-loader-title"><?php esc_html_e('BetPro Account', 'betpro-account'); ?></div>
        <p class="betpro-loader-text"><?php esc_html_e('Preparing a secure, fast experience for verified betting accounts.', 'betpro-account'); ?></p>
        <div class="betpro-loader-pills" aria-hidden="true">
            <span class="betpro-loader-pill"><?php esc_html_e('Secure Setup', 'betpro-account'); ?></span>
            <span class="betpro-loader-pill"><?php esc_html_e('Fast Delivery', 'betpro-account'); ?></span>
            <span class="betpro-loader-pill"><?php esc_html_e('24/7 Support', 'betpro-account'); ?></span>
        </div>
        <div class="betpro-loader-progress" aria-hidden="true"><span></span></div>
    </div>
</div>
<a class="screen-reader-text" href="#root"><?php esc_html_e('Skip to content', 'betpro-account'); ?></a>
<div id="root"><?php betpro_account_render_seo_fallback(); ?></div>
<?php wp_footer(); ?>
</body>
</html>
    <?php
}
