<?php
/**
 * Spec Table Widget
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_register_spec_table_widget() {
    register_widget('Alomran_Spec_Table_Widget');
}
add_action('widgets_init', 'alomran_register_spec_table_widget');

class Alomran_Spec_Table_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'alomran_spec_table_widget',
            __('جدول المواصفات', 'alomran'),
            array('description' => __('عرض جدول مواصفات قابل للتخصيص', 'alomran'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'المواصفات';
        $specs_text = !empty($instance['specs']) ? $instance['specs'] : '';
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        if ($specs_text) {
            $specs = alomran_parse_specs($specs_text);
            if (!empty($specs)) {
                ?>
                <div class="alomran-spec-table bg-white rounded-lg border border-gray-200 overflow-hidden">
                    <?php foreach ($specs as $spec) : ?>
                        <div class="flex justify-between py-3 px-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                            <span class="font-bold text-gray-700"><?php echo esc_html($spec['label']); ?></span>
                            <span class="text-gray-600 dir-ltr"><?php echo esc_html($spec['value']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php
            }
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : 'المواصفات';
        $specs = !empty($instance['specs']) ? $instance['specs'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('specs')); ?>"><?php _e('المواصفات:', 'alomran'); ?></label>
            <textarea class="widefat" rows="8" id="<?php echo esc_attr($this->get_field_id('specs')); ?>" name="<?php echo esc_attr($this->get_field_name('specs')); ?>" placeholder="التسمية: القيمة"><?php echo esc_textarea($specs); ?></textarea>
            <small><?php _e('أدخل كل مواصفة بصيغة: التسمية: القيمة (كل مواصفة في سطر منفصل)', 'alomran'); ?></small>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['specs'] = !empty($new_instance['specs']) ? sanitize_textarea_field($new_instance['specs']) : '';
        return $instance;
    }
}

