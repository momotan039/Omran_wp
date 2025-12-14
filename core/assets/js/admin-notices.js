/**
 * Admin Notices JavaScript
 * 
 * Handles interactive admin notices for preset demo import
 */

(function($) {
    'use strict';
    
    $(document).ready(function() {
        
        // Handle demo import button click
        $(document).on('click', '.alomran-import-demo-btn', function(e) {
            e.preventDefault();
            
            var $button = $(this);
            var $notice = $button.closest('.alomran-demo-notice');
            var $progress = $notice.find('.alomran-import-progress');
            var $progressFill = $notice.find('.alomran-progress-fill');
            var $progressText = $notice.find('.alomran-progress-text');
            var preset = $button.data('preset');
            var nonce = $button.data('nonce') || alomranAdmin.nonce;
            
            // Disable button
            $button.prop('disabled', true);
            $button.html('<span class="dashicons dashicons-update spin" style="margin-top: 3px;"></span> ' + alomranAdmin.strings.importing);
            
            // Show progress
            $progress.show();
            $progressFill.css('width', '10%');
            $progressText.text('جاري التحضير...');
            
            // Import demo data
            $.ajax({
                url: alomranAdmin.ajaxurl,
                type: 'POST',
                data: {
                    action: 'alomran_import_demo',
                    preset: preset,
                    import_content: true,
                    import_media: true,
                    import_redux: true,
                    import_menus: true,
                    overwrite: false,
                    nonce: nonce
                },
                success: function(response) {
                    if (response.success) {
                        $progressFill.css('width', '100%');
                        $progressText.text(alomranAdmin.strings.success);
                        
                        // Update button
                        $button.html('<span class="dashicons dashicons-yes" style="margin-top: 3px; color: #46b450;"></span> ' + alomranAdmin.strings.success);
                        
                        // Reload page after short delay
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        $progressFill.css('width', '0%');
                        $progressText.text(response.data && response.data.message ? response.data.message : alomranAdmin.strings.error);
                        $button.prop('disabled', false);
                        $button.html('<span class="dashicons dashicons-download" style="margin-top: 3px;"></span> ' + alomranAdmin.strings.importButton);
                    }
                },
                error: function() {
                    $progressFill.css('width', '0%');
                    $progressText.text(alomranAdmin.strings.error);
                    $button.prop('disabled', false);
                    $button.html('<span class="dashicons dashicons-download" style="margin-top: 3px;"></span> Import Demo Content');
                }
            });
        });
        
        // Add spin animation
        $('<style>')
            .prop('type', 'text/css')
            .html('.dashicons-update.spin { animation: spin 1s linear infinite; } @keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }')
            .appendTo('head');
    });
    
})(jQuery);

