<?php

/**
 * The CMS Events Plugin
 * @package CMS Events
 * @subpackage Main
 * @link https://github.com/vianhtu/cmsevents
 */

/**
 * Plugin Name: CMS Events
 * Plugin URI: http://cmssuperheroes.com
 * Description: CMS Events is software with a twist from the creators of WordPress.
 * Author: The CMS Events Community
 * Author URI: http://cmssuperheroes.com
 * Version: 1.0.0
 * Text Domain: cmsevents
 * Domain Path: /languages/
 */
if (! defined('ABSPATH')) {
    exit(); // Exit if accessed directly
}
define('CMSEVENTS_NAME', 'cmsevents');
define('CMSEVENTS_URL', plugin_dir_url(__FILE__));
define('CMSEVENTS_DIR', plugin_dir_path(__FILE__));

if (! class_exists('CMSEvents')) :
    
    final class CMSEvents
    {

        function __construct()
        {
            $this->includes_dir = CMSEVENTS_DIR . 'includes/';
            /* includes file */
            $this->includes();
            /* activation install table */
            register_activation_hook(__FILE__, array(
                $this,
                'table_install'
            ));
        }

        /**
         * includes file.
         */
        private function includes()
        {
            if(is_admin()){
            
            } else {
                require $this->includes_dir . 'common/events-templates.php';
            }
            // admin options /
            require $this->includes_dir . 'admin/admin.options.php';
            // common functions /
            require $this->includes_dir . 'common/events-postype.php';
            // base functions /
            require $this->includes_dir . 'core/base.functions.php';
        }
        /**
         * Create Table.
         */
        function table_install()
        {
            global $wpdb;
            
            $charset_collate = '';
            
            if (! empty($wpdb->charset)) {
                $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
            }
            
            if (! empty($wpdb->collate)) {
                $charset_collate .= " COLLATE {$wpdb->collate}";
            }
            require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
            /**
             * table auto_evanto
             */
            $table_name = $wpdb->prefix . 'events';
            if ($wpdb->get_var("SHOW TABLES LIKE '" . $table_name . "'") !== $table_name) {
                
                $sql = "CREATE TABLE $table_name (
                id mediumint(9) NOT NULL AUTO_INCREMENT,
                post_id mediumint(9) NOT NULL,
                start_date datetime,
                end_date datetime,
                UNIQUE KEY id (id)
                ) $charset_collate;";
                
                dbDelta($sql);
            }
        }
    }
    new CMSEvents();

endif;
