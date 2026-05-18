<?php

if (! defined('ABSPATH')) {
    exit;
}
?>

<section class="betpro-faq-section">
    <div class="betpro-home-container">
        <div class="betpro-section-row">
            <div class="betpro-section-heading betpro-reveal" data-betpro-reveal>
                <p class="betpro-eyebrow text-lg"><?php esc_html_e('Common Questions', 'betpro-account'); ?></p>
                <h2><?php esc_html_e('BetPro Account FAQ', 'betpro-account'); ?></h2>
                <p class="text-lg"><?php esc_html_e('Quick answers about BetPro Account, verified betting accounts, PKR payments, and fast support.', 'betpro-account'); ?></p>
            </div>
            <a class="betpro-mini-link" href="<?php echo esc_url(home_url('/faq/')); ?>"><?php esc_html_e('View All FAQs', 'betpro-account'); ?></a>
        </div>
        <div class="betpro-faq-grid">
            <?php foreach (array_slice(betpro_account_faq_items(), 0, 6) as $faq) : ?>
                <details class="betpro-faq-card betpro-reveal" data-betpro-reveal>
                    <summary><?php echo esc_html($faq['question']); ?></summary>
                    <p class="text-lg"><?php echo esc_html($faq['answer']); ?></p>
                </details>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="betpro-testimonials-section py-24 bg-background">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="betpro-section-heading betpro-reveal text-center max-w-3xl mx-auto mb-14" data-betpro-reveal>
            <p class="betpro-eyebrow text-lg"><?php esc_html_e('Testimonials', 'betpro-account'); ?></p>
            <h2 class="text-3xl md:text-4xl font-extrabold mb-4"><?php esc_html_e('Real Clients, Real Results', 'betpro-account'); ?></h2>
            <p class="text-lg text-muted-foreground leading-8"><?php esc_html_e('Real feedback from customers who used our account creation and setup support.', 'betpro-account'); ?></p>
        </div>
        <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <?php
            $testimonials = array(
                array('quote' => __('I had a smooth experience while creating my BetPro account. It was a fast process, and the agent gave me easy instructions. Professionally managed all of it, I could start using my ID without any hassle.', 'betpro-account'), 'name' => __('Ahmed R.', 'betpro-account'), 'location' => __('Lahore', 'betpro-account'), 'headline' => __('Credentials delivered on schedule', 'betpro-account'), 'avatar' => 'testimonial-1.png'),
                array('quote' => __('It was very easy for me to set up a BetPro account. I received step-by-step guidance, and my login credentials were provided as scheduled. The customer service staff were always on point.', 'betpro-account'), 'name' => __('Sarah K.', 'betpro-account'), 'location' => __('Karachi', 'betpro-account'), 'headline' => __('Beginner-friendly signup', 'betpro-account'), 'avatar' => 'testimonial-2.png'),
                array('quote' => __('I was inexperienced with this platform, but the signup process was way too easy. It didn’t take long to create my BetPro ID & I could easily access my account.', 'betpro-account'), 'name' => __('Usman T.', 'betpro-account'), 'location' => __('Islamabad', 'betpro-account'), 'headline' => __('Stress-free account creation', 'betpro-account'), 'avatar' => 'testimonial-3.png'),
                array('quote' => __('Good service and fast account creation. I liked how clearly everything was explained before setting up my BetPro ID. It made the whole process stress-free.', 'betpro-account'), 'name' => __('Ali H.', 'betpro-account'), 'location' => __('Multan', 'betpro-account'), 'headline' => __('Reliable and smooth registration', 'betpro-account'), 'avatar' => 'testimonial-1.png'),
                array('quote' => __('The registration process was smooth and reliable. I received my login details without delay, and the platform works exactly as described. Overall, a good experience.', 'betpro-account'), 'name' => __('Fatima S.', 'betpro-account'), 'location' => __('Pakistan', 'betpro-account'), 'headline' => __('Smooth login delivery', 'betpro-account'), 'avatar' => 'testimonial-2.png'),
            );
            foreach ($testimonials as $testimonial) :
                ?>
                <article class="betpro-reveal flex h-full flex-col rounded-2xl border border-border bg-card p-7 shadow-sm" data-betpro-reveal>
                    <div class="mb-5 flex items-center justify-between gap-4">
                        <span class="betpro-rating-stars text-lg font-bold text-primary" aria-hidden="true">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </span>
                        <span class="rounded-full border border-primary/20 bg-primary/10 px-3 py-1 text-sm font-bold text-primary"><?php esc_html_e('Client Verified', 'betpro-account'); ?></span>
                    </div>
                    <h3 class="text-xl font-extrabold mb-3"><?php echo esc_html($testimonial['headline']); ?></h3>
                    <blockquote class="grow text-lg leading-8 text-muted-foreground">"<?php echo esc_html($testimonial['quote']); ?>"</blockquote>
                    <div class="betpro-testimonial-author">
                        <img src="<?php echo esc_url(betpro_account_managed_asset_url('images/' . $testimonial['avatar'])); ?>" alt="" loading="lazy" />
                        <div><p class="text-lg font-extrabold text-foreground"><?php echo esc_html($testimonial['name']); ?></p><p class="text-lg text-muted-foreground"><?php echo esc_html($testimonial['location']); ?></p></div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
