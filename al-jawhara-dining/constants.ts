
import { Branch, MenuItem, BlogPost } from './types';

export const APP_NAME_AR = "الجوهرة";
export const APP_NAME_EN = "Al-Jawhara";

export const BRANCHES: Branch[] = [
  {
    id: 'riyadh-main',
    nameAr: 'الرياض - شارع التحلية',
    nameEn: 'Riyadh - Tahlia St.',
    city: 'الرياض',
    image: 'https://images.unsplash.com/photo-1590846406792-0adc7f938f1d?q=80&w=1200&auto=format&fit=crop',
    mapLink: '#',
    phone: '011-234-5678',
    address: 'حي السليمانية، الرياض'
  },
  {
    id: 'jeddah-corniche',
    nameAr: 'جدة - الكورنيش',
    nameEn: 'Jeddah - Corniche',
    city: 'جدة',
    image: 'https://images.unsplash.com/photo-1559339352-11d035aa65de?q=80&w=1200&auto=format&fit=crop',
    mapLink: '#',
    phone: '012-345-6789',
    address: 'طريق الكورنيش، جدة'
  },
  {
    id: 'dubai-downtown',
    nameAr: 'دبي - داون تاون',
    nameEn: 'Dubai - Downtown',
    city: 'دبي',
    image: 'https://images.unsplash.com/photo-1581347141528-768f5c381c8b?q=80&w=1200&auto=format&fit=crop',
    mapLink: '#',
    phone: '+971-4-567-8901',
    address: 'بوليفارد الشيخ محمد، دبي'
  }
];

