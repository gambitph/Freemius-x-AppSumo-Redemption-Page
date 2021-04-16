# Freemius x AppSumo Redemption Page

A complete redemption page for AppSumo Codes for Freemius.

What this does:
- People can redeem a Freemius license key
- Upon successful redemption, the user will be directed to a thank you page
- The user's email, name and is_marketing_allowed fields are collected
- When an error occurs (e.g. invalid license key) it will be alerted out for simplicity

# Development

1. Download and then run:

```bash
npm install
```

2. Start with:

```bash
npm run start
```

or for the thank you page:

```bash
npm run start:thanks
```

Then visit http://localhost:1234

If you want to test the PHP side of things, build using the instructions below and then place the files in a PHP-enabled web server.

# Customizing

1. Change the PHP constants in `src/verify.php`:

```php
// Freemus Plugin ID.
define( 'FS_PLUGIN_ID', 1748 );
// Freemius API.
define( 'FS_SCOPE', 'developer' );
define( 'FS_DEV_ID', 12345 );
define( 'FS_PUBLIC_KEY', 'YOUR_PUBLIC_KEY' );
define( 'FS_SECRET_KEY', 'YOUR_SECRET_KEY' );
```

2. Customize the contents in `src/index.html` and `src/thank-you.html`

# Building & Deployment

Build using:

```
npm run build
```

Afterwards, upload the **contents** of the `dist/` folder to your site. Then visit your URL and try redeeming one of your existing License Keys.