/**
 * Industrial Preset JavaScript
 * 
 * Additional JavaScript specific to the Industrial preset
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Industrial-specific animations
        if ($('.preset-industrial').length) {
            
            // Smooth scroll for anchor links
            $('a[href^="#"]').on('click', function(e) {
                var target = $(this.getAttribute('href'));
                if (target.length) {
                    e.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 80
                    }, 1000);
                }
            });
            
            // Statistics counter animation
            $('.stat-number').each(function() {
                var $this = $(this);
                var countTo = $this.attr('data-count');
                
                $({ countNum: $this.text() }).animate({
                    countNum: countTo
                }, {
                    duration: 2000,
                    easing: 'swing',
                    step: function() {
                        $this.text(Math.floor(this.countNum));
                    },
                    complete: function() {
                        $this.text(this.countNum);
                    }
                });
            });
        }
    });
    
})(jQuery);

