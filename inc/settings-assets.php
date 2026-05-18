<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_setting_defaults(): array
{
    return array(
        'whatsapp_number' => '923047577777',
        'whatsapp_label' => '+923047577777',
        'telegram_handle' => '@BetProAccount',
        'support_email' => 'support@betproaccount.net',
        'contact_email' => 'vip@betproaccount.net',
    );
}

function betpro_account_migrate_contact_settings(): void
{
    $defaults = betpro_account_setting_defaults();
    $release_flag = 'betpro_contact_release_20260328';

    if (get_option($release_flag) !== 'done') {
        update_option(betpro_account_setting_option_name('whatsapp_number'), $defaults['whatsapp_number']);
        update_option(betpro_account_setting_option_name('whatsapp_label'), $defaults['whatsapp_label']);
        update_option($release_flag, 'done');
    }

    $legacy_values = array(
        'whatsapp_number' => array('', '1234567890', '+1234567890'),
        'whatsapp_label' => array('', '1234567890', '+1234567890'),
    );

    foreach ($legacy_values as $key => $values) {
        $option_name = betpro_account_setting_option_name($key);
        $current = get_option($option_name, null);

        if ($current === null || $current === false || in_array((string) $current, $values, true)) {
            update_option($option_name, $defaults[$key]);
        }
    }
}
add_action('init', 'betpro_account_migrate_contact_settings', 5);

function betpro_account_setting_option_name(string $key): string
{
    return "betpro_{$key}";
}

function betpro_account_get_setting(string $key): string
{
    $defaults = betpro_account_setting_defaults();
    $default = $defaults[$key] ?? '';

    return (string) get_option(betpro_account_setting_option_name($key), $default);
}

function betpro_account_theme_settings(): array
{
    return array(
        'brandName' => 'BetPro Account',
        'whatsappNumber' => betpro_account_get_setting('whatsapp_number'),
        'whatsappLabel' => betpro_account_get_setting('whatsapp_label'),
        'telegramHandle' => betpro_account_get_setting('telegram_handle'),
        'supportEmail' => betpro_account_get_setting('support_email'),
        'contactEmail' => betpro_account_get_setting('contact_email'),
    );
}

function betpro_account_theme_images(): array
{
    if (! function_exists('betpro_account_media_urls')) {
        return array();
    }

    $image_urls = betpro_account_media_urls();

    return is_array($image_urls) ? $image_urls : array();
}

function betpro_account_whatsapp_url(): string
{
    return 'https://wa.me/' . preg_replace('/\D+/', '', betpro_account_get_setting('whatsapp_number'));
}

function betpro_account_telegram_url(): string
{
    return 'https://t.me/' . ltrim(betpro_account_get_setting('telegram_handle'), '@');
}

function betpro_account_default_asset_url(string $path): string
{
    return betpro_account_asset_uri() . '/' . ltrim($path, '/');
}

function betpro_account_is_absolute_url(string $value): bool
{
    return (bool) preg_match('#^(?:[a-z][a-z0-9+\-.]*:)?//#i', $value)
        || (bool) preg_match('#^(?:mailto:|tel:|data:|blob:)#i', $value);
}

function betpro_account_managed_asset_url(string $path): string
{
    if ($path === '') {
        return '';
    }

    if (betpro_account_is_absolute_url($path) || str_starts_with($path, '#')) {
        return $path;
    }

    $normalized = ltrim($path, '/');

    if ($normalized === 'favicon.webp' || $normalized === 'opengraph.jpg') {
        return betpro_account_default_asset_url($normalized);
    }

    if (str_starts_with($normalized, 'images/')) {
        $filename = substr($normalized, strlen('images/'));
        $images = betpro_account_theme_images();
        $mapped = $images[$filename] ?? '';

        if (is_string($mapped) && $mapped !== '') {
            return $mapped;
        }

        return betpro_account_default_asset_url('opengraph.jpg');
    }

    if (str_starts_with($normalized, 'wp-content/') || str_starts_with($normalized, 'wp-includes/')) {
        return home_url('/' . $normalized);
    }

    if (str_starts_with($path, '/')) {
        return home_url($path);
    }

    return home_url('/' . $normalized);
}

function betpro_account_normalize_managed_html(string $html): string
{
    if ($html === '') {
        return '';
    }

    $normalized_html = preg_replace_callback(
        '/\b(src|href)=(["\'])([^"\']+)\2/i',
        static function (array $matches): string {
            $attribute = strtolower((string) $matches[1]);
            $quote = (string) $matches[2];
            $value = (string) $matches[3];

            if ($attribute === 'src') {
                $normalized = betpro_account_managed_asset_url($value);
            } elseif (preg_match('#^(?:images/|/?images/|/?favicon\.webp|/?opengraph\.jpg)#i', $value) === 1) {
                $normalized = betpro_account_managed_asset_url($value);
            } elseif (! betpro_account_is_absolute_url($value) && ! str_starts_with($value, '#')) {
                $normalized = betpro_account_managed_asset_url($value);
            } else {
                $normalized = $value;
            }

            return sprintf('%s=%s%s%s', $attribute, $quote, esc_url($normalized), $quote);
        },
        $html
    );

    return is_string($normalized_html) ? $normalized_html : $html;
}
