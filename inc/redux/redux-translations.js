/**
 * Redux Arabic Translations
 * Auto-generated JavaScript for translating Redux interface
 */
(function() {
    var translations = {
        save_changes: '{{SAVE_CHANGES}}',
        reset_section: '{{RESET_SECTION}}',
        reset_all: '{{RESET_ALL}}',
        upload: '{{UPLOAD}}',
        remove: '{{REMOVE}}',
        on: '{{ON}}',
        off: '{{OFF}}'
    };
    
    function translateText(element, original, translated) {
        if (element.value && element.value.indexOf(original) !== -1) {
            element.value = element.value.replace(new RegExp(original, 'gi'), translated);
        }
        if (element.textContent && element.textContent.indexOf(original) !== -1) {
            element.textContent = element.textContent.replace(new RegExp(original, 'gi'), translated);
        }
        if (element.innerHTML && element.innerHTML.indexOf(original) !== -1) {
            element.innerHTML = element.innerHTML.replace(new RegExp(original, 'gi'), translated);
        }
        if (element.getAttribute('title') && element.getAttribute('title').indexOf(original) !== -1) {
            element.setAttribute('title', element.getAttribute('title').replace(new RegExp(original, 'gi'), translated));
        }
    }
    
    function translateReduxStrings() {
        var selectors = ['button', 'a', 'input[type="button"]', 'input[type="submit"]', '.button'];
        var elements = document.querySelectorAll(selectors.join(', '));
        
        elements.forEach(function(el) {
            var text = (el.textContent || el.value || el.innerHTML || el.getAttribute('title') || '').trim();
            
            if (text.indexOf('Save Changes') !== -1) {
                translateText(el, 'Save Changes', translations.save_changes);
            }
            if (text.indexOf('Reset Section') !== -1) {
                translateText(el, 'Reset Section', translations.reset_section);
            }
            if (text.indexOf('Reset All') !== -1) {
                translateText(el, 'Reset All', translations.reset_all);
            }
            if (text === 'Upload' || text === 'upload') {
                translateText(el, text, translations.upload);
            }
            if (text === 'Remove' || text === 'remove') {
                translateText(el, text, translations.remove);
            }
        });
        
        // Translate switch labels
        document.querySelectorAll('.redux-field-switch, [class*="switch"]').forEach(function(container) {
            container.querySelectorAll('span, label, div').forEach(function(el) {
                var text = (el.textContent || '').trim().toLowerCase();
                if (text === 'on') {
                    el.textContent = translations.on;
                } else if (text === 'off') {
                    el.textContent = translations.off;
                }
            });
        });
    }
    
    // Run translations
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', translateReduxStrings);
    } else {
        translateReduxStrings();
    }
    
    // Run after delays for dynamically loaded content
    [100, 300, 500, 1000, 2000, 3000].forEach(function(delay) {
        setTimeout(translateReduxStrings, delay);
    });
    
    // Watch for dynamically added content
    var observer = new MutationObserver(function() {
        setTimeout(translateReduxStrings, 200);
    });
    
    observer.observe(document.body, {
        childList: true,
        subtree: true,
        characterData: true
    });
    
    // Listen for Redux events
    if (typeof jQuery !== 'undefined') {
        jQuery(document).on('redux-init redux-loaded', function() {
            setTimeout(translateReduxStrings, 100);
        });
    }
})();

