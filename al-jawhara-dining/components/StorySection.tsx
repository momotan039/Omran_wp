
import React from 'react';
import { motion } from 'framer-motion';

const StorySection: React.FC = () => {
  return (
    <section id="story" className="py-20 md:py-32 bg-brand-cream relative overflow-hidden">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          
          {/* Text Content */}
          <motion.div
            initial={{ opacity: 0, x: 50 }}
            whileInView={{ opacity: 1, x: 0 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
            className="order-2 lg:order-1 text-right"
          >
            <div className="flex items-center gap-4 mb-6">
              <span className="h-[2px] w-16 bg-brand-gold"></span>
              <h3 className="text-brand-gray uppercase tracking-widest font-bold">قصتنا</h3>
            </div>
            <h2 className="text-4xl md:text-5xl font-black text-brand-black mb-8 leading-snug">
              أكثر من مجرد مطعم،<br />
              <span className="text-brand-accent">نحن وجهة ثقافية.</span>
            </h2>
            <p className="text-brand-gray text-lg leading-loose mb-6">
              في "الجوهرة"، نؤمن بأن الطعام هو لغة الحب وكرم الضيافة. تأسسنا برؤية تهدف إلى إعادة تعريف المطبخ الشرقي، مقدمين أطباقاً تحترم الجذور وتعانق الحداثة العالمية.
            </p>
            <p className="text-brand-gray text-lg leading-loose">
              كل طبق هو سيمفونية من المذاق، وكل زاوية في فروعنا تروي حكاية من التراث العربي بتصميم عصري أنيق، لنضمن لكم ولعائلاتكم لحظات من الرفاهية والسكينة.
            </p>
          </motion.div>

          {/* Image Composition */}
          <motion.div
            initial={{ opacity: 0, scale: 0.9 }}
            whileInView={{ opacity: 1, scale: 1 }}
            viewport={{ once: true }}
            transition={{ duration: 0.8 }}
            className="order-1 lg:order-2 relative"
          >
            <div className="relative z-10 rounded-[40px] overflow-hidden luxury-shadow">
              <img
                src="https://images.unsplash.com/photo-1555396273-367ea4eb4db5?q=80&w=1200&auto=format&fit=crop"
                alt="Al-Jawhara Fine Dining Concept"
                className="w-full h-[600px] object-cover"
              />
            </div>
            {/* Abstract Decorative Element */}
            <div className="absolute -top-10 -left-10 w-64 h-64 bg-brand-gold/10 rounded-full blur-[100px] -z-0"></div>
            <div className="absolute -bottom-10 -right-10 w-80 h-80 bg-brand-accent/10 rounded-full blur-[100px] -z-0"></div>
          </motion.div>
        </div>
      </div>
    </section>
  );
};

export default StorySection;
