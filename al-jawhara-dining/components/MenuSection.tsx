
import React, { useState, useMemo, useEffect } from 'react';
import { motion, AnimatePresence } from 'framer-motion';
import { MENU_ITEMS } from '../constants';
import { MenuItem } from '../types';
import { ChevronRight, ChevronLeft } from 'lucide-react';

const categories = [
  { id: 'starters', label: 'المقبلات' },
  { id: 'mains', label: 'الأطباق الرئيسية' },
  { id: 'desserts', label: 'الحلويات' },
  { id: 'drinks', label: 'المشروبات' },
];

const ITEMS_PER_PAGE = 6;

const MenuSection: React.FC = () => {
  const [activeCategory, setActiveCategory] = useState('mains');
  const [currentPage, setCurrentPage] = useState(1);

  // Reset page when category changes
  useEffect(() => {
    setCurrentPage(1);
  }, [activeCategory]);

  const filteredItems = useMemo(() => 
    MENU_ITEMS.filter(item => item.category === activeCategory),
    [activeCategory]
  );

  const totalPages = Math.ceil(filteredItems.length / ITEMS_PER_PAGE);
  
  const paginatedItems = useMemo(() => {
    const start = (currentPage - 1) * ITEMS_PER_PAGE;
    return filteredItems.slice(start, start + ITEMS_PER_PAGE);
  }, [filteredItems, currentPage]);

  const handlePageChange = (newPage: number) => {
    setCurrentPage(newPage);
    const element = document.getElementById('menu');
    if (element) {
      element.scrollIntoView({ behavior: 'smooth' });
    }
  };

  return (
    <section id="menu" className="py-20 bg-brand-black text-white relative min-h-screen">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <motion.h2 
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            viewport={{ once: true }}
            className="text-4xl md:text-6xl font-black text-brand-gold mb-4"
          >
            قائمة الطعام
          </motion.h2>
          <motion.p 
            initial={{ opacity: 0 }}
            whileInView={{ opacity: 1 }}
            viewport={{ once: true }}
            transition={{ delay: 0.2 }}
            className="text-gray-400 text-xl font-light"
          >
            مختاراتنا المميزة المحضرة بكل حب وإتقان
          </motion.p>
        </div>

        {/* Categories Navigation */}
        <div className="flex flex-wrap justify-center gap-4 mb-16">
          {categories.map((cat) => (
            <button
              key={cat.id}
              onClick={() => setActiveCategory(cat.id)}
              className={`px-8 py-3 rounded-full border transition-all duration-500 text-lg relative overflow-hidden group ${
                activeCategory === cat.id
                  ? 'bg-brand-gold text-brand-black border-brand-gold font-bold shadow-lg shadow-brand-gold/20'
                  : 'bg-transparent text-gray-400 border-white/10 hover:border-brand-gold hover:text-brand-gold'
              }`}
            >
              <span className="relative z-10">{cat.label}</span>
              {activeCategory !== cat.id && (
                <div className="absolute inset-0 bg-brand-gold scale-x-0 group-hover:scale-x-100 origin-right transition-transform duration-500 opacity-10"></div>
              )}
            </button>
          ))}
        </div>

        {/* Menu Grid Container */}
        <div className="relative min-h-[800px]">
          <AnimatePresence mode="wait">
            <motion.div
              key={`${activeCategory}-${currentPage}`}
              initial={{ opacity: 0, x: 20 }}
              animate={{ opacity: 1, x: 0 }}
              exit={{ opacity: 0, x: -20 }}
              transition={{ duration: 0.5, ease: "circOut" }}
              className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10"
            >
              {paginatedItems.map((item) => (
                <MenuCard key={item.id} item={item} />
              ))}
            </motion.div>
          </AnimatePresence>

          {paginatedItems.length === 0 && (
            <div className="text-center py-20 opacity-50">لا توجد أطباق في هذا القسم حالياً.</div>
          )}
        </div>

        {/* Luxurious Pagination */}
        {totalPages > 1 && (
          <div className="mt-24 flex justify-center items-center gap-8">
            <button
              disabled={currentPage === 1}
              onClick={() => handlePageChange(currentPage - 1)}
              className="group w-14 h-14 rounded-full border border-white/10 flex items-center justify-center transition-all hover:border-brand-gold hover:text-brand-gold disabled:opacity-20 disabled:cursor-not-allowed"
            >
              <ChevronRight size={24} className="rtl:rotate-180" />
            </button>

            <div className="flex gap-4 items-center">
              {Array.from({ length: totalPages }).map((_, idx) => {
                const pageNum = idx + 1;
                return (
                  <button
                    key={pageNum}
                    onClick={() => handlePageChange(pageNum)}
                    className={`relative w-12 h-12 flex items-center justify-center font-bold text-lg transition-all duration-500 rounded-xl ${
                      currentPage === pageNum
                        ? 'text-brand-black'
                        : 'text-gray-500 hover:text-white'
                    }`}
                  >
                    {currentPage === pageNum && (
                      <motion.div
                        layoutId="activePage"
                        className="absolute inset-0 bg-brand-gold rounded-xl -z-10 shadow-xl shadow-brand-gold/10"
                        transition={{ type: "spring", stiffness: 300, damping: 30 }}
                      />
                    )}
                    {pageNum}
                  </button>
                );
              })}
            </div>

            <button
              disabled={currentPage === totalPages}
              onClick={() => handlePageChange(currentPage + 1)}
              className="group w-14 h-14 rounded-full border border-white/10 flex items-center justify-center transition-all hover:border-brand-gold hover:text-brand-gold disabled:opacity-20 disabled:cursor-not-allowed"
            >
              <ChevronLeft size={24} className="rtl:rotate-180" />
            </button>
          </div>
        )}
      </div>
    </section>
  );
};

