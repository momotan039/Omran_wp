<?php
/**
 * The template for displaying product archives
 *
 * @package AlOmran
 */

get_header();

$current_category = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : 'ALL';
$search_term = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

$args = array(
    'post_type' => 'product',
    'posts_per_page' => 12,
    'paged' => get_query_var('paged') ? get_query_var('paged') : 1,
);

if ($current_category !== 'ALL') {
    $args['meta_query'] = array(
        array(
            'key' => 'product_category_enum',
            'value' => $current_category,
            'compare' => '='
        )
    );
}

if ($search_term) {
    $args['s'] = $search_term;
}

$products_query = new WP_Query($args);
?>

<div class="bg-gray-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        <!-- Header -->
        <div class="text-center mb-12 animate-fade-in-up">
            <h1 class="text-4xl font-bold text-primary mb-4">منتجاتنا</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                تصفح مجموعتنا الواسعة من حلول الصرف والمعالجة المصممة وفق أعلى المعايير العالمية.
            </p>
        </div>

        <!-- Filter & Search Toolbar -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-12 flex flex-col md:flex-row gap-6 items-center justify-between border border-gray-100 animate-fade-in-up delay-200">
            
            <!-- Categories -->
            <div class="flex flex-wrap gap-2 justify-center md:justify-start">
                <a href="<?php echo esc_url(remove_query_arg('category')); ?>" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all <?php echo $current_category === 'ALL' ? 'bg-primary text-white scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'; ?>">
                    الكل
                </a>
                <a href="<?php echo esc_url(add_query_arg('category', 'DRAIN_GRILLS')); ?>" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all <?php echo $current_category === 'DRAIN_GRILLS' ? 'bg-primary text-white scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'; ?>">
                    مصافي وجريلات
                </a>
                <a href="<?php echo esc_url(add_query_arg('category', 'GREASE_TRAPS')); ?>" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all <?php echo $current_category === 'GREASE_TRAPS' ? 'bg-primary text-white scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'; ?>">
                    مصائد شحوم
                </a>
                <a href="<?php echo esc_url(add_query_arg('category', 'WATER_TREATMENT')); ?>" 
                   class="px-4 py-2 rounded-full text-sm font-bold transition-all <?php echo $current_category === 'WATER_TREATMENT' ? 'bg-primary text-white scale-105' : 'bg-gray-100 text-gray-600 hover:bg-gray-200'; ?>">
                    معالجة مياه
                </a>
            </div>

            <!-- Search -->
            <form method="get" class="relative w-full md:w-1/3">
                <input 
                    type="text" 
                    name="search" 
                    placeholder="ابحث عن منتج..." 
                    value="<?php echo esc_attr($search_term); ?>"
                    class="w-full pr-10 pl-4 py-2 border border-gray-200 rounded-lg focus:outline-none focus:border-secondary focus:ring-1 focus:ring-secondary transition-colors"
                />
                <button type="submit" class="absolute right-3 top-2.5 text-gray-400 hover:text-secondary transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>
        </div>

        <!-- Products Grid -->
        <?php if ($products_query->have_posts()) : ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                    <?php get_template_part('template-parts/product-card'); ?>
                <?php endwhile; ?>
            </div>

            <!-- Pagination -->
            <?php
            $big = 999999999;
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $products_query->max_num_pages,
                'prev_text' => __('&laquo; السابق', 'alomran'),
                'next_text' => __('التالي &raquo;', 'alomran'),
                'type' => 'list',
                'end_size' => 2,
                'mid_size' => 1,
            ));
            wp_reset_postdata();
            ?>
        <?php else : ?>
            <div class="text-center py-20 bg-white rounded-lg border border-dashed border-gray-300 animate-scale-in">
                <svg class="mx-auto text-gray-300 mb-4 w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                </svg>
                <h3 class="text-xl font-bold text-gray-500">لا توجد منتجات تطابق بحثك</h3>
                <p class="text-gray-400 mt-2">جرب تغيير كلمات البحث أو الفلاتر</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>

