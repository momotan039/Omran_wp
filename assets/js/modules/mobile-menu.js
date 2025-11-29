/**
 * Mobile Menu Toggle
 * 
 * @package AlOmran
 */

(function($) {
    'use strict';

    const MobileMenu = {
        init: function() {
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
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        MobileMenu.init();
    });

    // Export for use in other modules
    window.MobileMenu = MobileMenu;

})(jQuery);

