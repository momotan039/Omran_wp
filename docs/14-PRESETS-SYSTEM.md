# Complete Theme Presets System

## Overview

The Theme Presets System provides a complete solution for managing multiple theme variations without modifying core code. Each preset is self-contained with its own configuration, styles, templates, and functionality.

## Architecture

### Automatic Detection & Loading

The preset system automatically:
1. Scans `/presets/` directory for preset folders
2. Loads configuration from `config.php`
3. Applies active preset based on Redux `theme_preset` option
4. Enqueues preset-specific CSS/JS assets
5. Outputs CSS variables from preset colors
6. Loads preset template overrides
7. Applies preset-specific hooks and filters

### Core Integration

The preset loader (`core/functions/preset-loader.php`) integrates seamlessly with the core theme:
- Loads after core initialization
- Hooks into asset loading system
- Filters template locations
- Applies preset configurations

## Preset Structure

### Required Files

1. **config.php** - Preset configuration (required)
2. **functions.php** - Preset-specific hooks (optional)
3. **assets/css/preset.css** - Preset styles (optional)

### Optional Files

- `template-parts/` - Template overrides
- `assets/js/preset.js` - Preset JavaScript
- `README.md` - Preset documentation

## Configuration Options

### Colors

```php
'colors' => array(
    'primary'    => '#2c5530',
    'secondary'  => '#4a7c59',
    'accent'     => '#f97316',
    'background' => '#ffffff',
    'text'       => '#1f2937',
    // Custom colors
    'custom_1'   => '#color',
),
```

All colors are automatically output as CSS variables: `--preset-primary`, `--preset-secondary`, etc.

### Typography

```php
'typography' => array(
    'font_family'     => 'Cairo',
    'font_weight'     => '400',
    'heading_weight'  => '700',
    'body_size'       => '16px',
    'heading_scale'   => 1.25,
),
```

Typography settings are applied via body classes and CSS variables.

### Layout

```php
'layout' => array(
    'container_width' => 'standard', // full, wide, standard, narrow
    'content_layout'  => 'boxed',     // boxed, fullwidth
    'header_style'    => 'default',  // default, transparent, minimal, centered
    'footer_style'    => 'default',  // default, dark, minimal, centered
    'header_sticky'   => true,
    'sidebar_position' => 'none',    // left, right, none
),
```

Layout settings are applied automatically via Redux options.

### Components

```php
'components' => array(
    'button_radius'    => '0.5rem',
    'card_radius'      => '0.5rem',
    'card_shadow'      => '0 1px 3px rgba(0, 0, 0, 0.1)',
    'section_spacing'  => '4rem',
    'animation_speed'  => 'normal',
),
```

Component settings are output as CSS variables for use in preset styles.

### Templates

```php
'templates' => array(
    'header' => 'presets/preset-id/template-parts/header.php',
    'footer' => 'presets/preset-id/template-parts/footer.php',
    'hero'   => 'presets/preset-id/template-parts/sections/section-hero.php',
),
```

Template paths are relative to theme root. System automatically uses preset templates if they exist.

### Assets

```php
'styles' => array(
    'main' => 'presets/preset-id/assets/css/preset.css',
    'custom' => 'presets/preset-id/assets/css/custom.css',
),

'scripts' => array(
    'main' => 'presets/preset-id/assets/js/preset.js',
),
```

Asset paths are relative to theme root. Files are automatically enqueued with proper dependencies.

## API Functions

### Get Preset Configuration

```php
// Get active preset config
$config = omran_core_get_active_preset_config();

// Get specific option (supports dot notation)
$primary_color = omran_core_get_preset_option('colors.primary', '#000000');
$font_family = omran_core_get_preset_option('typography.font_family', 'Cairo');

// Get all available presets
$presets = omran_core_get_available_presets();
```

### Preset Hooks

```php
// Filter preset configuration
add_filter('omran_core_active_preset_config', function($config, $preset_id) {
    // Modify config before it's used
    if ($preset_id === 'my-preset') {
        $config['colors']['primary'] = '#custom-color';
    }
    return $config;
}, 10, 2);

// Action when preset initializes
add_action('omran_core_preset_initialized', function($preset_id) {
    // Do something when preset loads
    if ($preset_id === 'my-preset') {
        // Custom initialization
    }
});

// Filter available presets
add_filter('omran_core_available_presets', function($presets) {
    // Add or modify presets
    return $presets;
});
```

## Creating a Custom Preset

### Step 1: Directory Structure

