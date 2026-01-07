# دليل فصل القوالب - Migration Guide

## نظرة عامة

هذا الدليل يشرح كيفية تحويل القالب الحالي (الذي يستخدم نظام Presets) إلى 3 قوالب WordPress منفصلة تماماً.

## البنية الحالية

```
alomran-theme/
├── core/                    # نظام Preset (سيتم إزالته)
├── presets/                 # 3 presets (سيتم تحويلها إلى قوالب منفصلة)
│   ├── industrial/
│   ├── food/
│   └── tech/
├── inc/                     # ملفات مشتركة (سيتم توزيعها)
└── assets/                  # ملفات مشتركة (سيتم توزيعها)
```

## البنية الجديدة

```
wp-content/themes/
├── alomran-industrial/      # قالب Industrial منفصل
├── alomran-food/            # قالب Food منفصل
└── alomran-tech/            # قالب Tech منفصل
```

## الملفات المشتركة (Shared Files)

هذه الملفات موجودة في جميع القوالب الثلاثة:

### Core Files
- `index.php`
- `404.php`
- `header.php` (مشترك مع تعديلات بسيطة)
- `footer.php` (مشترك مع تعديلات بسيطة)

### Core Directories
- `inc/setup.php`
- `inc/assets.php`
- `inc/translation.php`
- `inc/menu-walker.php`
- `inc/redux-blocker.php`
- `inc/cpt-common.php` (contact_message فقط)
- `inc/helpers/` (معظم الملفات مشتركة)
- `inc/seo/` (كامل)
- `inc/widgets/` (معظمها مشتركة)
- `inc/demo-import/` (سيتم تبسيطه)

### Assets
- `assets/css/custom.css`
- `assets/css/loader.css`
- `assets/js/main.js`
- `assets/js/modules/` (معظمها مشتركة)

## الملفات الخاصة بكل Preset

### Industrial
- `presets/industrial/cpt.php` → `inc/cpt.php`
- `presets/industrial/taxonomies.php` → `inc/taxonomies.php`
- `presets/industrial/redux-sections.php` → `inc/redux/redux-sections.php`
- `presets/industrial/redux-config.php` → `inc/redux/redux-config.php`
- `presets/industrial/templates/` → جذور القالب
- `presets/industrial/template-parts/` → `template-parts/`
- `presets/industrial/assets/` → `assets/preset/`
- `presets/industrial/demo/` → `demo/`

### Food
- `presets/food/cpt.php` → `inc/cpt.php`
- `presets/food/taxonomies.php` → `inc/taxonomies.php`
- `presets/food/redux-sections.php` → `inc/redux/redux-sections.php`
- `presets/food/redux.json` → `inc/redux/redux.json`
- `presets/food/templates/` → جذور القالب
- `presets/food/template-parts/` → `template-parts/`
- `presets/food/assets/` → `assets/preset/`
- `presets/food/demo/` → `demo/`
- `presets/food/admin/` → `inc/admin/`
- `inc/acf-food.php` → `inc/acf.php`

### Tech
- `presets/tech/redux-sections.php` → `inc/redux/redux-sections.php`
- `presets/tech/redux.json` → `inc/redux/redux.json`
- `presets/tech/templates/` → جذور القالب
- `presets/tech/template-parts/` → `template-parts/`
- `presets/tech/assets/` → `assets/preset/`
- `presets/tech/demo/` → `demo/`

## خطوات الفصل

### المرحلة 1: إعداد الهيكل الأساسي

1. إنشاء 3 مجلدات جديدة:
   - `alomran-industrial/`
   - `alomran-food/`
   - `alomran-tech/`

2. نسخ الملفات الأساسية لكل قالب:
   - `style.css` (مع تعديل Theme Name)
   - `index.php`
   - `404.php`
   - `header.php`
   - `footer.php`

### المرحلة 2: نسخ الملفات المشتركة

