# Static Theme Map

This file records the structure of `wp-content/themes/static` so the dynamic theme can be built section by section without changing the static theme.

## Source Pages

### `index.html`

Title: `AluPro Alloy Solutions`

Main sections:

- Header / navigation
- Banner
- About section
- Browse section
- Sheets & Plates Aluminium section
- Structural Grade Aluminium section
- Aerospace Grade Aluminium section
- Extrusions & Profiles Aluminium section
- Specialty Range Aluminium section
- Precision / Custom Services section
- New sub footer
- Footer
- Quote modal
- WhatsApp button
- Scroll to top button
- Under maintenance popup

### `aboutus.html`

Title: `Our Story | AluPro Alloy Solutions`

Main sections:

- Header / navigation
- About section
- Company story section, currently commented in static HTML
- Story hero section, currently commented in static HTML
- Values section, currently commented in static HTML
- Industries section, currently commented in static HTML
- Story CTA section, currently commented in static HTML
- Footer
- Quote modal
- WhatsApp button
- Scroll to top button

### `contact.html`

Title: `Contact Us | AluPro Alloy Solutions`

Main sections:

- Header / navigation
- Materials / contact section
- Footer
- Quote modal
- WhatsApp button
- Scroll to top button

### `table-pdf.html`

Title: `5083 Marine Aluminium Plates | AluPro Alloy Solutions`

Main sections:

- Header / navigation
- Product table / PDF section
- Footer
- Quote modal
- WhatsApp button
- Scroll to top button

## Shared Assets

Copied into the dynamic theme:

- `css/style.css`
- `js/all.js`
- `js/tailwindcss.js`
- `fonts/`
- `images/`

Important images:

- `images/logo-white.svg`
- `images/logo-colored.svg`
- `images/favicon.png`
- `images/banner-img-1.webp`
- `images/marine-img-*.jpeg`
- `images/structural-img-*.jpeg`
- `images/aerospace-img-*.jpeg`
- `images/extrusions-img-*.jpeg`
- `images/special-img-1.*`
- `images/custom-service.webp`
- `images/PDF-Design.pdf`

## Dynamic Theme Build Order

The dynamic theme should follow the static design exactly and convert one area at a time.

1. Theme setup files
2. Header and navigation
3. Homepage banner
4. Homepage about section
5. Product browse section
6. Marine aluminium section
7. Structural aluminium section
8. Aerospace aluminium section
9. Extrusions section
10. Specialty range section
11. Custom services section
12. Footer and quote modal
13. About page template
14. Contact page template
15. Table PDF page template

## Current Dynamic Theme Status

Already created:

- `style.css`
- `functions.php`
- `header.php`
- `footer.php`
- `front-page.php`
- `index.php`
- `template-parts/banner.php`
- `templates/home-static.html`
- `screenshot.png`

Currently dynamic:

- Navigation is included directly in `header.php`.
- Banner file exists as a WordPress template part.
- Banner text, button text, button URL, and background image are editable in the WordPress Customizer.

Temporary static fallback:

- Remaining homepage sections are loaded from `templates/home-static.html` until each section is converted into its own dynamic template part.
