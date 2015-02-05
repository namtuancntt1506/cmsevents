<?php
/**
 * @package CMS Event
 * @version 1.0.0
 */
//**********************************Base*************************************/

/**
 * Is CmsEvents
 * @return boolean
 */
function is_cmsevents(){
    // Defalt to false
    $retval = false;
    if(get_post_type() == 'events'){
        $retval = true;
    }
    return $retval;
}
//**********************************Event Data*************************************/
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
//******************************Template**********************************/
/**
 * Archive Template
 * @param unknown $template
 * @return string|unknown
 */
add_filter('archive_template', 'get_event_archive_template');

function get_event_archive_template($template)
{
    if (get_post_type() == 'events') {
        $new_template = locate_template('cmsevents/content-archive.php');
        if ('' != $new_template) {
            return $new_template;
        } else {
            return CMSEVENTS_DIR . 'templates/default/cmsevents/content-archive.php';
        }
    }
    return $template;
}
/**
 * Single Template
 * @param unknown $template
 * @return string|unknown
 */
add_filter('single_template', 'get_event_single_template');

function get_event_single_template($template)
{
    if (get_post_type() == 'events') {
        $new_template = locate_template('cmsevents/content-single.php');
        if ('' != $new_template) {
            return $new_template;
        } else {
            return CMSEVENTS_DIR . 'templates/default/cmsevents/content-single.php';
        }
    }
    return $template;
}
/**
 * Get template
 * @param string $slug
 * @param string $name
 */
function cmsevent_get_template_part($slug = '', $name = ''){
    global $posts, $post, $wp_did_header, $wp_query, $wp_rewrite, $wpdb, $wp_version, $wp, $id, $comment, $user_ID;
    if($slug){
        if(!empty($name)){ $name = "-".$name;}
        $new_template = locate_template("cmsevents/{$slug}{$name}.php");
        if ('' == $new_template) {
            $new_template = CMSEVENTS_DIR . "templates/default/cmsevents/{$slug}{$name}.php";
        }
        if(file_exists($new_template)){
            require $new_template;
        }
    }
}