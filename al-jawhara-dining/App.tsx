
import React, { useState, useMemo, useEffect } from 'react';
import { AnimatePresence, motion, Variants } from 'framer-motion';
import { PageID, MenuItem, BlogPost } from './types';
import { APP_NAME_AR, APP_NAME_EN, BRANCHES, MENU_ITEMS, BLOG_POSTS, GALLERY_IMAGES } from './constants';
import { Share2, Clock, MapPin, ChevronLeft, ChevronRight, ArrowRight, ArrowLeft, Twitter, Facebook, MessageCircle, Copy, Check } from 'lucide-react';

// Core UI Components
import Navbar from './components/Navbar';
import Footer from './components/Footer';
import AIChat from './components/AIChat';
import ReservationModal from './components/ReservationModal';

// Animated Hero
import Hero from './components/Hero';

const App: React.FC = () => {
  const [currentPage, setCurrentPage] = useState<PageID>('home');
  const [selectedItem, setSelectedItem] = useState<MenuItem | null>(null);
  const [selectedPost, setSelectedPost] = useState<BlogPost | null>(null);

  const pageVariants: Variants = {
    initial: { opacity: 0, y: 20 },
    animate: { 
      opacity: 1, 
      y: 0, 
      transition: { duration: 0.8, ease: "easeOut" } 
    },
    exit: { 
      opacity: 0, 
      y: -20, 
      transition: { duration: 0.5 } 
    }
  };

  const handleItemClick = (item: MenuItem) => {
    setSelectedItem(item);
    setCurrentPage('menu-item');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const handlePostClick = (post: BlogPost) => {
    setSelectedPost(post);
    setCurrentPage('blog-post');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  const renderPageContent = () => {
    switch (currentPage) {
      case 'home':
        return (
          <motion.div variants={pageVariants} key="home">
            <Hero />
            
            {/* Philosophical Intro */}
            <section className="py-32 bg-brand-cream relative overflow-hidden">
               <div className="absolute top-0 right-0 w-96 h-96 bg-brand-gold/5 blur-[120px] rounded-full"></div>
               <div className="max-w-7xl mx-auto px-8 grid lg:grid-cols-2 gap-24 items-center">
                  <div className="relative">
                     <div className="relative z-10 rounded-[40px] overflow-hidden luxury-shadow">
                        <img src="https://images.unsplash.com/photo-1590846406792-0adc7f938f1d?q=80&w=1000" className="w-full h-[600px] object-cover" />
                     </div>
                     <div className="absolute -bottom-10 -left-10 w-64 h-64 bg-brand-black rounded-[40px] flex items-center justify-center p-10 hidden md:flex">
                        <p className="text-brand-gold text-2xl font-black leading-tight text-center italic">
                          "الفخامة هي التفاصيل التي لا تُنسى"
                        </p>
                     </div>
                  </div>
                  <div className="text-right">
                     <span className="text-brand-gray font-bold tracking-widest mb-6 block">فلسفتنا</span>
                     <h2 className="text-5xl md:text-6xl font-black mb-10 leading-tight">نعيد صياغة <br/><span className="text-brand-gold">مفهوم الضيافة</span></h2>
                     <p className="text-xl text-brand-gray leading-loose mb-12">
                       في الجوهرة، لسنا مجرد مطعم؛ نحن صالون ثقافي يحتفي بأرقى معايير الطهي. نجمع بين أندر المكونات العالمية والوصفات المتوارثة لنقدم لك سيمفونية من المذاق الفريد.
                     </p>
                     <button onClick={() => setCurrentPage('story')} className="group flex items-center gap-6 text-xl font-black transition-all hover:gap-10">
                        <span>اكتشف قصتنا</span>
                        <div className="w-16 h-16 rounded-full border border-brand-black flex items-center justify-center group-hover:bg-brand-black group-hover:text-white transition-all">←</div>
                     </button>
                  </div>
               </div>
            </section>

            <HomeSignatureCarousel setPage={setCurrentPage} onItemClick={handleItemClick} />
          </motion.div>
        );
      
      case 'menu':
        return <MenuPage key="menu" onItemClick={handleItemClick} />;
      
      case 'menu-item':
        return selectedItem ? <MenuItemDetail key="menu-item" item={selectedItem} setPage={setCurrentPage} onItemClick={handleItemClick} /> : null;

      case 'blog':
        return <BlogPage key="blog" onPostClick={handlePostClick} />;
      
      case 'blog-post':
        return selectedPost ? <BlogPostDetail key="blog-post" post={selectedPost} setPage={setCurrentPage} /> : null;

      case 'experience':
        return <ExperiencePage key="experience" />;

      case 'reservations':
        return <ReservationPage key="reservations" />;

      case 'story':
        return (
          <motion.div variants={pageVariants} key="story" className="pt-40 pb-20 bg-brand-cream min-h-screen">
             <div className="max-w-4xl mx-auto px-8 text-center">
                <h1 className="text-7xl font-black mb-12">القصة والمنشأ</h1>
                <div className="aspect-video rounded-[50px] overflow-hidden mb-16 luxury-shadow">
                   <img src="https://images.unsplash.com/photo-1550966841-3ee7adac169a?q=80&w=1200&auto=format&fit=crop" className="w-full h-full object-cover" />
                </div>
                <p className="text-2xl text-brand-gray leading-relaxed mb-10">بدأت الجوهرة كحلم لجمع شتات المطبخ العربي في قالب عالمي أنيق. كل حجر في مطاعمنا، وكل نكهة في قائمة طعامنا، تم اختيارها لتكون جزءاً من هذا الإرث.</p>
             </div>
          </motion.div>
        );

      default:
        return (
          <motion.div variants={pageVariants} key="default" className="pt-40 h-screen flex items-center justify-center">
            <h1 className="text-3xl font-bold opacity-20 uppercase tracking-[1em]">Coming Soon</h1>
          </motion.div>
        );
    }
  };

  return (
    <div className="font-sans antialiased text-brand-black bg-brand-cream min-h-screen relative overflow-x-hidden">
      <Navbar currentPage={currentPage} setPage={setCurrentPage} />
      
      <main>
        <AnimatePresence mode="wait">
          {renderPageContent()}
        </AnimatePresence>
      </main>

      <Footer setPage={setCurrentPage} />
      <AIChat />
      <ReservationModal />
    </div>
  );
};

/** SHARE COMPONENT **/
const ShareOptions: React.FC<{ title: string; url: string }> = ({ title, url }) => {
  const [copied, setCopied] = useState(false);
  const [show, setShow] = useState(false);

  const handleCopy = () => {
    navigator.clipboard.writeText(url);
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  const shareLinks = [
    { name: 'واتساب', icon: <MessageCircle size={20} />, color: 'bg-[#25D366]', link: `https://wa.me/?text=${encodeURIComponent(title + ' ' + url)}` },
    { name: 'تويتر', icon: <Twitter size={20} />, color: 'bg-black', link: `https://twitter.com/intent/tweet?text=${encodeURIComponent(title)}&url=${encodeURIComponent(url)}` },
    { name: 'فيسبوك', icon: <Facebook size={20} />, color: 'bg-[#1877F2]', link: `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}` },
  ];

  return (
    <div className="relative inline-block w-full">
      <button 
        onClick={() => setShow(!show)}
        className="flex items-center justify-center gap-4 border-2 border-brand-black py-6 px-10 rounded-3xl font-black hover:bg-brand-black hover:text-white transition-all w-full"
      >
        <Share2 size={24} />
        <span>مشاركة</span>
      </button>

      <AnimatePresence>
        {show && (
          <>
            <motion.div 
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => setShow(false)}
              className="fixed inset-0 z-50 bg-black/5"
            />
            <motion.div 
              initial={{ opacity: 0, y: 10, scale: 0.95 }}
              animate={{ opacity: 1, y: 0, scale: 1 }}
              exit={{ opacity: 0, y: 10, scale: 0.95 }}
              className="absolute bottom-full mb-4 right-0 w-64 bg-white rounded-[30px] luxury-shadow p-6 z-[60] border border-gray-100"
            >
              <div className="grid grid-cols-1 gap-4">
                {shareLinks.map((s) => (
                  <a 
                    key={s.name} 
                    href={s.link} 
                    target="_blank" 
                    rel="noopener noreferrer"
                    className="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors group"
                  >
                    <div className={`${s.color} text-white p-2 rounded-xl`}>{s.icon}</div>
                    <span className="font-bold text-brand-black group-hover:text-brand-gold transition-colors">{s.name}</span>
                  </a>
                ))}
                <button 
                  onClick={handleCopy}
                  className="flex items-center gap-4 p-3 rounded-2xl hover:bg-gray-50 transition-colors group w-full text-right"
                >
                  <div className="bg-gray-200 text-brand-black p-2 rounded-xl">
                    {copied ? <Check size={20} className="text-green-600" /> : <Copy size={20} />}
                  </div>
                  <span className="font-bold text-brand-black group-hover:text-brand-gold transition-colors">
                    {copied ? 'تم النسخ!' : 'نسخ الرابط'}
                  </span>
                </button>
              </div>
              <div className="absolute -bottom-2 right-10 w-4 h-4 bg-white rotate-45 border-r border-b border-gray-100"></div>
            </motion.div>
          </>
        )}
      </AnimatePresence>
    </div>
  );
};

/** SUB-COMPONENTS **/

const HomeSignatureCarousel: React.FC<{ setPage: (p: PageID) => void, onItemClick: (item: MenuItem) => void }> = ({ setPage, onItemClick }) => (
  <section className="py-32 bg-brand-black text-white relative">
    <div className="max-w-7xl mx-auto px-8">
      <div className="flex justify-between items-end mb-20">
        <div>
           <h4 className="text-brand-gold font-bold tracking-widest uppercase mb-4">Chef's Selection</h4>
           <h2 className="text-5xl font-black">مختارات النخبة</h2>
        </div>
        <button onClick={() => setPage('menu')} className="text-brand-gold hover:text-white font-black text-lg underline decoration-brand-gold underline-offset-8 transition-all">
           قائمة الطعام كاملة
        </button>
      </div>
      <div className="grid md:grid-cols-2 gap-12">
        {MENU_ITEMS.slice(0, 2).map((item) => (
          <div key={item.id} className="group relative rounded-[40px] overflow-hidden cursor-pointer h-[500px]" onClick={() => onItemClick(item)}>
             <img src={item.image} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" />
             <div className="absolute inset-0 bg-gradient-to-t from-brand-black via-brand-black/20 to-transparent"></div>
             <div className="absolute bottom-12 right-12 left-12 text-right">
                <h3 className="text-4xl font-black mb-4 group-hover:text-brand-gold transition-colors">{item.nameAr}</h3>
                <p className="text-gray-400 text-lg leading-relaxed line-clamp-2">{item.descriptionAr}</p>
             </div>
          </div>
        ))}
      </div>
    </div>
  </section>
);

const ITEMS_PER_PAGE = 6;
const categories = [
  { id: 'all', label: 'الكل' },
  { id: 'starters', label: 'المقبلات' },
  { id: 'mains', label: 'الأطباق الرئيسية' },
  { id: 'desserts', label: 'الحلويات' },
  { id: 'drinks', label: 'المشروبات' },
];

const MenuPage: React.FC<{ onItemClick: (item: MenuItem) => void }> = ({ onItemClick }) => {
  const [activeCategory, setActiveCategory] = useState('all');
  const [currentPageNum, setCurrentPageNum] = useState(1);

  // Reset page on category change
  useEffect(() => {
    setCurrentPageNum(1);
  }, [activeCategory]);

  const filteredItems = useMemo(() => {
    if (activeCategory === 'all') return MENU_ITEMS;
    return MENU_ITEMS.filter(item => item.category === activeCategory);
  }, [activeCategory]);

  const totalPages = Math.ceil(filteredItems.length / ITEMS_PER_PAGE);
  
  const currentItems = useMemo(() => {
    const start = (currentPageNum - 1) * ITEMS_PER_PAGE;
    return filteredItems.slice(start, start + ITEMS_PER_PAGE);
  }, [filteredItems, currentPageNum]);

  const handlePageChange = (n: number) => {
    setCurrentPageNum(n);
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };

  return (
    <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} className="pt-40 pb-20 bg-brand-cream min-h-screen">
       <div className="max-w-7xl mx-auto px-8">
          <div className="text-center mb-16">
             <h1 className="text-7xl font-black mb-6">قائمة الطعام</h1>
             <p className="text-brand-gray text-xl max-w-2xl mx-auto mb-12">كل طبق هو رحلة عبر الزمن، محضرة بأفضل المكونات الموسمية والتقنيات العصرية.</p>
             
             {/* Category Selector */}
             <div className="flex flex-wrap justify-center gap-4">
                {categories.map((cat) => (
                  <button
                    key={cat.id}
                    onClick={() => setActiveCategory(cat.id)}
                    className={`px-10 py-4 rounded-full font-black text-lg transition-all duration-500 border ${
                      activeCategory === cat.id 
                        ? 'bg-brand-black text-brand-gold border-brand-black scale-105 shadow-xl' 
                        : 'bg-white text-brand-gray border-gray-100 hover:border-brand-gold'
                    }`}
                  >
                    {cat.label}
                  </button>
                ))}
             </div>
          </div>

          <div className="relative min-h-[600px]">
            <AnimatePresence mode="wait">
              <motion.div 
                key={`${activeCategory}-${currentPageNum}`}
                initial={{ opacity: 0, x: 20 }}
                animate={{ opacity: 1, x: 0 }}
                exit={{ opacity: 0, x: -20 }}
                transition={{ duration: 0.5 }}
                className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10"
              >
                {currentItems.map(item => (
                  <div 
                    key={item.id} 
                    onClick={() => onItemClick(item)}
                    className="bg-white p-8 rounded-[40px] luxury-shadow group hover:-translate-y-2 transition-transform duration-500 cursor-pointer"
                  >
                      <div className="rounded-[30px] overflow-hidden h-64 mb-8">
                        <img src={item.image} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" alt={item.nameAr} />
                      </div>
                      <div className="flex justify-between items-start mb-4">
                        <h3 className="text-2xl font-black group-hover:text-brand-gold transition-colors">{item.nameAr}</h3>
                        <span className="text-brand-gold font-bold text-xl">{item.price}</span>
                      </div>
                      <p className="text-brand-gray leading-relaxed line-clamp-2">{item.descriptionAr}</p>
                  </div>
                ))}
              </motion.div>
            </AnimatePresence>
          </div>

          {/* Premium Pagination Controls */}
          {totalPages > 1 && (
            <div className="mt-24 flex justify-center items-center gap-6">
              <button 
                disabled={currentPageNum === 1}
                onClick={() => handlePageChange(currentPageNum - 1)}
                className="w-16 h-16 rounded-full border border-gray-200 flex items-center justify-center hover:bg-brand-black hover:text-brand-gold hover:border-brand-black transition-all disabled:opacity-20 disabled:cursor-not-allowed group"
              >
                <ChevronRight size={28} className="rtl:rotate-0" />
              </button>

              <div className="flex gap-4 p-2 bg-white rounded-[24px] luxury-shadow border border-gray-100">
                {Array.from({ length: totalPages }).map((_, i) => {
                  const p = i + 1;
                  const isActive = currentPageNum === p;
                  return (
                    <button
                      key={p}
                      onClick={() => handlePageChange(p)}
                      className={`relative w-14 h-14 flex items-center justify-center font-black text-xl transition-all duration-500 z-10 ${
                        isActive ? 'text-white' : 'text-brand-gray hover:text-brand-black'
                      }`}
                    >
                      {isActive && (
                        <motion.div 
                          layoutId="active-pill"
                          className="absolute inset-0 bg-brand-black rounded-2xl -z-10"
                          transition={{ type: "spring", stiffness: 300, damping: 30 }}
                        />
                      )}
                      {p}
                    </button>
                  );
                })}
              </div>

              <button 
                disabled={currentPageNum === totalPages}
                onClick={() => handlePageChange(currentPageNum + 1)}
                className="w-16 h-16 rounded-full border border-gray-200 flex items-center justify-center hover:bg-brand-black hover:text-brand-gold hover:border-brand-black transition-all disabled:opacity-20 disabled:cursor-not-allowed group"
              >
                <ChevronLeft size={28} className="rtl:rotate-0" />
              </button>
            </div>
          )}
       </div>
    </motion.div>
  );
};

const MenuItemDetail: React.FC<{ item: MenuItem, setPage: (p: PageID) => void, onItemClick: (item: MenuItem) => void }> = ({ item, setPage, onItemClick }) => {
  return (
    <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} className="pt-32 pb-20 bg-brand-cream min-h-screen">
      <div className="max-w-7xl mx-auto px-8">
        <button onClick={() => setPage('menu')} className="flex items-center gap-2 text-brand-gray hover:text-brand-gold font-bold mb-12 transition-colors">
          <ChevronLeft className="rtl:rotate-180" />
          <span>العودة للقائمة</span>
        </button>
        
        <div className="grid lg:grid-cols-2 gap-20 items-start">
          <motion.div 
            initial={{ opacity: 0, x: -50 }}
            animate={{ opacity: 1, x: 0 }}
            className="sticky top-40 rounded-[50px] overflow-hidden luxury-shadow aspect-square lg:aspect-auto lg:h-[700px]"
          >
            <img src={item.image} className="w-full h-full object-cover" />
          </motion.div>
          
          <motion.div 
            initial={{ opacity: 0, x: 50 }}
            animate={{ opacity: 1, x: 0 }}
            className="text-right"
          >
            <span className="bg-brand-gold/10 text-brand-gold px-6 py-2 rounded-full font-bold text-sm uppercase tracking-widest mb-6 inline-block">
              {item.category === 'mains' ? 'طبق رئيسي' : item.category === 'desserts' ? 'حلويات' : 'صنف مميز'}
            </span>
            <h1 className="text-6xl font-black mb-4">{item.nameAr}</h1>
            <h2 className="text-2xl text-brand-gold font-light tracking-widest mb-8 opacity-60 uppercase">{item.nameEn}</h2>
            <div className="text-4xl font-black text-brand-black mb-12 border-b border-brand-black/10 pb-8">{item.price}</div>
            
            <div className="space-y-12">
              <div>
                <h3 className="text-xl font-black mb-4 border-r-4 border-brand-gold pr-4">وصف الطبق</h3>
                <p className="text-xl text-brand-gray leading-loose">{item.descriptionAr}</p>
              </div>
              
              <div className="grid grid-cols-2 gap-8">
                <div className="bg-white p-8 rounded-[30px] luxury-shadow">
                  <h4 className="font-bold text-brand-gold mb-2 text-sm uppercase tracking-widest">توصية الشيف</h4>
                  <p className="text-brand-gray">يُفضل تناوله في أجواء الجوهرة الهادئة مع التوابل الخاصة.</p>
                </div>
                <div className="bg-white p-8 rounded-[30px] luxury-shadow">
                  <h4 className="font-bold text-brand-gold mb-2 text-sm uppercase tracking-widest">المكونات</h4>
                  <p className="text-brand-gray">مكونات عضوية مختارة من أجود المزارع المحلية والعالمية.</p>
                </div>
              </div>
              
              <div className="pt-10 flex flex-col sm:flex-row gap-6">
                <button onClick={() => setPage('reservations')} className="flex-1 bg-brand-black text-white py-6 rounded-3xl font-black text-2xl hover:bg-brand-gold hover:text-brand-black transition-all shadow-xl">
                  احجز طاولتك الآن
                </button>
                <ShareOptions title={item.nameAr} url={window.location.href} />
              </div>
            </div>
          </motion.div>
        </div>
        
        {/* Similar Items */}
        <div className="mt-40">
           <h2 className="text-4xl font-black mb-12 text-center">أطباق قد تعجبك</h2>
           <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
              {MENU_ITEMS.filter(i => i.id !== item.id && i.category === item.category).slice(0, 4).map(similar => (
                <div key={similar.id} onClick={() => { onItemClick(similar); window.scrollTo(0,0); }} className="cursor-pointer group">
                  <div className="rounded-[30px] overflow-hidden aspect-square mb-6">
                    <img src={similar.image} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700" />
                  </div>
                  <h3 className="text-xl font-bold text-center group-hover:text-brand-gold transition-colors">{similar.nameAr}</h3>
                </div>
              ))}
           </div>
        </div>
      </div>
    </motion.div>
  );
};

