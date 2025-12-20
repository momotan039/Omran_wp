
import React from 'react';
import { Instagram, Twitter, Facebook, ArrowUp } from 'lucide-react';
import { APP_NAME_AR, APP_NAME_EN } from '../constants';
import { PageID } from '../types';

interface FooterProps {
  setPage: (p: PageID) => void;
}

const Footer: React.FC<FooterProps> = ({ setPage }) => {
  const scrollToTop = () => window.scrollTo({ top: 0, behavior: 'smooth' });

  const navigate = (p: PageID) => {
    setPage(p);
    scrollToTop();
  };

  return (
    <footer className="bg-brand-black text-white pt-32 pb-12 border-t border-white/5 relative">
      <div className="max-w-7xl mx-auto px-8">
        <div className="grid grid-cols-1 md:grid-cols-12 gap-16 mb-24">
          
          <div className="md:col-span-5">
            <h2 className="text-5xl font-black text-brand-gold mb-6">{APP_NAME_AR}</h2>
            <p className="text-xl text-gray-400 leading-loose max-w-md">
              حيث تتحول النكهات إلى قصص، والمكان إلى ذكرى تدوم. الجوهرة هي وجهتكم الأولى لتعريف الفخامة بمفهوم عربي أصيل.
            </p>
          </div>

          <div className="md:col-span-2">
            <h4 className="text-xs uppercase tracking-[0.3em] text-gray-500 mb-8 font-bold">الاستكشاف</h4>
            <ul className="space-y-4 text-lg">
              <li><button onClick={() => navigate('story')} className="hover:text-brand-gold transition-colors">عن الجوهرة</button></li>
              <li><button onClick={() => navigate('menu')} className="hover:text-brand-gold transition-colors">القائمة</button></li>
              <li><button onClick={() => navigate('experience')} className="hover:text-brand-gold transition-colors">التجربة</button></li>
              <li><button onClick={() => navigate('gallery')} className="hover:text-brand-gold transition-colors">المعرض</button></li>
            </ul>
          </div>

          <div className="md:col-span-2">
            <h4 className="text-xs uppercase tracking-[0.3em] text-gray-500 mb-8 font-bold">المزيد</h4>
            <ul className="space-y-4 text-lg">
              <li><button onClick={() => navigate('offers')} className="hover:text-brand-gold transition-colors">العروض</button></li>
              <li><button onClick={() => navigate('blog')} className="hover:text-brand-gold transition-colors">المجلة</button></li>
              <li><button onClick={() => navigate('events')} className="hover:text-brand-gold transition-colors">المناسبات</button></li>
              <li><button onClick={() => navigate('contact')} className="hover:text-brand-gold transition-colors">اتصل بنا</button></li>
            </ul>
          </div>

          <div className="md:col-span-3">
            <h4 className="text-xs uppercase tracking-[0.3em] text-gray-500 mb-8 font-bold">تابعنا</h4>
            <div className="flex gap-6 mb-12">
              <a href="#" className="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center hover:bg-brand-gold hover:border-brand-gold hover:text-brand-black transition-all">
                <Instagram size={24} />
              </a>
              <a href="#" className="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center hover:bg-brand-gold hover:border-brand-gold hover:text-brand-black transition-all">
                <Twitter size={24} />
              </a>
              <a href="#" className="w-14 h-14 rounded-full border border-white/10 flex items-center justify-center hover:bg-brand-gold hover:border-brand-gold hover:text-brand-black transition-all">
                <Facebook size={24} />
              </a>
            </div>
            <button 
              onClick={scrollToTop}
              className="group flex items-center gap-4 text-brand-gold font-bold uppercase tracking-widest text-xs"
            >
               <span>إلى الأعلى</span>
               <ArrowUp size={16} className="group-hover:-translate-y-1 transition-transform" />
            </button>
          </div>
        </div>

        <div className="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center text-gray-500 text-sm">
          <p dir="ltr">© {new Date().getFullYear()} {APP_NAME_EN}. All Rights Reserved.</p>
          <div className="flex gap-8 mt-6 md:mt-0">
             <button className="hover:text-white transition-colors">سياسة الخصوصية</button>
             <button className="hover:text-white transition-colors">الشروط والأحكام</button>
          </div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;