const MenuCard: React.FC<{ item: MenuItem }> = ({ item }) => {
  return (
    <motion.div
      layout
      className="bg-[#121212] rounded-[32px] overflow-hidden border border-white/5 group hover:border-brand-gold/30 transition-all duration-700 hover:shadow-2xl hover:shadow-brand-gold/5"
    >
      <div className="h-72 overflow-hidden relative">
        <motion.img
          whileHover={{ scale: 1.1 }}
          transition={{ duration: 0.8 }}
          src={item.image}
          alt={item.nameEn}
          className="w-full h-full object-cover grayscale-[20%] group-hover:grayscale-0"
        />
        <div className="absolute top-6 right-6 bg-brand-black/80 backdrop-blur-md text-brand-gold px-4 py-2 rounded-2xl font-black shadow-2xl border border-white/10">
          {item.price}
        </div>
        <div className="absolute inset-0 bg-gradient-to-t from-[#121212] via-transparent to-transparent opacity-60"></div>
      </div>
      
      <div className="p-8 text-right">
        <div className="flex justify-between items-start mb-4">
           <div>
              <h3 className="text-2xl font-black text-white mb-1 group-hover:text-brand-gold transition-colors duration-500">{item.nameAr}</h3>
              <p className="text-brand-gold/50 text-xs font-bold uppercase tracking-widest">{item.nameEn}</p>
           </div>
        </div>
        <p className="text-gray-400 text-sm leading-relaxed font-light line-clamp-2 h-10">
          {item.descriptionAr}
        </p>
        
        <div className="mt-8 pt-6 border-t border-white/5 flex justify-between items-center opacity-0 group-hover:opacity-100 transition-all duration-700 translate-y-2 group-hover:translate-y-0">
          <button className="text-brand-gold font-bold text-xs uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">
             <span>طلب الآن</span>
             <ChevronLeft size={14} className="rtl:rotate-180" />
          </button>
          <div className="h-1 w-12 bg-brand-gold/20 rounded-full"></div>
        </div>
      </div>
    </motion.div>
  );
};

export default MenuSection;
