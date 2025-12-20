import React, { useRef } from 'react';
import { X, Calendar, User, Phone, MapPin } from 'lucide-react';
import { BRANCHES } from '../constants';

const ReservationModal: React.FC = () => {
  const dialogRef = useRef<HTMLDialogElement>(null);

  const closeModal = () => {
    dialogRef.current?.close();
  };

  const handleSubmit = (e: React.FormEvent) => {
    e.preventDefault();
    alert('شكراً لك! تم استلام طلب الحجز وسيتم التأكيد قريباً.');
    closeModal();
  };

  return (
    <dialog
      id="reservation-modal"
      ref={dialogRef}
      className="bg-transparent p-0 w-full h-full max-w-full max-h-full backdrop:bg-black/80"
      onClick={(e) => {
        if (e.target === dialogRef.current) closeModal();
      }}
    >
      <div className="flex items-center justify-center min-h-screen p-4">
        <div className="bg-white w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden relative animate-fade-in-up">
          <button
            onClick={closeModal}
            className="absolute top-4 left-4 text-gray-400 hover:text-brand-black transition-colors"
          >
            <X size={24} />
          </button>

          <div className="bg-brand-black p-6 text-center">
            <h3 className="text-2xl font-bold text-brand-gold mb-1">احجز طاولتك</h3>
            <p className="text-gray-400 text-sm">نحن بانتظار خدمتك</p>
          </div>

          <form onSubmit={handleSubmit} className="p-8 space-y-5">
            {/* Branch */}
            <div className="relative">
              <label className="block text-sm font-bold text-gray-700 mb-1">الفرع</label>
              <div className="relative">
                <MapPin className="absolute right-3 top-3 text-gray-400" size={18} />
                <select className="w-full pr-10 pl-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand-gold focus:border-brand-gold outline-none bg-gray-50 text-right appearance-none" required>
                   <option value="" disabled selected>اختر الفرع</option>
                  {BRANCHES.map(b => (
                    <option key={b.id} value={b.id}>{b.nameAr}</option>
                  ))}
                </select>
              </div>
            </div>

            <div className="grid grid-cols-2 gap-4">
              {/* Date */}
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-1">التاريخ</label>
                <div className="relative">
                  <input
                    type="date"
                    className="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand-gold outline-none bg-gray-50 text-right"
                    required
                  />
                </div>
              </div>
              {/* Guests */}
              <div>
                <label className="block text-sm font-bold text-gray-700 mb-1">الضيوف</label>
                <div className="relative">
                  <User className="absolute right-3 top-3 text-gray-400" size={18} />
                  <input
                    type="number"
                    min="1"
                    max="20"
                    placeholder="2"
                    className="w-full pr-10 pl-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand-gold outline-none bg-gray-50 text-right"
                    required
                  />
                </div>
              </div>
            </div>

            {/* Name */}
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-1">الاسم</label>
              <input
                type="text"
                placeholder="اسمك الكريم"
                className="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand-gold outline-none bg-gray-50 text-right"
                required
              />
            </div>

            {/* Phone */}
            <div>
              <label className="block text-sm font-bold text-gray-700 mb-1">رقم الجوال</label>
              <div className="relative">
                <Phone className="absolute right-3 top-3 text-gray-400" size={18} />
                <input
                  type="tel"
                  placeholder="05xxxxxxxx"
                  className="w-full pr-10 pl-3 py-2 border rounded-lg focus:ring-2 focus:ring-brand-gold outline-none bg-gray-50 text-right"
                  required
                />
              </div>
            </div>

            <button
              type="submit"
              className="w-full bg-brand-gold hover:bg-brand-accent text-brand-black font-bold py-3 rounded-xl transition-all shadow-lg mt-4"
            >
              تأكيد الحجز
            </button>
          </form>
        </div>
      </div>
    </dialog>
  );
};

export default ReservationModal;
