<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_render_page_hero(string $title = '', string $description = '', string $slug = ''): void
{
    $title = $title !== '' ? $title : get_the_title();
    $description = $description !== '' ? $description : trim((string) get_the_excerpt());
    $slug = $slug !== '' ? $slug : betpro_account_page_slug();
    $details = betpro_account_page_hero_details($slug);
    $image_url = betpro_account_seo_image_url((int) get_the_ID(), $slug);
    $title_parts = betpro_account_page_hero_title_parts($title);
    ?>
    <section class="betpro-page-hero betpro-reveal relative overflow-hidden border-b border-border bg-card py-20 lg:py-24" data-betpro-reveal data-page="<?php echo esc_attr($slug); ?>">
        <div class="absolute inset-0 z-0">
            <img src="<?php echo esc_url($image_url); ?>" alt="" class="h-full w-full object-cover" />
            <div class="betpro-page-hero__overlay absolute inset-0"></div>
        </div>
        <div class="betpro-page-hero__inner relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="betpro-page-hero__copy">
                <p class="betpro-eyebrow mb-4 text-xs font-extrabold uppercase tracking-widest text-primary"><?php echo esc_html((string) $details['eyebrow']); ?></p>
                <h1 class="text-4xl md:text-5xl font-extrabold tracking-tight text-foreground mb-5">
                    <?php echo esc_html($title_parts['before']); ?><?php if ($title_parts['highlight'] !== '') : ?> <span><?php echo esc_html($title_parts['highlight']); ?></span><?php endif; ?>
                </h1>
                <?php if ($description !== '') : ?>
                    <p class="max-w-3xl text-lg leading-8 text-muted-foreground"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

function betpro_account_page_hero_details(string $slug): array
{
    $defaults = array(
        'eyebrow' => __('BetPro Account', 'betpro-account'),
    );

    $pages = array(
        'services' => array('eyebrow' => __('Services', 'betpro-account')),
        'how-it-works' => array('eyebrow' => __('Process', 'betpro-account')),
        'faq' => array('eyebrow' => __('Support', 'betpro-account')),
        'contact' => array('eyebrow' => __('Contact', 'betpro-account')),
        'blog' => array('eyebrow' => __('Guides', 'betpro-account')),
        'terms-of-service' => array('eyebrow' => __('Terms', 'betpro-account')),
        'privacy-policy' => array('eyebrow' => __('Privacy', 'betpro-account')),
    );

    return array_merge($defaults, $pages[$slug] ?? array());
}

function betpro_account_page_hero_title_parts(string $title): array
{
    $title = trim($title);

    if ($title === '') {
        return array('before' => '', 'highlight' => '');
    }

    $words = preg_split('/\s+/', $title);

    if (! is_array($words) || count($words) < 2) {
        return array('before' => $title, 'highlight' => '');
    }

    $highlight = (string) array_pop($words);

    return array(
        'before' => implode(' ', $words),
        'highlight' => $highlight,
    );
}
