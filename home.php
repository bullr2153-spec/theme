<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();
betpro_account_render_page_hero(__('BetPro Account Blog', 'betpro-account'), __('Guides on verified betting accounts, KYC, payments, bookmaker restrictions, and account strategy.', 'betpro-account'), 'blog');
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
            <p class="text-muted-foreground"><?php esc_html_e('No blog posts are published yet.', 'betpro-account'); ?></p>
        <?php endif; ?>
    </div>
</section>
<?php
get_footer();
