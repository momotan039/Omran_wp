# Industrial Preset

## Overview

The Industrial preset is a complete, self-contained theme preset designed for manufacturing and industrial companies. It includes all necessary templates, assets, Redux configurations, and demo content.

## Structure

```
industrial/
├── assets/              # Preset-specific assets
├── template-parts/      # Preset-specific templates
├── demo/                # Demo content and settings
├── redux.json          # Redux field definitions
└── preset-info.json    # Preset metadata
```

## Templates

### Header Templates
- `template-parts/header/header-default.php` - Default header with primary navigation

### Footer Templates
- `template-parts/footer/footer-default.php` - Default footer with widget areas

### Section Templates
- `template-parts/sections/section-hero.php` - Hero section with background image support

## Redux Configuration

The preset defines additional Redux fields in `redux.json`:
- Industrial hero section settings
- Statistics display options
- Preset-specific color overrides

## Demo Content

The `demo/` folder contains:
- **redux-settings.json**: Complete Redux configuration
- **content.json**: Sample pages, posts, and products
- **menus.json**: Navigation menu structure
- **media/**: Demo images and files

## Customization

### Adding New Templates

1. Create template in appropriate `template-parts/` subdirectory
2. Use `AlOmran_Preset_Loader::locate_template()` to load
3. Follow WordPress template hierarchy

### Modifying Styles

Edit `assets/css/preset.css` for preset-specific styles. The preset CSS loads after core Tailwind CSS.

### Adding JavaScript

Add to `assets/js/preset.js` or create modules in `assets/js/modules/`. All preset JS loads after core scripts.

## Color Scheme

- **Primary**: `#2c5530` (Dark Green)
- **Secondary**: `#4a7c59` (Medium Green)
- **Accent**: `#f97316` (Vibrant Orange)

## Typography

- **Font Family**: Cairo (default)
- **Font Weight**: 400 (normal)

## Importing Demo

1. Go to **Theme Settings → Setup Wizard**
2. Select Industrial preset
3. Click **Import Demo Content**
4. Wait for import to complete

Or use the admin notice that appears when demo is not imported.

## Notes

- All templates fall back to core templates if not found in preset
- Preset assets load automatically when preset is active
- Redux settings merge with existing settings (unless overwrite is enabled)
- Demo import can be selective (content, media, Redux, menus)
