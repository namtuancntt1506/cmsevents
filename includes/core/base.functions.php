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
    if(get_post_type() == 'event'){
        $retval = true;
    }
    return $retval;
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
    if (get_post_type() == 'event') {
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
    if (get_post_type() == 'event') {
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