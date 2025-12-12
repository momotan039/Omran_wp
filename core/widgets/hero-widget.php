<?php
/**
 * Hero Widget
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

function alomran_register_hero_widget() {
    register_widget('Alomran_Hero_Widget');
}
add_action('widgets_init', 'alomran_register_hero_widget');

class Alomran_Hero_Widget extends WP_Widget {
    
    public function __construct() {
        parent::__construct(
            'alomran_hero_widget',
            __('قسم البطل (Hero)', 'alomran'),
            array('description' => __('عرض قسم بطل مع عنوان، وصف، صورة خلفية، وأزرار', 'alomran'))
        );
    }
    
    public function widget($args, $instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $background_image = !empty($instance['background_image']) ? $instance['background_image'] : '';
        $button_text = !empty($instance['button_text']) ? $instance['button_text'] : '';
        $button_url = !empty($instance['button_url']) ? $instance['button_url'] : '';
        $button_text_2 = !empty($instance['button_text_2']) ? $instance['button_text_2'] : '';
        $button_url_2 = !empty($instance['button_url_2']) ? $instance['button_url_2'] : '';
        $overlay_opacity = !empty($instance['overlay_opacity']) ? $instance['overlay_opacity'] : '50';
        
        echo $args['before_widget'];
        
        $bg_style = '';
        if ($background_image) {
            $bg_style = 'background-image: url(' . esc_url($background_image) . ');';
        }
        ?>
        <div class="alomran-hero-widget relative py-20 bg-cover bg-center bg-no-repeat" style="<?php echo esc_attr($bg_style); ?>">
            <div class="absolute inset-0" style="background-color: rgba(0, 0, 0, <?php echo esc_attr($overlay_opacity / 100); ?>);"></div>
            <div class="relative z-10 <?php echo esc_attr(alomran_get_container_width_class()); ?> mx-auto px-4 text-center" style="color: var(--theme-white);">
                <?php if ($subtitle) : ?>
                    <p class="text-lg mb-4 text-accent" style="color: var(--theme-accent);"><?php echo esc_html($subtitle); ?></p>
                <?php endif; ?>
                <?php if ($title) : ?>
                    <h2 class="text-4xl md:text-6xl font-bold mb-6"><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($description) : ?>
                    <p class="text-xl mb-8 max-w-2xl mx-auto"><?php echo esc_html($description); ?></p>
                <?php endif; ?>
                <div class="flex flex-wrap gap-4 justify-center">
                    <?php if ($button_text && $button_url) : ?>
                        <a href="<?php echo esc_url($button_url); ?>" class="text-white px-8 py-3 rounded-lg font-bold hover:bg-secondary transition" style="background-color: var(--theme-primary);">
                            <?php echo esc_html($button_text); ?>
                        </a>
                    <?php endif; ?>
                    <?php if ($button_text_2 && $button_url_2) : ?>
                        <a href="<?php echo esc_url($button_url_2); ?>" class="px-8 py-3 rounded-lg font-bold hover:bg-gray-100 transition" style="background-color: var(--theme-white); color: var(--theme-primary);">
                            <?php echo esc_html($button_text_2); ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php
        
        echo $args['after_widget'];
    }
    
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $subtitle = !empty($instance['subtitle']) ? $instance['subtitle'] : '';
        $description = !empty($instance['description']) ? $instance['description'] : '';
        $background_image = !empty($instance['background_image']) ? $instance['background_image'] : '';
        $button_text = !empty($instance['button_text']) ? $instance['button_text'] : '';
        $button_url = !empty($instance['button_url']) ? $instance['button_url'] : '';
        $button_text_2 = !empty($instance['button_text_2']) ? $instance['button_text_2'] : '';
        $button_url_2 = !empty($instance['button_url_2']) ? $instance['button_url_2'] : '';
        $overlay_opacity = !empty($instance['overlay_opacity']) ? $instance['overlay_opacity'] : '50';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php _e('العنوان:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('subtitle')); ?>"><?php _e('العنوان الفرعي:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('subtitle')); ?>" name="<?php echo esc_attr($this->get_field_name('subtitle')); ?>" type="text" value="<?php echo esc_attr($subtitle); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('description')); ?>"><?php _e('الوصف:', 'alomran'); ?></label>
            <textarea class="widefat" rows="3" id="<?php echo esc_attr($this->get_field_id('description')); ?>" name="<?php echo esc_attr($this->get_field_name('description')); ?>"><?php echo esc_textarea($description); ?></textarea>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('background_image')); ?>"><?php _e('صورة الخلفية (URL):', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('background_image')); ?>" name="<?php echo esc_attr($this->get_field_name('background_image')); ?>" type="url" value="<?php echo esc_url($background_image); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('overlay_opacity')); ?>"><?php _e('شفافية الغطاء (0-100):', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('overlay_opacity')); ?>" name="<?php echo esc_attr($this->get_field_name('overlay_opacity')); ?>" type="number" min="0" max="100" value="<?php echo esc_attr($overlay_opacity); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_text')); ?>"><?php _e('نص الزر الأول:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_text')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text')); ?>" type="text" value="<?php echo esc_attr($button_text); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_url')); ?>"><?php _e('رابط الزر الأول:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_url')); ?>" name="<?php echo esc_attr($this->get_field_name('button_url')); ?>" type="url" value="<?php echo esc_url($button_url); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_text_2')); ?>"><?php _e('نص الزر الثاني:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_text_2')); ?>" name="<?php echo esc_attr($this->get_field_name('button_text_2')); ?>" type="text" value="<?php echo esc_attr($button_text_2); ?>">
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('button_url_2')); ?>"><?php _e('رابط الزر الثاني:', 'alomran'); ?></label>
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('button_url_2')); ?>" name="<?php echo esc_attr($this->get_field_name('button_url_2')); ?>" type="url" value="<?php echo esc_url($button_url_2); ?>">
        </p>
        <?php
    }
    
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['subtitle'] = !empty($new_instance['subtitle']) ? sanitize_text_field($new_instance['subtitle']) : '';
        $instance['description'] = !empty($new_instance['description']) ? sanitize_textarea_field($new_instance['description']) : '';
        $instance['background_image'] = !empty($new_instance['background_image']) ? esc_url_raw($new_instance['background_image']) : '';
        $instance['button_text'] = !empty($new_instance['button_text']) ? sanitize_text_field($new_instance['button_text']) : '';
        $instance['button_url'] = !empty($new_instance['button_url']) ? esc_url_raw($new_instance['button_url']) : '';
        $instance['button_text_2'] = !empty($new_instance['button_text_2']) ? sanitize_text_field($new_instance['button_text_2']) : '';
        $instance['button_url_2'] = !empty($new_instance['button_url_2']) ? esc_url_raw($new_instance['button_url_2']) : '';
        $instance['overlay_opacity'] = !empty($new_instance['overlay_opacity']) ? absint($new_instance['overlay_opacity']) : '50';
        return $instance;
    }
}

