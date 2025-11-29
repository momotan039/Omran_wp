/**
 * Product Gallery & Share Functionality
 * 
 * @package AlOmran
 */

(function($) {
    'use strict';

    const ProductPage = {
        init: function() {
            this.initGallery();
            this.initShare();
        },

        initGallery: function() {
            const $sliderItems = $('.media-slider-item');
            const $mainContainer = $('#product-main-container');

            if (!$sliderItems.length || !$mainContainer.length) return;

            $sliderItems.on('click', function() {
                const $this = $(this);
                const mediaType = $this.data('type');
                const mediaUrl = $this.data('url');
                const mediaTitle = $this.data('title') || '';

                // Update active state
                $sliderItems.removeClass('border-secondary scale-105').addClass('border-gray-200');
                $this.removeClass('border-gray-200').addClass('border-secondary scale-105');

                // Hide current media
                $mainContainer.find('.main-media-item').fadeOut(200, function() {
                    $(this).removeClass('active');
                    
                    let newMedia;
                    
                    if (mediaType === 'image') {
                        // Create image element
                        newMedia = $('<img>', {
                            class: 'w-full h-full object-cover main-media-item active',
                            src: mediaUrl,
                            alt: mediaTitle || 'Product image',
                            'data-type': 'image',
                            'data-src': mediaUrl
                        });
                    } else if (mediaType === 'video') {
                        // Create video iframe
                        newMedia = $('<div>', {
                            class: 'w-full h-full main-media-item active aspect-square',
                            'data-type': 'video',
                            'data-url': mediaUrl
                        }).html(
                            '<iframe src="' + mediaUrl + '" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen class="w-full h-full"></iframe>'
                        );
                    }
                    
                    if (newMedia) {
                        $mainContainer.empty().append(newMedia);
                        newMedia.hide().fadeIn(200);
                    }
                });
            });
        },

        initShare: function() {
            const $copyBtn = $('#copy-link-btn');

            if (!$copyBtn.length) return;

            // Handle copy link button
            $copyBtn.on('click', function(e) {
                e.preventDefault();
                const url = window.location.href;
                
                // Copy to clipboard
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(url).then(function() {
                        ProductPage.updateCopyButton($copyBtn, true);
                    }).catch(function() {
                        // Fallback if clipboard fails
                        ProductPage.copyToClipboardFallback(url, $copyBtn);
                    });
                } else {
                    // Fallback for older browsers
                    ProductPage.copyToClipboardFallback(url, $copyBtn);
                }
            });
        },

        updateCopyButton: function($btn, success) {
            const originalTitle = $btn.attr('title');
            $btn.attr('title', success ? 'تم النسخ!' : originalTitle);
            $btn.removeClass('bg-primary hover:bg-green-800').addClass('bg-green-600 hover:bg-green-700');
            
            setTimeout(function() {
                $btn.attr('title', originalTitle);
                $btn.removeClass('bg-green-600 hover:bg-green-700').addClass('bg-primary hover:bg-green-800');
            }, 2000);
        },

        copyToClipboardFallback: function(text, $btn) {
            const $temp = $('<input>');
            $('body').append($temp);
            $temp.val(text).select();
            document.execCommand('copy');
            $temp.remove();
            
            this.updateCopyButton($btn, true);
        }
    };

    // Initialize product page features
    $(document).ready(function() {
        if ($('body').hasClass('single-product') || $('#product-main-image').length) {
            ProductPage.init();
        }
    });

    // Export for use in other modules
    window.ProductPage = ProductPage;

})(jQuery);

