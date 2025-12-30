<?php
/**
 * Tech Preset - Header Loader
 * Loads Tailwind CSS CDN with custom config matching React app
 *
 * @package AlOmran
 * @subpackage Tech
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!-- Tailwind CSS CDN with Tech Preset Config -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Cairo', 'sans-serif'],
        },
        colors: {
          blue: {
            50: '#eff6ff',
            100: '#dbeafe',
            200: '#bfdbfe',
            300: '#93c5fd',
            400: '#60a5fa',
            500: '#3b82f6',
            600: '#2563eb',
            700: '#1d4ed8',
            800: '#1e40af',
            900: '#1e3a8a',
          },
          slate: {
            50: '#f8fafc',
            100: '#f1f5f9',
            200: '#e2e8f0',
            300: '#cbd5e1',
            400: '#94a3b8',
            500: '#64748b',
            600: '#475569',
            700: '#334155',
            800: '#1e293b',
            900: '#0f172a',
          },
          violet: {
            600: '#6366f1',
          }
        },
        animation: {
          'gradient-x': 'gradient-x 3s ease infinite',
        },
        keyframes: {
          'gradient-x': {
            '0%, 100%': { 'background-position': '0% 50%' },
            '50%': { 'background-position': '100% 50%' },
          }
        }
      }
    }
  }
</script>

<?php
// Get typography settings
$font_family = alomran_get_option('tech_typography_font_family', 'cairo');
$font_families = array(
    'cairo' => array('name' => 'Cairo', 'url' => 'Cairo:wght@200;300;400;500;600;700;800;900'),
    'tajawal' => array('name' => 'Tajawal', 'url' => 'Tajawal:wght@200;300;400;500;700;800;900'),
    'almarai' => array('name' => 'Almarai', 'url' => 'Almarai:wght@300;400;700;800'),
);
$selected_font = isset($font_families[$font_family]) ? $font_families[$font_family] : $font_families['cairo'];
?>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=<?php echo esc_attr($selected_font['url']); ?>&display=swap" rel="stylesheet">

<?php
// Get typography settings
$font_family = alomran_get_option('tech_typography_font_family', 'cairo');
$font_families = array(
    'cairo' => 'Cairo',
    'tajawal' => 'Tajawal',
    'almarai' => 'Almarai',
);
$font_name = isset($font_families[$font_family]) ? $font_families[$font_family] : 'Cairo';
?>
<style>
  *,
  *::before,
  *::after {
    font-family: '<?php echo esc_attr($font_name); ?>', sans-serif !important;
  }
  
  body {
    background-color: #f8fafc;
    color: #1e293b;
    overflow-x: hidden;
    cursor: default;
    font-family: '<?php echo esc_attr($font_name); ?>', sans-serif !important;
  }
  
  /* Apply font to all text elements */
  h1, h2, h3, h4, h5, h6,
  p, span, div, a, button,
  input, textarea, select,
  label, li, td, th {
    font-family: '<?php echo esc_attr($font_name); ?>', sans-serif !important;
  }
  
  /* Hide scrollbar but keep functionality */
  .no-scrollbar::-webkit-scrollbar { 
    display: none; 
  }
  .no-scrollbar { 
    -ms-overflow-style: none; 
    scrollbar-width: none; 
  }
</style>

<?php
// Get header style from Redux
$header_style = alomran_get_option('tech_header_style', 'default');

// Load header template
$header_template = AlOmran_Preset_Loader::locate_template('header-' . $header_style, 'header');
if (!$header_template) {
    // Fallback to default
    $header_template = AlOmran_Preset_Loader::locate_template('header-default', 'header');
}

if ($header_template) {
    include $header_template;
}
?>


