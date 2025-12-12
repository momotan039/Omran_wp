# Core Assets Directory

This directory contains all CSS and design assets for the Core Theme Layer.

## Structure

```
core/assets/
└── css/
    ├── base.css              # Base styles (animations, utilities)
    ├── components.css         # Reusable component styles
    └── presets/              # Preset-specific styles
        ├── industrial.css    # Industrial preset styles
        ├── food-beverage.css # Food & Beverage preset styles
        └── tech-devices.css  # Tech & Devices preset styles
```

## File Descriptions

### base.css
Base styles that apply to all presets:
- Animations (fadeInUp, slideInRight, scaleIn, etc.)
- Loading states
- Accessibility improvements
- Print styles
- RTL support
- Theme-specific overrides

### components.css
Reusable component styles that work across all presets:
- Scrollbar styles
- Line clamp utilities
- Card components
- Button components
- Grid utilities
- Container utilities
- Responsive utilities

These can be overridden by preset-specific styles.

### presets/{preset-name}.css
Preset-specific styles that customize:
- Colors (CSS variables)
- Typography
- Component variations
- Layout adjustments
- Industry-specific styling

## Loading Order

Assets are loaded in this order:
1. **Tailwind CSS** (from `assets/css/tailwind.css`)
2. **Components CSS** (`core/assets/css/components.css`)
3. **Base CSS** (`core/assets/css/base.css`)
4. **Preset CSS** (`core/assets/css/presets/{preset}.css`)

This ensures proper cascade and allows presets to override base styles.

## Adding a New Preset Style

1. Create `core/assets/css/presets/my-preset.css`
2. Define CSS variables for colors:
   ```css
   :root {
       --preset-primary: #color;
       --preset-secondary: #color;
       --preset-accent: #color;
   }
   ```
3. Add preset-specific styles using `.preset-my-preset` class
4. The asset loader will automatically load it when preset is active

## Customization

### Override Component Styles
Presets can override component styles by targeting the same classes:

```css
/* In preset CSS */
.preset-food-beverage .card {
    border-radius: 12px;
    /* Overrides base .card styles */
}
```

### Add Custom Styles
Presets can add completely new styles:

```css
/* In preset CSS */
.preset-food-beverage .ingredient-list {
    /* New component specific to food preset */
}
```

## Hooks

The asset loader provides hooks for customization:

```php
// Enqueue additional preset styles
add_action('omran_core_enqueue_preset_styles', function($preset) {
    if ($preset === 'my-preset') {
        wp_enqueue_style('my-custom-style', 'path/to/style.css');
    }
});

// Enqueue additional preset scripts
add_action('omran_core_enqueue_preset_scripts', function($version) {
    wp_enqueue_script('my-custom-script', 'path/to/script.js', array('jquery'), $version);
});
```

## Best Practices

1. **Use CSS Variables**: Define colors as CSS variables for easy theming
2. **Preset Classes**: Always scope preset styles with `.preset-{name}` class
3. **Component Overrides**: Override components rather than duplicating code
4. **Mobile First**: Write responsive styles with mobile-first approach
5. **Performance**: Keep preset CSS files focused and minimal

## File Organization

- **Base styles**: Core functionality that never changes
- **Components**: Reusable UI components
- **Presets**: Industry-specific customizations

This separation allows:
- Easy preset creation
- Maintainable codebase
- Performance optimization
- Design flexibility

