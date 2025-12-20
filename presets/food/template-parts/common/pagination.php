<?php
/**
 * Food Preset - Custom Pagination Component
 * Matches React app design with animated page numbers
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

$query = isset($args['query']) ? $args['query'] : $GLOBALS['wp_query'];
$current_page = max(1, $query->get('paged') ?: 1);
$total_pages = $query->max_num_pages;

if ($total_pages <= 1) {
    return;
}

// Get the base URL for pagination
$base_url = get_pagenum_link(1);
$base_url = remove_query_arg('paged', $base_url);
// If it's a custom query, we need to handle the URL differently
if (isset($args['query']) && $args['query'] !== $GLOBALS['wp_query']) {
    // For custom queries, use the current page URL
    $base_url = get_permalink();
    if (is_archive()) {
        $base_url = get_post_type_archive_link(get_post_type());
    }
}
if (strpos($base_url, '?') !== false) {
    $base_url .= '&';
} else {
    $base_url .= '?';
}
?>
<div class="mt-24 flex justify-center items-center gap-6">
    <?php if ($current_page > 1): ?>
        <a 
            href="<?php echo esc_url($base_url . 'paged=' . ($current_page - 1)); ?>" 
            class="w-16 h-16 rounded-full border border-gray-200 flex items-center justify-center hover:bg-brand-black hover:text-brand-gold hover:border-brand-black transition-all group"
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
            $page_url = $i === 1 ? remove_query_arg('paged', $base_url) : ($base_url . 'paged=' . $i);
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
            href="<?php echo esc_url($base_url . 'paged=' . ($current_page + 1)); ?>" 
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

