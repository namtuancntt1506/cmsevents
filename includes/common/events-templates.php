<?php

/**
 * Event Template Functions
 * 
 * @package CMS Event
 * @author Fox
 * @version 1.0.0
 */

/**
 * start datetime
 *
 * @param string $format
 *            = 'Y-m-d H:i:s'
 * @param string $before
 *            = ''
 * @param string $after
 *            = ''
 */
function the_cmsevent_start_datetime($format = 'Y-m-d H:i:s', $before = '', $after = '')
{
    global $post;
    $start_datetime = get_post_meta($post->ID, 'cmsevent_start_date', true);

    if ($start_datetime) {
        echo $before . date($format, $start_datetime) . $after;
    }
}

/**
 * end datetime
 *
 * @param string $format
 *            = 'Y-m-d H:i:s'
 * @param string $before
 *            = ''
 * @param string $after
 *            = ''
 */
function the_cmsevent_end_datetime($format = 'Y-m-d H:i:s', $before = '', $after = '')
{
    global $post;
    $start_datetime = get_post_meta($post->ID, 'cmsevent_end_date', true);
    
    if ($start_datetime) {
        echo $before . date($format, $start_datetime) . $after;
    }
}

/**
 * location
 * 
 * @param string $before            
 * @param string $after            
 */
function the_cmsevent_location($before = '', $after = '')
{
    echo $before . get_post_meta(get_the_ID(), 'cmsevent_location', true) . $after;
}

/**
 * address
 * 
 * @param string $before            
 * @param string $after            
 */
function the_cmsevent_address($before = '', $after = '')
{
    echo $before . get_post_meta(get_the_ID(), 'cmsevent_address', true) . $after;
}

/**
 * city
 * 
 * @param string $before            
 * @param string $after            
 */
function the_cmsevent_city($before = '', $after = '')
{
    echo $before . get_post_meta(get_the_ID(), 'cmsevent_city', true) . $after;
}

/**
 * state
 * 
 * @param string $before            
 * @param string $after            
 */
function the_cmsevent_state($before = '', $after = '')
{
    echo $before . get_post_meta(get_the_ID(), 'cmsevent_state', true) . $after;
}

/**
 * postcode
 * 
 * @param string $before            
 * @param string $after            
 */
function the_cmsevent_postcode($before = '', $after = '')
{
    echo $before . get_post_meta(get_the_ID(), 'cmsevent_postcode', true) . $after;
}

/**
 * region
 * 
 * @param string $before            
 * @param string $after            
 */
function the_cmsevent_region($before = '', $after = '')
{
    echo $before . get_post_meta(get_the_ID(), 'cmsevent_region', true) . $after;
}

/**
 * country
 * 
 * @param string $before            
 * @param string $after            
 */
function the_cmsevent_country($before = '', $after = '')
{
    echo $before . get_post_meta(get_the_ID(), 'cmsevent_country', true) . $after;
}