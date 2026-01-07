/**
 * Page Loader Management
 * 
 * @package AlOmran
 */

(function() {
    'use strict';
    
    // Vanilla JS loader function - works without jQuery
    function hideLoaderVanilla() {
        const loader = document.getElementById('alomran-page-loader');
        const page = document.getElementById('page');
        
        if (!loader) {
            return; // Loader doesn't exist
        }
        
                // Ensure minimum display time for smooth experience
                // Get from data attribute if available, otherwise use default
                const loaderElement = document.getElementById('alomran-page-loader');
                const minDisplayTime = loaderElement && loaderElement.dataset.minTime 
                    ? parseFloat(loaderElement.dataset.minTime) 
                    : 800;
                const startTime = Date.now();
        
        const hideLoaderNow = function() {
            const elapsed = Date.now() - startTime;
            const remaining = Math.max(0, minDisplayTime - elapsed);
            
            setTimeout(function() {
                loader.classList.add('hidden');
                if (page) {
                    page.classList.remove('opacity-0');
                    page.classList.add('opacity-100');
                }
                
                setTimeout(function() {
                    loader.remove();
                }, 500);
            }, remaining);
        };
        
        // Check if window has already loaded
        if (document.readyState === 'complete') {
            hideLoaderNow();
        } else {
            // Wait for window load
            window.addEventListener('load', hideLoaderNow);
        }
        
        // Fallback if window load doesn't fire (safety net)
        setTimeout(function() {
            if (loader && !loader.classList.contains('hidden')) {
                hideLoaderNow();
            }
        }, 2000);
    }
    
    // Wait for jQuery to be available
    function initLoader() {
        var $ = typeof jQuery !== 'undefined' ? jQuery : null;
        
        const PageLoader = {
            init: function() {
                this.hideLoader();
                if ($) {
                    this.setupImageLoading();
                    this.setupPageTransitions();
                }
            },
            
            hideLoader: function() {
                const loader = $ ? $('#alomran-page-loader') : null;
                const page = $ ? $('#page') : null;
                
                if ($ && loader && loader.length) {
                    // Use jQuery if available
                    // Get from data attribute if available, otherwise use default
                    const loaderElement = document.getElementById('alomran-page-loader');
                    const minDisplayTime = loaderElement && loaderElement.dataset.minTime 
                        ? parseFloat(loaderElement.dataset.minTime) 
                        : 800;
                    const startTime = Date.now();
                    
                    const hideLoaderNow = function() {
                        const elapsed = Date.now() - startTime;
                        const remaining = Math.max(0, minDisplayTime - elapsed);
                        
                        setTimeout(function() {
                            loader.addClass('hidden');
                            if (page && page.length) {
                                page.removeClass('opacity-0').addClass('opacity-100');
                            }
                            
                            setTimeout(function() {
                                loader.remove();
                            }, 500);
                        }, remaining);
                    };
                    
                    if (document.readyState === 'complete') {
                        hideLoaderNow();
                    } else {
                        $(window).on('load', hideLoaderNow);
                    }
                    
                    setTimeout(function() {
                        if (loader.length && !loader.hasClass('hidden')) {
                            hideLoaderNow();
                        }
                    }, 2000);
                } else {
                    // Fallback to vanilla JS
                    hideLoaderVanilla();
                }
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
                    const $loader = $('#alomran-page-loader');
                    if ($loader.length) {
                        $loader.removeClass('hidden').show();
                        $('#page').addClass('opacity-0');
                    }
                });
            }
        };

        // Initialize on document ready
        if ($) {
            $(document).ready(function() {
                // Check if page is already loaded and hide loader immediately if so
                if (document.readyState === 'complete') {
                    const loader = $('#alomran-page-loader');
                    const page = $('#page');
                    if (loader.length) {
                        setTimeout(function() {
                            loader.addClass('hidden');
                            setTimeout(function() {
                                loader.remove();
                            }, 500);
                            if (page.length) {
                                page.removeClass('opacity-0').addClass('opacity-100');
                            }
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
        } else {
            // Use vanilla JS if jQuery not available
            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', function() {
                    PageLoader.init();
                });
            } else {
                PageLoader.init();
            }
            
            window.addEventListener('load', function() {
                const page = document.getElementById('page');
                if (page) {
                    page.classList.remove('opacity-0');
                }
            });
        }

        // Export for use in other modules
        window.PageLoader = PageLoader;
    }
    
    // Start initialization immediately with vanilla JS
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            hideLoaderVanilla();
            initLoader();
        });
    } else {
        hideLoaderVanilla();
        initLoader();
    }
    
    // Also try on window load as backup
    window.addEventListener('load', function() {
        const loader = document.getElementById('alomran-page-loader');
        if (loader && !loader.classList.contains('hidden')) {
            setTimeout(function() {
                loader.classList.add('hidden');
                setTimeout(function() {
                    loader.remove();
                }, 500);
            }, 300);
        }
    });

})();
