# Redux Framework Integration

This directory contains the Redux Framework configuration for making the theme's front page sections fully dynamic and editable from the WordPress admin panel.

## Structure

```
inc/redux/
├── redux-config.php          # Main Redux initialization
├── redux-helpers.php         # Helper functions for getting options
└── sections/                 # Individual section configurations
    ├── general.php           # General site settings
    ├── hero.php              # Hero section settings
    ├── risks.php             # Risks section settings
    ├── sectors.php           # Sectors section settings
    ├── products.php          # Products section settings
    ├── stainless.php         # Stainless Steel section settings
    ├── testimonials.php      # Testimonials section settings
    └── sections-order.php    # Section ordering control
```

## Installation

1. **Install Redux Framework Plugin**
   - Go to Plugins → Add New
   - Search for "Redux Framework"
   - Install and activate the plugin

2. **Access Theme Options**
   - After activation, go to **إعدادات الموقع** (Site Settings) in WordPress admin menu
   - All sections are now editable from this panel

## Features

### Section Management
- **Enable/Disable Sections**: Toggle any section on/off
- **Reorder Sections**: Drag and drop sections to reorder
- **Edit Content**: Change all text, titles, descriptions
- **Upload Images**: Replace background images and media
- **Dynamic Content**: Add/remove items in repeater fields

### Available Sections

1. **Hero Section** (قسم البطل)
   - Badge text
   - Main title and subtitle
   - Description
   - Button texts and URLs
   - Background image
   - Quality seal toggle

2. **Risks Section** (قسم المخاطر)
   - Section title
   - Risk items (repeater field)

3. **Sectors Section** (قسم القطاعات)
   - Section title and subtitle
   - Sector items (repeater field)

4. **Products Section** (قسم المنتجات)
   - Section title
   - Number of products to display
   - Show/hide "View All" link

5. **Stainless Steel Section** (قسم الاستانلس ستيل)
   - Section title and subtitle
   - Feature items (repeater field)

6. **Testimonials Section** (قسم الشهادات)
   - Section title
   - Number of testimonials to display

## Usage

### Editing Section Content

1. Go to **إعدادات الموقع** → Select section tab
2. Toggle "تفعيل قسم [Name]" to enable/disable
3. Edit text fields, upload images, add/remove items
4. Click "Save Changes"

### Reordering Sections

1. Go to **إعدادات الموقع** → **ترتيب الأقسام**
2. Drag sections from "Enabled" to reorder
3. Move sections to "Disabled" to hide them
4. Click "Save Changes"

## Helper Functions

### `alomran_get_option($option, $default)`
Get a Redux option value.

```php
$title = alomran_get_option('hero_title', 'Default Title');
```

### `alomran_is_section_enabled($section_id)`
Check if a section is enabled.

```php
if (alomran_is_section_enabled('hero')) {
    // Show hero section
}
```

### `alomran_get_section_data($section_id)`
Get all data for a section.

```php
$hero_data = alomran_get_section_data('hero');
```

### `alomran_get_ordered_sections()`
Get sections in their configured order.

```php
$sections = alomran_get_ordered_sections();
```

## Template Files

Section templates are located in:
```
template-parts/sections/
├── section-hero.php
├── section-risks.php
├── section-sectors.php
├── section-products.php
├── section-stainless.php
└── section-testimonials.php
```

Each template automatically checks if the section is enabled and retrieves data from Redux.

## Notes

- All text fields support Arabic
- Image uploads use WordPress media library
- Repeater fields allow unlimited items
- Changes take effect immediately after saving

