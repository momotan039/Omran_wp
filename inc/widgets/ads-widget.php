<?php
/**
 * Ads Widget
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Ads Widget
 */
function alomran_register_ads_widget() {
    register_widget('Alomran_Ads_Widget');
}
add_action('widgets_init', 'alomran_register_ads_widget');

/**
 * Ads Widget Class
 */
class Alomran_Ads_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'alomran_ads_widget',
            __('إعلان مخصص', 'alomran'),
            array(
                'description' => __('عرض إعلان مخصص أو كود AdSense', 'alomran'),
            )
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $ad_code = !empty($instance['ad_code']) ? $instance['ad_code'] : '';
        
        // If no custom code, use global widget ad code
        if (empty($ad_code)) {
            $ad_code = alomran_get_widget_ad_code();
        }
        
        if (empty($ad_code)) {
            return;
        }
        
        echo $args['before_widget'];
        
        if (!empty($title)) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        echo '<div class="alomran-ad-widget">';
        echo $ad_code;
        echo '</div>';
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $ad_code = !empty($instance['ad_code']) ? $instance['ad_code'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php _e('العنوان:', 'alomran'); ?>
            </label>
            <input class="widefat" 
                   id="<?php echo esc_attr($this->get_field_id('title')); ?>" 
                   name="<?php echo esc_attr($this->get_field_name('title')); ?>" 
                   type="text" 
                   value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('ad_code')); ?>">
                <?php _e('كود الإعلان (HTML/JS):', 'alomran'); ?>
            </label>
            <textarea class="widefat" 
                      rows="8" 
                      id="<?php echo esc_attr($this->get_field_id('ad_code')); ?>" 
                      name="<?php echo esc_attr($this->get_field_name('ad_code')); ?>"><?php echo esc_textarea($ad_code); ?></textarea>
            <small><?php _e('اتركه فارغاً لاستخدام كود الإعلان الافتراضي من إعدادات الموقع', 'alomran'); ?></small>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['ad_code'] = !empty($new_instance['ad_code']) ? $new_instance['ad_code'] : '';
        return $instance;
    }
}

