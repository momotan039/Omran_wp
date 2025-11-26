<?php
/**
 * The template for displaying single products
 *
 * @package AlOmran
 */

get_header();

while (have_posts()) : the_post();
    $short_description = get_field('short_description') ?: '';
    $full_description = get_the_content();
    $price = get_field('price') ?: 'تواصل للسعر';
    $category_enum = get_field('product_category_enum') ?: '';
    $features_raw = get_field('features') ?: '';
    $specs_raw = get_field('specs') ?: '';
    $features = alomran_parse_features($features_raw);
    $specs = alomran_parse_specs($specs_raw);
    $is_featured = get_field('is_featured') ?: false;
?>

<div class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-500 mb-8 animate-fade-in-up">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-secondary">الرئيسية</a>
            <span class="mx-2">/</span>
            <a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="hover:text-secondary">المنتجات</a>
            <span class="mx-2">/</span>
            <span class="text-primary font-bold"><?php the_title(); ?></span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Image Gallery -->
            <div class="space-y-4 animate-slide-in-right">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="aspect-square bg-gray-50 rounded-xl overflow-hidden shadow-lg border border-gray-200 group cursor-zoom-in relative">
                        <div class="absolute inset-0 bg-primary/5 group-hover:bg-transparent transition"></div>
                        <?php the_post_thumbnail('product-large', array('class' => 'w-full h-full object-cover transition-transform duration-500 group-hover:scale-125')); ?>
                    </div>
                <?php endif; ?>
                <!-- Thumbnails can be added here if multiple images are needed -->
            </div>

            <!-- Content -->
            <div class="animate-fade-in-up delay-200">
                <div class="flex items-center gap-3 mb-4">
                    <?php if ($category_enum) : ?>
                        <span class="bg-secondary/10 text-secondary px-3 py-1 rounded text-sm font-bold">
                            <?php echo esc_html(alomran_get_product_category_label($category_enum)); ?>
                        </span>
                    <?php endif; ?>
                    <?php if ($is_featured) : ?>
                        <span class="text-yellow-500 flex items-center text-sm gap-1 animate-pulse">★ منتج مميز</span>
                    <?php endif; ?>
                </div>

                <h1 class="text-3xl md:text-4xl font-black text-primary mb-6"><?php the_title(); ?></h1>
                
                <?php if ($short_description || $full_description) : ?>
                    <p class="text-gray-600 text-lg leading-relaxed mb-8">
                        <?php echo $full_description ?: esc_html($short_description); ?>
                    </p>
                <?php endif; ?>

                <!-- Special Feature Highlight for Rodent Prevention -->
                <?php if (strpos(get_the_title(), 'قوارض') !== false || strpos(get_the_title(), 'قارض') !== false) : ?>
                    <div class="bg-red-50 border-r-4 border-red-500 p-4 rounded mb-8 animate-scale-in">
                        <h4 class="font-bold text-red-700 flex items-center gap-2">
                            <span class="text-xl">🚫</span> نظام حماية قصوى
                        </h4>
                        <p class="text-red-600 mt-1 text-sm">هذا المنتج مزود بتقنية الغلق الذاتي لمنع دخول القوارض والحشرات بنسبة 100%.</p>
                    </div>
                <?php endif; ?>

                <!-- Specs Table -->
                <?php if ($specs) : ?>
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-primary mb-4 border-b pb-2">المواصفات الفنية</h3>
                        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                            <?php foreach ($specs as $index => $spec) : ?>
                                <div class="flex justify-between py-3 px-4 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <span class="font-bold text-gray-700"><?php echo esc_html($spec['label']); ?></span>
                                    <span class="text-gray-600 dir-ltr"><?php echo esc_html($spec['value']); ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Features List -->
                <?php if ($features) : ?>
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-primary mb-4">المميزات الرئيسية</h3>
                        <ul class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <?php foreach ($features as $idx => $feature) : ?>
                                <li class="flex items-center gap-2 text-gray-600 hover:text-primary transition-colors">
                                    <svg class="w-4 h-4 text-secondary flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span><?php echo esc_html($feature['feature_text']); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <!-- Actions -->
                <div class="flex flex-col md:flex-row gap-4 mt-8">
                    <a href="<?php echo esc_url(alomran_get_page_url('تواصل معنا') ?: alomran_get_page_url('contact') ?: home_url('/contact')); ?>" class="flex-1 bg-primary text-white py-4 rounded-lg font-bold hover:bg-green-800 transition flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-[1.02] duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        اطلب عرض سعر
                    </a>
                    <button class="flex-1 border-2 border-gray-200 text-gray-700 py-4 rounded-lg font-bold hover:border-secondary hover:text-secondary transition flex items-center justify-center gap-2 hover:bg-gray-50">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                        تحميل الكتالوج
                    </button>
                    <button class="w-14 h-14 border-2 border-gray-200 rounded-lg flex items-center justify-center hover:bg-gray-50 text-gray-500 hover:text-secondary hover:border-secondary transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                        </svg>
                    </button>
                </div>
                
                <div class="mt-6 text-sm text-gray-400 text-center">
                    منتج مطابق للمواصفات القياسية المصرية (ES) والأوروبية (EN)
                </div>
            </div>
        </div>
    </div>
</div>

<?php
endwhile;
get_footer();
?>

