<?php
/**
 * Food Preset - Header Loader
 * Loads Tailwind CSS CDN with custom config matching React app
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}
?>
<!-- Tailwind CSS CDN with Food Preset Config -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Tajawal', 'sans-serif'],
        },
        colors: {
          brand: {
            black: '#0A0A0A',
            gold: '#D4AF37',
            goldLight: '#F4CF67',
            cream: '#FAF9F6',
            gray: '#71717A',
            accent: '#B8860B'
          }
        },
        animation: {
          'float': 'float 6s ease-in-out infinite',
          'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
        },
        keyframes: {
          float: {
            '0%, 100%': { transform: 'translateY(0)' },
            '50%': { transform: 'translateY(-20px)' },
          }
        }
      }
    }
  }
</script>

<!-- Tajawal Font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

<style>
  body {
    background-color: #FAF9F6;
    color: #0A0A0A;
    overflow-x: hidden;
    cursor: default;
    font-family: 'Tajawal', sans-serif;
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
// Load the actual header template
$header_template = AlOmran_Preset_Loader::locate_template('header-default', 'header');
if ($header_template) {
    include $header_template;
}
?>

