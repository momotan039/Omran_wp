# Quick Start Guide - Core Theme Layer

## Overview

The WordPress Industrial Theme has been refactored into a **Core Theme Layer** that serves as the foundation for multiple presets. This guide will help you get started quickly.

## File Structure

```
alomran-theme/
├── core/                    # Core Theme Layer (DO NOT MODIFY)
│   ├── core-loader.php      # Main bootstrap
│   ├── functions/           # Helper functions
│   ├── post-types/          # Custom Post Types
│   ├── taxonomies/          # Taxonomies
│   ├── acf/                 # ACF fields
│   ├── redux/               # Redux configuration
│   ├── widgets/             # Widgets
│   ├── seo/                 # SEO functionality
│   ├── hooks/               # Hooks system
│   └── presets/             # Preset examples
├── template-parts/          # Template parts (can be overridden)
├── inc/                     # Legacy files (backward compatibility)
└── functions.php            # Main loader (loads core)
```

## Key Concepts

### 1. Core vs Design Separation

- **Core (`/core`)**: All business logic, CPTs, taxonomies, ACF, Redux
- **Design (`/template-parts`)**: Layout, CSS, visual presentation
- **Never modify core files directly** - Use hooks and filters instead

### 2. Function Names

- **New Core Functions**: `omran_core_*` (e.g., `omran_core_get_option()`)
- **Old Functions**: `alomran_*` (still work via compatibility layer)
- **Recommendation**: Use `omran_core_*` for new code

### 3. Hooks and Filters

All core functionality exposes hooks for customization:

```php
// Filter section data
add_filter('omran_core_section_data', function($data, $section) {
    if ($section === 'hero') {
        $data['title'] = 'Custom Title';
    }
    return $data;
}, 10, 2);

// Override section template
add_filter('omran_core_section_template', function($template, $section) {
    if ($section === 'hero') {
        return 'template-parts/sections/custom-hero';
    }
    return $template;
}, 10, 2);
```

## Common Tasks

### Get a Redux Option

```php
// New way (recommended)
$value = omran_core_get_option('hero_title', 'Default Title');

// Old way (still works)
$value = alomran_get_option('hero_title', 'Default Title');
```

### Get Section Data

```php
$hero_data = omran_core_get_section_data('hero');
// Returns: array with 'enable', 'title', 'subtitle', 'buttons', etc.
```

### Check if Section is Enabled

```php
if (omran_core_is_section_enabled('hero')) {
    // Section is enabled
}
```

### Get Ordered Sections

```php
$sections = omran_core_get_ordered_sections();
// Returns: array('hero' => 'hero', 'products' => 'products', ...)
```

### Customize via Hooks

```php
// In your theme's functions.php or child theme

// Change hero title
add_filter('omran_core_hero_data', function($data) {
    $data['title'] = 'My Custom Title';
    return $data;
});

// Add custom CSS class to body
add_filter('omran_core_body_classes', function($classes) {
    $classes[] = 'my-custom-class';
    return $classes;
});
```

## Creating a Preset

### Step 1: Create Preset File

Create `presets/my-preset/functions.php`:

```php
<?php
// Set preset identifier
add_filter('omran_core_theme_preset', function() {
    return 'my-preset';
});

// Customize sections
add_filter('omran_core_section_data', function($data, $section) {
    // Customize as needed
    return $data;
}, 10, 2);
```

### Step 2: Load Preset

In your theme's `functions.php` or via mu-plugin:

```php
require_once get_template_directory() . '/presets/my-preset/functions.php';
```

See `core/presets/README.md` for complete guide.

## Available Hooks

### Core Hooks
- `omran_core_init` - Fires when core initializes
- `omran_core_post_types_registered` - After CPTs registered
- `omran_core_taxonomies_registered` - After taxonomies registered

### Section Hooks
- `omran_core_section_data` - Filter section data
- `omran_core_section_template` - Override section template
- `omran_core_section_enabled` - Filter section enabled status
- `omran_core_before_section` - Action before section
- `omran_core_after_section` - Action after section

### Template Hooks
- `omran_core_header_template` - Override header template
- `omran_core_footer_template` - Override footer template
- `omran_core_body_classes` - Filter body classes

See `docs/10-CORE-REFACTORING.md` for complete hook list.

## Troubleshooting

### Functions Not Found

If you get "function not found" errors:
1. Ensure `core/core-loader.php` is loaded (via `functions.php`)
2. Check compatibility layer is loaded
3. Verify file paths in `core/core-loader.php`

### Redux Options Not Working

1. Ensure Redux Framework plugin is active
2. Check Redux config loads (admin only)
3. Verify option names match Redux sections

### Sections Not Displaying

1. Check section is enabled: `omran_core_is_section_enabled('section_id')`
2. Verify section in order: `omran_core_get_ordered_sections()`
3. Check template exists: `template-parts/sections/section-{id}.php`

## Best Practices

1. ✅ **Use hooks, don't modify core**
2. ✅ **Use `omran_core_*` functions for new code**
3. ✅ **Keep design separate from logic**
4. ✅ **Test backward compatibility**
5. ✅ **Document customizations**

## Resources

- **Core Refactoring Guide**: `docs/10-CORE-REFACTORING.md`
- **Refactoring Summary**: `docs/11-REFACTORING-SUMMARY.md`
- **Preset Guide**: `core/presets/README.md`
- **Example Preset**: `core/presets/example-food-beverage.php`

## Support

For issues or questions:
1. Check hook documentation
2. Review example preset
3. Check compatibility layer
4. Verify core files are loaded

