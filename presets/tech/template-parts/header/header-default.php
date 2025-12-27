<?php
/**
 * Tech Preset - Default Header Template
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

// Get header settings
$logo_text = alomran_get_option('tech_header_logo_text', 'إتقان');
$logo_image = alomran_get_option('tech_header_logo_image', '');

// Get logo URL
$logo_url = '';
if ($logo_image) {
    if (is_array($logo_image) && isset($logo_image['url'])) {
        $logo_url = $logo_image['url'];
    } elseif (is_numeric($logo_image)) {
        $logo_url = wp_get_attachment_image_url($logo_image, 'full');
    }
}

// Get menu items
$menu_items = array();
if (has_nav_menu('primary')) {
    $menu = wp_get_nav_menu_object(get_nav_menu_locations()['primary']);
    if ($menu) {
        $menu_items = wp_get_nav_menu_items($menu->term_id);
    }
}

// Check if scrolled (will be handled by JS)
$is_scrolled = false;
?>
<nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 tech-navbar" id="tech-navbar">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2">
                <?php if ($logo_url) : ?>
                    <img src="<?php echo esc_url($logo_url); ?>" alt="<?php echo esc_attr($logo_text); ?>" class="h-10 w-auto">
                <?php else : ?>
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-violet-600 rounded-xl flex items-center justify-center text-white font-bold text-2xl shadow-lg">
                        إ
                    </div>
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-l from-slate-900 to-slate-700"><?php echo esc_html($logo_text); ?></span>
                <?php endif; ?>
            </a>

            <!-- Desktop Nav -->
            <div class="hidden md:flex items-center gap-8">
                <?php if ($menu_items && is_array($menu_items)) : ?>
                    <?php foreach ($menu_items as $item) : ?>
                        <?php
                        // Get correct URL - handle page links and custom links
                        if ($item->type === 'post_type' && $item->object === 'page') {
                            // For page menu items, use permalink
                            $menu_url = get_permalink($item->object_id);
                        } else {
                            // For custom links, format using helper function
                            $menu_url = alomran_format_url($item->url);
                        }
                        // Check if current page
                        $is_current = false;
                        if (is_page()) {
                            $current_page_id = get_queried_object_id();
                            $is_current = ($item->type === 'post_type' && $item->object_id == $current_page_id) || 
                                         (get_permalink() === $menu_url);
                        } elseif (is_front_page() && ($menu_url === home_url('/') || $menu_url === home_url())) {
                            $is_current = true;
                        }
                        ?>
                        <a 
                            href="<?php echo esc_url($menu_url); ?>" 
                            class="text-sm font-medium transition-colors text-slate-600 hover:text-blue-500 <?php echo $is_current ? 'text-blue-600' : ''; ?>"
                        >
                            <?php echo esc_html($item->title); ?>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
                
                <div class="flex items-center gap-4 mr-4">
                    <?php
                    // Login link
                    $login_page = get_page_by_path('login');
                    if ($login_page) {
                        echo '<a href="' . esc_url(get_permalink($login_page)) . '" class="text-sm font-semibold text-slate-700 hover:text-blue-600">تسجيل الدخول</a>';
                    }
                    
                    // Register link
                    $register_page = get_page_by_path('register');
                    if ($register_page) {
                        echo '<a href="' . esc_url(get_permalink($register_page)) . '" class="bg-blue-600 text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-blue-700 transition-all shadow-md shadow-blue-200">ابدأ الآن</a>';
                    }
                    ?>
                </div>
            </div>

            <!-- Mobile Toggle -->
            <button 
                class="md:hidden p-2 text-slate-600 tech-mobile-menu-toggle"
                aria-label="<?php esc_attr_e('فتح القائمة', 'alomran'); ?>"
            >
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="md:hidden bg-white border-t border-slate-100 p-4 absolute top-full left-0 right-0 shadow-xl tech-mobile-menu" style="display: none;">
        <div class="flex flex-col gap-4">
            <?php if ($menu_items && is_array($menu_items)) : ?>
                <?php foreach ($menu_items as $item) : ?>
                    <?php
                    // Get correct URL - handle page links and custom links
                    if ($item->type === 'post_type' && $item->object === 'page') {
                        // For page menu items, use permalink
                        $menu_url = get_permalink($item->object_id);
                    } else {
                        // For custom links, format using helper function
                        $menu_url = alomran_format_url($item->url);
                    }
                    ?>
                    <a 
                        href="<?php echo esc_url($menu_url); ?>" 
                        class="text-lg font-medium text-slate-700 py-2 border-b border-slate-50"
                    >
                        <?php echo esc_html($item->title); ?>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <div class="flex flex-col gap-3 pt-4">
                <?php
                $login_page = get_page_by_path('login');
                if ($login_page) {
                    echo '<a href="' . esc_url(get_permalink($login_page)) . '" class="text-center py-3 text-slate-700 font-semibold bg-slate-100 rounded-xl">تسجيل الدخول</a>';
                }
                
                $register_page = get_page_by_path('register');
                if ($register_page) {
                    echo '<a href="' . esc_url(get_permalink($register_page)) . '" class="text-center py-3 text-white font-semibold bg-blue-600 rounded-xl">ابدأ الآن مجاناً</a>';
                }
                ?>
            </div>
        </div>
    </div>
</nav>

