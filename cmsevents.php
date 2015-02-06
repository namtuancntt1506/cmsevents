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
    }
    new CMSEvents();

endif;
