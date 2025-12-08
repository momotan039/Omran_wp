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
<html <?php language_attributes(); ?> dir="<?php echo esc_attr(alomran_get_html_dir()); ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php 
    // Force Tailwind CSS to load - direct output as fallback
    $tailwind_path = get_template_directory() . '/assets/css/tailwind.css';
    $tailwind_uri = get_template_directory_uri() . '/assets/css/tailwind.css';
    $tailwind_version = file_exists($tailwind_path) ? filemtime($tailwind_path) : '1.0.0';
    echo '<link rel="stylesheet" id="alomran-tailwind-css" href="' . esc_url($tailwind_uri) . '?ver=' . esc_attr($tailwind_version) . '" type="text/css" media="all" />' . "\n";
    ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-slate-800 font-sans antialiased'); ?>>
<?php wp_body_open(); ?>

<?php get_template_part('template-parts/header/header-loader'); ?>

<div id="page" class="site flex flex-col min-h-screen opacity-0 transition-opacity duration-500">
    <?php
    $header_style = alomran_get_header_style();
    $header_sticky = alomran_is_header_sticky();
    $header_classes = array('bg-primary', 'text-white', 'z-50', 'shadow-lg', 'border-b', 'border-white/10');
    
    if ($header_sticky) {
        $header_classes[] = 'sticky top-0';
    }
    
    if ($header_style === 'transparent') {
        $header_classes[] = 'bg-transparent absolute w-full';
    } elseif ($header_style === 'minimal') {
        $header_classes[] = 'bg-white text-gray-900 border-gray-200';
    } elseif ($header_style === 'centered') {
        $header_classes[] = 'text-center';
    }
    
    $header_class = implode(' ', $header_classes);
    ?>
    <header class="<?php echo esc_attr($header_class); ?>">
        <div class="<?php echo esc_attr(alomran_get_container_width_class()); ?> mx-auto px-4">
            <div class="flex <?php echo $header_style === 'centered' ? 'justify-center' : 'justify-between'; ?> items-center h-20">
                <?php get_template_part('template-parts/header/header-logo'); ?>
                
                <?php get_template_part('template-parts/header/header-nav'); ?>
                
                <?php get_template_part('template-parts/header/header-mobile-menu'); ?>
            </div>
        </div>
    </header>

    <?php alomran_display_ad('header', 'container mx-auto px-4 py-2', 'header-ad'); ?>

    <main id="main" class="site-main flex-grow">
