/**
 * Scroll Animations & Lazy Loading
 * 
 * @package AlOmran
 */

(function($) {
    'use strict';

    const Animations = {
        init: function() {
            this.initSmoothScroll();
            this.initLazyLoading();
            this.initScrollAnimations();
            this.handleHashNavigation();
        },

        initSmoothScroll: function() {
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
        },

        initLazyLoading: function() {
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
        },

        initScrollAnimations: function() {
            // Trigger animations on scroll (Intersection Observer)
            const elements = document.querySelectorAll('.animate-fade-in-up, .animate-slide-in-right, .animate-scale-in');
            
            if (!elements.length) {
                return;
            }
            
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting) {
                            // Add 'animated' class to trigger the animation
                            entry.target.classList.add('animated');
                            entry.target.style.opacity = '1';
                            entry.target.style.visibility = 'visible';
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                });

                elements.forEach(function(el) {
                    // Ensure initial state
                    el.style.opacity = '0';
                    el.style.visibility = 'hidden';
                    observer.observe(el);
                });
            } else {
                // Fallback for older browsers - animate immediately
                elements.forEach(function(el) {
                    el.classList.add('animated');
                    el.style.opacity = '1';
                    el.style.visibility = 'visible';
                });
            }
        },

        handleHashNavigation: function() {
            // Scroll to top on page navigation (HashRouter simulation)
            if (window.location.hash) {
                window.scrollTo(0, 0);
            }
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        Animations.init();
    });

    // Export for use in other modules
    window.Animations = Animations;

})(jQuery);

