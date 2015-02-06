<?php
/**
 * Add Posttype Event
 * @author Fox
 * @version 1.0.0
 */

/**
 * Load Scripts
 */
add_action( 'admin_enqueue_scripts', 'add_post_type_script' );

function add_post_type_script(){
    $screen = get_current_screen();
    if($screen->post_type == 'events'){
        wp_enqueue_style('datetimepicker', CMSEVENTS_URL . 'assets/css/jquery.datetimepicker.css');
        wp_enqueue_style('easytabs', CMSEVENTS_URL . 'assets/css/jquery.easytabs.css');
        
        wp_enqueue_script('datetimepicker', CMSEVENTS_URL . 'assets/libs/jquery.datetimepicker.js');
        wp_enqueue_script('easytabs', CMSEVENTS_URL . 'assets/libs/jquery.easytabs.min.js');
        wp_enqueue_script('cmsevents.item', CMSEVENTS_URL . 'assets/js/cmsevents.item.js');
    }
}
/**
 * Add post type
 */
add_action('init', 'add_post_type_event');

function add_post_type_event()
{
    /**
     * Event Posttype
     */
    $labels = array(
        'name' => __('CMS Events', CMSEVENTS_NAME),
        'singular_name' => __('CMS Event', CMSEVENTS_NAME),
        'add_new' => __('Add New', CMSEVENTS_NAME),
        'add_new_item' => __('Add New Event', CMSEVENTS_NAME),
        'edit_item' => __('Edit Event', CMSEVENTS_NAME),
        'new_item' => __('New Event', CMSEVENTS_NAME),
        'all_items' => __('Event', CMSEVENTS_NAME),
        'view_item' => __('View Event', CMSEVENTS_NAME),
        'search_items' => __('Search Event', CMSEVENTS_NAME),
        'not_found' => __('No event found', CMSEVENTS_NAME),
        'not_found_in_trash' => __('No event found in Trash', CMSEVENTS_NAME),
        'parent_item_colon' => "",
        'menu_name' => __('CMS Events', CMSEVENTS_NAME)
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'events'
        ),
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 10,
        'menu_icon' => 'dashicons-clock',
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail',
            'excerpt',
            'comments'
        )
    );
    register_post_type('events', $args);
    /**
     * Event Taxonomy
     */
    register_taxonomy('events_category', 'events', array(
        'hierarchical' => true,
        'label' => __('Event Categories', CMSEVENTS_NAME),
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'events'
        )
    ));
    /**
     * Event Tags
     */
    $labels = array(
        'name' => __('Event Tags', 'taxonomy general name', CMSEVENTS_NAME),
        'singular_name' => __('Tag', 'taxonomy singular name', CMSEVENTS_NAME),
        'search_items' => __('Search Tags', CMSEVENTS_NAME),
        'popular_items' => __('Popular Tags', CMSEVENTS_NAME),
        'all_items' => __('All Tags', CMSEVENTS_NAME),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Tag', CMSEVENTS_NAME),
        'update_item' => __('Update Tag', CMSEVENTS_NAME),
        'add_new_item' => __('Add New Tag', CMSEVENTS_NAME),
        'new_item_name' => __('New Tag Name', CMSEVENTS_NAME),
        'separate_items_with_commas' => __('Separate tags with commas', CMSEVENTS_NAME),
        'add_or_remove_items' => __('Add or remove tags', CMSEVENTS_NAME),
        'choose_from_most_used' => __('Choose from the most used tags', CMSEVENTS_NAME),
        'menu_name' => __('Event Tags', CMSEVENTS_NAME)
    );
    
    register_taxonomy('event_tag', 'events', array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array(
            'slug' => 'tag'
        )
    ));
}
/**
 * Add Event Category Filter
 */
add_action('restrict_manage_posts', 'restrict_listings_by_events');
add_filter('parse_query', 'convert_events_id_to_taxonomy_term_in_query');

function restrict_listings_by_events()
{
    global $typenow;
    global $wp_query;
    if ($typenow == 'events') {
        $taxonomy = 'events_category';
        $term = isset($wp_query->query['events_category']) ? $wp_query->query['events_category'] : '';
        $business_taxonomy = get_taxonomy($taxonomy);
        wp_dropdown_categories(array(
            'show_option_all' => __("Show All", CMSEVENTS_NAME),
            'taxonomy' => $taxonomy,
            'name' => 'events_category',
            'orderby' => 'name',
            'selected' => $term,
            'hierarchical' => true,
            'depth' => 3,
            'show_count' => true,
            'hide_empty' => true
        ));
    }
}

