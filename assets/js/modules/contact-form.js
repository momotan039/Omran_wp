/**
 * Contact Form AJAX Handler
 * 
 * @package AlOmran
 */

(function($) {
    'use strict';

    const ContactForm = {
        init: function() {
            $('#contact-form').on('submit', function(e) {
                e.preventDefault();
                ContactForm.handleSubmit($(this));
            });
        },

        handleSubmit: function($form) {
            const $submitBtn = $form.find('button[type="submit"]');
            const $messageDiv = $('#form-message');
            const formData = {
                action: 'alomran_contact_form',
                nonce: alomranAjax.nonce,
                name: $form.find('input[name="name"]').val(),
                phone: $form.find('input[name="phone"]').val(),
                email: $form.find('input[name="email"]').val(),
                message: $form.find('textarea[name="message"]').val()
            };

            // Disable submit button and show loading
            $submitBtn.prop('disabled', true).html('<span class="inline-flex items-center gap-2"><svg class="w-4 h-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg> جاري الإرسال...</span>');

            $.ajax({
                url: alomranAjax.ajaxurl,
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        ContactForm.showSuccess($messageDiv, response.data.message);
                        $form[0].reset();
                        
                        // Reset button after 3 seconds
                        setTimeout(function() {
                            $messageDiv.addClass('hidden').removeClass('bg-green-50 text-green-700 p-4 rounded-lg text-center animate-scale-in');
                            $submitBtn.prop('disabled', false).html('إرسال الآن <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>');
                        }, 3000);
                    } else {
                        ContactForm.showError($messageDiv, response.data.message || 'حدث خطأ. يرجى المحاولة مرة أخرى.');
                        $submitBtn.prop('disabled', false).html('إرسال الآن <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Contact form error:', error);
                    ContactForm.showError($messageDiv, 'حدث خطأ في الاتصال. يرجى المحاولة مرة أخرى.');
                    $submitBtn.prop('disabled', false).html('إرسال الآن <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>');
                }
            });
        },

        showSuccess: function($messageDiv, message) {
            $messageDiv
                .removeClass('hidden bg-red-50 text-red-700')
                .addClass('bg-green-50 text-green-700 p-4 rounded-lg text-center animate-scale-in')
                .text(message);
        },

        showError: function($messageDiv, message) {
            $messageDiv
                .removeClass('hidden bg-green-50 text-green-700')
                .addClass('bg-red-50 text-red-700 p-4 rounded-lg text-center animate-scale-in')
                .text(message);
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        ContactForm.init();
    });

    // Export for use in other modules
    window.ContactForm = ContactForm;

})(jQuery);

