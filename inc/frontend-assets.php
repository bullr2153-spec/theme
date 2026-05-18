<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_theme_data(): array
{
    return array(
        'wordpressMode' => true,
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'contactNonce' => wp_create_nonce('betpro_contact'),
        'settings' => betpro_account_theme_settings(),
        'images' => betpro_account_theme_images(),
        'menus' => array(
            'primary' => betpro_account_menu_items('primary'),
            'footer_quick' => betpro_account_menu_items('footer_quick'),
            'footer_support' => betpro_account_menu_items('footer_support'),
        ),
        'currentPage' => betpro_account_current_page_data(),
        'currentPost' => betpro_account_current_post_data(),
        'blogPosts' => betpro_account_blog_posts_data(),
    );
}

function betpro_account_enqueue_assets(): void
{
    $manifest = betpro_account_manifest();
    $entry = $manifest['index.html'] ?? null;
    $theme_version = betpro_account_theme_version();
    $fontawesome_handle = betpro_account_enqueue_fontawesome($theme_version);
    $font_handle = betpro_account_enqueue_local_fonts($theme_version);

    if (! is_array($entry)) {
        betpro_account_enqueue_theme_styles($theme_version, array($fontawesome_handle, $font_handle));
        wp_register_script('betpro-account-native', '', array(), $theme_version, true);
        wp_enqueue_script('betpro-account-native');
        wp_add_inline_script('betpro-account-native', betpro_account_native_script());
        return;
    }

    $css_files = array();

    if (! empty($entry['css']) && is_array($entry['css'])) {
        foreach ($entry['css'] as $css_file) {
            if (is_string($css_file) && $css_file !== '') {
                $css_files[] = $css_file;
            }
        }
    }

    foreach ($manifest as $manifest_entry) {
        if (! is_array($manifest_entry)) {
            continue;
        }

        $manifest_file = $manifest_entry['file'] ?? null;

        if (! is_string($manifest_file) || ! str_ends_with($manifest_file, '.css')) {
            continue;
        }

        $css_files[] = $manifest_file;
    }

    $css_files = array_values(array_unique($css_files));

    $app_style_handles = betpro_account_enqueue_app_styles($css_files);
    array_unshift($app_style_handles, $font_handle);
    array_unshift($app_style_handles, $fontawesome_handle);

    betpro_account_enqueue_theme_styles($theme_version, $app_style_handles);

    wp_enqueue_style(
        'betpro-account-pagination',
        get_template_directory_uri() . '/assets/css/pagination.css',
        array(),
        $theme_version
    );

    wp_register_script('betpro-account-native', '', array(), $theme_version, true);
    wp_enqueue_script('betpro-account-native');
    wp_add_inline_script('betpro-account-native', betpro_account_native_script());
}
add_action('wp_enqueue_scripts', 'betpro_account_enqueue_assets');

function betpro_account_resource_hints(array $urls, string $relation_type): array
{
    if (! in_array($relation_type, array('preconnect', 'dns-prefetch'), true)) {
        return $urls;
    }

    foreach (array('https://cdnjs.cloudflare.com') as $url) {
        $urls[] = $url;
    }

    return array_values(array_unique($urls));
}
add_filter('wp_resource_hints', 'betpro_account_resource_hints', 10, 2);

function betpro_account_enqueue_fontawesome(string $theme_version): string
{
    $handle = 'betpro-account-fontawesome';

    wp_enqueue_style(
        $handle,
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
        array(),
        $theme_version
    );

    return $handle;
}

function betpro_account_enqueue_local_fonts(string $theme_version): string
{
    $handle = 'betpro-account-fonts';
    $theme_uri = get_template_directory_uri();

    $fonts = array(
        'Light' => array('weight' => 300, 'file' => 'BricolageGrotesque-Light.ttf'),
        'Regular' => array('weight' => 400, 'file' => 'BricolageGrotesque-Regular.ttf'),
        'Medium' => array('weight' => 500, 'file' => 'BricolageGrotesque-Medium.ttf'),
        'SemiBold' => array('weight' => 600, 'file' => 'BricolageGrotesque-SemiBold.ttf'),
        'Bold' => array('weight' => 700, 'file' => 'BricolageGrotesque-Bold.ttf'),
        'ExtraBold' => array('weight' => 800, 'file' => 'BricolageGrotesque-ExtraBold.ttf'),
    );

    $css = '';
    foreach ($fonts as $font_data) {
        $font_url = $theme_uri . '/static/' . $font_data['file'];
        $css .= '@font-face{font-family:"Bricolage Grotesque";src:url("' . esc_url_raw($font_url) . '") format("truetype");font-weight:' . $font_data['weight'] . ';font-display:swap;}';
    }

    wp_register_style($handle, false, array(), $theme_version);
    wp_enqueue_style($handle);
    wp_add_inline_style($handle, $css);

    return $handle;
}

