<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()) :
    the_post();

    $post_id = get_the_ID();
    $categories = get_the_category($post_id);
    $category_name = __('BetPro Guides', 'betpro-account');
    $read_time = (string) get_post_meta($post_id, 'betpro_read_time', true);

    if ($read_time === '') {
        $word_count = str_word_count(wp_strip_all_tags((string) get_the_content(null, false)));
        $read_time = sprintf(__('%d min read', 'betpro-account'), max(1, (int) ceil($word_count / 220)));
    }

    $hero_image = betpro_account_seo_image_url($post_id, 'blog');
    $terms = get_the_terms($post_id, 'post_tag');

    if (! is_array($terms) || empty($terms)) {
        $terms = $categories;
    }
    ?>
    <article class="betpro-single-post">
        <header class="betpro-single-hero relative overflow-hidden">
            <div class="betpro-single-hero__media" aria-hidden="true">
                <img src="<?php echo esc_url($hero_image); ?>" alt="">
            </div>
            <div class="betpro-single-hero__inner">
                <a class="betpro-single-back" href="<?php echo esc_url(home_url('/blog/')); ?>"><i class="fa-solid fa-arrow-left" aria-hidden="true"></i> <?php esc_html_e('Back to Blog', 'betpro-account'); ?></a>
                <div class="betpro-single-meta">
                    <span><?php echo esc_html(strtoupper($category_name)); ?></span>
                    <time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>"><?php echo esc_html(get_the_date('F j, Y')); ?></time>
                    <span><?php echo esc_html($read_time); ?></span>
                </div>
                <h1><?php the_title(); ?></h1>
            </div>
        </header>

        <section class="betpro-single-body betpro-content-section bg-background">
            <div class="betpro-single-wrap">
                <div class="betpro-single-card">
                    <div class="betpro-single-author">
                        <div class="betpro-single-author__avatar">
                            <?php echo get_avatar($post_id, 44, '', esc_attr__('BetPro Account Team', 'betpro-account')); ?>
                        </div>
                        <div>
                            <strong><?php esc_html_e('BetPro Account Team', 'betpro-account'); ?></strong>
                            <p><?php esc_html_e('BetPro Account Editorial Team', 'betpro-account'); ?></p>
                        </div>
                        <time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>"><?php echo esc_html(get_the_date('F j, Y')); ?></time>
                    </div>

                    <?php betpro_account_render_native_content(null, false); ?>

                    <?php if (! empty($terms)) : ?>
                        <footer class="betpro-single-tags">
                            <?php foreach ($terms as $term) : ?>
                                <?php if ($term instanceof WP_Term) : ?>
                                    <?php $term_link = get_term_link($term); ?>
                                    <?php if (! is_wp_error($term_link)) : ?>
                                        <a href="<?php echo esc_url($term_link); ?>"><?php echo esc_html($term->name); ?></a>
                                    <?php else : ?>
                                        <span><?php echo esc_html($term->name); ?></span>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </footer>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </article>

    <?php
    $more_posts = new WP_Query(
        array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'post__not_in' => array($post_id),
            'orderby' => 'date',
            'order' => 'DESC',
        )
    );

    if ($more_posts->have_posts()) :
        ?>
        <section class="betpro-more-articles">
            <div class="betpro-more-articles__inner">
                <h2><?php esc_html_e('More Articles', 'betpro-account'); ?></h2>
                <div class="betpro-more-articles__grid">
                    <?php
                    while ($more_posts->have_posts()) :
                        $more_posts->the_post();
                        betpro_account_render_static_post_card(get_post());
                    endwhile;
                    wp_reset_postdata();
                    ?>
                </div>
            </div>
        </section>
    <?php endif; ?>

<?php
// Display comments section
if ( comments_open() || get_comments_number() ) {
	comments_template();
}
?>

<?php endwhile; ?>

<?php
get_footer();
