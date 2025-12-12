# Design Assets Separation

## Overview

Design assets (CSS, colors, typography) have been separated from core logic and organized into a structured system that supports multiple presets.

## Directory Structure

```
core/assets/
└── css/
    ├── base.css              # Base styles (animations, utilities)
    ├── components.css        # Reusable component styles
    └── presets/              # Preset-specific styles
        ├── industrial.css    # Industrial preset
        ├── food-beverage.css # Food & Beverage preset
        └── tech-devices.css  # Tech & Devices preset
```

## Asset Loading System

### Core Assets Loader

The `core/functions/assets-loader.php` file handles all asset loading:

1. **Tailwind CSS** - Base utility framework
2. **Components CSS** - Reusable component styles
3. **Base CSS** - Core animations and utilities
4. **Preset CSS** - Preset-specific customizations

### Loading Order

Assets load in this specific order to ensure proper cascade:

```php
1. Tailwind CSS (assets/css/tailwind.css)
2. Components CSS (core/assets/css/components.css)
3. Base CSS (core/assets/css/base.css)
4. Preset CSS (core/assets/css/presets/{preset}.css)
```

## CSS Organization

### base.css
Contains base styles that apply to all presets:
- Animation keyframes and classes
- Loading states
- Accessibility improvements
- Print styles
- RTL support
- Theme variable overrides

### components.css
Reusable component styles:
- Scrollbar styles
- Line clamp utilities
- Card components
- Button components
- Grid utilities
- Container utilities
- Responsive breakpoints

### presets/{preset-name}.css
Preset-specific customizations:
- CSS variable definitions (colors, fonts)
- Component overrides
- Industry-specific styling
- Layout variations

## Preset CSS Structure

Each preset CSS file follows this structure:

```css
/**
 * Preset Name Styles
 */

/* CSS Variables */
:root {
    --preset-primary: #color;
    --preset-secondary: #color;
    --preset-accent: #color;
    --preset-font-family: 'Font Name', sans-serif;
}

/* Preset-specific styles */
.preset-{name} {
    /* Base preset styles */
}

.preset-{name} .component {
    /* Component overrides */
}
```

## Creating a New Preset Style

### Step 1: Create CSS File

Create `core/assets/css/presets/my-preset.css`:

```css
/**
 * My Preset Styles
 */

:root {
    --preset-primary: #1a1a1a;
    --preset-secondary: #2a2a2a;
    --preset-accent: #3a3a3a;
}

.preset-my-preset {
    /* Preset styles */
}
```

### Step 2: Register Preset

The asset loader automatically detects presets based on the `theme_preset` option. Ensure your preset identifier matches the CSS filename (or add mapping in `assets-loader.php`).

### Step 3: Override Components

Override component styles as needed:

```css
.preset-my-preset .card {
    border-radius: 16px;
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
}
```

## CSS Variables

### Theme Variables
- `--theme-primary` - Primary color
- `--theme-secondary` - Secondary color
- `--theme-accent` - Accent color
- `--theme-gray-{shade}` - Gray scale colors

### Preset Variables
- `--preset-primary` - Preset primary color
- `--preset-secondary` - Preset secondary color
- `--preset-accent` - Preset accent color
- `--preset-font-family` - Preset font family

## Hooks for Customization

### Enqueue Additional Styles

```php
add_action('omran_core_enqueue_preset_styles', function($preset) {
    if ($preset === 'my-preset') {
        wp_enqueue_style(
            'my-custom-style',
            get_template_directory_uri() . '/presets/my-preset/custom.css',
            array('omran-core-preset'),
            '1.0.0'
        );
    }
});
```

### Enqueue Additional Scripts

```php
add_action('omran_core_enqueue_preset_scripts', function($version) {
    wp_enqueue_script(
        'my-custom-script',
        get_template_directory_uri() . '/presets/my-preset/custom.js',
        array('jquery'),
        $version,
        true
    );
});
```

### Filter Asset Paths

```php
add_filter('omran_core_asset_path', function($path, $type) {
    if ($type === 'css' && strpos($path, 'preset') !== false) {
        // Customize preset CSS path
        return get_template_directory_uri() . '/custom-presets/' . basename($path);
    }
    return $path;
}, 10, 2);
```

## Best Practices

1. **Use CSS Variables**: Always define colors as CSS variables for easy theming
2. **Scope Preset Styles**: Always use `.preset-{name}` class to scope styles
3. **Override, Don't Duplicate**: Override components rather than duplicating code
4. **Mobile First**: Write responsive styles with mobile-first approach
5. **Keep Files Focused**: Each CSS file should have a single responsibility
6. **Document Customizations**: Comment complex styles and overrides

## Migration from Old System

### Old Location
- `assets/css/custom.css` - All styles in one file

### New Location
- `core/assets/css/base.css` - Base styles
- `core/assets/css/components.css` - Components
- `core/assets/css/presets/{preset}.css` - Preset styles

### Backward Compatibility

The old `assets/css/custom.css` file is still loaded for backward compatibility, but new development should use the core assets structure.

## Performance Considerations

1. **File Size**: Keep preset CSS files focused and minimal
2. **Caching**: CSS files use file modification time for versioning
3. **Dependencies**: Proper dependency chain ensures correct loading order
4. **Conditional Loading**: Only active preset CSS is loaded

## Troubleshooting

### Styles Not Loading

1. Check file exists: `core/assets/css/presets/{preset}.css`
2. Verify preset identifier matches filename
3. Check asset loader is loaded: `core/functions/assets-loader.php`
4. Verify file permissions

### Styles Overridden

1. Check loading order (preset CSS loads last)
2. Verify CSS specificity
3. Check for conflicting styles in base.css or components.css

### Preset Not Applied

1. Verify `theme_preset` option is set correctly
2. Check preset mapping in `assets-loader.php`
3. Verify CSS file naming matches preset identifier

## Examples

See the existing preset files for examples:
- `core/assets/css/presets/industrial.css`
- `core/assets/css/presets/food-beverage.css`
- `core/assets/css/presets/tech-devices.css`

