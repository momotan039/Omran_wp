# Core System Documentation

## Overview

The Core system provides a modular architecture for managing theme presets. It handles preset detection, template loading, asset management, Redux configuration, demo imports, and admin notices.

## Architecture

### Core Classes

1. **AlOmran_Preset_Loader** - Handles preset detection and template/asset loading
2. **AlOmran_Redux_Loader** - Loads preset-specific Redux configurations
3. **AlOmran_Section_Loader** - Manages dynamic section template loading
4. **AlOmran_Demo_Importer** - Handles demo content, media, and settings import
5. **AlOmran_Admin_Notices** - Displays interactive admin notices

## Preset Structure

Each preset should follow this structure:

```
presets/{preset-name}/
├── assets/
│   ├── css/
│   │   └── preset.css
│   └── js/
│       ├── preset.js
│       └── modules/
├── template-parts/
│   ├── header/
│   ├── footer/
│   ├── sections/
│   └── layouts/
├── demo/
│   ├── redux-settings.json
│   ├── content.json
│   ├── menus.json
│   └── media/
├── redux.json
└── preset-info.json
```

## Template Loading Priority

1. Preset-specific template (`presets/{preset}/template-parts/...`)
2. Core template (`template-parts/...`)

## Usage Examples

### Loading a Template

```php
// Load template from preset or core
$template = AlOmran_Preset_Loader::locate_template('section-hero', 'sections');
if ($template) {
    include $template;
}

// Or use the helper
AlOmran_Preset_Loader::load_template('section-hero', 'sections');
```

### Loading a Section

```php
// Load section using section loader
AlOmran_Section_Loader::load_section('hero');
```

### Checking Preset Status

```php
// Get active preset
$preset = AlOmran_Preset_Loader::get_active_preset();

// Check if preset is active
if (AlOmran_Preset_Loader::is_preset_active('industrial')) {
    // Industrial preset is active
}

// Check if preset exists
if (AlOmran_Preset_Loader::preset_exists('industrial')) {
    // Industrial preset exists
}
```

### Importing Demo Data

```php
// Import demo for a preset
$result = AlOmran_Demo_Importer::import_demo('industrial', array(
    'import_content' => true,
    'import_media' => true,
    'import_redux' => true,
    'import_menus' => true,
    'overwrite' => false,
));

// Check if demo is imported
if (AlOmran_Demo_Importer::is_demo_imported('industrial')) {
    // Demo is imported
}
```

## Redux Configuration

Presets can define their own Redux fields via `redux.json`. The format follows Redux Framework's section structure.

## Best Practices

1. Always check if a preset exists before accessing its resources
2. Use the loader classes instead of direct file access
3. Follow the preset structure for consistency
4. Include fallback templates in core for compatibility
5. Sanitize all user inputs and escape outputs

