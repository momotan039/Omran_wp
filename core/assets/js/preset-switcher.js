/**
 * Preset Switcher JavaScript
 * 
 * Handles dynamic preset switching, preview, and instant updates.
 * 
 * @package AlOmran_Core
 */

(function($) {
    'use strict';
    
    const PresetSwitcher = {
        init: function() {
            this.bindEvents();
            this.loadCurrentPreset();
        },
        
        bindEvents: function() {
            // Preset selector change
            $(document).on('change', '#redux-opt-theme_preset', function() {
                const presetId = $(this).val();
                PresetSwitcher.showPreview(presetId);
            });
            
            // Apply preset button
            $(document).on('click', '#omran-apply-preset', function(e) {
                e.preventDefault();
                PresetSwitcher.applyPreset();
            });
            
            // Preview preset button
            $(document).on('click', '#omran-preview-preset', function(e) {
                e.preventDefault();
                const presetId = $('#redux-opt-theme_preset').val();
                PresetSwitcher.previewPreset(presetId);
            });
            
            // Color picker changes - update preview
            $(document).on('change', '.redux-color, .redux-color-picker', function() {
                PresetSwitcher.updateColorPreview();
            });
        },
        
        loadCurrentPreset: function() {
            const presetId = $('#redux-opt-theme_preset').val();
            if (presetId) {
                this.showPreview(presetId);
            }
        },
        
        showPreview: function(presetId) {
            if (!presetId) {
                $('#omran-preset-preview').hide();
                return;
            }
            
            // Show loading
            $('#omran-preset-preview-content').html('<p>' + omranPresetSwitcher.strings.loading + '</p>');
            $('#omran-preset-preview').show();
            
            // Get preset preview via AJAX
            $.ajax({
                url: omranPresetSwitcher.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'omran_get_preset_preview',
                    preset_id: presetId,
                    nonce: omranPresetSwitcher.previewNonce
                },
                success: function(response) {
                    if (response.success) {
                        $('#omran-preset-preview-content').html(response.data.preview);
                        PresetSwitcher.updatePresetInfo(response.data.config);
                    } else {
                        $('#omran-preset-preview-content').html('<p class="error">' + response.data.message + '</p>');
                    }
                },
                error: function() {
                    $('#omran-preset-preview-content').html('<p class="error">' + omranPresetSwitcher.strings.error + '</p>');
                }
            });
        },
        
        updatePresetInfo: function(config) {
            // Update preset name
            if (config.name) {
                $('#preset-name').text(config.name);
            }
            
            // Update description
            if (config.description) {
                $('#preset-description').text(config.description);
            }
            
            // Update color previews
            if (config.colors) {
                const colors = config.colors;
                const colorKeys = ['primary', 'secondary', 'accent'];
                $('#preset-colors-preview .color-preview').each(function(index) {
                    if (colorKeys[index] && colors[colorKeys[index]]) {
                        $(this).css('background-color', colors[colorKeys[index]]);
                    }
                });
            }
        },
        
        applyPreset: function() {
            const presetId = $('#redux-opt-theme_preset').val();
            if (!presetId) {
                return;
            }
            
            // Collect color values
            const colors = {
                primary: $('#redux-opt-preset_primary_color').val() || '',
                secondary: $('#redux-opt-preset_secondary_color').val() || '',
                accent: $('#redux-opt-preset_accent_color').val() || '',
                background: $('#redux-opt-preset_background_color').val() || '',
                text: $('#redux-opt-preset_text_color').val() || ''
            };
            
            // Get other settings
            const updateTailwind = $('#redux-opt-preset_update_tailwind').is(':checked');
            const rebuildStyles = $('#redux-opt-preset_rebuild_styles').val() === 'auto';
            
            // Show loading
            const $button = $('#omran-apply-preset');
            const originalText = $button.text();
            $button.prop('disabled', true).text(omranPresetSwitcher.strings.applying);
            
            // Apply preset via AJAX
            $.ajax({
                url: omranPresetSwitcher.ajaxUrl,
                type: 'POST',
                data: {
                    action: 'omran_switch_preset',
                    preset_id: presetId,
                    colors: colors,
                    update_tailwind: updateTailwind,
                    rebuild_styles: rebuildStyles,
                    nonce: omranPresetSwitcher.nonce
                },
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        $button.text(omranPresetSwitcher.strings.applied).removeClass('button-primary').addClass('button-success');
                        
                        // Update UI with new colors
                        PresetSwitcher.updateUI(response.data.config);
                        
                        // Reload page after short delay to apply all changes
                        setTimeout(function() {
                            window.location.reload();
                        }, 1500);
                    } else {
                        alert(response.data.message || omranPresetSwitcher.strings.error);
                        $button.prop('disabled', false).text(originalText);
                    }
                },
                error: function() {
                    alert(omranPresetSwitcher.strings.error);
                    $button.prop('disabled', false).text(originalText);
                }
            });
        },
        
        previewPreset: function(presetId) {
            // Open preview in new window
            const previewUrl = window.location.origin + '?omran_preview=' + presetId;
            window.open(previewUrl, '_blank');
        },
        
        updateColorPreview: function() {
            // Update color preview boxes with current color picker values
            const primary = $('#redux-opt-preset_primary_color').val();
            const secondary = $('#redux-opt-preset_secondary_color').val();
            const accent = $('#redux-opt-preset_accent_color').val();
            
            if (primary) {
                $('#preset-colors-preview .color-preview').eq(0).css('background-color', primary);
            }
            if (secondary) {
                $('#preset-colors-preview .color-preview').eq(1).css('background-color', secondary);
            }
            if (accent) {
                $('#preset-colors-preview .color-preview').eq(2).css('background-color', accent);
            }
        },
        
        updateUI: function(config) {
            // Update CSS variables instantly (if on frontend)
            if (config && config.colors) {
                const root = document.documentElement;
                Object.keys(config.colors).forEach(function(key) {
                    const varName = '--preset-' + key.replace(/_/g, '-');
                    root.style.setProperty(varName, config.colors[key]);
                });
            }
        }
    };
    
    // Initialize when document is ready
    $(document).ready(function() {
        PresetSwitcher.init();
    });
    
    // Also initialize when Redux is ready
    if (typeof redux !== 'undefined') {
        $(document).on('redux_init', function() {
            PresetSwitcher.init();
        });
    }
    
})(jQuery);

