<?php
/**
 * Bootstrap theme includes.
 * 
 * @package AlOmran
 * @subpackage Industrial
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ALOMRAN_THEME_VERSION', wp_get_theme()->get('Version'));
define('ALOMRAN_THEME_DIR', get_template_directory());
define('ALOMRAN_THEME_URI', get_template_directory_uri());

// Core Setup
require_once ALOMRAN_THEME_DIR . '/inc/setup.php';
require_once ALOMRAN_THEME_DIR . '/inc/redux-blocker.php';
require_once ALOMRAN_THEME_DIR . '/inc/assets.php';
require_once ALOMRAN_THEME_DIR . '/inc/menu-walker.php';
require_once ALOMRAN_THEME_DIR . '/inc/translation.php';

// Helpers
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-company.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-content.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-products.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-url.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-archive.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-contact.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-ads.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-content-display.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-taxonomies.php';
require_once ALOMRAN_THEME_DIR . '/inc/helpers/helpers-redux-repeater.php';

// Custom Post Types & Taxonomies
require_once ALOMRAN_THEME_DIR . '/inc/cpt-common.php';
require_once ALOMRAN_THEME_DIR . '/inc/cpt.php';
require_once ALOMRAN_THEME_DIR . '/inc/taxonomies.php';

// ACF
if (file_exists(ALOMRAN_THEME_DIR . '/inc/acf.php')) {
    require_once ALOMRAN_THEME_DIR . '/inc/acf.php';
}

// Media Management
require_once ALOMRAN_THEME_DIR . '/inc/product-media.php';
require_once ALOMRAN_THEME_DIR . '/inc/news-media.php';

// Contact & AJAX
require_once ALOMRAN_THEME_DIR . '/inc/contact-messages.php';
require_once ALOMRAN_THEME_DIR . '/inc/demo-requests.php';
require_once ALOMRAN_THEME_DIR . '/inc/ajax.php';

// SEO
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-helpers.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-core.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-schema.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-sitemap.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-images.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-accessibility.php';
require_once ALOMRAN_THEME_DIR . '/inc/seo/seo-enhancements.php';

// Redux
require_once ALOMRAN_THEME_DIR . '/inc/redux/redux-helpers-core.php';
require_once ALOMRAN_THEME_DIR . '/inc/redux/redux-helpers.php';
require_once ALOMRAN_THEME_DIR . '/inc/redux/redux-config.php';

// Demo Import & Setup Wizard
require_once ALOMRAN_THEME_DIR . '/inc/demo-import/demo-data.php';
require_once ALOMRAN_THEME_DIR . '/inc/demo-import/setup-wizard.php';
require_once ALOMRAN_THEME_DIR . '/inc/demo-import/admin-ui.php';

// Widgets
require_once ALOMRAN_THEME_DIR . '/inc/widgets/ads-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/hero-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/spec-table-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/download-box-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/gallery-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/testimonials-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/projects-slider-widget.php';
require_once ALOMRAN_THEME_DIR . '/inc/widgets/clients-grid-widget.php';

