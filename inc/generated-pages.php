<?php

if (! defined('ABSPATH')) {
    exit;
}

function betpro_account_faq_items(): array
{
    $settings = betpro_account_theme_settings();

    return array(
        array(
            'question' => __('How can I get a BetPro account?', 'betpro-account'),
            'answer' => __('Message us on WhatsApp, tell us you need a BetPro account, share your requirements, pay the deposit in PKR, and we complete the setup for you.', 'betpro-account'),
        ),
        array(
            'question' => __('Can you help with another betting account too?', 'betpro-account'),
            'answer' => __('Yes. We also help with other verified betting account requests. Send the platform name and your requirements and we will guide you.', 'betpro-account'),
        ),
        array(
            'question' => __('What details do you need from me?', 'betpro-account'),
            'answer' => __('Usually we need the platform name, the account type you want, and any special requirements. If anything else is required, we guide you step by step.', 'betpro-account'),
        ),
        array(
            'question' => __('How long does delivery take?', 'betpro-account'),
            'answer' => __('Most verified accounts are delivered quickly after confirmation. The exact timing depends on the platform, but we keep the process fast and smooth.', 'betpro-account'),
        ),
        array(
            'question' => __('Do you accept payments in Pakistani Rupees?', 'betpro-account'),
            'answer' => __('Yes. Our pricing and deposits can be handled in PKR, which keeps the payment process easy for local customers.', 'betpro-account'),
        ),
        array(
            'question' => __('Is the service secure and reliable?', 'betpro-account'),
            'answer' => __('Yes. We use a careful process, secure communication, and trusted workflows to deliver verified accounts safely and reliably.', 'betpro-account'),
        ),
        array(
            'question' => __('Can I contact you anytime?', 'betpro-account'),
            'answer' => sprintf(
                __('Yes, our support team is available 24/7 on WhatsApp (%1$s), Telegram (%2$s), and Facebook.', 'betpro-account'),
                $settings['whatsappLabel'],
                $settings['telegramHandle']
            ),
        ),
        array(
            'question' => __('How can I get a verified account?', 'betpro-account'),
            'answer' => __('Simply contact us on WhatsApp, share your requirements, pay the deposit in PKR, and we will handle the full process for you.', 'betpro-account'),
        ),
        array(
            'question' => __('How do I order a verified betting account?', 'betpro-account'),
            'answer' => __('Contact us directly, tell us which platform you need, confirm your requirements, pay the deposit in PKR, and we start the process right away.', 'betpro-account'),
        ),
        array(
            'question' => __('How long does the process take?', 'betpro-account'),
            'answer' => __('Our process is fast and efficient. Most accounts are delivered quickly after confirmation.', 'betpro-account'),
        ),
        array(
            'question' => __('What payment methods do you accept?', 'betpro-account'),
            'answer' => __('We accept PKR payments through bank transfer, Easypaisa, and JazzCash. We share the exact payment details when you place the order.', 'betpro-account'),
        ),
        array(
            'question' => __('What happens after I pay the deposit?', 'betpro-account'),
            'answer' => __('Once the deposit is confirmed, we begin the account process, keep you updated on progress, and deliver the verified account as quickly as possible.', 'betpro-account'),
        ),
        array(
            'question' => __('Can I order through WhatsApp?', 'betpro-account'),
            'answer' => __('Yes. WhatsApp is the fastest way to place an order, ask questions, and get updates on your account delivery.', 'betpro-account'),
        ),
        array(
            'question' => __('Do you provide support after delivery?', 'betpro-account'),
            'answer' => __('Yes. We continue to help after delivery if you need guidance, clarification, or ongoing support.', 'betpro-account'),
        ),
    );
}

