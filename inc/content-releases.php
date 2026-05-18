<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_redirect_legacy_pricing_page(): void
{
    if (is_admin() || is_preview() || ! is_page('pricing')) {
        return;
    }

    wp_safe_redirect(home_url('/how-it-works/'), 301);
    exit;
}
add_action('template_redirect', 'betpro_account_redirect_legacy_pricing_page');

function betpro_account_latest_marketing_posts(int $limit = 3): array
{
    $blocked_ids = array();

    $test_by_slug = get_page_by_path('first-testing-post', OBJECT, 'post');
    if ($test_by_slug instanceof WP_Post) {
        $blocked_ids[] = $test_by_slug->ID;
    }

    $test_by_title = get_page_by_title('first testing post', OBJECT, 'post');
    if ($test_by_title instanceof WP_Post) {
        $blocked_ids[] = $test_by_title->ID;
    }

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'numberposts' => max(1, $limit),
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if (! empty($blocked_ids)) {
        $args['post__not_in'] = $blocked_ids;
    }

    return get_posts($args);
}

function betpro_account_recent_toast_messages(): array
{
    $names = array('Ahsan', 'Bilal', 'Hamza', 'Usman', 'Zain', 'Saad');
    $cities = array('Lahore', 'Karachi', 'Islamabad', 'Multan', 'Faisalabad', 'Rawalpindi');
    $products = array('BetPro account order', 'verified betting account order', 'KYC verification request', 'account top-up request', 'replacement account request');
    $times = array('just now', '3 minutes ago', '8 minutes ago', '14 minutes ago', '21 minutes ago');
    $messages = array();

    foreach ($names as $index => $name) {
        $messages[] = sprintf(
            __('%1$s from %2$s placed a %3$s %4$s.', 'betpro-account'),
            $name,
            $cities[$index % count($cities)],
            $products[$index % count($products)],
            $times[$index % count($times)]
        );
    }

    foreach ($cities as $index => $city) {
        $messages[] = sprintf(
            __('A buyer from %1$s confirmed a %2$s %3$s.', 'betpro-account'),
            $city,
            $products[$index % count($products)],
            $times[$index % count($times)]
        );
    }

    return $messages;
}

function betpro_account_render_site_footer(): void
{
    $settings = betpro_account_theme_settings();
    $logo_url = get_template_directory_uri() . '/logo.png';
    $footer_groups = array(
        __('Quick Links', 'betpro-account') => betpro_account_menu_items_with_fallback('footer_quick'),
        __('Support', 'betpro-account') => betpro_account_menu_items_with_fallback('footer_support'),
    );
    ?>
    <footer class="betpro-site-footer">
        <div class="betpro-site-footer__inner">
            <div class="betpro-site-footer__top">
                <div class="betpro-site-footer__logo">
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($settings['brandName']); ?>" width="1920" height="544" loading="lazy" decoding="async" />
                </div>
                <div class="betpro-site-footer__intro">
                    <h2 class="betpro-site-footer__title"><?php esc_html_e('BetPro Account support, guides, and direct contact.', 'betpro-account'); ?></h2>
                    <p class="betpro-site-footer__text"><?php esc_html_e('Use the links below to browse services, read guides, and contact our team quickly on the channel you prefer.', 'betpro-account'); ?></p>
                </div>
                <div class="betpro-site-footer__actions">
                    <a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('View All Articles', 'betpro-account'); ?></a>
                    <a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact Us', 'betpro-account'); ?></a>
                </div>
            </div>

            <div class="betpro-site-footer__meta">
                <?php foreach ($footer_groups as $heading => $items) : ?>
                    <nav class="betpro-site-footer__nav" aria-label="<?php echo esc_attr($heading); ?>">
                        <h2 class="betpro-site-footer__heading"><?php echo esc_html($heading); ?></h2>
                        <ul class="betpro-site-footer__list">
                            <?php foreach ($items as $item) : ?>
                                <li><a href="<?php echo esc_url((string) ($item['url'] ?? '#')); ?>"><?php echo esc_html((string) ($item['title'] ?? '')); ?></a></li>
                            <?php endforeach; ?>
                        </ul>
                    </nav>
                <?php endforeach; ?>
                <div class="betpro-site-footer__contact">
                    <h2 class="betpro-site-footer__heading"><?php esc_html_e('Contact', 'betpro-account'); ?></h2>
                    <ul class="betpro-site-footer__list">
                        <li><a href="<?php echo esc_url(betpro_account_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($settings['whatsappLabel']); ?></a></li>
                        <li><a href="<?php echo esc_url(betpro_account_telegram_url()); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($settings['telegramHandle']); ?></a></li>
                        <li><a href="<?php echo esc_url('mailto:' . $settings['supportEmail']); ?>"><?php echo esc_html($settings['supportEmail']); ?></a></li>
                    </ul>
                </div>
            </div>

            <div class="betpro-site-footer__bottom">
                <?php printf(esc_html__('Copyright %1$s %2$s. All rights reserved.', 'betpro-account'), esc_html((string) date_i18n('Y')), esc_html($settings['brandName'])); ?>
            </div>
        </div>
    </footer>
    <div class="betpro-proof-toast" aria-live="polite" data-betpro-toast data-messages="<?php echo esc_attr(wp_json_encode(betpro_account_recent_toast_messages())); ?>">
        <div class="betpro-proof-toast__content">
            <strong><?php esc_html_e('Recent Order', 'betpro-account'); ?></strong>
            <p><?php esc_html_e('Ahsan from Lahore placed a BetPro account order just now.', 'betpro-account'); ?></p>
        </div>
    </div>
    <?php betpro_account_render_floating_whatsapp_button(); ?>
    <?php
}

function betpro_account_render_floating_whatsapp_button(): void
{
    ?>
    <a class="betpro-floating-whatsapp" href="<?php echo esc_url(betpro_account_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e('Chat with BetPro Account on WhatsApp', 'betpro-account'); ?>">
        <span class="betpro-floating-whatsapp__icon-wrap" aria-hidden="true">
            <i class="fa-brands fa-whatsapp"></i>
        </span>
        <span class="betpro-floating-whatsapp__content">
            <strong><?php esc_html_e('Chat on WhatsApp', 'betpro-account'); ?></strong>
            <small><?php esc_html_e('Fast reply available', 'betpro-account'); ?></small>
        </span>
    </a>
    <?php
}