const BlogPage: React.FC<{ onPostClick: (post: BlogPost) => void }> = ({ onPostClick }) => (
   <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} className="pt-40 pb-20 bg-brand-cream min-h-screen">
      <div className="max-w-7xl mx-auto px-8">
         <h1 className="text-7xl font-black text-center mb-24">المجلة والنمط الغذائي</h1>
         <div className="grid grid-cols-1 md:grid-cols-2 gap-16">
            {BLOG_POSTS.map(post => (
              <div 
                key={post.id} 
                onClick={() => onPostClick(post)}
                className="flex flex-col gap-8 group cursor-pointer"
              >
                 <div className="rounded-[50px] overflow-hidden h-[450px] luxury-shadow">
                    <img src={post.image} className="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000" />
                 </div>
                 <div className="text-right">
                    <span className="text-brand-gold font-bold uppercase tracking-widest text-sm mb-4 block">{post.date}</span>
                    <h3 className="text-4xl font-black mb-6 group-hover:text-brand-gold transition-colors">{post.title}</h3>
                    <p className="text-xl text-brand-gray leading-relaxed mb-8 line-clamp-3">{post.excerpt}</p>
                    <button className="font-black text-lg border-b-2 border-brand-black pb-1 hover:border-brand-gold transition-all">اقرأ المقال</button>
                 </div>
              </div>
            ))}
         </div>
      </div>
   </motion.div>
);

