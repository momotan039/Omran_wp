# Al-Omran Industries WordPress Theme

WordPress theme converted from React application for Al-Omran Industries.

## Features
- Responsive design with RTL support
- Custom Post Types: Products, News, Testimonials, FAQ
- Advanced Custom Fields (ACF) integration
- Redux Framework for dynamic sections
- Tailwind CSS (production build)
- Interactive elements: mobile menu, FAQ accordion, AJAX contact form
- SEO optimized with schema markup

## Installation
1. Upload theme to `/wp-content/themes/`
2. Activate theme
3. Install required plugins: ACF, Redux Framework
4. Set permalinks to "Post name"
5. Create pages: About, Contact, FAQ
6. Configure navigation menu

## Custom Post Types

**Products**
- Archive: `/products/`
- ACF Fields: Short Description, Price, Category, Features, Specifications, Is Featured

**News**
- Archive: `/news/`
- ACF Fields: Summary

**Testimonials**
- ACF Fields: Role, Company, Content

**FAQ**
- Uses title (question) and content (answer)

## Redux Framework - Dynamic Sections
Access via **إعدادات الموقع** (Site Settings) in admin:
- Hero, Risks, Sectors, Products, Stainless Steel, Testimonials sections
- Enable/disable, reorder, edit content without code

## Navigation Menu
- Appearance → Menus
- Add CSS class `menu-cta` for CTA button styling
- Assign to "Primary Menu" location

## Chat Widget
Basic implementation included. Requires API integration for full AI functionality.

## Styling
- Tailwind CSS (production build)
- Custom CSS: `assets/css/custom.css`
- Colors: Primary (#047857), Secondary (#10b981)
- Font: Cairo (Google Fonts)

## Requirements
- PHP 7.4+, WordPress 5.0+, MySQL 5.6+

## Support
Email: info@alomran-eg.com

**License**: GNU GPL v2 or later


