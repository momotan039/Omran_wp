<?php
/**
 * Food Preset - Blog Archive Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="font-sans antialiased text-brand-black bg-brand-cream min-h-screen relative overflow-x-hidden">
<?php
$blog_title = alomran_get_option('food_blog_title', 'المجلة والنمط الغذائي');
$posts_per_page = alomran_get_option('food_blog_posts_per_page', 6);
$paged = get_query_var('paged') ?: 1;

$blog_query = alomran_food_get_blog_posts(array(
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
));
?>
<div class="pt-40 pb-20 bg-brand-cream min-h-screen">
    <div class="max-w-7xl mx-auto px-8">
        <h1 class="text-7xl font-black text-center mb-24"><?php echo esc_html($blog_title); ?></h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
            <?php if ($blog_query->have_posts()): ?>
                <?php while ($blog_query->have_posts()): $blog_query->the_post(); ?>
                    <a href="<?php the_permalink(); ?>" class="flex flex-col gap-8 group cursor-pointer">
                        <div class="overflow-hidden h-[450px] luxury-shadow" style="border-radius: 50px;">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                            <?php endif; ?>
                        </div>
                        <div class="text-right">
                            <span class="text-brand-gold font-bold uppercase tracking-widest text-sm mb-4 block"><?php echo get_the_date('d F Y'); ?></span>
                            <h3 class="text-4xl font-black mb-6 group-hover:text-brand-gold transition-colors"><?php the_title(); ?></h3>
                            <p class="text-xl text-brand-gray leading-relaxed mb-8 line-clamp-3"><?php echo esc_html(get_the_excerpt()); ?></p>
                            <span class="font-black text-lg border-b-2 border-brand-black pb-1 hover:border-brand-gold transition-all">اقرأ المقال</span>
                        </div>
                    </a>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="col-span-full text-center text-gray-500 py-12">
                    <p>لا توجد مقالات متاحة حالياً.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <?php
        // Pagination
        if ($blog_query->max_num_pages > 1) {
            AlOmran_Preset_Loader::get_template_part('pagination', '', array('query' => $blog_query), 'common');
        }
        ?>
    </div>
</div>
</div>

<?php get_footer(); ?>

