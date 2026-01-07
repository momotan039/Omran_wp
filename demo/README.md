# Industrial Preset Demo Import System

This directory contains the complete demo import system for the Industrial preset. The system is fully programmatic and generates all content from within the theme itself.

## File Structure

```
presets/industrial/demo/
├── content.php          # Programmatically creates all content (CPTs, pages, taxonomies, menus)
├── redux.php            # Redux settings for Industrial preset
├── media/               # Placeholder images/videos (optional)
│   ├── README.md        # Instructions for media files
│   └── .gitkeep         # Ensures directory is tracked
├── content.json         # Legacy JSON file (backward compatibility)
├── menus.json           # Legacy menus file (backward compatibility)
└── redux-settings.json  # Legacy Redux settings (backward compatibility)
```

## How It Works

### 1. Content Generation (`content.php`)

The `content.php` file contains functions that programmatically create all demo content:

- **Pages**: About Us, Contact, FAQ, Privacy Policy, Terms
- **Product Categories**: Drainage Systems, Water Treatment, Grease Traps, Accessories
- **Products**: 4 sample products with Arabic content
- **News Categories**: Company News, Product Launches, Projects
- **News Posts**: 3 sample news items
- **Testimonials**: 3 customer testimonials
- **FAQs**: 5 frequently asked questions
- **Menus**: Primary menu and Footer menu

All content is in Arabic and RTL-ready.

### 2. Redux Settings (`redux.php`)

The `redux.php` file contains:
- `omran_demo_get_redux_settings()` - Returns Redux settings array
- `omran_demo_apply_redux_settings()` - Applies settings to WordPress

Settings include:
- Theme preset selection
- Colors (primary, secondary, accent)
- Typography (font family, weight)
- Header/Footer styles
- Hero section settings
- Stats section
- Products, Sectors, Testimonials sections
- And more...

### 3. Media Import

Media files should be placed in the `media/` folder. Supported formats:
- Images: JPG, JPEG, PNG, GIF, SVG, WEBP
- Documents: PDF

The system automatically:
- Imports all media files to WordPress Media Library
- Skips files that are already imported
- Handles errors gracefully

## Usage

### For End Users

1. Go to **إعدادات الموقع > استيراد المحتوى التجريبي** in WordPress admin
2. Click the **"استيراد المحتوى التجريبي"** button
3. Wait for the import to complete (progress bar will show status)
4. Review the success message with import statistics

### For Developers

#### Adding New Content

To add new demo content, edit `content.php`:

```php
// Add a new page
$pages[] = array(
    'title' => 'عنوان الصفحة',
    'slug' => 'page-slug',
    'content' => '<p>محتوى الصفحة</p>',
    'excerpt' => 'ملخص الصفحة',
    'template' => 'page-template.php' // optional
);
```

#### Modifying Redux Settings

Edit `redux.php` and update the `omran_demo_get_redux_settings()` function:

```php
return array(
    'theme_preset' => 'industrial',
    'preset_industrial_primary' => '#2c5530',
    // ... more settings
);
```

#### Adding Media Files

1. Place media files in `media/` folder
2. Use descriptive filenames (e.g., `product-1.jpg`, `hero-bg.jpg`)
3. The system will automatically import them

## Adapting for Other Presets

To create a demo import system for a new preset (e.g., Food, Tech):

1. **Create the directory structure:**
   ```
   presets/[preset-name]/demo/
   ├── content.php
   ├── redux.php
   └── media/
   ```

2. **Copy and modify `content.php`:**
   - Update content to match the preset's theme
   - Modify product categories, news categories, etc.
   - Keep the same function names and structure

3. **Copy and modify `redux.php`:**
   - Update settings to match the preset
   - Change preset name from 'industrial' to your preset name
   - Update colors, typography, and other settings

4. **Add media files:**
   - Place relevant images/videos in `media/` folder

5. **The system will automatically detect and use the new preset's demo files**

## Function Reference

### Content Functions

- `omran_demo_generate_content($overwrite)` - Main function to generate all content
- `omran_demo_create_pages($overwrite)` - Creates demo pages
- `omran_demo_create_product_categories($overwrite)` - Creates product categories
- `omran_demo_create_products($overwrite)` - Creates demo products
- `omran_demo_create_news_categories($overwrite)` - Creates news categories
- `omran_demo_create_news($overwrite)` - Creates demo news posts
- `omran_demo_create_testimonials($overwrite)` - Creates testimonials
- `omran_demo_create_faqs($overwrite)` - Creates FAQs
- `omran_demo_create_menus($overwrite)` - Creates navigation menus

### Redux Functions

- `omran_demo_get_redux_settings()` - Returns Redux settings array
- `omran_demo_apply_redux_settings($overwrite)` - Applies Redux settings

## Best Practices

1. **Always use sanitization functions:**
   - `sanitize_text_field()` for text
   - `wp_kses_post()` for HTML content
   - `esc_url_raw()` for URLs
   - `sanitize_key()` for slugs

2. **Check for existing content:**
   - Use `get_page_by_path()` for pages/posts
   - Use `get_term_by()` for taxonomies
   - Respect the `$overwrite` parameter

3. **Handle errors gracefully:**
   - Check for `is_wp_error()` on WordPress functions
   - Collect errors in an array and return them
   - Don't stop the entire import if one item fails

4. **Use WordPress functions:**
   - `wp_insert_post()` for creating posts/pages
   - `wp_insert_term()` for creating taxonomies
   - `wp_set_post_terms()` for assigning terms
   - `wp_update_nav_menu_item()` for menu items

5. **Store created IDs:**
   - Use `update_option()` to store created page/product IDs
   - This helps with menu creation and relationships

## Troubleshooting

### Import Fails

1. Check file permissions on `demo/` folder
2. Ensure PHP has write access to WordPress uploads
3. Check WordPress error logs
4. Verify Redux Framework is installed and active

### Content Not Appearing

1. Clear WordPress cache
2. Check if content was actually created (check database)
3. Verify post types and taxonomies are registered
4. Check for JavaScript errors in browser console

### Media Not Importing

1. Verify media files exist in `media/` folder
2. Check file permissions
3. Ensure WordPress uploads directory is writable
4. Check file sizes (may exceed PHP limits)

## Notes

- The system is backward compatible with JSON files
- If `content.php` exists, it takes precedence over `content.json`
- Same for `redux.php` vs `redux-settings.json`
- Media import is optional - system works without media files
- All content is in Arabic and RTL-ready
- The system handles duplicates gracefully (won't create duplicates unless `$overwrite = true`)

