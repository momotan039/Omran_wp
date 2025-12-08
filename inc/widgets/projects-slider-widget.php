<?php
/**
 * Projects Slider Widget
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_register_projects_slider_widget() {
    register_widget('Alomran_Projects_Slider_Widget');
}
add_action('widgets_init', 'alomran_register_projects_slider_widget');

class Alomran_Projects_Slider_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'alomran_projects_slider_widget',
            __('سلايدر المشاريع', 'alomran'),
            array('description' => __('عرض سلايدر للمشاريع', 'alomran'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $projects_text = !empty($instance['projects']) ? $instance['projects'] : '';
        
        echo $args['before_widget'];
        
        if ($title) {
            echo $args['before_title'] . esc_html($title) . $args['after_title'];
        }
        
        if ($projects_text) {
            $projects = array_filter(array_map('trim', explode("\n", $projects_text)));
            if (!empty($projects)) {
                ?>
                <div class="alomran-projects-slider relative">
                    <div class="flex gap-4 overflow-x-auto pb-4 scrollbar-hide" style="scrollbar-width: none;">
                        <?php foreach ($projects as $project_line) : 
                            $parts = explode('|', $project_line, 3);
                            $image_url = trim($parts[0]);
                            $project_title = isset($parts[1]) ? trim($parts[1]) : '';
                            $project_url = isset($parts[2]) ? trim($parts[2]) : '#';
                            if (empty($image_url)) continue;
                        ?>
                            <div class="flex-shrink-0 w-80">
                                <a href="<?php echo esc_url($project_url); ?>" class="block group">
                                    <div class="relative aspect-video overflow-hidden rounded-lg">
                                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($project_title); ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                            <span class="text-white font-bold"><?php echo esc_html($project_title); ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php
            }
        }
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $projects = !empty($instance['projects']) ? $instance['projects'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('projects')); ?>"><?php _e('المشاريع:', 'alomran'); ?></label>
            <textarea class="widefat" rows="8" id="<?php echo esc_attr($this->get_field_id('projects')); ?>" name="<?php echo esc_attr($this->get_field_name('projects')); ?>" placeholder="ImageURL|Title|LinkURL"><?php echo esc_textarea($projects); ?></textarea>
            <small><?php _e('صيغة: رابط_الصورة|عنوان_المشروع|رابط_المشروع (كل مشروع في سطر منفصل)', 'alomran'); ?></small>
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['projects'] = !empty($new_instance['projects']) ? sanitize_textarea_field($new_instance['projects']) : '';
        return $instance;
    }
}

