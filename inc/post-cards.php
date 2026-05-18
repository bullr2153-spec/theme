<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_query_blog_posts(int $limit = 9): array
{
    $blocked_ids = array();
    $test_by_slug = get_page_by_path('first-testing-post', OBJECT, 'post');

    if ($test_by_slug instanceof WP_Post) {
        $blocked_ids[] = (int) $test_by_slug->ID;
    }

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => $limit,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if (! empty($blocked_ids)) {
        $args['post__not_in'] = $blocked_ids;
    }

    return array(new WP_Query($args), $blocked_ids);
}

function betpro_account_render_post_card(WP_Post $post): void
{
    $image_url = betpro_account_post_cover_image($post);
    ?>
    <article class="betpro-post-card betpro-reveal group overflow-hidden rounded-2xl border border-border bg-card shadow-sm transition-transform hover:-translate-y-1" data-betpro-reveal>
        <a href="<?php echo esc_url(get_permalink($post)); ?>" class="betpro-post-card__media block">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>" class="w-full h-auto" />
        </a>
        <div class="betpro-post-card__body p-6">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-primary"><?php echo esc_html(get_the_date('F j, Y', $post)); ?></p>
            <h2 class="text-xl font-extrabold leading-snug mb-3">
                <a class="hover:text-primary transition-colors" href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a>
            </h2>
            <p class="text-sm leading-7 text-muted-foreground"><?php echo esc_html(wp_trim_words(get_the_excerpt($post), 24)); ?></p>
        </div>
    </article>
    <?php
}

function betpro_account_render_static_post_card(WP_Post $post): void
{
    $image_url = betpro_account_post_cover_image($post);
    ?>
    <article class="betpro-post-card betpro-reveal group overflow-hidden rounded-2xl border border-border bg-card shadow-sm transition-transform hover:-translate-y-1" data-betpro-reveal>
        <a href="<?php echo esc_url(get_permalink($post)); ?>" class="betpro-post-card__media block">
            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>" class="w-full h-auto" loading="lazy" decoding="async" />
        </a>
        <div class="betpro-post-card__body p-6">
            <p class="mb-3 text-xs font-bold uppercase tracking-widest text-primary"><?php echo esc_html(get_the_date('F j, Y', $post)); ?></p>
            <h2 class="text-xl font-extrabold leading-snug mb-3">
                <a class="hover:text-primary transition-colors" href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a>
            </h2>
            <p class="text-sm leading-7 text-muted-foreground"><?php echo esc_html(wp_trim_words(get_the_excerpt($post), 24)); ?></p>
        </div>
    </article>
    <?php
}
