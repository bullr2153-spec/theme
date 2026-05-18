<?php

if (! defined('ABSPATH')) {
    exit;
}

?>
<section class="betpro-content-section pb-16 bg-background">
    <div class="betpro-contact-form-shell max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="betpro-contact-form-intro betpro-reveal" data-betpro-reveal>
            <p class="betpro-eyebrow"><?php esc_html_e('Start Here', 'betpro-account'); ?></p>
            <h2><?php esc_html_e('Send your account request', 'betpro-account'); ?></h2>
            <p><?php esc_html_e('Use this form when you want a structured quote. For urgent orders, WhatsApp is still the fastest option.', 'betpro-account'); ?></p>
        </div>
        <form class="betpro-contact-form betpro-reveal" method="post" data-betpro-reveal>
            <div class="betpro-contact-form__grid">
                <label>
                    <span><?php esc_html_e('Full Name', 'betpro-account'); ?></span>
                    <input type="text" name="name" autocomplete="name" required>
                </label>
                <label>
                    <span><?php esc_html_e('Email', 'betpro-account'); ?></span>
                    <input type="email" name="email" autocomplete="email" required>
                </label>
                <label>
                    <span><?php esc_html_e('WhatsApp', 'betpro-account'); ?></span>
                    <input type="text" name="whatsapp" autocomplete="tel" required>
                </label>
                <label>
                    <span><?php esc_html_e('Platform', 'betpro-account'); ?></span>
                    <input type="text" name="platform" placeholder="<?php esc_attr_e('BetPro, Bet365...', 'betpro-account'); ?>" required>
                </label>
            </div>
            <label>
                <span><?php esc_html_e('Message', 'betpro-account'); ?></span>
                <textarea name="message" placeholder="<?php esc_attr_e('Tell us the account type, payment method, and timeline you need.', 'betpro-account'); ?>" required></textarea>
            </label>
            <div class="betpro-contact-form__actions">
                <button type="submit"><?php esc_html_e('Send Inquiry', 'betpro-account'); ?></button>
                <p class="betpro-contact-form__message" role="status" aria-live="polite"></p>
            </div>
        </form>
    </div>
</section>
