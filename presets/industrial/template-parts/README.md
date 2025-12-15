# Template Parts for Industrial Preset

This directory contains all reusable template parts organized by category.

## Directory Structure

```
template-parts/
├── common/                   # Shared components (DRY)
│   ├── helpers.php           # Helper functions loader
│   ├── page-header.php       # Page header component
│   ├── page-content.php     # Page content component
│   ├── archive-header.php    # Archive header component
│   ├── archive-loop.php      # Archive loop with pagination
│   ├── single-header.php    # Single post header component
│   ├── single-content.php    # Single post content component
│   └── section-loader.php    # Section loading helper
│
├── sections/                 # Page sections
│   ├── about-header.php      # About page header section
│   ├── about-content.php     # About page content section
│   ├── about-vision-mission.php
│   ├── about-stats.php
│   ├── section-hero.php      # Homepage hero section
│   ├── section-products.php
│   ├── section-testimonials.php
│   └── ...
│
├── header/                   # Header components
│   ├── header-default.php
│   ├── header-transparent.php
│   ├── header-logo.php
│   ├── header-nav.php
│   └── ...
│
├── footer/                   # Footer components
│   ├── footer-default.php
│   ├── footer-dark.php
│   └── ...
│
├── news/                     # News template parts
│   ├── news-hero.php
│   ├── news-content.php
│   ├── news-media.php
│   └── ...
│
└── product-card.php          # Product card component
```

## Loading Template Parts

### Using Preset Loader (Recommended)

```php
// Load from sections subdirectory
AlOmran_Preset_Loader::get_template_part('about-content', '', array(), 'sections');

// Load from root template-parts
AlOmran_Preset_Loader::get_template_part('product-card');

// Load from header subdirectory
AlOmran_Preset_Loader::get_template_part('header-default', '', array(), 'header');
```

### Using Section Loader Helper (DRY)

```php
// Load section with automatic enable check
omran_load_section('about-content', 'about-content', 'about_content', 'sections');

// Render section with wrapper
omran_render_section('about-header', 'about-header', 'about_header', 'bg-white', 'sections');
```

## Common Components

### Page Components
- `omran_render_page_header($args)` - Render page header
- `omran_render_page_content($args)` - Render page content

### Archive Components
- `omran_render_archive_header($args)` - Render archive header
- `omran_render_archive_loop($args)` - Render archive loop with pagination
- `omran_render_empty_archive()` - Render empty archive state

### Single Post Components
- `omran_render_single_header($args)` - Render single post header
- `omran_render_single_content($args)` - Render single post content

### Section Loading
- `omran_load_section($section_id, $template_name, $data_key, $subdirectory)` - Load section with enable check
- `omran_render_section($section_id, $template_name, $data_key, $wrapper_class, $subdirectory)` - Render section with wrapper

## Best Practices

1. **Use common components** for repeated patterns
2. **Use section-loader.php** for sections with enable checks
3. **Organize by category** - sections, header, footer, etc.
4. **Keep components focused** - one responsibility per component
5. **Use helper functions** for complex logic
6. **Follow naming conventions** - `{category}-{name}.php`

## Path Resolution

Template parts are loaded from:
- `presets/industrial/template-parts/{subdirectory}/{name}.php`
- `presets/industrial/template-parts/{name}.php` (if no subdirectory)

The system automatically:
1. Checks preset template-parts directory
2. Falls back to WordPress default `get_template_part()` if not found
3. Supports nested subdirectories (e.g., `sections/about/header.php`)

