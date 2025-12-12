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
<div class="mt-8 pt-8 border-t flex justify-between items-center" style="border-color: var(--theme-gray-100);">
    <a 
        href="<?php echo esc_url(get_post_type_archive_link('news') ?: home_url('/news')); ?>" 
        class="hover:text-accent font-bold flex items-center gap-2 transition-colors"
        style="color: var(--theme-gray-500);"
    >
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        العودة للأخبار
    </a>
</div>

