<?php
/**
 * Bootstrap theme includes.
 *
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

define('ALOMRAN_THEME_VERSION', wp_get_theme()->get('Version'));
define('ALOMRAN_THEME_DIR', get_template_directory());
define('ALOMRAN_THEME_URI', get_template_directory_uri());

$alomran_includes = array(
    'inc/helpers.php',
    'inc/setup.php',
    'inc/assets.php',
    'inc/menu-walker.php',
    'inc/cpt.php',
    'inc/taxonomies.php',
    'inc/acf.php',
    'inc/ajax.php',
);

foreach ($alomran_includes as $file) {
    $filepath = ALOMRAN_THEME_DIR . '/' . $file;

    if (file_exists($filepath)) {
        require_once $filepath;
    }
}

