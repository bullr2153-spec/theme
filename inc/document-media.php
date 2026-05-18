<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_theme_bootstrap_script(): string
{
    return "(function(){try{var themeKey='betpro-theme-v6';var storedTheme=window.localStorage.getItem(themeKey);var theme=(storedTheme==='dark'||storedTheme==='light')?storedTheme:'light';var root=document.documentElement;root.classList.remove('light','dark');root.classList.add(theme);root.style.colorScheme=theme;root.lang='en';root.dir='ltr';root.classList.remove('locale-ur');}catch(error){var root=document.documentElement;root.classList.add('light');root.style.colorScheme='light';root.lang='en';root.dir='ltr';root.classList.remove('locale-ur');}})();";
}

function betpro_account_loader_styles(): string
{
    return <<<CSS
#betpro-shell-loader{position:fixed;inset:0;z-index:99999;display:flex;align-items:center;justify-content:center;padding:clamp(20px,4vw,36px);background:
radial-gradient(circle at 14% 18%,rgba(250,204,21,.26),transparent 30%),
radial-gradient(circle at 82% 16%,rgba(34,197,94,.14),transparent 24%),
radial-gradient(circle at 50% 100%,rgba(15,23,42,.06),transparent 36%),
linear-gradient(180deg,#fffdf6 0%,#fffaf1 48%,#f4f7f2 100%);transition:opacity .34s ease,visibility .34s ease;color-scheme:light}
#betpro-shell-loader::before{content:"";position:absolute;inset:18px;border-radius:36px;background:linear-gradient(180deg,rgba(255,255,255,.58),rgba(255,255,255,.14));filter:blur(26px);opacity:.85;pointer-events:none}
#betpro-shell-loader.is-hidden{opacity:0;visibility:hidden;pointer-events:none}
#betpro-shell-loader .betpro-loader-card{position:relative;display:flex;flex-direction:column;align-items:center;gap:14px;min-width:min(92vw,460px);padding:34px 30px 28px;border-radius:32px;border:1px solid rgba(15,23,42,.08);background:linear-gradient(180deg,rgba(255,255,255,.9),rgba(255,255,255,.78));box-shadow:0 28px 80px rgba(15,23,42,.14),inset 0 1px 0 rgba(255,255,255,.72);backdrop-filter:blur(18px);overflow:hidden}
#betpro-shell-loader .betpro-loader-card::before{content:"";position:absolute;top:0;left:0;right:0;height:5px;background:linear-gradient(90deg,#facc15 0%,#f59e0b 35%,#22c55e 100%)}
#betpro-shell-loader .betpro-loader-mark{position:relative;width:104px;height:104px;display:grid;place-items:center;margin-bottom:4px}
#betpro-shell-loader .betpro-loader-ring{position:absolute;border-radius:999px;pointer-events:none}
#betpro-shell-loader .betpro-loader-ring--outer{inset:0;border:1.5px solid rgba(202,138,4,.18);animation:betpro-orbit 9s linear infinite}
#betpro-shell-loader .betpro-loader-ring--inner{inset:11px;border:1.5px dashed rgba(34,197,94,.24);animation:betpro-orbit-reverse 7s linear infinite}
#betpro-shell-loader .betpro-loader-core{position:relative;display:flex;align-items:center;justify-content:center;width:62px;height:62px;border-radius:20px;background:linear-gradient(145deg,#fff7bf 0%,#facc15 52%,#f59e0b 100%);box-shadow:0 18px 34px rgba(245,158,11,.28);font:900 1.15rem/1 system-ui,sans-serif;letter-spacing:.08em;color:#5b3a00;text-transform:uppercase}
#betpro-shell-loader .betpro-loader-core::after{content:"";position:absolute;inset:8px;border-radius:14px;border:1px solid rgba(255,255,255,.55)}
#betpro-shell-loader .betpro-loader-eyebrow{display:inline-flex;align-items:center;gap:8px;padding:7px 12px;border-radius:999px;background:rgba(250,204,21,.16);border:1px solid rgba(250,204,21,.3);font:700 .73rem/1 system-ui,sans-serif;letter-spacing:.16em;text-transform:uppercase;color:#8a5b00}
#betpro-shell-loader .betpro-loader-eyebrow::before{content:"";width:8px;height:8px;border-radius:999px;background:#22c55e;box-shadow:0 0 0 6px rgba(34,197,94,.12)}
#betpro-shell-loader .betpro-loader-title{font:900 clamp(1.45rem,2vw,1.72rem)/1.05 system-ui,sans-serif;letter-spacing:.02em;color:#0f172a;text-align:center}
#betpro-shell-loader .betpro-loader-text{margin:0;max-width:330px;font:500 .97rem/1.7 system-ui,sans-serif;color:rgba(15,23,42,.68);text-align:center}
#betpro-shell-loader .betpro-loader-pills{display:flex;flex-wrap:wrap;justify-content:center;gap:10px;margin-top:2px}
#betpro-shell-loader .betpro-loader-pill{padding:9px 12px;border-radius:999px;border:1px solid rgba(15,23,42,.08);background:rgba(255,255,255,.7);font:700 .78rem/1 system-ui,sans-serif;letter-spacing:.04em;color:#334155}
#betpro-shell-loader .betpro-loader-progress{position:relative;width:min(100%,280px);height:8px;border-radius:999px;background:rgba(15,23,42,.08);overflow:hidden;margin-top:6px}
#betpro-shell-loader .betpro-loader-progress span{position:absolute;inset:0 auto 0 -35%;width:35%;border-radius:inherit;background:linear-gradient(90deg,rgba(250,204,21,0),#facc15 30%,#22c55e 100%);animation:betpro-progress 1.35s ease-in-out infinite}
html.betpro-shell-loading,html.betpro-shell-loading body{overflow:hidden}
@media (max-width:640px){#betpro-shell-loader .betpro-loader-card{padding:28px 20px 24px;border-radius:26px}#betpro-shell-loader .betpro-loader-mark{width:92px;height:92px}#betpro-shell-loader .betpro-loader-core{width:56px;height:56px;font-size:1.02rem}#betpro-shell-loader .betpro-loader-eyebrow{font-size:.68rem;letter-spacing:.14em}#betpro-shell-loader .betpro-loader-title{font-size:1.34rem}#betpro-shell-loader .betpro-loader-text{font-size:.9rem}}
@keyframes betpro-orbit{to{transform:rotate(360deg)}}
@keyframes betpro-orbit-reverse{to{transform:rotate(-360deg)}}
@keyframes betpro-progress{0%{transform:translateX(0)}100%{transform:translateX(390%)}}
CSS;
}

function betpro_account_loader_bootstrap_script(): string
{
    return "(function(){var root=document.documentElement;root.classList.add('betpro-shell-loading');var hidden=false;var hide=function(){if(hidden){return;}hidden=true;root.classList.remove('betpro-shell-loading');var loader=document.getElementById('betpro-shell-loader');if(!loader){return;}loader.classList.add('is-hidden');window.setTimeout(function(){if(loader&&loader.parentNode){loader.parentNode.removeChild(loader);}},320);};window.addEventListener('load',hide,{once:true});window.setTimeout(hide,10000);})();";
}

function betpro_account_normalize_title_text(string $value): string
{
    $normalized = preg_replace('/\bAcoount\b/i', 'Account', $value);

    return is_string($normalized) ? $normalized : $value;
}

function betpro_account_site_name(): string
{
    $site_name = trim(betpro_account_normalize_title_text((string) get_bloginfo('name')));

    return $site_name !== '' ? $site_name : 'BetPro Account';
}

function betpro_account_fix_site_title_typo(): void
{
    $blogname = get_option('blogname', '');

    if (! is_string($blogname) || $blogname === '') {
        return;
    }

    $normalized = betpro_account_normalize_title_text($blogname);

    if ($normalized !== $blogname) {
        update_option('blogname', $normalized);
    }
}
add_action('init', 'betpro_account_fix_site_title_typo', 6);

function betpro_account_filter_document_title(string $title): string
{
    if (betpro_account_rank_math_active() || ! (is_front_page() || is_home())) {
        return $title;
    }

    return sprintf(
        '%s | %s',
        betpro_account_site_name(),
        __('Verified Betting Accounts', 'betpro-account')
    );
}
add_filter('pre_get_document_title', 'betpro_account_filter_document_title');

function betpro_account_filter_document_title_parts(array $parts): array
{
    if (betpro_account_rank_math_active()) {
        return $parts;
    }

    foreach ($parts as $key => $value) {
        if (is_string($value)) {
            $parts[$key] = betpro_account_normalize_title_text($value);
        }
    }

    if (! empty($parts['site']) && is_string($parts['site'])) {
        $parts['site'] = betpro_account_site_name();
    }

    return $parts;
}
add_filter('document_title_parts', 'betpro_account_filter_document_title_parts');

function betpro_account_allow_svg_uploads(array $mimes): array
{
    if (! current_user_can('manage_options')) {
        return $mimes;
    }

    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';

    return $mimes;
}
add_filter('upload_mimes', 'betpro_account_allow_svg_uploads');

function betpro_account_disable_big_image_scaling($threshold)
{
    return false;
}
add_filter('big_image_size_threshold', 'betpro_account_disable_big_image_scaling');

function betpro_account_disable_intermediate_image_sizes(array $sizes): array
{
    return array();
}
add_filter('intermediate_image_sizes_advanced', 'betpro_account_disable_intermediate_image_sizes');

function betpro_account_fix_svg_filetype(array $data, string $file, string $filename, array $mimes): array
{
    if (! current_user_can('manage_options')) {
        return $data;
    }

    $extension = strtolower((string) pathinfo($filename, PATHINFO_EXTENSION));

    if (! in_array($extension, array('svg', 'svgz'), true)) {
        return $data;
    }

    $data['ext'] = $extension;
    $data['type'] = 'image/svg+xml';
    $data['proper_filename'] = $filename;

    return $data;
}
add_filter('wp_check_filetype_and_ext', 'betpro_account_fix_svg_filetype', 10, 4);

function betpro_account_skip_svg_metadata(array $metadata, int $attachment_id): array
{
    $mime_type = get_post_mime_type($attachment_id);

    if ($mime_type !== 'image/svg+xml') {
        return $metadata;
    }

    $file = get_attached_file($attachment_id);

    if (! is_string($file) || $file === '' || ! file_exists($file)) {
        return array();
    }

    $svg = file_get_contents($file);

    if (! is_string($svg) || $svg === '') {
        return array();
    }

    $width = 0;
    $height = 0;

    if (preg_match('/viewBox=["\'][^"\']*?(\d+(?:\.\d+)?)\s+(\d+(?:\.\d+)?)["\']/', $svg, $matches) === 1) {
        $width = (int) round((float) $matches[1]);
        $height = (int) round((float) $matches[2]);
    }

    if (($width === 0 || $height === 0) && preg_match('/<svg[^>]*width=["\'](\d+(?:\.\d+)?)(?:px)?["\'][^>]*height=["\'](\d+(?:\.\d+)?)(?:px)?["\']/', $svg, $matches) === 1) {
        $width = (int) round((float) $matches[1]);
        $height = (int) round((float) $matches[2]);
    }

    return array_filter(
        array(
            'width' => $width,
            'height' => $height,
            'file' => wp_basename($file),
        ),
        static function ($value): bool {
            return $value !== 0 && $value !== '';
        }
    );
}
add_filter('wp_generate_attachment_metadata', 'betpro_account_skip_svg_metadata', 10, 2);

function betpro_account_svg_media_styles(): void
{
    if (! current_user_can('manage_options')) {
        return;
    }
    ?>
<style>
    .attachment .thumbnail img[src$=".svg"],
    .attachments .attachment-preview img[src$=".svg"] {
        width: 100%;
        height: auto;
    }
</style>
    <?php
}
add_action('admin_head', 'betpro_account_svg_media_styles');
