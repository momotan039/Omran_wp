<?php
/**
 * Food Preset - Single Blog Post Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

while (have_posts()): the_post();
    $share_url = get_permalink();
    $share_title = get_the_title();
?>
<div class="font-sans antialiased text-brand-black bg-brand-cream min-h-screen relative overflow-x-hidden">
<div class="bg-brand-cream min-h-screen">
    <div class="relative h-[70vh] w-full">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover', 'loading' => 'eager', 'decoding' => 'async')); ?>
        <?php endif; ?>
        <div class="absolute inset-0" style="background: linear-gradient(to top, #FAF9F6, transparent);" />
        <div class="absolute top-40 left-8">
            <a href="<?php echo esc_url(get_post_type_archive_link('blog_post')); ?>" class="bg-white/90 backdrop-blur-md p-4 rounded-full luxury-shadow hover:scale-110 transition-all text-brand-black">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </a>
        </div>
    </div>
    
    <div class="max-w-4xl mx-auto px-8 -mt-32 relative z-10 pb-40">
        <div class="bg-white p-16 luxury-shadow text-right" style="border-radius: 60px;">
            <div class="flex justify-between items-center mb-10">
                <div class="flex gap-4 text-brand-gray text-sm">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        ٥ دقائق قراءة
                    </span>
                    <button onclick="navigator.share({title: '<?php echo esc_js($share_title); ?>', url: '<?php echo esc_url($share_url); ?>'})" class="flex items-center gap-2 hover:text-brand-gold transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                        </svg>
                        مشاركة
                    </button>
                </div>
                <span class="text-brand-gold font-bold uppercase tracking-widest"><?php echo get_the_date('d F Y'); ?></span>
            </div>
            
            <h1 class="text-5xl md:text-6xl font-black mb-12 leading-tight"><?php the_title(); ?></h1>
            
            <div class="prose prose-xl prose-brand max-w-none">
                <p class="text-2xl text-brand-gray leading-relaxed mb-12 font-light italic border-r-4 border-brand-gold pr-8">
                    <?php echo esc_html(get_the_excerpt()); ?>
                </p>
                
                <div class="text-xl text-brand-gray leading-[2] whitespace-pre-wrap">
                    <?php the_content(); ?>
                </div>
            </div>
            
            <div class="mt-20 pt-10 border-t border-gray-100 flex justify-between items-center">
                <div class="flex gap-4">
                    <a href="https://wa.me/?text=<?php echo urlencode($share_title . ' ' . $share_url); ?>" target="_blank" rel="noopener" class="w-12 h-12 bg-brand-black rounded-full flex items-center justify-center text-brand-gold hover:bg-[#25D366] hover:text-white transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?text=<?php echo urlencode($share_title); ?>&url=<?php echo urlencode($share_url); ?>" target="_blank" rel="noopener" class="w-12 h-12 bg-brand-black rounded-full flex items-center justify-center text-brand-gold hover:bg-black hover:text-white transition-colors cursor-pointer">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </a>
                </div>
                <div class="text-right">
                    <p class="text-xs text-brand-gray uppercase tracking-widest mb-1">الكاتب</p>
                    <p class="font-black text-lg"><?php the_author(); ?></p>
                </div>
            </div>
        </div>
        
        <?php
        // Next Post Preview
        $next_post = get_next_post();
        if ($next_post):
            setup_postdata($next_post);
        ?>
        <div class="mt-24 bg-brand-black text-white p-12 rounded-[50px] luxury-shadow flex justify-between items-center cursor-pointer hover:bg-brand-gold hover:text-brand-black transition-all group">
            <a href="<?php echo esc_url(get_permalink($next_post)); ?>" class="flex items-center gap-6">
                <svg class="w-10 h-10 group-hover:-translate-x-2 transition-transform rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                <div>
                    <p class="text-xs uppercase tracking-[0.3em] opacity-50 mb-1">المقال التالي</p>
                    <h4 class="text-2xl font-bold"><?php echo esc_html(get_the_title($next_post)); ?></h4>
                </div>
            </a>
            <div class="hidden md:block h-20 w-32 rounded-2xl overflow-hidden">
                <?php if (has_post_thumbnail($next_post)): ?>
                    <?php echo get_the_post_thumbnail($next_post, 'thumbnail', array('class' => 'w-full h-full object-cover', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                <?php endif; ?>
            </div>
        </div>
        <?php
            wp_reset_postdata();
        endif;
        ?>
    </div>
</div>
</div>
<?php endwhile; ?>

<?php get_footer(); ?>

