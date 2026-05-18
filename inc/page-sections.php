<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_render_services_overview(): void
{
    $services = array(
        array('title' => __('Betting Account Creation', 'betpro-account'), 'text' => __('New accounts on any bookmaker, fully registered and identity-verified. We set up everything from scratch on tier-1 platforms.', 'betpro-account'), 'points' => array(__('Full KYC included', 'betpro-account'), __('Clean digital footprint', 'betpro-account'), __('Instant readiness', 'betpro-account'))),
        array('title' => __('Account Verification (KYC)', 'betpro-account'), 'text' => __('We handle full document verification on existing accounts. ID, proof of address, selfies — we manage the complete KYC process.', 'betpro-account'), 'points' => array(__('Guaranteed approval', 'betpro-account'), __('Complex cases handled', 'betpro-account'), __('Fast turnaround', 'betpro-account'))),
        array('title' => __('Account Top-Up Services', 'betpro-account'), 'text' => __('Fund your account instantly with verified payment methods. We assist with crypto rails, bank transfer, Easypaisa, JazzCash, and matched e-wallet setups.', 'betpro-account'), 'points' => array(__('Crypto to Fiat', 'betpro-account'), __('Local wallet support', 'betpro-account'), __('Instant deposits', 'betpro-account'))),
        array('title' => __('Account Management', 'betpro-account'), 'text' => __('Ongoing monitoring, limit appeals, and account health checks to keep your betting operation running smoothly.', 'betpro-account'), 'points' => array(__('Daily monitoring', 'betpro-account'), __('Limit appeals', 'betpro-account'), __('Dedicated manager', 'betpro-account'))),
        array('title' => __('Account Replacement', 'betpro-account'), 'text' => __('Fast replacement when accounts get limited or suspended. Never miss out on value due to a banned account.', 'betpro-account'), 'points' => array(__('24hr turnaround', 'betpro-account'), __('Seamless transition', 'betpro-account'), __('Priority sourcing', 'betpro-account'))),
        array('title' => __('Multi-Platform Packages', 'betpro-account'), 'text' => __('Bundles for multiple accounts across multiple bookmakers. Perfect for syndicates and arbitrage bettors.', 'betpro-account'), 'points' => array(__('Bulk discounts', 'betpro-account'), __('Centralized management', 'betpro-account'), __('Cross-platform access', 'betpro-account'))),
    );
    $included = array(__('Verified account setup', 'betpro-account'), __('Fast processing', 'betpro-account'), __('Secure transactions', 'betpro-account'), __('24/7 customer support', 'betpro-account'), __('Assistance on WhatsApp, Telegram & Facebook', 'betpro-account'));
    ?>
    <div class="betpro-services-overview space-y-20">
        <div class="betpro-section-heading max-w-3xl">
            <p class="betpro-eyebrow mb-4 text-xs font-extrabold uppercase tracking-widest text-primary"><?php esc_html_e('What We Do', 'betpro-account'); ?></p>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4"><?php esc_html_e('Our Premium Services', 'betpro-account'); ?></h2>
            <p class="text-muted-foreground leading-8"><?php esc_html_e('Verified betting account creation, KYC, top-ups, replacements, and support from BetPro Account.', 'betpro-account'); ?></p>
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php foreach ($services as $index => $service) : ?>
                <article class="betpro-service-card betpro-reveal group relative overflow-hidden rounded-2xl border border-border bg-card p-7" data-betpro-reveal>
                    <span class="betpro-service-card__number"><?php echo esc_html(str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT)); ?></span>
                    <h2 class="relative text-2xl font-extrabold mb-3"><?php echo esc_html($service['title']); ?></h2>
                    <p class="text-muted-foreground leading-8 mb-5"><?php echo esc_html($service['text']); ?></p>
                    <ul class="betpro-service-card__list space-y-2 text-sm font-semibold text-foreground">
                        <?php foreach ($service['points'] as $point) : ?>
                            <li class="flex gap-2"><span class="text-primary"><i class="fa-solid fa-check" aria-hidden="true"></i></span><span><?php echo esc_html($point); ?></span></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php endforeach; ?>
        </div>
        <section class="betpro-service-feature-panel betpro-reveal mt-4 md:mt-8 rounded-2xl border border-primary/15 bg-primary/5 p-7 md:p-9" data-betpro-reveal>
            <div class="grid gap-8 lg:grid-cols-[1fr_1.2fr] lg:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold mb-3"><?php esc_html_e('Our Services Include', 'betpro-account'); ?></h2>
                    <p class="text-xl font-bold mb-3"><?php esc_html_e('Everything kept simple, fast, and secure.', 'betpro-account'); ?></p>
                    <p class="text-muted-foreground leading-8"><?php esc_html_e('We handle the setup, payment coordination, and delivery process carefully so you can order with confidence.', 'betpro-account'); ?></p>
                </div>
                <div>
                    <div class="flex flex-wrap gap-3 mb-6">
                        <?php foreach ($included as $item) : ?>
                            <span class="rounded-full border border-primary/20 bg-background/80 px-4 py-2 text-sm font-semibold text-foreground"><?php echo esc_html($item); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <p class="text-muted-foreground leading-8 mb-5"><?php esc_html_e("We serve customers 24/7 — contact us anytime, we're always available.", 'betpro-account'); ?></p>
                    <h3 class="text-xl font-extrabold mb-2"><?php esc_html_e('Need a custom solution?', 'betpro-account'); ?></h3>
                    <p class="text-muted-foreground leading-8"><?php esc_html_e('We work with syndicates and high-volume bettors to build bespoke account infrastructure.', 'betpro-account'); ?></p>
                </div>
            </div>
        </section>
    </div>
    <?php
}

