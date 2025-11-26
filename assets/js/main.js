/**
 * Main JavaScript file for Al-Omran Theme
 */

(function($) {
    'use strict';

    // Page Loader Management
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
        // Mobile Menu Toggle
        const mobileMenuToggle = $('#mobile-menu-toggle');
        const mobileMenu = $('#mobile-menu');
        const menuIcon = $('#menu-icon');
        const closeIcon = $('#close-icon');

        if (mobileMenuToggle.length) {
            mobileMenuToggle.on('click', function() {
                mobileMenu.toggleClass('hidden');
                menuIcon.toggleClass('hidden');
                closeIcon.toggleClass('hidden');
            });
        }

        // FAQ Accordion
        $('.faq-toggle').on('click', function(e) {
            e.preventDefault();
            const $item = $(this).closest('.faq-item');
            const $content = $item.find('.faq-content');
            const $icon = $(this).find('.faq-icon');
            const isOpen = $content.hasClass('max-h-48');

            // Close all items
            $('.faq-item').removeClass('border-secondary bg-blue-50/30');
            $('.faq-content').removeClass('max-h-48 opacity-100').addClass('max-h-0 opacity-0');
            $('.faq-toggle span').removeClass('text-secondary').addClass('text-gray-700');
            $('.faq-icon').html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>').removeClass('text-secondary').addClass('text-gray-400');

            if (isOpen) {
                // Do nothing if already open (close it)
            } else {
                // Open clicked item
                $item.addClass('border-secondary bg-blue-50/30');
                $content.removeClass('max-h-0 opacity-0').addClass('max-h-48 opacity-100');
                $(this).find('span').removeClass('text-gray-700').addClass('text-secondary');
                $icon.html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>').removeClass('text-gray-400').addClass('text-secondary');
            }
        });

        // FAQ Search
        $('#faq-search').on('input', function() {
            const searchTerm = $(this).val().toLowerCase();
            $('.faq-item').each(function() {
                const question = $(this).data('question') || '';
                const answer = $(this).data('answer') || '';
                
                if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });

        // Contact Form AJAX
        $('#contact-form').on('submit', function(e) {
            e.preventDefault();
            
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            const $messageDiv = $('#form-message');
            const formData = {
                action: 'alomran_contact_form',
                nonce: alomranAjax.nonce,
                name: $form.find('input[name="name"]').val(),
                phone: $form.find('input[name="phone"]').val(),
                email: $form.find('input[name="email"]').val(),
                message: $form.find('textarea[name="message"]').val()
            };

            // Disable submit button and show loading
            $submitBtn.prop('disabled', true).html('<span class="inline-flex items-center gap-2"><svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> جاري الإرسال...</span>');

            $.ajax({
                url: alomranAjax.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        $messageDiv
                            .removeClass('hidden bg-red-50 text-red-700')
                            .addClass('bg-green-50 text-green-700 p-4 rounded-lg text-center animate-scale-in')
                            .text(response.data.message);
                        
                        $form[0].reset();
                        
                        // Reset button after 3 seconds
                        setTimeout(function() {
                            $messageDiv.addClass('hidden').removeClass('bg-green-50 text-green-700 p-4 rounded-lg text-center animate-scale-in');
                            $submitBtn.prop('disabled', false).html('إرسال الآن <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>');
                        }, 3000);
                    } else {
                        $messageDiv
                            .removeClass('hidden bg-green-50 text-green-700')
                            .addClass('bg-red-50 text-red-700 p-4 rounded-lg text-center animate-scale-in')
                            .text(response.data.message || 'حدث خطأ. يرجى المحاولة مرة أخرى.');
                        
                        $submitBtn.prop('disabled', false).html('إرسال الآن <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>');
                    }
                },
                error: function() {
                    $messageDiv
                        .removeClass('hidden bg-green-50 text-green-700')
                        .addClass('bg-red-50 text-red-700 p-4 rounded-lg text-center animate-scale-in')
                        .text('حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.');
                    
                    $submitBtn.prop('disabled', false).html('إرسال الآن <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>');
                }
            });
        });

        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 100
                }, 1000);
            }
        });

        // Lazy loading for images (if not using native lazy loading)
        if ('loading' in HTMLImageElement.prototype === false) {
            const images = document.querySelectorAll('img[data-src]');
            const imageObserver = new IntersectionObserver(function(entries, observer) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(function(img) {
                imageObserver.observe(img);
            });
        }

        // Scroll to top on page navigation (HashRouter simulation)
        if (window.location.hash) {
            window.scrollTo(0, 0);
        }

        // Trigger animations on scroll (Intersection Observer)
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.animate-fade-in-up, .animate-slide-in-right, .animate-scale-in');
            
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            entry.target.style.opacity = '1';
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1
                });

                elements.forEach(function(el) {
                    observer.observe(el);
                });
            } else {
                // Fallback for older browsers
                elements.forEach(function(el) {
                    el.style.opacity = '1';
                });
            }
        };

        animateOnScroll();
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

})(jQuery);

