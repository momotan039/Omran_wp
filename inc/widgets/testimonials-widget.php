<?php
/**
 * Testimonials Widget
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_register_testimonials_widget() {
    register_widget('Alomran_Testimonials_Widget');
}
add_action('widgets_init', 'alomran_register_testimonials_widget');

class Alomran_Testimonials_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'alomran_testimonials_widget',
            __('الشهادات', 'alomran'),
            array('description' => __('عرض شهادات العملاء', 'alomran'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $limit = !empty($instance['limit']) ? absint($instance['limit']) : 5;
        $show_slider = !empty($instance['show_slider']) ? true : false;
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        $testimonials = get_posts(array(
            'post_type' => 'testimonial',
            'posts_per_page' => $limit,
            'orderby' => 'date',
            'order' => 'DESC',
        ));
        
        if (!empty($testimonials)) {
            $slider_class = $show_slider ? 'alomran-testimonials-slider' : '';
            ?>
            <div class="alomran-testimonials <?php echo esc_attr($slider_class); ?> space-y-4">
                <?php foreach ($testimonials as $testimonial) : 
                    $role = get_field('role', $testimonial->ID);
                    $company = get_field('company', $testimonial->ID);
                    $content = get_field('content', $testimonial->ID) ?: $testimonial->post_content;
                ?>
                    <div class="bg-white rounded-lg p-6 border border-gray-200 shadow-sm">
                        <div class="flex items-start gap-1 mb-4">
                            <?php for ($i = 0; $i < 5; $i++) : ?>
                                <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            <?php endfor; ?>
                        </div>
                        <p class="text-gray-700 mb-4"><?php echo esc_html($content); ?></p>
                        <div class="flex items-center gap-3">
                            <div>
                                <p class="font-bold text-gray-900"><?php echo esc_html($testimonial->post_title); ?></p>
                                <?php if ($role || $company) : ?>
                                    <p class="text-sm text-gray-500">
                                        <?php if ($role) echo esc_html($role); ?>
                                        <?php if ($role && $company) echo ' - '; ?>
                                        <?php if ($company) echo esc_html($company); ?>
                                    </p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $limit = !empty($instance['limit']) ? absint($instance['limit']) : 5;
        $show_slider = !empty($instance['show_slider']) ? true : false;
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('limit')); ?>"><?php _e('عدد الشهادات:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('limit')); ?>" name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="number" min="1" max="20" value="<?php echo esc_attr($limit); ?>">
        </p>
        <p>
            <input class="checkbox" type="checkbox" <?php checked($show_slider); ?> id="<?php echo esc_attr($this->get_field_id('show_slider')); ?>" name="<?php echo esc_attr($this->get_field_name('show_slider')); ?>">
            <label for="<?php echo esc_attr($this->get_field_id('show_slider')); ?>"><?php _e('عرض كسلايدر', 'alomran'); ?></label>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['limit'] = !empty($new_instance['limit']) ? absint($new_instance['limit']) : 5;
        $instance['show_slider'] = !empty($new_instance['show_slider']) ? 1 : 0;
        return $instance;
    }
}

