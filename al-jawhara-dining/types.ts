
export type PageID = 
  | 'home' | 'story' | 'experience' | 'menu' | 'signatures' 
  | 'offers' | 'branches' | 'reservations' | 'gallery' 
  | 'events' | 'blog' | 'testimonials' | 'contact'
  | 'menu-item' | 'blog-post';

export interface MenuItem {
  id: string;
  nameAr: string;
  nameEn: string;
  descriptionAr: string;
  price: string;
  category: 'starters' | 'mains' | 'desserts' | 'drinks';
  image: string;
}

export interface Branch {
  id: string;
  nameAr: string;
  nameEn: string;
  city: string;
  image: string;
  mapLink: string;
  phone: string;
  address: string;
}

export interface ChatMessage {
  id: string;
  role: 'user' | 'model';
  text: string;
  timestamp: Date;
}

export interface BlogPost {
  id: string;
  title: string;
  date: string;
  excerpt: string;
  contentAr?: string;
  image: string;
}
