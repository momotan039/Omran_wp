<?php
/**
 * Product Media Management
 * Handles product gallery and videos using post meta
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Get product gallery images from post meta
 *
 * @param int $product_id Product post ID.
 * @return array Array of image data.
 */
function alomran_get_product_gallery($product_id = null) {
    if (!$product_id) {
        $product_id = get_the_ID();
    }
    
    $gallery = get_post_meta($product_id, '_product_gallery', true);
    
    if (empty($gallery) || !is_array($gallery)) {
        return array();
    }
    
    $images = array();
    foreach ($gallery as $image_id) {
        if (!empty($image_id)) {
            $image_data = wp_get_attachment_image_src($image_id, 'full');
            if ($image_data) {
                $images[] = array(
                    'id'   => $image_id,
                    'url'  => $image_data[0],
                    'sizes' => array(
                        'thumbnail' => wp_get_attachment_image_url($image_id, 'thumbnail'),
                        'medium'    => wp_get_attachment_image_url($image_id, 'medium'),
                        'large'     => wp_get_attachment_image_url($image_id, 'large'),
                        'full'      => $image_data[0],
                    ),
                    'alt'  => get_post_meta($image_id, '_wp_attachment_image_alt', true),
                );
            }
        }
    }
    
    return $images;
}

/**
 * Get product videos from post meta
 *
 * @param int $product_id Product post ID.
 * @return array Array of video data.
 */
function alomran_get_product_videos($product_id = null) {
    if (!$product_id) {
        $product_id = get_the_ID();
    }
    
    $videos = get_post_meta($product_id, '_product_videos', true);
    
    if (empty($videos) || !is_array($videos)) {
        return array();
    }
    
    return $videos;
}

/**
 * Add meta box for product media
 */