function betpro_account_render_process_overview(): void
{
    $steps = array(
        array('title' => __('Send Requirements', 'betpro-account'), 'text' => __('Tell us which platform you need, your account type, and any special requirements.', 'betpro-account'), 'meta' => __('Share the basics first', 'betpro-account')),
        array('title' => __('Confirm Details', 'betpro-account'), 'text' => __('We confirm the service scope, payment method, deposit amount, and estimated delivery time.', 'betpro-account'), 'meta' => __('We lock the exact scope', 'betpro-account')),
        array('title' => __('Pay Deposit', 'betpro-account'), 'text' => __('Pay in PKR or another agreed method using the payment details shared by support.', 'betpro-account'), 'meta' => __('Secure payment step', 'betpro-account')),
        array('title' => __('Receive Account', 'betpro-account'), 'text' => __('We deliver the verified account details and remain available for support after delivery.', 'betpro-account'), 'meta' => __('Delivery plus after-support', 'betpro-account')),
    );
    ?>
    <div class="betpro-process-shell">
        <div class="betpro-process-intro betpro-reveal" data-betpro-reveal>
            <p class="betpro-eyebrow"><?php esc_html_e('Clear 4-Step Flow', 'betpro-account'); ?></p>
            <h2><?php esc_html_e('How your order moves from request to delivery.', 'betpro-account'); ?></h2>
            <p><?php esc_html_e('The process is simple, but it should still feel premium. Each step below shows what happens next so the page feels more trustworthy and less like a generic checklist.', 'betpro-account'); ?></p>
        </div>
        <div class="betpro-process-list">
            <?php foreach ($steps as $index => $step) : ?>
                <article class="betpro-process-card betpro-reveal rounded-2xl border border-border bg-card p-6" data-betpro-reveal>
                    <div class="betpro-process-card__top">
                        <span class="betpro-process-card__number flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-primary text-white font-extrabold"><?php echo esc_html((string) ($index + 1)); ?></span>
                        <span class="betpro-process-card__meta"><?php echo esc_html($step['meta']); ?></span>
                    </div>
                    <div class="betpro-process-card__body">
                        <h2 class="text-xl font-extrabold mb-2"><?php echo esc_html($step['title']); ?></h2>
                        <p class="text-muted-foreground leading-7"><?php echo esc_html($step['text']); ?></p>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
    <?php
}

function betpro_account_render_faq_overview(): void
{
    $faqs = betpro_account_faq_items();
    ?>
    <div class="betpro-faq-list">
        <?php foreach ($faqs as $faq) : ?>
            <article class="betpro-faq-item betpro-reveal" data-betpro-reveal>
                <h2><?php echo esc_html((string) $faq['question']); ?></h2>
                <p><?php echo esc_html((string) $faq['answer']); ?></p>
            </article>
        <?php endforeach; ?>
    </div>
    <?php
}

function betpro_account_render_contact_overview(): void
{
    get_template_part('template-parts/contact-overview');
}

function betpro_account_render_support_cta(string $heading = '', string $description = ''): void
{
    $heading = $heading !== '' ? $heading : __('Need a verified betting account?', 'betpro-account');
    $description = $description !== '' ? $description : __('Message us with the platform you need, your requirements, and your preferred timeline. We will guide you through the next step.', 'betpro-account');
    ?>
    <section class="betpro-cta-section betpro-reveal py-16 bg-primary/5 border-y border-primary/10" data-betpro-reveal>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4"><?php echo esc_html($heading); ?></h2>
            <p class="text-muted-foreground leading-8 max-w-2xl mx-auto mb-8"><?php echo esc_html($description); ?></p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <?php
                betpro_account_render_button(betpro_account_whatsapp_url(), betpro_account_primary_cta_label(), 'primary', true);
                betpro_account_render_button(home_url('/contact/'), __('Contact Page', 'betpro-account'), 'secondary');
                ?>
            </div>
        </div>
    </section>
    <?php
}   


