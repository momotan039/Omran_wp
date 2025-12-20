
import React, { useState, useEffect } from 'react';
import { Menu, X } from 'lucide-react';
import { APP_NAME_AR, APP_NAME_EN } from '../constants';
import { PageID } from '../types';
import { motion, AnimatePresence } from 'framer-motion';

interface NavbarProps {
  currentPage: PageID;
  setPage: (page: PageID) => void;
}

const Navbar: React.FC<NavbarProps> = ({ currentPage, setPage }) => {
  const [isScrolled, setIsScrolled] = useState(false);
  const [isMenuOpen, setIsMenuOpen] = useState(false);

  useEffect(() => {
    const handleScroll = () => setIsScrolled(window.scrollY > 40);
    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, []);

  const links: { name: string, id: PageID }[] = [
    { name: 'الرئيسية', id: 'home' },
    { name: 'القصة', id: 'story' },
    { name: 'القائمة', id: 'menu' },
    { name: 'التجربة', id: 'experience' },
    { name: 'المجلة', id: 'blog' },
  ];

  const navigate = (id: PageID) => {
    setPage(id);
    setIsMenuOpen(false);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const isDarkPage = ['experience', 'home'].includes(currentPage);
  const textColor = (isScrolled || isDarkPage) ? 'text-white' : 'text-brand-black';
  const logoColor = (isScrolled || isDarkPage) ? 'text-brand-gold' : 'text-brand-black';

  return (
    <nav className={`fixed top-0 left-0 right-0 z-50 transition-all duration-700 px-8 lg:px-12 ${
      isScrolled ? 'py-4' : 'py-10'
    }`}>
      <div className={`max-w-[1600px] mx-auto transition-all duration-700 rounded-full px-10 py-4 flex justify-between items-center ${
        isScrolled ? 'bg-brand-black/90 backdrop-blur-2xl shadow-2xl border border-white/10' : 'bg-transparent'
      }`}>
        
        {/* Desktop Links - Right */}
        <div className="hidden lg:flex items-center gap-10">
          {links.slice(0, 3).map(link => (
            <button
              key={link.id}
              onClick={() => navigate(link.id)}
              className={`text-[12px] font-black uppercase tracking-[0.2em] transition-all hover:text-brand-gold ${
                currentPage === link.id ? 'text-brand-gold' : textColor
              }`}
            >
              {link.name}
            </button>
          ))}
        </div>

        {/* Logo - Center */}
        <div 
          className="flex flex-col items-center cursor-pointer group"
          onClick={() => navigate('home')}
        >
          <h1 className={`text-4xl font-black transition-colors ${logoColor} group-hover:scale-105 transition-transform duration-500`}>
            {APP_NAME_AR}
          </h1>
          <span className={`text-[9px] tracking-[0.6em] font-light uppercase mt-1 opacity-50 ${textColor}`}>
            {APP_NAME_EN}
          </span>
        </div>

        {/* Desktop Links - Left */}
        <div className="hidden lg:flex items-center gap-10">
          {links.slice(3).map(link => (
            <button
              key={link.id}
              onClick={() => navigate(link.id)}
              className={`text-[12px] font-black uppercase tracking-[0.2em] transition-all hover:text-brand-gold ${
                currentPage === link.id ? 'text-brand-gold' : textColor
              }`}
            >
              {link.name}
            </button>
          ))}
          <button
            onClick={() => navigate('reservations')}
            className="bg-brand-gold text-brand-black px-10 py-3 rounded-full font-black text-xs uppercase tracking-widest hover:scale-105 transition-all shadow-xl shadow-brand-gold/10"
          >
            احجز الآن
          </button>
        </div>

        {/* Mobile Toggle */}
        <button className="lg:hidden" onClick={() => setIsMenuOpen(true)}>
          <Menu size={32} className={textColor} />
        </button>
      </div>

      {/* Fullscreen Mobile Menu */}
      <AnimatePresence>
        {isMenuOpen && (
          <motion.div 
            initial={{ opacity: 0, x: '100%' }}
            animate={{ opacity: 1, x: 0 }}
            exit={{ opacity: 0, x: '100%' }}
            className="fixed inset-0 bg-brand-black z-[100] flex flex-col justify-center items-center text-center p-12"
          >
            <button onClick={() => setIsMenuOpen(false)} className="absolute top-12 left-12 text-brand-gold">
               <X size={48} />
            </button>
            <div className="space-y-10">
              {links.map((link) => (
                <button 
                  key={link.id} 
                  onClick={() => navigate(link.id)} 
                  className="block text-5xl text-white font-black hover:text-brand-gold transition-colors"
                >
                  {link.name}
                </button>
              ))}
              <button 
                onClick={() => navigate('reservations')} 
                className="mt-12 bg-brand-gold text-brand-black px-16 py-6 rounded-full font-black text-2xl shadow-2xl"
              >
                احجز طاولتك
              </button>
            </div>
            <div className="mt-24 text-gray-500 font-bold tracking-[0.5em] text-xs uppercase">
              Al-Jawhara • Fine Dining
            </div>
          </motion.div>
        )}
      </AnimatePresence>
    </nav>
  );
};

export default Navbar;