export const MENU_ITEMS: MenuItem[] = [
  // STARTERS
  {
    id: '1',
    nameAr: 'حمص بالكمأ',
    nameEn: 'Truffle Hummus',
    descriptionAr: 'حمص كريمي محضر يدوياً مع زيت الكمأ الأسود والصنوبر المحمص والذهب الصالح للأكل.',
    price: '٧٥ ر.س',
    category: 'starters',
    image: 'https://images.unsplash.com/photo-1541518763669-27fef04b14ea?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 's2',
    nameAr: 'كبة الجوهرة الخاصة',
    nameEn: 'Al-Jawhara Kibbeh',
    descriptionAr: 'كبة مقلية محشوة باللحم والمكسرات الفاخرة مع دبس الرمان.',
    price: '٦٠ ر.س',
    category: 'starters',
    image: 'https://images.unsplash.com/photo-1547048203-d2503d420658?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 's3',
    nameAr: 'فتوش ملكي',
    nameEn: 'Royal Fattoush',
    descriptionAr: 'خضروات طازجة مع خبز محمص بالأعشاب وصوص السماق والرمان.',
    price: '٥٠ ر.س',
    category: 'starters',
    image: 'https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 's4',
    nameAr: 'ورق عنب بالزيت',
    nameEn: 'Stuffed Vine Leaves',
    descriptionAr: 'ورق عنب محشو بالأرز والأعشاب الطازجة مع لمسة من الليمون وزيت الزيتون.',
    price: '٥٥ ر.س',
    category: 'starters',
    image: 'https://images.unsplash.com/photo-1610192244261-3f33de3f55e4?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 's5',
    nameAr: 'بابا غنوج مدخن',
    nameEn: 'Smoked Baba Ghanoush',
    descriptionAr: 'باذنجان مشوي على الفحم مع الطحينة وزيت الزيتون البكر.',
    price: '٤٥ ر.س',
    category: 'starters',
    image: 'https://images.unsplash.com/photo-1593001874117-c99c800e3eb7?q=80&w=800&auto=format&fit=crop'
  },

  // MAINS
  {
    id: '2',
    nameAr: 'كباب الكرز الملوكي',
    nameEn: 'Royal Cherry Kebab',
    descriptionAr: 'لحم ضأن مفروم متبل بصوص الكرز البري الحلو والحامض، يُقدم على خبز محمص.',
    price: '١٤٥ ر.س',
    category: 'mains',
    image: 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: '3',
    nameAr: 'اوزي لحم فاخر',
    nameEn: 'Premium Lamb Ouzi',
    descriptionAr: 'كتف لحم ضأن مطهو ببطء لمدة ١٢ ساعة يقدم مع الأرز الشرقي والمكسرات الفاخرة.',
    price: '٢٢٠ ر.س',
    category: 'mains',
    image: 'https://images.unsplash.com/photo-1596797038530-2c107229654b?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'm3',
    nameAr: 'منسف أردني أصيل',
    nameEn: 'Authentic Mansaf',
    descriptionAr: 'لحم بلدي مطهو بجميد كركي أصيل يقدم على خبز الشراك والأرز باللوز.',
    price: '١٨٠ ر.س',
    category: 'mains',
    image: 'https://images.unsplash.com/photo-1541518763669-27fef04b14ea?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'm4',
    nameAr: 'صيادية سمك فاخرة',
    nameEn: 'Luxury Sayadieh',
    descriptionAr: 'سمك طازج مع الأرز البني المحضر ببهاراتنا الخاصة والبصل المقرمش.',
    price: '١٦٠ ر.س',
    category: 'mains',
    image: 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'm5',
    nameAr: 'مشاوي مشكلة مدخنة',
    nameEn: 'Smoked Mixed Grill',
    descriptionAr: 'تشكيلة من الشيش طاووق، الريش، والكباب المشوي على الفحم الطبيعي.',
    price: '١٩٠ ر.س',
    category: 'mains',
    image: 'https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'm6',
    nameAr: 'ريش غنم بالزعتر',
    nameEn: 'Lamb Chops with Zaatar',
    descriptionAr: 'ريش غنم طرية متبلة بالزعتر البري وزيت الزيتون تقدم مع الخضار المشوية.',
    price: '١٧٥ ر.س',
    category: 'mains',
    image: 'https://images.unsplash.com/photo-1603048588665-791ca8aea617?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'm7',
    nameAr: 'مقلوبة دجاج بيتي',
    nameEn: 'Home-style Maqluba',
    descriptionAr: 'دجاج مطهو مع الباذنجان والزهرة والأرز، يقلب ليقدم لوحة فنية شهية.',
    price: '١٣٠ ر.س',
    category: 'mains',
    image: 'https://images.unsplash.com/photo-1626700051175-656fc7cd30be?q=80&w=800&auto=format&fit=crop'
  },

  // DESSERTS
  {
    id: '4',
    nameAr: 'بقلاوة بالفستق الحلبي',
    nameEn: 'Pistachio Baklava',
    descriptionAr: 'رقائق البقلاوة الهشة محشوة بالفستق الحلبي الفاخر وتقدم مع آيس كريم المستكة.',
    price: '٦٥ ر.س',
    category: 'desserts',
    image: 'https://images.unsplash.com/photo-1519676867240-f031ee04a703?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'd2',
    nameAr: 'كنافة نابلسية بالجبن',
    nameEn: 'Cheese Kunafa',
    descriptionAr: 'كنافة ساخنة بجبنة عكاوي ذائبة مغطاة بالفستق الحلبي والقطر الساخن.',
    price: '٧٠ ر.س',
    category: 'desserts',
    image: 'https://images.unsplash.com/photo-1517433670267-08bbd4be890f?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'd3',
    nameAr: 'أم علي بالقشطة',
    nameEn: 'Um Ali with Cream',
    descriptionAr: 'رقائق العجين مع الحليب الساخن والمكسرات والقشطة الطازجة.',
    price: '٥٥ ر.س',
    category: 'desserts',
    image: 'https://images.unsplash.com/photo-1579372781848-22822205bb67?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'd4',
    nameAr: 'أرز بالحليب والورد',
    nameEn: 'Rose Rice Pudding',
    descriptionAr: 'أرز بالحليب كريمي مع ماء الورد الطبيعي وبتلات الورد المجفف.',
    price: '٤٥ ر.س',
    category: 'desserts',
    image: 'https://images.unsplash.com/photo-1544333323-5d73b4003df0?q=80&w=800&auto=format&fit=crop'
  },

  // DRINKS
  {
    id: 'dr1',
    nameAr: 'ليمون بالنعناع منعش',
    nameEn: 'Mint Lemonade',
    descriptionAr: 'عصير الليمون الطازج مع أوراق النعناع المقطوفة يدوياً والثلج المجروش.',
    price: '٣٥ ر.س',
    category: 'drinks',
    image: 'https://images.unsplash.com/photo-1513558161293-cdaf765ed2fd?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'dr2',
    nameAr: 'قهوة سعودية أصيلة',
    nameEn: 'Authentic Saudi Coffee',
    descriptionAr: 'قهوة شقراء محمصة بعناية مع الهيل الفاخر والزعفران، تقدم مع التمر السكري.',
    price: '٤٠ ر.س',
    category: 'drinks',
    image: 'https://images.unsplash.com/photo-1574513149524-766f5c381c8b?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'dr3',
    nameAr: 'شاي مغربي ملكي',
    nameEn: 'Royal Moroccan Tea',
    descriptionAr: 'شاي أخضر بالنعناع المغربي الأصيل يحضر بالطريقة التقليدية.',
    price: '٣٠ ر.س',
    category: 'drinks',
    image: 'https://images.unsplash.com/photo-1576092768241-dec231879fc3?q=80&w=800&auto=format&fit=crop'
  },
  {
    id: 'dr4',
    nameAr: 'عصير رمان طبيعي',
    nameEn: 'Natural Pomegranate',
    descriptionAr: 'عصير رمان طازج غني بمضادات الأكسدة بدون إضافة سكر.',
    price: '٤٠ ر.س',
    category: 'drinks',
    image: 'https://images.unsplash.com/photo-1618897996318-5a901fa6ca71?q=80&w=800&auto=format&fit=crop'
  }
];

