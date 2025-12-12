# Template Parts Refactoring

## Overview

All template parts have been refactored to separate core logic from visual presentation. This allows for one logic layer with multiple UI variations per preset, eliminating code duplication.

## Architecture

### Core Logic Files

Located in: `template-parts/sections/`

**Structure:**
- Data fetching (Redux options, queries)
- Data preparation and validation
- Logic processing
- **No HTML/layout code**

**Example:**
```php
// template-parts/sections/section-hero.php
$data = alomran_get_section_data('hero');
if (!$data['enable']) {
    return;
}

// Prepare data
$hero_data = array(
    'title' => $data['title'],
    'subtitle' => $data['subtitle'],
    // ... more data
);

// Load preset layout
$layout_path = omran_core_locate_preset_template_part('sections/section-hero', 'hero');
include $layout_path;
```

### Preset Layout Files

Located in: `presets/{preset-id}/layouts/`

**Structure:**
- HTML markup
- CSS classes
- Visual styling
- **No logic/queries**

**Example:**
```php
// presets/industrial/layouts/hero.php
<section class="hero-section" <?php echo omran_core_get_section_attributes('hero'); ?>>
    <h1><?php echo esc_html($hero_data['title']); ?></h1>
    <!-- HTML only, uses $hero_data from core logic -->
</section>
```

## Template Part Loader

### Functions

**omran_core_locate_preset_template_part($template_name, $section_name)**

Locates preset-specific layout file for a section.

**Parameters:**
- `$template_name` (string) - Template name (e.g., 'sections/section-hero')
- `$section_name` (string) - Section identifier (e.g., 'hero')

**Returns:** `string|false` - Template path or false if not found

**Search Order:**
1. `presets/{preset-id}/template-parts/{template_name}.php`
2. `presets/{preset-id}/template-parts/sections/section-{section_name}.php`
3. `presets/{preset-id}/layouts/{section_name}.php`
4. Fallback to default layout

**omran_core_get_section_attributes($section_name)**

Returns HTML attributes for section wrapper.

**Returns:** `string` - HTML attributes (class, data-section, data-preset)

**omran_core_get_section_classes($section_name)**

Returns CSS classes for section wrapper.

**Returns:** `string` - Space-separated CSS classes

## Refactored Sections

### Hero Section

**Core Logic:** `template-parts/sections/section-hero.php`
- Fetches hero data from Redux
- Validates enable flag
- Prepares data array
- Loads preset layout

**Layouts:**
- `presets/industrial/layouts/hero.php` - Professional industrial design
- `presets/food-beverage/layouts/hero.php` - Vibrant food industry design
- `presets/tech-devices/layouts/hero.php` - Modern tech design with glass morphism

### Products Section

**Core Logic:** `template-parts/sections/section-products.php`
- Queries featured products
- Validates enable flag
- Prepares query and data
- Loads preset layout

**Layouts:**
- `presets/industrial/layouts/products.php` - Grid layout with industrial styling

### Testimonials Section

**Core Logic:** `template-parts/sections/section-testimonials.php`
- Queries testimonials
- Validates enable flag
- Prepares query and data
- Loads preset layout

**Layouts:**
- `presets/industrial/layouts/testimonials.php` - Card-based testimonial layout

### Sectors Section

**Core Logic:** `template-parts/sections/section-sectors.php`
- Validates sectors data
- Prepares items array
- Loads preset layout

**Layouts:**
- `presets/industrial/layouts/sectors.php` - Icon-based sector cards

### Risks Section

**Core Logic:** `template-parts/sections/section-risks.php`
- Validates risks data
- Prepares items array
- Loads preset layout

**Layouts:**
- `presets/industrial/layouts/risks.php` - Warning-based risk display

## Data Flow

```
1. Frontend calls get_template_part('sections/section-hero')
   ↓
2. Core logic file (section-hero.php) loads
   ↓
3. Fetches data from Redux/ACF
   ↓
4. Prepares data array
   ↓
5. Locates preset layout file
   ↓
6. Includes layout file with data
   ↓
7. Layout renders HTML using data
```

