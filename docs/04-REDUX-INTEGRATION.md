# Redux Framework Integration

Dynamic section management for front page via WordPress admin.

## Installation
1. Install Redux Framework plugin
2. Access **إعدادات الموقع** (Site Settings) in admin

## Features
- Enable/disable sections
- Drag & drop reordering
- Edit all text content
- Upload/replace images
- Add/remove repeater items

## Available Sections

1. **Hero Section** - Badge, title, description, buttons, background image
2. **Risks Section** - Risk items (repeater)
3. **Sectors Section** - Service sectors (repeater)
4. **Products Section** - Featured products display
5. **Stainless Steel Section** - Benefits (repeater)
6. **Testimonials Section** - Customer testimonials

## Usage

**Editing Content**
- Go to **إعدادات الموقع** → Select section tab
- Toggle enable/disable
- Edit fields, upload images
- Save changes

**Reordering**
- Go to **إعدادات الموقع** → **ترتيب الأقسام**
- Drag sections to reorder
- Move to "Disabled" to hide

## Helper Functions

```php
alomran_get_option($option, $default)      // Get option value
alomran_is_section_enabled($section_id)    // Check if enabled
alomran_get_section_data($section_id)      // Get section data
alomran_get_ordered_sections()             // Get ordered sections
```

## Template Files
Located in `template-parts/sections/` - automatically check if enabled and retrieve Redux data.

