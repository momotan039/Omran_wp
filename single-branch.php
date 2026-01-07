<?php
/**
 * Food Preset - Single Branch Template
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$city = alomran_food_get_branch_city(get_the_ID());
$address = alomran_food_get_branch_address(get_the_ID());
$phone = alomran_food_get_branch_phone(get_the_ID());
$map_link = alomran_food_get_branch_map_link(get_the_ID());
$name_en = alomran_food_get_branch_name_en(get_the_ID());
?>

<div class="w-full font-sans antialiased text-brand-black bg-brand-cream min-h-screen">
    <!-- Hero Section with Image -->
    <section class="relative h-[70vh] min-h-[500px] overflow-hidden">
        <?php if (has_post_thumbnail()): ?>
            <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover', 'loading' => 'eager', 'decoding' => 'async')); ?>
        <?php else: ?>
            <div class="w-full h-full bg-gradient-to-br from-brand-black to-brand-gray"></div>
        <?php endif; ?>
        
        <!-- Overlay -->
        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(10, 10, 10, 0.9), rgba(10, 10, 10, 0.3), transparent);"></div>
        
        <!-- Content -->
        <div class="absolute inset-0 flex items-end">
            <div class="max-w-7xl mx-auto px-8 pb-20 w-full">
                <div class="max-w-3xl">
                    <?php if ($city): ?>
                        <span class="inline-block px-6 py-3 bg-brand-gold text-brand-black text-lg font-black rounded-full mb-6">
                            <?php echo esc_html($city); ?>
                        </span>
                    <?php endif; ?>
                    
                    <h1 class="text-6xl md:text-7xl font-black text-white mb-6">
                        <?php the_title(); ?>
                    </h1>
                    
                    <?php if ($name_en): ?>
                        <p class="text-2xl text-brand-gold font-bold mb-8"><?php echo esc_html($name_en); ?></p>
                    <?php endif; ?>
                    
                    <?php if ($address): ?>
                        <div class="flex items-start gap-4 text-white mb-6">
                            <svg class="w-6 h-6 text-brand-gold mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <p class="text-xl leading-relaxed"><?php echo esc_html($address); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-20">
        <div class="max-w-7xl mx-auto px-8">
            <div class="grid lg:grid-cols-3 gap-16">
                <!-- Main Content Column -->
                <div class="lg:col-span-2">
                    <!-- Description -->
                    <div class="prose prose-lg max-w-none mb-16">
                        <div class="text-2xl text-brand-gray leading-relaxed">
                            <?php the_content(); ?>
                        </div>
                    </div>
                    
                    <!-- Gallery (if multiple images) -->
                    <?php if (has_post_thumbnail()): ?>
                        <div class="mb-16">
                            <h2 class="text-4xl font-black mb-8">معرض الصور</h2>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="aspect-video overflow-hidden luxury-shadow" style="border-radius: 30px;">
                                    <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover')); ?>
                                </div>
                                <?php
                                // Get additional images from gallery if available
                                $gallery = get_post_meta(get_the_ID(), '_branch_gallery', true);
                                if ($gallery && is_array($gallery) && !empty($gallery)):
                                    foreach (array_slice($gallery, 0, 3) as $image_id):
                                ?>
                                    <div class="aspect-video overflow-hidden luxury-shadow" style="border-radius: 30px;">
                                        <?php echo wp_get_attachment_image($image_id, 'large', false, array('class' => 'w-full h-full object-cover', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                                    </div>
                                <?php
                                    endforeach;
                                endif;
                                ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
                <!-- Sidebar with Contact Info -->
                <div class="lg:col-span-1">
                    <div class="sticky top-24">
                        <!-- Contact Card -->
                        <div class="bg-white luxury-shadow p-10 mb-8" style="border-radius: 40px;">
                            <h3 class="text-3xl font-black mb-8">معلومات التواصل</h3>
                            
                            <!-- Address -->
                            <?php if ($address): ?>
                                <div class="mb-8 pb-8 border-b border-gray-200">
                                    <div class="flex items-start gap-4 mb-4">
                                        <svg class="w-6 h-6 text-brand-gold mt-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div>
                                            <h4 class="font-black text-lg mb-2">العنوان</h4>
                                            <p class="text-brand-gray leading-relaxed"><?php echo esc_html($address); ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Phone -->
                            <?php if ($phone): ?>
                                <div class="mb-8 pb-8 border-b border-gray-200">
                                    <div class="flex items-center gap-4 mb-4">
                                        <svg class="w-6 h-6 text-brand-gold flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                        <div>
                                            <h4 class="font-black text-lg mb-2">الهاتف</h4>
                                            <a href="tel:<?php echo esc_attr(preg_replace('/[^0-9+]/', '', $phone)); ?>" class="text-brand-gold hover:text-brand-black transition-colors font-bold text-lg">
                                                <?php echo esc_html($phone); ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Map Link -->
                            <?php if ($map_link && $map_link !== '#'): ?>
                                <div class="mb-8">
                                    <a 
                                        href="<?php echo esc_url($map_link); ?>" 
                                        target="_blank" 
                                        rel="noopener noreferrer"
                                        class="group w-full bg-brand-black text-white py-6 px-8 rounded-full font-black text-lg flex items-center justify-center gap-4 hover:bg-brand-gold hover:text-brand-black transition-all duration-300"
                                    >
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                        </svg>
                                        <span>احصل على الاتجاهات</span>
                                        <svg class="w-5 h-5 rtl:rotate-180 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Reservation Button -->
                            <a 
                                href="<?php echo esc_url(alomran_format_url('/reservations')); ?>" 
                                class="w-full bg-brand-gold text-brand-black py-6 px-8 rounded-full font-black text-lg flex items-center justify-center gap-4 hover:bg-brand-black hover:text-white transition-all duration-300"
                            >
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>احجز طاولتك</span>
                            </a>
                        </div>
                        
                        <!-- Back to Branches -->
                        <a 
                            href="<?php echo esc_url(home_url('/#branches')); ?>" 
                            class="group flex items-center gap-4 text-brand-gray hover:text-brand-black font-bold transition-colors"
                        >
                            <svg class="w-5 h-5 rtl:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>العودة إلى الفروع</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Other Branches Section -->
    <?php
    $other_branches = new WP_Query(array(
        'post_type' => 'branch',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()),
        'orderby' => 'menu_order',
        'order' => 'ASC',
    ));
    
    if ($other_branches->have_posts()):
    ?>
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-8">
            <h2 class="text-5xl font-black text-center mb-16">فروع أخرى</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <?php while ($other_branches->have_posts()): $other_branches->the_post(); ?>
                    <?php
                    $other_city = alomran_food_get_branch_city(get_the_ID());
                    $other_address = alomran_food_get_branch_address(get_the_ID());
                    ?>
                    <a href="<?php the_permalink(); ?>" class="group relative overflow-hidden cursor-pointer luxury-shadow hover:-translate-y-2 transition-all duration-500" style="border-radius: 40px;">
                        <div class="aspect-[4/5] w-full overflow-hidden">
                            <?php if (has_post_thumbnail()): ?>
                                    <?php the_post_thumbnail('large', array('class' => 'w-full h-full object-cover transition-transform duration-700 group-hover:scale-110', 'loading' => 'lazy', 'decoding' => 'async')); ?>
                            <?php else: ?>
                                <div class="w-full h-full bg-gradient-to-br from-brand-black to-brand-gray"></div>
                            <?php endif; ?>
                        </div>
                        <div class="absolute inset-0" style="background: linear-gradient(to top, rgba(10, 10, 10, 0.95), rgba(10, 10, 10, 0.5), transparent);"></div>
                        <div class="absolute inset-0 flex flex-col justify-end p-8">
                            <?php if ($other_city): ?>
                                <span class="inline-block px-4 py-2 bg-brand-gold text-brand-black text-sm font-black rounded-full mb-4 w-fit">
                                    <?php echo esc_html($other_city); ?>
                                </span>
                            <?php endif; ?>
                            <h3 class="text-2xl font-black text-white mb-2 group-hover:text-brand-gold transition-colors">
                                <?php the_title(); ?>
                            </h3>
                            <?php if ($other_address): ?>
                                <p class="text-sm text-gray-300 line-clamp-2"><?php echo esc_html($other_address); ?></p>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endwhile; ?>
                <?php wp_reset_postdata(); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
</div>

<?php get_footer(); ?>

