# Al-Omran Industries WordPress Theme

A fully functional WordPress theme converted from a React application. This theme is designed for Al-Omran Industries, a company specializing in stainless steel drainage systems, grease traps, and water treatment solutions.

## Features

- **Responsive Design**: Fully responsive layout with mobile-first approach
- **RTL Support**: Right-to-left text support for Arabic content
- **Custom Post Types**: Products, News, Testimonials, and FAQ
- **Advanced Custom Fields (ACF)**: Integrated ACF fields for custom content
- **Tailwind CSS**: Modern utility-first CSS framework (production build)
- **Interactive Elements**: Mobile menu, FAQ accordion, contact form with AJAX
- **Chat Widget**: AI-powered chat widget (requires API integration)
- **SEO Optimized**: Proper WordPress SEO functions and meta tags

## Installation

1. **Upload Theme**
   - Upload the `alomran-theme` folder to `/wp-content/themes/` directory
   - Or zip the theme folder and upload via WordPress admin: Appearance → Themes → Add New → Upload Theme

2. **Activate Theme**
   - Go to Appearance → Themes
   - Activate "Al-Omran Industries"

3. **Install Required Plugins**
   - **Advanced Custom Fields (ACF)** - Required for custom fields
     - Install from Plugins → Add New
     - Search for "Advanced Custom Fields"
     - Install and activate

4. **Set Permalinks**
   - Go to Settings → Permalinks
   - Select "Post name" structure
   - Click "Save Changes"

5. **Create Pages**
   - Create the following pages (Pages → Add New):
     - **About** (use "About Page" template)
     - **Contact** (use "Contact Page" template)
     - **FAQ** (use "FAQ Page" template)
   - Set a static front page (Settings → Reading → A static page → Select "Home")

6. **Configure Navigation Menu**
   - Go to Appearance → Menus
   - Create a new menu or edit existing menu
   - Add pages, posts, custom links, or categories to the menu
   - Assign the menu to "Primary Menu" location
   - **Tip**: To create a CTA button, add a menu item and in "CSS Classes" field, add: `menu-cta`
   - Click "Save Menu"

6. **Import Sample Data** (Optional)
   - You can create sample products, news items, testimonials, and FAQs manually
   - Or use a plugin like "WordPress Importer" to import from XML/JSON

## Theme Structure

```
alomran-theme/
├── style.css                 # Theme stylesheet with theme info
├── functions.php             # Theme functions and setup
├── header.php                # Header template
├── footer.php                # Footer template
├── index.php                 # Main template (fallback)
├── front-page.php            # Home page template
├── page.php                  # Default page template
├── page-about.php            # About page template
├── page-contact.php          # Contact page template
├── page-faq.php              # FAQ page template
├── single.php                # Single post template
├── single-product.php        # Single product template
├── archive.php               # Archive template (fallback)
├── archive-product.php       # Products archive
├── archive-news.php          # News archive
├── 404.php                   # 404 error page
├── template-parts/           # Reusable template parts
│   └── product-card.php      # Product card component
└── assets/                   # Theme assets
    ├── css/
    │   └── custom.css        # Custom CSS styles
    └── js/
        ├── main.js           # Main JavaScript
        └── chat-widget.js    # Chat widget JavaScript
```

## Custom Post Types

### Products
- **Archive URL**: `/products/`
- **Single URL**: `/products/{product-slug}/`
- **ACF Fields**:
  - Short Description
  - Price
  - Product Category (DRAIN_GRILLS, GREASE_TRAPS, WATER_TREATMENT)
  - Features (repeater)
  - Specifications (repeater)
  - Is Featured (true/false)

### News
- **Archive URL**: `/news/`
- **Single URL**: `/news/{news-slug}/`
- **ACF Fields**:
  - Summary

### Testimonials
- **ACF Fields**:
  - Role
  - Company
  - Content

### FAQ
- **ACF Fields**: None (uses title for question, content for answer)

## Navigation Menu Setup

The theme uses WordPress's built-in menu system for easy management:

1. **Access Menu Editor**
   - Go to **Appearance → Menus** in WordPress admin
   - Create a new menu or edit an existing one

2. **Add Menu Items**
   - Add pages, posts, custom links, or categories
   - Drag and drop to reorder items
   - Create submenus by indenting items

3. **Create CTA Button**
   - Add a menu item (usually "Contact" or "Request Quote")
   - Click to expand the menu item
   - In the **CSS Classes** field, add: `menu-cta`
   - This will style the item as a button with special styling

4. **Assign Menu Location**
   - Check "Primary Menu" to display in header
   - Check "Footer Menu" to display in footer (if implemented)
   - Click "Save Menu"

5. **Menu Features**
   - Supports Arabic page titles
   - Automatic active state highlighting
   - Responsive mobile menu
   - Custom styling for CTA buttons

**Note**: If no menu is assigned, the theme will display a fallback menu with default links.

## Custom Fields Setup

The theme includes ACF field definitions in `functions.php`. However, for better management:

1. Install ACF plugin
2. The fields will be automatically registered
3. You can also export/import ACF fields as JSON
4. Create an `acf-json` folder in the theme directory for automatic sync

## Company Information

Company info can be customized via:

1. **WordPress Customizer** (Theme Customization API)
2. **Direct edit in functions.php**: Modify `alomran_get_company_info()` function
3. **Theme Options Plugin**: Install a theme options plugin for easier management

Default company info fields:
- Company Name
- Slogan
- Vision
- Mission
- Phone
- Email
- Address

## Chat Widget Configuration

The chat widget is included but requires API integration for full AI functionality:

1. **Current Implementation**: Basic keyword-based responses
2. **To Integrate AI**:
   - Edit `alomran_handle_chat_message()` in `functions.php`
   - Add your AI API key (Google Gemini, OpenAI, etc.)
   - Implement API call in the function

Example integration:
```php
// In functions.php, modify alomran_handle_chat_message()
$api_key = get_option('alomran_ai_api_key');
$ai_response = alomran_call_ai_api($message, $api_key);
```

## Styling

- **Tailwind CSS**: Loaded via CDN (can be self-hosted for production)
- **Custom CSS**: Located in `assets/css/custom.css`
- **Colors**: Primary (#047857), Secondary (#10b981)
- **Font**: Cairo (Google Fonts)

## JavaScript Features

- Mobile menu toggle
- FAQ accordion
- Contact form AJAX submission
- Chat widget
- Smooth scroll
- Scroll animations (Intersection Observer)

## Browser Support

- Modern browsers (Chrome, Firefox, Safari, Edge)
- IE11+ (with polyfills)

## Development

### Requirements
- PHP 7.4+
- WordPress 5.0+
- MySQL 5.6+

### Local Development
1. Set up local WordPress installation
2. Install theme in themes directory
3. Install required plugins
4. Activate theme
5. Create sample content

## Support

For issues or questions:
- Email: info@alomran-eg.com
- Developer: mohamad-taha.com

## Credits

- **Theme Developer**: Al-Omran Development Team
- **Design**: Converted from React application
- **Framework**: WordPress, Tailwind CSS
- **Icons**: Lucide Icons (converted to SVG)

## License

GNU General Public License v2 or later

## Changelog

### Version 1.0.0
- Initial release
- Full theme conversion from React
- All features implemented
- Custom post types registered
- ACF integration
- Responsive design
- RTL support

