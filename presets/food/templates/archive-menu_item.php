<?php
/**
 * Food Preset - Menu Archive Template
 * Matches React app MenuPage design 100%
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
$menu_title = alomran_get_option('food_menu_title', 'قائمة الطعام');
$menu_description = alomran_get_option('food_menu_description', 'كل طبق هو رحلة عبر الزمن، محضرة بأفضل المكونات الموسمية والتقنيات العصرية.');
$show_categories = alomran_get_option('food_menu_show_categories', true);
$items_per_page = alomran_get_option('food_menu_items_per_page', 6);

// Get current category from URL
$current_category = 'all';
if (is_tax('menu_category')) {
    $term = get_queried_object();
    $current_category = $term->slug;
}

$paged = get_query_var('paged') ?: 1;
$random_order = alomran_get_option('food_menu_random_order', false);

// Build query args
$query_args = array(
    'post_type'      => 'menu_item',
    'posts_per_page' => $items_per_page,
    'paged'          => $paged,
    'post_status'    => 'publish',
    'no_found_rows'  => false, // We need pagination
    'update_post_meta_cache' => true,
    'update_post_term_cache' => true,
);

// Set order based on random option
if ($random_order) {
    $query_args['orderby'] = 'rand';
} else {
    $query_args['orderby'] = 'menu_order';
    $query_args['order'] = 'ASC';
}

if ($current_category !== 'all') {
    $query_args['tax_query'] = array(
        array(
            'taxonomy' => 'menu_category',
            'field'    => 'slug',
            'terms'    => $current_category,
            'operator' => 'IN',
        ),
    );
}

// Ensure we get unique posts only
$query_args['post__not_in'] = array(); // Reset to avoid conflicts
$query_args['suppress_filters'] = false;

$menu_query = new WP_Query($query_args);
$categories = alomran_food_get_menu_categories();

// Build categories array with "all" option
$all_categories = array(
    (object) array('id' => 'all', 'slug' => 'all', 'name' => 'الكل', 'link' => get_post_type_archive_link('menu_item'))
);
foreach ($categories as $cat) {
    $all_categories[] = (object) array(
        'id' => $cat->term_id,
        'slug' => $cat->slug,
        'name' => $cat->name,
        'link' => get_term_link($cat)
    );
}
?>
<div class="pt-40 pb-20 bg-brand-cream min-h-screen">
    <div class="max-w-4xl mx-auto px-8 text-center">
        <?php $menu_subtitle = alomran_get_option('food_menu_subtitle', "Chef's Selection"); ?>
        <?php if (!empty($menu_subtitle)): ?>
            <span class="text-brand-gold font-bold tracking-widest uppercase text-sm mb-6 block">
                <?php echo esc_html($menu_subtitle); ?>
            </span>
        <?php endif; ?>
        <h1 class="text-7xl font-black mb-12"><?php echo esc_html($menu_title); ?></h1>
        <p class="text-brand-gray text-xl max-w-2xl mx-auto mb-12"><?php echo esc_html($menu_description); ?></p>
        
        <?php if ($show_categories && !empty($all_categories)): ?>
            <div class="flex flex-wrap justify-center gap-4 mb-16">
                <?php foreach ($all_categories as $cat): ?>
                    <?php
                    $is_active = ($current_category === 'all' && $cat->slug === 'all') || ($current_category === $cat->slug);
                    $active_classes = $is_active 
                        ? 'bg-brand-black text-brand-gold border-brand-black scale-105 shadow-xl' 
                        : 'bg-white text-brand-gray border-gray-100 hover:border-brand-gold';
                    ?>
                    <a 
                        href="<?php echo esc_url($cat->link); ?>" 
                        class="px-10 py-4 rounded-full font-black text-lg transition-all duration-500 border <?php echo esc_attr($active_classes); ?>"
                    >
                        <?php echo esc_html($cat->name); ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="max-w-7xl mx-auto px-8">
        <div class="relative min-h-[600px]">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <?php if ($menu_query->have_posts()): ?>
                    <?php while ($menu_query->have_posts()): $menu_query->the_post(); ?>
                        <a 
                            href="<?php the_permalink(); ?>" 
                            class="bg-white p-8 rounded-[40px] luxury-shadow group hover:-translate-y-2 transition-transform duration-500 cursor-pointer"
                        >
                            <div class="rounded-[30px] overflow-hidden h-64 mb-8">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400"><?php echo esc_html__('لا توجد صورة', 'alomran'); ?></span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-2xl font-black group-hover:text-brand-gold transition-colors"><?php the_title(); ?></h3>
                                <span class="text-brand-gold font-bold text-xl"><?php echo esc_html(alomran_food_get_menu_item_price(get_the_ID())); ?></span>
                            </div>
                            <p class="text-brand-gray leading-relaxed line-clamp-2"><?php echo esc_html(get_the_excerpt()); ?></p>
                        </a>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else: ?>
                    <div class="col-span-full text-center text-gray-500 py-12">
                        <p>لا توجد أصناف متاحة حالياً.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <?php
        // Pagination - matches React app design exactly
        if ($menu_query->max_num_pages > 1) {
            $current_page = max(1, $paged);
            $total_pages = $menu_query->max_num_pages;
            $base_url = get_post_type_archive_link('menu_item');
            if ($current_category !== 'all') {
                $term = get_term_by('slug', $current_category, 'menu_category');
                if ($term) {
                    $base_url = get_term_link($term);
                }
            }
            $base_url = trailingslashit($base_url);
            ?>
            <div class="mt-24 flex justify-center items-center gap-6">
                <?php if ($current_page > 1): ?>
                    <a 
                        href="<?php echo esc_url($base_url . 'page/' . ($current_page - 1) . '/'); ?>" 
                        class="w-16 h-16 rounded-full border border-gray-200 flex items-center justify-center hover:bg-brand-black hover:text-brand-gold hover:border-brand-black transition-all disabled:opacity-20 disabled:cursor-not-allowed group"
                    >
                        <svg class="w-7 h-7 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </a>
                <?php else: ?>
                    <span class="w-16 h-16 rounded-full border border-gray-200 flex items-center justify-center opacity-20 cursor-not-allowed">
                        <svg class="w-7 h-7 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                        </svg>
                    </span>
                <?php endif; ?>

                <div class="flex gap-4 p-2 bg-white rounded-[24px] luxury-shadow border border-gray-100">
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <?php
                        $is_active = $current_page === $i;
                        $page_url = $i === 1 ? $base_url : $base_url . 'page/' . $i . '/';
                        ?>
                        <a
                            href="<?php echo esc_url($page_url); ?>"
                            class="relative w-14 h-14 flex items-center justify-center font-black text-xl transition-all duration-500 z-10 <?php echo $is_active ? 'text-white' : 'text-brand-gray hover:text-brand-black'; ?>"
                        >
                            <?php if ($is_active): ?>
                                <span class="absolute inset-0 bg-brand-black rounded-2xl -z-10"></span>
                            <?php endif; ?>
                            <?php echo $i; ?>
                        </a>
                    <?php endfor; ?>
                </div>

                <?php if ($current_page < $total_pages): ?>
                    <a 
                        href="<?php echo esc_url($base_url . 'page/' . ($current_page + 1) . '/'); ?>" 
                        class="w-16 h-16 rounded-full border border-gray-200 flex items-center justify-center hover:bg-brand-black hover:text-brand-gold hover:border-brand-black transition-all group"
                    >
                        <svg class="w-7 h-7 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                <?php else: ?>
                    <span class="w-16 h-16 rounded-full border border-gray-200 flex items-center justify-center opacity-20 cursor-not-allowed">
                        <svg class="w-7 h-7 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </span>
                <?php endif; ?>
            </div>
        <?php } ?>
    </div>
</div>
</div>

<?php get_footer(); ?>
