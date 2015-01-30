<?php
add_action('wp_ajax_touristtravel_search', 'touristtravel_search_callback');
function touristtravel_search_callback() {
    $data = $_REQUEST['data'];
    $col = get_option('_tt_column', 3) ; $rows = 0; 
    $data_search = touristtravel_find_tour_data('', $data['keyword'], $data['start_date'], $data['end_date'], $data['budgets'], get_option('_tt_items', 6));
    $items_count = count($data_search);
    
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
    ob_start();
    foreach ($data_search as $item): $rows++;
    $tour_day = get_post_meta($item->ID,'_touristtravel_days',true);
    $product = new WC_Product($item->ID);
    
    if($rows % $col == 1){
        echo '<div class="row">';
    } ?>           
    <div class="item <?php echo $_col; ?>">
        <div class="tour-image">
            <?php echo $product->get_image('full'); ?>
            <div class="overlay">
                <div class="overlay-content">
                    <a href="<?php echo wp_get_attachment_url($product->get_image_id()); ?>" class="colorbox"><i class="fa fa-search"></i></a>
                </div>
            </div>
        </div>
        <div class="tour-content">
            <div class="tour-info">
                <span class="right"><?php echo esc_attr($tour_day); ?> <?php _e('DAYS', TOURISTTRAVEL_NAME); ?></span>
                <?php echo $product->get_categories(', '); ?>
            </div>
            <div class="tour-title">
                <a href="<?php echo $product->get_permalink(); ?>">
                    <span class="right"><?php echo $product->get_price_html(); ?></span>
                    <?php echo $product->get_title(); ?>
                    
                </a>
            </div>
        </div>
    </div>
    <?php if($rows % $col == 0 || $rows == $items_count){
        echo '</div>';
    } endforeach;
    
    echo ob_get_clean();
    exit();
}
/**
 * Query
 * @param string $cats
 * @param string $keywork
 * @param string $start
 * @param string $end
 * @param string $max
 * @param string $limit
 * @return boolean
 */
function touristtravel_find_tour_data($cats = '', $keyword = '', $start = '', $end = '', $max = '', $limit = '6'){
    global $wpdb;
    
    $start = $start ? date('Y-m-d',strtotime($start)) : '' ;
    $end = $end ? date('Y-m-d',strtotime($end)) : '' ;
    
    $prefix = $wpdb->prefix;
    $query = "SELECT DISTINCT p.ID FROM {$prefix}posts as p, {$prefix}touristtravel as ti";
    $query .= ($keyword || $cats) ? ",{$prefix}terms as t, {$prefix}term_relationships as tr, {$prefix}term_taxonomy as tt" : '';
    $query .= " WHERE p.post_type = 'product' AND p.post_status = 'publish' AND p.ID = ti.post_id";
    $query .= ($keyword || $cats) ? " AND p.ID = tr.object_id AND t.term_id = tt.term_id AND tt.term_taxonomy_id = tr.term_taxonomy_id" : '';
    /* select taxs */
    $query .= $cats ? " AND t.term_id IN ({$cats})" : '' ;
    /* find */
    $query .= $start ? " AND ti.startdate >= '{$start}'" : '' ;
    $query .= $end ? " AND ti.startdate <= '{$end}'" : '' ;
    $query .= $max ? " AND ti.budgets <= {$max}" : '' ;
    /* search */
    $query .= $keyword ? " AND (p.post_title LIKE '%{$keyword}%' OR t.name LIKE '%{$keyword}%' OR ti.location LIKE '%{$keyword}%' OR ti.address LIKE '%{$keyword}%' OR ti.city LIKE '%{$keyword}%' OR ti.state LIKE '%{$keyword}%')" : '';
    /* order */
    $query .= " ORDER BY ti.startdate ASC LIMIT {$limit}";
    
    return $wpdb->get_results($query, OBJECT);
}
/**
 * Get template file.
 * @param unknown $param
 */
function touristtravel_locate_template($file, $name) {
    $theme_template_dir = get_template_directory().'/touristtravel/'.$file.'-'.$name.'.php';
    $plugin_template_dir = TOURISTTRAVEL_DIR.'templates/default/touristtravel/'.$file.'-'.$name.'.php';
    if(file_exists($theme_template_dir)){
        require $theme_template_dir;
    } else {
        require $plugin_template_dir;
    }
}
/**
 * Get meta data
 */
function touristtravel_get_metadata($id) {
    global $wpdb;
    return $wpdb->get_row("SELECT * FROM {$wpdb->prefix}touristtravel as ti WHERE ti.post_id = {$id}", ARRAY_A);
}