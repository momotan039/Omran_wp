# Preset Content Isolation

## Overview

The preset content isolation system ensures that when a preset is active, only content from that preset is displayed. This creates a completely separate site experience for each preset.

## How It Works

### 1. Meta Fields

Each post, page, product, and menu is tagged with a `_alomran_preset` meta field that identifies which preset it belongs to.

### 2. Query Filtering

The system automatically filters all WordPress queries to show only:
- Content with the current preset's meta field
- Content without a preset meta field (for backward compatibility)

### 3. Menu Filtering

Menus are filtered to show only:
- Menus tagged with the current preset
- Menu items that link to posts from the current preset

### 4. Automatic Cleanup

When importing demo content for a new preset:
- Content from other presets is automatically deleted (if `delete_other_presets` option is enabled)
- This ensures a clean, fresh site for each preset

## Usage

### Setting Preset Meta

```php
// Set preset for a post
alomran_set_post_preset($post_id, 'food');

// Get preset for a post
$preset = alomran_get_post_preset($post_id);

// Set preset for a menu
alomran_set_menu_preset($menu_id, 'food');

// Get preset for a menu
$preset = alomran_get_menu_preset($menu_id);
```

### Deleting Preset Content

```php
// Delete all content from a specific preset
$results = alomran_delete_preset_content('industrial');
// Returns: array('posts' => 5, 'pages' => 3, 'products' => 10, 'news' => 2, 'menus' => 2)
```

## Demo Import

When importing demo content, the system automatically:
1. Tags all imported content with the preset meta field
2. Tags all imported menus with the preset meta field
3. Optionally deletes content from other presets (default: enabled)

```php
AlOmran_Demo_Importer::import_demo('food', array(
    'delete_other_presets' => true, // Delete content from other presets
    'import_content' => true,
    'import_menus' => true,
    // ... other options
));
```

## Filtered Post Types

The following post types are automatically filtered:
- `page`
- `post`
- `product`
- `news`
- `testimonial`
- `faq`

## Backward Compatibility

Content without a preset meta field is shown for backward compatibility. This allows existing content to remain visible until it's tagged with a preset.

## Notes

- Content isolation only works on the frontend (not in admin)
- Widget queries are also filtered
- Custom post types can be added to the filtered list in `alomran_apply_preset_filter()`



