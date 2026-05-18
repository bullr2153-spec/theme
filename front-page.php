<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();

$home_assets = array(
    'hero_image' => betpro_account_managed_asset_url('images/hero-bg.png'),
    'person_image' => betpro_account_managed_asset_url('images/hero-person.png'),
    'setup_image' => betpro_account_managed_asset_url('images/verified-account.png'),
    'cta_image' => betpro_account_managed_asset_url('images/workspace-flatlay.png'),
);

get_template_part('template-parts/home/hero', null, $home_assets);
get_template_part('template-parts/home/stats-services');
get_template_part('template-parts/home/process-compare', null, $home_assets);
get_template_part('template-parts/home/faq-testimonials');
get_template_part('template-parts/home/blog-cta', null, $home_assets);

get_footer();
