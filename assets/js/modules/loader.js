/**
 * Page Loader Management
 * 
 * @package AlOmran
 */

(function($) {
    'use strict';

    const PageLoader = {
        init: function() {
            this.hideLoader();
            this.setupImageLoading();
            this.setupPageTransitions();
        },
        
        hideLoader: function() {
            const loader = $('#page-loader');
            const page = $('#page');
            
            if (!loader.length) {
                return; // Loader doesn't exist
            }
            
            // Ensure minimum display time for smooth experience
            const minDisplayTime = 800;
            const startTime = Date.now();
            
            const hideLoaderNow = function() {
                const elapsed = Date.now() - startTime;
                const remaining = Math.max(0, minDisplayTime - elapsed);
                
                setTimeout(function() {
                    loader.addClass('opacity-0 pointer-events-none');
                    page.removeClass('opacity-0').addClass('page-fade-in');
                    
                    setTimeout(function() {
                        loader.hide();
                    }, 500);
                }, remaining);
            };
            
            // Check if window has already loaded
            if (document.readyState === 'complete') {
                hideLoaderNow();
            } else {
                // Wait for window load
                $(window).on('load', hideLoaderNow);
            }
            
            // Fallback if window load doesn't fire (safety net)
            setTimeout(function() {
                if (loader.is(':visible')) {
                    hideLoaderNow();
                }
            }, 2000);
        },
        
        setupImageLoading: function() {
            // Add loading state to images
            $('img').each(function() {
                const $img = $(this);
                
                if (!$img.attr('src')) {
                    $img.addClass('image-loading');
                }
                
                $img.on('load', function() {
                    $(this).removeClass('image-loading').addClass('opacity-0');
                    $(this).animate({ opacity: 1 }, 300);
                });
                
                $img.on('error', function() {
                    $(this).removeClass('image-loading');
                });
            });
        },
        
        setupPageTransitions: function() {
            // Smooth page transitions for internal links
            $('a[href^="' + window.location.origin + '"]').on('click', function(e) {
                const href = $(this).attr('href');
                
                // Skip if external link, anchor, or special attributes
                if ($(this).attr('target') === '_blank' || 
                    $(this).attr('href').indexOf('#') !== -1 ||
                    $(this).hasClass('no-transition')) {
                    return;
                }
                
                // Show loading overlay for page transitions
                const $loader = $('#page-loader');
                $loader.removeClass('opacity-0 pointer-events-none').show();
                $('#page').addClass('opacity-0');
            });
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        // Check if page is already loaded and hide loader immediately if so
        if (document.readyState === 'complete') {
            const loader = $('#page-loader');
            const page = $('#page');
            if (loader.length) {
                setTimeout(function() {
                    loader.fadeOut(500, function() {
                        $(this).remove();
                    });
                    page.removeClass('opacity-0').addClass('page-fade-in');
                }, 500);
            }
        }
        
        // Initialize page loader
        PageLoader.init();
    });

    // Window load events
    $(window).on('load', function() {
        // Hide any loading spinners if present
        $('.loader').fadeOut();
        
        // Ensure page is visible after load
        setTimeout(function() {
            $('#page').removeClass('opacity-0');
        }, 100);
    });

    // Export for use in other modules
    window.PageLoader = PageLoader;

})(jQuery);

