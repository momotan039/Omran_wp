/**
 * Stats Counter Animation
 * 
 * @package AlOmran
 */

(function() {
    'use strict';
    
    function initStatsCounter() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initStatsCounter, 50);
            return;
        }
        
        var $ = jQuery;
        
        function startStatsCounter() {
            const statsSection = document.getElementById('about-stats-section');
            if (!statsSection) {
                return;
            }

            const statNumbers = statsSection.querySelectorAll('.stat-number');
            let hasAnimated = false;

            // Function to animate a single number
            function animateNumber(element) {
                const target = parseFloat(element.getAttribute('data-target')) || 0;
                const suffix = element.getAttribute('data-suffix') || '';
                const duration = parseInt(element.getAttribute('data-duration')) || 2000;
                const startTime = Date.now();
                const startValue = 0;
                
                const statValueSpan = element.querySelector('.stat-value');
                if (!statValueSpan) return;

                function updateNumber() {
                    const elapsed = Date.now() - startTime;
                    const progress = Math.min(elapsed / duration, 1);
                    
                    // Easing function for smooth animation
                    const easeOutQuart = 1 - Math.pow(1 - progress, 4);
                    const currentValue = startValue + (target - startValue) * easeOutQuart;
                    
                    // Format number - always show as integer for stats
                    if (target >= 1000) {
                        statValueSpan.textContent = Math.floor(currentValue).toLocaleString('ar-EG');
                    } else {
                        statValueSpan.textContent = Math.floor(currentValue);
                    }
                    
                    if (progress < 1) {
                        requestAnimationFrame(updateNumber);
                    } else {
                        // Ensure final value is exact
                        if (target >= 1000) {
                            statValueSpan.textContent = Math.floor(target).toLocaleString('ar-EG');
                        } else {
                            statValueSpan.textContent = Math.floor(target);
                        }
                    }
                }
                
                updateNumber();
            }

            // Intersection Observer to trigger animation when section is visible
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(function(entry) {
                        if (entry.isIntersecting && !hasAnimated) {
                            hasAnimated = true;
                            
                            // Animate all numbers with slight delay between each
                            statNumbers.forEach(function(statNumber, index) {
                                setTimeout(function() {
                                    animateNumber(statNumber);
                                }, index * 200); // 200ms delay between each number
                            });
                            
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    threshold: 0.3 // Trigger when 30% of section is visible
                });

                observer.observe(statsSection);
            } else {
                // Fallback for older browsers - animate immediately
                statNumbers.forEach(function(statNumber, index) {
                    setTimeout(function() {
                        animateNumber(statNumber);
                    }, index * 200);
                });
            }
        }

        // Initialize on document ready
        $(document).ready(function() {
            startStatsCounter();
        });

        // Export for use in other modules
        window.initStatsCounter = startStatsCounter;
    }
    
    // Start initialization
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initStatsCounter);
    } else {
        initStatsCounter();
    }

})();
