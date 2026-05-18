<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();
    $slug = (string) get_post_field('post_name', get_the_ID());

    if ($slug === 'blog') {
        betpro_account_render_page_hero(get_the_title(), get_the_excerpt(), 'blog');
        echo '<section class="betpro-content-section py-16 bg-background"><div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">';
        [$blog_query] = betpro_account_query_blog_posts(12);

        if ($blog_query instanceof WP_Query && $blog_query->have_posts()) {
            echo '<div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">';
            while ($blog_query->have_posts()) {
                $blog_query->the_post();
                betpro_account_render_post_card(get_post());
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p class="text-muted-foreground">' . esc_html__('No blog posts are published yet.', 'betpro-account') . '</p>';
        }

        echo '</div></section>';
        betpro_account_render_support_cta(__('Need help choosing a platform?', 'betpro-account'), __('Our team can recommend the right account setup based on your country, payment method, and requirements.', 'betpro-account'));
        continue;
    }

    $raw_content = (string) get_the_content(null, false);
    $is_default_generated_content = betpro_account_is_default_generated_page_content($slug, $raw_content);
    $content_width_class = in_array($slug, array('services', 'faq', 'contact'), true) ? 'max-w-7xl' : 'max-w-5xl';

    betpro_account_render_page_hero(get_the_title(), get_the_excerpt(), $slug);
    ?>
    <section class="betpro-content-section betpro-content-section--<?php echo esc_attr($slug); ?> py-16 bg-background">
        <div class="<?php echo esc_attr($content_width_class); ?> mx-auto px-4 sm:px-6 lg:px-8">
            <?php
            if ($slug === 'contact') {
                betpro_account_render_contact_overview();
            } elseif ($slug === 'services') {
                betpro_account_render_services_overview();
            } elseif ($slug === 'how-it-works') {
                betpro_account_render_process_overview();
            } elseif ($slug === 'faq' && (trim($raw_content) === '' || $is_default_generated_content)) {
                betpro_account_render_faq_overview();
            } else {
                betpro_account_render_native_content();
            }

            ?>
        </div>
    </section>
    <?php

    if (! in_array($slug, array('contact', 'terms-of-service', 'privacy-policy'), true)) {
        betpro_account_render_support_cta();
    }
endwhile;

get_footer();
