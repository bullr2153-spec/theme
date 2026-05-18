<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_contact_handler(): void
{
    check_ajax_referer('betpro_contact', 'nonce');

    $name = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    $email = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $whatsapp = sanitize_text_field(wp_unslash($_POST['whatsapp'] ?? ''));
    $platform = sanitize_text_field(wp_unslash($_POST['platform'] ?? ''));
    $message = sanitize_textarea_field(wp_unslash($_POST['message'] ?? ''));

    if ($name === '' || $email === '' || $whatsapp === '' || $platform === '' || $message === '') {
        wp_send_json_error(array('message' => __('Please complete all required fields.', 'betpro-account')), 400);
    }

    $inquiry_id = betpro_account_store_inquiry($name, $email, $whatsapp, $platform, $message);

    if ($inquiry_id === 0) {
        wp_send_json_error(array('message' => __('Your inquiry could not be saved right now.', 'betpro-account')), 500);
    }

    $recipient = betpro_account_get_setting('contact_email');
    $subject = sprintf(__('New BetPro inquiry from %s', 'betpro-account'), $name);
    $body = implode(
        "\n\n",
        array(
            "Name: {$name}",
            "Email: {$email}",
            "WhatsApp: {$whatsapp}",
            "Platform: {$platform}",
            "Message:\n{$message}",
        )
    );
    $headers = array('Content-Type: text/plain; charset=UTF-8', sprintf('Reply-To: %s <%s>', $name, $email));
    $sent = wp_mail($recipient, $subject, $body, $headers);

    wp_send_json_success(
        array(
            'message' => $sent
                ? __('Inquiry saved successfully. Your message is also visible in the WordPress admin.', 'betpro-account')
                : __('Inquiry saved successfully. Your message is visible in the WordPress admin.', 'betpro-account'),
            'id' => $inquiry_id,
        )
    );
}
add_action('wp_ajax_betpro_contact', 'betpro_account_contact_handler');
add_action('wp_ajax_nopriv_betpro_contact', 'betpro_account_contact_handler');

function betpro_account_missing_assets_notice(): void
{
    if (! current_user_can('switch_themes') || file_exists(betpro_account_asset_dir() . '/manifest.json')) {
        return;
    }

    echo '<div class="notice notice-warning"><p>';
    echo esc_html__('BetPro Account theme is missing frontend assets. Rebuild the WordPress bundle before using this theme.', 'betpro-account');
    echo '</p></div>';
}
add_action('admin_notices', 'betpro_account_missing_assets_notice');

function betpro_account_media_notice(): void
{
    if (! current_user_can('switch_themes') || ! function_exists('betpro_account_media_urls') || ! empty(betpro_account_theme_images())) {
        return;
    }

    echo '<div class="notice notice-warning"><p>';
    echo esc_html__('BetPro Account Media plugin is active, but no images are assigned yet. Bundled fallback images will be used.', 'betpro-account');
    echo '</p></div>';
}
add_action('admin_notices', 'betpro_account_media_notice');