function betpro_account_generated_page_content(string $slug): string
{
    $settings = betpro_account_theme_settings();
    $internal_links = array(
        array('label' => __('Services', 'betpro-account'), 'url' => home_url('/services/')),
        array('label' => __('How It Works', 'betpro-account'), 'url' => home_url('/how-it-works/')),
        array('label' => __('FAQ', 'betpro-account'), 'url' => home_url('/faq/')),
        array('label' => __('Contact', 'betpro-account'), 'url' => home_url('/contact/')),
        array('label' => __('Blog', 'betpro-account'), 'url' => home_url('/blog/')),
    );

    ob_start();

    if ($slug === 'faq') {
        $faqs = betpro_account_faq_items();
        ?>
        <p><?php esc_html_e('Read clear answers about BetPro Account, verified betting accounts, PKR payments, delivery timelines, and 24/7 support.', 'betpro-account'); ?></p>
        <h2><?php esc_html_e('Quick Summary', 'betpro-account'); ?></h2>
        <ul>
            <li><?php esc_html_e('Contact us directly on WhatsApp with your BetPro or verified account requirements.', 'betpro-account'); ?></li>
            <li><?php esc_html_e('Pay the deposit in PKR using bank transfer, Easypaisa, or JazzCash.', 'betpro-account'); ?></li>
            <li><?php esc_html_e('We keep delivery fast, communication clear, and support available 24/7.', 'betpro-account'); ?></li>
        </ul>
        <h2><?php esc_html_e('BetPro Account Setup Questions', 'betpro-account'); ?></h2>
        <ul>
            <?php foreach (array_slice($faqs, 0, 5) as $faq) : ?>
                <li><strong><?php echo esc_html($faq['question']); ?></strong> <?php echo esc_html($faq['answer']); ?></li>
            <?php endforeach; ?>
        </ul>
        <h2><?php esc_html_e('Payments and Delivery Questions', 'betpro-account'); ?></h2>
        <ul>
            <?php foreach (array_slice($faqs, 5, 5) as $faq) : ?>
                <li><strong><?php echo esc_html($faq['question']); ?></strong> <?php echo esc_html($faq['answer']); ?></li>
            <?php endforeach; ?>
        </ul>
        <h2><?php esc_html_e('Support and Trust Questions', 'betpro-account'); ?></h2>
        <ul>
            <?php foreach (array_slice($faqs, 10) as $faq) : ?>
                <li><strong><?php echo esc_html($faq['question']); ?></strong> <?php echo esc_html($faq['answer']); ?></li>
            <?php endforeach; ?>
        </ul>
        <h2><?php esc_html_e('Helpful BetPro Pages', 'betpro-account'); ?></h2>
        <p>
            <a href="<?php echo esc_url(home_url('/how-it-works/')); ?>"><?php esc_html_e('How It Works', 'betpro-account'); ?></a>,
            <a href="<?php echo esc_url(home_url('/services/')); ?>"><?php esc_html_e('Services', 'betpro-account'); ?></a>,
            <a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Contact', 'betpro-account'); ?></a>,
            <a href="<?php echo esc_url(home_url('/blog/')); ?>"><?php esc_html_e('Blog', 'betpro-account'); ?></a>.
        </p>
        <h2><?php esc_html_e('Still Need Help?', 'betpro-account'); ?></h2>
        <p>
            <a href="<?php echo esc_url(home_url('/contact/')); ?>"><?php esc_html_e('Open the contact page', 'betpro-account'); ?></a>
            <?php esc_html_e(' or message us directly on ', 'betpro-account'); ?>
            <a href="<?php echo esc_url(betpro_account_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('WhatsApp', 'betpro-account'); ?></a>
            <?php esc_html_e(' or ', 'betpro-account'); ?>
            <a href="<?php echo esc_url(betpro_account_telegram_url()); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Telegram', 'betpro-account'); ?></a>.
        </p>
        <?php
    } elseif ($slug === 'contact') {
        ?>
        <p><?php esc_html_e('Reach our team for verified betting accounts, KYC help, replacements, payment questions, and delivery estimates.', 'betpro-account'); ?></p>
        <h2><?php esc_html_e('Fastest Ways to Reach Us', 'betpro-account'); ?></h2>
        <ul>
            <li><a href="<?php echo esc_url(betpro_account_whatsapp_url()); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($settings['whatsappLabel']); ?></a> - <?php esc_html_e('usually the quickest response channel.', 'betpro-account'); ?></li>
            <li><a href="<?php echo esc_url(betpro_account_telegram_url()); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($settings['telegramHandle']); ?></a> - <?php esc_html_e('ideal for direct platform discussions.', 'betpro-account'); ?></li>
            <li><a href="<?php echo esc_url('mailto:' . $settings['contactEmail']); ?>"><?php echo esc_html($settings['contactEmail']); ?></a> - <?php esc_html_e('best for detailed order requests.', 'betpro-account'); ?></li>
        </ul>
        <h2><?php esc_html_e('What to Include in Your Inquiry', 'betpro-account'); ?></h2>
        <p><?php esc_html_e('Tell us the bookmaker, your requirements, your preferred timeline, and that you want to pay the deposit in PKR.', 'betpro-account'); ?></p>
        <h2><?php esc_html_e('Helpful Pages Before You Message Us', 'betpro-account'); ?></h2>
        <p>
            <?php foreach ($internal_links as $index => $link) : ?>
                <a href="<?php echo esc_url($link['url']); ?>"><?php echo esc_html($link['label']); ?></a><?php echo $index < count($internal_links) - 1 ? ', ' : '.'; ?>
            <?php endforeach; ?>
        </p>
        <?php
    } elseif ($slug === 'blog') {
        $blocked_ids = array();

        $test_by_slug = get_page_by_path('first-testing-post', OBJECT, 'post');
        if ($test_by_slug && $test_by_slug instanceof WP_Post) {
            $blocked_ids[] = $test_by_slug->ID;
        }

        $test_by_title = get_page_by_title('first testing post', OBJECT, 'post');
        if ($test_by_title && $test_by_title instanceof WP_Post) {
            $blocked_ids[] = $test_by_title->ID;
        }

        $posts = get_posts(
            array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'numberposts' => 6,
                'orderby' => 'date',
                'order' => 'DESC',
                'post__not_in' => $blocked_ids,
            )
        );
        ?>
        <p><?php esc_html_e('Read BetPro Account guides on verified betting accounts, bookmaker limits, KYC, payments, and multi-account strategy.', 'betpro-account'); ?></p>
        <h2><?php esc_html_e('Latest Guides', 'betpro-account'); ?></h2>
        <ul>
            <?php foreach ($posts as $post) : ?>
                <li>
                    <a href="<?php echo esc_url(get_permalink($post)); ?>"><?php echo esc_html(get_the_title($post)); ?></a><br />
                    <?php $excerpt = trim((string) get_the_excerpt($post)); ?>
                    <?php if ($excerpt !== '') : ?>
                        &#8211; <?php echo esc_html($excerpt); ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <h2><?php esc_html_e('Explore BetPro Services', 'betpro-account'); ?></h2>
        <p>
            <a href="<?php echo esc_url(home_url('/services/')); ?>"><?php esc_html_e('Services', 'betpro-account'); ?></a>,
            <a href="<?php echo esc_url(home_url('/how-it-works/')); ?>"><?php esc_html_e('How It Works', 'betpro-account'); ?></a>,
            <a href="<?php echo esc_url(home_url('/faq/')); ?>"><?php esc_html_e('FAQ', 'betpro-account'); ?></a>.
        </p>
        <?php
    }

    return trim((string) ob_get_clean());
}
