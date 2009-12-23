<?php
if (!class_exists('GpcKits_Locale'))
{
	class GpcKits_Locale
	{
		/**
		 * Get the decimal extracting data from locale format
		 * 
		 * @static
		 * @param 	string	$value		the formats allowed are:
		 * 									- 10.000,20 for german
		 * 									- 10,000.20 for english
		 * @param	string	$lang
		 * @return	decimal				the format returned is the standar (the same as english format)
		 * @access	public
		 */
		static public function get_decimal_from_locale_format($value,$lang='english')
		{		   	
		   	if (strtolower($lang)=='german') {
				/*
		   		 * To do this is necessary to:
		   		 * 	- replace any '.' for ','
		   		 * 	- replace any ',' for '.'
		   		 * 
		   		 * we use a comodin to avoid lose real ',' in first replacemente
		   		 */
		   		
				$value = str_replace('.','.#',$value);
				$value = str_replace(',',',#',$value);
				$value = str_replace(',#','.',$value);
				$value = str_replace('.#',',',$value);
				
				// strip ',' because in database this values aren't saved
				return str_replace(',','',$value);
			}
			else { // english				
				// strip ',' because in database this values aren't saved
				return str_replace(',','',$value);
			}
		}
		
		/**
		 * Get the decimal in locale format
		 * 
		 * @static
		 * @param 	string	$value		the format allowed is:
		 * 									- 10,000.20 for english
		 * @param	string	$lang
		 * @return	decimal				the format returned is the value in locale format
		 * @access	public
		 */
		static public function get_decimal_in_locale_format($value,$lang='english') {
			// In case is null, keep this way
			if ($value=='')
				return $value;
						   	
		   	if (strtolower($lang)=='german') {
				// Check if has decimal values
				$pos_r_dot = strrpos($value,'.');
				if ($pos_r_dot)
					$decimal_part = substr($value,$pos_r_dot+1);
				else 
					$decimal_part = 0;
				
				if ($decimal_part!=0)
					return number_format($value, 2, ',', '.');
				else 
					return number_format($value, 0, ',', '.');
			}
			else { // english
				// Check if has decimal values
				$pos_r_dot = strrpos($value,'.');
				if ($pos_r_dot)
					$decimal_part = substr($value,$pos_r_dot+1);
				else 
					$decimal_part = 0;
				
				if ($decimal_part!=0)
					return number_format($value, 2, '.', ',');
				else 
					return number_format($value, 0, '.', ',');
			}
		}
		
		/**
		 * Get the datetime extracting data from locale format
		 * 
		 * @static
		 * @param 	string	$value		the formats allowed are:
		 * 									- dd/mm/yyyy hh:ii for german
		 * 									- mm/dd/yyyy hh:ii for english
		 * @param	string	$lang
		 * @param	bool	$only_date	define when to parse date and time or only date
		 * @return	int
		 * @access	public
		 */
		static public function get_datetime_from_locale_format($value,$lang='english',$only_date=FALSE)
		{		   	
		   	if (strtolower($lang)=='german') {
				if ($only_date)
					list( $day, $month, $year ) = split( '([^0-9])', $value );
				else 
					list( $day, $month, $year, $hour, $minute ) = split( '([^0-9])', $value );				
			}
			else { // english				
				if ($only_date)
					list( $month, $day, $year ) = split( '([^0-9])', $value );
				else 
					list( $month, $day, $year, $hour, $minute ) = split( '([^0-9])', $value );	
				
			}
			
			if ($only_date)
				return mktime(0,0,0,$month,$day,$year);
			else
				return mktime($hour,$minute,0,$month,$day,$year);
		}
		
		/**
		 * Get the datetime from mysql format
		 * 
		 * Use a WordPress function to translates dates from mysql format to any format 
		 * acceptable by the php date() function 
		 * 
		 * @static
		 * @param 	string	$dateformatstring	the requested output format. Any format acceptable by the php date() function
		 * @param 	string	$mysqlstring		the input string, probably mysql database output 
		 * @return	string
		 * @access	public
		 */
		static public function get_date_and_time_from_mysql_format($dateformatstring, $mysqlstring)
		{		   	
		   	return mysql2date($dateformatstring, $mysqlstring);
		}
		
		/**
		 * Get the datetime in the right format
		 * 
		 * Note: the function http://codex.wordpress.org/Function_Reference/date_i18n
		 * isn't used, because now isn't clear if the global $wp_locale store the same
		 * locale information that the plugin uses.
		 * 
		 * @static
		 * @param	int		$datetime
		 * @param 	string	$lang
		 * @param 	bool 	$only_date	define when to show date and time or only date
		 * @return 	string
		 * @access 	public
		 */
		static public function get_datetime_in_locale_format($datetime,$lang='english',$only_date=FALSE)
		{
			if (strtolower($lang)=='german') {
				if ($only_date)
		   			return date('d/m/Y',$datetime);
		   		else 
		   			return date('d/m/Y H:i',$datetime);
			}
		   	else { // english is the default
		   		if ($only_date)
		   			return date('m/d/Y',$datetime);
		   		else 
		   			return date('m/d/Y H:i',$datetime);
		   	}
		}
		
		/**
		 * Get the format of a datetime
		 * 
		 * @static
		 * @param string $lang
		 * @return string
		 * @access public
		 */
		static public function get_datetime_locale_format($lang='english')
		{
			if (strtolower($lang)=='german')
		   		return __('dd/mm/yyyy hh:ii','gpc-kits');
		   	else // english is the default
		   		return __('mm/dd/yyyy hh:ii','gpc-kits');
		}
		
		/**
		 * Get the locale code in use
		 * 
		 * Will return for example "de_DE" for german
		 * 
		 * @static
		 * @param string $lang
		 * @return string
		 * @access public
		 */
		static public function get_locale_code_in_use($lang='german')
		{
			if (strtolower($lang)=='german')
		   		return 'de_DE';
		   	else // english is the default
		   		return '';
		}
	}
}
?>