<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_add_post_rewrite_rule(): void
{
    add_rewrite_rule(
        betpro_account_post_rewrite_rule_pattern(),
        betpro_account_post_rewrite_rule_target(),
        'top'
    );
}
add_action('init', 'betpro_account_add_post_rewrite_rule');

function betpro_account_post_rewrite_rule_pattern(): string
{
    return '^blog/([^/]+)/?$';
}

function betpro_account_post_rewrite_rule_target(): string
{
    return 'index.php?post_type=post&name=$matches[1]';
}

function betpro_account_post_permalink_structure(): string
{
    return '/blog/%postname%/';
}

function betpro_account_maybe_set_post_permalink_structure(): void
{
    $target = betpro_account_post_permalink_structure();
    $current = (string) get_option('permalink_structure', '');
    $release_flag = 'betpro_post_permalink_structure_20260427';

    if ($current === $target) {
        update_option($release_flag, 'done', false);
        return;
    }

    if (get_option($release_flag) === 'done') {
        return;
    }

    if (! in_array($current, array('/%postname%/', '/index.php/%postname%/'), true)) {
        return;
    }

    update_option('permalink_structure', $target);
    update_option($release_flag, 'done', false);
    flush_rewrite_rules(false);
}
add_action('init', 'betpro_account_maybe_set_post_permalink_structure', 19);

function betpro_account_maybe_flush_post_rewrite_rules(): void
{
    $rules = get_option('rewrite_rules');
    $pattern = betpro_account_post_rewrite_rule_pattern();
    $target = betpro_account_post_rewrite_rule_target();

    if (is_array($rules) && (($rules[$pattern] ?? '') === $target)) {
        return;
    }

    flush_rewrite_rules(false);
}
add_action('init', 'betpro_account_maybe_flush_post_rewrite_rules', 20);

function betpro_account_filter_pre_post_link($permalink, $post = null): string
{
    if (! $post instanceof WP_Post || $post->post_type !== 'post') {
        return is_string($permalink) ? $permalink : '';
    }

    return betpro_account_post_permalink_structure();
}
add_filter('pre_post_link', 'betpro_account_filter_pre_post_link', 10, 2);

function betpro_account_filter_post_link($permalink, $post): string
{
    $permalink = is_string($permalink) ? $permalink : '';

    if (! $post instanceof WP_Post) {
        return $permalink;
    }

    if ($post->post_type !== 'post' || $post->post_name === '') {
        return $permalink;
    }

    return home_url(user_trailingslashit('blog/' . $post->post_name));
}
add_filter('post_link', 'betpro_account_filter_post_link', 10, 2);

function betpro_account_redirect_legacy_root_post_urls(): void
{
    if (is_admin() || wp_doing_ajax() || ! is_404()) {
        return;
    }

    $request_path = trim(betpro_account_request_path(), '/');

    if ($request_path === '' || strpos($request_path, '/') !== false) {
        return;
    }

    $post = get_page_by_path($request_path, OBJECT, 'post');

    if (! $post instanceof WP_Post) {
        return;
    }

    $permalink = get_permalink($post);

    if (! is_string($permalink) || $permalink === '') {
        return;
    }

    wp_safe_redirect($permalink, 301, 'BetPro Account');
    exit;
}
add_action('template_redirect', 'betpro_account_redirect_legacy_root_post_urls', 1);

function betpro_account_manifest(): array
{
    static $manifest = null;

    if (is_array($manifest)) {
        return $manifest;
    }

    $manifest_path = betpro_account_asset_dir() . '/manifest.json';

    if (! file_exists($manifest_path)) {
        $manifest = array();
        return array();
    }

    $contents = file_get_contents($manifest_path);

    if (! is_string($contents) || $contents === '') {
        $manifest = array();
        return array();
    }

    $decoded = json_decode($contents, true);

    $manifest = is_array($decoded) ? $decoded : array();

    return $manifest;
}

function betpro_account_frontend_build_id(): string
{
    $manifest = betpro_account_manifest();
    $entry = $manifest['index.html'] ?? null;

    if (! is_array($entry)) {
        return '';
    }

    $file = $entry['file'] ?? '';

    return is_string($file) ? wp_basename($file) : '';
}

function betpro_account_find_page_id_by_slug(string $slug): int
{
    $page = get_page_by_path($slug, OBJECT, 'page');

    return $page instanceof WP_Post ? (int) $page->ID : 0;
}

