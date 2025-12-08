/**
 * Main JavaScript file for Al-Omran Theme
 * 
 * This file initializes all modules
 * 
 * @package AlOmran
 */

(function() {
    'use strict';
    
    function initMain() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initMain, 50);
            return;
        }
        
        var $ = jQuery;
        
        $(document).ready(function() {
            // All modules are initialized in their respective files
            // This main file serves as the entry point
            
            // Additional global initialization can go here if needed
            console.log('Al-Omran Theme JavaScript loaded');
        });
    }
    
    // Start initialization
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initMain);
    } else {
        initMain();
    }

})();