export const BLOG_POSTS: BlogPost[] = [
  {
    id: '1',
    title: 'سر التوابل الملوكية في الجوهرة',
    date: '١٢ أكتوبر ٢٠٢٤',
    excerpt: 'نأخذكم في رحلة لاستكشاف خبايا النكهات التي تميز مطبخ الجوهرة، من حقول الزعفران إلى موائدكم...',
    contentAr: 'لطالما كانت التوابل هي الروح النابضة للمطبخ العربي، وفي الجوهرة، نأخذ هذا المفهوم إلى آفاق جديدة. نحن لا نكتفي بشراء التوابل الجاهزة، بل نقوم باستيراد بذور الزعفران النقية مباشرة من مزارعها الأصلية، ونقوم بتحميص المكسرات في مطابخنا يومياً لضمان أعلى مستويات النضارة.\n\nإن التوازن بين المذاق الحامض للسمّاق والدفء المنبعث من الكمون هو ما يخلق تلك النغمة المميزة في أطباقنا. في هذا المقال، نشارككم جزءاً من فلسفتنا في اختيار المكونات وكيف نحول طبقاً بسيطاً إلى تجربة ملكية تستحق الاكتشاف.',
    image: 'https://images.unsplash.com/photo-1506368249639-73a05d6f6488?q=80&w=1000&auto=format&fit=crop'
  },
  {
    id: '2',
    title: 'فن الضيافة العربية المعاصرة',
    date: '٠٥ نوفمبر ٢٠٢٤',
    excerpt: 'كيف نجمع بين التراث العريق واللمسات العصرية في استقبال ضيوفنا لضمان تجربة لا تُنسى...',
    contentAr: 'الضيافة في ثقافتنا ليست مجرد خدمة، بل هي واجب مقدس وشكل من أشكال الفن. في الجوهرة، قمنا بدراسة تاريخ الضيافة العربية لنستلهم منها قيم الكرم والترحاب، ودمجناها مع معايير الخدمة العالمية.\n\nمنذ لحظة دخولك، نستقبلك برائحة العود الفاخرة ونغمات القانون الهادئة، حيث يتم تصميم كل ركن ليوفر الخصوصية والراحة. نحن نؤمن بأن "الجوهرة" ليست مجرد مكان لتناول الطعام، بل هي مساحة ثقافية تجمع العائلات والأصدقاء في جو مفعم بالأناقة والود.',
    image: 'https://images.unsplash.com/photo-1514362545857-3bc16549766b?q=80&w=1200&auto=format&fit=crop'
  }
];

export const GALLERY_IMAGES = [
  "https://images.unsplash.com/photo-1550966841-3ee7adac169a",
  "https://images.unsplash.com/photo-1559339352-11d035aa65de",
  "https://images.unsplash.com/photo-1514362545857-3bc16549766b",
  "https://images.unsplash.com/photo-1544148103-0773bf10d330",
  "https://images.unsplash.com/photo-1504674900247-0877df9cc836",
  "https://images.unsplash.com/photo-1590846406792-0adc7f938f1d"
];
