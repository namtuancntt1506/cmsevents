<?php
/**
 * Add Posttype Event
 * @author Fox
 * @version 1.0.0
 */
add_action('init', 'add_post_type_event');

function add_post_type_event()
{
    /**
     * Event Posttype
     */
    $labels = array(
        'name' => __('CMS Events', CSCORE_NAME),
        'singular_name' => __('CMS Event', CSCORE_NAME),
        'add_new' => __('Add New', CSCORE_NAME),
        'add_new_item' => __('Add New Event', CSCORE_NAME),
        'edit_item' => __('Edit Event', CSCORE_NAME),
        'new_item' => __('New Event', CSCORE_NAME),
        'all_items' => __('Event', CSCORE_NAME),
        'view_item' => __('View Event', CSCORE_NAME),
        'search_items' => __('Search Event', CSCORE_NAME),
        'not_found' => __('No event found', CSCORE_NAME),
        'not_found_in_trash' => __('No event found in Trash', CSCORE_NAME),
        'parent_item_colon' => "",
        'menu_name' => __('CMS Events', CSCORE_NAME)
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
        'menu_icon' => 'dashicons-calendar-alt',
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
        'label' => __('Event Categories', CSCORE_NAME),
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
        'name' => __('Event Tags', 'taxonomy general name', CSCORE_NAME),
        'singular_name' => __('Tag', 'taxonomy singular name', CSCORE_NAME),
        'search_items' => __('Search Tags', CSCORE_NAME),
        'popular_items' => __('Popular Tags', CSCORE_NAME),
        'all_items' => __('All Tags', CSCORE_NAME),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __('Edit Tag', CSCORE_NAME),
        'update_item' => __('Update Tag', CSCORE_NAME),
        'add_new_item' => __('Add New Tag', CSCORE_NAME),
        'new_item_name' => __('New Tag Name', CSCORE_NAME),
        'separate_items_with_commas' => __('Separate tags with commas', CSCORE_NAME),
        'add_or_remove_items' => __('Add or remove tags', CSCORE_NAME),
        'choose_from_most_used' => __('Choose from the most used tags', CSCORE_NAME),
        'menu_name' => __('Event Tags', CSCORE_NAME)
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
            'show_option_all' => __("Show All", CSCORE_NAME),
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
    $columns['start_date'] = __('Starts Date', CSCORE_NAME);
    $columns['end_date'] = __('End Date', CSCORE_NAME);
    return $columns;
}

function custom_events_column($column, $post_id)
{
    switch ($column) {
        case 'start_date':
            echo get_post_meta($post_id, 'cs_start_date', true);
            break;
        case 'end_date':
            echo get_post_meta($post_id, 'cs_end_date', true);
            break;
    }
}
/**
 * Action Save Event
 */