const BlogPostDetail: React.FC<{ post: BlogPost, setPage: (p: PageID) => void }> = ({ post, setPage }) => {
  const [copied, setCopied] = useState(false);
  const handleCopy = () => {
    navigator.clipboard.writeText(window.location.href);
    setCopied(true);
    setTimeout(() => setCopied(false), 2000);
  };

  return (
    <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} className="bg-brand-cream min-h-screen">
      <div className="relative h-[70vh] w-full">
        <img src={post.image} className="w-full h-full object-cover" />
        <div className="absolute inset-0 bg-gradient-to-t from-brand-cream to-transparent" />
        <div className="absolute top-40 left-8">
           <button onClick={() => setPage('blog')} className="bg-white/90 backdrop-blur-md p-4 rounded-full luxury-shadow hover:scale-110 transition-all text-brand-black">
              <ArrowLeft size={32} />
           </button>
        </div>
      </div>
      
      <div className="max-w-4xl mx-auto px-8 -mt-32 relative z-10 pb-40">
        <div className="bg-white p-16 rounded-[60px] luxury-shadow text-right">
           <div className="flex justify-between items-center mb-10">
              <div className="flex gap-4 text-brand-gray text-sm">
                 <span className="flex items-center gap-2"><Clock size={16} /> ٥ دقائق قراءة</span>
                 <button onClick={handleCopy} className="flex items-center gap-2 hover:text-brand-gold transition-colors">
                    {copied ? <Check size={16} className="text-green-600" /> : <Share2 size={16} />} 
                    {copied ? 'تم النسخ!' : 'مشاركة'}
                 </button>
              </div>
              <span className="text-brand-gold font-bold uppercase tracking-widest">{post.date}</span>
           </div>
           
           <h1 className="text-5xl md:text-6xl font-black mb-12 leading-tight">{post.title}</h1>
           
           <div className="prose prose-xl prose-brand max-w-none">
              <p className="text-2xl text-brand-gray leading-relaxed mb-12 font-light italic border-r-4 border-brand-gold pr-8">
                {post.excerpt}
              </p>
              
              <div className="text-xl text-brand-gray leading-[2] whitespace-pre-wrap">
                {post.contentAr}
              </div>
           </div>
           
           <div className="mt-20 pt-10 border-t border-gray-100 flex justify-between items-center">
              <div className="flex gap-4">
                 <a href={`https://wa.me/?text=${encodeURIComponent(post.title + ' ' + window.location.href)}`} target="_blank" rel="noopener" className="w-12 h-12 bg-brand-black rounded-full flex items-center justify-center text-brand-gold hover:bg-[#25D366] hover:text-white transition-colors cursor-pointer"><MessageCircle size={20}/></a>
                 <a href={`https://twitter.com/intent/tweet?text=${encodeURIComponent(post.title)}&url=${encodeURIComponent(window.location.href)}`} target="_blank" rel="noopener" className="w-12 h-12 bg-brand-black rounded-full flex items-center justify-center text-brand-gold hover:bg-black hover:text-white transition-colors cursor-pointer"><Twitter size={20}/></a>
                 <div onClick={handleCopy} className="w-12 h-12 bg-brand-black rounded-full flex items-center justify-center text-brand-gold hover:bg-brand-gold hover:text-brand-black transition-colors cursor-pointer">
                    {copied ? <Check size={20} /> : <Copy size={20}/>}
                 </div>
              </div>
              <div className="text-right">
                 <p className="text-xs text-brand-gray uppercase tracking-widest mb-1">الكاتب</p>
                 <p className="font-black text-lg">فريق تحرير الجوهرة</p>
              </div>
           </div>
        </div>
        
        {/* Next Post Preview */}
        <div className="mt-24 bg-brand-black text-white p-12 rounded-[50px] luxury-shadow flex justify-between items-center cursor-pointer hover:bg-brand-gold hover:text-brand-black transition-all group">
           <div className="flex items-center gap-6">
              <ArrowLeft className="group-hover:-translate-x-2 transition-transform" size={40} />
              <div>
                 <p className="text-xs uppercase tracking-[0.3em] opacity-50 mb-1">المقال التالي</p>
                 <h4 className="text-2xl font-bold">فن الضيافة العربية</h4>
              </div>
           </div>
           <div className="hidden md:block h-20 w-32 rounded-2xl overflow-hidden">
              <img src={BLOG_POSTS[1].image} className="w-full h-full object-cover" />
           </div>
        </div>
      </div>
    </motion.div>
  );
};