function betpro_account_enqueue_app_styles(array $css_files): array
{
    $app_style_handles = array();

    foreach ($css_files as $index => $css_file) {
        if (! is_string($css_file) || $css_file === '') {
            continue;
        }

        $handle = "betpro-account-app-{$index}";
        $css = betpro_account_compiled_app_css($css_file);

        if ($css === '') {
            continue;
        }

        wp_register_style(
            $handle,
            false,
            array(),
            betpro_account_asset_version($css_file)
        );
        wp_enqueue_style($handle);
        wp_add_inline_style($handle, $css);

        $app_style_handles[] = $handle;
    }

    return array_values(array_unique($app_style_handles));
}

function betpro_account_compiled_app_css(string $css_file): string
{
    $source_files = array_merge(array($css_file), betpro_account_app_css_imports($css_file));
    $source_files = array_values(array_unique($source_files));

    return betpro_account_css_bundle($source_files, betpro_account_asset_dir());
}

function betpro_account_app_css_imports(string $css_file): array
{
    static $cache = array();

    if (isset($cache[$css_file])) {
        return $cache[$css_file];
    }

    $css_path = betpro_account_asset_dir() . '/' . ltrim($css_file, '/');

    if (! is_file($css_path)) {
        $cache[$css_file] = array();
        return array();
    }

    $contents = file_get_contents($css_path);

    if (! is_string($contents) || $contents === '') {
        $cache[$css_file] = array();
        return array();
    }

    if (! preg_match_all('/@import\s+(?:url\()?["\']([^"\')]+)["\']\)?[^;]*;/', $contents, $matches)) {
        $cache[$css_file] = array();
        return array();
    }

    $base_dir = trim(dirname($css_file), '.');
    $base_dir = $base_dir === '' ? '' : trim($base_dir, '/') . '/';
    $import_files = array();

    foreach ($matches[1] as $import_url) {
        if (! is_string($import_url) || $import_url === '' || preg_match('/^(?:[a-z][a-z0-9+.-]*:|\/\/)/i', $import_url)) {
            continue;
        }

        $normalized = betpro_account_normalize_asset_path($base_dir . $import_url);

        if ($normalized !== '' && is_file(betpro_account_asset_dir() . '/' . $normalized)) {
            $import_files[] = $normalized;
        }
    }

    $cache[$css_file] = array_values(array_unique($import_files));

    return $cache[$css_file];
}

function betpro_account_css_bundle(array $asset_files, string $base_dir): string
{
    $asset_files = array_values(
        array_filter(
            array_unique($asset_files),
            static function ($asset_file): bool {
                return is_string($asset_file) && $asset_file !== '';
            }
        )
    );

    if (empty($asset_files)) {
        return '';
    }

    $css = '';

    foreach ($asset_files as $asset_file) {
        $path = rtrim($base_dir, '/') . '/' . ltrim($asset_file, '/');

        if (! is_file($path)) {
            continue;
        }

        $contents = file_get_contents($path);

        if (! is_string($contents) || $contents === '') {
            continue;
        }

        $contents = preg_replace('/@import\s+(?:url\()?["\'][^"\')]+["\']\)?[^;]*;/', '', $contents);
        $css .= "\n/* " . esc_html($asset_file) . " */\n" . trim((string) $contents) . "\n";
    }

    $css = trim($css);

    return $css;
}

function betpro_account_normalize_asset_path(string $path): string
{
    $segments = array();

    foreach (explode('/', str_replace('\\', '/', $path)) as $segment) {
        if ($segment === '' || $segment === '.') {
            continue;
        }

        if ($segment === '..') {
            array_pop($segments);
            continue;
        }

        $segments[] = $segment;
    }

    return implode('/', $segments);
}

function betpro_account_theme_css_files(): array
{
    return array(
        'assets/css/site-shell.css',
        'assets/css/page-hero.css',
        'assets/css/home-hero.css',
        'assets/css/home-sections.css',
        'assets/css/home-components.css',
        'assets/css/home-content-cards.css',
        'assets/css/sections-cards.css',
        'assets/css/native-content.css',
        'assets/css/single-post.css',
        'assets/css/contact-faq.css',
        'assets/css/contact-page.css',
        'assets/css/contact-form.css',
        'assets/css/utilities-responsive.css',
    );
}

function betpro_account_enqueue_theme_styles(string $theme_version, array $dependencies = array()): void
{
    $theme_css_files = betpro_account_theme_css_files();

    wp_enqueue_style(
        'betpro-account-theme',
        get_stylesheet_uri(),
        $dependencies,
        betpro_account_asset_version('style.css', $theme_version)
    );

    $theme_css = betpro_account_css_bundle($theme_css_files, get_template_directory());

    if ($theme_css !== '') {
        wp_add_inline_style('betpro-account-theme', $theme_css);
    }
}

