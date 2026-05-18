<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_page_slug(): string
{
    if (is_front_page()) {
        return 'home';
    }

    $post = get_queried_object();

    return $post instanceof WP_Post ? (string) $post->post_name : '';
}

function betpro_account_primary_cta_label(): string
{
    return __('Order on WhatsApp', 'betpro-account');
}

function betpro_account_render_button(string $url, string $label, string $variant = 'primary', bool $external = false): void
{
    $classes = $variant === 'secondary'
        ? 'inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl border border-primary/35 text-foreground font-semibold text-sm hover:bg-primary/10 transition-colors'
        : 'inline-flex items-center justify-center gap-2 h-12 px-6 rounded-xl text-black font-bold text-sm shadow-[0_0_24px_rgba(245,197,24,0.45)] hover:opacity-95 transition-opacity';
    $icon = '';
    $style = $variant === 'secondary'
        ? ''
        : ' style="background-color:#f5c518;border-color:#f5c518;color:#111111;"';

    if ($external) {
        $icon = '<i class="fa-brands fa-whatsapp" aria-hidden="true"></i>';
    } elseif ($variant === 'secondary') {
        $icon = '<i class="fa-solid fa-arrow-right" aria-hidden="true"></i>';
    }

    printf(
        '<a href="%1$s" class="%2$s"%3$s>%4$s</a>',
        esc_url($url),
        esc_attr($classes),
        ($external ? ' target="_blank" rel="noopener noreferrer"' : '') . $style,
        $icon . esc_html($label)
    );
}

function betpro_account_render_native_content(?WP_Post $post = null, bool $reveal = true): void
{
    $post = $post ?: get_post();

    if (! $post instanceof WP_Post) {
        return;
    }

    $content = apply_filters('the_content', $post->post_content);
    $content = betpro_account_normalize_managed_html((string) $content);

    if (trim(wp_strip_all_tags($content)) === '' && trim($content) === '') {
        return;
    }

    $classes = 'betpro-native-content prose prose-lg max-w-none text-foreground';
    $attributes = '';

    if ($reveal) {
        $classes .= ' betpro-reveal';
        $attributes = ' data-betpro-reveal';
    }

    printf('<div class="%1$s"%2$s>', esc_attr($classes), $attributes);
    echo $content;
    echo '</div>';
}

function betpro_account_is_default_generated_page_content(string $slug, string $content): bool
{
    $signatures = array(
        'faq' => 'Read clear answers about BetPro Account',
        'contact' => 'Reach our team for verified betting accounts',
    );

    return isset($signatures[$slug]) && str_contains($content, $signatures[$slug]);
}
