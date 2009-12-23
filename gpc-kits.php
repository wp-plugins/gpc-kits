<?php
/*
Plugin Name: GPC Kits
Description: Install the kits for development with GPC plugins
Version: 0.1
Author: gpc
*/

/**
 * Version of WordPress
 * @since
 * @global    string    $wp_version
 *
 */

global $wp_version;

$exit_msg = __('This plugin require WordPress 2.8.4 or newer','gpc-kits').'. <a href="http://codex.wordpress.org/Upgrading_WordPress">'.__('Please update','gpc-kits').'</a>';
  
if (version_compare($wp_version, "2.8.4", "<")) {
	exit($exit_msg);
}

// Avoid name collisions.
if (!class_exists('GpcKits'))
{
	class GpcKits
    {
       /**
	    * The url to the plugin
	    *
	    * @static 
	    * @var string
	    */
        static $plugin_url;
         
       /**
	    * The path to the plugin
	    *
	    * @static 
	    * @var string
	    */
        static $plugin_dir;
         
       /**
	    * The descriptive name for plugin
	    *
	    * @var string
	    */
        static $plugin_desc_name;
        
       /**
	    * The prefix for tables in the DB
	    *
	    * @var string
	    */
        static $db_prefix = 'gpc_kits_';
        
       /**
         * Executes all initialization code for the plugin.
         * 
         * @return void
         * @access public
		 */
        function GpcKits(){
        	// Define static values
        	self::$plugin_url = trailingslashit( WP_PLUGIN_URL.'/'. dirname( plugin_basename(__FILE__) ));
        	self::$plugin_dir = pathinfo(__FILE__,PATHINFO_DIRNAME);
        	self::$plugin_desc_name = __('GPC development Kits','gpc-kits');
        	
        	// Include all classes
        	include( self::$plugin_dir . '/includes/all_classes.php');
        	
			// Translations for plugin
			$this->handle_load_domain();
			
			// Store cookies pending to save
			GpcKits_Cookies::save_cookies_pending_to_save();
        }
        
	    /**
		 * Handles the instalation code of the plugin. Executed only one time
		 * 
		 * @global $wpdb used to access to WordPress Object that manage DB
		 * @return void
		 * @access public
		 */
        function install()
        {
        	// Creating tables
			include('db/tables.php');
        }
        
        /**
		 * Handles the uninstall code of the plugin. Executed only one time
		 * 
		 * @return void
		 * @access public
		 */
        function uninstall()
        {
        	// For now nothing in unistall, because we don't want user lose the data. 
        }
        
    	/**
         * Add html code inside the tag <head> of the admin pages.
         * 
         * @return void
         * @access public
		 */
        function add_admin_header() {
        }
		
    	/**
         * Add html code inside the tag <head> of the user pages.
         * 
         * @return void
         * @access public
		 */
        function add_wp_head() {
        }
		
     	/**
         * Handles the translation of plugin
         * 
         * @return void
         * @access public
		 */
        function handle_load_domain()
		{
			$plugin_domain = 'gpc-kits';
			
			// TODO: define how client want get this value
			$locale = 'de_DE';
				
			if ($locale!='')
			{
				// locate translation file
				$mofile = WP_PLUGIN_DIR.'/'.plugin_basename(dirname
				(__FILE__)).'/lang/' . $plugin_domain . '-' .
				$locale . '.mo';
				// load translation
				load_textdomain($plugin_domain, $mofile);
			}
		}		
	}
}

// create new instance of the class
$GpcKits = new GpcKits();
if (isset($GpcKits)) {
    // register the activation function by passing the reference to our instance
    register_activation_hook(__FILE__, array(&$GpcKits, 'install'));
    register_deactivation_hook(__FILE__, array(&$GpcKits, 'uninstall'));
}

?>
