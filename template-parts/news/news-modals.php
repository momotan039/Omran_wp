<?php
/**
 * News Modals (Image & Video)
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!-- Image Modal -->
<div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/90 flex items-center justify-center p-4" onclick="closeImageModal()">
    <button class="absolute top-4 left-4 text-white text-2xl z-10 hover:text-gray-300 transition" onclick="closeImageModal()">×</button>
    <img id="modalImage" src="" alt="" class="max-w-full max-h-full object-contain" onclick="event.stopPropagation();">
</div>

<!-- Video Modal -->
<div id="videoModal" class="fixed inset-0 z-50 hidden bg-black/90 flex items-center justify-center p-4" onclick="closeVideoModal()">
    <button class="absolute top-4 left-4 text-white text-2xl z-10 hover:text-gray-300 transition" onclick="closeVideoModal()">×</button>
    <div class="w-full max-w-4xl aspect-video bg-black rounded-lg overflow-hidden" onclick="event.stopPropagation();">
        <div id="videoContainer" class="w-full h-full"></div>
    </div>
</div>

<script>
function openImageModal(url, alt) {
    document.getElementById('modalImage').src = url;
    document.getElementById('modalImage').alt = alt;
    document.getElementById('imageModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeImageModal() {
    document.getElementById('imageModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function openVideoModal(videoId, platform, title) {
    const container = document.getElementById('videoContainer');
    container.innerHTML = '';
    
    let iframe;
    if (platform === 'youtube') {
        iframe = document.createElement('iframe');
        iframe.src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0';
        iframe.className = 'w-full h-full';
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
        iframe.setAttribute('allowfullscreen', '');
    } else if (platform === 'vimeo') {
        iframe = document.createElement('iframe');
        iframe.src = 'https://player.vimeo.com/video/' + videoId + '?autoplay=1&title=0&byline=0&portrait=0';
        iframe.className = 'w-full h-full';
        iframe.setAttribute('frameborder', '0');
        iframe.setAttribute('allow', 'autoplay; fullscreen; picture-in-picture');
        iframe.setAttribute('allowfullscreen', '');
    }
    
    if (iframe) {
        container.appendChild(iframe);
        document.getElementById('videoModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeVideoModal() {
    const container = document.getElementById('videoContainer');
    container.innerHTML = '';
    document.getElementById('videoModal').classList.add('hidden');
    document.body.style.overflow = '';
}

function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('تم نسخ الرابط بنجاح!');
    });
}
</script>

