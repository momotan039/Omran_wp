/**
 * FAQ Accordion & Search
 * 
 * @package AlOmran
 */

(function($) {
    'use strict';

    const FAQ = {
        init: function() {
            this.initAccordion();
            this.initSearch();
        },

        initAccordion: function() {
            $('.faq-toggle').on('click', function(e) {
                e.preventDefault();
                const $item = $(this).closest('.faq-item');
                const $content = $item.find('.faq-content');
                const $icon = $(this).find('.faq-icon');
                const isOpen = $content.hasClass('max-h-48');

                // Close all items
                $('.faq-item').removeClass('border-secondary bg-blue-50/30');
                $('.faq-content').removeClass('max-h-48 opacity-100').addClass('max-h-0 opacity-0');
                $('.faq-toggle span').removeClass('text-secondary').addClass('text-gray-700');
                $('.faq-icon').html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>').removeClass('text-secondary').addClass('text-gray-400');

                if (isOpen) {
                    // Do nothing if already open (close it)
                } else {
                    // Open clicked item
                    $item.addClass('border-secondary bg-blue-50/30');
                    $content.removeClass('max-h-0 opacity-0').addClass('max-h-48 opacity-100');
                    $(this).find('span').removeClass('text-gray-700').addClass('text-secondary');
                    $icon.html('<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>').removeClass('text-gray-400').addClass('text-secondary');
                }
            });
        },

        initSearch: function() {
            $('#faq-search').on('input', function() {
                const searchTerm = $(this).val().toLowerCase();
                $('.faq-item').each(function() {
                    const question = $(this).data('question') || '';
                    const answer = $(this).data('answer') || '';
                    
                    if (question.includes(searchTerm) || answer.includes(searchTerm)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        }
    };

    // Initialize on document ready
    $(document).ready(function() {
        FAQ.init();
    });

    // Export for use in other modules
    window.FAQ = FAQ;

})(jQuery);

