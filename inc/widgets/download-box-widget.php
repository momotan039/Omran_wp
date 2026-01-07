<?php
/**
 * Download Box Widget
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_register_download_box_widget() {
    register_widget('Alomran_Download_Box_Widget');
}
add_action('widgets_init', 'alomran_register_download_box_widget');

class Alomran_Download_Box_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'alomran_download_box_widget',
            __('صندوق التحميل', 'alomran'),
            array('description' => __('عرض ملفات قابلة للتحميل', 'alomran'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'الملفات القابلة للتحميل';
        $downloads_text = !empty($instance['downloads']) ? $instance['downloads'] : '';
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        if ($downloads_text) {
            $downloads = array_filter(array_map('trim', explode("\n", $downloads_text)));
            if (!empty($downloads)) {
                ?>
                <div class="alomran-download-box space-y-3">
                    <?php foreach ($downloads as $index => $download_line) : 
                        $parts = explode('|', $download_line, 2);
                        $file_url = trim($parts[0]);
                        $file_label = isset($parts[1]) ? trim($parts[1]) : basename($file_url);
                    ?>
                        <a href="<?php echo esc_url($file_url); ?>" target="_blank" class="flex items-center justify-between p-4 rounded-lg border transition group" style="background-color: var(--theme-gray-50); border-color: var(--theme-gray-200);" onmouseover="this.style.backgroundColor='var(--theme-gray-100)'" onmouseout="this.style.backgroundColor='var(--theme-gray-50)'">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                <span class="group-hover:text-primary transition" style="color: var(--theme-gray-700);"><?php echo esc_html($file_label); ?></span>
                            </div>
                            <svg class="w-5 h-5" style="color: var(--theme-gray-400);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php
            }
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'الملفات القابلة للتحميل';
        $downloads = !empty($instance['downloads']) ? $instance['downloads'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('downloads')); ?>"><?php _e('الملفات:', 'alomran'); ?></label>
            <textarea class="widefat" rows="6" id="<?php echo esc_attr($this->get_field_id('downloads')); ?>" name="<?php echo esc_attr($this->get_field_name('downloads')); ?>" placeholder="URL|Label"><?php echo esc_textarea($downloads); ?></textarea>
            <small><?php _e('صيغة: رابط_الملف|عنوان_الملف (كل ملف في سطر منفصل)', 'alomran'); ?></small>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['downloads'] = !empty($new_instance['downloads']) ? sanitize_textarea_field($new_instance['downloads']) : '';
        return $instance;
    }
}

