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
                        <button id="chat-widget-toggle" class="fixed bottom-6 left-6 z-50 p-4 rounded-full shadow-2xl transition-all duration-300 transform hover:scale-110 bg-primary animate-bounce">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                        </button>
                    `);

                    // Create chat window
                    $('body').append(`
                        <div id="chat-widget-window" class="fixed bottom-24 left-6 z-50 w-[90vw] md:w-96 h-[500px] bg-white rounded-2xl shadow-2xl flex flex-col overflow-hidden border border-gray-200 hidden">
                            <div class="bg-primary p-4 text-white flex items-center justify-between shadow-md">
                                <div class="flex items-center gap-3">
                                    <div class="bg-white/20 p-2 rounded-full">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-bold">مساعد العمران</h3>
                                        <div class="flex items-center gap-1 text-xs text-green-100">
                                            <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                            متصل الآن
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-secondary/20 px-2 py-1 rounded text-xs font-mono">AI Beta</div>
                            </div>

                            <div id="chat-messages" class="flex-grow p-4 overflow-y-auto bg-gray-50 custom-scrollbar">
                                <div class="space-y-4">
                                    <div class="flex justify-start">
                                        <div class="max-w-[80%] p-3 rounded-2xl shadow-sm text-sm leading-relaxed bg-white text-gray-800 border border-gray-200 rounded-br-none">
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

                            <form id="chat-form" class="p-3 bg-white border-t border-gray-100">
                                <div class="relative flex items-center gap-2">
                                    <input
                                        type="text"
                                        id="chat-input"
                                        placeholder="اكتب استفسارك هنا..."
                                        class="flex-grow bg-gray-100 text-gray-700 rounded-full px-5 py-3 pr-5 focus:outline-none focus:ring-2 focus:ring-secondary/50 transition-all text-sm"
                                    />
                                    <button
                                        type="submit"
                                        id="chat-send-btn"
                                        class="bg-secondary text-white p-3 rounded-full hover:bg-green-600 disabled:opacity-50 disabled:cursor-not-allowed transition-all transform hover:scale-105 shadow-md"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="text-center mt-2">
                                    <span class="text-[10px] text-gray-400">مدعوم بالذكاء الاصطناعي - قد تحدث أخطاء</span>
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
                    $(this).toggleClass('bg-primary bg-red-500 rotate-90');
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

                const messageHtml = `
                    <div class="flex ${isUser ? 'justify-end' : 'justify-start'} animate-fade-in-up">
                        <div class="max-w-[80%] p-3 rounded-2xl shadow-sm text-sm leading-relaxed ${
                            isUser 
                                ? 'bg-primary text-white rounded-bl-none' 
                                : 'bg-white text-gray-800 border border-gray-200 rounded-br-none'
                        }">
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
                        <div class="bg-white p-3 rounded-2xl rounded-br-none border border-gray-200 shadow-sm flex items-center gap-2">
                            <svg class="w-4 h-4 animate-spin text-secondary" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs text-gray-400">جاري الكتابة...</span>
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
