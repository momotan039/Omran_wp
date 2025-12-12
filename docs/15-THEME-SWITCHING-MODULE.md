# Theme Switching Module

## Overview

The Theme Switching Module provides a comprehensive interface within Redux Framework for switching between theme presets, previewing changes, and applying updates instantly. It includes dynamic preset detection, color injection into Tailwind config, and automatic style rebuilding.

## Features

### 1. Dynamic Preset Detection
- Automatically scans `/presets/` directory
- Loads preset configurations dynamically
- No hardcoded preset lists
- Extensible for future presets

### 2. Preview System
- Real-time preset preview in admin
- Color palette preview
- Typography preview
- Frontend preview mode

### 3. Instant Updates
- AJAX-powered preset switching
- No page reload required for preview
- Instant color updates via CSS variables
- Automatic UI refresh

### 4. Tailwind Integration
- Automatic Tailwind config updates
- Color injection into Tailwind theme
- Supports rebuild on demand

### 5. Style Rebuilding
- Automatic CSS generation
- Preset-specific style files
- CSS variable injection
- Cache clearing

## Redux Panel Structure

### Theme Style Panel

Located at: `core/redux/sections/theme-style.php`

**Sections:**
1. **Preset Selector** - Dropdown with all available presets
2. **Preset Information** - Current preset details and color preview
3. **Color Customization** - Primary, secondary, accent, background, text
4. **Typography Settings** - Font family and weight
5. **Layout Settings** - Container width, content layout, header/footer styles
6. **Advanced Settings** - Rebuild styles, Tailwind config updates

### Field IDs

- `theme_preset` - Preset selector
- `preset_primary_color` - Primary color picker
- `preset_secondary_color` - Secondary color picker
- `preset_accent_color` - Accent color picker
- `preset_background_color` - Background color picker
- `preset_text_color` - Text color picker
- `preset_font_family` - Font family selector
- `preset_font_weight` - Font weight selector
- `preset_container_width` - Container width selector
- `preset_content_layout` - Content layout selector
- `preset_header_style` - Header style selector
- `preset_header_sticky` - Sticky header toggle
- `preset_footer_style` - Footer style selector
- `preset_rebuild_styles` - Style rebuild mode
- `preset_update_tailwind` - Tailwind config update toggle

## AJAX Handlers

### Switch Preset

**Action:** `omran_switch_preset`

**Parameters:**
- `preset_id` (string) - Preset identifier
- `colors` (array) - Color values
- `update_tailwind` (bool) - Update Tailwind config
- `rebuild_styles` (bool) - Rebuild CSS files

**Response:**
```json
{
    "success": true,
    "data": {
        "message": "Preset applied successfully",
        "preset": "industrial",
        "config": { ... }
    }
}
```

### Get Preset Preview

**Action:** `omran_get_preset_preview`

**Parameters:**
- `preset_id` (string) - Preset identifier

**Response:**
```json
{
    "success": true,
    "data": {
        "preview": "<div>...</div>",
        "config": { ... }
    }
}
```

## JavaScript API

### PresetSwitcher Object

```javascript
// Initialize
PresetSwitcher.init();

// Show preview
PresetSwitcher.showPreview(presetId);

// Apply preset
PresetSwitcher.applyPreset();

// Preview in new window
PresetSwitcher.previewPreset(presetId);

// Update color preview
PresetSwitcher.updateColorPreview();

// Update UI
PresetSwitcher.updateUI(config);
```

### Events

```javascript
// Preset selector change
$('#redux-opt-theme_preset').on('change', function() {
    const presetId = $(this).val();
    PresetSwitcher.showPreview(presetId);
});

// Apply button click
$('#omran-apply-preset').on('click', function() {
    PresetSwitcher.applyPreset();
});
```

## PHP Functions

### omran_core_ajax_switch_preset()

Switches the active preset and applies all settings.

**Usage:**
```php
// Called via AJAX
// Updates Redux options
// Updates Tailwind config (if enabled)
// Rebuilds styles (if enabled)
```

### omran_core_ajax_get_preset_preview()

Returns preset preview HTML and configuration.

