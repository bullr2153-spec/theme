<?php

if (! defined('ABSPATH')) {
    exit;
}

$settings = betpro_account_theme_settings();
$support_items = array(
    array(
        'title' => __('Email Support', 'betpro-account'),
        'meta' => __('Response time: ~2-4 hours', 'betpro-account'),
        'value' => $settings['supportEmail'],
        'url' => 'mailto:' . $settings['supportEmail'],
        'icon' => 'mail',
    ),
    array(
        'title' => __('Secure Channel', 'betpro-account'),
        'meta' => __('All communications are completely confidential and end-to-end encrypted.', 'betpro-account'),
        'value' => '',
        'url' => '',
        'icon' => 'shield',
    ),
    array(
        'title' => __('Operating Hours', 'betpro-account'),
        'meta' => __('24/7 coverage for active clients. New inquiries processed 08:00 - 22:00 UTC.', 'betpro-account'),
        'value' => '',
        'url' => '',
        'icon' => 'clock',
    ),
);
?>
<div class="betpro-contact-page">
    <div class="betpro-contact-fast-grid">
        <a class="betpro-contact-fast-card betpro-contact-fast-card--whatsapp betpro-reveal" href="<?php echo esc_url(betpro_account_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer" data-betpro-reveal>
            <span class="betpro-contact-fast-card__icon" aria-hidden="true">
                <i class="fa-brands fa-whatsapp"></i>
            </span>
            <span>
                <strong><?php esc_html_e('WhatsApp Support', 'betpro-account'); ?></strong>
                <em><?php esc_html_e('We typically respond within 1 hour', 'betpro-account'); ?></em>
            </span>
        </a>
        <a class="betpro-contact-fast-card betpro-contact-fast-card--telegram betpro-reveal" href="<?php echo esc_url(betpro_account_telegram_url()); ?>" target="_blank" rel="noopener noreferrer" data-betpro-reveal>
            <span class="betpro-contact-fast-card__icon" aria-hidden="true">
                <i class="fa-brands fa-telegram"></i>
            </span>
            <span>
                <strong><?php esc_html_e('Telegram Support', 'betpro-account'); ?></strong>
                <em><?php esc_html_e('We typically respond within 1 hour', 'betpro-account'); ?></em>
            </span>
        </a>
    </div>

    <div class="betpro-contact-main-grid">
        <aside class="betpro-contact-info-card betpro-reveal" data-betpro-reveal>
            <h2><?php esc_html_e('Other Ways to Connect', 'betpro-account'); ?></h2>
            <div class="betpro-contact-info-list">
                <?php foreach ($support_items as $item) : ?>
                    <div class="betpro-contact-info-item">
                        <span class="betpro-contact-info-item__icon" aria-hidden="true">
                            <i class="fa-solid <?php echo esc_attr(array('mail' => 'fa-envelope', 'shield' => 'fa-shield-halved', 'clock' => 'fa-clock')[$item['icon']] ?? 'fa-circle-info'); ?>"></i>
                        </span>
                        <div>
                            <h3><?php echo esc_html($item['title']); ?></h3>
                            <p><?php echo esc_html($item['meta']); ?></p>
                            <?php if ($item['value'] !== '' && $item['url'] !== '') : ?>
                                <a href="<?php echo esc_url($item['url']); ?>"><?php echo esc_html($item['value']); ?></a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </aside>

        <form class="betpro-contact-form betpro-contact-form--inline betpro-reveal" method="post" data-betpro-reveal>
            <h2><?php esc_html_e('Send an Inquiry', 'betpro-account'); ?></h2>
            <div class="betpro-contact-form__grid">
                <label>
                    <span><?php esc_html_e('Full Name / Alias', 'betpro-account'); ?></span>
                    <input type="text" name="name" placeholder="<?php esc_attr_e('John Doe', 'betpro-account'); ?>" autocomplete="name" required>
                </label>
                <label>
                    <span><?php esc_html_e('Email Address', 'betpro-account'); ?></span>
                    <input type="email" name="email" placeholder="<?php esc_attr_e('john@example.com', 'betpro-account'); ?>" autocomplete="email" required>
                </label>
                <label>
                    <span><?php esc_html_e('WhatsApp Number', 'betpro-account'); ?></span>
                    <input type="text" name="whatsapp" placeholder="<?php esc_attr_e('+1 234 567 8900', 'betpro-account'); ?>" autocomplete="tel" required>
                </label>
                <label>
                    <span><?php esc_html_e('Platform Needed', 'betpro-account'); ?></span>
                    <input type="text" name="platform" placeholder="<?php esc_attr_e('Bet365, Betway, etc.', 'betpro-account'); ?>" required>
                </label>
            </div>
            <label>
                <span><?php esc_html_e('Message Details', 'betpro-account'); ?></span>
                <textarea name="message" placeholder="<?php esc_attr_e('Please specify any specific requirements or your estimated monthly volume...', 'betpro-account'); ?>" required></textarea>
            </label>
            <div class="betpro-contact-form__actions">
                <button type="submit"><?php esc_html_e('Submit Inquiry', 'betpro-account'); ?> <i class="fa-solid fa-arrow-right" aria-hidden="true"></i></button>
                <p class="betpro-contact-form__message" role="status" aria-live="polite"></p>
            </div>
        </form>
    </div>
</div>
