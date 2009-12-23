<?php
global $wpdb;

// Include all classes
include(GpcKits::$plugin_dir . '/includes/all_classes.php');

// Define the tables prefix
$prefix = $wpdb->prefix . GpcKits::$db_prefix;

// 1- Creating Table for Address
$table_name = $prefix . GpcKits_Address::$table_name;

/*
 * This is for compatibility with previous version.
 * If already exists a table for address of the Plugin business-events
 * replace the name of it. 
 */
if (class_exists('BusinessEvents')) {
	$old_table_name = $wpdb->prefix . BusinessEvents::$db_prefix . GpcKits_Address::$table_name;
	if ($wpdb->get_var("show tables like '$old_table_name'") == $old_table_name) {
		$wpdb->query("RENAME TABLE `$old_table_name`  TO `$table_name`");	
	}
}
// Create table if isn't exists
if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
	$wpdb->query("CREATE TABLE `$table_name` (
			`id` INT NOT NULL auto_increment ,
			`street` varchar (255),
			`postal_code` varchar (255),
			`place` varchar (255),
			`state` varchar (255),
			`country_code` varchar (5),
			PRIMARY KEY ( `id` ))");	
}

// 2- Creating Table for Countries
$table_name = $prefix . GpcKits_Countries::$table_name;

/*
 * This is for compatibility with previous version.
 * If already exists a table for countries of the Plugin business-events
 * replace the name of it. 
 */
if (class_exists('BusinessEvents')) {
	$old_table_name = $wpdb->prefix . BusinessEvents::$db_prefix . GpcKits_Countries::$table_name;
	if ($wpdb->get_var("show tables like '$old_table_name'") == $old_table_name) {
		$wpdb->query("RENAME TABLE `$old_table_name`  TO `$table_name`");	
	}
}
// Create table if isn't exists
if ($wpdb->get_var("show tables like '$table_name'") != $table_name) {
		$wpdb->query("CREATE TABLE `$table_name` (
			`id` INT NOT NULL auto_increment ,
			`code` VARCHAR (5),
			`name` VARCHAR (255),
			PRIMARY KEY ( `id` ))");	
}
// Add values if aren't in database
$tmp_result = $wpdb->get_results("select * from `$table_name`");
if (count($tmp_result) == 0) {
    $all_countries_to_db_arr = GpcKits_Countries::get_all_countries_to_db();
    foreach ($all_countries_to_db_arr as $key=>$item) {
    	$wpdb->query("INSERT INTO `$table_name` (`code`,`name`) VALUES
		('$key','$item') ;");
    }
}
?>