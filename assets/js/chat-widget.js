/**
 * Chat Widget JavaScript
 * Note: This requires API key configuration in WordPress admin
 */

(function() {
    'use strict';
    
    function initChatWidget() {
        if (typeof jQuery === 'undefined') {
            setTimeout(initChatWidget, 50);
            return;
        }
        
        var $ = jQuery;
        
        const ChatWidget = {
            init: function() {
                this.createWidget();
                this.attachEvents();
            },

            createWidget: function() {
                // Create toggle button
                if ($('#chat-widget-toggle').length === 0) {
                    $('body').append(`
                        <button id="chat-widget-toggle" class="fixed bottom-6 left-6 z-50 p-4 rounded-full shadow-2xl transition-all duration-300 transform hover:scale-110 animate-bounce" style="background-color: var(--theme-primary);">
                            <svg class="w-7 h-7" style="color: var(--theme-white);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </button>
                    `);

                    // Create chat window
                    $('body').append(`
                        <div id="chat-widget-window" class="fixed bottom-24 left-6 z-50 w-[90vw] md:w-96 h-[500px] rounded-2xl shadow-2xl flex flex-col overflow-hidden border hidden" style="background-color: var(--theme-white); border-color: var(--theme-gray-200);">
                            <div class="p-4 flex items-center justify-between shadow-md" style="background-color: var(--theme-primary); color: var(--theme-white);">
                                <div class="flex items-center gap-3">
                                    <div class="p-2 rounded-full" style="background-color: rgba(255, 255, 255, 0.2);">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold">مساعد العمران</h3>
                                        <div class="flex items-center gap-1 text-xs" style="color: rgba(255, 255, 255, 0.9);">
                                            <span class="w-2 h-2 rounded-full animate-pulse" style="background-color: rgba(34, 197, 94, 0.8);"></span>
                                            متصل الآن
                                        </div>
                                    </div>
                                </div>
                                <div class="px-2 py-1 rounded text-xs font-mono" style="background-color: rgba(var(--theme-secondary-rgb), 0.2);">AI Beta</div>
                            </div>

                            <div id="chat-messages" class="flex-grow p-4 overflow-y-auto custom-scrollbar" style="background-color: var(--theme-gray-50);">
                                <div class="space-y-4">
                                    <div class="flex justify-start">
                                        <div class="max-w-[80%] p-3 rounded-2xl shadow-sm text-sm leading-relaxed rounded-br-none" style="background-color: var(--theme-white); color: var(--theme-gray-800); border-color: var(--theme-gray-200); border: 1px solid;">
                                            <div class="flex items-center gap-1 mb-1 text-secondary font-bold text-xs">
                                                <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                                </svg>
                                                المساعد
                                            </div>
                                            أهلاً بك في العمران! 👋 أنا مساعدك الذكي. كيف يمكنني مساعدتك اليوم؟ تسألني عن المنتجات، المواصفات، أو الأسعار.
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <form id="chat-form" class="p-3 border-t" style="background-color: var(--theme-white); border-color: var(--theme-gray-100);">
                                <div class="relative flex items-center gap-2">
                                    <input
                                        type="text"
                                        id="chat-input"
                                        placeholder="اكتب استفسارك هنا..."
                                        class="flex-grow rounded-full px-5 py-3 pr-5 focus:outline-none transition-all text-sm"
                                        style="background-color: var(--theme-gray-100); color: var(--theme-gray-700);"
                                        onfocus="this.style.boxShadow='0 0 0 2px rgba(var(--theme-secondary-rgb), 0.5)'"
                                        onblur="this.style.boxShadow='none'"
                                    />
                                    <button
                                        type="submit"
                                        id="chat-send-btn"
                                        class="p-3 rounded-full disabled:opacity-50 disabled:cursor-not-allowed transition-all transform hover:scale-105 shadow-md"
                                        style="background-color: var(--theme-secondary); color: var(--theme-white);"
                                        onmouseover="this.style.backgroundColor='var(--theme-secondary)'"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-[10px]" style="color: var(--theme-gray-400);">مدعوم بالذكاء الاصطناعي - قد تحدث أخطاء</span>
                                </div>
                            </form>
                        </div>
                    `);
                }
            },

            attachEvents: function() {
                const $toggle = $('#chat-widget-toggle');
                const $window = $('#chat-widget-window');
                const $form = $('#chat-form');
                const $input = $('#chat-input');
                const $messages = $('#chat-messages');
                const $sendBtn = $('#chat-send-btn');

                // Toggle chat window
                $toggle.on('click', function() {
                    $window.toggleClass('hidden');
                    const $btn = $(this);
                    if ($window.hasClass('hidden')) {
                        $btn.css('background-color', 'var(--theme-primary)').removeClass('rotate-90');
                    } else {
                        $btn.css('background-color', 'var(--theme-accent)').addClass('rotate-90');
                    }
                    if (!$window.hasClass('hidden')) {
                        $input.focus();
                    }
                });

                // Send message
                $form.on('submit', function(e) {
                    e.preventDefault();
                    const message = $input.val().trim();
                    if (!message) return;

                    // Add user message
                    ChatWidget.addMessage(message, 'user');
                    $input.val('');
                    $sendBtn.prop('disabled', true);

                    // Show loading
                    ChatWidget.showLoading();

                    // Send to backend (AJAX)
                    $.ajax({
                        url: alomranAjax.ajaxurl,
                        type: 'POST',
                        data: {
                            action: 'alomran_chat_message',
                            nonce: alomranAjax.nonce,
                            message: message
                        },
                        success: function(response) {
                            ChatWidget.hideLoading();
                            if (response.success) {
                                ChatWidget.addMessage(response.data.message, 'bot');
                            } else {
                                ChatWidget.addMessage('عذراً، حدث خطأ في الاتصال. يرجى المحاولة لاحقاً أو الاتصال بنا مباشرة.', 'bot');
                            }
                            $sendBtn.prop('disabled', false);
                        },
                        error: function() {
                            ChatWidget.hideLoading();
                            ChatWidget.addMessage('عذراً، حدث خطأ في الاتصال. يرجى المحاولة لاحقاً أو الاتصال بنا مباشرة.', 'bot');
                            $sendBtn.prop('disabled', false);
                        }
                    });
                });
            },

            addMessage: function(text, sender) {
                const $messages = $('#chat-messages');
                const isUser = sender === 'user';
                const icon = isUser ? '' : `
                    <div class="flex items-center gap-1 mb-1 text-secondary font-bold text-xs">
                        <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        المساعد
                    </div>
                `;

                const userStyle = isUser 
                    ? 'background-color: var(--theme-primary); color: var(--theme-white);'
                    : 'background-color: var(--theme-white); color: var(--theme-gray-800); border: 1px solid; border-color: var(--theme-gray-200);';
                
                const messageHtml = `
                    <div class="flex ${isUser ? 'justify-end' : 'justify-start'} animate-fade-in-up">
                        <div class="max-w-[80%] p-3 rounded-2xl shadow-sm text-sm leading-relaxed ${isUser ? 'rounded-bl-none' : 'rounded-br-none'}" style="${userStyle}">
                            ${icon}
                            ${text}
                        </div>
                    </div>
                `;

                $messages.find('.space-y-4').append(messageHtml);
                $messages.scrollTop($messages[0].scrollHeight);
            },

            showLoading: function() {
                const $messages = $('#chat-messages');
                const loadingHtml = `
                    <div class="flex justify-start">
                        <div class="p-3 rounded-2xl rounded-br-none border shadow-sm flex items-center gap-2" style="background-color: var(--theme-white); border-color: var(--theme-gray-200);">
                            <svg class="w-4 h-4 animate-spin" style="color: var(--theme-secondary);" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs" style="color: var(--theme-gray-400);">جاري الكتابة...</span>
                        </div>
                    </div>
                `;
                $messages.find('.space-y-4').append(loadingHtml);
                $messages.scrollTop($messages[0].scrollHeight);
            },

            hideLoading: function() {
                $('#chat-messages .animate-spin').closest('.flex').remove();
            }
        };

        // Initialize on DOM ready
        $(document).ready(function() {
            try {
                ChatWidget.init();
            } catch (e) {
                console.error('ChatWidget initialization error:', e);
            }
        });
    }
    
    // Start initialization - multiple fallbacks
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initChatWidget);
    } else {
        // DOM already loaded, initialize immediately
        setTimeout(initChatWidget, 100);
    }
    
    // Fallback: Try again after window loads
    window.addEventListener('load', function() {
        if (typeof jQuery !== 'undefined' && jQuery('#chat-widget-toggle').length === 0) {
            setTimeout(initChatWidget, 200);
        }
    });

})();
