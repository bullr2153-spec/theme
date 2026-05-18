<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

if (have_posts()) :
    if (is_search()) {
        betpro_account_render_page_hero(
            sprintf(__('Search Results for %s', 'betpro-account'), get_search_query()),
            __('Browse matching BetPro Account pages, posts, and support content.', 'betpro-account'),
            'blog'
        );
    } else {
        betpro_account_render_page_hero(
            __('Latest BetPro Account Updates', 'betpro-account'),
            __('Explore BetPro Account pages, guides, and service updates.', 'betpro-account'),
            'blog'
        );
    }
    ?>
    <section class="betpro-content-section py-16 bg-background">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-10">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article class="betpro-listing-card betpro-reveal rounded-2xl border border-border bg-card p-7" data-betpro-reveal>
                    <h1 class="text-3xl font-extrabold mb-4"><a class="hover:text-primary transition-colors" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
                    <div class="text-muted-foreground leading-7"><?php the_excerpt(); ?></div>
                </article>
            <?php endwhile; ?>
            <div class="mt-12 text-center">
                <?php the_posts_pagination(); ?>
            </div>
        </div>
    </section>
    <?php
else :
    betpro_account_render_page_hero(__('Nothing Found', 'betpro-account'), __('The requested content could not be found.', 'betpro-account'));
endif;

get_footer();
