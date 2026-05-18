<?php

if (! defined('ABSPATH')) {
    exit;
}

$hero_image = (string) ($args['hero_image'] ?? '');
$person_image = (string) ($args['person_image'] ?? '');
?>

<section class="betpro-home-hero relative overflow-hidden min-h-[92svh] flex items-center border-b border-border bg-background py-20 lg:py-28">
    <div class="absolute inset-0 z-0">
        <img src="<?php echo esc_url($hero_image); ?>" alt="" class="h-full w-full object-cover opacity-20" fetchpriority="high" />
        <div class="absolute inset-0 bg-gradient-to-br from-background via-background/85 to-background/50"></div>
    </div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
        <div class="grid gap-14 lg:grid-cols-2 lg:items-center">
            <div class="betpro-reveal" data-betpro-reveal>
                <div class="betpro-eyebrow inline-flex items-center gap-2 rounded-full border border-primary/25 bg-primary/10 px-4 py-1.5 text-sm font-semibold text-primary mb-7">
                    <?php esc_html_e('Verified BetPro accounts in Pakistan', 'betpro-account'); ?>
                </div>
                <h1 class="text-5xl lg:text-6xl xl:text-7xl font-extrabold tracking-tight mb-6 leading-[1.08]">
                    <span class="betpro-home-hero__line"><?php esc_html_e('Verified BetPro account', 'betpro-account'); ?></span>
                    <span class="betpro-home-hero__line text-gradient-green"><?php esc_html_e('ready to use in 24-48 hours', 'betpro-account'); ?></span>
                </h1>
                <p class="text-2xl text-muted-foreground mb-9 leading-9 max-w-xl">
                    <?php esc_html_e('We create your account, finish ID check, and send you a ready-to-use BetPro login with WhatsApp help. Simple process, no long wait.', 'betpro-account'); ?>
                </p>
                <div class="betpro-home-hero__actions flex flex-col sm:flex-row gap-4 mb-8">
                    <?php betpro_account_render_button(betpro_account_whatsapp_url(), betpro_account_primary_cta_label(), 'primary', true); ?>
                </div>
                <div class="betpro-home-hero__proof grid gap-3 text-lg text-muted-foreground sm:grid-cols-2">
                    <?php foreach (array('Ready BetPro login', 'Delivered in 24-48 hours', 'ID check help included', 'WhatsApp support available') as $proof) : ?>
                        <span><i class="fa-solid fa-check" aria-hidden="true"></i><?php echo esc_html($proof); ?></span>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="betpro-home-hero__visual betpro-reveal relative hidden lg:block" data-betpro-reveal>
                <div class="betpro-home-hero__visual-glow absolute inset-0 rounded-full bg-primary/15 blur-[100px]"></div>
                <div class="betpro-home-hero__image-card relative overflow-hidden rounded-2xl shadow-2xl ring-1 ring-white/10">
                    <img src="<?php echo esc_url($person_image); ?>" alt="<?php esc_attr_e('Professional betting account support workspace', 'betpro-account'); ?>" class="h-[480px] w-full object-cover object-top" />
                    <div class="absolute inset-0 bg-gradient-to-t from-background/80 via-transparent to-transparent"></div>
                </div>
                <?php foreach (array('delivery' => 'Under 24 Hours', 'status' => 'Verified & Active') as $type => $value) : ?>
                    <div class="glass-card betpro-hero-badge betpro-hero-badge--<?php echo esc_attr($type); ?>">
                        <span class="betpro-hero-badge__icon" aria-hidden="true">
                            <i class="fa-solid <?php echo esc_attr($type === 'delivery' ? 'fa-clock' : 'fa-circle-check'); ?>"></i>
                        </span>
                        <span><small><?php echo esc_html($type === 'delivery' ? 'Avg Delivery' : 'Account Status'); ?></small><strong><?php echo esc_html($value); ?></strong></span>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
