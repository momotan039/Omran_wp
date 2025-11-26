/**
 * Main JavaScript file for Al-Omran Theme
 */

(function($) {
    'use strict';

    $(document).ready(function() {
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

            // Disable submit button
            $submitBtn.prop('disabled', true).text('جاري الإرسال...');

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
    });

})(jQuery);