function betpro_account_default_pages(): array
{
    return array(
        array(
            'slug' => 'home',
            'title' => __('BetPro Account | Verified Betting Accounts', 'betpro-account'),
            'excerpt' => __('BetPro Account delivers verified betting accounts, fast setup, KYC support, and secure PKR payments.', 'betpro-account'),
            'content' => '',
        ),
        array(
            'slug' => 'services',
            'title' => __('BetPro Account Services', 'betpro-account'),
            'excerpt' => __('Explore BetPro Account services for verified betting accounts, KYC, top-ups, replacements, and account management.', 'betpro-account'),
            'content' => '',
        ),
        array(
            'slug' => 'how-it-works',
            'title' => __('BetPro Account Process', 'betpro-account'),
            'excerpt' => __('See how BetPro Account delivers verified betting accounts with a simple PKR order process and fast support.', 'betpro-account'),
            'content' => '',
        ),
        array(
            'slug' => 'faq',
            'title' => __('BetPro Account FAQ', 'betpro-account'),
            'excerpt' => __('Clear answers about BetPro Account, verified betting accounts, PKR payments, delivery times, and 24/7 support.', 'betpro-account'),
            'content' => betpro_account_generated_page_content('faq'),
        ),
        array(
            'slug' => 'contact',
            'title' => __('Contact BetPro Account', 'betpro-account'),
            'excerpt' => __('Contact BetPro Account for verified betting accounts, KYC help, replacements, payment questions, and delivery estimates.', 'betpro-account'),
            'content' => betpro_account_generated_page_content('contact'),
        ),
        array(
            'slug' => 'blog',
            'title' => __('BetPro Account Blog', 'betpro-account'),
            'excerpt' => __('Read BetPro Account guides on verified betting accounts, bookmaker limits, KYC, payments, and multi-account strategy.', 'betpro-account'),
            'content' => '',
        ),
        array(
            'slug' => 'terms-of-service',
            'title' => __('BetPro Account Terms of Service', 'betpro-account'),
            'excerpt' => __('Read the BetPro Account terms before using our verified betting account services.', 'betpro-account'),
            'content' => betpro_account_default_terms_content(),
        ),
        array(
            'slug' => 'privacy-policy',
            'title' => __('BetPro Account Privacy Policy', 'betpro-account'),
            'excerpt' => __('Learn how BetPro Account collects, uses, and protects your information.', 'betpro-account'),
            'content' => betpro_account_default_privacy_content(),
        ),
    );
}

function betpro_account_default_terms_content(): string
{
    return '
<h2>1. Acceptance of Terms</h2>
<p>By accessing BetPro Account or placing an order through our official support channels, you agree to these Terms of Service.</p>
<p>We may update these terms when our services, payment options, or operating requirements change.</p>
<h2>2. Services</h2>
<p>BetPro Account provides account creation, KYC verification support, top-up guidance, replacement support, and account management help for supported betting platforms.</p>
<p>We are not affiliated with or endorsed by any bookmaker or third-party platform mentioned on this website.</p>
<h2>3. Eligibility</h2>
<p>You must be at least 18 years old and responsible for confirming that your requested service is lawful in your jurisdiction.</p>
<h2>4. Payments</h2>
<p>Pricing, deposit requirements, payment method, and delivery estimates are confirmed through official support before work begins.</p>
<p>Supported payment routes may include PKR bank transfer, Easypaisa, JazzCash, crypto, or another method agreed with support.</p>
<h2>5. Delivery and Support</h2>
<p>Delivery timelines are estimates. Platform reviews, KYC checks, third-party outages, or incomplete information may affect timing.</p>
<p>After delivery, clients should review the account details promptly and contact support with any issue as soon as possible.</p>
<h2>6. Client Responsibilities</h2>
<p>You are responsible for providing accurate information, following support instructions, and using delivered accounts responsibly.</p>
<h2>7. Limitation of Liability</h2>
<p>BetPro Account does not guarantee betting outcomes, bookmaker decisions, account longevity, withdrawal success, or third-party platform availability.</p>
<p>To the fullest extent permitted by law, our liability is limited to the amount paid for the specific service connected to the claim.</p>
<h2>8. Contact</h2>
<p>Questions about these terms can be sent through WhatsApp, Telegram, or the contact email listed on this website.</p>';
}

function betpro_account_default_privacy_content(): string
{
    return '
<h2>1. Overview</h2>
<p>BetPro Account respects client privacy and uses personal information only as needed to respond to inquiries, process orders, deliver services, and provide support.</p>
<h2>2. Information We Collect</h2>
<p>We may collect your name, email address, WhatsApp number, platform requirements, order notes, payment-related details, and standard website usage information.</p>
<h2>3. How We Use Information</h2>
<p>Information is used to answer questions, confirm service requirements, process orders, provide updates, prevent fraud, and improve our website and support workflow.</p>
<h2>4. Sharing</h2>
<p>We do not sell personal information. Limited information may be shared with trusted service partners only when needed to complete a requested service or comply with valid legal requirements.</p>
<h2>5. Retention</h2>
<p>We keep information for as long as needed for service delivery, support, record keeping, dispute handling, and legitimate operational needs.</p>
<h2>6. Security</h2>
<p>We use reasonable safeguards to protect client information, but no online transmission or storage method can be guaranteed as perfectly secure.</p>
<h2>7. Your Requests</h2>
<p>You may contact us to request access, correction, or deletion of your information where applicable.</p>
<h2>8. Contact</h2>
<p>Privacy questions can be sent through WhatsApp, Telegram, or the support email shown on this website.</p>';
}

require_once __DIR__ . '/content-seeding-runner.php';
