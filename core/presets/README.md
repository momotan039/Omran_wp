# Theme Presets

This directory is for future theme presets (Food & Beverage, Tech & Devices, etc.).

## Preset Structure

Each preset should follow this structure:

```
presets/
└── {preset-name}/
    ├── functions.php          # Preset-specific functions and hooks
    ├── style.css              # Preset-specific styles
    ├── template-parts/        # Override template parts
    │   └── sections/
    └── assets/
        └── css/
            └── preset.css     # Preset-specific CSS
```

## Creating a Preset

### Method 1: Child Theme (Recommended)

Create a child theme that extends the core:

```php
// child-theme/functions.php
<?php
// Set preset identifier
add_filter('omran_core_theme_preset', function() {
    return 'food-beverage';
});

// Customize section data
add_filter('omran_core_section_data', function($data, $section) {
    if ($section === 'hero') {
        $data['title'] = 'Welcome to Our Food Products';
    }
    return $data;
}, 10, 2);

// Override section template
add_filter('omran_core_section_template', function($template, $section) {
    if ($section === 'hero') {
        return 'template-parts/sections/food-hero';
    }
    return $template;
}, 10, 2);
```

### Method 2: Preset Directory

Create a preset directory and load it via a plugin or mu-plugin:

```php
// wp-content/mu-plugins/preset-loader.php
<?php
require_once get_template_directory() . '/presets/food-beverage/functions.php';
```

## Example: Food & Beverage Preset

```php
// presets/food-beverage/functions.php
<?php
/**
 * Food & Beverage Preset
 * 
 * @package AlOmran_Preset_Food
 */

if (!defined('ABSPATH')) {
    exit;
}

// Set preset
add_filter('omran_core_theme_preset', function() {
    return 'food-beverage';
});

// Customize colors
add_filter('omran_core_body_classes', function($classes, $preset, $header_style, $footer_style) {
    $classes[] = 'preset-food-beverage';
    return $classes;
}, 10, 4);

// Customize products section for food industry
add_filter('omran_core_products_data', function($data) {
    $data['title'] = 'Our Food Products';
    $data['show_ingredients'] = true; // Show ingredients for food products
    return $data;
});

// Override hero template
add_filter('omran_core_hero_template', function($template) {
    return 'template-parts/sections/food-hero';
});
```

## Available Hooks

See `docs/10-CORE-REFACTORING.md` for complete hook documentation.

Key hooks for presets:
- `omran_core_theme_preset` - Set preset identifier
- `omran_core_section_data` - Customize section data
- `omran_core_section_template` - Override section templates
- `omran_core_body_classes` - Add custom body classes
- `omran_core_header_template` - Override header template
- `omran_core_footer_template` - Override footer template

## Preset Assets

Preset-specific CSS should be enqueued in the preset's functions.php:

```php
add_action('wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'preset-food-beverage',
        get_template_directory_uri() . '/presets/food-beverage/assets/css/preset.css',
        array('alomran-tailwind'),
        '1.0.0'
    );
}, 20);
```

## Best Practices

1. **Use hooks, don't modify core** - Always use filters/actions
2. **Keep design separate** - CSS in assets, logic in functions.php
3. **Test backward compatibility** - Ensure core still works
4. **Document customizations** - Comment your preset code
5. **Follow naming conventions** - Use preset-specific prefixes

