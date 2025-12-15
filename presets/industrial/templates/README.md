# Templates for Industrial Preset

This directory contains **ALL** templates (pages, archives, singles) for the Industrial preset. No templates should exist in the root theme directory.

## DRY Principles Applied

1. **Single Source of Truth**: All templates are in `presets/industrial/templates/`
2. **Common Components**: Reusable components in `template-parts/common/`
3. **Helper Functions**: Shared helper functions for consistent behavior
4. **Section Loader**: Centralized section loading logic

## Directory Structure

```
presets/industrial/
├── templates/                    # Main templates (pages, archives, singles)
│   ├── page-*.php               # Page templates
│   ├── archive-*.php            # Archive templates
│   ├── single-*.php             # Single post templates
│   └── taxonomy-*.php           # Taxonomy templates
│
└── template-parts/               # Reusable template parts
    ├── common/                   # Common components (DRY)
    │   ├── helpers.php           # Helper functions
    │   ├── page-header.php       # Page header component
    │   ├── page-content.php      # Page content component
    │   ├── archive-header.php    # Archive header component
    │   ├── archive-loop.php      # Archive loop component
    │   ├── single-header.php     # Single post header component
    │   ├── single-content.php    # Single post content component
    │   └── section-loader.php    # Section loading helper
    │
    ├── sections/                 # Page sections (About, Homepage)
    │   ├── about-*.php           # About page sections
    │   └── section-*.php         # Homepage sections
    │
    ├── header/                   # Header components
    ├── footer/                   # Footer components
    ├── news/                     # News template parts
    └── product-card.php          # Product card component
```

## Available Templates

### Page Templates
- `page-default.php` - Default page template (fallback)
- `page-about.php` - About Us page (uses sections)
- `page-contact.php` - Contact page
- `page-faq.php` - FAQ page
- `page-services.php` - Services page
- `page-projects.php` - Projects page
- `page-testimonials.php` - Testimonials page
- `page-privacy-policy.php` - Privacy Policy page
- `page-terms.php` - Terms of Service page

### Archive Templates
- `archive.php` - Default archive template
- `archive-product.php` - Product archive
- `archive-news.php` - News archive
- `taxonomy-product_category.php` - Product category taxonomy

### Single Post Templates
- `single.php` - Default single post template
- `single-product.php` - Single product page
- `single-news.php` - Single news post

## How Template Loading Works

### Template Hierarchy

1. **Page Templates**: `page_template` filter → `presets/industrial/templates/page-*.php`
2. **Archive Templates**: `archive_template` filter → `presets/industrial/templates/archive-*.php`
3. **Single Templates**: `single_template` filter → `presets/industrial/templates/single-*.php`
4. **Template Parts**: `get_template_part()` → `presets/industrial/template-parts/{subdirectory}/{name}.php`

### Template Part Loading

```php
// Load from sections subdirectory
AlOmran_Preset_Loader::get_template_part('about-content', '', array(), 'sections');

// Load from root template-parts
AlOmran_Preset_Loader::get_template_part('product-card');

// Load from header subdirectory
AlOmran_Preset_Loader::get_template_part('header-default', '', array(), 'header');
```

## Common Components Usage

### Page Templates
```php
<?php
get_header();
omran_load_common_components();

omran_render_page_header(array(
    'title' => 'Page Title',
    'subtitle' => 'Subtitle',
));

omran_render_page_content();
get_footer();
?>
```

### Archive Templates
```php
<?php
get_header();
omran_load_common_components();

omran_render_archive_header();
omran_render_archive_loop();
get_footer();
?>
```

### Section Loading (DRY)
```php
<?php
omran_load_common_components();

// Load section with automatic enable check
omran_load_section('about-content', 'about-content', 'about_content', 'sections');
?>
```

## Best Practices

1. **Always use common components** for headers and content
2. **Use section-loader.php** for loading sections with enable checks
3. **Don't duplicate code** - extract to common components
4. **Keep templates focused** - one template per page type
5. **Use helper functions** for repeated logic
6. **Follow naming conventions** - `{type}-{name}.php`

## Path Resolution

The system uses two main paths:
- **Templates**: `presets/industrial/templates/` - Full page templates
- **Template Parts**: `presets/industrial/template-parts/` - Reusable components

Template parts are organized by subdirectory:
- `common/` - Shared components
- `sections/` - Page sections
- `header/` - Header components
- `footer/` - Footer components
- `news/` - News components

## Notes

- All templates are RTL-ready and use Arabic content
- Templates integrate with Redux Framework for dynamic content
- **No templates should exist in root theme directory**
- DRY principle: Common components reduce code duplication
- Single source of truth: All templates in preset directory
- Section loader automatically checks if sections are enabled
