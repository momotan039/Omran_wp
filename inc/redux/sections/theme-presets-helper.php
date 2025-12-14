<?php
/**
 * Helper functions for theme presets section
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Render demo import button in Redux panel
 * 
 * @return string HTML content
 */
function alomran_render_demo_import_button() {
    if (!current_user_can('manage_options')) {
        return '';
    }
    
    $current_preset = alomran_get_theme_preset();
    $demo_imported = function_exists('AlOmran_Demo_Importer') ? AlOmran_Demo_Importer::is_demo_imported($current_preset) : false;
    
    ob_start();
    ?>
    <div class="alomran-demo-import-wrapper" style="padding: 20px; background: #f9f9f9; border: 1px solid #ddd; border-radius: 4px; margin: 15px 0;">
        <h3 style="margin-top: 0;"><?php _e('استيراد المحتوى التجريبي', 'alomran'); ?></h3>
        <p style="margin-bottom: 15px;">
            <?php _e('استورد المحتوى التجريبي والإعدادات الجاهزة للقالب المحدد. يتضمن هذا: المحتوى، الوسائط، القوائم، والإعدادات.', 'alomran'); ?>
        </p>
        
        <?php if ($demo_imported) : ?>
            <div class="notice notice-success inline" style="margin: 0 0 15px 0;">
                <p><?php _e('✓ تم استيراد المحتوى التجريبي مسبقاً', 'alomran'); ?></p>
            </div>
        <?php endif; ?>
        
        <button type="button" 
                class="button button-primary alomran-import-demo-btn-redux" 
                data-preset="<?php echo esc_attr($current_preset); ?>"
                data-nonce="<?php echo esc_attr(wp_create_nonce('alomran_import_demo')); ?>"
                style="margin-right: 10px;">
            <span class="dashicons dashicons-download" style="margin-top: 3px;"></span>
            <?php _e('استيراد المحتوى التجريبي', 'alomran'); ?>
        </button>
        
        <div class="alomran-import-progress-redux" style="display: none; margin-top: 15px;">
            <div class="alomran-progress-bar" style="height: 4px; background: #f0f0f0; border-radius: 2px; overflow: hidden;">
                <div class="alomran-progress-fill" style="height: 100%; background: #2271b1; width: 0%; transition: width 0.3s;"></div>
            </div>
            <p class="alomran-progress-text" style="margin: 10px 0 0 0; font-size: 13px; color: #666;"></p>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('.alomran-import-demo-btn-redux').on('click', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $wrapper = $button.closest('.alomran-demo-import-wrapper');
            var $progress = $wrapper.find('.alomran-import-progress-redux');
            var $progressFill = $wrapper.find('.alomran-progress-fill');
            var $progressText = $wrapper.find('.alomran-progress-text');
            var preset = $button.data('preset');
            var nonce = $button.data('nonce');
            
            if (!confirm('<?php echo esc_js(__('هل تريد استيراد بيانات القالب؟ سيتم تحديث إعدادات الموقع الحالية.', 'alomran')); ?>')) {
                return;
            }
            
            $button.prop('disabled', true);
            $button.html('<span class="dashicons dashicons-update spin" style="margin-top: 3px;"></span> <?php echo esc_js(__('جاري الاستيراد...', 'alomran')); ?>');
            
            $progress.show();
            $progressFill.css('width', '10%');
            $progressText.text('<?php echo esc_js(__('جاري التحضير...', 'alomran')); ?>');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'alomran_import_demo',
                    preset: preset,
                    import_content: true,
                    import_media: true,
                    import_redux: true,
                    import_menus: true,
                    overwrite: false,
                    nonce: nonce
                },
                success: function(response) {
                    if (response.success) {
                        $progressFill.css('width', '100%');
                        $progressText.text('<?php echo esc_js(__('تم الاستيراد بنجاح!', 'alomran')); ?>');
                        $button.html('<span class="dashicons dashicons-yes" style="margin-top: 3px; color: #46b450;"></span> <?php echo esc_js(__('تم الاستيراد', 'alomran')); ?>');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        $progressFill.css('width', '0%');
                        $progressText.text(response.data && response.data.message ? response.data.message : '<?php echo esc_js(__('حدث خطأ', 'alomran')); ?>');
                        $button.prop('disabled', false);
                        $button.html('<span class="dashicons dashicons-download" style="margin-top: 3px;"></span> <?php echo esc_js(__('استيراد المحتوى التجريبي', 'alomran')); ?>');
                    }
                },
                error: function() {
                    $progressFill.css('width', '0%');
                    $progressText.text('<?php echo esc_js(__('حدث خطأ أثناء الاستيراد', 'alomran')); ?>');
                    $button.prop('disabled', false);
                    $button.html('<span class="dashicons dashicons-download" style="margin-top: 3px;"></span> <?php echo esc_js(__('استيراد المحتوى التجريبي', 'alomran')); ?>');
                }
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}