const ExperiencePage: React.FC = () => (
  <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} className="bg-brand-black min-h-screen text-white pt-40 relative">
     <div className="absolute inset-0 opacity-30">
        <img src="https://images.unsplash.com/photo-1550966841-3ee7adac169a?q=80&w=1920" className="w-full h-full object-cover grayscale" />
     </div>
     <div className="relative z-10 max-w-5xl mx-auto px-8 text-center">
        <h1 className="text-8xl font-black text-brand-gold mb-12">فن الأجواء</h1>
        <p className="text-3xl font-light leading-relaxed mb-20 italic">"نحن لا نقدم الطعام فقط، بل نصمم الذكريات."</p>
        <div className="grid md:grid-cols-2 gap-16">
           <div className="text-right space-y-10">
              <h3 className="text-4xl font-bold border-r-4 border-brand-gold pr-6">الإضاءة والموسيقى</h3>
              <p className="text-gray-400 text-xl leading-loose">تم تصميم إضاءة الجوهرة لتعكس فخامة الأحجار الكريمة، مع سيمفونيات موسيقية هادئة مختارة بعناية لتناسب أرقى الأذواق.</p>
           </div>
           <div className="text-right space-y-10">
              <h3 className="text-4xl font-bold border-r-4 border-brand-gold pr-6">الخدمة الفندقية</h3>
              <p className="text-gray-400 text-xl leading-loose">فريقنا مدرب على أعلى معايير الضيافة العالمية، ليضمن لك خصوصية تامة واهتماماً بأدق التفاصيل الشخصية.</p>
           </div>
        </div>
     </div>
  </motion.div>
);

