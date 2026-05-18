<?php

if (! defined('ABSPATH')) {
    exit;
}

$cta_image = (string) ($args['cta_image'] ?? '');
?>

<section class="betpro-blog-preview-section">
    <div class="betpro-home-container">
        <div class="betpro-section-row">
            <div class="betpro-section-heading betpro-reveal" data-betpro-reveal>
                <p class="betpro-eyebrow text-lg"><?php esc_html_e('From the Blog', 'betpro-account'); ?></p>
                <h2><?php esc_html_e('BetPro Account Guides & Insights', 'betpro-account'); ?></h2>
            </div>
            <a class="betpro-mini-link" href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('View All Articles', 'betpro-account'); ?></a>
        </div>
        <div class="betpro-blog-preview-grid">
            <?php
            [$blog_query] = betpro_account_query_blog_posts(3);

            if ($blog_query instanceof WP_Query && $blog_query->have_posts()) :
                while ($blog_query->have_posts()) :
                    $blog_query->the_post();
                    $post_id = get_the_ID();
                    $image_url = betpro_account_post_cover_image(get_post());
                    ?>
                    <article class="betpro-blog-preview-card betpro-reveal" data-betpro-reveal>
                        <a href="<?php echo esc_url(get_permalink()); ?>">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy" />
                        </a>
                        <div>
                            <h3><a href="<?php echo esc_url(get_permalink()); ?>"><?php the_title(); ?></a></h3>
                            <p class="text-lg"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
                            <a class="betpro-read-link" href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e('Read', 'betpro-account'); ?></a>
                        </div>
                    </article>
                <?php
                endwhile;
                wp_reset_postdata();
            else :
                ?>
                <p class="text-lg text-muted-foreground col-span-full"><?php esc_html_e('Blog posts coming soon.', 'betpro-account'); ?></p>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="betpro-final-cta">
    <img src="<?php echo esc_url($cta_image); ?>" alt="" loading="lazy" />
    <div class="betpro-final-cta__content betpro-reveal" data-betpro-reveal>
        <h2><?php esc_html_e('Get Your Verified Account', 'betpro-account'); ?></h2>
        <p class="text-xl"><?php esc_html_e('Join professional bettors who trust BetPro Account for reliable, verified betting accounts delivered fast.', 'betpro-account'); ?></p>
        <div class="betpro-final-cta__actions">
            <?php
            betpro_account_render_button(betpro_account_whatsapp_url(), betpro_account_primary_cta_label(), 'primary', true);
            ?>
        </div>
    </div>
</section>
