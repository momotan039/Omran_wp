<?php
/**
 * Template Name: About Page
 * The template for displaying the about page
 *
 * @package AlOmran
 */

get_header();

$company_info = alomran_get_company_info();
?>

<div class="bg-white">
    <!-- Header -->
    <div class="bg-primary text-white py-20 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]"></div>
        <div class="container mx-auto px-4 relative z-10 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 animate-fade-in-up">من نحن</h1>
            <p class="text-xl text-green-100 animate-fade-in-up delay-200">شركاؤكم في البناء والتطوير منذ عام ١٩٩٨</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-16">
        <div class="flex flex-col md:flex-row gap-16 items-center mb-20">
            <div class="md:w-1/2 animate-slide-in-right">
                <?php if (has_post_thumbnail()) : ?>
                    <?php the_post_thumbnail('large', array('class' => 'rounded-xl shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500 border-4 border-gray-100')); ?>
                <?php else : ?>
                    <img src="https://picsum.photos/id/403/800/600" alt="Factory" class="rounded-xl shadow-2xl rotate-2 hover:rotate-0 transition-transform duration-500 border-4 border-gray-100" />
                <?php endif; ?>
            </div>
            <div class="md:w-1/2 animate-fade-in-up delay-200">
                <h2 class="text-3xl font-bold text-primary mb-6 relative">
                    عن شركة العمران
                    <span class="absolute bottom-0 right-0 w-20 h-1 bg-secondary translate-y-2"></span>
                </h2>
                <div class="prose prose-lg max-w-none text-gray-600 leading-loose text-lg">
                    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                        <?php the_content(); ?>
                    <?php endwhile; endif; ?>
                </div>
            </div>
        </div>

        <!-- Mission & Vision -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-20">
            <div class="bg-white p-10 rounded-xl border-t-4 border-secondary shadow-lg hover:shadow-xl transition transform hover:-translate-y-2 animate-fade-in-up delay-300">
                <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center text-primary mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-primary mb-4">رؤيتنا</h3>
                <p class="text-gray-600 leading-relaxed text-lg">
                    <?php echo esc_html($company_info['vision']); ?>
                </p>
            </div>
            <div class="bg-white p-10 rounded-xl border-t-4 border-primary shadow-lg hover:shadow-xl transition transform hover:-translate-y-2 animate-fade-in-up delay-400">
                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-primary mb-6">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-primary mb-4">رسالتنا</h3>
                <p class="text-gray-600 leading-relaxed text-lg">
                    <?php echo esc_html($company_info['mission']); ?>
                </p>
            </div>
        </div>

        <!-- Stats -->
        <div class="bg-primary rounded-2xl p-12 text-white text-center grid grid-cols-1 md:grid-cols-3 gap-8 animate-scale-in delay-200">
            <div class="hover:scale-110 transition-transform duration-300">
                <div class="text-4xl font-bold text-secondary mb-2">25+</div>
                <div class="text-sm opacity-80">عام من الخبرة</div>
            </div>
            <div class="hover:scale-110 transition-transform duration-300">
                <div class="text-4xl font-bold text-secondary mb-2">500+</div>
                <div class="text-sm opacity-80">مشروع ناجح</div>
            </div>
            <div class="hover:scale-110 transition-transform duration-300">
                <div class="text-4xl font-bold text-secondary mb-2">100%</div>
                <div class="text-sm opacity-80">صنع في مصر</div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

