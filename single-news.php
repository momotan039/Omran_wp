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
    <?php get_template_part('template-parts/news/news-hero'); ?>
    
    <!-- Content Section -->
    <div class="container mx-auto px-4 -mt-16 relative z-30">
        <?php alomran_display_ad('content_before', 'mb-4', 'news-ad-before'); ?>
        
        <div class="bg-white rounded-xl shadow-xl p-8 md:p-12 border-t-4 border-secondary animate-fade-in-up delay-200">
            <?php get_template_part('template-parts/news/news-content'); ?>
            
            <!-- Media Gallery -->
            <?php get_template_part('template-parts/news/news-media'); ?>
            
            <!-- Share Buttons -->
            <?php get_template_part('template-parts/news/news-share'); ?>
            
            <!-- Navigation -->
            <?php get_template_part('template-parts/news/news-navigation'); ?>
        </div>
        
        <?php alomran_display_ad('content_after', 'mt-4', 'news-ad-after'); ?>
    </div>
    
    <!-- Related News -->
    <?php get_template_part('template-parts/news/news-related'); ?>
    
    <!-- Modals -->
    <?php get_template_part('template-parts/news/news-modals'); ?>
    
<?php endwhile; ?>

<?php get_footer(); ?>