function alomran_add_product_media_meta_box() {
    add_meta_box(
        'product_media_meta_box',
        'معرض الصور والفيديوهات',
        'alomran_product_media_meta_box_callback',
        'product',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alomran_add_product_media_meta_box');

/**
 * Meta box callback
 */
function alomran_product_media_meta_box_callback($post) {
    wp_nonce_field('alomran_product_media_meta_box', 'alomran_product_media_meta_box_nonce');
    
    $gallery = alomran_get_product_gallery($post->ID);
    $videos = alomran_get_product_videos($post->ID);
    
    ?>
    <div style="padding: 20px;">
        <!-- Gallery Section -->
        <h3 style="margin-top: 0;">معرض الصور</h3>
        <p class="description">أضف صور إضافية للمنتج. الصورة الرئيسية (Featured Image) تظهر تلقائياً.</p>
        
        <div id="product-gallery-container">
            <input type="hidden" id="product-gallery-ids" name="product_gallery_ids" value="<?php echo esc_attr(implode(',', wp_list_pluck($gallery, 'id'))); ?>">
            <button type="button" class="button" id="add-gallery-images">إضافة صور</button>
            <button type="button" class="button" id="clear-gallery" style="margin-left: 10px;">مسح الكل</button>
            
            <div id="gallery-preview" style="margin-top: 15px; display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px;">
                <?php foreach ($gallery as $image) : ?>
                    <div class="gallery-item" data-id="<?php echo esc_attr($image['id']); ?>" style="position: relative; border: 2px solid #ddd; border-radius: 4px; overflow: hidden;">
                        <img src="<?php echo esc_url($image['sizes']['thumbnail'] ?? $image['url']); ?>" style="width: 100%; height: 150px; object-fit: cover; display: block;">
                        <button type="button" class="remove-gallery-item" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer;">×</button>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <hr style="margin: 30px 0;">
        
        <!-- Videos Section -->
        <h3>الفيديوهات</h3>
        <p class="description">أضف فيديوهات من YouTube أو Vimeo. أدخل رابط الفيديو فقط.</p>
        
        <div id="product-videos-container">
            <?php if (!empty($videos)) : ?>
                <?php foreach ($videos as $index => $video) : ?>
                    <div class="video-item" style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; border-radius: 4px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">رابط الفيديو:</label>
                        <input type="url" name="product_videos[<?php echo esc_attr($index); ?>][url]" value="<?php echo esc_attr($video['url'] ?? ''); ?>" placeholder="https://youtube.com/watch?v=..." style="width: 100%; padding: 8px; margin-bottom: 10px;">
                        <label style="display: block; margin-bottom: 5px; font-weight: bold;">عنوان الفيديو (اختياري):</label>
                        <input type="text" name="product_videos[<?php echo esc_attr($index); ?>][title]" value="<?php echo esc_attr($video['title'] ?? ''); ?>" placeholder="عنوان الفيديو" style="width: 100%; padding: 8px;">
                        <button type="button" class="button remove-video-item" style="margin-top: 10px; background: #dc3232; color: white; border-color: #dc3232;">حذف</button>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <button type="button" class="button" id="add-video-item">إضافة فيديو</button>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        let videoIndex = <?php echo count($videos); ?>;
        
        // Gallery management
        const galleryFrame = wp.media({
            title: 'اختر صور المنتج',
            button: { text: 'استخدام الصور المحددة' },
            multiple: true
        });
        
        $('#add-gallery-images').on('click', function(e) {
            e.preventDefault();
            galleryFrame.open();
        });
        
        galleryFrame.on('select', function() {
            const selection = galleryFrame.state().get('selection');
            const ids = [];
            
            selection.each(function(attachment) {
                ids.push(attachment.id);
                const url = attachment.attributes.sizes && attachment.attributes.sizes.thumbnail ? attachment.attributes.sizes.thumbnail.url : attachment.attributes.url;
                $('#gallery-preview').append(
                    '<div class="gallery-item" data-id="' + attachment.id + '" style="position: relative; border: 2px solid #ddd; border-radius: 4px; overflow: hidden;">' +
                    '<img src="' + url + '" style="width: 100%; height: 150px; object-fit: cover; display: block;">' +
                    '<button type="button" class="remove-gallery-item" style="position: absolute; top: 5px; right: 5px; background: red; color: white; border: none; border-radius: 50%; width: 25px; height: 25px; cursor: pointer;">×</button>' +
                    '</div>'
                );
            });
            
            updateGalleryIds();
        });
        
        $(document).on('click', '.remove-gallery-item', function() {
            $(this).closest('.gallery-item').remove();
            updateGalleryIds();
        });
        
        $('#clear-gallery').on('click', function() {
            $('#gallery-preview').empty();
            updateGalleryIds();
        });
        
        function updateGalleryIds() {
            const ids = [];
            $('.gallery-item').each(function() {
                ids.push($(this).data('id'));
            });
            $('#product-gallery-ids').val(ids.join(','));
        }
        
        // Video management
        $('#add-video-item').on('click', function() {
            const html = '<div class="video-item" style="margin-bottom: 15px; padding: 15px; border: 1px solid #ddd; border-radius: 4px;">' +
                '<label style="display: block; margin-bottom: 5px; font-weight: bold;">رابط الفيديو:</label>' +
                '<input type="url" name="product_videos[' + videoIndex + '][url]" placeholder="https://youtube.com/watch?v=..." style="width: 100%; padding: 8px; margin-bottom: 10px;">' +
                '<label style="display: block; margin-bottom: 5px; font-weight: bold;">عنوان الفيديو (اختياري):</label>' +
                '<input type="text" name="product_videos[' + videoIndex + '][title]" placeholder="عنوان الفيديو" style="width: 100%; padding: 8px;">' +
                '<button type="button" class="button remove-video-item" style="margin-top: 10px; background: #dc3232; color: white; border-color: #dc3232;">حذف</button>' +
                '</div>';
            $('#product-videos-container').append(html);
            videoIndex++;
        });
        
        $(document).on('click', '.remove-video-item', function() {
            $(this).closest('.video-item').remove();
        });
    });
    </script>
    <?php
}

/**
 * Save product media meta box data
 */
function alomran_save_product_media_meta_box($post_id) {
    // Check nonce
    if (!isset($_POST['alomran_product_media_meta_box_nonce']) || 
        !wp_verify_nonce($_POST['alomran_product_media_meta_box_nonce'], 'alomran_product_media_meta_box')) {
        return;
    }
    
    // Check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Save gallery
    if (isset($_POST['product_gallery_ids'])) {
        $gallery_ids = array_filter(array_map('intval', explode(',', sanitize_text_field($_POST['product_gallery_ids']))));
        update_post_meta($post_id, '_product_gallery', $gallery_ids);
    } else {
        delete_post_meta($post_id, '_product_gallery');
    }
    
    // Save videos
    if (isset($_POST['product_videos']) && is_array($_POST['product_videos'])) {
        $videos = array();
        foreach ($_POST['product_videos'] as $video) {
            if (!empty($video['url'])) {
                $videos[] = array(
                    'url'   => esc_url_raw($video['url']),
                    'title' => sanitize_text_field($video['title'] ?? ''),
                );
            }
        }
        update_post_meta($post_id, '_product_videos', $videos);
    } else {
        delete_post_meta($post_id, '_product_videos');
    }
}
add_action('save_post_product', 'alomran_save_product_media_meta_box');