لكل قالب، نسخ:
- `inc/setup.php`
- `inc/assets.php`
- `inc/translation.php`
- `inc/menu-walker.php`
- `inc/redux-blocker.php`
- `inc/cpt-common.php`
- `inc/helpers/` (كامل)
- `inc/seo/` (كامل)
- `inc/widgets/` (كامل)
- `assets/css/custom.css`
- `assets/css/loader.css`
- `assets/js/main.js`
- `assets/js/modules/` (كامل)

### المرحلة 3: نسخ الملفات الخاصة

لكل قالب، نسخ الملفات الخاصة به من `presets/{preset}/`

### المرحلة 4: إنشاء functions.php

لكل قالب، إنشاء `functions.php` جديد يحتوي على:
- تحميل الملفات المشتركة
- تحميل الملفات الخاصة
- إزالة جميع الإشارات إلى Preset System
- تبسيط Redux Config (إزالة preset selector)

### المرحلة 5: تحديث Redux Config

لكل قالب:
- إزالة `theme-presets.php` section
- إزالة جميع الإشارات إلى Preset System
- تبسيط Redux Config ليكون مستقلاً

### المرحلة 6: تحديث Templates

لكل قالب:
- نقل templates من `presets/{preset}/templates/` إلى جذور القالب
- تحديث جميع المسارات
- إزالة جميع الإشارات إلى Preset System

### المرحلة 7: تحديث Assets

لكل قالب:
- نقل preset assets إلى `assets/preset/`
- تحديث مسارات التحميل في `inc/assets.php`

### المرحلة 8: الاختبار

لكل قالب:
- اختبار التحميل
- اختبار Redux
- اختبار Templates
- اختبار Assets
- اختبار CPTs و Taxonomies

## التعديلات المطلوبة

### 1. functions.php

**قبل:**
```php
// Load Core System First (before everything else)
require_once ALOMRAN_THEME_DIR . '/core/core-loader.php';
```

**بعد:**
```php
// No core loader needed - standalone theme
```

### 2. Redux Config

**قبل:**
```php
// Get sections from active preset
$preset = AlOmran_Preset_Loader::get_active_preset();
```

**بعد:**
```php
// Load sections directly (no preset system)
$section_files = array(
    'theme-general.php',
    'theme-header.php',
    // ... etc
);
```

### 3. Template Loading

**قبل:**
```php
$template = AlOmran_Preset_Loader::locate_template('section-hero', 'sections');
```

**بعد:**
```php
$template = locate_template('template-parts/sections/section-hero.php');
```

### 4. Assets Loading

**قبل:**
```php
AlOmran_Preset_Loader::load_preset_assets();
```

**بعد:**
```php
wp_enqueue_style('theme-preset', get_template_directory_uri() . '/assets/preset/css/preset.css');
```

## المزايا بعد الفصل

1. **الأداء**: كل قالب مستقل تماماً - لا يوجد overhead من Preset System
2. **البساطة**: كود أبسط وأسهل للصيانة
3. **الاستقلالية**: كل قالب يمكن تطويره بشكل مستقل
4. **الحجم**: كل قالب أصغر حجماً (لا يحتوي على presets أخرى)
5. **التوافق**: كل قالب يعمل بشكل مستقل تماماً

## المخاطر والتحديات

1. **التحديثات**: أي تحديث في الملفات المشتركة يجب تطبيقه على 3 قوالب
2. **الصيانة**: 3 قوالب تحتاج صيانة منفصلة
3. **التوافق**: يجب التأكد من توافق كل قالب مع WordPress

## الحلول المقترحة

1. **Shared Library**: إنشاء مكتبة مشتركة للملفات المشتركة
2. **Build System**: استخدام نظام build لتوليد القوالب من source واحد
3. **Version Control**: استخدام Git submodules للملفات المشتركة

## الخلاصة

فصل القوالب سيعطي أداء أفضل وبساطة أكبر، لكنه يحتاج صيانة أكثر. يجب الموازنة بين المزايا والعيوب قبل اتخاذ القرار.

