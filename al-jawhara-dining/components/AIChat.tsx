
import React, { useState, useRef, useEffect } from 'react';
import { MessageSquare, Send, X, Sparkles, Loader2, Bot } from 'lucide-react';
import { motion, AnimatePresence } from 'framer-motion';
import { sendMessageToGemini } from '../services/geminiService';
import { ChatMessage } from '../types';

const AIChat: React.FC = () => {
  const [isOpen, setIsOpen] = useState(false);
  const [messages, setMessages] = useState<ChatMessage[]>([
    {
      id: 'welcome',
      role: 'model',
      text: 'أهلاً بك في الجوهرة. أنا ليلى، مساعدتك الذكية. كيف يمكنني إثراء تجربتك اليوم؟',
      timestamp: new Date(),
    }
  ]);
  const [inputValue, setInputValue] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  const messagesEndRef = useRef<HTMLDivElement>(null);

  const scrollToBottom = () => messagesEndRef.current?.scrollIntoView({ behavior: "smooth" });
  useEffect(() => { scrollToBottom(); }, [messages, isOpen]);

  const handleSend = async () => {
    if (!inputValue.trim()) return;
    const userMsg: ChatMessage = { id: Date.now().toString(), role: 'user', text: inputValue, timestamp: new Date() };
    setMessages(prev => [...prev, userMsg]);
    setInputValue('');
    setIsLoading(true);

    try {
      const responseText = await sendMessageToGemini(userMsg.text);
      setMessages(prev => [...prev, { id: (Date.now() + 1).toString(), role: 'model', text: responseText, timestamp: new Date() }]);
    } catch (error) {
      console.error(error);
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <>
      <motion.button
        onClick={() => setIsOpen(true)}
        className={`fixed bottom-8 left-8 z-[100] bg-brand-black text-brand-gold w-16 h-16 rounded-full luxury-shadow flex items-center justify-center border border-brand-gold/30 hover:scale-110 transition-transform ${isOpen ? 'hidden' : 'flex'}`}
        initial={{ scale: 0 }} animate={{ scale: 1 }}
      >
        <Sparkles size={28} />
      </motion.button>

      <AnimatePresence>
        {isOpen && (
          <motion.div
            initial={{ opacity: 0, scale: 0.95, y: 20 }}
            animate={{ opacity: 1, scale: 1, y: 0 }}
            exit={{ opacity: 0, scale: 0.95, y: 20 }}
            className="fixed bottom-8 left-8 md:left-12 z-[100] w-[90vw] md:w-[400px] h-[600px] bg-brand-cream rounded-[40px] luxury-shadow border border-brand-gold/20 flex flex-col overflow-hidden"
          >
            <div className="bg-brand-black p-8 flex justify-between items-center text-white">
              <div className="flex items-center gap-4">
                <div className="w-14 h-14 bg-gold-gradient rounded-full flex items-center justify-center text-brand-black">
                  <Bot size={28} />
                </div>
                <div>
                  <h3 className="font-black text-brand-gold text-xl leading-none">ليلى</h3>
                  <p className="text-xs text-gray-500 mt-1 uppercase tracking-widest">Concierge</p>
                </div>
              </div>
              <button onClick={() => setIsOpen(false)} className="text-gray-500 hover:text-white"><X size={24} /></button>
            </div>

            <div className="flex-1 overflow-y-auto p-8 space-y-6 bg-brand-cream">
              {messages.map((msg) => (
                <div key={msg.id} className={`flex ${msg.role === 'user' ? 'justify-start' : 'justify-end'}`}>
                  <div className={`max-w-[85%] p-5 rounded-[30px] text-lg leading-relaxed ${
                    msg.role === 'user' ? 'bg-brand-black text-white rounded-br-none shadow-xl' : 'bg-white text-brand-gray rounded-bl-none shadow-md border border-gray-100'
                  }`}>
                    {msg.text}
                  </div>
                </div>
              ))}
              {isLoading && (
                <div className="flex justify-end">
                   <div className="bg-white p-5 rounded-[30px] rounded-bl-none shadow-md border border-gray-100"><Loader2 size={24} className="animate-spin text-brand-gold" /></div>
                </div>
              )}
              <div ref={messagesEndRef} />
            </div>

            <div className="p-6 bg-white border-t border-gray-100 flex gap-4 items-center">
              <input
                type="text" value={inputValue} onChange={(e) => setInputValue(e.target.value)}
                onKeyDown={(e) => e.key === 'Enter' && handleSend()}
                placeholder="تحدثي معي..."
                className="flex-1 bg-gray-50 rounded-2xl px-6 py-4 text-lg focus:outline-none focus:ring-2 focus:ring-brand-gold text-right"
              />
              <button onClick={handleSend} disabled={!inputValue.trim() || isLoading} className="bg-brand-black text-brand-gold w-14 h-14 rounded-2xl flex items-center justify-center hover:bg-brand-gold hover:text-brand-black transition-all disabled:opacity-50">
                <Send size={24} className="rtl:rotate-180" />
              </button>
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </>
  );
};

export default AIChat;
