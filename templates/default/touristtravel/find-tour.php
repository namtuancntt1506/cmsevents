<?php
global $touristtravel; $rows = 0;
?>
<div class="touristtravel" data-format="<?php echo esc_attr($touristtravel->dateformat); ?>">
    <div class="touristtravel-find-wrap">
        <div class="touristtravel-find row">
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label><?php _e('DESTINATION', TOURISTTRAVEL_NAME); ?></label>
                    <input type="text" class="keyword" placeholder="<?php _e('CITY, REGION OR KEYWORD', TOURISTTRAVEL_NAME); ?>">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label><?php _e('DATE', TOURISTTRAVEL_NAME); ?></label>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 calendar">
                            <input type="text" class="date start-date" placeholder="<?php _e('DEPARTURE', TOURISTTRAVEL_NAME); ?>"><i class="fa fa-calendar"></i>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 calendar">
                            <input type="text" class="date end-date" placeholder="<?php _e('ARRIVAL', TOURISTTRAVEL_NAME); ?>"><i class="fa fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label><?php _e('MAX BUDGETS', TOURISTTRAVEL_NAME); ?></label>
                    <input type="text" class="budgets" placeholder="<?php _e('USD EX.100', TOURISTTRAVEL_NAME); ?>">
                </div>
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <label>&nbsp;</label>
                    <button class="search btn btn-block"><?php _e('SEARCH', TOURISTTRAVEL_NAME); ?></button></li>
                </div>
            </div>
        </div>
    </div>
    <div class="touristtravel-intro-wrap">
        <div class="touristtravel-intro text-center">
            <h3><span><?php _e('CHEAP OFFERS', TOURISTTRAVEL_NAME); ?></span></h3>
            <span><?php _e('check out our best promotion tours', TOURISTTRAVEL_NAME); ?></span>
        </div>
        <div class="touristtravel-content">
            <div class="content">
                <?php foreach ($touristtravel->items as $item): $rows++;
                $tour_day = get_post_meta($item->ID,'_touristtravel_days',true);
                $product = new WC_Product($item->ID);
                if($rows % $touristtravel->col == 1){
                    echo '<div class="row">';
                } ?>           
                <div class="item <?php echo esc_attr($touristtravel->_col); ?>">
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
                <?php if($rows % $touristtravel->col == 0 || $rows == $touristtravel->items_count){
                    echo '</div>';
                } endforeach; ?>
            </div>
            <div class="loading" style="display: none"></div>
        </div>
    </div>
</div>