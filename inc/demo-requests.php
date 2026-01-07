<?php
/**
 * Demo Requests Management
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta box for demo request details
 */
function alomran_add_demo_request_meta_box() {
    add_meta_box(
        'demo_request_details',
        'تفاصيل طلب الديمو',
        'alomran_demo_request_meta_box_callback',
        'demo_request',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alomran_add_demo_request_meta_box');

/**
 * Meta box callback
 */
function alomran_demo_request_meta_box_callback($post) {
    $name = get_post_meta($post->ID, 'name', true);
    $email = get_post_meta($post->ID, 'email', true);
    $company = get_post_meta($post->ID, 'company', true);
    $message = get_post_meta($post->ID, 'message', true);
    $date = get_post_meta($post->ID, 'date', true);
    $ip = get_post_meta($post->ID, 'ip', true);
    $read = get_post_meta($post->ID, '_demo_read', true);
    
    // Mark as read when viewing
    if ($read !== '1') {
        update_post_meta($post->ID, '_demo_read', '1');
    }
    
    ?>
    <div style="padding: 20px;">
        <table class="form-table">
            <tr>
                <th style="width: 150px; padding: 10px 0;"><strong>الاسم:</strong></th>
                <td style="padding: 10px 0;"><?php echo esc_html($name); ?></td>
            </tr>
            <tr>
                <th style="padding: 10px 0;"><strong>البريد الإلكتروني:</strong></th>
                <td style="padding: 10px 0;">
                    <a href="mailto:<?php echo esc_attr($email); ?>">
                        <?php echo esc_html($email); ?>
                    </a>
                </td>
            </tr>
            <tr>
                <th style="padding: 10px 0;"><strong>اسم الشركة:</strong></th>
                <td style="padding: 10px 0;"><?php echo esc_html($company); ?></td>
            </tr>
            <?php if ($message) : ?>
            <tr>
                <th style="padding: 10px 0;"><strong>الرسالة:</strong></th>
                <td style="padding: 10px 0;"><?php echo nl2br(esc_html($message)); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th style="padding: 10px 0;"><strong>تاريخ الطلب:</strong></th>
                <td style="padding: 10px 0;"><?php echo esc_html($date ? date_i18n('Y/m/d H:i', strtotime($date)) : get_the_date('Y/m/d H:i', $post->ID)); ?></td>
            </tr>
            <?php if ($ip) : ?>
            <tr>
                <th style="padding: 10px 0;"><strong>عنوان IP:</strong></th>
                <td style="padding: 10px 0;"><?php echo esc_html($ip); ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <th style="padding: 10px 0;"><strong>حالة القراءة:</strong></th>
                <td style="padding: 10px 0;">
                    <?php if ($read === '1') : ?>
                        <span style="color: green; font-weight: bold;">✓ مقروءة</span>
                    <?php else : ?>
                        <span style="color: red; font-weight: bold;">✗ غير مقروءة</span>
                    <?php endif; ?>
                </td>
            </tr>
        </table>
    </div>
    <?php
}

/**
 * Add custom columns to demo requests list
 */
function alomran_demo_request_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = 'الاسم';
    $new_columns['demo_email'] = 'البريد الإلكتروني';
    $new_columns['demo_company'] = 'الشركة';
    $new_columns['demo_read'] = 'الحالة';
    $new_columns['date'] = 'التاريخ';
    return $new_columns;
}
add_filter('manage_demo_request_posts_columns', 'alomran_demo_request_columns');

/**
 * Display custom column content
 */
function alomran_demo_request_column_content($column, $post_id) {
    switch ($column) {
        case 'demo_email':
            $email = get_post_meta($post_id, 'email', true);
            if ($email) {
                echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            } else {
                echo '—';
            }
            break;
            
        case 'demo_company':
            $company = get_post_meta($post_id, 'company', true);
            if ($company) {
                echo esc_html($company);
            } else {
                echo '—';
            }
            break;
            
        case 'demo_read':
            $read = get_post_meta($post_id, '_demo_read', true);
            if ($read === '1') {
                echo '<span style="color: green; font-weight: bold;">✓ مقروءة</span>';
            } else {
                echo '<span style="color: red; font-weight: bold;">✗ غير مقروءة</span>';
            }
            break;
    }
}
add_action('manage_demo_request_posts_custom_column', 'alomran_demo_request_column_content', 10, 2);

/**
 * Make columns sortable
 */
function alomran_demo_request_sortable_columns($columns) {
    $columns['demo_read'] = 'demo_read';
    $columns['demo_email'] = 'demo_email';
    return $columns;
}
add_filter('manage_edit-demo_request_sortable_columns', 'alomran_demo_request_sortable_columns');

/**
 * Handle sorting
 */
function alomran_demo_request_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ('demo_read' === $query->get('orderby')) {
        $query->set('meta_key', '_demo_read');
        $query->set('orderby', 'meta_value');
    }
    
    if ('demo_email' === $query->get('orderby')) {
        $query->set('meta_key', 'email');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'alomran_demo_request_orderby');

/**
 * Change post title to show name and company
 */
function alomran_demo_request_title($title, $post_id) {
    if (get_post_type($post_id) === 'demo_request') {
        $name = get_post_meta($post_id, 'name', true);
        $company = get_post_meta($post_id, 'company', true);
        if ($name && $company) {
            return $name . ' - ' . $company;
        } elseif ($name) {
            return $name;
        }
    }
    return $title;
}
add_filter('the_title', 'alomran_demo_request_title', 10, 2);

/**
 * Add unread count badge to menu
 */
function alomran_demo_request_menu_badge() {
    global $menu;
    
    // Count unread demo requests (where _demo_read is not '1' or doesn't exist)
    $unread_count = get_posts(array(
        'post_type'      => 'demo_request',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'meta_query'     => array(
            'relation' => 'OR',
            array(
                'key'     => '_demo_read',
                'compare' => 'NOT EXISTS',
            ),
            array(
                'key'   => '_demo_read',
                'value' => '1',
                'compare' => '!=',
            ),
        ),
        'fields'         => 'ids',
    ));
    
    $count = count($unread_count);
    
    if ($count > 0) {
        foreach ($menu as $key => $item) {
            if (isset($item[2]) && $item[2] === 'edit.php?post_type=demo_request') {
                $menu[$key][0] .= ' <span class="update-plugins count-' . $count . '" style="background: #d63638; color: white; border-radius: 10px; padding: 0 6px; margin-right: 5px;"><span class="plugin-count">' . $count . '</span></span>';
                break;
            }
        }
    }
}
add_action('admin_menu', 'alomran_demo_request_menu_badge', 999);

