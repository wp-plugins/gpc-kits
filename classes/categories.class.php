<?php
if (!class_exists('GpcKits_Categories'))
{
	class GpcKits_Categories
	{
		/**
		 * Get category name.
		 *
		 * @static 
		 * @param int $term_id
		 * @param string $default_value
		 * @global $wpdb used to access to WordPress Object that manage DB
		 * @return string name of category
		 * @access public
		 */
		static function get_category_name($term_id, $default_value='') {	
			global $wpdb;
			
			$return = $wpdb->get_var($wpdb->prepare("SELECT name from $wpdb->terms WHERE term_id = %d", $term_id));
			if ($return==NULL)
				$return =  $default_value;
				
			return $return;
	    }
		
		/**
		 * Retrieve the list of categories.
		 *
		 * @static 
		 * @global $wpdb used to access to WordPress Object that manage DB
		 * @return array array of objects with the data of the Categories
		 * @access public
		 */
		static function get_all_categories() {	
			global $wpdb;
			
			return $wpdb->get_results("select $wpdb->terms.* from $wpdb->terms inner join $wpdb->term_taxonomy
					on ($wpdb->term_taxonomy.term_id = $wpdb->terms.term_id)
				 where $wpdb->term_taxonomy.taxonomy = 'category'
				 order by $wpdb->terms.name
				 "); 
	    }
	    
		/**
		 * Retrieve the list of categories parents.
		 *
		 * @static 
		 * @return array array name of Parents Categories
		 * @access public
		 */
		static function get_all_categories_parents($term_id) {	
			/*
			 * Using the WP function to returns a list of the parents of a category, including the category, sorted by ID.
			 */ 
			$category_parents = get_category_parents($term_id, FALSE, ',');
			$category_parents_arr = split(',',$category_parents);
			
			// Get current category name, to ignore it
			$term_id_name = self::get_category_name($term_id);
			
			$to_return = array();
			foreach ($category_parents_arr as $item) {
				if ($item!='' && $item!=$term_id_name)
					$to_return[] = $item;
			}
			
			return $to_return;
	    }
	    
		/**
		 * Retrieve the list of categories with levels.
		 *
		 * @static 
		 * @return array array with data of the Categories as follow
		 * 						$categories = array(
												array(
													'id' => 1,
													'name' => 'Category1',
													'level' => 0
												),
												array(
													'id' => 2,
													'name' => 'Category2',
													'level' => 1
												)
											   )
		 * @access public
		 */
		static function get_all_categories_with_levels()
		{
			// Get all categories in hierarchical way
			$args = array(
			    'show_option_all'    => '',
			    'show_option_none'   => '',
			    'orderby'            => 'ID', 
			    'order'              => 'ASC',
			    'show_last_update'   => 0,
			    'show_count'         => 0,
			    'hide_empty'         => 0, 
			    'child_of'           => 0,
			    'exclude'            => '',
			    'echo'               => 0,
			    'selected'           => 0,
			    'hierarchical'       => 1, 
			    'name'               => 'cat',
			    'class'              => 'postform',
			    'depth'              => 0 );
			$categories_output = wp_dropdown_categories( $args );
			$arr = split('<option',$categories_output);
			$hierarchical_order = array();
			foreach ($arr as $item) {
				if (substr_count($item,'value="')) {
					$id = substr($item,strpos($item,'value="') + strlen('value="'),strpos($item,'">') - (strpos($item,'value="') + strlen('value="')));
					$hierarchical_order[] = $id;
				}
			}
			// End: Get all categories in hierarchical way 
			
			$all_categories = self::get_all_categories();
			$to_return = array();
			
			foreach ($all_categories as $item) {
				$term_id = $item->term_id;
				
				// Get the list of names of parents
				$parents = self::get_all_categories_parents($term_id);
				
				// Determining the level 
				$level = count($parents);			
				
				$to_return[$term_id] = array(
										'id' => $term_id,
										'name' => $item->name,
										'level' => $level
									);
			}
			
			// Order in hierarchical way
			$hierarchical_order_arr = array();
			foreach ($hierarchical_order as $item) {
				$hierarchical_order_arr[] = $to_return[$item];
			}
			
			return $hierarchical_order_arr;
	    }
	}
}
?>