<?php

if (! defined('ABSPATH')) {
    exit;
}

get_header();
betpro_account_render_page_hero(__('Page Not Found', 'betpro-account'), __('The page you are looking for does not exist or may have moved.', 'betpro-account'));
?>
<section class="betpro-content-section py-16 bg-background">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="betpro-link-panel betpro-reveal rounded-2xl border border-border bg-card p-8" data-betpro-reveal>
            <h2 class="text-2xl font-extrabold mb-4"><?php esc_html_e('Explore BetPro pages', 'betpro-account'); ?></h2>
            <ul class="grid gap-3 text-muted-foreground sm:grid-cols-2">
                <?php foreach (betpro_account_default_support_links() as $link) : ?>
                    <li><a class="hover:text-primary transition-colors" href="<?php echo esc_url((string) $link['url']); ?>"><?php echo esc_html((string) $link['label']); ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</section>
<?php
get_footer();
