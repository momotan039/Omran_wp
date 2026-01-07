<?php
/**
 * Tech Theme - Redux Sections
 * 
 * Returns array of Redux section files to load
 * 
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}

// Return array of section files to load for Tech theme
// Organized by main categories with subsections
return array(
    // ============================================
    // الصفحة الرئيسية
    // ============================================
    'tech-homepage.php',       // Main homepage section (parent)
    'tech-hero.php',           // Hero section settings (subsection)
    'tech-case-study.php',     // Case study section settings (subsection) - includes all new sections (Features Preview, Stats, Testimonials, CTA)
    
    // ============================================
    // الصفحات
    // ============================================
    'tech-pages.php',          // Main pages section (parent)
    'tech-features-page.php',  // Features page settings (subsection)
    'tech-pricing-page.php',   // Pricing page settings (subsection)
    'tech-use-cases-page.php', // Use cases page settings (subsection)
    'tech-about-page.php',     // About page settings (subsection)
    'tech-contact-page.php',   // Contact page settings (subsection)
    
    // ============================================
    // إعدادات عامة
    // ============================================
    'tech-general.php',        // Main general settings section (parent)
    'tech-header.php',         // Header settings (subsection)
    'tech-footer.php',         // Footer settings (subsection)
    'tech-social.php',         // Social media links (subsection)
    'tech-typography.php',     // Typography settings (subsection)
    'tech-colors.php',         // Color settings (subsection)
    'tech-loader.php',         // Page loader settings (subsection)
);

