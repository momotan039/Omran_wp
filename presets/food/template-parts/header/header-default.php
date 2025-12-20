<?php
/**
 * Food Preset - Default Header Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get header settings
$header_enable = alomran_get_option('food_header_enable', true);
$header_show_menu = alomran_get_option('food_header_show_menu', true);
$header_show_reservation_button = alomran_get_option('food_header_show_reservation_button', true);
$header_sticky = alomran_get_option('food_header_sticky', true);
$header_transparent = alomran_get_option('food_header_transparent', true);

// Logo settings
$header_logo_type = alomran_get_option('food_header_logo_type', 'text');
$header_logo_image = alomran_get_option('food_header_logo_image', '');
$header_logo_image_width = alomran_get_option('food_header_logo_image_width', 150);

// Design settings
$header_padding = alomran_get_option('food_header_padding', 16);
$header_border_radius = alomran_get_option('food_header_border_radius', 9999);
$header_background_opacity = alomran_get_option('food_header_background_opacity', 95);
$header_logo_size = alomran_get_option('food_header_logo_size', 36);
$header_menu_font_size = alomran_get_option('food_header_menu_font_size', 12);
$header_menu_spacing = alomran_get_option('food_header_menu_spacing', 40);

// Button settings
$header_reservation_button_text = alomran_get_option('food_header_reservation_button_text', 'احجز الآن');
$header_reservation_button_link_type = alomran_get_option('food_header_reservation_button_link_type', 'reservations');
$header_reservation_button_link_custom = alomran_get_option('food_header_reservation_button_link_custom', '');
$header_reservation_button_link = alomran_get_button_link($header_reservation_button_link_type, $header_reservation_button_link_custom);

// If header is disabled, don't render it
if (!$header_enable) {
    return;
}

$app_name_ar = alomran_get_option('food_app_name_ar', 'الجوهرة');
$app_name_en = alomran_get_option('food_app_name_en', 'Al-Jawhara');
$current_page = get_query_var('paged') ? 'paged' : (is_front_page() ? 'home' : 'page');

// Determine if page is dark (for navbar color)
$is_dark_page = is_front_page() || is_page('experience');
$is_branch_page = is_singular('branch');
$text_color = $is_dark_page ? 'text-white' : 'text-brand-black';
$logo_color = $is_dark_page ? 'text-brand-gold' : 'text-brand-black';

// On branch pages, always use white text and add prominent background
if ($is_branch_page) {
    $text_color = 'text-white';
    $logo_color = 'text-brand-gold';
}

// Determine navbar position class
$navbar_position = $header_sticky ? 'fixed' : 'relative';

// Calculate background color and opacity
$bg_opacity = $header_background_opacity / 100;
if ($is_branch_page) {
    $bg_color_class = 'bg-brand-black';
    $bg_color_style = 'background-color: rgba(10, 10, 10, ' . $bg_opacity . ');';
} elseif ($header_transparent && $is_dark_page) {
    $bg_color_class = 'bg-transparent';
    $bg_color_style = '';
} else {
    $bg_color_class = 'bg-white';
    $bg_color_style = 'background-color: rgba(255, 255, 255, ' . $bg_opacity . ');';
}
?>
<nav class="<?php echo esc_attr($navbar_position); ?> top-0 left-0 right-0 z-50 transition-all duration-700 px-8 lg:px-12 py-10" id="food-navbar">
    <div class="max-w-[1600px] mx-auto transition-all duration-700 backdrop-blur-md shadow-2xl flex justify-between items-center <?php echo esc_attr($bg_color_class); ?>" 
         id="food-navbar-inner" 
         style="padding: <?php echo esc_attr($header_padding); ?>px; border-radius: <?php echo esc_attr($header_border_radius); ?>px; <?php echo esc_attr($bg_color_style); ?>"
         <?php echo $is_branch_page ? 'data-branch-page="true"' : ''; ?>>
        
        <!-- Desktop Links - Right -->
        <?php if ($header_show_menu) : ?>
        <div class="hidden lg:flex items-center" style="gap: <?php echo esc_attr($header_menu_spacing); ?>px;">
            <?php
            // Get menu items
            $menu_items = array();
            if (has_nav_menu('primary')) {
                $menu = wp_get_nav_menu_object(get_nav_menu_locations()['primary']);
                if ($menu) {
                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                }
            }
            
            if ($menu_items && is_array($menu_items)) {
                // Split menu items - first half on right, second half on left
                $total_items = count($menu_items);
                $half = ceil($total_items / 2);
                $right_items = array_slice($menu_items, 0, $half);
                
                foreach ($right_items as $item) {
                    if ($item->menu_item_parent == 0) { // Only top-level items
                        ?>
                        <a href="<?php echo esc_url(alomran_format_url($item->url)); ?>" class="font-black uppercase tracking-[0.2em] transition-all hover:text-brand-gold <?php echo esc_attr($text_color); ?>" style="font-size: <?php echo esc_attr($header_menu_font_size); ?>px;">
                            <?php echo esc_html($item->title); ?>
                        </a>
                        <?php
                    }
                }
            } else {
                // Fallback menu if no menu is assigned
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="font-black uppercase tracking-[0.2em] transition-all hover:text-brand-gold <?php echo esc_attr($text_color); ?>" style="font-size: <?php echo esc_attr($header_menu_font_size); ?>px;">
                    الرئيسية
                </a>
                <a href="<?php echo esc_url(alomran_format_url('/story')); ?>" class="font-black uppercase tracking-[0.2em] transition-all hover:text-brand-gold <?php echo esc_attr($text_color); ?>" style="font-size: <?php echo esc_attr($header_menu_font_size); ?>px;">
                    القصة
                </a>
                <a href="<?php echo esc_url(get_post_type_archive_link('menu_item')); ?>" class="font-black uppercase tracking-[0.2em] transition-all hover:text-brand-gold <?php echo esc_attr($text_color); ?>" style="font-size: <?php echo esc_attr($header_menu_font_size); ?>px;">
                    القائمة
                </a>
                <?php
            }
            ?>
        </div>
        <?php else : ?>
        <div class="hidden lg:flex items-center"></div>
        <?php endif; ?>

        <!-- Logo - Center -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="flex flex-col items-center cursor-pointer group">
            <?php if ($header_logo_type === 'image' && !empty($header_logo_image)) : 
                // Get logo image URL
                $logo_url = '';
                if (is_array($header_logo_image) && isset($header_logo_image['url'])) {
                    $logo_url = $header_logo_image['url'];
                } elseif (is_numeric($header_logo_image)) {
                    $logo_url = wp_get_attachment_image_url($header_logo_image, 'full');
                } elseif (is_string($header_logo_image)) {
                    $logo_url = $header_logo_image;
                }
                
                if (!empty($logo_url)) : ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($app_name_ar); ?>" class="group-hover:scale-105 transition-transform duration-500" style="max-width: <?php echo esc_attr($header_logo_image_width); ?>px; height: auto;" loading="eager" decoding="async">
                <?php else : ?>
                    <!-- Fallback to text if image not found -->
                    <h1 class="font-black transition-colors <?php echo esc_attr($logo_color); ?> group-hover:scale-105 transition-transform duration-500" style="font-size: <?php echo esc_attr($header_logo_size); ?>px;">
                        <?php echo esc_html($app_name_ar); ?>
                    </h1>
                    <span class="font-light uppercase mt-1 opacity-50 <?php echo esc_attr($text_color); ?>" style="font-size: <?php echo esc_attr($header_logo_size * 0.25); ?>px; letter-spacing: 0.6em;">
                        <?php echo esc_html($app_name_en); ?>
                    </span>
                <?php endif; ?>
            <?php else : ?>
                <!-- Text Logo -->
                <h1 class="font-black transition-colors <?php echo esc_attr($logo_color); ?> group-hover:scale-105 transition-transform duration-500" style="font-size: <?php echo esc_attr($header_logo_size); ?>px;">
                    <?php echo esc_html($app_name_ar); ?>
                </h1>
                <span class="font-light uppercase mt-1 opacity-50 <?php echo esc_attr($text_color); ?>" style="font-size: <?php echo esc_attr($header_logo_size * 0.25); ?>px; letter-spacing: 0.6em;">
                    <?php echo esc_html($app_name_en); ?>
                </span>
            <?php endif; ?>
        </a>

        <!-- Desktop Links - Left -->
        <?php if ($header_show_menu) : ?>
        <div class="hidden lg:flex items-center" style="gap: <?php echo esc_attr($header_menu_spacing); ?>px;">
            <?php
            // Get menu items and split them - first half on right, second half on left
            $menu_items = array();
            if (has_nav_menu('primary')) {
                $menu = wp_get_nav_menu_object(get_nav_menu_locations()['primary']);
                if ($menu) {
                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                }
            }
            
            if ($menu_items && is_array($menu_items)) {
                $total_items = count($menu_items);
                $half = ceil($total_items / 2);
                $left_items = array_slice($menu_items, $half);
                
                foreach ($left_items as $item) {
                    if ($item->menu_item_parent == 0) { // Only top-level items
                        ?>
                        <a href="<?php echo esc_url(alomran_format_url($item->url)); ?>" class="font-black uppercase tracking-[0.2em] transition-all hover:text-brand-gold <?php echo esc_attr($text_color); ?>" style="font-size: <?php echo esc_attr($header_menu_font_size); ?>px;">
                            <?php echo esc_html($item->title); ?>
                        </a>
                        <?php
                    }
                }
            } else {
                // Fallback menu if no menu is assigned
                ?>
                <a href="<?php echo esc_url(alomran_format_url('/experience')); ?>" class="font-black uppercase tracking-[0.2em] transition-all hover:text-brand-gold <?php echo esc_attr($text_color); ?>" style="font-size: <?php echo esc_attr($header_menu_font_size); ?>px;">
                    التجربة
                </a>
                <a href="<?php echo esc_url(get_post_type_archive_link('blog_post')); ?>" class="font-black uppercase tracking-[0.2em] transition-all hover:text-brand-gold <?php echo esc_attr($text_color); ?>" style="font-size: <?php echo esc_attr($header_menu_font_size); ?>px;">
                    المجلة
                </a>
                <?php
            }
            ?>
            <?php if ($header_show_reservation_button) : ?>
            <a href="<?php echo esc_url($header_reservation_button_link); ?>" class="bg-brand-gold text-brand-black px-10 py-3 rounded-full font-black text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-xl" style="box-shadow: 0 10px 15px -3px rgba(212, 175, 55, 0.1), 0 4px 6px -2px rgba(212, 175, 55, 0.1);">
                <?php echo esc_html($header_reservation_button_text); ?>
            </a>
            <?php endif; ?>
        </div>
        <?php else : ?>
        <div class="hidden lg:flex items-center"></div>
        <?php endif; ?>

        <!-- Mobile Toggle -->
        <button class="lg:hidden" id="food-mobile-menu-toggle">
            <svg class="w-8 h-8 <?php echo esc_attr($text_color); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>

    <!-- Fullscreen Mobile Menu -->
    <div class="fixed inset-0 bg-brand-black z-[100] hidden flex-col justify-center items-center text-center p-12" id="food-mobile-menu">
        <button class="absolute top-12 left-12 text-brand-gold" id="food-mobile-menu-close">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
        <div class="space-y-10">
            <?php
            // Get menu items for mobile menu
            $menu_items = array();
            if (has_nav_menu('primary')) {
                $menu = wp_get_nav_menu_object(get_nav_menu_locations()['primary']);
                if ($menu) {
                    $menu_items = wp_get_nav_menu_items($menu->term_id);
                }
            }
            
            if ($menu_items && is_array($menu_items)) {
                foreach ($menu_items as $item) {
                    if ($item->menu_item_parent == 0) { // Only top-level items
                        ?>
                        <a href="<?php echo esc_url(alomran_format_url($item->url)); ?>" class="block text-5xl text-white font-black hover:text-brand-gold transition-colors">
                            <?php echo esc_html($item->title); ?>
                        </a>
                        <?php
                    }
                }
                
                // Add reservation button if enabled
                if ($header_show_reservation_button) {
                    ?>
                    <a href="<?php echo esc_url($header_reservation_button_link); ?>" class="mt-12 bg-brand-gold text-brand-black px-16 py-6 rounded-full font-black text-2xl shadow-2xl inline-block">
                        <?php echo esc_html($header_reservation_button_text); ?>
                    </a>
                    <?php
                }
            } else {
                // Fallback menu if no menu is assigned
                ?>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="block text-5xl text-white font-black hover:text-brand-gold transition-colors">الرئيسية</a>
                <a href="<?php echo esc_url(alomran_format_url('/story')); ?>" class="block text-5xl text-white font-black hover:text-brand-gold transition-colors">القصة</a>
                <a href="<?php echo esc_url(get_post_type_archive_link('menu_item')); ?>" class="block text-5xl text-white font-black hover:text-brand-gold transition-colors">القائمة</a>
                <a href="<?php echo esc_url(alomran_format_url('/experience')); ?>" class="block text-5xl text-white font-black hover:text-brand-gold transition-colors">التجربة</a>
                <a href="<?php echo esc_url(get_post_type_archive_link('blog_post')); ?>" class="block text-5xl text-white font-black hover:text-brand-gold transition-colors">المجلة</a>
                <?php if ($header_show_reservation_button) : ?>
                <a href="<?php echo esc_url($header_reservation_button_link); ?>" class="mt-12 bg-brand-gold text-brand-black px-16 py-6 rounded-full font-black text-2xl shadow-2xl inline-block">
                    <?php echo esc_html($header_reservation_button_text); ?>
                </a>
                <?php endif; ?>
                <?php
            }
            ?>
        </div>
        <div class="mt-24 text-gray-500 font-bold tracking-[0.5em] text-xs uppercase">
            Al-Jawhara • Fine Dining
        </div>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const navbar = document.getElementById('food-navbar-inner');
    const mobileMenuToggle = document.getElementById('food-mobile-menu-toggle');
    const mobileMenu = document.getElementById('food-mobile-menu');
    const mobileMenuClose = document.getElementById('food-mobile-menu-close');
    
    // Scroll effect - matching React app behavior
    const isDarkPage = <?php echo $is_dark_page ? 'true' : 'false'; ?>;
    const isBranchPage = <?php echo $is_branch_page ? 'true' : 'false'; ?>;
    const headerSticky = <?php echo $header_sticky ? 'true' : 'false'; ?>;
    const headerTransparent = <?php echo $header_transparent ? 'true' : 'false'; ?>;
    
    // On branch pages, always show scrolled state for prominent navbar
    if (isBranchPage) {
        navbar.classList.add('scrolled');
        navbar.style.backgroundColor = 'rgba(10, 10, 10, 1)';
    }
    
    // Only apply scroll effect if sticky is enabled
    if (headerSticky) {
        window.addEventListener('scroll', function() {
            const isScrolled = window.scrollY > 40;
            
            if (isScrolled || isDarkPage || isBranchPage) {
                navbar.classList.add('scrolled');
                // Remove transparency when scrolled - make background fully opaque
                if (isBranchPage) {
                    navbar.style.backgroundColor = 'rgba(10, 10, 10, 1)';
                } else {
                    navbar.style.backgroundColor = 'rgba(255, 255, 255, 1)';
                }
            } else if (!isBranchPage && headerTransparent) {
                navbar.classList.remove('scrolled');
                // Restore original opacity when not scrolled
                const originalOpacity = <?php echo $header_background_opacity / 100; ?>;
                if (headerTransparent && isDarkPage) {
                    navbar.style.backgroundColor = '';
                } else {
                    navbar.style.backgroundColor = 'rgba(255, 255, 255, ' + originalOpacity + ')';
                }
            }
        });
    }
    
    // Mobile menu toggle
    if (mobileMenuToggle && mobileMenu && mobileMenuClose) {
        mobileMenuToggle.addEventListener('click', function() {
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('flex');
        });
        
        mobileMenuClose.addEventListener('click', function() {
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('flex');
        });
    }
});
</script>

