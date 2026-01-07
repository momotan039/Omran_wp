# Redux Configuration Structure

تم تقسيم ملف `redux-config.php` الكبير إلى عدة ملفات منطقية باستخدام مبدأ DRY وأفضل الممارسات.

## هيكل الملفات

### الملف الرئيسي
- **`redux-config.php`** - الملف الرئيسي الذي يقوم بتحميل جميع الوحدات وإعداد Redux الأساسي
- **`redux-loader.php`** - محمل مركزي للوحدات مع إدارة التبعيات (Dependency Management)

### الوحدات (Modules)

#### 1. إعدادات الأقسام
- **`redux-section-config.php`** - إعدادات موحدة لجميع أقسام Tech preset
  - `alomran_get_tech_sections_config()` - إعدادات جميع الأقسام
  - `alomran_get_tech_section_to_field_map()` - ربط القسم بالحقل
  - `alomran_get_tech_field_to_section_map()` - ربط الحقل بالقسم
  - `alomran_get_tech_homepage_sections()` - أقسام الصفحة الرئيسية فقط
  - `alomran_get_tech_page_sections()` - أقسام الصفحات فقط
  - `alomran_get_tech_tab_to_section_map()` - ربط Tab بالأقسام
  - `alomran_get_tech_homepage_tab_to_section_map()` - ربط Tab بأقسام الصفحة الرئيسية

#### 2. القيم الافتراضية
- **`redux-repeater-defaults.php`** - القيم الافتراضية لجميع حقول Repeater
  - `alomran_get_tech_repeater_defaults()` - القيم الافتراضية لجميع الحقول

#### 3. دوال مساعدة Reset
- **`redux-reset-helpers.php`** - دوال مساعدة مشتركة لعمليات Reset
  - `alomran_detect_reset_operation()` - اكتشاف عملية Reset
  - `alomran_get_homepage_section_from_tab()` - الحصول على القسم من Tab
  - `alomran_detect_homepage_section_from_post()` - اكتشاف القسم من POST
  - `alomran_clear_redux_caches()` - مسح الكاش
  - `alomran_remove_field_from_post()` - إزالة حقل من POST
  - `alomran_clear_reset_section_cookie()` - مسح Cookie

#### 4. معالجات Reset
- **`redux-reset-handlers.php`** - جميع معالجات عمليات Reset
  - `alomran_backup_repeater_data_before_reset()` - نسخ احتياطي قبل Reset
  - `alomran_restore_repeater_defaults_on_section_reset()` - استعادة القيم الافتراضية
  - `alomran_handle_redux_section_reset()` - معالجة Reset القسم
  - `alomran_ultra_fast_reset_repeater()` - Reset سريع مباشر
  - `alomran_ensure_repeater_defaults_restored_after_section_reset()` - التأكد من استعادة القيم

#### 5. الترجمة
- **`redux-translations.php`** - ترجمة واجهة Redux للعربية
  - `alomran_redux_arabic_translations()` - ترجمة النصوص
  - `alomran_redux_arabic_js_translations()` - ترجمة JavaScript

#### 6. معالجات JavaScript
- **`redux-js-handlers.php`** - كود JavaScript لمعالجة Reset والحفاظ على Preset
  - كود jQuery لمعالجة Reset Section
  - كود للحفاظ على theme_preset عند Reset All

#### 7. الحفاظ على Preset
- **`redux-preset-preservation.php`** - الحفاظ على theme_preset عند Reset
  - `alomran_preserve_theme_preset_on_reset()` - الحفاظ على Preset عند Reset
  - `alomran_restore_theme_preset_after_reset()` - استعادة Preset بعد Reset

#### 8. الحفاظ على القيم
- **`redux-value-preservation.php`** - الحفاظ على قيم Redux عند تعطيل الأقسام
  - `alomran_preserve_redux_values()` - الحفاظ على القيم
  - `alomran_restore_redux_values_after_save()` - استعادة القيم بعد الحفظ
  - `alomran_backup_redux_values_before_save()` - نسخ احتياطي قبل الحفظ

#### 9. حماية Frontend
- **`redux-frontend-protection.php`** - منع تحميل Redux على Frontend
  - حجب جميع فلاتر Redux على Frontend
  - منع تحميل CSS/JS على صفحات العملاء

## مبادئ التصميم

### 1. DRY (Don't Repeat Yourself)
- تم توحيد جميع دوال الكشف عن Reset في دالة واحدة `alomran_detect_reset_operation()`
- تم توحيد جميع دوال مسح الكاش في دالة واحدة `alomran_clear_redux_caches()`
- تم توحيد جميع دوال إزالة الحقول من POST في دالة واحدة `alomran_remove_field_from_post()`

### 2. Single Source of Truth
- `alomran_get_tech_sections_config()` هو المصدر الوحيد لإعدادات الأقسام
- `alomran_get_tech_repeater_defaults()` هو المصدر الوحيد للقيم الافتراضية

### 3. Separation of Concerns
- كل ملف له مسؤولية واحدة واضحة
- الملفات منفصلة ومنطقية
- سهولة الصيانة والتطوير

### 4. Maintainability
- الكود منظم وواضح
- سهولة إضافة أقسام جديدة
- سهولة تعديل القيم الافتراضية

## كيفية الاستخدام

جميع الملفات يتم تحميلها تلقائياً من `redux-config.php` عبر `redux-loader.php`، لا حاجة لتحميلها يدوياً.

### ترتيب التحميل (Loading Order)

الملفات يتم تحميلها حسب المجموعات التالية لضمان تحميل التبعيات أولاً:

1. **المجموعة 1**: Configuration & Defaults (لا تعتمد على شيء)
   - `redux-section-config.php`
   - `redux-repeater-defaults.php`

2. **المجموعة 2**: Helper Functions (تعتمد على المجموعة 1)
   - `redux-reset-helpers.php`

3. **المجموعة 3**: Handlers (تعتمد على المجموعات 1 و 2)
   - `redux-reset-handlers.php`
   - `redux-preset-preservation.php`
   - `redux-value-preservation.php`

4. **المجموعة 4**: Translations & UI (مستقلة)
   - `redux-translations.php`

5. **المجموعة 5**: Frontend Protection (يجب تحميلها أخيراً)
   - `redux-frontend-protection.php`

### إضافة قسم جديد

1. أضف القسم في `alomran_get_tech_sections_config()` في `redux-section-config.php`
2. أضف القيم الافتراضية في `alomran_get_tech_repeater_defaults()` في `redux-repeater-defaults.php`
3. أضف التخطيط في `redux-js-handlers.php` في دالة `detectSectionIdFromButton()`

### تعديل القيم الافتراضية

عدّل فقط في `alomran_get_tech_repeater_defaults()` في `redux-repeater-defaults.php`

## ملاحظات

- جميع الملفات محمية بـ `if (!defined('ABSPATH'))`
- جميع الملفات تستخدم namespace functions مع prefix `alomran_`
- الكود متوافق مع WordPress Coding Standards

