<?php
/**
 * Custom menu walker for theme navigation.
 *
 * @package AlOmran_Core
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Custom navigation walker with theme-specific classes.
 * 
 * Note: This class may already be defined in inc/menu-walker.php for backward compatibility.
 */
if (!class_exists('AlOmran_Walker_Nav_Menu')) {
    class AlOmran_Walker_Nav_Menu extends Walker_Nav_Menu {

    /**
     * Start the element output.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Menu item data object.
     * @param int    $depth  Depth of menu item. Used for padding.
     * @param array  $args   An array of arguments. @see wp_nav_menu().
     * @param int    $id     Current item ID.
     */
    public function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $indent = ($depth) ? str_repeat($t, $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Check if item has 'menu-cta' class for button styling
        $is_cta = in_array('menu-cta', $classes, true);
        
        // Add active class
        $active_classes = array();
        if (in_array('current-menu-item', $classes, true) || 
            in_array('current-page-ancestor', $classes, true) ||
            (is_home() && $item->url === home_url('/'))) {
            $active_classes[] = 'text-secondary';
            $active_classes[] = 'font-bold';
        } else {
            $active_classes[] = 'text-white';
            $active_classes[] = 'hover:text-secondary';
        }

        // Base classes for menu items
        $base_classes = array('transition-colors', 'duration-300');
        
        if ($is_cta) {
            // CTA button classes
            $base_classes = array(
                'bg-secondary',
                'text-primary',
                'px-5',
                'py-2',
                'rounded-full',
                'font-bold',
                'hover:bg-yellow-500',
                'transition',
                'shadow-lg',
                'animate-pulse'
            );
        } else {
            // Regular menu item classes
            $base_classes[] = 'text-sm';
            $base_classes[] = 'lg:text-base';
        }

        // Get menu container classes to determine if mobile
        $is_mobile = isset($args->menu_class) && strpos($args->menu_class, 'flex-col') !== false;
        
        // Combine all classes for the link
        $link_classes = array_merge($base_classes, $active_classes);
        if ($is_mobile && !$is_cta) {
            $link_classes[] = 'block';
        }
        $link_class_string = ' class="' . esc_attr(join(' ', array_filter($link_classes))) . '"';

        // List item classes (minimal)
        $li_classes = array('menu-item', 'menu-item-' . $item->ID);
        $li_class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($li_classes), $item, $args));
        $li_class_names = $li_class_names ? ' class="' . esc_attr($li_class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $li_class_names . '>';

        $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
        $attributes .= $link_class_string;

        $item_output = isset($args->before) ? $args->before : '';
        $item_output .= '<a' . $attributes . '>';
        $item_output .= (isset($args->link_before) ? $args->link_before : '') . apply_filters('the_title', $item->title, $item->ID) . (isset($args->link_after) ? $args->link_after : '');
        $item_output .= '</a>';
        $item_output .= isset($args->after) ? $args->after : '';

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    /**
     * End the element output.
     *
     * @param string $output Passed by reference. Used to append additional content.
     * @param object $item   Page data object. Not used.
     * @param int    $depth  Depth of page. Not Used.
     * @param array  $args   An array of arguments. @see wp_nav_menu().
     */
    public function end_el(&$output, $item, $depth = 0, $args = null) {
        if (isset($args->item_spacing) && 'discard' === $args->item_spacing) {
            $t = '';
            $n = '';
        } else {
            $t = "\t";
            $n = "\n";
        }
        $output .= "</li>{$n}";
    }
} // End class
} // End class_exists check

