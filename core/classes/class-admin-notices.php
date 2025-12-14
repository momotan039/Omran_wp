<?php
/**
 * Core Admin Notices
 * 
 * Handles interactive admin notices for preset status
 * 
 * @package AlOmran
 * @subpackage Core
 */

if (!defined('ABSPATH')) {
    exit;
}

class AlOmran_Admin_Notices {
    
    /**
     * Initialize admin notices
     */
    public static function init() {
        // Only in admin
        if (!is_admin()) {
            return;
        }
        
        // Add admin notices
        add_action('admin_notices', array(__CLASS__, 'display_preset_notices'));
        
        // Enqueue admin scripts
        add_action('admin_enqueue_scripts', array(__CLASS__, 'enqueue_admin_scripts'));
    }
    
    
    /**
     * Render demo import notice
     * 
     * @param string $preset Preset name
     */
    private static function render_demo_notice($preset) {
        $preset_names = array(
            'industrial' => 'الصناعي',
            'food' => 'الطعام والمشروبات',
            'tech' => 'التكنولوجيا'
        );
        $preset_name = isset($preset_names[$preset]) ? $preset_names[$preset] : ucfirst($preset);
        $options_url = admin_url('admin.php?page=alomran-options&tab=theme_presets');
        
        ?>
        <div class="notice notice-info is-dismissible alomran-demo-notice" data-preset="<?php echo esc_attr($preset); ?>">
            <div class="alomran-notice-content" style="display: flex; align-items: center; padding: 15px;">
                <div style="flex: 1;">
                    <h3 style="margin: 0 0 10px 0; font-size: 16px; font-weight: 600;">
                        <?php printf(__('مرحباً بك في قالب %s!', 'alomran'), esc_html($preset_name)); ?>
                    </h3>
                    <p style="margin: 0 0 15px 0; font-size: 14px; line-height: 1.6;">
                        <?php _e('للبدء، ننصحك باستيراد المحتوى التجريبي والوسائط والإعدادات لهذا القالب. سيتم إعداد موقعك بمحتوى تجريبي وتكوينات جاهزة.', 'alomran'); ?>
                    </p>
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button type="button" class="button button-primary alomran-import-demo-btn" 
                                data-preset="<?php echo esc_attr($preset); ?>"
                                data-nonce="<?php echo esc_attr(wp_create_nonce('alomran_import_demo')); ?>">
                            <span class="dashicons dashicons-download" style="margin-top: 3px;"></span>
                            <?php _e('استيراد المحتوى التجريبي', 'alomran'); ?>
                        </button>
                        <a href="<?php echo esc_url($options_url); ?>" class="button">
                            <span class="dashicons dashicons-admin-generic" style="margin-top: 3px;"></span>
                            <?php _e('إعدادات القالب', 'alomran'); ?>
                        </a>
                    </div>
                </div>
                <div style="margin-left: 20px;">
                    <div class="alomran-notice-icon" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">
                        <span class="dashicons dashicons-admin-appearance"></span>
                    </div>
                </div>
            </div>
            <div class="alomran-import-progress" style="display: none; margin-top: 15px; padding-top: 15px; border-top: 1px solid #ddd;">
                <div class="alomran-progress-bar" style="height: 4px; background: #f0f0f0; border-radius: 2px; overflow: hidden;">
                    <div class="alomran-progress-fill" style="height: 100%; background: #2271b1; width: 0%; transition: width 0.3s;"></div>
                </div>
                <p class="alomran-progress-text" style="margin: 10px 0 0 0; font-size: 13px; color: #666;"></p>
            </div>
        </div>
        <?php
    }
    
    /**
     * Render generic notice
     * 
     * @param string $type Notice type (error, warning, info, success)
     * @param string $title Notice title
     * @param string $message Notice message
     */
    private static function render_notice($type, $title, $message) {
        ?>
        <div class="notice notice-<?php echo esc_attr($type); ?> is-dismissible">
            <p><strong><?php echo esc_html($title); ?>:</strong> <?php echo esc_html($message); ?></p>
        </div>
        <?php
    }
    
    /**
     * Display preset-related admin notices
     */
    public static function display_preset_notices() {
        // Only show to users who can manage options
        if (!current_user_can('manage_options')) {
            return;
        }
        
        $active_preset = AlOmran_Preset_Loader::get_active_preset();
        $preset_exists = AlOmran_Preset_Loader::preset_exists($active_preset);
        $demo_imported = AlOmran_Demo_Importer::is_demo_imported($active_preset);
        
        // Check if preset is inactive or missing
        if (!$preset_exists) {
            self::render_notice('error', __('القالب النشط غير موجود', 'alomran'), __('القالب المحدد غير موجود. يرجى اختيار قالب صالح.', 'alomran'));
            return;
        }
        
        // Check if demo is not imported
        if (!$demo_imported) {
            self::render_demo_notice($active_preset);
        }
    }
    
    /**
     * Enqueue admin scripts and styles
     * 
     * @param string $hook Current admin page hook
     */
    public static function enqueue_admin_scripts($hook) {
        // Only on relevant pages
        if (strpos($hook, 'alomran') === false && $hook !== 'dashboard') {
            return;
        }
        
        wp_enqueue_script(
            'alomran-admin-notices',
            ALOMRAN_THEME_URI . '/core/assets/js/admin-notices.js',
            array('jquery'),
            ALOMRAN_THEME_VERSION,
            true
        );
        
        wp_enqueue_style(
            'alomran-admin-notices',
            ALOMRAN_THEME_URI . '/core/assets/css/admin-notices.css',
            array(),
            ALOMRAN_THEME_VERSION
        );
        
        wp_localize_script('alomran-admin-notices', 'alomranAdmin', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('alomran_import_demo'),
            'strings' => array(
                'importing' => __('جاري الاستيراد...', 'alomran'),
                'success' => __('تم استيراد المحتوى التجريبي بنجاح!', 'alomran'),
                'error' => __('حدث خطأ أثناء الاستيراد.', 'alomran'),
                'importButton' => __('استيراد المحتوى التجريبي', 'alomran'),
            )
        ));
    }
}

