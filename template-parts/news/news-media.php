<?php
/**
 * News Media Gallery (Images + Videos)
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

$post_id = get_the_ID();
$gallery = alomran_get_news_gallery($post_id);
$videos = alomran_get_news_videos($post_id);

// Combine images and videos for gallery display
$all_media = array();

// Add gallery images
if (!empty($gallery)) {
    foreach ($gallery as $image) {
        $all_media[] = array(
            'type' => 'image',
            'url' => $image['url'],
            'thumb' => $image['sizes']['medium'] ?? $image['url'],
            'alt' => $image['alt'] ?? '',
        );
    }
}

// Add videos with thumbnails
if (!empty($videos) && is_array($videos)) {
    foreach ($videos as $video) {
        if (empty($video['url'])) continue;
        
        $video_url = trim($video['url']);
        if (empty($video_url)) continue;
        
        // Extract YouTube ID
        $youtube_id = '';
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([a-zA-Z0-9_-]{11})/', $video_url, $matches)) {
            $youtube_id = $matches[1];
        }
        
        // Extract Vimeo ID
        $vimeo_id = '';
        if (preg_match('/(?:vimeo\.com\/|player\.vimeo\.com\/video\/)(\d+)/', $video_url, $matches)) {
            $vimeo_id = $matches[1];
        }
        
        if ($youtube_id || $vimeo_id) {
            $thumbnail_url = '';
            if ($youtube_id) {
                $thumbnail_url = 'https://img.youtube.com/vi/' . $youtube_id . '/maxresdefault.jpg';
            }
            
            $all_media[] = array(
                'type' => 'video',
                'url' => $video_url,
                'thumb' => $thumbnail_url,
                'title' => $video['title'] ?? '',
                'youtube_id' => $youtube_id,
                'vimeo_id' => $vimeo_id,
            );
        }
    }
}

if (!empty($all_media)) : ?>
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-primary mb-6">معرض الصور والفيديوهات</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($all_media as $item) : ?>
                <?php if ($item['type'] === 'image') : ?>
                    <div class="relative group overflow-hidden rounded-lg cursor-pointer" onclick="openImageModal('<?php echo esc_url($item['url']); ?>', '<?php echo esc_attr($item['alt']); ?>')">
                        <img src="<?php echo esc_url($item['thumb']); ?>" 
                             alt="<?php echo esc_attr($item['alt']); ?>" 
                             class="w-full h-64 object-cover transform group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center" style="background-color: rgba(0, 0, 0, 0.5);">
                            <svg class="w-12 h-12" style="color: var(--theme-white);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/>
                            </svg>
                        </div>
                    </div>
                <?php else : ?>
                    <div class="relative group overflow-hidden rounded-lg cursor-pointer" style="background-color: var(--theme-gray-900);" onclick="openVideoModal('<?php echo esc_attr($item['youtube_id'] ?: $item['vimeo_id']); ?>', '<?php echo esc_attr($item['youtube_id'] ? 'youtube' : 'vimeo'); ?>', '<?php echo esc_attr($item['title']); ?>')">
                        <?php if (!empty($item['thumb'])) : ?>
                            <img src="<?php echo esc_url($item['thumb']); ?>" 
                                 alt="<?php echo esc_attr($item['title']); ?>" 
                                 class="w-full h-64 object-cover opacity-75">
                        <?php else : ?>
                            <div class="w-full h-64 flex items-center justify-center" style="background-color: var(--theme-gray-800);">
                                <svg class="w-16 h-16" style="color: var(--theme-white);" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </div>
                        <?php endif; ?>
                        <div class="absolute inset-0 flex items-center justify-center" style="background-color: rgba(0, 0, 0, 0.4);">
                            <div class="w-16 h-16 rounded-full flex items-center justify-center backdrop-blur-sm transition" style="background-color: rgba(255, 255, 255, 0.2);" onmouseover="this.style.backgroundColor='rgba(255, 255, 255, 0.3)'" onmouseout="this.style.backgroundColor='rgba(255, 255, 255, 0.2)'">
                                <svg class="w-8 h-8 mr-1" style="color: var(--theme-white);" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M6.3 2.841A1.5 1.5 0 004 4.11V15.89a1.5 1.5 0 002.3 1.269l9.344-5.89a1.5 1.5 0 000-2.538L6.3 2.84z"/>
                                </svg>
                            </div>
                        </div>
                        <?php if (!empty($item['title'])) : ?>
                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t p-4" style="background: linear-gradient(to top, rgba(0, 0, 0, 0.8), transparent);">
                                <p class="font-bold text-sm" style="color: var(--theme-white);"><?php echo esc_html($item['title']); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