function convert_events_id_to_taxonomy_term_in_query($query)
{
    global $pagenow;
    $qv = &$query->query_vars;
    if ($pagenow == 'edit.php' && isset($qv['events_category']) && is_numeric($qv['events_category'])) {
        $term = get_term_by('id', $qv['events_category'], 'events_category');
        $qv['events_category'] = ($term ? $term->slug : '');
    }
}
/**
 * Add Collumn To Table
 */
add_filter('manage_edit-events_columns', 'set_custom_events_columns');
add_action('manage_events_posts_custom_column', 'custom_events_column', 10, 2);

function set_custom_events_columns($columns)
{
    $columns['event_date'] = __('Events Date', CMSEVENTS_NAME);
    $columns['event_booking'] = __('Events Booking', CMSEVENTS_NAME);
    return $columns;
}

function custom_events_column($column, $post_id)
{
    $event_data = get_event_data($post_id);
    switch ($column) {
        case 'event_date':
            echo "Start: {$event_data->start_date}</br> End: {$event_data->end_date}";
            break;
    }
}
/**
 * Meta Box
 */
add_action('add_meta_boxes','event_meta_boxes');

function event_meta_boxes() {
    add_meta_box('event_date', __('Event Options', CMSEVENTS_NAME), 'event_meta_boxes_content', 'events', 'side', 'high');
}

function event_meta_boxes_content(){
    global $post;
    $event_data = get_event_data($post->ID);
    $start_date = !empty($event_data->start_date) ? $event_data->start_date : date_i18n('Y-m-d H:i') ;
    $end_date = !empty($event_data->end_date) ?  $event_data->end_date : '';
    
    $cmsevent_start_date = get_post_meta($post->ID, 'cmsevent_start_date', true);
    $cmsevent_end_date = get_post_meta($post->ID, 'cmsevent_end_date', true);
    $cmsevent_no_location = get_post_meta($post->ID, 'cmsevent_no_location', true);
    
    $cmsevent_location = get_post_meta($post->ID, 'cmsevent_location', true);
    $cmsevent_address = get_post_meta($post->ID, 'cmsevent_address', true);
    $cmsevent_city = get_post_meta($post->ID, 'cmsevent_city', true);
    $cmsevent_state = get_post_meta($post->ID, 'cmsevent_state', true);
    $cmsevent_postcode = get_post_meta($post->ID, 'cmsevent_postcode', true);
    $cmsevent_region = get_post_meta($post->ID, 'cmsevent_region', true);
    $cmsevent_country = get_post_meta($post->ID, 'cmsevent_country', true);
    
    
    if(empty($start_date)){ $start_date = date('Y-m-d'); }
    ?>
    <div class="easytabs">
        <ul class="category-tabs">
            <li class=""><i class="dashicons dashicons-calendar"></i> <a href="#events_date"><?php _e('When' , CMSEVENTS_NAME); ?></a></li>
            <li class=""><i class="dashicons dashicons-post-status"></i> <a href="#events_local"><?php _e('Where' , CMSEVENTS_NAME); ?></a></li>
        </ul>
        <div id="events_date" class="tabs-panel">
            <ul>
                <li>
                    <label for="cmsevent_start_date"><?php _e('Start Date', CMSEVENTS_NAME); ?></label>
                    <input id="cmsevent_start_date" name="cmsevent_start_date" type="text" class="newtag form-input-tip input-datetime" value="<?php echo esc_attr($start_date); ?>"/>
                </li>
                <li>
                    <label for="cmsevent_end_date"><?php _e('End Date', CMSEVENTS_NAME); ?></label>
                    <input id="cmsevent_end_date" name="cmsevent_end_date" type="text" class="newtag form-input-tip input-datetime" value="<?php echo esc_attr($end_date); ?>"/>
                </li>
            </ul>
        </div>
        <div id="events_local" class="tabs-panel">
            <ul>
                <li>
                    <label for="cmsevent_no_location"><?php _e('This event does not have a physical location.', CMSEVENTS_NAME); ?></label></br>
                    <input id="cmsevent_no_location" name="cmsevent_no_location" type="checkbox" class="newtag form-input-tip" <?php echo $cmsevent_no_location ? 'checked="checked"' : '' ; ?>/>
                </li>
            </ul>
            <ul id="events_location">
                <li>
                    <label for="cmsevent_location"><?php _e('Location Name *', CMSEVENTS_NAME); ?></label></br>
                    <input id="cmsevent_location" name="cmsevent_location" type="text" class="newtag form-input-tip" value="<?php echo esc_attr($cmsevent_location); ?>"/>
                </li>
                <li>
                    <label for="cmsevent_address"><?php _e('Address *', CMSEVENTS_NAME); ?></label></br>
                    <input id="cmsevent_address" name="cmsevent_address" type="text" class="newtag form-input-tip" value="<?php echo esc_attr($cmsevent_address); ?>"/>
                </li>
                <li>
                    <label for="cmsevent_city"><?php _e('City/Town *', CMSEVENTS_NAME); ?></label></br>
                    <input id="cmsevent_city" name="cmsevent_city" type="text" class="newtag form-input-tip" value="<?php echo esc_attr($cmsevent_city); ?>"/>
                </li>
                <li>
                    <label for="cmsevent_state"><?php _e('State/County', CMSEVENTS_NAME); ?></label></br>
                    <input id="cmsevent_state" name="cmsevent_state" type="text" class="newtag form-input-tip" value="<?php echo esc_attr($cmsevent_state); ?>"/>
                </li>
                <li>
                    <label for="cmsevent_postcode"><?php _e('Postcode', CMSEVENTS_NAME); ?></label></br>
                    <input id="cmsevent_postcode" name="cmsevent_postcode" type="text" class="newtag form-input-tip" value="<?php echo esc_attr($cmsevent_postcode); ?>"/>
                </li>
                <li>
                    <label for="cmsevent_region"><?php _e('Region', CMSEVENTS_NAME); ?></label></br>
                    <input id="cmsevent_region" name="cmsevent_region" type="text" class="newtag form-input-tip" value="<?php echo esc_attr($cmsevent_region); ?>"/>
                </li>
                <li>
                    <label for="cmsevent_country"><?php _e('Country', CMSEVENTS_NAME); ?></label></br>
                    <input id="cmsevent_country" name="cmsevent_country" type="text" class="newtag form-input-tip" value="<?php echo esc_attr($cmsevent_country); ?>"/>
                </li>
            </ul>
        </div>
    </div>
    <?php
}
/**
 * Action Save Event
 */
