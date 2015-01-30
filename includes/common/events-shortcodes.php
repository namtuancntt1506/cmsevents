<?php
add_shortcode('touristtravel-find-tour', 'touristtravel_find_tour');

function touristtravel_find_tour($params, $content)
{
    global $touristtravel;
    $touristtravel = new stdClass();
    extract(shortcode_atts(array(
        'cats' => '',
        'dateformat' => '',
    ), $params));
    $col = get_option('_tt_column', 3);
    
    $items = touristtravel_find_tour_data($cats,'','','','', get_option('_tt_items', 6));
    $touristtravel->items = $items;
    $touristtravel->col = $col;
    $touristtravel->dateformat = $dateformat;
    $touristtravel->items_count = count($items);
    
    wp_enqueue_style('jquery.datetimepicker', TOURISTTRAVEL_URL . 'assets/css/jquery.datetimepicker.css');
    wp_enqueue_script('jquery.datetimepicker', TOURISTTRAVEL_URL . 'assets/libs/jquery.datetimepicker.js');
    
    wp_enqueue_style('touristravel', TOURISTTRAVEL_URL . 'templates/default/css/touristravel.css');
    wp_register_script('touristravel', TOURISTTRAVEL_URL . 'templates/default/js/touristravel.js');
    wp_localize_script('touristravel','adminajax',array('ajax_url'=>admin_url('admin-ajax.php')));
    wp_enqueue_script('touristravel');
    
    /**
     * col
     */
    $_col = '';
    switch ($col) {
        case '1':
            $_col = 'col-xs-12 col-sm-12 col-md-12 col-lg-12';
            break;
        case '2':
            $_col = 'col-xs-12 col-sm-6 col-md-6 col-lg-6';
            break;
        case '3':
            $_col = 'col-xs-12 col-sm-4 col-md-4 col-lg-4';
            break;
        case '4':
            $_col = 'col-xs-12 col-sm-3 col-md-3 col-lg-3';
            break;
    }
    $touristtravel->_col = $_col;
    ob_start();
    touristtravel_locate_template('find', 'tour');
    return ob_get_clean();
}