<?php
/**
 * Header template.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> dir="rtl">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-slate-800 font-sans antialiased'); ?>>
<?php wp_body_open(); ?>

<!-- Page Loader -->
<div id="page-loader" class="fixed inset-0 z-[100] bg-white flex items-center justify-center transition-opacity duration-500">
    <div class="text-center">
        <!-- Industrial Logo Animation -->
        <div class="relative w-20 h-20 mx-auto mb-6">
            <div class="absolute inset-0 bg-secondary rounded-lg flex items-center justify-center transform rotate-45 animate-spin-slow">
                <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-lg transform -rotate-45"></div>
            </div>
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-8 h-8 bg-primary rounded transform rotate-45"></div>
            </div>
        </div>
        <!-- Loading Text -->
        <div class="space-y-2">
            <h3 class="text-xl font-bold text-primary">العمران</h3>
            <p class="text-sm text-gray-600">للصناعات المتطورة</p>
            <!-- Progress Bar -->
            <div class="w-48 h-1 bg-gray-200 rounded-full mx-auto mt-4 overflow-hidden">
                <div id="loader-progress" class="h-full bg-gradient-to-r from-primary via-secondary to-primary rounded-full transform -translate-x-full animate-progress"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Vanilla JS fallback to hide loader - runs immediately
(function() {
    function hideLoader() {
        const loader = document.getElementById('page-loader');
        const page = document.getElementById('page');
        
        if (loader && page) {
            loader.style.opacity = '0';
            loader.style.pointerEvents = 'none';
            page.style.opacity = '1';
            
            setTimeout(function() {
                loader.style.display = 'none';
            }, 500);
        }
    }
    
    // Hide loader when window loads
    if (document.readyState === 'complete') {
        setTimeout(hideLoader, 800);
    } else {
        window.addEventListener('load', function() {
            setTimeout(hideLoader, 800);
        });
    }
    
    // Safety fallback - hide after 3 seconds max
    setTimeout(hideLoader, 3000);
})();
</script>

<div id="page" class="site flex flex-col min-h-screen opacity-0 transition-opacity duration-500">
    <header class="bg-primary text-white sticky top-0 z-50 shadow-lg border-b border-white/10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center transform rotate-45">
                         <div class="w-6 h-6 border-2 border-primary transform -rotate-45"></div>
                    </div>
                    <div>
                        <?php if (is_front_page() || is_home()) : ?>
                            <h1 class="text-xl font-bold tracking-wider text-secondary">العمران</h1>
                        <?php else : ?>
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="text-xl font-bold tracking-wider text-secondary hover:text-yellow-400 transition">
                                العمران
                            </a>
                        <?php endif; ?>
                        <p class="text-xs text-gray-300">للصناعات المتطورة</p>
                    </div>
                </div>

                <nav class="hidden md:flex space-x-8 space-x-reverse items-center">
                    <?php
                    if (has_nav_menu('primary')) {
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'container'      => false,
                            'menu_class'     => 'flex space-x-8 space-x-reverse items-center',
                            'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                            'walker'         => new AlOmran_Walker_Nav_Menu(),
                            'fallback_cb'    => false,
                        ));
                    } else {
                        // Fallback menu if no menu is assigned
                        $nav_links = array(
                            array('name' => 'الرئيسية', 'url' => home_url('/')),
                            array('name' => 'منتجاتنا', 'url' => get_post_type_archive_link('product') ?: home_url('/products')),
                            array('name' => 'عن الشركة', 'url' => alomran_get_page_url('عن الشركة') ?: alomran_get_page_url('about') ?: home_url('/about')),
                            array('name' => 'الأخبار', 'url' => get_post_type_archive_link('news') ?: home_url('/news')),
                            array('name' => 'الأسئلة الشائعة', 'url' => alomran_get_page_url('الأسئلة الشائعة') ?: alomran_get_page_url('faq') ?: home_url('/faq')),
                            array('name' => 'تواصل معنا', 'url' => alomran_get_page_url('تواصل معنا') ?: alomran_get_page_url('contact') ?: home_url('/contact')),
                        );

                        echo '<ul class="flex space-x-8 space-x-reverse items-center">';
                        foreach ($nav_links as $link) {
                            $is_active = (is_page($link['url']) || (is_home() && $link['url'] === home_url('/'))) ? 'text-secondary font-bold' : 'text-white hover:text-secondary';
                            echo '<li class="transition-colors duration-300 text-sm lg:text-base ' . esc_attr($is_active) . '">';
                            echo '<a href="' . esc_url($link['url']) . '">' . esc_html($link['name']) . '</a>';
                            echo '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </nav>

                <div class="md:hidden">
                    <button id="mobile-menu-toggle" class="text-white focus:outline-none" aria-label="<?php esc_attr_e('Toggle Menu', 'alomran'); ?>">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="menu-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg class="w-7 h-7 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24" id="close-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="md:hidden hidden bg-primary border-t border-gray-700">
            <div class="flex flex-col space-y-4 px-4 py-6">
                <?php
                if (has_nav_menu('primary')) {
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'container'      => false,
                        'menu_class'     => 'flex flex-col space-y-4',
                        'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                        'walker'         => new AlOmran_Walker_Nav_Menu(),
                        'fallback_cb'    => false,
                    ));
                } else {
                    // Fallback menu if no menu is assigned
                    $nav_links = array(
                        array('name' => 'الرئيسية', 'url' => home_url('/')),
                        array('name' => 'منتجاتنا', 'url' => get_post_type_archive_link('product') ?: home_url('/products')),
                        array('name' => 'عن الشركة', 'url' => alomran_get_page_url('عن الشركة') ?: alomran_get_page_url('about') ?: home_url('/about')),
                        array('name' => 'الأخبار', 'url' => get_post_type_archive_link('news') ?: home_url('/news')),
                        array('name' => 'الأسئلة الشائعة', 'url' => alomran_get_page_url('الأسئلة الشائعة') ?: alomran_get_page_url('faq') ?: home_url('/faq')),
                        array('name' => 'تواصل معنا', 'url' => alomran_get_page_url('تواصل معنا') ?: alomran_get_page_url('contact') ?: home_url('/contact')),
                    );

                    foreach ($nav_links as $link) {
                        $is_active = (is_page($link['url']) || (is_home() && $link['url'] === home_url('/'))) ? 'text-secondary font-bold' : 'text-white hover:text-secondary';
                        echo '<a href="' . esc_url($link['url']) . '" class="block ' . esc_attr($is_active) . '">' . esc_html($link['name']) . '</a>';
                    }
                }
                ?>
            </div>
        </div>
    </header>

    <main id="main" class="site-main flex-grow">
