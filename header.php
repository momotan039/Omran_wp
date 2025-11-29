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

<?php get_template_part('template-parts/header/header-loader'); ?>

<div id="page" class="site flex flex-col min-h-screen opacity-0 transition-opacity duration-500">
    <header class="bg-primary text-white sticky top-0 z-50 shadow-lg border-b border-white/10">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                <?php get_template_part('template-parts/header/header-logo'); ?>
                
                <?php get_template_part('template-parts/header/header-nav'); ?>
                
                <?php get_template_part('template-parts/header/header-mobile-menu'); ?>
            </div>
        </div>
    </header>

    <main id="main" class="site-main flex-grow">
