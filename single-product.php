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
    $features_raw = get_field('features') ?: '';
    $specs_raw = get_field('specs') ?: '';
    $features = alomran_parse_features($features_raw);
    $specs = alomran_parse_specs($specs_raw);
    $is_featured = get_field('is_featured') ?: false;
    // Get product categories
    $product_categories = array();
    if (taxonomy_exists('product_category')) {
        $terms = get_the_terms(get_the_ID(), 'product_category');
        if (!is_wp_error($terms) && !empty($terms)) {
            $product_categories = $terms;
        }
    }
    $product_gallery = alomran_get_product_gallery();
    $product_videos = alomran_get_product_videos();
    $current_url = get_permalink();
    $product_title = get_the_title();
    $has_featured_image = has_post_thumbnail();
?>

<div class="py-12 bg-white">
    <div class="container mx-auto px-4">
        <?php alomran_display_ad('content_before', 'mb-8', 'product-ad-before'); ?>
        
        <!-- Breadcrumb -->
        <div class="flex items-center text-sm text-gray-500 mb-8 animate-fade-in-up">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-secondary">الرئيسية</a>
            <span class="mx-2">/</span>
            <a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="hover:text-secondary">المنتجات</a>
            <span class="mx-2">/</span>
            <span class="text-primary font-bold"><?php the_title(); ?></span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
            <!-- Image Gallery & Slider -->
            <div class="space-y-4 animate-slide-in-right">
                <!-- Main Image/Video Container -->
                <div id="product-main-container" class="aspect-square bg-gray-50 rounded-xl overflow-hidden shadow-lg border border-gray-200 relative">
                    <?php if ($has_featured_image) : ?>
                        <?php 
                        $featured_image_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
                        the_post_thumbnail('product-large', array('class' => 'w-full h-full object-cover main-media-item active', 'id' => 'main-product-img', 'data-type' => 'image', 'data-src' => $featured_image_url)); 
                        ?>
                    <?php elseif (!empty($product_gallery)) : ?>
                        <img src="<?php echo esc_url($product_gallery[0]['url']); ?>" alt="<?php echo esc_attr($product_gallery[0]['alt'] ?? get_the_title()); ?>" class="w-full h-full object-cover main-media-item active" id="main-product-img" data-type="image" data-src="<?php echo esc_url($product_gallery[0]['url']); ?>">
                    <?php else : ?>
                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                            <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Media Slider (Images + Videos) -->
                <?php 
                // Prepare all media items (images + videos)
                $all_media = array();
                
                // Add featured image if exists
                if ($has_featured_image) {
                    $featured_thumb = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                    $all_media[] = array(
                        'type' => 'image',
                        'id' => 'main',
                        'url' => $featured_image_url,
                        'thumb' => $featured_thumb,
                        'alt' => get_the_title(),
                    );
                }
                
                // Add gallery images
                foreach ($product_gallery as $index => $image) {
                    $all_media[] = array(
                        'type' => 'image',
                        'id' => 'gallery-' . $index,
                        'url' => $image['url'],
                        'thumb' => $image['sizes']['thumbnail'] ?? $image['url'],
                        'alt' => $image['alt'] ?? '',
                    );
                }
                
                // Add videos
                foreach ($product_videos as $index => $video) {
                    $video_url = $video['url'] ?? '';
                    if (empty($video_url)) continue;
                    
                    // Detect video platform and extract ID
                    $embed_url = '';
                    $thumbnail_url = '';
                    if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]+)/', $video_url, $matches)) {
                        $video_id = $matches[1];
                        $embed_url = 'https://www.youtube.com/embed/' . $video_id;
                        $thumbnail_url = 'https://img.youtube.com/vi/' . $video_id . '/default.jpg';
                    } elseif (preg_match('/vimeo\.com\/(\d+)/', $video_url, $matches)) {
                        $video_id = $matches[1];
                        $embed_url = 'https://player.vimeo.com/video/' . $video_id;
                        // Vimeo thumbnail would need API call, using placeholder
                        $thumbnail_url = '';
                    }
                    
                    if ($embed_url) {
                        $all_media[] = array(
                            'type' => 'video',
                            'id' => 'video-' . $index,
                            'url' => $embed_url,
                            'thumb' => $thumbnail_url,
                            'title' => $video['title'] ?? '',
                        );
                    }
                }
                
                if (!empty($all_media)) :
                ?>
                    <div class="product-media-slider">
                        <div class="flex gap-2 overflow-x-auto pb-2 scrollbar-hide" style="scrollbar-width: none; -ms-overflow-style: none;">
                            <?php foreach ($all_media as $item) : 
                                $is_active = ($item['id'] === 'main' || ($item['type'] === 'image' && $item['id'] === 'gallery-0' && !$has_featured_image));
                            ?>
                                <div class="media-slider-item flex-shrink-0 cursor-pointer rounded-lg overflow-hidden border-2 transition-all <?php echo $is_active ? 'border-secondary scale-105' : 'border-gray-200 hover:border-gray-300'; ?>" 
                                     data-type="<?php echo esc_attr($item['type']); ?>"
                                     data-id="<?php echo esc_attr($item['id']); ?>"
                                     data-url="<?php echo esc_attr($item['url']); ?>"
                                     data-title="<?php echo esc_attr($item['title'] ?? ''); ?>">
                                    <?php if ($item['type'] === 'image') : ?>
                                        <div class="w-20 h-20 relative">
                                            <img src="<?php echo esc_url($item['thumb']); ?>" alt="<?php echo esc_attr($item['alt']); ?>" class="w-full h-full object-cover">
                                        </div>
                                    <?php else : ?>
                                        <div class="w-20 h-20 relative bg-gray-800 flex items-center justify-center">
                                            <?php if (!empty($item['thumb'])) : ?>
                                                <img src="<?php echo esc_url($item['thumb']); ?>" alt="Video thumbnail" class="w-full h-full object-cover opacity-75">
                                            <?php endif; ?>
                                            <svg class="w-8 h-8 text-white absolute" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Content -->
            <div class="animate-fade-in-up delay-200">
                <!-- Categories & Featured Badge -->
                <div class="flex items-center gap-3 mb-6 flex-wrap">
                    <?php if (!empty($product_categories) && !is_wp_error($product_categories)) : ?>
                        <?php foreach ($product_categories as $category) : 
                            $category_link = get_term_link($category);
                            if (!is_wp_error($category_link)) : ?>
                                <a href="<?php echo esc_url($category_link); ?>" class="text-secondary px-4 py-1.5 rounded-full text-sm font-bold hover:text-secondary transition">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($is_featured) : ?>
                        <span class="text-yellow-500 flex items-center text-sm gap-1 animate-pulse">★ منتج مميز</span>
                    <?php endif; ?>
                </div>

                <h1 class="text-4xl md:text-5xl font-black text-primary mb-6 leading-tight"><?php the_title(); ?></h1>
                
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
                <div class="space-y-4 mt-8">
                    <a href="<?php echo esc_url(alomran_get_page_url('تواصل معنا') ?: alomran_get_page_url('contact') ?: home_url('/contact')); ?>" class="block w-full bg-primary text-white py-4 rounded-lg font-bold hover:bg-green-800 transition flex items-center justify-center gap-2 shadow-lg hover:shadow-xl transform hover:-translate-y-1 hover:scale-[1.02] duration-300">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        اطلب عرض سعر
                    </a>
                    
                    <!-- Share Buttons -->
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm font-semibold text-gray-700 mb-3 text-center">مشاركة المنتج</p>
                        <div class="flex items-center justify-center gap-3 flex-wrap">
                            <?php
                            $share_url = urlencode(get_permalink());
                            $share_title = urlencode(get_the_title());
                            $share_text = urlencode(get_the_excerpt() ?: get_the_title());
                            ?>
                            <a href="https://wa.me/?text=<?php echo esc_attr($share_text . '%20' . $share_url); ?>" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center hover:bg-green-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110" 
                               title="مشاركة على واتساب"
                               aria-label="مشاركة على واتساب">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                                </svg>
                            </a>
                            
                            <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo esc_attr($share_url); ?>" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center hover:bg-green-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110" 
                               title="مشاركة على فيسبوك"
                               aria-label="مشاركة على فيسبوك">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                                </svg>
                            </a>
                            
                            <a href="https://twitter.com/intent/tweet?url=<?php echo esc_attr($share_url); ?>&text=<?php echo esc_attr($share_text); ?>" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center hover:bg-green-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110" 
                               title="مشاركة على تويتر"
                               aria-label="مشاركة على تويتر">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                </svg>
                            </a>
                            
                            <button id="copy-link-btn" 
                                    class="w-12 h-12 bg-primary text-white rounded-full flex items-center justify-center hover:bg-green-800 transition-all duration-300 shadow-md hover:shadow-lg transform hover:scale-110" 
                                    title="نسخ الرابط"
                                    aria-label="نسخ الرابط">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 text-sm text-gray-400 text-center">
                    منتج مطابق للمواصفات القياسية المصرية (ES) والأوروبية (EN)
                </div>
            </div>
        </div>
    </div>
    
    <?php alomran_display_ad('content_after', 'mt-8', 'product-ad-after'); ?>
</div>

<?php
endwhile;
get_footer();
?>

