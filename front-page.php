<?php
/**
 * The front page template
 *
 * @package AlOmran
 */

get_header();

$company_info = alomran_get_company_info();

// Get featured products
$featured_products_query = new WP_Query(array(
    'post_type' => 'product',
    'posts_per_page' => 3,
    'meta_query' => array(
        array(
            'key' => 'is_featured',
            'value' => '1',
            'compare' => '='
        )
    )
));

// Get testimonials
$testimonials_query = new WP_Query(array(
    'post_type' => 'testimonial',
    'posts_per_page' => 2
));

// Risks content (static - can be moved to theme options)
$risks_content = array(
    array('title' => 'انسداد متكرر', 'desc' => 'يعطّل خطوط الإنتاج ويوقف العمل.'),
    array('title' => 'تآكل سريع', 'desc' => 'يؤدي إلى تسرّب الروائح والمياه وتلوث البيئة.'),
    array('title' => 'نمو بكتيري', 'desc' => 'بسبب استخدام خامات رديئة غير مقاومة للميكروبات.'),
    array('title' => 'خسائر تشغيلية', 'desc' => 'تكاليف باهظة بسبب الأعطال والصيانة المستمرة.'),
    array('title' => 'تهديد السلامة', 'desc' => 'مخالفة معايير السلامة في المنشآت الغذائية والصناعية.')
);

// Why Stainless Steel content (static)
$why_stainless = array(
    array('text' => 'مقاومة عالية للتآكل في البيئات الرطبة.'),
    array('text' => 'عمر افتراضي طويل وصيانة شبه معدومة.'),
    array('text' => 'يمنع تراكم البكتيريا وسهل التنظيف.'),
    array('text' => 'يتحمل درجات حرارة مختلفة.'),
    array('text' => 'يحافظ على جودة الأنظمة ويقلل الأعطال.'),
    array('text' => 'مناسب للمنشآت الغذائية وفق المعايير الدولية.')
);
?>