**Usage:**
```php
// Called via AJAX
// Returns formatted preview HTML
// Includes color swatches and typography info
```

### omran_core_update_tailwind_config($preset_config)

Updates Tailwind configuration file with preset colors.

**Parameters:**
- `$preset_config` (array) - Preset configuration array

**Returns:** `bool` - True on success

**Usage:**
```php
$preset_config = omran_core_get_active_preset_config();
omran_core_update_tailwind_config($preset_config);
```

### omran_core_rebuild_preset_styles($preset_id, $preset_config)

Rebuilds preset CSS file with updated colors.

**Parameters:**
- `$preset_id` (string) - Preset identifier
- `$preset_config` (array) - Preset configuration

**Returns:** `bool` - True on success

**Usage:**
```php
$preset_id = 'industrial';
$preset_config = omran_core_get_active_preset_config();
omran_core_rebuild_preset_styles($preset_id, $preset_config);
```

## Frontend Preview Mode

### Usage

Add `?omran_preview=preset-id` to any frontend URL while logged in as admin.

**Example:**
```
https://yoursite.com/?omran_preview=industrial
https://yoursite.com/?omran_preview=food-beverage
```

### Features

- Temporarily applies preset without saving
- Shows preview banner at top of page
- Exit preview link
- Only visible to users with `manage_options` capability

## Tailwind Config Updates

The system automatically updates `tailwind.config.js` with preset colors:

**Before:**
```javascript
colors: {
    primary: '#047857',
    secondary: '#10b981',
    accent: '#f3f4f6',
}
```

**After (Industrial preset):**
```javascript
colors: {
    primary: '#2c5530',
    secondary: '#4a7c59',
    accent: '#f97316',
}
```

## Style Rebuilding

When enabled, the system:

1. Reads preset configuration
2. Generates CSS variables
3. Creates/updates preset CSS file
4. Outputs CSS variables to frontend

**Generated CSS:**
```css
:root {
    --preset-primary: #2c5530;
    --preset-secondary: #4a7c59;
    --preset-accent: #f97316;
    /* ... more variables ... */
}
```

## Hooks & Filters

### Actions

```php
// Fired after Tailwind config is updated
do_action('omran_core_tailwind_config_updated', $preset_config, $success);
```

### Filters

```php
// Filter preset before switching
apply_filters('omran_core_preset_before_switch', $preset_config, $preset_id);

// Filter preset after switching
apply_filters('omran_core_preset_after_switch', $preset_config, $preset_id);
```

## Security

- All AJAX handlers check `manage_options` capability
- Nonce verification for all AJAX requests
- Input sanitization for all user data
- Output escaping for all displayed content

## Performance

- Preset configs are cached after first load
- CSS variables output inline (minimal overhead)
- AJAX requests are lightweight
- Tailwind config updates are optional

## Extending

### Add New Preset

1. Create preset folder: `/presets/my-preset/`
2. Add `config.php` with preset configuration
3. System automatically detects and includes it

### Custom AJAX Handler

```php
add_action('wp_ajax_omran_custom_action', function() {
    // Your custom logic
});
```

### Custom Preview Content

```php
add_filter('omran_core_preset_preview_content', function($content, $preset_config) {
    // Customize preview HTML
    return $content;
}, 10, 2);
```

## Troubleshooting

### Preset Not Appearing

1. Check preset folder exists: `/presets/{preset-id}/`
2. Verify `config.php` exists and returns array
3. Check preset ID matches folder name
4. Clear cache and reload

### Colors Not Updating

1. Check Tailwind config update is enabled
2. Verify Tailwind config file is writable
3. Check CSS variables are output (view page source)
4. Clear browser cache

### Styles Not Rebuilding

1. Check style rebuild mode is set to "Automatic"
2. Verify preset CSS directory is writable
3. Check file permissions
4. Review error logs

## Best Practices

1. **Test Before Applying**: Use preview mode before applying changes
2. **Backup Config**: Backup Tailwind config before auto-updates
3. **Version Control**: Track Tailwind config changes
4. **Clear Cache**: Clear all caches after switching presets
5. **Test Frontend**: Always test frontend after preset changes

