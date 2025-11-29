<?php
/**
 * Contact Messages Management
 * 
 * @package AlOmran
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add meta box for contact message details
 */
function alomran_add_contact_message_meta_box() {
    add_meta_box(
        'contact_message_details',
        'تفاصيل الرسالة',
        'alomran_contact_message_meta_box_callback',
        'contact_message',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'alomran_add_contact_message_meta_box');

/**
 * Meta box callback
 */
function alomran_contact_message_meta_box_callback($post) {
    $name = get_post_meta($post->ID, '_contact_name', true);
    $phone = get_post_meta($post->ID, '_contact_phone', true);
    $email = get_post_meta($post->ID, '_contact_email', true);
    $date = get_post_meta($post->ID, '_contact_date', true);
    $read = get_post_meta($post->ID, '_contact_read', true);
    
    // Mark as read when viewing
    if ($read !== '1') {
        update_post_meta($post->ID, '_contact_read', '1');
    }
    
    ?>
    <div style="padding: 20px;">
        <table class="form-table">
            <tr>
                <th style="width: 150px; padding: 10px 0;"><strong>الاسم:</strong></th>
                <td style="padding: 10px 0;"><?php echo esc_html($name); ?></td>
            </tr>
            <tr>
                <th style="padding: 10px 0;"><strong>الهاتف:</strong></th>
                <td style="padding: 10px 0;">
                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $phone)); ?>">
                        <?php echo esc_html($phone); ?>
                    </a>
                </td>
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
                <th style="padding: 10px 0;"><strong>تاريخ الإرسال:</strong></th>
                <td style="padding: 10px 0;"><?php echo esc_html($date ? date_i18n('Y/m/d H:i', strtotime($date)) : get_the_date('Y/m/d H:i', $post->ID)); ?></td>
            </tr>
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
 * Add custom columns to contact messages list
 */
function alomran_contact_message_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = 'الاسم';
    $new_columns['contact_email'] = 'البريد الإلكتروني';
    $new_columns['contact_phone'] = 'الهاتف';
    $new_columns['contact_read'] = 'الحالة';
    $new_columns['date'] = 'التاريخ';
    return $new_columns;
}
add_filter('manage_contact_message_posts_columns', 'alomran_contact_message_columns');

/**
 * Display custom column content
 */
function alomran_contact_message_column_content($column, $post_id) {
    switch ($column) {
        case 'contact_email':
            $email = get_post_meta($post_id, '_contact_email', true);
            if ($email) {
                echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            } else {
                echo '—';
            }
            break;
            
        case 'contact_phone':
            $phone = get_post_meta($post_id, '_contact_phone', true);
            if ($phone) {
                echo '<a href="tel:' . esc_attr(str_replace(' ', '', $phone)) . '">' . esc_html($phone) . '</a>';
            } else {
                echo '—';
            }
            break;
            
        case 'contact_read':
            $read = get_post_meta($post_id, '_contact_read', true);
            if ($read === '1') {
                echo '<span style="color: green; font-weight: bold;">✓ مقروءة</span>';
            } else {
                echo '<span style="color: red; font-weight: bold;">✗ غير مقروءة</span>';
            }
            break;
    }
}
add_action('manage_contact_message_posts_custom_column', 'alomran_contact_message_column_content', 10, 2);

/**
 * Make columns sortable
 */
function alomran_contact_message_sortable_columns($columns) {
    $columns['contact_read'] = 'contact_read';
    $columns['contact_email'] = 'contact_email';
    return $columns;
}
add_filter('manage_edit-contact_message_sortable_columns', 'alomran_contact_message_sortable_columns');

/**
 * Handle sorting
 */
function alomran_contact_message_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }

    if ('contact_read' === $query->get('orderby')) {
        $query->set('meta_key', '_contact_read');
        $query->set('orderby', 'meta_value');
    }
    
    if ('contact_email' === $query->get('orderby')) {
        $query->set('meta_key', '_contact_email');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'alomran_contact_message_orderby');

/**
 * Change post title to show name
 */
function alomran_contact_message_title($title, $post_id) {
    if (get_post_type($post_id) === 'contact_message') {
        $name = get_post_meta($post_id, '_contact_name', true);
        if ($name) {
            return $name;
        }
    }
    return $title;
}
add_filter('the_title', 'alomran_contact_message_title', 10, 2);

/**
 * Add unread count badge to menu
 */
function alomran_contact_message_menu_badge() {
    global $menu;
    
    $unread_count = get_posts(array(
        'post_type'      => 'contact_message',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'   => '_contact_read',
                'value' => '0',
            ),
        ),
        'fields'         => 'ids',
    ));
    
    $count = count($unread_count);
    
    if ($count > 0) {
        foreach ($menu as $key => $item) {
            if ($item[2] === 'edit.php?post_type=contact_message') {
                $menu[$key][0] .= ' <span class="update-plugins count-' . $count . '" style="background: #d63638; color: white; border-radius: 10px; padding: 0 6px; margin-right: 5px;"><span class="plugin-count">' . $count . '</span></span>';
                break;
            }
        }
    }
}
add_action('admin_menu', 'alomran_contact_message_menu_badge');

