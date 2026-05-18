<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_render_setting_field(array $args): void
{
    $key = (string) ($args['key'] ?? '');
    $label = (string) ($args['label'] ?? '');
    $type = (string) ($args['type'] ?? 'text');
    $value = esc_attr(betpro_account_get_setting($key));
    $option_name = esc_attr(betpro_account_setting_option_name($key));

    printf(
        '<input type="%1$s" id="%2$s" name="%2$s" value="%3$s" class="regular-text" />',
        esc_attr($type),
        $option_name,
        $value
    );

    if ($label !== '') {
        printf('<p class="description">%s</p>', esc_html($label));
    }
}

function betpro_account_register_settings(): void
{
    $fields = array(
        'whatsapp_number' => array(
            'title' => __('WhatsApp Number', 'betpro-account'),
            'label' => __('Digits only. Used to build the WhatsApp order link.', 'betpro-account'),
            'type' => 'text',
        ),
        'whatsapp_label' => array(
            'title' => __('WhatsApp Label', 'betpro-account'),
            'label' => __('Display label used in the footer and contact sections.', 'betpro-account'),
            'type' => 'text',
        ),
        'telegram_handle' => array(
            'title' => __('Telegram Handle', 'betpro-account'),
            'label' => __('Include or omit the @ prefix. Both will work.', 'betpro-account'),
            'type' => 'text',
        ),
        'support_email' => array(
            'title' => __('Support Email', 'betpro-account'),
            'label' => __('Displayed across the site and used as the reply address.', 'betpro-account'),
            'type' => 'email',
        ),
        'contact_email' => array(
            'title' => __('Contact Form Recipient', 'betpro-account'),
            'label' => __('Messages from the on-site contact form will be sent here.', 'betpro-account'),
            'type' => 'email',
        ),
    );

    foreach ($fields as $key => $field) {
        register_setting(
            'general',
            betpro_account_setting_option_name($key),
            array(
                'type' => 'string',
                'sanitize_callback' => $field['type'] === 'email' ? 'sanitize_email' : 'sanitize_text_field',
                'default' => betpro_account_setting_defaults()[$key] ?? '',
            )
        );

        add_settings_field(
            betpro_account_setting_option_name($key),
            $field['title'],
            'betpro_account_render_setting_field',
            'general',
            'default',
            array(
                'key' => $key,
                'label' => $field['label'],
                'type' => $field['type'],
            )
        );
    }
}
add_action('admin_init', 'betpro_account_register_settings');

function betpro_account_register_inquiry_post_type(): void
{
    register_post_type(
        'betpro_inquiry',
        array(
            'labels' => array(
                'name' => __('Inquiries', 'betpro-account'),
                'singular_name' => __('Inquiry', 'betpro-account'),
                'menu_name' => __('Inquiries', 'betpro-account'),
                'name_admin_bar' => __('Inquiry', 'betpro-account'),
                'add_new_item' => __('Add Inquiry', 'betpro-account'),
                'edit_item' => __('View Inquiry', 'betpro-account'),
                'new_item' => __('New Inquiry', 'betpro-account'),
                'view_item' => __('View Inquiry', 'betpro-account'),
                'search_items' => __('Search Inquiries', 'betpro-account'),
                'not_found' => __('No inquiries found.', 'betpro-account'),
            ),
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'show_in_rest' => false,
            'exclude_from_search' => true,
            'publicly_queryable' => false,
            'menu_position' => 26,
            'menu_icon' => 'dashicons-email-alt2',
            'supports' => array('title', 'editor'),
            'rewrite' => false,
        )
    );
}
add_action('init', 'betpro_account_register_inquiry_post_type');

function betpro_account_register_inquiry_meta_box(): void
{
    add_meta_box(
        'betpro-inquiry-details',
        __('Inquiry Details', 'betpro-account'),
        'betpro_account_render_inquiry_meta_box',
        'betpro_inquiry',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'betpro_account_register_inquiry_meta_box');

function betpro_account_render_inquiry_meta_box(WP_Post $post): void
{
    $details = array(
        __('Full Name', 'betpro-account') => get_post_meta($post->ID, '_betpro_inquiry_name', true),
        __('Email', 'betpro-account') => get_post_meta($post->ID, '_betpro_inquiry_email', true),
        __('WhatsApp', 'betpro-account') => get_post_meta($post->ID, '_betpro_inquiry_whatsapp', true),
        __('Platform', 'betpro-account') => get_post_meta($post->ID, '_betpro_inquiry_platform', true),
        __('Submitted At', 'betpro-account') => get_post_meta($post->ID, '_betpro_inquiry_submitted_at', true),
    );
    ?>
    <table class="widefat striped" style="border: 0;">
        <tbody>
        <?php foreach ($details as $label => $value) : ?>
            <tr>
                <th style="width: 180px; padding-left: 0;"><?php echo esc_html($label); ?></th>
                <td><?php echo esc_html((string) $value); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <p style="margin-top: 16px;"><strong><?php esc_html_e('Client Message', 'betpro-account'); ?></strong></p>
    <div style="padding: 12px 14px; border: 1px solid #dcdcde; border-radius: 8px; background: #fff;">
        <?php echo wpautop(esc_html($post->post_content)); ?>
    </div>
    <?php
}

function betpro_account_inquiry_columns(array $columns): array
{
    return array(
        'cb' => $columns['cb'] ?? '',
        'title' => __('Inquiry', 'betpro-account'),
        'platform' => __('Platform', 'betpro-account'),
        'email' => __('Email', 'betpro-account'),
        'whatsapp' => __('WhatsApp', 'betpro-account'),
        'date' => $columns['date'] ?? __('Date', 'betpro-account'),
    );
}
add_filter('manage_betpro_inquiry_posts_columns', 'betpro_account_inquiry_columns');

function betpro_account_render_inquiry_column(string $column, int $post_id): void
{
    if ($column === 'platform') {
        echo esc_html((string) get_post_meta($post_id, '_betpro_inquiry_platform', true));
        return;
    }

    if ($column === 'email') {
        $email = (string) get_post_meta($post_id, '_betpro_inquiry_email', true);

        if ($email !== '') {
            printf('<a href="mailto:%1$s">%1$s</a>', esc_attr($email));
        }

        return;
    }

    if ($column === 'whatsapp') {
        echo esc_html((string) get_post_meta($post_id, '_betpro_inquiry_whatsapp', true));
    }
}
add_action('manage_betpro_inquiry_posts_custom_column', 'betpro_account_render_inquiry_column', 10, 2);

function betpro_account_store_inquiry(
    string $name,
    string $email,
    string $whatsapp,
    string $platform,
    string $message
): int {
    $post_id = wp_insert_post(
        wp_slash(
            array(
                'post_type' => 'betpro_inquiry',
                'post_status' => 'publish',
                'post_title' => sprintf('%s - %s', $name, $platform),
                'post_content' => $message,
            )
        ),
        true
    );

    if (is_wp_error($post_id)) {
        return 0;
    }

    update_post_meta((int) $post_id, '_betpro_inquiry_name', $name);
    update_post_meta((int) $post_id, '_betpro_inquiry_email', $email);
    update_post_meta((int) $post_id, '_betpro_inquiry_whatsapp', $whatsapp);
    update_post_meta((int) $post_id, '_betpro_inquiry_platform', $platform);
    update_post_meta((int) $post_id, '_betpro_inquiry_submitted_at', current_time('mysql'));

    return (int) $post_id;
}
