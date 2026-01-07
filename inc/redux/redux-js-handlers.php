<?php
/**
 * Redux JavaScript Handlers
 * JavaScript code for Redux admin interface
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

// This file is included by redux-translations.php
// Output JavaScript code for Redux admin interface
?>
<script type="text/javascript">
(function($) {
    'use strict';
    
    var currentPreset = '<?php echo esc_js($current_preset); ?>';
    
    // Preserve theme_preset when resetting all
    $(document).on('click', '.redux-action_bar .redux-reset-all', function(e) {
        // Store current preset before reset
        if (currentPreset && (currentPreset === 'industrial' || currentPreset === 'food' || currentPreset === 'tech')) {
            // Wait for reset to complete, then restore preset
            setTimeout(function() {
                var presetField = $('#redux-alomran_options-theme_preset');
                if (presetField.length) {
                    // Set the value
                    presetField.val(currentPreset).trigger('change');
                    
                    // If it's an image select, trigger click on the correct option
                    var presetOption = presetField.closest('.redux-field-container').find('input[type="radio"][value="' + currentPreset + '"]');
                    if (presetOption.length) {
                        presetOption.prop('checked', true).trigger('change');
                    }
                }
            }, 500);
        }
    });
    
    // Also intercept form submission on reset
    $(document).on('submit', 'form.redux-form-wrapper', function(e) {
        var form = $(this);
        var isReset = form.find('input[name="redux-reset"]').length > 0 || 
                     form.find('.redux-reset-all').length > 0 ||
                     window.location.href.indexOf('reset=all') !== -1;
        
        if (isReset && currentPreset && (currentPreset === 'industrial' || currentPreset === 'food' || currentPreset === 'tech')) {
            // Ensure theme_preset field has the correct value before submit
            var presetInput = form.find('input[name="alomran_options[theme_preset]"]');
            if (presetInput.length) {
                presetInput.val(currentPreset);
            }
            
            // Also check for image select radio buttons
            var presetRadio = form.find('input[type="radio"][name*="theme_preset"][value="' + currentPreset + '"]');
            if (presetRadio.length) {
                presetRadio.prop('checked', true);
            }
        }
    });
    
    // Monitor for preset changes and update currentPreset
    $(document).on('change', 'input[name*="theme_preset"], input[type="radio"][name*="theme_preset"]', function() {
        var newPreset = $(this).val();
        if (newPreset && (newPreset === 'industrial' || newPreset === 'food' || newPreset === 'tech')) {
            currentPreset = newPreset;
        }
    });
    
    /**
     * Unified function to detect section ID from button context
     * This is the PRIMARY method for detecting section IDs
     * Works for both homepage and page sections
     */
    function detectSectionIdFromButton(button) {
        var sectionId = '';
        
        // Configuration: Field ID to Section ID mapping
        // This is the SINGLE SOURCE OF TRUTH for field detection
        var fieldToSectionMap = {
            // Homepage sections (tab 8, redux-section 3)
            'tech_features_preview_items': 'tech_features_preview_section',
            'tech_stats_items': 'tech_stats_section',
            'tech_testimonials_items': 'tech_testimonials_section',
            // Page sections
            'tech_demo_benefits': 'tech_demo_page',
            'tech_pricing_plans': 'tech_pricing_page',
            'tech_features_categories': 'tech_features_page',
            'tech_use_cases_items': 'tech_use_cases_page',
        };
        
        // Method 1: Check for field IDs in the current section (PRIMARY METHOD)
        // This works for ALL subsections (homepage and pages)
        var currentSection = button.closest('.redux-section, .redux-group-tab, .redux-group, .redux-field-container, .redux-field');
        if (!currentSection.length) {
            // Try wider search if closest didn't work
            currentSection = button.parents('.redux-section, .redux-group-tab, .redux-group');
        }
        
        if (currentSection.length) {
            // Check each field ID in the map
            // IMPORTANT: Check homepage sections FIRST (they're more specific)
            var fieldIdsToCheck = [
                // Homepage sections (check first - more specific)
                'tech_features_preview_items',
                'tech_stats_items',
                'tech_testimonials_items',
                // Page sections
                'tech_demo_benefits',
                'tech_pricing_plans',
                'tech_features_categories',
                'tech_use_cases_items',
            ];
            
            for (var idx = 0; idx < fieldIdsToCheck.length; idx++) {
                var fieldId = fieldIdsToCheck[idx];
                if (!fieldToSectionMap.hasOwnProperty(fieldId)) {
                    continue;
                }
                
                // Multiple selectors to catch all possible field representations
                // IMPORTANT: Check for repeater-specific selectors first
                var selectors = [
                    // Repeater-specific selectors (most reliable)
                    '.redux-field-container[data-id*="' + fieldId + '"]',
                    '.redux-field[data-id*="' + fieldId + '"]',
                    '.redux-field[data-id="' + fieldId + '"]',
                    // General selectors
                    '[id*="' + fieldId + '"]',
                    '[name*="' + fieldId + '"]',
                    '[for*="' + fieldId + '"]',
                    'input[name*="' + fieldId + '"]',
                    'textarea[name*="' + fieldId + '"]',
                    'select[name*="' + fieldId + '"]',
                    // Repeater title bind (for group_values)
                    '.redux-repeater[data-id*="' + fieldId + '"]',
                    '.redux-repeater-title[data-field*="' + fieldId + '"]',
                ];
                
                var found = false;
                for (var i = 0; i < selectors.length; i++) {
                    var matches = currentSection.find(selectors[i]);
                    if (matches.length > 0) {
                        sectionId = fieldToSectionMap[fieldId];
                        found = true;
                        break;
                    }
                }
                
                if (found) {
                    break; // Found section, stop checking
                }
            }
        }
        
        // Method 2: Try from button's closest redux-section or redux-field-container
        if (!sectionId) {
            var sectionElement = button.closest('.redux-section, .redux-field-container');
            if (sectionElement.length) {
                sectionId = sectionElement.attr('id') || sectionElement.data('id');
                if (sectionId) {
                    // Remove redux prefix if exists
                    sectionId = sectionId.replace(/^redux-alomran_options-/, '');
                }
            }
        }
        
        // Method 3: Try from button's data attributes
        if (!sectionId) {
            sectionId = button.data('id') || button.attr('data-id') || button.data('section-id');
        }
        
        // Method 4: Try from href
        if (!sectionId) {
            var href = button.attr('href');
            if (href) {
                // Try multiple patterns
                var match = href.match(/section[=:]([^&]+)/i) || href.match(/[#&]tab[=:](\d+)/i);
                if (match) {
                    sectionId = match[1];
                }
            }
        }
        
        // Method 5: Try from parent section container
        if (!sectionId) {
            var parentSection = button.closest('[id*="section"], [id*="page"]');
            if (parentSection.length) {
                var parentId = parentSection.attr('id');
                if (parentId) {
                    // Remove redux prefix if exists
                    sectionId = parentId.replace(/^redux-alomran_options-/, '').replace(/^redux-section-/, '');
                }
            }
        }
        
        return sectionId;
    }
    
    // Handle section reset to ensure all default items are restored
    $(document).on('click', '.redux-reset-section', function(e) {
        var button = $(this);
        // Get current tab from URL
        var urlParams = new URLSearchParams(window.location.search);
        var currentTab = urlParams.get('tab');
        
        var sectionId = detectSectionIdFromButton(button);
        
        // If sectionId is still empty, try to get it from the button's context more aggressively
        if (!sectionId) {
            // Try to find the section ID from the button's parent sections
            var parentSection = button.closest('.redux-section, .redux-group-tab, .redux-group');
            if (parentSection.length) {
                // Try to extract section ID from parent
                var parentId = parentSection.attr('id') || parentSection.data('id');
                if (parentId) {
                    // Remove common prefixes
                    parentId = parentId.replace(/^redux-alomran_options-/, '')
                                      .replace(/^redux-section-/, '')
                                      .replace(/^section-/, '');
                    if (parentId && parentId !== 'redux-section') {
                        sectionId = parentId;
                    }
                }
            }
        }
        
        // Only handle Tech preset repeater sections
        if (currentPreset === 'tech' && sectionId) {
            // Get section configuration (matches PHP config)
            var repeaterSections = {
                // Homepage sections (tab 8, redux-section 3)
                'tech_features_preview_section': 'tech_features_preview_items',
                'tech_stats_section': 'tech_stats_items',
                'tech_testimonials_section': 'tech_testimonials_items',
                // Pages sections
                'tech_use_cases_page': 'tech_use_cases_items',
                'tech_features_page': 'tech_features_categories',
                'tech_pricing_page': 'tech_pricing_plans',
                'tech_demo_page': 'tech_demo_benefits'
            };
            
            if (repeaterSections[sectionId]) {
                var fieldId = repeaterSections[sectionId];
                
                // Store section ID in form before reset - use multiple methods
                var form = $('form.redux-form-wrapper');
                if (form.length) {
                    // Remove any existing hidden inputs
                    form.find('input[name="redux-reset-section"]').remove();
                    form.find('input[name="redux_reset_section"]').remove();
                    form.find('input[name="redux-reset-section-id"]').remove();
                    
                    // Add hidden inputs with section ID
                    form.append('<input type="hidden" name="redux-reset-section" value="' + sectionId + '">');
                    form.append('<input type="hidden" name="redux_reset_section" value="' + sectionId + '">');
                    form.append('<input type="hidden" name="redux-reset-section-id" value="' + sectionId + '">');
                    
                    // Also set as data attribute on form for PHP to access
                    form.data('redux-reset-section', sectionId);
                    form.attr('data-redux-reset-section', sectionId);
                }
                
                // Also store in sessionStorage for PHP to use
                if (typeof sessionStorage !== 'undefined') {
                    sessionStorage.setItem('redux_reset_section', sectionId);
                    sessionStorage.setItem('redux_reset_time', Date.now());
                }
                
                // Also store in cookie as backup (with longer expiration)
                var expireDate = new Date();
                expireDate.setTime(expireDate.getTime() + (60 * 1000)); // 1 minute
                document.cookie = 'redux_reset_section=' + sectionId + '; expires=' + expireDate.toUTCString() + '; path=/';
                
                // Also add to URL if it's a GET request
                if (button.attr('href') && button.attr('href').indexOf('?') !== -1) {
                    var url = button.attr('href');
                    if (url.indexOf('redux-reset-section=') === -1) {
                        url += (url.indexOf('&') !== -1 ? '&' : '&') + 'redux-reset-section=' + encodeURIComponent(sectionId);
                        button.attr('href', url);
                    }
                }
            }
        }
    });
    
})(jQuery);
</script>
<?php

