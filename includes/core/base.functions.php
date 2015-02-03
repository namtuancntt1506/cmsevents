<?php
/**
 * @package CMS Event
 * @version 1.0.0
 */

//***********************************************************************/
/**
 * Get Event Data
 * @param unknown $post_id
 * @return mixed
 */
function get_event_data($post_id) {
    global $wpdb;
    return $wpdb->get_row("SELECT * FROM {$wpdb->prefix}events WHERE post_id = {$post_id}");
}
/**
 * Get Event Start Date
 * @param unknown $post_id
 * @return Ambigous <string, NULL>
 */
function get_event_start_date_time($post_id) {
    global $wpdb;
    return $wpdb->get_var("SELECT start_date FROM {$wpdb->prefix}events WHERE post_id = {$post_id}");
}
/**
 * Get Event End Date
 * @param unknown $post_id
 * @return Ambigous <string, NULL>
 */
function get_event_end_date_time($post_id) {
    global $wpdb;
    return $wpdb->get_var("SELECT end_date FROM {$wpdb->prefix}events WHERE post_id = {$post_id}");
}