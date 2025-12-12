# Core Theme Layer Refactoring

## Overview

The WordPress Industrial Theme has been refactored into a **Core Theme Layer** that serves as the foundation for multiple future presets (Food & Beverage, Tech & Devices). All current functionality is preserved and fully manageable via Redux Options, while design (CSS/Layout) is decoupled from core logic.

## Architecture

### Directory Structure

```
alomran-theme/
├── core/                          # Core Theme Layer
│   ├── classes/                   # Core classes (if needed)
│   ├── functions/                 # Helper functions
│   │   ├── core-setup.php         # Theme setup
│   │   ├── core-constants.php     # Core constants
│   │   ├── compatibility.php      # Backward compatibility layer
│   │   ├── helpers-*.php          # Helper functions
│   │   ├── media-*.php            # Media management
│   │   ├── contact-messages.php   # Contact handling
│   │   ├── ajax-handlers.php      # AJAX handlers
│   │   └── ...
│   ├── post-types/                # Custom Post Types
│   │   └── post-types.php
│   ├── taxonomies/                # Custom Taxonomies
│   │   └── taxonomies.php
│   ├── acf/                       # ACF Field Groups
│   │   └── acf-fields.php
│   ├── redux/                     # Redux Framework
│   │   ├── redux-config.php       # Redux configuration
│   │   ├── redux-helpers.php      # Redux helpers
│   │   ├── options.php            # Option getters
│   │   ├── section-data.php       # Section data retrieval
│   │   ├── parsers.php            # Text parsers
│   │   └── sections/              # Redux section definitions
│   ├── widgets/                   # Core widgets
│   │   ├── widgets-loader.php
│   │   └── *.php
│   ├── seo/                       # SEO functionality
│   │   ├── seo-core.php
│   │   ├── seo-schema.php
│   │   └── seo-sitemap.php
│   ├── hooks/                     # Hooks and filters system
│   │   ├── hooks-core.php         # Core hooks
│   │   ├── hooks-sections.php     # Section hooks
│   │   └── hooks-template-parts.php
│   ├── assets/                    # Core assets
│   │   └── css/
│   │       └── presets/           # Preset-specific styles
│   └── core-loader.php            # Core bootstrap
├── template-parts/                # Template parts (design/layout)
├── inc/                           # Legacy files (for backward compatibility)
└── functions.php                  # Main loader
```

## Core Principles

### 1. Design Separation

- **Core Logic**: All business logic, CPTs, taxonomies, ACF fields, and Redux configuration live in `/core`
- **Design/Layout**: Template parts, CSS, colors, typography are separate and can be overridden by presets
- **No Hardcoded Design**: Core functions return data, not HTML/CSS

### 2. Hooks and Filters

All core functionality exposes hooks and filters for preset customization:

```php
// Example: Filter section data
add_filter('omran_core_section_data', function($data, $section) {
    if ($section === 'hero') {
        $data['title'] = 'Custom Title';
    }
    return $data;
}, 10, 2);

// Example: Override section template
add_filter('omran_core_section_template', function($template, $section) {
    if ($section === 'hero') {
        return 'template-parts/sections/custom-hero';
    }
    return $template;
}, 10, 2);
```

### 3. Namespacing

All core functions use the `omran_core_` prefix:
- `omran_core_get_option()` - Get Redux option
- `omran_core_get_section_data()` - Get section data
- `omran_core_is_section_enabled()` - Check if section is enabled
- `omran_core_get_ordered_sections()` - Get ordered sections

### 4. Backward Compatibility

A compatibility layer (`core/functions/compatibility.php`) maps old function names to new ones:
- `alomran_get_option()` → `omran_core_get_option()`
- `alomran_get_section_data()` → `omran_core_get_section_data()`
- etc.

## Available Hooks

### Core Hooks

- `omran_core_init` - Fires when core is initialized
- `omran_core_post_types_registered` - After post types are registered
- `omran_core_taxonomies_registered` - After taxonomies are registered
- `omran_core_widgets_loaded` - After widgets are loaded

