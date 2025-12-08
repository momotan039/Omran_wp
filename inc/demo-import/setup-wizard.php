<?php
/**
 * Setup Wizard
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add setup wizard page to admin menu
 */
function alomran_add_setup_wizard_page() {
    add_submenu_page(
        'alomran-options',
        'معالج الإعداد السريع',
        'معالج الإعداد',
        'manage_options',
        'alomran-setup-wizard',
        'alomran_setup_wizard_page'
    );
}
add_action('admin_menu', 'alomran_add_setup_wizard_page', 20);

/**
 * Setup wizard page content
 */
function alomran_setup_wizard_page() {
    if (!current_user_can('manage_options')) {
        wp_die('غير مصرح');
    }
    
    $current_preset = alomran_get_theme_preset();
    ?>
    <div class="wrap">
        <h1><?php _e('معالج الإعداد السريع', 'alomran'); ?></h1>
        <p class="description"><?php _e('قم بإعداد الموقع بسرعة باستخدام هذا المعالج', 'alomran'); ?></p>
        
        <div class="alomran-setup-wizard" style="max-width: 800px; margin-top: 20px;">
            <!-- Step 1: Theme Preset -->
            <div class="card" style="background: white; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2><?php _e('الخطوة 1: اختر قالب التصميم', 'alomran'); ?></h2>
                <div class="preset-selector" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-top: 20px;">
                    <?php
                    $presets = array('industrial', 'food', 'tech');
                    foreach ($presets as $preset) :
                        $demo_data = alomran_get_demo_data($preset);
                        $is_selected = $current_preset === $preset;
                    ?>
                        <div class="preset-option" style="border: 2px solid <?php echo $is_selected ? '#0073aa' : '#ddd'; ?>; padding: 15px; border-radius: 8px; cursor: pointer; text-align: center; transition: all 0.3s;" 
                             data-preset="<?php echo esc_attr($preset); ?>"
                             onclick="alomranSelectPreset('<?php echo esc_js($preset); ?>')">
                            <div style="width: 100%; height: 120px; background: linear-gradient(135deg, <?php echo esc_attr($demo_data['colors']['primary']); ?>, <?php echo esc_attr($demo_data['colors']['secondary']); ?>); border-radius: 4px; margin-bottom: 10px;"></div>
                            <h3 style="margin: 0;"><?php echo esc_html($demo_data['name']); ?></h3>
                            <?php if ($is_selected) : ?>
                                <p style="color: #0073aa; font-weight: bold; margin: 5px 0 0;">✓ مختار</p>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <button type="button" class="button button-primary" onclick="alomranImportDemo('<?php echo esc_js($current_preset); ?>')" style="margin-top: 20px;">
                    <?php _e('استيراد بيانات القالب', 'alomran'); ?>
                </button>
            </div>
            
            <!-- Step 2: Quick Settings -->
            <div class="card" style="background: white; padding: 20px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2><?php _e('الخطوة 2: الإعدادات السريعة', 'alomran'); ?></h2>
                <p><?php _e('يمكنك تعديل هذه الإعدادات لاحقاً من صفحة إعدادات الموقع', 'alomran'); ?></p>
                <p>
                    <a href="<?php echo admin_url('admin.php?page=alomran-options'); ?>" class="button">
                        <?php _e('فتح إعدادات الموقع', 'alomran'); ?>
                    </a>
                </p>
            </div>
            
            <!-- Step 3: Next Steps -->
            <div class="card" style="background: white; padding: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2><?php _e('الخطوة 3: الخطوات التالية', 'alomran'); ?></h2>
                <ul style="list-style: disc; margin-right: 20px;">
                    <li><?php _e('قم بإضافة منتجاتك من قسم المنتجات', 'alomran'); ?></li>
                    <li><?php _e('أضف صفحات من نحن واتصل بنا', 'alomran'); ?></li>
                    <li><?php _e('قم بتخصيص الألوان والخطوط من إعدادات الموقع', 'alomran'); ?></li>
                    <li><?php _e('أضف القوائم من المظهر → القوائم', 'alomran'); ?></li>
                </ul>
            </div>
        </div>
    </div>
    
    <script>
    function alomranSelectPreset(preset) {
        // Update UI
        document.querySelectorAll('.preset-option').forEach(function(el) {
            el.style.borderColor = '#ddd';
            el.querySelector('p') && el.querySelector('p').remove();
        });
        
        var selected = document.querySelector('[data-preset="' + preset + '"]');
        if (selected) {
            selected.style.borderColor = '#0073aa';
            var p = document.createElement('p');
            p.style.cssText = 'color: #0073aa; font-weight: bold; margin: 5px 0 0;';
            p.textContent = '✓ مختار';
            selected.appendChild(p);
        }
    }
    
    function alomranImportDemo(preset) {
        if (!confirm('هل تريد استيراد بيانات القالب؟ سيتم تحديث إعدادات الموقع الحالية.')) {
            return;
        }
        
        var button = event.target;
        button.disabled = true;
        button.textContent = 'جاري الاستيراد...';
        
        var formData = new FormData();
        formData.append('action', 'alomran_import_demo');
        formData.append('preset', preset);
        formData.append('nonce', '<?php echo wp_create_nonce('alomran_import_demo'); ?>');
        
        fetch(ajaxurl, {
            method: 'POST',
            body: formData
        })
        .then(function(response) {
            return response.json();
        })
        .then(function(data) {
            if (data.success) {
                alert(data.data.message);
                location.reload();
            } else {
                alert('حدث خطأ: ' + (data.data ? data.data.message : 'خطأ غير معروف'));
                button.disabled = false;
                button.textContent = 'استيراد بيانات القالب';
            }
        })
        .catch(function(error) {
            alert('حدث خطأ: ' + error);
            button.disabled = false;
            button.textContent = 'استيراد بيانات القالب';
        });
    }
    </script>
    <?php
}

/**
 * Handle demo import AJAX request
 */
function alomran_handle_demo_import_ajax() {
    check_ajax_referer('alomran_import_demo', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error(array('message' => 'غير مصرح'));
    }
    
    $preset = isset($_POST['preset']) ? sanitize_text_field($_POST['preset']) : 'industrial';
    
    $result = alomran_import_demo_data($preset);
    
    if ($result['success']) {
        wp_send_json_success($result);
    } else {
        wp_send_json_error($result);
    }
}
add_action('wp_ajax_alomran_import_demo', 'alomran_handle_demo_import_ajax');

