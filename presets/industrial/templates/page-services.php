<?php
/**
 * Template Name: Services Page
 * The template for displaying the services page
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="min-h-screen bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in-up">
            <h1 class="text-4xl font-bold text-primary mb-4">خدماتنا</h1>
            <p class="text-gray-600 text-lg">حلول متكاملة في مجال الصرف الصحي ومعالجة المياه</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Service Card 1 -->
            <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-xl transition-all duration-300 animate-fade-in-up delay-100">
                <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-4">التصميم والاستشارات</h3>
                <p class="text-gray-600 leading-relaxed">فريق من المهندسين المتخصصين يقدمون استشارات فنية شاملة ودراسات جدوى وتصاميم مخصصة تناسب احتياجات كل عميل.</p>
            </div>

            <!-- Service Card 2 -->
            <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-xl transition-all duration-300 animate-fade-in-up delay-200">
                <div class="w-16 h-16 bg-secondary/10 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-4">التصنيع</h3>
                <p class="text-gray-600 leading-relaxed">مصنعنا المجهز بأحدث التقنيات ينتج منتجات عالية الجودة وفقاً للمعايير الدولية.</p>
            </div>

            <!-- Service Card 3 -->
            <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-xl transition-all duration-300 animate-fade-in-up delay-300">
                <div class="w-16 h-16 bg-accent/10 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-4">التركيب والصيانة</h3>
                <p class="text-gray-600 leading-relaxed">فريق تركيب محترف يضمن التنفيذ الصحيح والصيانة الدورية لضمان الأداء الأمثل.</p>
            </div>

            <!-- Service Card 4 -->
            <div class="bg-white rounded-xl shadow-md p-8 hover:shadow-xl transition-all duration-300 animate-fade-in-up delay-400">
                <div class="w-16 h-16 bg-primary/10 rounded-lg flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-primary mb-4">الدعم الفني</h3>
                <p class="text-gray-600 leading-relaxed">دعم فني متواصل على مدار الساعة لمساعدة عملائنا في حل أي مشاكل تقنية.</p>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

