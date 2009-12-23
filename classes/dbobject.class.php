<?php
if (!class_exists('GpcKits_DBO'))
{
	class GpcKits_DBO
	{
		/**
		 * The name of table in the DB
		 * 
		 * @var string
		 */
		public $table;
		
		/**
		 * Set table name
		 * 
		 * @param  string $table_name name of the table
		 * @access public
		 */
		public function GpcKits_DBO($table_name) {
			
			$this->table = $table_name;
		}
		
		
		/**
		 * Add item to DB
		 * 
		 * @global $wpdb used to access to WordPress Object that manage DB
	 	 * @param  array $data all fields of the item. The keys are the name of columns in DB
		 * @return int|bool ID generated for an AUTO_INCREMENT column by the most recent INSERT query 
		 * 					or FALSE when the query wasn't executed succesfully
		 * @access public
		 */
		public function add($data) {
	    	global $wpdb;
	    	if ($wpdb->insert( $this->table, (array) $data ))
	    		return $wpdb->insert_id;
	    	else
	    		return FALSE;
	    }
	    
		/**
		 * Update item in DB
		 * 
		 * @global $wpdb used to access to WordPress Object that manage DB
	 	 * @param  array $data all fields of the item. The keys are the name of columns in DB
		 * @param  array $where fields to select the item to update. The keys are the name of columns in DB
		 * @return bool true when query was executed succesfully, else return FALSE
		 * @access public
		 */
		public function update($data, $where) {
	    	global $wpdb;
	    	return $wpdb->update($this->table, (array) $data, (array) $where);
	    }
	    
		/**
		 * Get item from DB
		 * 
		 * @global $wpdb used to access to WordPress Object that manage DB
	 	 * @param  int|string $value id of the item to get
		 * @param  string $field a different to 'id' column to get where it match with $value
		 * @param string $field_type type of the column to filter (can be '%s' for strings or '%d' for numeric values)
		 * @return array|NULL data when query was executed succesfully, else return NULL
		 * @access public
		 */
		public function get($value, $field='', $field_type='') {
	    	global $wpdb;
	    	
	    	if ($field=='')
	    		$field = 'id';
	    		
	    	if ($field_type=='')  // %d
	    		$result = $wpdb->get_row( $wpdb->prepare( "SELECT * from `$this->table` WHERE `$field` = %d", $value ) );
	    	else // %s
	    		$result = $wpdb->get_row( $wpdb->prepare( "SELECT * from `$this->table` WHERE `$field` = %s", $value ) );
	    	
	    	if ($result==NULL)
	    		return NULL;

	    	// Parse returned fields to strip slashes
	    	$result = (array) $result;
	    	$parsed_result = GpcKits_Validator::parse_array_output($result);
	    	$parsed_result = (object) $parsed_result;
	    	// End: Parse returned fields to strip slashes
	    		
	    	return $parsed_result;
	    }
	    
		/**
		 * Get all items from DB
		 * 
		 * @global $wpdb used to access to WordPress Object that manage DB
	 	 * @param  int|string $value value of the item to filter
		 * @param  string $field a different to 'id' column to filter
		 * @param  string $order_by name of the column to order by
		 * @param  string $field_type type of the column to filter (can be '%s' for strings or '%d' for numeric values)
		 * @param  string $order_direction direction to ordey by. Can be "DESC" or "ASC"
		 * @return array array of objects with the data from DB
		 * @access public
		 */
		public function get_all($value='', $field='', $order_by='', $field_type='%d', $order_direction='ASC') {
	    	global $wpdb;
	    	
	    	if ($field=='')
	    		$field = 'id';
	    	
	    	// Special cases for ordering that requires innerjoins
	    	$extra_sql = '';
	    	// Special case for categories
	    	if ($order_by=='term_id') {
	    		$extra_sql = "inner join `$wpdb->terms` on (`$wpdb->terms`.term_id=`$this->table`.term_id)";
	    		$order_by = "`$wpdb->terms`.name";
	    	}
	    	elseif ($order_by!='') {
	    		// Set order by ` where is a simple column
	    		$order_by = "`$order_by`";
	    	}
	    		
	    	if ($order_by!='') $order_by = " order by $order_by $order_direction";
	    		
	    	if ($value!='')
	    	{
	    		if ($field_type=='%d')  // %d
		    		$query = $wpdb->prepare( "SELECT `$this->table`.* from `$this->table` $extra_sql WHERE `$this->table`.`$field` = %d $order_by", $value );
		    	else // %s
		    		$query = $wpdb->prepare( "SELECT `$this->table`.* from `$this->table` $extra_sql WHERE `$this->table`.`$field` = %s $order_by", $value );
	    	}
	    	else 
	    		$query = "SELECT `$this->table`.* from `$this->table` $extra_sql $order_by";
	    	
	    	
	    	$results = $wpdb->get_results($query);
			
	    	// Parse returned fields to strip slashes
	    	$parsed_results = array();
	    	foreach ($results as $result) {
	    		$tmp_result = (array) $result;
		    	$parsed_result = GpcKits_Validator::parse_array_output($tmp_result);
		    	$parsed_result = (object) $parsed_result;
		    	
		    	$parsed_results[] = $parsed_result;
	    	}
	    	// End: Parse returned fields to strip slashes
	    	
	    	return $parsed_results;
	    }
	    
		/**
		 * Delete item in DB
		 * 
		 * @global $wpdb used to access to WordPress Object that manage DB
	 	 * @param  int $id id of the item to delete
		 * @param  string $field a different column to delete where it match with $id
		 * @param string $field_type type of the column to filter (can be '%s' for strings or '%d' for numeric values)
		 * @return bool true when query was executed succesfully, else return FALSE
		 * @access public
		 */
		public function delete($id, $field='', $field_type='') {
	    	global $wpdb;
	    	
	    	if ($field=='')
	    		$field = 'id';
	    		
	    	if ($field_type=='')  // %d
		    	return $wpdb->query( $wpdb->prepare( "DELETE from $this->table WHERE $field = %d", $id ) );
		    else // %s
		    	return $wpdb->query( $wpdb->prepare( "DELETE from $this->table WHERE $field = %s", $id ) );
	    }
	}
}
?>