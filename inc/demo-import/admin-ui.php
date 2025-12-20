<?php
/**
 * Demo Import Admin UI
 * 
 * Provides a beautiful admin interface for one-click demo import
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add demo import admin page
 */
function omran_demo_add_admin_page() {
    add_submenu_page(
        'alomran-options',
        __('استيراد المحتوى التجريبي', 'alomran'),
        __('استيراد المحتوى التجريبي', 'alomran'),
        'manage_options',
        'alomran-demo-import',
        'omran_demo_admin_page'
    );
}
add_action('admin_menu', 'omran_demo_add_admin_page', 30);

/**
 * Demo import admin page content
 */
function omran_demo_admin_page() {
    if (!current_user_can('manage_options')) {
        wp_die(__('ليس لديك صلاحية للوصول إلى هذه الصفحة.', 'alomran'));
    }
    
    $current_preset = alomran_get_theme_preset();
    $is_imported = AlOmran_Demo_Importer::is_demo_imported($current_preset);
    
    wp_enqueue_script('jquery');
    ?>
    <div class="wrap omran-demo-import-wrap" dir="rtl">
        <h1><?php _e('استيراد المحتوى التجريبي', 'alomran'); ?></h1>
        <p class="description"><?php _e('استورد المحتوى التجريبي للقالب الصناعي بنقرة واحدة. يتضمن الصفحات والمنتجات والأخبار والقوائم والإعدادات.', 'alomran'); ?></p>
        
        <div class="omran-demo-import-container" style="max-width: 1200px; margin-top: 20px;">
            
            <!-- Current Preset Info -->
            <div class="card" style="background: linear-gradient(135deg, #2c5530 0%, #4a7c59 100%); color: white; padding: 25px; margin-bottom: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <h2 style="color: white; margin-top: 0;">
                    <span class="dashicons dashicons-admin-appearance" style="font-size: 24px; width: 24px; height: 24px; margin-left: 10px;"></span>
                    <?php echo esc_html(ucfirst($current_preset)); ?> - القالب الحالي
                </h2>
                <?php if ($is_imported) : ?>
                    <p style="margin-bottom: 0; font-size: 14px;">
                        <span class="dashicons dashicons-yes-alt" style="color: #4ade80; margin-left: 5px;"></span>
                        <?php _e('تم استيراد المحتوى التجريبي مسبقاً', 'alomran'); ?>
                    </p>
                <?php else : ?>
                    <p style="margin-bottom: 0; font-size: 14px;">
                        <span class="dashicons dashicons-info" style="margin-left: 5px;"></span>
                        <?php _e('لم يتم استيراد المحتوى التجريبي بعد', 'alomran'); ?>
                    </p>
                <?php endif; ?>
            </div>
            
            <!-- Import Button Card -->
            <div class="card" style="background: white; padding: 30px; margin-bottom: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 8px;">
                <h2 style="margin-top: 0;"><?php _e('استيراد المحتوى التجريبي', 'alomran'); ?></h2>
                <p><?php _e('انقر على الزر أدناه لاستيراد جميع المحتويات التجريبية للقالب الصناعي:', 'alomran'); ?></p>
                
                <div style="margin: 30px 0; display: flex; gap: 15px; flex-wrap: wrap;">
                    <button type="button" 
                            id="omran-demo-import-btn" 
                            class="button button-primary button-hero" 
                            data-preset="<?php echo esc_attr($current_preset); ?>"
                            style="font-size: 16px; padding: 15px 40px; height: auto; line-height: 1.5; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                        <span class="dashicons dashicons-download" style="font-size: 20px; width: 20px; height: 20px; margin-left: 8px; vertical-align: middle;"></span>
                        <?php _e('استيراد المحتوى التجريبي', 'alomran'); ?>
                    </button>
                    
                    <button type="button" 
                            id="omran-reset-menu-btn" 
                            class="button button-secondary" 
                            data-preset="<?php echo esc_attr($current_preset); ?>"
                            style="font-size: 14px; padding: 12px 25px; height: auto; line-height: 1.5; border-radius: 6px;">
                        <span class="dashicons dashicons-menu" style="font-size: 18px; width: 18px; height: 18px; margin-left: 6px; vertical-align: middle;"></span>
                        <?php _e('إعادة تعيين القوائم', 'alomran'); ?>
                    </button>
                    
                    <a href="<?php echo esc_url(admin_url('nav-menus.php')); ?>" 
                       class="button" 
                       style="font-size: 14px; padding: 12px 25px; height: auto; line-height: 1.5; border-radius: 6px; text-decoration: none;">
                        <span class="dashicons dashicons-admin-settings" style="font-size: 18px; width: 18px; height: 18px; margin-left: 6px; vertical-align: middle;"></span>
                        <?php _e('إدارة القوائم', 'alomran'); ?>
                    </a>
                </div>
                
                <!-- Menu Reset Success/Error Messages -->
                <div id="omran-menu-reset-success" style="display: none; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 6px; padding: 15px; margin-top: 15px; color: #155724;">
                    <span class="dashicons dashicons-yes-alt" style="color: #28a745; margin-left: 5px;"></span>
                    <span id="omran-menu-reset-success-message"></span>
                </div>
                
                <div id="omran-menu-reset-error" style="display: none; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 6px; padding: 15px; margin-top: 15px; color: #721c24;">
                    <span class="dashicons dashicons-warning" style="color: #dc3545; margin-left: 5px;"></span>
                    <span id="omran-menu-reset-error-message"></span>
                </div>
                
                <!-- Progress Container -->
                <div id="omran-demo-progress" style="display: none; margin-top: 20px;">
                    <div style="background: #f0f0f0; border-radius: 4px; padding: 20px; margin-bottom: 15px;">
                        <div id="omran-demo-progress-bar" style="background: #2c5530; height: 30px; border-radius: 4px; width: 0%; transition: width 0.3s ease; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                            <span id="omran-demo-progress-text">0%</span>
                        </div>
                    </div>
                    <div id="omran-demo-progress-messages" style="background: #f9f9f9; border-right: 4px solid #2c5530; padding: 15px; border-radius: 4px; max-height: 300px; overflow-y: auto;">
                        <p style="margin: 0; color: #666;">
                            <span class="dashicons dashicons-update" style="animation: spin 1s linear infinite; margin-left: 5px;"></span>
                            <?php _e('جاري التحضير...', 'alomran'); ?>
                        </p>
                    </div>
                </div>
                
                <!-- Success Message -->
                <div id="omran-demo-success" style="display: none; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 6px; padding: 20px; margin-top: 20px; color: #155724;">
                    <h3 style="margin-top: 0; color: #155724;">
                        <span class="dashicons dashicons-yes-alt" style="color: #28a745; margin-left: 10px;"></span>
                        <?php _e('تم الاستيراد بنجاح!', 'alomran'); ?>
                    </h3>
                    <div id="omran-demo-success-details"></div>
                    <p style="margin-bottom: 0;">
                        <a href="<?php echo esc_url(home_url()); ?>" class="button button-primary" target="_blank">
                            <?php _e('عرض الموقع', 'alomran'); ?>
                        </a>
                        <a href="<?php echo esc_url(admin_url('edit.php?post_type=product')); ?>" class="button">
                            <?php _e('عرض المنتجات', 'alomran'); ?>
                        </a>
                    </p>
                </div>
                
                <!-- Error Message -->
                <div id="omran-demo-error" style="display: none; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 6px; padding: 20px; margin-top: 20px; color: #721c24;">
                    <h3 style="margin-top: 0; color: #721c24;">
                        <span class="dashicons dashicons-warning" style="color: #dc3545; margin-left: 10px;"></span>
                        <?php _e('حدث خطأ أثناء الاستيراد', 'alomran'); ?>
                    </h3>
                    <div id="omran-demo-error-message"></div>
                </div>
            </div>
            
            <!-- What Will Be Imported -->
            <div class="card" style="background: white; padding: 25px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 8px;">
                <h2 style="margin-top: 0;">
                    <span class="dashicons dashicons-list-view" style="margin-left: 10px;"></span>
                    <?php _e('ما سيتم استيراده', 'alomran'); ?>
                </h2>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 15px; margin-top: 20px;">
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-right: 3px solid #2c5530;">
                        <strong style="display: block; margin-bottom: 5px;">
                            <span class="dashicons dashicons-admin-page" style="margin-left: 5px;"></span>
                            <?php _e('الصفحات', 'alomran'); ?>
                        </strong>
                        <span style="color: #666; font-size: 14px;">5 صفحات (من نحن، اتصل بنا، إلخ)</span>
                    </div>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-right: 3px solid #4a7c59;">
                        <strong style="display: block; margin-bottom: 5px;">
                            <span class="dashicons dashicons-products" style="margin-left: 5px;"></span>
                            <?php _e('المنتجات', 'alomran'); ?>
                        </strong>
                        <span style="color: #666; font-size: 14px;">4 منتجات مع فئات</span>
                    </div>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-right: 3px solid #f97316;">
                        <strong style="display: block; margin-bottom: 5px;">
                            <span class="dashicons dashicons-megaphone" style="margin-left: 5px;"></span>
                            <?php _e('الأخبار', 'alomran'); ?>
                        </strong>
                        <span style="color: #666; font-size: 14px;">3 أخبار مع فئات</span>
                    </div>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-right: 3px solid #2c5530;">
                        <strong style="display: block; margin-bottom: 5px;">
                            <span class="dashicons dashicons-format-quote" style="margin-left: 5px;"></span>
                            <?php _e('الشهادات', 'alomran'); ?>
                        </strong>
                        <span style="color: #666; font-size: 14px;">3 شهادات عملاء</span>
                    </div>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-right: 3px solid #4a7c59;">
                        <strong style="display: block; margin-bottom: 5px;">
                            <span class="dashicons dashicons-editor-help" style="margin-left: 5px;"></span>
                            <?php _e('الأسئلة الشائعة', 'alomran'); ?>
                        </strong>
                        <span style="color: #666; font-size: 14px;">5 أسئلة شائعة</span>
                    </div>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-right: 3px solid #f97316;">
                        <strong style="display: block; margin-bottom: 5px;">
                            <span class="dashicons dashicons-menu" style="margin-left: 5px;"></span>
                            <?php _e('القوائم', 'alomran'); ?>
                        </strong>
                        <span style="color: #666; font-size: 14px;">2 قوائم (رئيسية وتذييل)</span>
                    </div>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-right: 3px solid #2c5530;">
                        <strong style="display: block; margin-bottom: 5px;">
                            <span class="dashicons dashicons-admin-settings" style="margin-left: 5px;"></span>
                            <?php _e('إعدادات Redux', 'alomran'); ?>
                        </strong>
                        <span style="color: #666; font-size: 14px;">إعدادات القالب الكاملة</span>
                    </div>
                    <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-right: 3px solid #4a7c59;">
                        <strong style="display: block; margin-bottom: 5px;">
                            <span class="dashicons dashicons-images-alt2" style="margin-left: 5px;"></span>
                            <?php _e('الوسائط', 'alomran'); ?>
                        </strong>
                        <span style="color: #666; font-size: 14px;">الصور والملفات (إن وجدت)</span>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <style>
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .omran-demo-import-wrap .card {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .omran-demo-import-wrap .button-hero:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        
        #omran-demo-progress-messages p {
            margin: 5px 0;
            padding: 8px;
            background: white;
            border-radius: 4px;
        }
        
        #omran-demo-progress-messages p.success {
            background: #d4edda;
            color: #155724;
        }
        
        #omran-demo-progress-messages p.error {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
    
    <script>
    jQuery(document).ready(function($) {
        var importBtn = $('#omran-demo-import-btn');
        var progressContainer = $('#omran-demo-progress');
        var progressBar = $('#omran-demo-progress-bar');
        var progressText = $('#omran-demo-progress-text');
        var progressMessages = $('#omran-demo-progress-messages');
        var successContainer = $('#omran-demo-success');
        var errorContainer = $('#omran-demo-error');
        var errorMessage = $('#omran-demo-error-message');
        var successDetails = $('#omran-demo-success-details');
        
        var steps = [
            { name: 'جاري استيراد إعدادات Redux...', progress: 10 },
            { name: 'جاري إنشاء الصفحات...', progress: 25 },
            { name: 'جاري إنشاء فئات المنتجات...', progress: 35 },
            { name: 'جاري إنشاء المنتجات...', progress: 45 },
            { name: 'جاري إنشاء فئات الأخبار...', progress: 55 },
            { name: 'جاري إنشاء الأخبار...', progress: 65 },
            { name: 'جاري إنشاء الشهادات...', progress: 75 },
            { name: 'جاري إنشاء الأسئلة الشائعة...', progress: 80 },
            { name: 'جاري إنشاء القوائم...', progress: 85 },
            { name: 'جاري استيراد الوسائط...', progress: 90 },
            { name: 'جاري الانتهاء...', progress: 100 }
        ];
        
        var currentStep = 0;
        
        function addProgressMessage(message, type) {
            var className = type || '';
            var icon = '';
            if (type === 'success') {
                icon = '<span class="dashicons dashicons-yes-alt" style="color: #28a745; margin-left: 5px;"></span>';
            } else if (type === 'error') {
                icon = '<span class="dashicons dashicons-warning" style="color: #dc3545; margin-left: 5px;"></span>';
            } else {
                icon = '<span class="dashicons dashicons-update" style="animation: spin 1s linear infinite; margin-left: 5px;"></span>';
            }
            
            progressMessages.append('<p class="' + className + '">' + icon + ' ' + message + '</p>');
            progressMessages.scrollTop(progressMessages[0].scrollHeight);
        }
        
        function updateProgress(progress, message) {
            progressBar.css('width', progress + '%');
            progressText.text(progress + '%');
            if (message) {
                addProgressMessage(message);
            }
        }
        
        function showStep(stepIndex) {
            if (stepIndex < steps.length) {
                var step = steps[stepIndex];
                updateProgress(step.progress, step.name);
                currentStep = stepIndex;
            }
        }
        
        importBtn.on('click', function() {
            if (!confirm('هل أنت متأكد من استيراد المحتوى التجريبي؟ سيتم إنشاء صفحات ومنتجات وأخبار جديدة.')) {
                return;
            }
            
            var preset = $(this).data('preset');
            
            // Reset UI
            importBtn.prop('disabled', true).text('جاري الاستيراد...');
            progressContainer.show();
            successContainer.hide();
            errorContainer.hide();
            progressMessages.html('');
            currentStep = 0;
            
            // Start progress animation
            showStep(0);
            
            // Prepare form data
            var formData = new FormData();
            formData.append('action', 'alomran_import_demo');
            formData.append('preset', preset);
            formData.append('import_content', '1');
            formData.append('import_media', '1');
            formData.append('import_redux', '1');
            formData.append('import_menus', '1');
            formData.append('overwrite', '0');
            formData.append('nonce', '<?php echo wp_create_nonce('alomran_import_demo'); ?>');
            
            // Simulate progress updates
            var progressInterval = setInterval(function() {
                if (currentStep < steps.length - 1) {
                    showStep(currentStep + 1);
                }
            }, 500);
            
            // Make AJAX request
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    clearInterval(progressInterval);
                    updateProgress(100, 'اكتمل الاستيراد بنجاح!');
                    
                    if (response.success) {
                        // Show success message
                        var details = '<ul style="list-style: disc; margin-right: 20px; margin-top: 10px;">';
                        if (response.data && response.data.results) {
                            if (response.data.results.content && response.data.results.content.details) {
                                var content = response.data.results.content.details;
                                if (content.pages) details += '<li>' + content.pages + ' صفحات</li>';
                                if (content.products) details += '<li>' + content.products + ' منتجات</li>';
                                if (content.news) details += '<li>' + content.news + ' أخبار</li>';
                                if (content.testimonials) details += '<li>' + content.testimonials + ' شهادات</li>';
                                if (content.faqs) details += '<li>' + content.faqs + ' أسئلة شائعة</li>';
                                if (content.menus) details += '<li>' + content.menus + ' قوائم</li>';
                            }
                        }
                        details += '</ul>';
                        successDetails.html(details);
                        
                        setTimeout(function() {
                            progressContainer.hide();
                            successContainer.show();
                            importBtn.prop('disabled', false).html('<span class="dashicons dashicons-download" style="font-size: 20px; width: 20px; height: 20px; margin-left: 8px; vertical-align: middle;"></span> استيراد المحتوى التجريبي');
                        }, 1000);
                    } else {
                        throw new Error(response.data ? response.data.message : 'خطأ غير معروف');
                    }
                },
                error: function(xhr, status, error) {
                    clearInterval(progressInterval);
                    var errorMsg = 'حدث خطأ أثناء الاستيراد.';
                    if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
                        errorMsg = xhr.responseJSON.data.message;
                    }
                    
                    updateProgress(0, 'فشل الاستيراد');
                    addProgressMessage(errorMsg, 'error');
                    
                    setTimeout(function() {
                        progressContainer.hide();
                        errorContainer.show();
                        errorMessage.html('<p>' + errorMsg + '</p>');
                        importBtn.prop('disabled', false).html('<span class="dashicons dashicons-download" style="font-size: 20px; width: 20px; height: 20px; margin-left: 8px; vertical-align: middle;"></span> استيراد المحتوى التجريبي');
                    }, 1000);
                }
            });
        });
        
        // Menu Reset Handler
        var resetMenuBtn = $('#omran-reset-menu-btn');
        var menuResetSuccess = $('#omran-menu-reset-success');
        var menuResetError = $('#omran-menu-reset-error');
        var menuResetSuccessMsg = $('#omran-menu-reset-success-message');
        var menuResetErrorMsg = $('#omran-menu-reset-error-message');
        
        resetMenuBtn.on('click', function() {
            if (!confirm('هل أنت متأكد من إعادة تعيين القوائم؟ سيتم حذف جميع عناصر القوائم الحالية (القائمة الرئيسية وقائمة التذييل) واستيراد القوائم التجريبية.')) {
                return;
            }
            
            var preset = $(this).data('preset');
            
            // Reset UI
            resetMenuBtn.prop('disabled', true).text('جاري إعادة التعيين...');
            menuResetSuccess.hide();
            menuResetError.hide();
            
            // Make AJAX request
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'alomran_reset_menu',
                    preset: preset,
                    nonce: '<?php echo wp_create_nonce('alomran_reset_menu'); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        menuResetSuccessMsg.text(response.data.message || 'تم إعادة تعيين القائمة بنجاح');
                        menuResetSuccess.show();
                        
                        // Reload page after 2 seconds to show updated menu
                        setTimeout(function() {
                            window.location.reload();
                        }, 2000);
                    } else {
                        menuResetErrorMsg.text(response.data.message || 'حدث خطأ أثناء إعادة تعيين القائمة');
                        menuResetError.show();
                        resetMenuBtn.prop('disabled', false).html('<span class="dashicons dashicons-menu" style="font-size: 18px; width: 18px; height: 18px; margin-left: 6px; vertical-align: middle;"></span> إعادة تعيين القائمة');
                    }
                },
                error: function(xhr, status, error) {
                    var errorMsg = 'حدث خطأ أثناء إعادة تعيين القائمة.';
                    if (xhr.responseJSON && xhr.responseJSON.data && xhr.responseJSON.data.message) {
                        errorMsg = xhr.responseJSON.data.message;
                    }
                    
                    menuResetErrorMsg.text(errorMsg);
                    menuResetError.show();
                    resetMenuBtn.prop('disabled', false).html('<span class="dashicons dashicons-menu" style="font-size: 18px; width: 18px; height: 18px; margin-left: 6px; vertical-align: middle;"></span> إعادة تعيين القائمة');
                }
            });
        });
    });
    </script>
    <?php
}

