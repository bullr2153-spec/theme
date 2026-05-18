<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();
betpro_account_render_page_hero(wp_strip_all_tags(get_the_archive_title()), wp_strip_all_tags(get_the_archive_description()), 'blog');
?>
<section class="betpro-content-section py-16 bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <?php if (have_posts()) : ?>
            <div class="grid gap-7 md:grid-cols-2 lg:grid-cols-3">
                <?php
                while (have_posts()) :
                    the_post();
                    betpro_account_render_post_card(get_post());
                endwhile;
                ?>
            </div>
            <div class="mt-12 text-center">
                <?php the_posts_pagination(); ?>
            </div>
        <?php else : ?>
            <p class="text-muted-foreground"><?php esc_html_e('No posts found for this archive.', 'betpro-account'); ?></p>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