function betpro_account_native_script(): string
{
    $config = array(
        'ajaxUrl' => admin_url('admin-ajax.php'),
        'contactNonce' => wp_create_nonce('betpro_contact'),
        'messages' => array(
            'sending' => __('Sending your inquiry...', 'betpro-account'),
            'error' => __('Your inquiry could not be sent right now. Please message us directly on WhatsApp.', 'betpro-account'),
        ),
    );

    $encoded_config = wp_json_encode($config);

    return <<<JS
window.betproNative = {$encoded_config};
(function () {
    var config = window.betproNative || {};

    function initReveal() {
        if (document.body && document.body.classList.contains('single-post')) {
            return;
        }

        var elements = Array.prototype.slice.call(document.querySelectorAll('[data-betpro-reveal]'));

        if (! elements.length) {
            return;
        }

        if (! ('IntersectionObserver' in window)) {
            elements.forEach(function (element) {
                element.classList.add('is-visible');
            });
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (! entry.isIntersecting) {
                    return;
                }

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        }, {
            rootMargin: '0px 0px -10% 0px',
            threshold: 0.14
        });

        elements.forEach(function (element, index) {
            element.style.setProperty('--betpro-reveal-delay', Math.min(index % 6, 5) * 70 + 'ms');
            observer.observe(element);
        });
    }

    function initMenu() {
        var toggle = document.querySelector('[data-betpro-menu-toggle]');
        var menu = document.querySelector('[data-betpro-mobile-menu]');

        if (! toggle || ! menu) {
            return;
        }

        function setMenuState(isOpen) {
            toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
            menu.hidden = ! isOpen;
            menu.classList.toggle('is-open', isOpen);
            document.body.classList.toggle('betpro-menu-open', isOpen);
        }

        toggle.addEventListener('click', function () {
            var isOpen = toggle.getAttribute('aria-expanded') === 'true';
            setMenuState(! isOpen);
        });

        document.addEventListener('click', function (event) {
            if (menu.hidden) {
                return;
            }

            if (menu.contains(event.target) || toggle.contains(event.target)) {
                return;
            }

            setMenuState(false);
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                setMenuState(false);
            }
        });

        menu.querySelectorAll('a').forEach(function (link) {
            link.addEventListener('click', function () {
                setMenuState(false);
            });
        });

        window.addEventListener('resize', function () {
            if (window.innerWidth > 960) {
                setMenuState(false);
            }
        });
    }

    function initProofToast() {
        var toast = document.querySelector('[data-betpro-toast]');

        if (! toast) {
            return;
        }

        var textNode = toast.querySelector('p');
        var rawMessages = toast.getAttribute('data-messages') || '[]';
        var messages = [];

        try {
            messages = JSON.parse(rawMessages);
        } catch (error) {
            messages = [];
        }

        if (! textNode || ! Array.isArray(messages) || ! messages.length) {
            return;
        }

        var index = Math.floor(Math.random() * messages.length);

        function showMessage(nextIndex) {
            toast.classList.remove('is-visible');

            window.setTimeout(function () {
                textNode.textContent = messages[nextIndex];
                toast.classList.add('is-visible');
            }, 260);
        }

        textNode.textContent = messages[index];

        window.setTimeout(function () {
            toast.classList.add('is-visible');
        }, 1200);

        window.setInterval(function () {
            var nextIndex = Math.floor(Math.random() * messages.length);

            if (messages.length > 1) {
                while (nextIndex === index) {
                    nextIndex = Math.floor(Math.random() * messages.length);
                }
            }

            index = nextIndex;
            showMessage(index);
        }, 6800);
    }

    function initLiveSalesCounter() {
        var panel = document.querySelector('[data-betpro-live-sales]');

        if (! panel) {
            return;
        }

        var numberNodes = Array.prototype.slice.call(panel.querySelectorAll('[data-betpro-live-number]'));
        var progressNode = panel.querySelector('[data-betpro-live-progress]');
        var progressLabelNode = panel.querySelector('[data-betpro-live-progress-label]');
        var statusNode = panel.querySelector('[data-betpro-live-status]');
        var clockNode = panel.querySelector('[data-betpro-live-clock]');
        var statuses = [
            'One BetPro order cleared checks and moved to delivery 4 minutes ago.',
            'Support wrapped up a verified account handover for a returning customer.',
            'A fresh WhatsApp order just entered the verification queue.',
            'Another completed account was released to the delivery desk.'
        ];
        var statusIndex = -1;
        var currentValues = numberNodes.map(function (node) {
            var initial = parseInt(node.textContent || node.getAttribute('data-base') || '0', 10);
            return Number.isNaN(initial) ? 0 : initial;
        });

        function randomBetween(min, max) {
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }

        function clamp(value, min, max) {
            return Math.max(min, Math.min(max, value));
        }

        function setClockLabel() {
            if (! clockNode) {
                return;
            }

            clockNode.textContent = 'Updated just now';
        }

        function refreshCounters() {
            var soldToday = 0;
            var deliveredToday = 0;

            numberNodes.forEach(function (node, index) {
                var min = parseInt(node.getAttribute('data-min') || '0', 10);
                var max = parseInt(node.getAttribute('data-max') || '0', 10);
                var nextValue = currentValues[index] || min;

                if (index === 0) {
                    nextValue = clamp(nextValue + randomBetween(0, 1), min, max);
                    soldToday = nextValue;
                } else if (index === 1 || index === 2) {
                    nextValue = clamp(nextValue + randomBetween(-1, 1), min, max);
                } else {
                    nextValue = clamp(soldToday - randomBetween(1, 3), min, max);
                    deliveredToday = nextValue;
                }

                currentValues[index] = nextValue;
                node.textContent = String(nextValue);
            });

            if (progressNode && progressLabelNode) {
                var percent = Math.max(52, Math.min(97, Math.round((deliveredToday / 24) * 100)));
                progressNode.style.width = percent + '%';
                progressLabelNode.textContent = deliveredToday + ' of 24 delivered';
            }

            if (statusNode) {
                statusIndex = (statusIndex + 1) % statuses.length;
                statusNode.textContent = statuses[statusIndex];
            }

            setClockLabel();
        }

        refreshCounters();
        window.setInterval(refreshCounters, 5200);
    }

    function handleContactSubmit(event) {
        var form = event.target;

        if (! form || ! form.classList || ! form.classList.contains('betpro-contact-form')) {
            return;
        }

        event.preventDefault();

        var message = form.querySelector('.betpro-contact-form__message');
        var button = form.querySelector('button[type="submit"]');

        if (message) {
            message.textContent = (config.messages && config.messages.sending) || 'Sending...';
        }

        if (button) {
            button.disabled = true;
        }

        var data = new FormData(form);
        data.append('action', 'betpro_contact');
        data.append('nonce', config.contactNonce || '');

        fetch(config.ajaxUrl || '/wp-admin/admin-ajax.php', {
            method: 'POST',
            credentials: 'same-origin',
            body: data
        })
            .then(function (response) {
                return response.json();
            })
            .then(function (payload) {
                var text = payload && payload.data && payload.data.message
                    ? payload.data.message
                    : ((config.messages && config.messages.error) || 'Unable to send.');

                if (message) {
                    message.textContent = text;
                }

                if (payload && payload.success) {
                    form.reset();
                }
            })
            .catch(function () {
                if (message) {
                    message.textContent = (config.messages && config.messages.error) || 'Unable to send.';
                }
            })
            .finally(function () {
                if (button) {
                    button.disabled = false;
                }
            });
    }

    document.addEventListener('submit', handleContactSubmit);

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function () {
            initReveal();
            initMenu();
            initProofToast();
            initLiveSalesCounter();
        });
    } else {
        initReveal();
        initMenu();
        initProofToast();
        initLiveSalesCounter();
    }
})();
JS;
}

