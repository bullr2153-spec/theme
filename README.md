# BetPro Account WordPress Theme

This theme renders BetPro Account as a native WordPress theme. The bundled frontend build is kept for shared compiled assets, but page rendering is handled by PHP templates and WordPress content.

The large image library is intentionally not bundled in the theme zip. Install the companion `BetPro Account Media` plugin and upload the original images there.

## Install

1. Install and activate the `BetPro Account Media` plugin from `wordpress-plugin/betpro-account-media`.
2. Copy `wordpress-theme/betpro-account` into `wp-content/themes/` or upload the theme zip.
3. Activate the `BetPro Account` theme in WordPress.
4. On activation the theme will:
   - create the core pages (`home`, `services`, `pricing`, `how-it-works`, `faq`, `contact`, `blog`, `terms-of-service`, `privacy-policy`)
   - import the bundled blog posts as native WordPress posts
   - assign the primary and footer menus
   - set the `Home` page as the static front page
5. Go to `Settings -> BetPro Media` and assign the original image files from the media library.
6. Visit `Settings -> Permalinks` once if your host caches rewrite rules aggressively.
7. Update the WordPress `Settings -> General` BetPro fields for your real WhatsApp, Telegram, and email values.

## Runtime Content Model

- WordPress Pages and Posts are the source of truth after activation.
- Default install content lives in PHP theme files, not JSON seed files.
- Native templates render the site through `front-page.php`, `page.php`, `single.php`, `home.php`, `archive.php`, and `404.php`.
- Legacy generated page blobs are detected for services/process pages so the native templates can replace them without overwriting admin-edited content.
- Content release code must not silently rewrite existing pages during normal requests.

## Rebuild Theme Assets

Run this from the repository root:

```bash
pnpm --filter @workspace/betpro-website run build:wordpress
```

The build output is written into `wordpress-theme/betpro-account/assets/app`. The build strips `/images` from the theme package so those files stay managed by the plugin instead of the theme zip.

The content seed files are written into `wordpress-theme/betpro-account/inc`.
