<?php
/**
 * Clients Grid Widget
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_register_clients_grid_widget() {
    register_widget('Alomran_Clients_Grid_Widget');
}
add_action('widgets_init', 'alomran_register_clients_grid_widget');

class Alomran_Clients_Grid_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'alomran_clients_grid_widget',
            __('شبكة العملاء', 'alomran'),
            array('description' => __('عرض شعارات العملاء في شبكة', 'alomran'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $clients_text = !empty($instance['clients']) ? $instance['clients'] : '';
        $columns = !empty($instance['columns']) ? absint($instance['columns']) : 4;
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        if ($clients_text) {
            $clients = array_filter(array_map('trim', explode("\n", $clients_text)));
            if (!empty($clients)) {
                $grid_class = 'grid-cols-' . $columns;
                ?>
                <div class="alomran-clients-grid grid <?php echo esc_attr($grid_class); ?> gap-6">
                    <?php foreach ($clients as $client_line) : 
                        $parts = explode('|', $client_line, 2);
                        $logo_url = trim($parts[0]);
                        $client_url = isset($parts[1]) ? trim($parts[1]) : '#';
                        if (empty($logo_url)) continue;
                    ?>
                        <a href="<?php echo esc_url($client_url); ?>" target="_blank" class="flex items-center justify-center p-4 rounded-lg hover:border-primary hover:shadow-md transition group" style="background-color: var(--theme-white); border-color: var(--theme-gray-200);">
                            <img src="<?php echo esc_url($logo_url); ?>" alt="" class="max-w-full max-h-16 object-contain opacity-60 group-hover:opacity-100 transition">
                        </a>
                    <?php endforeach; ?>
                </div>
                <?php
            }
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $clients = !empty($instance['clients']) ? $instance['clients'] : '';
        $columns = !empty($instance['columns']) ? absint($instance['columns']) : 4;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('clients')); ?>"><?php _e('شعارات العملاء:', 'alomran'); ?></label>
            <textarea class="widefat" rows="8" id="<?php echo esc_attr($this->get_field_id('clients')); ?>" name="<?php echo esc_attr($this->get_field_name('clients')); ?>" placeholder="LogoURL|ClientURL"><?php echo esc_textarea($clients); ?></textarea>
            <small><?php _e('صيغة: رابط_الشعار|رابط_العميل (كل عميل في سطر منفصل)', 'alomran'); ?></small>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns')); ?>"><?php _e('عدد الأعمدة:', 'alomran'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('columns')); ?>" name="<?php echo esc_attr($this->get_field_name('columns')); ?>">
                <option value="2" <?php selected($columns, 2); ?>>2</option>
                <option value="3" <?php selected($columns, 3); ?>>3</option>
                <option value="4" <?php selected($columns, 4); ?>>4</option>
                <option value="5" <?php selected($columns, 5); ?>>5</option>
                <option value="6" <?php selected($columns, 6); ?>>6</option>
            </select>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['clients'] = !empty($new_instance['clients']) ? sanitize_textarea_field($new_instance['clients']) : '';
        $instance['columns'] = !empty($new_instance['columns']) ? absint($new_instance['columns']) : 4;
        return $instance;
    }
}

