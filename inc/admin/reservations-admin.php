<?php
/**
 * Food Preset - Reservations Admin Enhancements
 * 
 * Adds meta boxes, columns, and admin UI for reservations
 *
 * @package AlOmran
 * @subpackage Food
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add unread count badge to reservations menu
 */
function alomran_food_reservation_menu_badge() {
    global $menu;
    
    $unread_count = get_posts(array(
        'post_type'      => 'reservation',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'   => '_reservation_read',
                'value' => '0',
            ),
        ),
        'fields'         => 'ids',
    ));
    
    $count = count($unread_count);
    
    if ($count > 0) {
        foreach ($menu as $key => $item) {
            if ($item[2] === 'edit.php?post_type=reservation') {
                $menu[$key][0] .= ' <span class="update-plugins count-' . $count . '" style="background: #d63638; color: white; border-radius: 10px; padding: 0 6px; margin-right: 5px;"><span class="plugin-count">' . $count . '</span></span>';
                break;
            }
        }
    }
}
add_action('admin_menu', 'alomran_food_reservation_menu_badge', 999);

/**
 * Add meta boxes for reservation details
 */
function alomran_food_reservation_meta_boxes() {
    add_meta_box(
        'reservation_details',
        __('تفاصيل الحجز', 'alomran'),
        'alomran_food_reservation_details_callback',
        'reservation',
        'normal',
        'high'
    );
    
    add_meta_box(
        'reservation_status',
        __('حالة الحجز', 'alomran'),
        'alomran_food_reservation_status_callback',
        'reservation',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'alomran_food_reservation_meta_boxes');

/**
 * Reservation details meta box callback
 */
function alomran_food_reservation_details_callback($post) {
    wp_nonce_field('alomran_food_reservation_meta', 'alomran_food_reservation_nonce');
    
    // Mark as read when viewing
    $read = get_post_meta($post->ID, '_reservation_read', true);
    if ($read !== '1') {
        update_post_meta($post->ID, '_reservation_read', '1');
        update_post_meta($post->ID, '_reservation_read_date', current_time('mysql'));
        update_post_meta($post->ID, '_reservation_read_by', get_current_user_id());
    }
    
    $branch_id = get_post_meta($post->ID, '_reservation_branch_id', true);
    $date = get_post_meta($post->ID, '_reservation_date', true);
    $time = get_post_meta($post->ID, '_reservation_time', true);
    $guests = get_post_meta($post->ID, '_reservation_guests', true);
    $name = get_post_meta($post->ID, '_reservation_name', true);
    $phone = get_post_meta($post->ID, '_reservation_phone', true);
    $email = get_post_meta($post->ID, '_reservation_email', true);
    $status = get_post_meta($post->ID, '_reservation_status', true) ?: 'pending';
    
    $branch_name = $branch_id ? get_the_title($branch_id) : __('غير محدد', 'alomran');
    ?>
    <table class="form-table">
        <tr>
            <th><label><?php _e('الفرع', 'alomran'); ?></label></th>
            <td>
                <?php if ($branch_id): ?>
                    <strong><?php echo esc_html($branch_name); ?></strong>
                    <a href="<?php echo esc_url(get_edit_post_link($branch_id)); ?>" class="button button-small" style="margin-right: 10px;"><?php _e('عرض الفرع', 'alomran'); ?></a>
                <?php else: ?>
                    <span class="description"><?php echo esc_html($branch_name); ?></span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label><?php _e('التاريخ', 'alomran'); ?></label></th>
            <td><strong><?php echo esc_html($date ? date_i18n('l، d F Y', strtotime($date)) : '-'); ?></strong></td>
        </tr>
        <tr>
            <th><label><?php _e('الوقت', 'alomran'); ?></label></th>
            <td><strong><?php echo esc_html($time ?: '-'); ?></strong></td>
        </tr>
        <tr>
            <th><label><?php _e('عدد الضيوف', 'alomran'); ?></label></th>
            <td><strong><?php echo esc_html($guests ?: '-'); ?></strong></td>
        </tr>
        <tr>
            <th><label><?php _e('الاسم', 'alomran'); ?></label></th>
            <td><strong><?php echo esc_html($name ?: '-'); ?></strong></td>
        </tr>
        <tr>
            <th><label><?php _e('رقم الجوال', 'alomran'); ?></label></th>
            <td>
                <strong><?php echo esc_html($phone ?: '-'); ?></strong>
                <?php if ($phone): ?>
                    <a href="tel:<?php echo esc_attr($phone); ?>" class="button button-small" style="margin-right: 10px;"><?php _e('اتصال', 'alomran'); ?></a>
                    <a href="https://wa.me/<?php echo esc_attr(preg_replace('/[^0-9]/', '', $phone)); ?>" target="_blank" class="button button-small"><?php _e('واتساب', 'alomran'); ?></a>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label><?php _e('البريد الإلكتروني', 'alomran'); ?></label></th>
            <td>
                <?php if ($email): ?>
                    <strong><?php echo esc_html($email); ?></strong>
                    <a href="mailto:<?php echo esc_attr($email); ?>" class="button button-small" style="margin-right: 10px;"><?php _e('إرسال بريد', 'alomran'); ?></a>
                <?php else: ?>
                    <span class="description">-</span>
                <?php endif; ?>
            </td>
        </tr>
        <tr>
            <th><label><?php _e('حالة الحجز', 'alomran'); ?></label></th>
            <td>
                <select name="reservation_status" id="reservation_status">
                    <option value="pending" <?php selected($status, 'pending'); ?>><?php _e('معلق', 'alomran'); ?></option>
                    <option value="confirmed" <?php selected($status, 'confirmed'); ?>><?php _e('مؤكد', 'alomran'); ?></option>
                    <option value="cancelled" <?php selected($status, 'cancelled'); ?>><?php _e('ملغي', 'alomran'); ?></option>
                    <option value="completed" <?php selected($status, 'completed'); ?>><?php _e('مكتمل', 'alomran'); ?></option>
                </select>
            </td>
        </tr>
    </table>
    <?php
}

/**
 * Reservation status meta box callback
 */
function alomran_food_reservation_status_callback($post) {
    $status = get_post_meta($post->ID, '_reservation_status', true) ?: 'pending';
    $created = get_post_time('U', true, $post->ID);
    $date = get_post_meta($post->ID, '_reservation_date', true);
    $time = get_post_meta($post->ID, '_reservation_time', true);
    
    $status_colors = array(
        'pending' => '#f59e0b',
        'confirmed' => '#10b981',
        'cancelled' => '#ef4444',
        'completed' => '#3b82f6',
    );
    
    $status_labels = array(
        'pending' => __('معلق', 'alomran'),
        'confirmed' => __('مؤكد', 'alomran'),
        'cancelled' => __('ملغي', 'alomran'),
        'completed' => __('مكتمل', 'alomran'),
    );
    ?>
    <div style="padding: 10px 0;">
        <p>
            <strong><?php _e('الحالة الحالية:', 'alomran'); ?></strong><br>
            <span style="display: inline-block; padding: 5px 15px; background: <?php echo esc_attr($status_colors[$status] ?? '#666'); ?>; color: white; border-radius: 4px; margin-top: 5px;">
                <?php echo esc_html($status_labels[$status] ?? $status); ?>
            </span>
        </p>
        <p>
            <strong><?php _e('تاريخ الإنشاء:', 'alomran'); ?></strong><br>
            <?php echo esc_html(date_i18n('d/m/Y H:i', $created)); ?>
        </p>
        <?php if ($date && $time): ?>
            <p>
                <strong><?php _e('تاريخ الحجز:', 'alomran'); ?></strong><br>
                <?php echo esc_html(date_i18n('d/m/Y', strtotime($date)) . ' ' . esc_html($time)); ?>
            </p>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Save reservation meta data
 */
function alomran_food_save_reservation_meta($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!isset($_POST['alomran_food_reservation_nonce']) || !wp_verify_nonce($_POST['alomran_food_reservation_nonce'], 'alomran_food_reservation_meta')) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    if (get_post_type($post_id) !== 'reservation') {
        return;
    }
    
    if (isset($_POST['reservation_status'])) {
        $status = sanitize_text_field($_POST['reservation_status']);
        $old_status = get_post_meta($post_id, '_reservation_status', true);
        
        update_post_meta($post_id, '_reservation_status', $status);
        
        // Send email notification if status changed to confirmed
        if ($status === 'confirmed' && $old_status !== 'confirmed') {
            $email = get_post_meta($post_id, '_reservation_email', true);
            $name = get_post_meta($post_id, '_reservation_name', true);
            $date = get_post_meta($post_id, '_reservation_date', true);
            $time = get_post_meta($post_id, '_reservation_time', true);
            
            if ($email && is_email($email)) {
                $subject = __('تأكيد حجزك في الجوهرة', 'alomran');
                $message = sprintf(
                    __('عزيزي/عزيزتي %s،

نود إعلامك بأن حجزك بتاريخ %s في الساعة %s قد تم تأكيده.

نحن نتطلع لاستقبالك في مطعم الجوهرة.

مع أطيب التحيات،
فريق الجوهرة', 'alomran'),
                    esc_html($name),
                    esc_html(date_i18n('d/m/Y', strtotime($date))),
                    esc_html($time)
                );
                
                wp_mail($email, $subject, $message);
            }
        }
    }
}
add_action('save_post', 'alomran_food_save_reservation_meta');

/**
 * Add custom columns to reservations list
 */
function alomran_food_reservation_columns($columns) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['title'] = __('الاسم', 'alomran');
    $new_columns['branch'] = __('الفرع', 'alomran');
    $new_columns['date_time'] = __('التاريخ والوقت', 'alomran');
    $new_columns['guests'] = __('عدد الضيوف', 'alomran');
    $new_columns['phone'] = __('الهاتف', 'alomran');
    $new_columns['status'] = __('الحالة', 'alomran');
    $new_columns['date'] = $columns['date'];
    
    return $new_columns;
}
add_filter('manage_reservation_posts_columns', 'alomran_food_reservation_columns');

/**
 * Populate custom columns
 */
function alomran_food_reservation_column_content($column, $post_id) {
    switch ($column) {
        case 'read_status':
            $read = get_post_meta($post_id, '_reservation_read', true);
            if ($read !== '1') {
                echo '<span class="dashicons dashicons-marker" style="color: #d63638;" title="' . __('غير مقروء', 'alomran') . '"></span>';
            } else {
                echo '<span class="dashicons dashicons-yes-alt" style="color: #10b981;" title="' . __('مقروء', 'alomran') . '"></span>';
            }
            break;
            
        case 'branch':
            $branch_id = get_post_meta($post_id, '_reservation_branch_id', true);
            if ($branch_id) {
                echo '<a href="' . esc_url(get_edit_post_link($branch_id)) . '">' . esc_html(get_the_title($branch_id)) . '</a>';
            } else {
                echo '<span class="description">-</span>';
            }
            break;
            
        case 'date_time':
            $date = get_post_meta($post_id, '_reservation_date', true);
            $time = get_post_meta($post_id, '_reservation_time', true);
            if ($date) {
                echo esc_html(date_i18n('d/m/Y', strtotime($date)));
                if ($time) {
                    echo ' <strong>' . esc_html($time) . '</strong>';
                }
            } else {
                echo '<span class="description">-</span>';
            }
            break;
            
        case 'guests':
            $guests = get_post_meta($post_id, '_reservation_guests', true);
            echo $guests ? esc_html($guests) : '<span class="description">-</span>';
            break;
            
        case 'phone':
            $phone = get_post_meta($post_id, '_reservation_phone', true);
            if ($phone) {
                echo '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>';
            } else {
                echo '<span class="description">-</span>';
            }
            break;
            
        case 'status':
            $status = get_post_meta($post_id, '_reservation_status', true) ?: 'pending';
            $status_colors = array(
                'pending' => '#f59e0b',
                'confirmed' => '#10b981',
                'cancelled' => '#ef4444',
                'completed' => '#3b82f6',
            );
            $status_labels = array(
                'pending' => __('معلق', 'alomran'),
                'confirmed' => __('مؤكد', 'alomran'),
                'cancelled' => __('ملغي', 'alomran'),
                'completed' => __('مكتمل', 'alomran'),
            );
            $color = $status_colors[$status] ?? '#666';
            $label = $status_labels[$status] ?? $status;
            echo '<span style="display: inline-block; padding: 3px 10px; background: ' . esc_attr($color) . '; color: white; border-radius: 4px; font-size: 11px;">' . esc_html($label) . '</span>';
            break;
    }
}
add_action('manage_reservation_posts_custom_column', 'alomran_food_reservation_column_content', 10, 2);

/**
 * Make columns sortable
 */
function alomran_food_reservation_sortable_columns($columns) {
    $columns['date_time'] = 'date_time';
    $columns['status'] = 'status';
    return $columns;
}
add_filter('manage_edit-reservation_sortable_columns', 'alomran_food_reservation_sortable_columns');

/**
 * Handle sorting
 */
function alomran_food_reservation_orderby($query) {
    if (!is_admin() || !$query->is_main_query()) {
        return;
    }
    
    if ('date_time' === $query->get('orderby')) {
        $query->set('meta_key', '_reservation_date');
        $query->set('orderby', 'meta_value');
    }
    
    if ('status' === $query->get('orderby')) {
        $query->set('meta_key', '_reservation_status');
        $query->set('orderby', 'meta_value');
    }
}
add_action('pre_get_posts', 'alomran_food_reservation_orderby');

/**
 * Add dashboard widget for reservations
 */
function alomran_food_reservation_dashboard_widget() {
    wp_add_dashboard_widget(
        'alomran_food_reservations_stats',
        __('إحصائيات الحجوزات', 'alomran'),
        'alomran_food_reservation_dashboard_widget_callback'
    );
}
add_action('wp_dashboard_setup', 'alomran_food_reservation_dashboard_widget');

/**
 * Dashboard widget callback
 */
function alomran_food_reservation_dashboard_widget_callback() {
    $today = date('Y-m-d');
    $pending = get_posts(array(
        'post_type' => 'reservation',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_reservation_status',
                'value' => 'pending',
            ),
        ),
        'fields' => 'ids',
    ));
    
    $today_reservations = get_posts(array(
        'post_type' => 'reservation',
        'posts_per_page' => -1,
        'meta_query' => array(
            array(
                'key' => '_reservation_date',
                'value' => $today,
            ),
        ),
        'fields' => 'ids',
    ));
    
    $total = wp_count_posts('reservation');
    ?>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px;">
        <div style="padding: 15px; background: #f0f0f0; border-radius: 5px;">
            <h3 style="margin: 0 0 10px 0; font-size: 24px; color: #333;"><?php echo esc_html($total->publish ?? 0); ?></h3>
            <p style="margin: 0; color: #666;"><?php _e('إجمالي الحجوزات', 'alomran'); ?></p>
        </div>
        <div style="padding: 15px; background: #fff3cd; border-radius: 5px;">
            <h3 style="margin: 0 0 10px 0; font-size: 24px; color: #856404;"><?php echo esc_html(count($pending)); ?></h3>
            <p style="margin: 0; color: #666;"><?php _e('حجوزات معلقة', 'alomran'); ?></p>
        </div>
        <div style="padding: 15px; background: #d1ecf1; border-radius: 5px;">
            <h3 style="margin: 0 0 10px 0; font-size: 24px; color: #0c5460;"><?php echo esc_html(count($today_reservations)); ?></h3>
            <p style="margin: 0; color: #666;"><?php _e('حجوزات اليوم', 'alomran'); ?></p>
        </div>
    </div>
    <p style="margin-top: 15px;">
        <a href="<?php echo esc_url(admin_url('edit.php?post_type=reservation')); ?>" class="button button-primary"><?php _e('عرض جميع الحجوزات', 'alomran'); ?></a>
    </p>
    <?php
}

