<?php
/**
 * The template for displaying single news posts
 *
 * @package AlOmran
 */

get_header();
?>

<?php while (have_posts()) : the_post(); ?>
    <!-- Hero Section -->
    <?php AlOmran_Preset_Loader::get_template_part('news-hero', '', array(), 'news'); ?>
    
    <!-- Content Section -->
    <div class="container mx-auto px-4 -mt-16 relative z-30">
        <?php alomran_display_ad('content_before', 'mb-4', 'news-ad-before'); ?>
        
        <div class="bg-white rounded-xl shadow-xl p-8 md:p-12 border-t-4 border-secondary animate-fade-in-up delay-200">
            <?php AlOmran_Preset_Loader::get_template_part('news-content', '', array(), 'news'); ?>
            
            <!-- Media Gallery -->
            <?php AlOmran_Preset_Loader::get_template_part('news-media', '', array(), 'news'); ?>
            
            <!-- Share Buttons -->
            <?php AlOmran_Preset_Loader::get_template_part('news-share', '', array(), 'news'); ?>
            
            <!-- Navigation -->
            <?php AlOmran_Preset_Loader::get_template_part('news-navigation', '', array(), 'news'); ?>
        </div>
        
        <?php alomran_display_ad('content_after', 'mt-4', 'news-ad-after'); ?>
    </div>
    
    <!-- Related News -->
    <?php AlOmran_Preset_Loader::get_template_part('news-related', '', array(), 'news'); ?>
    
    <!-- Modals -->
    <?php AlOmran_Preset_Loader::get_template_part('news-modals', '', array(), 'news'); ?>
    
<?php endwhile; ?>

<?php get_footer(); ?>