## Creating New Preset Layouts

### Step 1: Create Layout File

```bash
presets/my-preset/layouts/hero.php
```

### Step 2: Use Data from Core Logic

```php
<?php
// $hero_data is automatically available from core logic
?>
<section <?php echo omran_core_get_section_attributes('hero'); ?>>
    <h1><?php echo esc_html($hero_data['title']); ?></h1>
    <!-- Your custom HTML/layout -->
</section>
```

### Step 3: Use CSS Variables

```php
<div style="background-color: var(--preset-primary);">
    <!-- Uses preset colors automatically -->
</div>
```

## Hooks & Filters

### Filters

**omran_core_hero_data**
```php
add_filter('omran_core_hero_data', function($hero_data) {
    // Modify hero data before rendering
    $hero_data['title'] = 'Custom Title';
    return $hero_data;
});
```

**omran_core_products_data**
```php
add_filter('omran_core_products_data', function($products_data) {
    // Modify products data before rendering
    return $products_data;
});
```

**omran_core_section_classes**
```php
add_filter('omran_core_section_classes', function($classes, $section_name, $preset_id) {
    // Add custom classes
    $classes[] = 'my-custom-class';
    return $classes;
}, 10, 3);
```

**omran_core_section_attributes**
```php
add_filter('omran_core_section_attributes', function($attributes, $section_name) {
    // Add custom attributes
    $attributes['data-custom'] = 'value';
    return $attributes;
}, 10, 2);
```

## Benefits

### 1. No Code Duplication
- Logic written once in core files
- Layouts only contain HTML/CSS
- Presets share same logic

### 2. Easy Preset Creation
- Copy layout file
- Modify HTML/CSS
- No logic changes needed

### 3. Maintainability
- Fix logic once, applies to all presets
- Update layouts independently
- Clear separation of concerns

### 4. Extensibility
- Add new presets easily
- Override layouts per preset
- Filter data before rendering

## Migration Guide

### Old Template Part
```php
// Old: Logic + HTML mixed
$data = alomran_get_section_data('hero');
if (!$data['enable']) return;
?>
<section class="hero">
    <h1><?php echo $data['title']; ?></h1>
</section>
```

### New Template Part
```php
// New: Logic only
$data = alomran_get_section_data('hero');
if (!$data['enable']) return;
$hero_data = array('title' => $data['title']);
$layout_path = omran_core_locate_preset_template_part('sections/section-hero', 'hero');
include $layout_path;
```

### New Layout File
```php
// presets/industrial/layouts/hero.php
<section class="hero" <?php echo omran_core_get_section_attributes('hero'); ?>>
    <h1><?php echo esc_html($hero_data['title']); ?></h1>
</section>
```

## Best Practices

1. **Keep Logic in Core Files**
   - All queries, data fetching, validation in core
   - No HTML in core files

2. **Keep HTML in Layout Files**
   - All markup in preset layouts
   - No queries or logic in layouts

3. **Use CSS Variables**
   - Reference preset colors via CSS variables
   - Ensures consistency across presets

4. **Escape All Output**
   - Use `esc_html()`, `esc_url()`, `esc_attr()`
   - Never trust user data

5. **Use Section Attributes**
   - Always use `omran_core_get_section_attributes()`
   - Provides consistent wrapper classes

## Troubleshooting

### Layout Not Loading

1. Check layout file exists: `presets/{preset-id}/layouts/{section}.php`
2. Verify preset ID matches active preset
3. Check file permissions
4. Review search order in loader function

### Data Not Available

1. Ensure core logic file prepares data
2. Check data array keys match layout expectations
3. Verify filters aren't removing data
4. Review data structure

### Styles Not Applying

1. Check CSS variables are output
2. Verify preset CSS is enqueued
3. Check section classes are applied
4. Review preset CSS file

