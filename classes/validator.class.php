<?php
if (!class_exists('GpcKits_Validator'))
{
	class GpcKits_Validator
	{
		/**
		 * Check if is valid decimal in depens on the language selected
		 * 
		 * @static 
		 * @param 	string 				$lang 		text of the language, if empty, english will be assumed. 
		 * 												Ultil now can be "german" and "english"
		 * @param 	string|decimal		$decimal	in any valid format for differents languages (example: english, german)
		 * @return 	boolean
		 * @access 	public
		 */
		static function is_valid_decimal($decimal,$lang='english') {
			// Calculate the numbers of comma and dot in the string
			$how_many_comma = substr_count($decimal,',');
			$how_many_dots = substr_count($decimal,'.');
			
			// Get the value passed without commas or dots
			$value_without_dot_comma = str_replace('.','',$decimal);
			$value_without_dot_comma = str_replace(',','',$value_without_dot_comma);
			
			// Get last ocurrence of "."
			$first_dot_pos = strrpos($decimal,'.'); 
			// Get first ocurrence of ","
			$first_comma_pos = strpos($decimal,',');

			if ($lang=='german') {
				/*
				 * None or only one ","
				 * None or many "." before "," if any
				 * 
				 */
						
				if ($first_comma_pos!==FALSE && $first_dot_pos!==FALSE) {
					if ($first_comma_pos<$first_dot_pos)
						return FALSE; // Problem: are a "," before a "."
				}
						
				if ($how_many_comma>1)
					return FALSE; // Problem: are more than one ","
			}
			else { // English
				if ($first_comma_pos!==FALSE && $first_dot_pos!==FALSE) {
					if ($first_dot_pos<$first_comma_pos)
						return FALSE; // Problem: are a "." before a ","
				}
				
				if ($how_many_dots>1)
					return FALSE; // Problem: are more than one "."
			}
			
			if (!ctype_digit($value_without_dot_comma))
				return FALSE; // Problem: there is more characters then numbers, "," and "."
			
			return TRUE;
	    }
	    
		/**
		 * Check if is valid integer in depens on the language selected
		 * 
		 * @static 
		 * @param 	string 		$lang 		text of the language, if empty, english will be assumed. 
		 * 										Ultil now can be "german" and "english"
		 * @param 	string|int	$int		in any valid format for differents languages (example: english, german)
		 * @return 	boolean
		 * @access 	public
		 */
		static function is_valid_int($int,$lang='english') {
			// Calculate the numbers of comma and dot in the string
			$how_many_comma = substr_count($int,',');
			$how_many_dots = substr_count($int,'.');
			
			// Get the value passed without commas or dots
			$value_without_dot_comma = str_replace('.','',$int);
			$value_without_dot_comma = str_replace(',','',$value_without_dot_comma);

			if ($lang=='german') {
				/*
				 * None or many "."
				 * None ","
				 *  
				 */
				
				if ($how_many_comma>0)
					return FALSE; // Problem: are a ","
				
			}
			else { // english
				/*
				 * None or many ","
				 * None "."
				 *  
				 */
				
				if ($how_many_dots>0)
					return FALSE; // Problem: are a "."
			}
			
			if (!ctype_digit($value_without_dot_comma))
				return FALSE; // Problem: there is more characters then numbers, "," and "."
			
			return TRUE;
	    }
	    
		/**
		 * Check if is valid an email address
		 * 
		 * Use a WordPress function to determine this.
		 *
		 * @static 
		 * @param string $email
		 * @return boolean
		 * @access public
		 */
		static function is_valid_email($email)
		{
			// Use the WordPress function
			return is_email($email);
	    }
	    
		/**
		 * Parse an Email and return a safe value.
		 * 
		 * Use a WordPress function to strips out all characters that are not allowable in an email:
		 * This function uses a smaller allowable character set than the set defined by RFC 5322. 
		 * Some legal email addresses may be changed.
		 * Allowed character regular expression: /[^a-z0-9+_.@-]/i.  
		 *
		 * @static 
		 * @param 	string	$email	Email address to filter
		 * @return 	string			Filtered email address.	
		 * @access public
		 */
		static function parse_email($email) {
			return sanitize_email($email);
	    }
	    
		/**
		 * Parse an file name and return a safe value.
		 * 
		 * Use a WordPress function to filters certain characters from the file name:
		 * Turns all strings to lowercase removing most characters except alphanumeric with spaces, 
		 * dashes and periods. All spaces and underscores are converted to dashes. Multiple dashes are 
		 * converted to a single dash. Finally, if the file name ends with a dash, it is removed. 
		 * 
		 *
		 * @static 
		 * @param 	string	$file_name	the file name
		 * @return 	string				filtered file name	
		 * @access public
		 */
		static function parse_file_name($file_name) {
			return sanitize_file_name($file_name);
	    }
	    
		/**
		 * Check if is valid the file name
		 * 
		 * Use WordPress function that:
		 * Is used to prevent directory traversal attacks, or to test a filename against a whitelist. 
		 * Returns 0 if $filename represents a valid relative path. After validating, you must treat 
		 * $filename as a relative path (i.e. you must prepend it with an absolute path), since 
		 * something like /etc/hosts will validate with this function. Returns an integer greater 
		 * than zero if the given path contains .., ./, or :, or is not in the $allowed_files whitelist. 
		 * Be careful making boolean interpretations of the result, since false (0) indicates the 
		 * filename has passed validation, whereas true (> 0) indicates failure. 
		 *
		 * @static 
		 * @param string $file_name
		 * @return boolean
		 * @access public
		 */
		static function is_valid_file_name($file_name)
		{
			// Use WordPress function
			if (validate_file($file_name)==0)
				return TRUE;
			else 
				return FALSE;
	    }
	    
		/**
		 * Check if is valid the format of a datetime in depens on the language selected
		 *
		 * @static 
		 * @param string $lang text of the language, if empty, english will be assumed. 
		 * 						Ultil now can be "german" and "english"
		 * @param string $value text to be validated. The formats allowed are:
		 * 						- dd/mm/yyyy hh:ii
		 * 						- mm/dd/yyyy hh:ii
		 * @return boolean
		 * @access public
		 */
		static function is_valid_datetime($value,$lang='english')
		{
			// Get each item of a datetime in depens on the language selected
	    	if ($lang=='german') {
				$day = substr($value,0,2);	
				$month = substr($value,3,2);	
				$year = substr($value,6);
				
				$hour = substr($value,11,2);
				$minute = substr($value,14,2);
			}
			else { // english
				$day = substr($value,3,2);	
				$month = substr($value,0,2);	
				$year = substr($value,6);
				
				$hour = substr($value,11,2);
				$minute = substr($value,14,2);
			}
			
			// Check the data
			$date_valid = checkdate($month,$day,$year);
			// Check the hours
			if ($hour>=0 && $hour<=23)
				$hour_valid = TRUE;
			else
				$hour_valid = FALSE;
			// Check the minutes
			if ($minute>=0 && $minute<=59)
				$minute_valid = TRUE;
			else
				$minute_valid = FALSE;
				
			// If all values are right, return TRUE, else FALSE
			if ($date_valid && $hour_valid && $minute_valid)
				return TRUE;
			else
				return FALSE;
	    }
	    
		/**
		 * Sanitizes $string for use in a LIKE expression of a SQL query 
		 * 
		 * Will still need to be SQL escaped before with parse_input.
		 * We use the like_escape WordPress function that use the str_replace() function, instead
		 * of the opinion of some programmers that said (http://dev.mysql.com/tech-resources/articles/guide-to-php-security-ch3.pdf):
		 * "addcslashes() works like a custom addslashes(), is fairly efficient, and much faster 
		 * alternative that str_replace() or the equivalent regular expression."
		 *
		 * @static 
		 * @param 	string				$value	text to be parsed
		 * @return 	string
		 * @access 	public
		 */
		static function parse_string_for_db_like($value)
		{
			$value = self::parse_input($value);
			$value = like_escape($value);
			
			return $value;
	    }
	    
		/**
		 * Parse a DateTime and return a safe value
		 *
		 * @static 
		 * @param string $lang text of the language, if empty, english will be assumed. 
		 * 						Ultil now can be "german" and "english"
		 * @param string $value text to be validated. The formats allowed are:
		 * 						- dd/mm/yyyy hh:ii
		 * 						- mm/dd/yyyy hh:ii
		 * @return int a DateTime value
		 * @access public
		 */
		static function parse_datetime($value,$lang='english') {
			return GpcKits_Locale::get_datetime_from_locale_format($value,$lang);
	    }

		/**
		 * Check if is valid the format of a Postal Code
		 *
		 * Check to enter only: spaces, numbers, letters, parenthesis and hyphen (-)
		 * 
		 * @static 
		 * @param string $value text to be validated
		 * @return boolean
		 * @access public
		 */
	    static function is_valid_postal_code($value) {
			// Test for invalid characters
			return eregi('[^a-zA-Z0-9 \(\)\-]', $value) ? FALSE : TRUE;
	    }
	    
	    /**
		 * Check if is valid the format of a Telephone
		 * 
		 * Check to enter only: spaces, numbers, letters, parenthesis and hyphen (-)
		 *
		 * @static 
		 * @param string $value text to be validated
		 * @return boolean
		 * @access public
		 */
		static function is_valid_telephone($value) {
			// Test for invalid characters
			return eregi('[^a-zA-Z0-9 \(\)\-]', $value) ? FALSE : TRUE;
	    }
	    
	    /**
		 * Check if is valid the format of a Telefax
		 *
		 * Check to enter only: spaces, numbers, letters, parenthesis and hyphen (-)
		 * 
		 * @static 
		 * @param string $value text to be validated
		 * @return boolean
		 * @access public
		 */
		static function is_valid_telefax($value) {
	    	// Test for invalid characters
			return eregi('[^a-zA-Z0-9 \(\)\-]', $value) ? FALSE : TRUE;
	    }
	    
	    /**
		 * Parse a data to be shown in templates
		 *
		 * @static 
		 * @param 	string 	$string	text to be parsed
		 * @return 	string
		 * @access 	public
		 */
		static function parse_output($string) {
	    	if ( get_magic_quotes_gpc() )
	    		return stripcslashes($string);
	    	else
	    		return $string;
	    }
	    
	    /**
		 * Parse a data to be used in a database Query
		 * 
		 * This is only used in cases where isn't used the follow WordPress functions (because
		 * they does the sanitation for us):
		 * 		$wpdb->prepare
		 * 		$wpdb->insert
		 * 		$wpdb->update
		 *
		 * @static 
		 * @param 	string 	$string	text to be parsed
		 * @return 	string
		 * @access 	public
		 */
		static function parse_input($string) {
	    	return esc_sql($string);
	    }
	    
	    /**
		 * Parse a data to be shown in richedit
		 * 
		 * Use a WordPress function to formats text for the rich text editor.
		 *
		 * @static 
		 * @param 	string 	$string	text to be parsed
		 * @return 	string
		 * @access 	public
		 */
		static function parse_output_for_richedit($string) {
			// Use WordPress function
	    	return wp_richedit_pre($string);
	    }
	    
	    /**
		 * Parse an array of data to be shown in templates
		 * 
		 * Use a WordPress function to navigates through an array and removes slashes from the values.
		 *
		 * @static 
		 * @param 	array 	$array	The array or string to be striped
		 * @return 	array			Stripped array
		 * @access 	public
		 */
		static function parse_array_output($array) {
			if ( get_magic_quotes_gpc() )
	    		return stripslashes_deep($array);
	    	else
	    		return $array;
	    }
	    
	    /**
		 * Parse a string and return a safe value
		 *
		 * @static 
		 * @param string $string text to be parsed
		 * @return string
		 * @access public
		 */
		static function parse_string($string) {
	    	return esc_html($string);
	    }
	    
	    /**
		 * Decode an URL and return the original value
		 *
		 * @static 
		 * @param string $url
		 * @return string
		 * @access public
		 */
		static function decode_url($url) {
	    	return urldecode($url);
	    }
	    
	    /**
		 * Encode an URL
		 * 
		 * Encodes for use in URL (as a query parameter, for example)
		 *
		 * @static 
		 * @param 	string 	$url
		 * @return 	string
		 * @access 	public
		 */
		static function encode_url($url) {
	    	return urlencode($url);
	    }
	    
	    /**
		 * Checks and cleans a URL
		 * 
		 * Use a WordPress function to accomplish the follow:
		 * A number of characters are removed from the URL. 
		 * If the URL is for displaying (the default behaviour) ampersands (&) are also replaced.
		 *
		 * @static 
		 * @param string $url
		 * @return string
		 * @access public
		 */
		static function parse_url($url) {
			// Use the WordPress function
	    	return esc_url($url);
	    }
	    
	    /**
		 * Parse an integer and return a safe value
		 *
		 * @static 
		 * @param 	int 	$int 			integer to be parsed
		 * @param 	bool 	$must_positive 	if TRUE, ensures that the result is nonnegative
		 * @return 	int
		 * @access 	public
		 */
		static function parse_int($int, $must_positive=FALSE) {
			if ($int=='')
				return '';
			
			preg_match('{(\d+)}', $int, $m);
			$first_number = $m[1];
			
			if ($must_positive)
	    		return abs(intval($first_number));
	    	else
	    		return intval($first_number);
	    }
	    
	    /**
		 * Parse a decimal and return a safe value to insert in database
		 *
		 * @static 
		 * @param 	string 		$lang 		text of the language, if empty, english will be assumed. 
		 * 										Ultil now can be "german" and "english"
		 * @param 	decimal 	$decimal 	decimal to be parsed
		 * @return 	decimal
		 * @access 	public
		 */
		static function parse_decimal($decimal,$lang='english') {
			
			// In case is null, keep this way
			if ($decimal=='')
				return $decimal;
			
			if ($lang=='german') {
				// Get the value in standar (english) format
				$decimal = B2bPlugin4_Locale::get_decimal_from_locale_format($decimal);
			}
			
			// remove all ',' as thousand separator
			$decimal = str_replace(',','',$decimal);
			
			return floatval($decimal);	    	
	    }
	}
}
?>