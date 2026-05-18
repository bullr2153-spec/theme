<?php

if (! defined('ABSPATH')) {
    exit;
}

$setup_image = (string) ($args['setup_image'] ?? '');
?>

<section class="betpro-process-section py-24 bg-card">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid gap-14 lg:grid-cols-2 lg:items-start">
            <div class="betpro-reveal" data-betpro-reveal>
                <p class="betpro-eyebrow mb-5 inline-flex rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-sm font-bold uppercase tracking-wider text-primary"><?php esc_html_e('The Process', 'betpro-account'); ?></p>
                <h2 class="text-3xl md:text-4xl font-extrabold mb-8"><?php esc_html_e('Get a BetPro Account in 4 Easy Steps', 'betpro-account'); ?></h2>
                <div class="betpro-process-list">
                    <?php
                    $steps = array(
                        array('title' => __('Contact us on WhatsApp', 'betpro-account'), 'text' => __('Message our team directly and get a quick reply from a real person.', 'betpro-account')),
                        array('title' => __('Share your requirements', 'betpro-account'), 'text' => __('Tell us which account you need and any important details.', 'betpro-account')),
                        array('title' => __('Pay the deposit in PKR', 'betpro-account'), 'text' => __('Use secure local payment methods and we confirm before processing begins.', 'betpro-account')),
                        array('title' => __('Get your account quickly', 'betpro-account'), 'text' => __('We process your order fast and support you after delivery too.', 'betpro-account')),
                    );
                    foreach ($steps as $index => $step) :
                        ?>
                        <div class="betpro-process-step betpro-reveal" data-betpro-reveal>
                            <span><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                            <div><h3><?php echo esc_html($step['title']); ?></h3><p class="text-lg"><?php echo esc_html($step['text']); ?></p></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="mt-8"><?php betpro_account_render_button(betpro_account_whatsapp_url(), __('Start Your Order Now', 'betpro-account'), 'primary', true); ?></div>
            </div>
            <div class="betpro-process-visual betpro-reveal" data-betpro-reveal>
                <img src="<?php echo esc_url($setup_image); ?>" alt="<?php esc_attr_e('Verified betting account confirmation on a mobile phone', 'betpro-account'); ?>" loading="lazy" />
            </div>
        </div>
    </div>
</section>

<section class="betpro-compare-section">
    <div class="betpro-home-container">
        <div class="betpro-section-heading betpro-reveal" data-betpro-reveal>
            <p class="betpro-eyebrow text-lg"><?php esc_html_e('Comparison', 'betpro-account'); ?></p>
            <h2><?php esc_html_e('BetPro vs Everyone Else', 'betpro-account'); ?></h2>
            <p class="text-lg"><?php esc_html_e('We built our service around the things that actually matter to serious bettors.', 'betpro-account'); ?></p>
        </div>
        <div class="betpro-compare-table betpro-reveal" data-betpro-reveal>
            <div class="betpro-compare-table__head">
                <span class="text-lg"><?php esc_html_e('Feature', 'betpro-account'); ?></span>
                <span class="text-lg"><?php esc_html_e('BetPro Account', 'betpro-account'); ?></span>
                <span class="text-lg"><?php esc_html_e('Other Providers', 'betpro-account'); ?></span>
            </div>
            <?php
            $rows = array(
                array(__('Delivery Time', 'betpro-account'), __('24-48 Hours', 'betpro-account'), __('5-10 business days', 'betpro-account')),
                array(__('KYC Verification', 'betpro-account'), __('Highly reliable', 'betpro-account'), __('Partial / Hit & Miss', 'betpro-account')),
                array(__('Support Channel', 'betpro-account'), __('WhatsApp & Telegram', 'betpro-account'), __('Email only', 'betpro-account')),
                array(__('Account Replacement', 'betpro-account'), __('Included', 'betpro-account'), __('Not offered', 'betpro-account')),
                array(__('Bookmakers Covered', 'betpro-account'), __('30+ platforms', 'betpro-account'), __('5-10 platforms', 'betpro-account')),
                array(__('Payment Options', 'betpro-account'), __('Crypto, bank, Easypaisa & JazzCash', 'betpro-account'), __('Bank transfer only', 'betpro-account')),
            );
            foreach ($rows as $row) :
                ?>
                <div class="betpro-compare-table__row">
                    <span class="text-lg"><?php echo esc_html($row[0]); ?></span>
                    <strong><i class="fa-solid fa-check" aria-hidden="true"></i><?php echo esc_html($row[1]); ?></strong>
                    <em><i class="fa-solid fa-xmark" aria-hidden="true"></i><?php echo esc_html($row[2]); ?></em>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
