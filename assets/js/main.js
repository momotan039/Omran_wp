/**
 * Main JavaScript file for Al-Omran Theme
 * 
 * This file initializes all modules
 * 
 * @package AlOmran
 */

// Load all modules
// Note: These should be enqueued in the correct order in functions.php/assets.php

// Modules are loaded separately:
// 1. loader.js - Page Loader Management
// 2. mobile-menu.js - Mobile Menu Toggle
// 3. faq.js - FAQ Accordion & Search
// 4. contact-form.js - Contact Form AJAX
// 5. animations.js - Scroll Animations & Lazy Loading
// 6. stats-counter.js - Stats Counter Animation
// 7. product-gallery.js - Product Gallery & Share

(function($) {
    'use strict';

    $(document).ready(function() {
        // All modules are initialized in their respective files
        // This main file serves as the entry point
        
        // Additional global initialization can go here if needed
        console.log('Al-Omran Theme JavaScript loaded');
    });

})(jQuery);
