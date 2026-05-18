<?php

if (! defined('ABSPATH')) {
    exit;
}
?>

<section class="betpro-stat-band py-16 bg-primary/5 border-b border-primary/10">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 gap-6 text-center md:grid-cols-4">
            <?php
            $stats = array(
                array('value' => '10,000+', 'label' => __('Accounts Delivered', 'betpro-account')),
                array('value' => '30+', 'label' => __('Bookmakers Supported', 'betpro-account')),
                array('value' => '98%', 'label' => __('Verified Success Rate', 'betpro-account')),
                array('value' => '2,500+', 'label' => __('Happy Customers', 'betpro-account')),
            );
            foreach ($stats as $stat) :
                ?>
                <div class="betpro-reveal p-6" data-betpro-reveal>
                    <div class="text-4xl md:text-5xl font-extrabold text-foreground mb-1"><?php echo esc_html($stat['value']); ?></div>
                    <div class="text-sm text-primary font-medium"><?php echo esc_html($stat['label']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="betpro-live-sales py-18 bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="betpro-live-sales__panel betpro-reveal" data-betpro-reveal data-betpro-live-sales>
            <div class="betpro-live-sales__intro">
                <p class="betpro-eyebrow text-lg"><?php esc_html_e('Live queue status', 'betpro-account'); ?></p>
                <h2><?php esc_html_e('Verified accounts moving through verification and delivery.', 'betpro-account'); ?></h2>
                <p class="text-lg"><?php esc_html_e('Live stats from today\'s BetPro queue. See how many accounts are delivered, in KYC review, and supported on WhatsApp.', 'betpro-account'); ?></p>
                <div class="betpro-live-sales__meta">
                    <span class="text-lg"><?php esc_html_e('Live queue counter', 'betpro-account'); ?></span>
                    <span class="text-lg" data-betpro-live-clock><?php esc_html_e('Updated just now', 'betpro-account'); ?></span>
                </div>
            </div>
            <div class="betpro-live-sales__grid">
                <article class="betpro-live-sales__card">
                    <span class="text-lg"><?php esc_html_e('Accounts Delivered', 'betpro-account'); ?></span>
                    <strong data-betpro-live-number data-base="18" data-min="16" data-max="24">18</strong>
                    <small><?php esc_html_e('Verified accounts delivered today', 'betpro-account'); ?></small>
                </article>
                <article class="betpro-live-sales__card">
                    <span class="text-lg"><?php esc_html_e('In Verification', 'betpro-account'); ?></span>
                    <strong data-betpro-live-number data-base="7" data-min="5" data-max="11">7</strong>
                    <small><?php esc_html_e('KYC review in progress', 'betpro-account'); ?></small>
                </article>
                <article class="betpro-live-sales__card">
                    <span class="text-lg"><?php esc_html_e('Live support replies', 'betpro-account'); ?></span>
                    <strong data-betpro-live-number data-base="6" data-min="5" data-max="9">6</strong>
                    <small><?php esc_html_e('WhatsApp support conversations', 'betpro-account'); ?></small>
                </article>
                <article class="betpro-live-sales__card">
                    <span class="text-lg"><?php esc_html_e('Delivered so far', 'betpro-account'); ?></span>
                    <strong><span data-betpro-live-number data-base="17" data-min="15" data-max="23">17</span>/24</strong>
                    <small><?php esc_html_e('Verified accounts completed today', 'betpro-account'); ?></small>
                </article>
            </div>
            <div class="betpro-live-sales__progress">
                <div class="betpro-live-sales__progress-copy">
                    <strong><?php esc_html_e('Delivery progress', 'betpro-account'); ?></strong>
                    <span class="text-lg" data-betpro-live-progress-label><?php esc_html_e('17 of 24 delivered', 'betpro-account'); ?></span>
                </div>
                <div class="betpro-live-sales__bar">
                    <span data-betpro-live-progress style="width:70.8%"></span>
                </div>
            </div>
            <div class="betpro-live-sales__ticker">
                <span class="betpro-live-sales__pulse" aria-hidden="true"></span>
                <p class="text-lg" data-betpro-live-status><?php esc_html_e('Verified account handed over to a returning customer with live support.', 'betpro-account'); ?></p>
            </div>
        </div>
    </div>
</section>

<section class="betpro-home-services py-24 bg-background">
    <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
        <div class="betpro-section-heading betpro-reveal text-center max-w-2xl mx-auto mb-14" data-betpro-reveal>
            <p class="betpro-eyebrow text-lg"><?php esc_html_e('How It Works', 'betpro-account'); ?></p>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4"><?php esc_html_e('Get your verified BetPro account in 24-48 hours.', 'betpro-account'); ?></h2>
            <p class="text-lg text-muted-foreground"><?php esc_html_e('We create the account, complete the KYC verification, and deliver it ready to use. No waiting in queues, no documentation hassle—just place your bets.', 'betpro-account'); ?></p>
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
            <?php
            $services = array(
                array('icon' => 'fa-user-plus', 'title' => __('Create Account', 'betpro-account'), 'text' => __('Fresh registered account on BetPro. Tell us your details, we handle the registration.', 'betpro-account')),
                array('icon' => 'fa-wallet', 'title' => __('Fund Your Account', 'betpro-account'), 'text' => __('Add money via crypto, bank transfer, Easypaisa, JazzCash, or other methods.', 'betpro-account')),
                array('icon' => 'fa-id-card', 'title' => __('Complete KYC', 'betpro-account'), 'text' => __('Submit documents and we guide you through verification. Most approvals in 24 hours.', 'betpro-account')),
                array('icon' => 'fa-headset', 'title' => __('Get Support When Needed', 'betpro-account'), 'text' => __('WhatsApp support available. Help with account issues, limits, or replacements.', 'betpro-account')),
            );
            foreach ($services as $index => $service) :
                ?>
                <article class="betpro-choice-card betpro-reveal relative overflow-hidden rounded-2xl border border-border bg-card p-7 transition-all hover:-translate-y-1 hover:border-primary/30" data-betpro-reveal>
                    <span class="betpro-choice-card__icon" aria-hidden="true"><i class="fa-solid <?php echo esc_attr($service['icon']); ?>"></i></span>
                    <div class="absolute right-5 top-5 text-6xl font-black text-primary/5"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></div>
                    <h3 class="relative text-lg font-bold mb-3"><?php echo esc_html($service['title']); ?></h3>
                    <p class="relative text-lg text-muted-foreground leading-7"><?php echo esc_html($service['text']); ?></p>
                </article>
            <?php endforeach; ?>
        </div>
        <div class="betpro-service-tags betpro-reveal" data-betpro-reveal>
            <?php foreach (array('Accounts delivered in 24-48 hours', 'KYC verified and approved', 'Replacement guarantee', 'Live WhatsApp support', 'Multiple payment methods') as $tag) : ?>
                <span class="text-lg"><?php echo esc_html($tag); ?></span>
            <?php endforeach; ?>
        </div>
    </div>
</section>
