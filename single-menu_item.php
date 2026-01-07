<?php
/**
 * Food Preset - Single Menu Item Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<?php
while (have_posts()): the_post();
    $price = alomran_food_get_menu_item_price(get_the_ID());
    $name_en = alomran_food_get_menu_item_name_en(get_the_ID());
    $category = alomran_food_get_menu_item_category(get_the_ID());
    
    // Get similar items
    $similar_args = array(
        'post_type'      => 'menu_item',
        'posts_per_page' => 4,
        'post__not_in'   => array(get_the_ID()),
    );
    
    if ($category) {
        $similar_args['tax_query'] = array(
            array(
                'taxonomy' => 'menu_category',
                'field'    => 'term_id',
                'terms'    => $category->term_id,
            ),
        );
    }
    
    $similar_query = new WP_Query($similar_args);
?>
<div class="font-sans antialiased text-brand-black bg-brand-cream min-h-screen relative overflow-x-hidden">
<div class="pt-32 pb-20 bg-brand-cream min-h-screen">
    <div class="max-w-7xl mx-auto px-8">
        <a href="<?php echo esc_url(get_post_type_archive_link('menu_item')); ?>" class="flex items-center gap-2 text-brand-gray hover:text-brand-gold font-bold mb-12 transition-colors">
            <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            <span>العودة للقائمة</span>
        </a>
        
        <div class="grid lg:grid-cols-2 gap-20 items-start">
            <div class="sticky top-40 overflow-hidden luxury-shadow aspect-square lg:aspect-auto lg:h-[700px]" style="border-radius: 50px;">
                <?php if (has_post_thumbnail()): ?>
                    <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover', 'loading' => 'eager', 'decoding' => 'async')); ?>
                <?php else: ?>
                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                        <span class="text-gray-400">لا توجد صورة</span>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="text-right">
                <?php if ($category): 
                    $category_names = array(
                        'starters' => 'صنف مميز',
                        'mains' => 'طبق رئيسي',
                        'desserts' => 'حلويات',
                        'drinks' => 'مشروبات'
                    );
                    $category_display = isset($category_names[$category->slug]) ? $category_names[$category->slug] : $category->name;
                ?>
                    <span class="text-brand-gold px-6 py-2 rounded-full font-bold text-sm uppercase tracking-widest mb-6 inline-block" style="background-color: rgba(212, 175, 55, 0.1);">
                        <?php echo esc_html($category_display); ?>
                    </span>
                <?php endif; ?>
                <h1 class="text-6xl font-black mb-4"><?php the_title(); ?></h1>
                <?php if ($name_en): ?>
                    <h2 class="text-2xl text-brand-gold font-light tracking-widest mb-8 opacity-60 uppercase"><?php echo esc_html($name_en); ?></h2>
                <?php endif; ?>
                <div class="text-4xl font-black text-brand-black mb-12 border-b border-brand-black/10 pb-8"><?php echo esc_html($price); ?></div>
                
                <div class="space-y-12">
                    <div>
                        <h3 class="text-xl font-black mb-4 border-r-4 border-brand-gold pr-4">وصف الطبق</h3>
                        <p class="text-xl text-brand-gray leading-loose"><?php echo wp_strip_all_tags(get_the_content()); ?></p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-8">
                        <div class="bg-white p-8 rounded-[30px] luxury-shadow">
                            <h4 class="font-bold text-brand-gold mb-2 text-sm uppercase tracking-widest">توصية الشيف</h4>
                            <p class="text-brand-gray">يُفضل تناوله في أجواء الجوهرة الهادئة مع التوابل الخاصة.</p>
                        </div>
                        <div class="bg-white p-8 rounded-[30px] luxury-shadow">
                            <h4 class="font-bold text-brand-gold mb-2 text-sm uppercase tracking-widest">المكونات</h4>
                            <p class="text-brand-gray">مكونات عضوية مختارة من أجود المزارع المحلية والعالمية.</p>
                        </div>
                    </div>
                    
                    <div class="pt-10 flex flex-col sm:flex-row gap-6">
                        <a href="<?php echo esc_url(alomran_format_url('/reservations')); ?>" class="flex-1 bg-brand-black text-white py-6 rounded-3xl font-black text-2xl hover:bg-brand-gold hover:text-brand-black transition-all shadow-xl text-center">
                            احجز طاولتك الآن
                        </a>
                        <div class="flex-1">
                            <?php
                            AlOmran_Preset_Loader::get_template_part('share-options', '', array(
                                'title' => get_the_title(),
                                'url' => get_permalink()
                            ), 'common');
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php if ($similar_query->have_posts()): ?>
            <div class="mt-40">
                <h2 class="text-4xl font-black mb-12 text-center">أطباق قد تعجبك</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    <?php while ($similar_query->have_posts()): $similar_query->the_post(); ?>
                        <a href="<?php the_permalink(); ?>" class="cursor-pointer group" onclick="window.scrollTo({top: 0, behavior: 'smooth'});">
                            <div class="rounded-[30px] overflow-hidden aspect-square mb-6">
                                <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('medium', array('class' => 'w-full h-full object-cover group-hover:scale-110 transition-transform duration-700', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                                <?php else: ?>
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400 text-sm">لا توجد صورة</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <h3 class="text-xl font-bold text-center group-hover:text-brand-gold transition-colors"><?php the_title(); ?></h3>
                        </a>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>
<?php endwhile; ?>

<?php get_footer(); ?>