<div class="w-full">
    <!-- Hero Section -->
    <section class="relative h-[85vh] flex items-center overflow-hidden">
        <div class="absolute inset-0 bg-primary/80 z-10 mix-blend-multiply"></div>
        <div class="absolute inset-0 bg-black/30 z-10"></div>
        <div class="absolute inset-0 bg-cover bg-center z-0 animate-scale-in" style="background-image: url('https://picsum.photos/id/195/1920/1080'); animation-duration: 10s;"></div>
        
        <div class="container mx-auto px-4 relative z-20 text-white text-center md:text-right">
            <div class="flex flex-col md:flex-row justify-between items-center md:items-start">
                <div class="md:w-2/3">
                    <span class="bg-secondary text-white font-bold px-4 py-1 rounded-full text-sm inline-block mb-4 animate-bounce">
                        الرائدون في مصر
                    </span>
                    <h1 class="text-4xl md:text-6xl font-black leading-tight mb-6 font-sans animate-fade-in-up">
                        <?php echo esc_html($company_info['slogan']); ?>
                        <br/>
                        <span class="text-secondary">في كل قطرة ومشروع</span>
                    </h1>
                    <p class="text-lg md:text-xl text-gray-100 mb-8 max-w-2xl leading-relaxed animate-fade-in-up delay-200">
                        نقدم حلولاً هندسية متكاملة لشبكات الصرف ومعالجة المياه. منتجات مصممة لتدوم، وتحمي استثماراتك من مخاطر الانسداد والتآكل.
                    </p>
                    <div class="flex flex-col md:flex-row gap-4 justify-center md:justify-start animate-fade-in-up delay-400">
                        <a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="bg-secondary text-white hover:bg-white hover:text-primary px-8 py-3 rounded-md font-bold text-lg transition-all duration-300 flex items-center justify-center gap-2 shadow-lg hover:shadow-secondary/50">
                            تصفح المنتجات
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </a>
                        <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact')) ?: home_url('/contact')); ?>" class="border-2 border-white hover:bg-white hover:text-primary px-8 py-3 rounded-md font-bold text-lg transition-all duration-300">
                            استشارة مجانية
                        </a>
                    </div>
                </div>
                <!-- Official Seal -->
                <div class="hidden md:flex flex-col items-center justify-center mt-8 md:mt-0 opacity-90 animate-scale-in delay-500">
                    <div class="w-32 h-32 md:w-40 md:h-40 bg-white/10 backdrop-blur-md rounded-full border-2 border-secondary flex flex-col items-center justify-center p-4 shadow-xl rotate-12 hover:rotate-0 transition-all duration-500">
                        <svg class="w-12 h-12 text-secondary mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                        <span class="text-xs font-bold text-white text-center leading-tight">جودة معتمدة<br/>ISO 9001</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Decorative curve at bottom -->
        <div class="absolute bottom-0 left-0 right-0 z-20">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
                <path fill="#f3f4f6" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>
    </section>

    <!-- Risks Section -->
    <section class="py-16 bg-accent relative z-10 -mt-10 md:-mt-20">
        <div class="container mx-auto px-4">
            <div class="bg-white rounded-2xl shadow-xl p-8 md:p-12 border-t-8 border-primary animate-fade-in-up delay-200">
                <div class="text-center mb-10">
                    <h2 class="text-3xl font-bold text-primary mb-4">المخاطر في أنظمة الصرف الرديئة</h2>
                    <div class="h-1 w-20 bg-secondary mx-auto"></div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    <?php foreach ($risks_content as $idx => $risk) : ?>
                        <div class="flex items-start gap-4 p-4 rounded-lg hover:bg-gray-50 transition-colors animate-scale-in delay-<?php echo ($idx % 3 + 1) * 100; ?>">
                            <div class="bg-red-50 p-3 rounded-full text-red-500 flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-lg text-primary mb-2"><?php echo esc_html($risk['title']); ?></h4>
                                <p class="text-gray-500 text-sm leading-relaxed"><?php echo esc_html($risk['desc']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Sectors Section -->
    <section class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="text-3xl font-bold text-primary mb-4">قطاعات نخدمها</h2>
                <div class="h-1 w-20 bg-secondary mx-auto"></div>
                <p class="mt-4 text-gray-500">نقدم حلولاً متخصصة لكل قطاع لضمان الكفاءة القصوى</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-t-4 border-secondary group animate-fade-in-up delay-100">
                    <div class="text-primary mb-6 group-hover:text-secondary transition-colors duration-300 transform group-hover:scale-110 origin-right">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">القطاع السكني</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">حلول للصرف المنزلي، مصائد شحوم للمطابخ، وأنظمة ري ذكية.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-t-4 border-secondary group animate-fade-in-up delay-200">
                    <div class="text-primary mb-6 group-hover:text-secondary transition-colors duration-300 transform group-hover:scale-110 origin-right">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">القطاع الصناعي</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">جريلات تتحمل الأوزان الثقيلة، ومعالجة المياه الصناعية المعقدة.</p>
                </div>
                <div class="bg-white p-8 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 border-t-4 border-secondary group animate-fade-in-up delay-300">
                    <div class="text-primary mb-6 group-hover:text-secondary transition-colors duration-300 transform group-hover:scale-110 origin-right">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-gray-800">المطاعم والفنادق</h3>
                    <p class="text-gray-500 leading-relaxed text-sm">أنظمة صحية تمنع الروائح والقوارض وتوافق اشتراطات السلامة الغذائية.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <?php if ($featured_products_query->have_posts()) : ?>
        <section class="py-20 bg-accent">
            <div class="container mx-auto px-4">
                <div class="flex justify-between items-end mb-12 animate-fade-in-up">
                    <div>
                        <h2 class="text-3xl font-bold text-primary mb-2">منتجات مختارة</h2>
                        <div class="h-1 w-20 bg-secondary"></div>
                    </div>
                    <a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="hidden md:flex items-center text-primary font-bold hover:text-secondary transition">
                        عرض الكل
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <?php $idx = 0; while ($featured_products_query->have_posts()) : $featured_products_query->the_post(); ?>
                        <?php get_template_part('template-parts/product-card'); ?>
                        <?php $idx++; endwhile; wp_reset_postdata(); ?>
                </div>
                
                <div class="mt-8 text-center md:hidden">
                    <a href="<?php echo esc_url(get_post_type_archive_link('product') ?: home_url('/products')); ?>" class="inline-flex items-center text-primary font-bold hover:text-secondary transition">
                        عرض الكل
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </a>
                </div>
            </div>
        </section>
    <?php endif; ?>

    <!-- Why Stainless Steel Section -->
    <section class="py-20 bg-gray-100">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16 animate-fade-in-up">
                <h2 class="text-3xl font-bold text-primary mb-4">ليش الاستانلس ستيل هو الخيار الأمثل؟</h2>
                <p class="text-gray-500">الجودة التي تستحق الاستثمار</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php
                $icons = array(
                    '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
                    '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>',
                    '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
                    '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
                    '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>',
                    '<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>'
                );
                foreach ($why_stainless as $idx => $item) :
                    $icon = $icons[$idx % count($icons)];
                ?>
                    <div class="flex items-center gap-4 bg-white p-6 rounded-lg shadow-sm border border-gray-100 hover:border-secondary transition-all hover:-translate-y-1 animate-fade-in-up delay-<?php echo ($idx % 3 + 1) * 100; ?>">
                        <div class="text-secondary flex-shrink-0">
                            <?php echo $icon; ?>
                        </div>
                        <p class="font-bold text-gray-700"><?php echo esc_html($item['text']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <?php if ($testimonials_query->have_posts()) : ?>
        <section class="py-20 bg-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-secondary/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>

            <div class="container mx-auto px-4 relative z-10">
                <h2 class="text-3xl font-bold text-center text-primary mb-16 animate-fade-in-up">شركاء النجاح</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <?php $idx = 0; while ($testimonials_query->have_posts()) : $testimonials_query->the_post(); 
                        $role = get_field('role') ?: '';
                        $company = get_field('company') ?: '';
                        $content = get_field('content') ?: get_the_content();
                    ?>
                        <div class="bg-gray-50 p-8 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-6 items-center md:items-start text-center md:text-right hover:border-secondary transition-colors duration-300 animate-slide-in-right delay-<?php echo ($idx + 1) * 200; ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', array('class' => 'w-20 h-20 rounded-full object-cover border-4 border-white shadow-md')); ?>
                            <?php else : ?>
                                <div class="w-20 h-20 rounded-full bg-secondary/20 flex items-center justify-center border-4 border-white shadow-md">
                                    <span class="text-2xl"><?php echo mb_substr(get_the_title(), 0, 1); ?></span>
                                </div>
                            <?php endif; ?>
                            <div>
                                <p class="text-gray-600 italic mb-4">"<?php echo esc_html($content); ?>"</p>
                                <h4 class="font-bold text-primary"><?php the_title(); ?></h4>
                                <?php if ($role || $company) : ?>
                                    <span class="text-xs text-secondary font-bold uppercase tracking-wider">
                                        <?php if ($role) echo esc_html($role); ?>
                                        <?php if ($role && $company) echo ' - '; ?>
                                        <?php if ($company) echo esc_html($company); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php $idx++; endwhile; wp_reset_postdata(); ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</div>

<?php get_footer(); ?>

