<?php
vc_map(array(
    "name" => __('Tour Filter', TOURISTTRAVEL_NAME),
    "base" => "touristtravel-find-tour",
    "icon" => "cs_icon_for_vc",
    "category" => __('TouristTravel', TOURISTTRAVEL_NAME),
    "description" => __('Tools Find Tour', TOURISTTRAVEL_NAME),
    "params" => array(
        array(
            "type" => "pro_taxonomy",
            "taxonomy" => "product_cat",
            "heading" => __('Category', TOURISTTRAVEL_NAME),
            "param_name" => "cats",
            "description" => __('Select Category for Tour Items', TOURISTTRAVEL_NAME)
        ),
        array(
            "type" => "textfield",
            "heading" => __('Collums', TOURISTTRAVEL_NAME),
            "param_name" => "col",
            "description" => __('Set (1 -> 4) Collums Default (3)', TOURISTTRAVEL_NAME)
        ),
        array(
            "type" => "textfield",
            "heading" => __('Date Format', TOURISTTRAVEL_NAME),
            "param_name" => "dateformat",
            "description" => __('Y/m/d', TOURISTTRAVEL_NAME)
        ),
    )
));
