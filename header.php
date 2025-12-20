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
<html <?php language_attributes(); ?> dir="<?php echo esc_attr(alomran_get_html_dir()); ?>" itemscope itemtype="https://schema.org/WebSite">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    
    <?php 
    // Preconnect to external resources for better performance
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">' . "\n";
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.googleapis.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//fonts.gstatic.com">' . "\n";
    
    // DNS prefetch for common external resources
    echo '<link rel="dns-prefetch" href="//www.google.com">' . "\n";
    echo '<link rel="dns-prefetch" href="//www.google-analytics.com">' . "\n";
    
    // Force Tailwind CSS to load - direct output as fallback
    $tailwind_path = get_template_directory() . '/assets/css/tailwind.css';
    $tailwind_uri = get_template_directory_uri() . '/assets/css/tailwind.css';
    $tailwind_version = file_exists($tailwind_path) ? filemtime($tailwind_path) : '1.0.0';
    echo '<link rel="stylesheet" id="alomran-tailwind-css" href="' . esc_url($tailwind_uri) . '?ver=' . esc_attr($tailwind_version) . '" type="text/css" media="all" />' . "\n";
    ?>
    <?php wp_head(); ?>
</head>
<body <?php body_class('font-sans antialiased'); ?> style="background-color: var(--theme-background); color: var(--theme-text);">
<?php wp_body_open(); ?>

<?php 
// Load header loader from preset
$loader_template = AlOmran_Preset_Loader::locate_template('header-loader', 'header');
if ($loader_template) {
    include $loader_template;
}
?>

<div id="page" class="site flex flex-col min-h-screen opacity-0 transition-opacity duration-500">
    <?php
    // Header removed - no header or logo displayed
    ?>

    <?php alomran_display_ad('header', 'container mx-auto px-4 py-2', 'header-ad'); ?>

    <main id="main" class="site-main flex-grow">