function betpro_account_render_schedule_page(): void
{
    $today = gmdate('Y-m-d');
    $fixtures = array(
        array('date' => '2026-05-18', 'time' => '14:00 PKT', 'tournament' => 'Pakistan Super League 2026', 'match' => 'Lahore Qalandars vs Karachi Kings', 'venue' => 'Gaddafi Stadium, Lahore', 'status' => __('Today', 'betpro-account')),
        array('date' => '2026-05-18', 'time' => '19:00 PKT', 'tournament' => 'Pakistan Super League 2026', 'match' => 'Multan Sultans vs Peshawar Zalmi', 'venue' => 'Multan Cricket Stadium, Multan', 'status' => __('Today', 'betpro-account')),
        array('date' => '2026-05-20', 'time' => '15:30 PKT', 'tournament' => 'Bpexch T20 Cup', 'match' => 'Islamabad United vs Quetta Gladiators', 'venue' => 'Rawalpindi Cricket Stadium', 'status' => __('Upcoming', 'betpro-account')),
        array('date' => '2026-05-22', 'time' => '20:00 PKT', 'tournament' => 'Bpexch ODI Series', 'match' => 'Pakistan vs Sri Lanka', 'venue' => 'National Stadium, Karachi', 'status' => __('Upcoming', 'betpro-account')),
        array('date' => '2026-05-25', 'time' => '16:00 PKT', 'tournament' => 'BetPro Premium League', 'match' => 'Faisalabad Wolves vs Sialkot Stallions', 'venue' => 'Iqbal Stadium, Faisalabad', 'status' => __('Upcoming', 'betpro-account')),
    );

    echo '<div class="space-y-8">';
    echo '<p class="text-muted-foreground text-lg leading-8">' . esc_html__('Track today\'s matches and upcoming BetPro & Bpexch cricket fixtures for Pakistan. Each card includes a direct Bet Now call-to-action.', 'betpro-account') . '</p>';
    echo '<div class="grid gap-6 md:grid-cols-2">';

    foreach ($fixtures as $fixture) {
        $is_today = $fixture['date'] === $today || $fixture['status'] === 'Today';
        echo '<article class="rounded-2xl border border-border bg-card p-6 shadow-sm">';
        echo '<div class="mb-3 flex items-center justify-between gap-3">';
        echo '<span class="inline-flex rounded-full px-3 py-1 text-xs font-bold ' . ($is_today ? 'bg-primary text-white' : 'bg-primary/10 text-primary') . '">' . esc_html($fixture['status']) . '</span>';
        echo '<p class="text-sm font-semibold text-muted-foreground">' . esc_html(date_i18n('F j, Y', strtotime($fixture['date']))) . ' · ' . esc_html($fixture['time']) . '</p>';
        echo '</div>';
        echo '<h2 class="mb-2 text-2xl font-extrabold">' . esc_html($fixture['match']) . '</h2>';
        echo '<p class="mb-2 text-sm font-bold uppercase tracking-widest text-primary">' . esc_html($fixture['tournament']) . '</p>';
        echo '<p class="mb-5 text-muted-foreground">' . esc_html($fixture['venue']) . '</p>';
        betpro_account_render_button(betpro_account_whatsapp_url(), __('Bet Now', 'betpro-account'), 'primary', true);
        echo '</article>';
    }

    echo '</div></div>';
}

function betpro_account_render_dealer_cities_page(): void
{
    $cities = array('Karachi','Lahore','Faisalabad','Rawalpindi','Multan','Gujranwala','Peshawar','Hyderabad','Islamabad','Quetta','Bahawalpur','Sargodha','Sialkot','Sukkur','Larkana','Sheikhupura','Rahim Yar Khan','Jhang','Dera Ghazi Khan','Gujrat','Sahiwal','Wah Cantonment','Mardan','Kasur','Okara','Mingora','Nawabshah','Chiniot','Kohat','Kamoke','Hafizabad','Sadiqabad','Mirpur Khas','Burewala','Khanewal','Jacobabad','Shikarpur','Muzaffargarh','Khanpur','Gojra','Bahawalnagar','Abbottabad','Muridke','Pakpattan','Khuzdar','Jhelum','Chakwal','Daska','Mandi Bahauddin','Vehari');
    echo '<div class="space-y-8">';
    echo '<p class="text-muted-foreground text-lg leading-8">' . esc_html__('Find BetPro dealers across major cities in Pakistan. Contact us for instant account setup, KYC support, and same-day service.', 'betpro-account') . '</p>';
    echo '<div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">';
    foreach ($cities as $city) {
        echo '<article class="rounded-xl border border-border bg-card p-5">';
        echo '<h2 class="mb-2 text-xl font-extrabold">' . esc_html(sprintf(__('BetPro Dealer in %s', 'betpro-account'), $city)) . '</h2>';
        echo '<p class="mb-4 text-sm text-muted-foreground">' . esc_html__('Verified account support, replacement service, and 24/7 WhatsApp response available.', 'betpro-account') . '</p>';
        betpro_account_render_button(betpro_account_whatsapp_url(), __('Contact Dealer', 'betpro-account'), 'secondary', true);
        echo '</article>';
    }
    echo '</div></div>';
}
