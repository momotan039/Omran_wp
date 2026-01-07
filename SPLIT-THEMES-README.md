# دليل فصل القوالب - Split Themes Guide

## 🎯 الهدف

تحويل القالب الحالي (نظام Presets) إلى 3 قوالب WordPress منفصلة تماماً مع:
- ✅ أعلى أداء ممكن
- ✅ أفضل ممارسات WordPress
- ✅ كود نظيف وقابل للصيانة
- ✅ استقلالية كاملة لكل قالب

## 📋 المتطلبات

- PHP 7.4+
- WordPress 5.0+
- Redux Framework Plugin
- ACF Plugin (لـ Food preset)

## 🚀 خطوات التنفيذ

### المرحلة 1: التحضير

1. **نسخ احتياطي كامل**
   ```bash
   cp -r alomran-theme alomran-theme-backup
   ```

2. **إنشاء مجلدات القوالب الجديدة**
   ```bash
   cd wp-content/themes/
   mkdir alomran-industrial alomran-food alomran-tech
   ```

### المرحلة 2: استخدام Script التلقائي

```bash
cd alomran-theme
php scripts/split-themes.php
```

هذا الـ script سيقوم بـ:
- ✅ نسخ جميع الملفات المشتركة
- ✅ نسخ الملفات الخاصة بكل preset
- ✅ إنشاء `functions.php` لكل قالب
- ✅ تحديث `style.css` لكل قالب

### المرحلة 3: التعديلات اليدوية المطلوبة

بعد تشغيل الـ script، يجب إجراء التعديلات التالية:

#### 3.1 تحديث `functions.php`

**إزالة:**
- `core/core-loader.php`
- `inc/preset-content-isolation.php`
- `inc/helpers/helpers-presets.php` (إذا لم يكن مطلوباً)

**إضافة:**
- تحميل الملفات الخاصة بكل قالب فقط

#### 3.2 تحديث `inc/redux/redux-config.php`

**إزالة:**
- جميع الإشارات إلى `AlOmran_Preset_Loader`
- `theme-presets.php` section
- `content-display.php` section (إذا لم يكن مطلوباً)

**تعديل:**
```php
// قبل
$preset = AlOmran_Preset_Loader::get_active_preset();
$preset_dir = AlOmran_Preset_Loader::get_preset_dir($preset);
$redux_sections_file = $preset_dir . '/redux-sections.php';

// بعد
$redux_sections_file = ALOMRAN_THEME_DIR . '/inc/redux/redux-sections.php';
```

#### 3.3 تحديث Templates

**إزالة:**
- جميع الإشارات إلى `AlOmran_Preset_Loader::locate_template()`

**استبدال بـ:**
```php
// قبل
$template = AlOmran_Preset_Loader::locate_template('section-hero', 'sections');

// بعد
$template = locate_template('template-parts/sections/section-hero.php');
```

#### 3.4 تحديث Assets Loading

**في `inc/assets.php`:**

**إزالة:**
```php
AlOmran_Preset_Loader::load_preset_assets();
```

**إضافة:**
```php
// Load preset-specific assets
wp_enqueue_style('theme-preset', get_template_directory_uri() . '/assets/preset/css/preset.css', array(), ALOMRAN_THEME_VERSION);
wp_enqueue_script('theme-preset', get_template_directory_uri() . '/assets/preset/js/preset.js', array('jquery'), ALOMRAN_THEME_VERSION, true);
```

### المرحلة 4: تنظيف الكود

#### 4.1 إزالة Preset System

**ملفات يجب حذفها:**
- `core/` (كامل)
- `inc/preset-content-isolation.php`
- `inc/helpers/helpers-presets.php` (إذا لم يكن مطلوباً)

#### 4.2 تبسيط Redux Config

**إزالة:**
- `inc/redux/redux-section-config.php` (Tech فقط)
- `inc/redux/redux-repeater-defaults.php` (Tech فقط)
- `inc/redux/redux-reset-helpers.php` (Tech فقط)
- `inc/redux/redux-reset-handlers.php` (Tech فقط)

**للـ Industrial و Food:**
- إزالة جميع ملفات reset handlers (إذا لم تكن مطلوبة)

### المرحلة 5: الاختبار

لكل قالب:

1. **اختبار التحميل**
   - تفعيل القالب
   - التحقق من عدم وجود أخطاء

2. **اختبار Redux**
   - فتح صفحة الإعدادات
   - التحقق من تحميل جميع الأقسام

3. **اختبار Templates**
   - فتح الصفحة الرئيسية
   - فتح صفحات مختلفة
   - التحقق من تحميل Templates بشكل صحيح

4. **اختبار Assets**
   - التحقق من تحميل CSS/JS
   - التحقق من عدم وجود أخطاء في Console

5. **اختبار CPTs و Taxonomies**
   - التحقق من تسجيل CPTs
   - التحقق من تسجيل Taxonomies

