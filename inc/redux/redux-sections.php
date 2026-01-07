<?php
/**
 * Food Theme - Redux Sections
 * 
 * Returns array of Redux section files to load
 * 
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

// Return array of section files to load for Food theme
// Organized by main categories with subsections
return array(
    // ============================================
    // الصفحة الرئيسية
    // ============================================
    'food-homepage.php',       // Main homepage section (parent)
    'food-hero.php',           // Hero, Philosophy, Experience, Story sections (subsections)
    'food-menu.php',           // Menu display settings (subsection)
    'food-blog.php',           // Blog settings (subsection)
    'food-branches.php',       // Branches settings (subsection)
    
    // ============================================
    // الصفحات
    // ============================================
    'food-pages.php',          // Main pages section (parent)
    'food-reservations.php',   // Reservations settings (subsection)
    'food-contact-page.php',   // Contact page settings (subsection)
    
    // ============================================
    // إعدادات عامة
    // ============================================
    'food-general.php',        // Main general settings section (parent)
    'food-footer.php',         // Footer settings (subsection)
    'food-social.php',         // Social media links (subsection)
    'ads.php',                 // Ads / Monetization system (subsection)
);

