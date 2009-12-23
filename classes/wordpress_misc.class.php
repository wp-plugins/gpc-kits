<?php
if (!class_exists('GpcKits_WordpressMisc'))
{
	class GpcKits_WordpressMisc
	{

        /**
         * Function to get the list of Pages
         * 
         * @global $wpdb
         * @return array of objects with pages data
         */
        static function get_wp_pages()
		{
			global $wpdb;
			return $wpdb->get_results( $wpdb->prepare("SELECT * FROM $wpdb->posts WHERE post_type = 'page'") );
		}
	}
}
?>