function betpro_account_asset_version(string $asset_file, string $fallback = ''): string
{
    static $app_css_mtime = null;
    static $theme_css_mtime = null;

    $theme_version = $fallback !== '' ? $fallback : betpro_account_theme_version();

    if ($asset_file === 'style.css' || str_starts_with($asset_file, 'assets/css/')) {
        $asset_path = get_stylesheet_directory() . '/' . ltrim($asset_file, '/');
    } else {
        $asset_path = betpro_account_asset_dir() . '/' . ltrim($asset_file, '/');
    }

    $mtime = is_file($asset_path) ? (int) filemtime($asset_path) : 0;

    if (str_ends_with($asset_file, '.css')) {
        if ($theme_css_mtime === null) {
            $theme_css_mtime = 0;

            foreach (betpro_account_theme_css_files() as $theme_css_file) {
                $theme_css_path = get_template_directory() . '/' . ltrim($theme_css_file, '/');

                if (is_file($theme_css_path)) {
                    $theme_css_mtime = max($theme_css_mtime, (int) filemtime($theme_css_path));
                }
            }
        }

        if ($app_css_mtime === null) {
            $app_css_mtime = 0;
            $part_files = glob(betpro_account_asset_dir() . '/assets/style-parts/*.css');

            if (is_array($part_files)) {
                foreach ($part_files as $part_file) {
                    if (is_file($part_file)) {
                        $app_css_mtime = max($app_css_mtime, (int) filemtime($part_file));
                    }
                }
            }
        }

        $mtime = max($mtime, $theme_css_mtime, $app_css_mtime);
    }

    return $mtime > 0 ? $theme_version . '-' . $mtime : $theme_version;
}
