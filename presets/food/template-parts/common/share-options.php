<?php
/**
 * Food Preset - Share Options Component
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

$share_title = isset($args['title']) ? $args['title'] : get_the_title();
$share_url = isset($args['url']) ? $args['url'] : get_permalink();
?>
<div class="relative inline-block w-full">
    <button 
        id="share-toggle-btn"
        class="flex items-center justify-center gap-4 border-2 border-brand-black py-6 px-10 rounded-3xl font-black hover:bg-brand-black hover:text-white transition-all w-full"
    >
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
        </svg>
        <span>مشاركة</span>
    </button>

    <div id="share-dropdown" class="hidden absolute bottom-full mb-4 right-0 w-64 bg-white rounded-[30px] luxury-shadow p-6 z-[60] border border-gray-100">
        <div class="grid grid-cols-1 gap-4">
            <a 
                href="https://wa.me/?text=<?php echo urlencode($share_title . ' ' . $share_url); ?>" 
                target="_blank" 
                rel="noopener noreferrer"
                class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors group"
            >
                <div class="bg-[#25D366] text-white p-2 rounded-xl">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                </div>
                <span class="font-bold text-brand-black group-hover:text-brand-gold transition-colors">واتساب</span>
            </a>
            <a 
                href="https://twitter.com/intent/tweet?text=<?php echo urlencode($share_title); ?>&url=<?php echo urlencode($share_url); ?>" 
                target="_blank" 
                rel="noopener noreferrer"
                class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors group"
            >
                <div class="bg-black text-white p-2 rounded-xl">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </div>
                <span class="font-bold text-brand-black group-hover:text-brand-gold transition-colors">تويتر</span>
            </a>
            <a 
                href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($share_url); ?>" 
                target="_blank" 
                rel="noopener noreferrer"
                class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors group"
            >
                <div class="bg-[#1877F2] text-white p-2 rounded-xl">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                </div>
                <span class="font-bold text-brand-black group-hover:text-brand-gold transition-colors">فيسبوك</span>
            </a>
            <button 
                id="copy-link-btn"
                class="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors group w-full text-right"
            >
                <div class="bg-gray-200 text-brand-black p-2 rounded-xl">
                    <svg id="copy-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <svg id="check-icon" class="w-5 h-5 hidden text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <span id="copy-text" class="font-bold text-brand-black group-hover:text-brand-gold transition-colors">نسخ الرابط</span>
            </button>
        </div>
        <div class="absolute -bottom-2 right-10 w-4 h-4 bg-white rotate-45 border-r border-b border-gray-100"></div>
    </div>
</div>

<script>
(function() {
    const toggleBtn = document.getElementById('share-toggle-btn');
    const dropdown = document.getElementById('share-dropdown');
    const copyBtn = document.getElementById('copy-link-btn');
    const copyIcon = document.getElementById('copy-icon');
    const checkIcon = document.getElementById('check-icon');
    const copyText = document.getElementById('copy-text');
    const shareUrl = '<?php echo esc_js($share_url); ?>';
    
    if (!toggleBtn || !dropdown) return;
    
    // Toggle dropdown
    toggleBtn.addEventListener('click', function(e) {
        e.stopPropagation();
        dropdown.classList.toggle('hidden');
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!dropdown.contains(e.target) && !toggleBtn.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
    
    // Copy link functionality
    if (copyBtn) {
        copyBtn.addEventListener('click', function() {
            navigator.clipboard.writeText(shareUrl).then(function() {
                copyIcon.classList.add('hidden');
                checkIcon.classList.remove('hidden');
                copyText.textContent = 'تم النسخ!';
                
                setTimeout(function() {
                    copyIcon.classList.remove('hidden');
                    checkIcon.classList.add('hidden');
                    copyText.textContent = 'نسخ الرابط';
                }, 2000);
            }).catch(function() {
                // Fallback for older browsers
                const textarea = document.createElement('textarea');
                textarea.value = shareUrl;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);
                
                copyIcon.classList.add('hidden');
                checkIcon.classList.remove('hidden');
                copyText.textContent = 'تم النسخ!';
                
                setTimeout(function() {
                    copyIcon.classList.remove('hidden');
                    checkIcon.classList.add('hidden');
                    copyText.textContent = 'نسخ الرابط';
                }, 2000);
            });
        });
    }
})();
</script>


