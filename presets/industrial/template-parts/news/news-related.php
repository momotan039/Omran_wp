<?php
/**
 * Related News Section
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();
$related_args = array(
    'post_type'      => 'news',
    'posts_per_page' => 3,
    'post__not_in'   => array($post_id),
    'orderby'        => 'rand',
    'order'          => 'DESC',
);

$related_news = new WP_Query($related_args);

if ($related_news->have_posts()) : ?>
    <div class="container mx-auto px-4 mt-12 mb-16">
        <h3 class="text-2xl font-bold text-primary mb-8 border-r-4 border-secondary pr-4">اقرأ أيضاً</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <?php while ($related_news->have_posts()) : $related_news->the_post(); ?>
                <a href="<?php the_permalink(); ?>" class="group block rounded-lg overflow-hidden hover:shadow-md transition" style="background-color: var(--theme-gray-50);">
                    <?php if (has_post_thumbnail()) : ?>
                        <div class="h-40 overflow-hidden">
                            <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover group-hover:scale-105 transition duration-500')); ?>
                        </div>
                    <?php endif; ?>
                    <div class="p-4">
                        <span class="text-xs font-bold" style="color: var(--theme-accent);"><?php echo get_the_date(); ?></span>
                        <h4 class="font-bold mt-1 group-hover:text-accent transition" style="color: var(--theme-gray-800);"><?php the_title(); ?></h4>
                    </div>
                </a>
            <?php endwhile; ?>
        </div>
    </div>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>