### Section Hooks

- `omran_core_ordered_sections` - Filter ordered sections
- `omran_core_section_enabled` - Filter section enabled status
- `omran_core_section_data` - Filter section data
- `omran_core_section_data_pre` - Filter section data before core processing
- `omran_core_section_template` - Filter section template path
- `omran_core_before_section` - Action before section output
- `omran_core_after_section` - Action after section output
- `omran_core_section_wrapper_classes` - Filter section wrapper classes

### Template Part Hooks

- `omran_core_header_template` - Filter header template
- `omran_core_footer_template` - Filter footer template
- `omran_core_header_classes` - Filter header classes
- `omran_core_footer_classes` - Filter footer classes
- `omran_core_before_header` - Action before header
- `omran_core_after_header` - Action after header
- `omran_core_before_footer` - Action before footer
- `omran_core_after_footer` - Action after footer

### Post Type Hooks

- `omran_core_product_post_type_args` - Filter product CPT args
- `omran_core_news_post_type_args` - Filter news CPT args
- `omran_core_testimonial_post_type_args` - Filter testimonial CPT args
- `omran_core_faq_post_type_args` - Filter FAQ CPT args

### Taxonomy Hooks

- `omran_core_taxonomy_labels` - Filter taxonomy labels
- `omran_core_taxonomy_args` - Filter taxonomy arguments
- `omran_core_single_taxonomy_args` - Filter single taxonomy args

## Creating a Theme Preset

### Step 1: Create Preset Directory

Create a directory for your preset (e.g., `presets/food-beverage/` or use child theme).

### Step 2: Override Templates

Create template parts that override core templates:

```php
// presets/food-beverage/template-parts/sections/section-hero.php
<?php
// Use hooks to get data
$data = omran_core_get_section_data('hero');
?>
<div class="food-hero">
    <!-- Custom design for Food & Beverage -->
</div>
```

### Step 3: Add Preset Styles

Create preset-specific CSS:

```css
/* presets/food-beverage/assets/css/preset.css */
.preset-food-beverage {
    /* Food & Beverage specific styles */
}
```

### Step 4: Hook into Core

Use filters to customize core behavior:

```php
// presets/food-beverage/functions.php
add_filter('omran_core_theme_preset', function() {
    return 'food-beverage';
});

add_filter('omran_core_section_data', function($data, $section) {
    if ($section === 'products') {
        // Customize products section for food industry
        $data['title'] = 'Our Food Products';
    }
    return $data;
}, 10, 2);
```

## Redux Configuration

All sections are fully controllable via Redux Options:

- **Section Visibility**: Each section has an `{section}_enable` option
- **Section Order**: Controlled via `sections_order` sorter field
- **Section Content**: All section content is editable via Redux
- **Layout Variations**: Minor layout variations via Redux options

## Migration Guide

### For Existing Code

1. **Templates**: Continue using `alomran_get_option()` - it's mapped to core
2. **Functions**: Old function names still work via compatibility layer
3. **Custom Code**: Gradually migrate to `omran_core_*` functions

### For New Code

1. Always use `omran_core_*` function names
2. Use hooks and filters instead of modifying core files
3. Keep design/layout separate from logic

## Best Practices

1. **Never modify core files directly** - Use hooks and filters
2. **Keep design in template parts** - Don't mix logic and presentation
3. **Use hooks for customization** - Don't copy core files
4. **Test backward compatibility** - Ensure old code still works
5. **Document custom hooks** - If you add new hooks, document them

## Future Presets

The core is designed to support:
- **Food & Beverage Preset**: Custom colors, fonts, and layouts for food industry
- **Tech & Devices Preset**: Modern tech-focused design
- **Custom Presets**: Any industry-specific preset

Each preset can:
- Override CSS/colors/fonts
- Override template parts
- Customize section data via hooks
- Add custom widgets
- Extend Redux options

## Support

For questions or issues:
1. Check hook documentation in `core/hooks/`
2. Review compatibility layer in `core/functions/compatibility.php`
3. Examine existing template parts for examples

