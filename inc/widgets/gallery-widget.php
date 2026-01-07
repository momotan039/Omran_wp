<?php
/**
 * Gallery Widget
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_register_gallery_widget() {
    register_widget('Alomran_Gallery_Widget');
}
add_action('widgets_init', 'alomran_register_gallery_widget');

class Alomran_Gallery_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'alomran_gallery_widget',
            __('معرض الصور', 'alomran'),
            array('description' => __('عرض معرض صور', 'alomran'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $images_text = !empty($instance['images']) ? $instance['images'] : '';
        $columns = !empty($instance['columns']) ? absint($instance['columns']) : 3;
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        if ($images_text) {
            $images = array_filter(array_map('trim', explode("\n", $images_text)));
            if (!empty($images)) {
                $grid_class = 'grid-cols-' . $columns;
                ?>
                <div class="alomran-gallery grid <?php echo esc_attr($grid_class); ?> gap-4">
                    <?php foreach ($images as $image_url) : 
                        $image_url = trim($image_url);
                        if (empty($image_url)) continue;
                    ?>
                        <div class="aspect-square overflow-hidden rounded-lg group cursor-pointer">
                            <img src="<?php echo esc_url($image_url); ?>" alt="" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php
            }
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $images = !empty($instance['images']) ? $instance['images'] : '';
        $columns = !empty($instance['columns']) ? absint($instance['columns']) : 3;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('images')); ?>"><?php _e('روابط الصور:', 'alomran'); ?></label>
            <textarea class="widefat" rows="8" id="<?php echo esc_attr($this->get_field_id('images')); ?>" name="<?php echo esc_attr($this->get_field_name('images')); ?>" placeholder="https://example.com/image1.jpg"><?php echo esc_textarea($images); ?></textarea>
            <small><?php _e('أدخل رابط كل صورة في سطر منفصل', 'alomran'); ?></small>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns')); ?>"><?php _e('عدد الأعمدة:', 'alomran'); ?></label>
            <select class="widefat" id="<?php echo esc_attr($this->get_field_id('columns')); ?>" name="<?php echo esc_attr($this->get_field_name('columns')); ?>">
                <option value="2" <?php selected($columns, 2); ?>>2</option>
                <option value="3" <?php selected($columns, 3); ?>>3</option>
                <option value="4" <?php selected($columns, 4); ?>>4</option>
            </select>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['images'] = !empty($new_instance['images']) ? sanitize_textarea_field($new_instance['images']) : '';
        $instance['columns'] = !empty($new_instance['columns']) ? absint($new_instance['columns']) : 3;
        return $instance;
    }
}