## 📁 هيكل القوالب الجديدة

### Industrial Theme
```
alomran-industrial/
├── style.css
├── functions.php
├── index.php
├── 404.php
├── header.php
├── footer.php
├── inc/
│   ├── setup.php
│   ├── assets.php
│   ├── cpt.php (from presets/industrial/cpt.php)
│   ├── taxonomies.php (from presets/industrial/taxonomies.php)
│   ├── redux/
│   │   ├── redux-config.php (simplified)
│   │   └── redux-sections.php (from presets/industrial/redux-sections.php)
│   └── ...
├── template-parts/ (from presets/industrial/template-parts/)
├── assets/
│   └── preset/ (from presets/industrial/assets/)
└── demo/ (from presets/industrial/demo/)
```

### Food Theme
```
alomran-food/
├── style.css
├── functions.php
├── index.php
├── 404.php
├── header.php
├── footer.php
├── inc/
│   ├── setup.php
│   ├── assets.php
│   ├── cpt.php (from presets/food/cpt.php)
│   ├── taxonomies.php (from presets/food/taxonomies.php)
│   ├── acf.php (from inc/acf-food.php)
│   ├── admin/ (from presets/food/admin/)
│   ├── redux/
│   │   ├── redux-config.php (simplified)
│   │   ├── redux-sections.php (from presets/food/redux-sections.php)
│   │   └── redux.json (from presets/food/redux.json)
│   └── ...
├── template-parts/ (from presets/food/template-parts/)
├── assets/
│   └── preset/ (from presets/food/assets/)
└── demo/ (from presets/food/demo/)
```

### Tech Theme
```
alomran-tech/
├── style.css
├── functions.php
├── index.php
├── 404.php
├── header.php
├── footer.php
├── inc/
│   ├── setup.php
│   ├── assets.php
│   ├── redux/
│   │   ├── redux-config.php (simplified)
│   │   ├── redux-sections.php (from presets/tech/redux-sections.php)
│   │   ├── redux.json (from presets/tech/redux.json)
│   │   ├── redux-section-config.php (Tech specific)
│   │   ├── redux-repeater-defaults.php (Tech specific)
│   │   └── ... (all reset handlers)
│   └── ...
├── template-parts/ (from presets/tech/template-parts/)
├── assets/
│   └── preset/ (from presets/tech/assets/)
└── demo/ (from presets/tech/demo/)
```

## ⚡ تحسينات الأداء

### 1. إزالة Preset System Overhead
- ❌ لا يوجد `AlOmran_Preset_Loader` checks
- ❌ لا يوجد preset detection
- ❌ لا يوجد preset switching logic

### 2. تحميل الملفات فقط عند الحاجة
- ✅ تحميل Redux فقط في Admin
- ✅ تحميل Assets فقط في Frontend
- ✅ تحميل CPTs فقط عند الحاجة

### 3. تقليل حجم القالب
- ✅ كل قالب يحتوي فقط على ملفاته الخاصة
- ✅ لا توجد ملفات presets أخرى
- ✅ كود أبسط وأصغر

## 🔧 الصيانة المستقبلية

### تحديثات الملفات المشتركة

عند تحديث ملف مشترك (مثل `inc/seo/seo-core.php`):

1. تحديث الملف في القالب الأول
2. نسخ التغييرات للقالبين الآخرين
3. اختبار جميع القوالب

### إضافة ميزة جديدة

1. إضافة الميزة في القالب المطلوب فقط
2. إذا كانت مشتركة، إضافتها لجميع القوالب
3. توثيق التغييرات

## 📝 ملاحظات مهمة

1. **Redux Options**: كل قالب يستخدم `alomran_options` - يجب التأكد من عدم التعارض
2. **Database**: كل قالب مستقل - لا توجد مشاكل في قاعدة البيانات
3. **Plugins**: جميع القوالب تحتاج نفس الـ Plugins (Redux, ACF)
4. **Updates**: يجب تحديث جميع القوالب عند إصلاح bug مشترك

## ✅ Checklist النهائي

- [ ] نسخ احتياطي كامل
- [ ] تشغيل split-themes.php script
- [ ] تحديث functions.php لكل قالب
- [ ] تحديث redux-config.php لكل قالب
- [ ] تحديث templates
- [ ] تحديث assets loading
- [ ] إزالة preset system files
- [ ] اختبار Industrial theme
- [ ] اختبار Food theme
- [ ] اختبار Tech theme
- [ ] توثيق التغييرات

## 🎉 النتيجة النهائية

3 قوالب WordPress منفصلة تماماً:
- ✅ **أداء أعلى** - لا يوجد overhead من preset system
- ✅ **كود أبسط** - كل قالب مستقل
- ✅ **صيانة أسهل** - كل قالب منفصل
- ✅ **استقلالية كاملة** - كل قالب يعمل بشكل مستقل

