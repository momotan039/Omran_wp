# Preset Isolation System

## Overview

The preset isolation system ensures that each preset is completely independent. When a preset is active, only its own CPTs, Taxonomies, and Redux sections are registered and loaded.

## How It Works

### 1. Custom Post Types (CPTs)

Each preset has its own `cpt.php` file that registers preset-specific post types:

- **Industrial**: `presets/industrial/cpt.php`
  - `product`
  - `news`
  - `testimonial`
  - `faq`

- **Food**: `presets/food/cpt.php`
  - (Add your Food-specific CPTs here)

**Common CPTs** (shared across all presets):
- `contact_message` - Registered in `inc/cpt-common.php`

### 2. Taxonomies

Each preset has its own `taxonomies.php` file:

- **Industrial**: `presets/industrial/taxonomies.php`
  - `product_category`
  - `news_category`

- **Food**: `presets/food/taxonomies.php`
  - (Add your Food-specific taxonomies here)

### 3. Redux Sections

Each preset has its own `redux-sections.php` file that returns an array of section files to load:

- **Industrial**: `presets/industrial/redux-sections.php`
  - Returns array of section files (hero, products, testimonials, etc.)

- **Food**: `presets/food/redux-sections.php`
  - Returns empty array by default (clean slate)

**Core Sections** (always loaded):
- `theme-presets.php` - Theme preset selector
- `content-display.php` - Content display settings

## File Structure

```
presets/
├── industrial/
│   ├── cpt.php              # Industrial CPTs
│   ├── taxonomies.php       # Industrial taxonomies
│   ├── redux-sections.php   # Industrial Redux sections
│   └── redux-config.php     # Industrial Redux config
├── food/
│   ├── cpt.php              # Food CPTs (empty template)
│   ├── taxonomies.php       # Food taxonomies (empty template)
│   ├── redux-sections.php   # Food Redux sections (empty)
│   └── redux-config.php     # Food Redux config
```

## Registration Flow

1. **Core System Loads** (`core/core-loader.php`)
   - Loads `AlOmran_Preset_Registry`

2. **Preset Registry Initializes** (`core/classes/class-preset-registry.php`)
   - Detects active preset
   - Loads preset's `cpt.php` (priority 5)
   - Loads preset's `taxonomies.php` (priority 20)
   - Filters Redux sections to load only from preset

3. **Redux Config Loads** (`inc/redux/redux-config.php`)
   - Loads preset's `redux-sections.php`
   - Only loads sections listed in that file
   - Always loads core sections (theme-presets, content-display)

## Benefits

1. **Complete Isolation**: Each preset is independent
2. **No Conflicts**: No CPT/taxonomy/Redux section conflicts
3. **Clean Slate**: New presets start with empty templates
4. **Easy Development**: Just add files to preset folder

## Adding New Preset

1. Create preset folder: `presets/{preset-name}/`
2. Create `cpt.php` - Register your CPTs
3. Create `taxonomies.php` - Register your taxonomies
4. Create `redux-sections.php` - Return array of section files
5. Create `redux-config.php` - Add preset-specific Redux config

## Example: Food Preset

```php
// presets/food/cpt.php
function alomran_food_register_post_types() {
    register_post_type('menu_item', array(...));
    register_post_type('reservation', array(...));
}
add_action('init', 'alomran_food_register_post_types', 10);

// presets/food/taxonomies.php
function alomran_food_register_taxonomies() {
    register_taxonomy('menu_category', 'menu_item', array(...));
}
add_action('init', 'alomran_food_register_taxonomies', 20);

// presets/food/redux-sections.php
return array(
    'food-menu.php',
    'food-reservations.php',
);
```

## Notes

- Old files `inc/cpt.php` and `inc/taxonomies.php` are disabled
- Common CPTs (like `contact_message`) are in `inc/cpt-common.php`
- Redux sections must exist in `inc/redux/sections/` directory
- Preset-specific Redux config is in `presets/{preset}/redux-config.php`