const ReservationPage: React.FC = () => (
   <motion.div initial={{ opacity: 0 }} animate={{ opacity: 1 }} className="pt-40 pb-20 bg-brand-cream min-h-screen flex items-center justify-center px-8">
      <div className="max-w-5xl w-full bg-white rounded-[60px] luxury-shadow overflow-hidden flex flex-col md:flex-row">
         <div className="md:w-5/12 bg-brand-black text-white p-16 flex flex-col justify-center text-right">
            <h2 className="text-5xl font-black text-brand-gold mb-8">دعنا نستقبلك</h2>
            <p className="text-gray-400 text-xl leading-loose mb-12">اختر الوقت والفرع المناسب لك، وسيقوم فريق "الجوهرة" بتجهيز كل شيء لتكون أمسيتك مثالية.</p>
            <div className="space-y-4 text-sm text-gray-500">
               <p>• الحجز متاح للعائلات والأفراد</p>
               <p>• يتوفر ركن خاص للمناسبات</p>
            </div>
         </div>
         <div className="md:w-7/12 p-16">
            <div className="space-y-10">
               <div className="grid grid-cols-2 gap-8">
                  <div className="flex flex-col">
                     <label className="text-xs uppercase tracking-widest font-bold mb-3 text-brand-gray">التاريخ</label>
                     <input type="date" className="border-b-2 py-3 outline-none focus:border-brand-gold bg-transparent text-right" />
                  </div>
                  <div className="flex flex-col">
                     <label className="text-xs uppercase tracking-widest font-bold mb-3 text-brand-gray">الوقت</label>
                     <input type="time" className="border-b-2 py-3 outline-none focus:border-brand-gold bg-transparent text-right" />
                  </div>
               </div>
               <div className="flex flex-col">
                  <label className="text-xs uppercase tracking-widest font-bold mb-3 text-brand-gray">الفرع</label>
                  <select className="border-b-2 py-3 outline-none focus:border-brand-gold bg-transparent text-right appearance-none">
                     <option>الرياض - شارع التحلية</option>
                     <option>جدة - الكورنيش</option>
                     <option>دبي - داون تاون</option>
                  </select>
               </div>
               <div className="flex flex-col">
                  <label className="text-xs uppercase tracking-widest font-bold mb-3 text-brand-gray">عدد الضيوف</label>
                  <input type="number" min="1" placeholder="مثلاً: 4" className="border-b-2 py-3 outline-none focus:border-brand-gold bg-transparent text-right" />
               </div>
               <button className="w-full bg-brand-black text-white py-6 rounded-3xl font-black text-2xl hover:bg-brand-gold transition-all mt-6 shadow-xl active:scale-95">
                  تأكيد الحجز
               </button>
            </div>
         </div>
      </div>
   </motion.div>
);

export default App;
