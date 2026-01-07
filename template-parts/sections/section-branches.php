<?php
/**
 * Food Preset - Branches Section Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

$branches_enable = alomran_get_option('food_branches_enable', true);
if (!$branches_enable) {
    return;
}

$branches_title = alomran_get_option('food_branches_title', 'فروعنا');
$branches_subtitle = alomran_get_option('food_branches_subtitle', 'نتشرف بزيارتكم في مواقعنا المميزة');
$branches_description = alomran_get_option('food_branches_description', 'زورونا في أحد فروعنا المنتشرة في المنطقة.');
$branches_query = alomran_food_get_branches(array('posts_per_page' => 3));
?>
<section id="branches" class="py-32 bg-brand-cream relative overflow-hidden homepage-branches">
    <!-- Decorative background element -->
    <div class="absolute top-0 left-0 w-96 h-96 bg-brand-gold/5 blur-[120px] rounded-full" style="width: 384px; height: 384px; background-color: rgba(212, 175, 55, 0.05); filter: blur(120px); border-radius: 9999px;"></div>
    
    <div class="max-w-7xl mx-auto px-8 relative z-10">
        <!-- Section Header -->
        <div class="text-center mb-20 branches-header">
            <span class="text-brand-gray font-bold tracking-widest uppercase mb-6 block branches-subtitle"><?php echo esc_html($branches_subtitle); ?></span>
            <h2 class="text-5xl md:text-6xl font-black text-brand-black mb-6 branches-title"><?php echo esc_html($branches_title); ?></h2>
            <?php if (!empty($branches_description)): ?>
                <p class="text-xl text-brand-gray max-w-2xl mx-auto leading-relaxed branches-description"><?php echo esc_html($branches_description); ?></p>
            <?php endif; ?>
        </div>

        <!-- Branches Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-16 branches-grid">
            <?php if ($branches_query->have_posts()): ?>
                <?php $branch_index = 0; while ($branches_query->have_posts()): $branches_query->the_post(); ?>
                    <?php
                    $city = alomran_food_get_branch_city(get_the_ID());
                    $address = alomran_food_get_branch_address(get_the_ID());
                    $phone = alomran_food_get_branch_phone(get_the_ID());
                    $map_link = alomran_food_get_branch_map_link(get_the_ID());
                    ?>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="group relative overflow-hidden cursor-pointer luxury-shadow hover:-translate-y-2 transition-all duration-500 branch-card" style="border-radius: 40px;" data-delay="<?php echo $branch_index * 150; ?>">
                        <!-- Image -->
                        <div class="aspect-[4/5] w-full overflow-hidden">
                            <?php if (has_post_thumbnail()): ?>
                                <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br from-brand-black to-brand-gray flex items-center justify-center">
                                    <svg class="w-24 h-24 text-brand-gold/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Overlay with content -->
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(10, 10, 10, 0.95), rgba(10, 10, 10, 0.5), transparent);"></div>
                        
                        <div class="absolute inset-0 flex flex-col justify-end p-8">
                            <!-- City Badge -->
                            <?php if ($city): ?>
                                <div class="mb-4">
                                    <span class="inline-block px-4 py-2 bg-brand-gold text-brand-black text-sm font-black rounded-full">
                                        <?php echo esc_html($city); ?>
                                    </span>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Title -->
                            <h3 class="text-3xl font-black text-white mb-3 group-hover:text-brand-gold transition-colors">
                                <?php the_title(); ?>
                            </h3>
                            
                            <!-- Address -->
                            <?php if ($address): ?>
                                <div class="flex items-start gap-3 mb-4 text-gray-300">
                                    <svg class="w-5 h-5 text-brand-gold mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <p class="text-sm leading-relaxed"><?php echo esc_html($address); ?></p>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Phone -->
                            <?php if ($phone): ?>
                                <div class="flex items-center gap-3 mb-6 text-gray-300">
                                    <svg class="w-5 h-5 text-brand-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                    </svg>
                                    <span class="text-sm font-medium"><?php echo esc_html($phone); ?></span>
                                </div>
                            <?php endif; ?>
                            
                            <!-- CTA Button -->
                            <div class="translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                                <div class="inline-flex items-center gap-3 text-brand-gold font-black text-lg">
                                    <span>استكشف الفرع</span>
                                    <svg class="w-6 h-6 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>
                <?php $branch_index++; endwhile; ?>
                <?php wp_reset_postdata(); ?>
            <?php else: ?>
                <div class="col-span-full text-center text-gray-500 py-20">
                    <svg class="w-24 h-24 mx-auto mb-6 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <p class="text-xl">لا توجد فروع متاحة حالياً.</p>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- View All Link -->
        <div class="text-center">
            <?php
            // Use the same URL formatting function used throughout the theme
            require_once get_template_directory() . '/inc/helpers/helpers-url.php';
            $branches_page_url = alomran_format_url('/branches');
            ?>
            <a href="<?php echo esc_url($branches_page_url); ?>" class="group inline-flex items-center gap-4 text-xl font-black text-brand-black hover:text-brand-gold transition-colors">
                <span>عرض جميع الفروع</span>
                <div class="w-16 h-16 rounded-full border-2 border-brand-black group-hover:bg-brand-black group-hover:text-white flex items-center justify-center transition-all">
                    <svg class="w-6 h-6 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </div>
            </a>
        </div>
    </div>
</section>

