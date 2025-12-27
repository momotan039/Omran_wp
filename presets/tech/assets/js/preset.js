/**
 * Tech Preset - Custom JavaScript
 * 
 * @package AlOmran
 * @subpackage Tech
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        // Navbar scroll effect
        const navbar = $('#tech-navbar');
        if (navbar.length) {
            $(window).on('scroll', function() {
                if ($(window).scrollTop() > 20) {
                    navbar.addClass('scrolled');
                } else {
                    navbar.removeClass('scrolled');
                }
            });
        }

        // Mobile menu toggle
        $('.tech-mobile-menu-toggle').on('click', function() {
            const menu = $('.tech-mobile-menu');
            menu.slideToggle(300);
        });

        // Close mobile menu when clicking outside
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.tech-navbar').length) {
                $('.tech-mobile-menu').slideUp(300);
            }
        });

        // Intersection Observer for cinematic animations
        if ('IntersectionObserver' in window) {
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -100px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible', 'animate-in');
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            // Observe all sections with IDs
            document.querySelectorAll('section[id]').forEach(function(section) {
                observer.observe(section);
            });

            // Observe hero elements specifically
            const heroObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        if (entry.target.classList.contains('hero-title')) {
                            entry.target.style.filter = 'blur(0)';
                        }
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.hero-badge, .hero-title, .hero-description, .hero-buttons, .hero-image-container').forEach(function(el) {
                if (el) {
                    heroObserver.observe(el);
                }
            });

            // Observe feature cards with staggered animation
            document.querySelectorAll('.feature-card').forEach(function(card, index) {
                observer.observe(card);
                card.style.transitionDelay = (index * 0.1) + 's';
            });

            // Observe testimonial cards
            document.querySelectorAll('.testimonial-card').forEach(function(card, index) {
                observer.observe(card);
                card.style.transitionDelay = (index * 0.15) + 's';
            });

            // Observe stat cards for counter animation
            document.querySelectorAll('.stat-card').forEach(function(card) {
                observer.observe(card);
            });

            // Enhanced animated number counter for stats - counts up from 0
            function animateCounter(element, targetValue, format) {
                const duration = 2500; // 2.5 seconds for smooth animation
                const start = 0;
                const steps = 60; // Number of animation steps
                const stepDuration = duration / steps;
                let currentStep = 0;
                
                // Parse the target value
                let numericValue = 0;
                let suffix = '';
                let isPercentage = false;
                let isSpecial = false;
                
                if (format === '24/7' || format.trim() === '24/7') {
                    isSpecial = true;
                } else if (format.includes('K+') || format.includes('K')) {
                    const numStr = format.replace(/[K+]/g, '').trim();
                    numericValue = parseFloat(numStr) * 1000;
                    suffix = 'K+';
                } else if (format.includes('%')) {
                    const numStr = format.replace('%', '').trim();
                    numericValue = parseFloat(numStr);
                    isPercentage = true;
                    suffix = '%';
                } else if (format.includes('+') && !format.includes('K')) {
                    const numStr = format.replace('+', '').trim();
                    numericValue = parseFloat(numStr);
                    suffix = '+';
                } else {
                    numericValue = parseFloat(format) || 0;
                }
                
                // Special case for 24/7 - show immediately without animation
                if (isSpecial) {
                    element.textContent = '24/7';
                    return;
                }
                
                // Ensure we have a valid number
                if (isNaN(numericValue) || numericValue <= 0) {
                    console.warn('Invalid number format:', format);
                    return;
                }
                
                const increment = numericValue / steps;
                let current = start;
                
                // Start from 0
                if (isPercentage) {
                    element.textContent = '0.0' + suffix;
                } else if (suffix === 'K+') {
                    element.textContent = '0' + suffix;
                } else if (suffix === '+') {
                    element.textContent = '0' + suffix;
                } else {
                    element.textContent = '0';
                }
                
                const timer = setInterval(function() {
                    currentStep++;
                    current += increment;
                    
                    if (currentStep >= steps || current >= numericValue) {
                        // Final value - ensure exact target
                        if (isPercentage) {
                            element.textContent = numericValue.toFixed(1) + suffix;
                        } else if (suffix === 'K+') {
                            element.textContent = (numericValue / 1000).toFixed(0) + suffix;
                        } else if (suffix === '+') {
                            element.textContent = Math.floor(numericValue) + suffix;
                        } else {
                            element.textContent = Math.floor(numericValue) + (suffix || '');
                        }
                        clearInterval(timer);
                    } else {
                        // Animated value - smooth counting
                        if (isPercentage) {
                            element.textContent = current.toFixed(1) + suffix;
                        } else if (suffix === 'K+') {
                            const displayValue = Math.floor(current / 1000);
                            element.textContent = displayValue + suffix;
                        } else if (suffix === '+') {
                            element.textContent = Math.floor(current) + suffix;
                        } else {
                            element.textContent = Math.floor(current) + (suffix || '');
                        }
                    }
                }, stepDuration);
            }

            // Counter animation observer - triggers when section is visible
            const counterObserver = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting && !entry.target.classList.contains('counted')) {
                        entry.target.classList.add('counted');
                        const targetFormat = entry.target.getAttribute('data-target');
                        const originalFormat = entry.target.getAttribute('data-format') || targetFormat;
                        
                        if (targetFormat && targetFormat !== '0' && targetFormat.trim() !== '') {
                            // Reset to 0 with proper format before animation
                            if (originalFormat && originalFormat.includes('%')) {
                                entry.target.textContent = '0.0%';
                            } else if (originalFormat && originalFormat.includes('K+')) {
                                entry.target.textContent = '0K+';
                            } else if (originalFormat && originalFormat.includes('+') && !originalFormat.includes('K')) {
                                entry.target.textContent = '0+';
                            } else if (originalFormat && originalFormat.trim() === '24/7') {
                                // Don't animate, just show immediately
                                entry.target.textContent = '24/7';
                                return;
                            } else {
                                entry.target.textContent = '0';
                            }
                            
                            // Small delay for better visual effect - then start counting up
                            setTimeout(function() {
                                animateCounter(entry.target, targetFormat, originalFormat);
                            }, 200);
                        }
                    }
                });
            }, { 
                threshold: 0.2, // Trigger when 20% of element is visible
                rootMargin: '0px 0px -100px 0px' // Start animation when section is about to be visible
            });

            // Observe all stat numbers
            document.querySelectorAll('.stat-number').forEach(function(stat) {
                // Don't override initial value - it's already set in PHP template
                // Just observe for animation
                counterObserver.observe(stat);
            });

            // Observe case study section container
            const caseStudyContainer = document.querySelector('#case-study .max-w-7xl');
            if (caseStudyContainer) {
                observer.observe(caseStudyContainer);
            }
        }

        // Smooth scroll for anchor links
        $('a[href^="#"]').on('click', function(e) {
            const target = $(this.getAttribute('href'));
            if (target.length) {
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top - 80
                }, 800);
            }
        });

        // Contact form submission
        $('form[action*="tech_contact_submit"]').on('submit', function(e) {
            e.preventDefault();
            const form = $(this);
            const formData = form.serialize();
            const submitButton = form.find('button[type="submit"]');
            const originalText = submitButton.text();

            submitButton.prop('disabled', true).text('جاري الإرسال...');

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                data: formData,
                success: function(response) {
                    submitButton.text('تم الإرسال بنجاح!').removeClass('bg-blue-600').addClass('bg-green-600');
                    form[0].reset();
                    setTimeout(function() {
                        submitButton.prop('disabled', false).text(originalText).removeClass('bg-green-600').addClass('bg-blue-600');
                    }, 3000);
                },
                error: function() {
                    submitButton.text('حدث خطأ، حاول مرة أخرى').removeClass('bg-blue-600').addClass('bg-red-600');
                    setTimeout(function() {
                        submitButton.prop('disabled', false).text(originalText).removeClass('bg-red-600').addClass('bg-blue-600');
                    }, 3000);
                }
            });
        });

    });

})(jQuery);

