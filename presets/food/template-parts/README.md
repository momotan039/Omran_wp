# Food Preset Template Parts

This directory contains reusable template parts for the Food preset.

## Structure

- `common/` - Common template parts (headers, loops, content)
- `header/` - Header variations
- `footer/` - Footer variations
- `sections/` - Section templates (hero, about, etc.)

## Usage

Load template parts using:
```php
get_template_part('presets/food/template-parts/header/header-default');
```

Or use the preset loader:
```php
AlOmran_Preset_Loader::get_template_part('header/header-default');
```


