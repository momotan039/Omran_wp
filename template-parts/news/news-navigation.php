<?php
/**
 * News Navigation Section
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="mt-8 pt-8 border-t border-gray-100 flex justify-between items-center">
    <a 
        href="<?php echo esc_url(get_post_type_archive_link('news') ?: home_url('/news')); ?>" 
        class="text-gray-500 hover:text-primary font-bold flex items-center gap-2 transition-colors"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        العودة للأخبار
    </a>
</div>

