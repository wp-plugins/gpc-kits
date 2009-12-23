<?php
if (!class_exists('GpcKits_Files'))
{
	class GpcKits_Files
	{
		
		/**
		 * Delete file
		 *
		 * @static 
		 * @param string $file_url 
		 * @access public
		 */
		static function delete_file($file_url) {
			
			// TODO: check if this work in a non standar place for /uploads/ folder
			
			// Search for file path
			$relative_path_uploads_pos = strpos($file_url,'/uploads/');
			$relative_path_uploads = substr($file_url, $relative_path_uploads_pos);
				
			$absolute_path = BusinessEvents::$plugin_dir . '/../..' . $relative_path_uploads;
			
			// Selete file
			if (file_exists($absolute_path) && is_file($absolute_path))
				unlink($absolute_path);
		}
	}
}
?>