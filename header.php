<?php

if (! defined('ABSPATH')) {
    exit;
}

?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="betpro-theme-version" content="<?php echo esc_attr(betpro_account_theme_version()); ?>">
    <script><?php echo betpro_account_theme_bootstrap_script(); ?></script>
    <?php wp_head(); ?>
</head>
<body <?php body_class('betpro-account-theme betpro-native-theme'); ?>>
<?php
if (function_exists('wp_body_open')) {
    wp_body_open();
}

betpro_account_render_site_header();
?>
<main id="primary" class="min-h-screen bg-background text-foreground">
