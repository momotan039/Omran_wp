
import React from 'react';
import { motion } from 'framer-motion';

const Hero: React.FC = () => {
  return (
    <section className="relative h-screen w-full overflow-hidden bg-brand-black flex items-center">
      {/* Background with subtle zoom */}
      <motion.div 
        initial={{ scale: 1.1 }}
        animate={{ scale: 1 }}
        transition={{ duration: 10, ease: "linear" }}
        className="absolute inset-0 z-0 opacity-60"
      >
        <img
          src="https://images.unsplash.com/photo-1544148103-0773bf10d330?q=80&w=1920&auto=format&fit=crop"
          alt="Al-Jawhara Ambience"
          className="w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-gradient-to-l from-brand-black via-brand-black/40 to-transparent" />
      </motion.div>

      <div className="relative z-20 max-w-7xl mx-auto px-8 w-full">
        <div className="max-w-3xl text-right">
          <motion.div
            initial={{ opacity: 0, x: 50 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 1, ease: "easeOut" }}
          >
            <span className="text-brand-gold font-bold tracking-[0.5em] uppercase text-sm mb-6 block drop-shadow-lg">
              Al-Jawhara Dining Experience
            </span>
          </motion.div>
          
          <motion.h1
            initial={{ opacity: 0, y: 30 }}
            animate={{ opacity: 1, y: 0 }}
            transition={{ duration: 1, delay: 0.3 }}
            className="text-6xl md:text-8xl lg:text-9xl font-black text-white leading-none mb-8 drop-shadow-2xl"
          >
            جوهرة <br />
            <span className="text-brand-gold italic">الضيافة</span>
          </motion.h1>

          <motion.p
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 1, delay: 0.6 }}
            className="text-xl md:text-2xl text-gray-200 font-light leading-relaxed mb-12 max-w-xl ml-auto"
          >
            حيث يلتقي عبق الماضي بأناقة الحاضر في تجربة طهي استثنائية مصممة لنخبة الذواقين.
          </motion.p>
          
          <motion.div
             initial={{ opacity: 0, scale: 0.9 }}
             animate={{ opacity: 1, scale: 1 }}
             transition={{ duration: 0.8, delay: 0.9 }}
             className="flex justify-end gap-6"
          >
             <button className="bg-brand-gold text-brand-black px-12 py-5 rounded-full font-black text-lg hover:bg-white transition-all shadow-2xl hover:scale-105 active:scale-95">
                احجز طاولتك
             </button>
             <button className="border border-white/30 text-white px-10 py-5 rounded-full font-bold text-lg backdrop-blur-sm hover:bg-white/10 transition-all">
                استكشف القائمة
             </button>
          </motion.div>
        </div>
      </div>

      {/* Vertical Decorative Bar */}
      <div className="absolute right-12 bottom-24 hidden lg:flex flex-col items-center gap-8">
        <div className="w-[1px] h-32 bg-brand-gold/50"></div>
        <span className="rotate-90 text-brand-gold tracking-[1em] text-[10px] uppercase origin-center whitespace-nowrap opacity-70">Scroll Experience</span>
      </div>
    </section>
  );
};

export default Hero;