```bash
presets/
└── my-custom-preset/
    ├── config.php
    ├── functions.php
    ├── assets/
    │   ├── css/
    │   │   └── preset.css
    │   └── js/
    │       └── preset.js (optional)
    └── template-parts/
        └── sections/
            └── section-hero.php (optional)
```

### Step 2: Configuration

Create `config.php`:

```php
<?php
return array(
    'id' => 'my-custom-preset',
    'name' => 'My Custom Preset',
    'description' => 'Description of my preset',
    'version' => '1.0.0',
    
    'colors' => array(
        'primary' => '#your-color',
        'secondary' => '#your-color',
        'accent' => '#your-color',
    ),
    
    'typography' => array(
        'font_family' => 'Your Font',
        'font_weight' => '400',
    ),
    
    'layout' => array(
        'container_width' => 'standard',
        'header_style' => 'default',
    ),
    
    'styles' => array(
        'main' => 'presets/my-custom-preset/assets/css/preset.css',
    ),
);
```

### Step 3: Functions

Create `functions.php`:

```php
<?php
add_filter('omran_core_theme_preset', function() {
    return 'my-custom-preset';
});

// Customize sections
add_filter('omran_core_section_data', function($data, $section) {
    if ($section === 'hero') {
        $data['title'] = 'My Custom Title';
    }
    return $data;
}, 10, 2);
```

### Step 4: Styles

Create `assets/css/preset.css`:

```css
.preset-my-custom-preset {
    /* Use CSS variables from config */
    color: var(--preset-primary);
}

.preset-my-custom-preset .button {
    background: var(--preset-primary);
    border-radius: var(--preset-button-radius);
}
```

### Step 5: Activate

Set `theme_preset` option in Redux to `my-custom-preset`. The system automatically loads it.

## Template Overrides

Presets can override any core template:

1. Create template in preset directory:
   ```
   presets/my-preset/template-parts/sections/section-hero.php
   ```

2. Add to config.php:
   ```php
   'templates' => array(
       'hero' => 'presets/my-preset/template-parts/sections/section-hero.php',
   ),
   ```

3. System automatically uses preset template when rendering sections.

## CSS Variables System

All preset colors and settings are automatically output as CSS variables:

```css
:root {
    --preset-primary: #2c5530;
    --preset-secondary: #4a7c59;
    --preset-accent: #f97316;
    --preset-font-family: "Cairo", sans-serif;
    --preset-button-radius: 0.5rem;
    --preset-card-radius: 0.5rem;
    /* ... more variables */
}
```

Use them in preset CSS files for consistent theming.

## Integration with Redux

The preset system integrates with Redux:

- **theme_preset** option controls which preset is active
- Preset colors can override Redux color options
- Layout settings from preset are applied via Redux
- Section defaults from preset are used if Redux values are empty

## Performance

- Presets are cached after first load
- Only active preset assets are enqueued
- CSS variables are output inline (minimal overhead)
- Template overrides are checked only when needed

## Best Practices

1. **Keep Presets Focused**: One preset = one industry/use case
2. **Use CSS Variables**: Reference preset config via CSS variables
3. **Override Templates**: Don't duplicate, override core templates
4. **Document Config**: Comment complex configuration options
5. **Test Thoroughly**: Ensure preset works with all core features
6. **Version Control**: Include version in config for updates

## Migration from Old System

If you have existing preset code:

1. Move to `/presets/{preset-id}/` directory
2. Create `config.php` with your settings
3. Move custom functions to `functions.php`
4. Move CSS to `assets/css/preset.css`
5. Update template paths in config

The system will automatically detect and load your preset.

## Troubleshooting

### Preset Not Loading

1. Check preset folder exists: `/presets/{preset-id}/`
2. Verify `config.php` exists and returns array
3. Check preset ID matches Redux `theme_preset` option
4. Verify file permissions

### Styles Not Applying

1. Check CSS file path in config is correct
2. Verify CSS file exists
3. Check CSS variables are being output (view page source)
4. Verify preset CSS is enqueued (check network tab)

### Templates Not Overriding

1. Check template path in config is correct
2. Verify template file exists
3. Check template path is relative to theme root
4. Verify template is being loaded (check template hierarchy)

## Examples

See included presets:
- `presets/industrial/` - Complete industrial preset
- `presets/food-beverage/` - Complete food industry preset
- `presets/tech-devices/` - Complete tech industry preset

Each includes full configuration, functions, and styles as reference.

