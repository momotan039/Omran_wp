<?php
/**
 * Template Name: Projects Page
 * The template for displaying the projects page
 *
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>

<div class="min-h-screen bg-gray-50 py-16">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in-up">
            <h1 class="text-4xl font-bold text-primary mb-4">مشاريعنا الناجحة</h1>
            <p class="text-gray-600 text-lg">نفخر بمشاريعنا المتنوعة في مختلف القطاعات</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Project Category 1 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 animate-fade-in-up delay-100">
                <div class="h-48 bg-gradient-to-br from-primary to-secondary flex items-center justify-center">
                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-primary mb-3">المشاريع الصناعية</h3>
                    <p class="text-gray-600 leading-relaxed">تنفيذ أنظمة صرف صحي متكاملة للمصانع والمنشآت الصناعية الكبرى.</p>
                </div>
            </div>

            <!-- Project Category 2 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 animate-fade-in-up delay-200">
                <div class="h-48 bg-gradient-to-br from-secondary to-accent flex items-center justify-center">
                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-primary mb-3">المشاريع الصحية</h3>
                    <p class="text-gray-600 leading-relaxed">تركيب أنظمة متخصصة للمستشفيات والمرافق الصحية وفقاً للمعايير الصحية الصارمة.</p>
                </div>
            </div>

            <!-- Project Category 3 -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 animate-fade-in-up delay-300">
                <div class="h-48 bg-gradient-to-br from-accent to-primary flex items-center justify-center">
                    <svg class="w-20 h-20 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-primary mb-3">المشاريع التجارية</h3>
                    <p class="text-gray-600 leading-relaxed">حلول مخصصة للمطاعم والفنادق والمراكز التجارية.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>

