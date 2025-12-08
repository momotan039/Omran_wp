<?php
/**
 * The template for displaying product archives
 *
 * @package AlOmran
 */

get_header();

// Get current category and search term
$current_category_term = alomran_get_current_taxonomy_term('product_category');
$current_category_slug = $current_category_term ? $current_category_term->slug : '';
$search_term = isset($_GET['search']) ? sanitize_text_field($_GET['search']) : '';

// Build products query
if (is_tax('product_category') && empty($search_term)) {
    global $wp_query;
    $products_query = $wp_query;
} else {
    $products_query = alomran_get_products_query(array(
        'category_slug' => $current_category_slug,
        'search_term'   => $search_term,
    ));
}
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
            <?php
            $product_categories = alomran_get_product_categories();
            $archive_url = get_post_type_archive_link('product') ?: home_url('/products');
            echo alomran_get_category_filters_html($product_categories, $current_category_slug, $archive_url);
            ?>

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

        <!-- View Toggle -->
        <?php 
        $current_view = alomran_get_archive_view('product');
        $grid_class = alomran_get_archive_grid_class('product');
        ?>
        <div class="flex justify-end mb-6">
            <div class="bg-white rounded-lg p-1 border border-gray-200 inline-flex gap-1">
                <button onclick="alomranSetView('grid')" class="view-toggle-btn px-4 py-2 rounded <?php echo $current_view === 'grid' ? 'bg-primary text-white' : 'text-gray-600'; ?>" data-view="grid">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                    </svg>
                </button>
                <button onclick="alomranSetView('list')" class="view-toggle-btn px-4 py-2 rounded <?php echo $current_view === 'list' ? 'bg-primary text-white' : 'text-gray-600'; ?>" data-view="list">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Products Grid/List -->
        <?php if ($products_query->have_posts()) : ?>
            <div class="products-archive grid <?php echo esc_attr($grid_class); ?> gap-8" data-view="<?php echo esc_attr($current_view); ?>">
                <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
                    <?php get_template_part('template-parts/product-card'); ?>
                <?php endwhile; ?>
            </div>
            
            <script>
            function alomranSetView(view) {
                document.querySelectorAll('.view-toggle-btn').forEach(function(btn) {
                    btn.classList.remove('bg-primary', 'text-white');
                    btn.classList.add('text-gray-600');
                });
                event.target.classList.add('bg-primary', 'text-white');
                event.target.classList.remove('text-gray-600');
                
                var container = document.querySelector('.products-archive');
                container.setAttribute('data-view', view);
                
                // Store preference
                localStorage.setItem('alomran_product_view', view);
            }
            
            // Restore view preference
            var savedView = localStorage.getItem('alomran_product_view');
            if (savedView) {
                var btn = document.querySelector('[data-view="' + savedView + '"]');
                if (btn) {
                    btn.click();
                }
            }
            </script>

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

