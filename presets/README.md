# Theme Presets System

## Overview

The Theme Presets System allows you to create and manage multiple theme variations (Industrial, Food & Beverage, Tech & Devices) without modifying the core theme code. Each preset can have its own colors, typography, layout, templates, and assets.

## Directory Structure

```
presets/
├── industrial/
│   ├── config.php              # Preset configuration
│   ├── functions.php           # Preset-specific functions
│   ├── assets/
│   │   └── css/
│   │       └── preset.css      # Preset-specific styles
│   └── template-parts/         # Optional template overrides
├── food-beverage/
│   ├── config.php
│   ├── functions.php
│   ├── assets/
│   │   └── css/
│   │       └── preset.css
│   └── template-parts/
└── tech-devices/
    ├── config.php
    ├── functions.php
    ├── assets/
    │   └── css/
    │       └── preset.css
    └── template-parts/
```

## Preset Configuration File

Each preset must have a `config.php` file that returns an array with the following structure:

```php
<?php
return array(
    'id'          => 'preset-id',
    'name'        => 'Preset Name',
    'description' => 'Preset description',
    'version'     => '1.0.0',
    
    // Color Palette
    'colors' => array(
        'primary'    => '#color',
        'secondary'  => '#color',
        'accent'     => '#color',
        // ... more colors
    ),
    
    // Typography
    'typography' => array(
        'font_family'     => 'Font Name',
        'font_weight'     => '400',
        'heading_weight'  => '700',
        'body_size'       => '16px',
        'heading_scale'   => 1.25,
    ),
    
    // Layout Settings
    'layout' => array(
        'container_width' => 'standard',
        'content_layout'  => 'boxed',
        'header_style'    => 'default',
        'footer_style'    => 'default',
        'header_sticky'   => true,
    ),
    
    // Component Styles
    'components' => array(
        'button_radius'    => '0.5rem',
        'card_radius'      => '0.5rem',
        'card_shadow'      => '0 1px 3px rgba(0, 0, 0, 0.1)',
        'section_spacing'  => '4rem',
    ),
    
    // Template Overrides (optional)
    'templates' => array(
        'header' => 'presets/preset-id/template-parts/header.php',
        'hero'   => 'presets/preset-id/template-parts/sections/section-hero.php',
    ),
    
    // CSS Files
    'styles' => array(
        'main' => 'presets/preset-id/assets/css/preset.css',
    ),
    
    // JavaScript Files (optional)
    'scripts' => array(
        'main' => 'presets/preset-id/assets/js/preset.js',
    ),
    
    // Section Defaults
    'sections' => array(
        'hero' => array(
            'title'    => 'Default Title',
            'subtitle' => 'Default Subtitle',
        ),
    ),
    
    // Features
    'features' => array(
        'show_breadcrumbs' => true,
        'show_share_buttons' => true,
    ),
);
```

## Preset Functions File

Each preset can have a `functions.php` file for custom hooks and filters:

```php
<?php
// Set preset identifier
add_filter('omran_core_theme_preset', function() {
    return 'preset-id';
});

// Customize section data
add_filter('omran_core_section_data', function($data, $section) {
    // Customize as needed
    return $data;
}, 10, 2);

// Add custom body classes
add_filter('omran_core_body_classes', function($classes) {
    $classes[] = 'my-custom-class';
    return $classes;
});
```

## Automatic Loading

The preset system automatically:

1. **Detects Presets**: Scans `/presets/` directory for preset folders
2. **Loads Configuration**: Reads `config.php` from each preset
3. **Applies Active Preset**: Based on `theme_preset` Redux option
4. **Loads Assets**: Automatically enqueues CSS/JS from preset
5. **Applies Styles**: Outputs CSS variables from preset colors
6. **Loads Templates**: Uses preset template overrides if available

## Available Functions

### Get Preset Configuration

```php
// Get active preset config
$config = omran_core_get_active_preset_config();

// Get specific option
$primary_color = omran_core_get_preset_option('colors.primary', '#000000');

// Get all available presets
$presets = omran_core_get_available_presets();
```

### Preset Hooks

```php
// Filter preset configuration
add_filter('omran_core_active_preset_config', function($config, $preset_id) {
    // Modify config
    return $config;
}, 10, 2);

// Action when preset is initialized
add_action('omran_core_preset_initialized', function($preset_id) {
    // Do something when preset loads
});
```

## Creating a New Preset

### Step 1: Create Preset Directory

```bash
mkdir -p presets/my-preset/assets/css
mkdir -p presets/my-preset/template-parts
```

### Step 2: Create config.php

```php
<?php
return array(
    'id' => 'my-preset',
    'name' => 'My Preset',
    'colors' => array(
        'primary' => '#ff0000',
        // ... more colors
    ),
    // ... rest of config
);
```

### Step 3: Create functions.php (optional)

```php
<?php
add_filter('omran_core_theme_preset', function() {
    return 'my-preset';
});
```

### Step 4: Create preset.css (optional)

```css
.preset-my-preset {
    /* Custom styles */
}
```

### Step 5: Activate Preset

Set `theme_preset` option in Redux to `my-preset`. The system will automatically load it.

## Template Overrides

Presets can override core templates:

```php
// In config.php
'templates' => array(
    'hero' => 'presets/my-preset/template-parts/sections/section-hero.php',
),
```

The system will automatically use the preset template if it exists.

## CSS Variables

Preset colors are automatically output as CSS variables:

```css
:root {
    --preset-primary: #2c5530;
    --preset-secondary: #4a7c59;
    --preset-accent: #f97316;
}
```

Use them in your preset CSS:

```css
.preset-my-preset .button {
    background: var(--preset-primary);
}
```

## Best Practices

1. **Keep Presets Focused**: Each preset should target a specific industry/use case
2. **Use CSS Variables**: Reference preset colors via CSS variables
3. **Override, Don't Duplicate**: Override templates/components rather than copying
4. **Document Customizations**: Comment complex customizations in functions.php
5. **Test Thoroughly**: Ensure preset works with all core features

## Examples

See the included presets for examples:
- `presets/industrial/` - Industrial/manufacturing theme
- `presets/food-beverage/` - Food industry theme
- `presets/tech-devices/` - Technology theme

