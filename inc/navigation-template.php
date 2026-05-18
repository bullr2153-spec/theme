<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_default_menu_items(string $location): array
{
    $items = array(
        'primary' => array(
            array('title' => __('Services', 'betpro-account'), 'url' => home_url('/services/'), 'target' => ''),
            array('title' => __('How It Works', 'betpro-account'), 'url' => home_url('/how-it-works/'), 'target' => ''),
            array('title' => __('Blog', 'betpro-account'), 'url' => home_url('/blog/'), 'target' => ''),
            array('title' => __('FAQ', 'betpro-account'), 'url' => home_url('/faq/'), 'target' => ''),
            array('title' => __('Contact', 'betpro-account'), 'url' => home_url('/contact/'), 'target' => ''),
        ),
        'footer_quick' => array(
            array('title' => __('Home', 'betpro-account'), 'url' => home_url('/'), 'target' => ''),
            array('title' => __('Services', 'betpro-account'), 'url' => home_url('/services/'), 'target' => ''),
            array('title' => __('How It Works', 'betpro-account'), 'url' => home_url('/how-it-works/'), 'target' => ''),
            array('title' => __('Contact', 'betpro-account'), 'url' => home_url('/contact/'), 'target' => ''),
        ),
        'footer_support' => array(
            array('title' => __('FAQ', 'betpro-account'), 'url' => home_url('/faq/'), 'target' => ''),
            array('title' => __('Contact', 'betpro-account'), 'url' => home_url('/contact/'), 'target' => ''),
            array('title' => __('Terms of Service', 'betpro-account'), 'url' => home_url('/terms-of-service/'), 'target' => ''),
            array('title' => __('Privacy Policy', 'betpro-account'), 'url' => home_url('/privacy-policy/'), 'target' => ''),
        ),
    );

    return $items[$location] ?? array();
}

function betpro_account_menu_items_with_fallback(string $location): array
{
    $items = betpro_account_menu_items($location);

    return empty($items) ? betpro_account_default_menu_items($location) : $items;
}

function betpro_account_render_site_header(): void
{
    $settings = betpro_account_theme_settings();
    $logo_url = get_template_directory_uri() . '/logo.png';
    $menu_items = betpro_account_menu_items_with_fallback('primary');
    $latest_posts = betpro_account_latest_marketing_posts(3);
    ?>
    <header class="betpro-site-header sticky top-0 z-50 border-b border-border bg-background/92 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="betpro-site-header__row flex min-h-20 items-center justify-between gap-6">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="betpro-site-brand flex items-center gap-3 font-extrabold tracking-tight text-foreground">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($settings['brandName']); ?>" width="1920" height="544" decoding="async" fetchpriority="high" />
                </a>
                <button class="betpro-menu-toggle" type="button" aria-expanded="false" aria-controls="betpro-mobile-menu" aria-label="<?php esc_attr_e('Open menu', 'betpro-account'); ?>" data-betpro-menu-toggle>
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
                <nav class="betpro-site-nav betpro-site-nav--desktop flex items-center gap-7 text-sm font-semibold text-muted-foreground" aria-label="<?php esc_attr_e('Primary menu', 'betpro-account'); ?>">
                    <ul class="betpro-site-nav__list">
                        <?php foreach ($menu_items as $item) : ?>
                            <?php
                            $target = (string) ($item['target'] ?? '');
                            $title = (string) ($item['title'] ?? '');
                            $is_blog = strtolower($title) === 'blog';
                            ?>
                            <li class="betpro-site-nav__item<?php echo $is_blog ? ' betpro-site-nav__item--has-mega' : ''; ?>">
                                <a class="hover:text-primary transition-colors" href="<?php echo esc_url((string) ($item['url'] ?? '#')); ?>"<?php echo $target !== '' ? ' target="' . esc_attr($target) . '"' : ''; ?>>
                                    <?php echo esc_html($title); ?>
                                </a>
                                <?php if ($is_blog && ! empty($latest_posts)) : ?>
                                    <div class="betpro-nav-mega">
                                        <div class="betpro-nav-mega__eyebrow"><?php esc_html_e('Latest Posts', 'betpro-account'); ?></div>
                                        <div class="betpro-nav-mega__grid">
                                            <?php foreach ($latest_posts as $post) : ?>
                                                <article class="betpro-nav-post">
                                                    <a class="betpro-nav-post__thumb" href="<?php echo esc_url(get_permalink($post)); ?>">
                                                        <img src="<?php echo esc_url(betpro_account_post_cover_image($post)); ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>" loading="lazy" />
                                                    </a>
                                                    <div class="betpro-nav-post__copy">
                                                        <span><?php echo esc_html(get_the_date('M j, Y', $post)); ?></span>
                                                        <h3><a href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a></h3>
                                                    </div>
                                                </article>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
                <div class="betpro-site-header__cta hidden sm:flex items-center gap-3">
                    <?php betpro_account_render_button(betpro_account_whatsapp_url(), betpro_account_primary_cta_label(), 'primary', true); ?>
                </div>
            </div>
            <div id="betpro-mobile-menu" class="betpro-mobile-menu" hidden data-betpro-mobile-menu>
                <nav class="betpro-mobile-menu__nav" aria-label="<?php esc_attr_e('Mobile menu', 'betpro-account'); ?>">
                    <?php foreach ($menu_items as $item) : ?>
                        <?php $target = (string) ($item['target'] ?? ''); ?>
                        <a href="<?php echo esc_url((string) ($item['url'] ?? '#')); ?>"<?php echo $target !== '' ? ' target="' . esc_attr($target) . '"' : ''; ?>>
                            <span><?php echo esc_html((string) ($item['title'] ?? '')); ?></span>
                            <i class="fa-solid fa-arrow-right" aria-hidden="true"></i>
                        </a>
                    <?php endforeach; ?>
                </nav>
                <?php if (! empty($latest_posts)) : ?>
                    <div class="betpro-mobile-menu__latest">
                        <div class="betpro-mobile-menu__eyebrow"><?php esc_html_e('Latest Posts', 'betpro-account'); ?></div>
                        <div class="betpro-mobile-menu__posts">
                            <?php foreach ($latest_posts as $post) : ?>
                                <article class="betpro-mobile-menu__post">
                                    <a class="betpro-mobile-menu__thumb" href="<?php echo esc_url(get_permalink($post)); ?>">
                                        <img src="<?php echo esc_url(betpro_account_post_cover_image($post)); ?>" alt="<?php echo esc_attr(get_the_title($post)); ?>" loading="lazy" />
                                    </a>
                                    <div class="betpro-mobile-menu__post-copy">
                                        <span><?php echo esc_html(get_the_date('M j', $post)); ?></span>
                                        <h3><a href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a></h3>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="betpro-mobile-menu__actions">
                    <?php betpro_account_render_button(betpro_account_whatsapp_url(), __('Order on WhatsApp', 'betpro-account'), 'primary', true); ?>
                </div>
            </div>
        </div>
    </header>
    <?php
}