add_action('save_post','events_save_data');
add_action('before_delete_post', 'events_delete_data');

function events_save_data($post_id) {
    global $wpdb;
    
    if(isset($_POST['cmsevent_start_date'])){
        $start_date = $_POST['cmsevent_start_date'];
    }
    if(isset($_POST['cmsevent_end_date'])){
        $end_date = $_POST['cmsevent_end_date'];
    }
    $_post_id = $wpdb->get_var("SELECT e.post_id FROM {$wpdb->prefix}events as e WHERE e.post_id= {$post_id}");
    
    if(isset($start_date) || isset($end_date)){
        update_post_meta($post_id, 'cmsevent_start_date', date('U',strtotime($_POST['cmsevent_start_date'])));
        update_post_meta($post_id, 'cmsevent_end_date', date('U',strtotime($_POST['cmsevent_end_date'])));
        /* update meta */
        if($_POST['cmsevent_no_location'] != 'on' && !empty($_POST['cmsevent_location']) && !empty($_POST['cmsevent_address']) && !empty($_POST['cmsevent_city'])){
            update_post_meta($post_id, 'cmsevent_no_location', $_POST['cmsevent_no_location']);
            update_post_meta($post_id, 'cmsevent_location', $_POST['cmsevent_location']);
            update_post_meta($post_id, 'cmsevent_address', $_POST['cmsevent_address']);
            update_post_meta($post_id, 'cmsevent_city', $_POST['cmsevent_city']);
            update_post_meta($post_id, 'cmsevent_state', $_POST['cmsevent_state']);
            update_post_meta($post_id, 'cmsevent_postcode', $_POST['cmsevent_postcode']);
            update_post_meta($post_id, 'cmsevent_region', $_POST['cmsevent_region']);
            update_post_meta($post_id, 'cmsevent_country', $_POST['cmsevent_country']);
        }
    }
}

function events_delete_data($post_id){
    global $wpdb;
    $wpdb->delete( $wpdb->prefix.'events', array('post_id'=>$post_id));
}