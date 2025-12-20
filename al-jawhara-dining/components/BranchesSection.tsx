import React from 'react';
import { BRANCHES } from '../constants';
import { MapPin, ArrowUpLeft } from 'lucide-react';

const BranchesSection: React.FC = () => {
  return (
    <section id="branches" className="py-20 bg-brand-cream">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="mb-12 flex flex-col md:flex-row justify-between items-end gap-6">
          <div>
            <h2 className="text-4xl font-bold text-brand-black mb-2">فروعنا</h2>
            <p className="text-gray-600">نتشرف بزيارتكم في مواقعنا المميزة</p>
          </div>
          <button className="text-brand-accent font-bold flex items-center gap-2 hover:gap-3 transition-all">
            عرض كل الفروع <ArrowUpLeft size={20} className="rotate-0 rtl:rotate-0" />
          </button>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8">
          {BRANCHES.map((branch) => (
            <div key={branch.id} className="group relative rounded-2xl overflow-hidden cursor-pointer">
              <div className="aspect-[4/5] w-full">
                <img
                  src={branch.image}
                  alt={branch.nameEn}
                  className="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"
                />
              </div>
              <div className="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent flex flex-col justify-end p-6 md:p-8">
                <h3 className="text-2xl font-bold text-white mb-1">{branch.city}</h3>
                <p className="text-gray-300 mb-4">{branch.nameAr}</p>
                
                <div className="translate-y-4 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
                  <a
                    href={branch.mapLink}
                    className="inline-flex items-center gap-2 text-brand-gold font-bold hover:text-white"
                  >
                    <MapPin size={18} />
                    <span>احصل على الاتجاهات</span>
                  </a>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
};

export default BranchesSection;
