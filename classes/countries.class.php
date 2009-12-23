<?php
if (!class_exists('GpcKits_Countries'))
{
class GpcKits_Countries
{
	
	/**
	 * The name of table in the DB
	 * @static
	 * @var string
	 */
	static $table_name = 'countries';
	
	/**
	 * Return the country name
	 * 
	 * @static 
	 * @param string $code
	 * @return string  
	 */
	static function get_country_name($code)
	{
		$data = self::get_countries_for_select();
		return $data[$code];
	}
	
	/**
	 * Return the countries
	 * 
	 * @static 
	 * @return array with the key as the code and the value as the name  
	 */
	static function get_countries_for_select()
	{
		$all_countries = self::get_all();
		$return_values = array();
		foreach ($all_countries as $item) {
			$return_values[$item->code] = $item->name;
		}
		
		return $return_values;
	}
	
	/**
	 * Return the array of Countries to Fill the DB
	 * 
	 * @static 
	 * @return array 
	 */
	static function get_all_countries_to_db()
	{
		return array(
			  "AF" => "Afghanistan",
			  "AL" => "Albania",
			  "DZ" => "Algeria",
			  "AS" => "American Samoa",
			  "AD" => "Andorra",
			  "AO" => "Angola",
			  "AI" => "Anguilla",
			  "AQ" => "Antarctica",
			  "AG" => "Antigua And Barbuda",
			  "AR" => "Argentina",
			  "AM" => "Armenia",
			  "AW" => "Aruba",
			  "AU" => "Australia",
			  "AT" => "Austria",
			  "AZ" => "Azerbaijan",
			  "BS" => "Bahamas",
			  "BH" => "Bahrain",
			  "BD" => "Bangladesh",
			  "BB" => "Barbados",
			  "BY" => "Belarus",
			  "BE" => "Belgium",
			  "BZ" => "Belize",
			  "BJ" => "Benin",
			  "BM" => "Bermuda",
			  "BT" => "Bhutan",
			  "BO" => "Bolivia",
			  "BA" => "Bosnia And Herzegowina",
			  "BW" => "Botswana",
			  "BV" => "Bouvet Island",
			  "BR" => "Brazil",
			  "IO" => "British Indian Ocean Territory",
			  "BN" => "Brunei Darussalam",
			  "BG" => "Bulgaria",
			  "BF" => "Burkina Faso",
			  "BI" => "Burundi",
			  "KH" => "Cambodia",
			  "CM" => "Cameroon",
			  "CA" => "Canada",
			  "CV" => "Cape Verde",
			  "KY" => "Cayman Islands",
			  "CF" => "Central African Republic",
			  "TD" => "Chad",
			  "CL" => "Chile",
			  "CN" => "China",
			  "CX" => "Christmas Island",
			  "CC" => "Cocos (Keeling) Islands",
			  "CO" => "Colombia",
			  "KM" => "Comoros",
			  "CG" => "Congo",
			  "CD" => "Congo, The Democratic Republic Of The",
			  "CK" => "Cook Islands",
			  "CR" => "Costa Rica",
			  "CI" => "Cote D'Ivoire",
			  "HR" => "Croatia (Local Name: Hrvatska)",
			  "CU" => "Cuba",
			  "CY" => "Cyprus",
			  "CZ" => "Czech Republic",
			  "DK" => "Denmark",
			  "DJ" => "Djibouti",
			  "DM" => "Dominica",
			  "DO" => "Dominican Republic",
			  "TP" => "East Timor",
			  "EC" => "Ecuador",
			  "EG" => "Egypt",
			  "SV" => "El Salvador",
			  "GQ" => "Equatorial Guinea",
			  "ER" => "Eritrea",
			  "EE" => "Estonia",
			  "ET" => "Ethiopia",
			  "FK" => "Falkland Islands (Malvinas)",
			  "FO" => "Faroe Islands",
			  "FJ" => "Fiji",
			  "FI" => "Finland",
			  "FR" => "France",
			  "FX" => "France, Metropolitan",
			  "GF" => "French Guiana",
			  "PF" => "French Polynesia",
			  "TF" => "French Southern Territories",
			  "GA" => "Gabon",
			  "GM" => "Gambia",
			  "GE" => "Georgia",
			  "DE" => "Germany",
			  "GH" => "Ghana",
			  "GI" => "Gibraltar",
			  "GR" => "Greece",
			  "GL" => "Greenland",
			  "GD" => "Grenada",
			  "GP" => "Guadeloupe",
			  "GU" => "Guam",
			  "GT" => "Guatemala",
			  "GN" => "Guinea",
			  "GW" => "Guinea-Bissau",
			  "GY" => "Guyana",
			  "HT" => "Haiti",
			  "HM" => "Heard And Mc Donald Islands",
			  "VA" => "Holy See (Vatican City State)",
			  "HN" => "Honduras",
			  "HK" => "Hong Kong",
			  "HU" => "Hungary",
			  "IS" => "Iceland",
			  "IN" => "India",
			  "ID" => "Indonesia",
			  "IR" => "Iran (Islamic Republic Of)",
			  "IQ" => "Iraq",
			  "IE" => "Ireland",
			  "IL" => "Israel",
			  "IT" => "Italy",
			  "JM" => "Jamaica",
			  "JP" => "Japan",
			  "JO" => "Jordan",
			  "KZ" => "Kazakhstan",
			  "KE" => "Kenya",
			  "KI" => "Kiribati",
			  "KP" => "Korea, Democratic People's Republic Of",
			  "KR" => "Korea, Republic Of",
			  "KW" => "Kuwait",
			  "KG" => "Kyrgyzstan",
			  "LA" => "Lao People's Democratic Republic",
			  "LV" => "Latvia",
			  "LB" => "Lebanon",
			  "LS" => "Lesotho",
			  "LR" => "Liberia",
			  "LY" => "Libyan Arab Jamahiriya",
			  "LI" => "Liechtenstein",
			  "LT" => "Lithuania",
			  "LU" => "Luxembourg",
			  "MO" => "Macau",
			  "MK" => "Macedonia, Former Yugoslav Republic Of",
			  "MG" => "Madagascar",
			  "MW" => "Malawi",
			  "MY" => "Malaysia",
			  "MV" => "Maldives",
			  "ML" => "Mali",
			  "MT" => "Malta",
			  "MH" => "Marshall Islands",
			  "MQ" => "Martinique",
			  "MR" => "Mauritania",
			  "MU" => "Mauritius",
			  "YT" => "Mayotte",
			  "MX" => "Mexico",
			  "FM" => "Micronesia, Federated States Of",
			  "MD" => "Moldova, Republic Of",
			  "MC" => "Monaco",
			  "MN" => "Mongolia",
			  "MS" => "Montserrat",
			  "MA" => "Morocco",
			  "MZ" => "Mozambique",
			  "MM" => "Myanmar",
			  "NA" => "Namibia",
			  "NR" => "Nauru",
			  "NP" => "Nepal",
			  "NL" => "Netherlands",
			  "AN" => "Netherlands Antilles",
			  "NC" => "New Caledonia",
			  "NZ" => "New Zealand",
			  "NI" => "Nicaragua",
			  "NE" => "Niger",
			  "NG" => "Nigeria",
			  "NU" => "Niue",
			  "NF" => "Norfolk Island",
			  "MP" => "Northern Mariana Islands",
			  "NO" => "Norway",
			  "OM" => "Oman",
			  "PK" => "Pakistan",
			  "PW" => "Palau",
			  "PA" => "Panama",
			  "PG" => "Papua New Guinea",
			  "PY" => "Paraguay",
			  "PE" => "Peru",
			  "PH" => "Philippines",
			  "PN" => "Pitcairn",
			  "PL" => "Poland",
			  "PT" => "Portugal",
			  "PR" => "Puerto Rico",
			  "QA" => "Qatar",
			  "RE" => "Reunion",
			  "RO" => "Romania",
			  "RU" => "Russian Federation",
			  "RW" => "Rwanda",
			  "KN" => "Saint Kitts And Nevis",
			  "LC" => "Saint Lucia",
			  "VC" => "Saint Vincent And The Grenadines",
			  "WS" => "Samoa",
			  "SM" => "San Marino",
			  "ST" => "Sao Tome And Principe",
			  "SA" => "Saudi Arabia",
			  "SN" => "Senegal",
			  "SC" => "Seychelles",
			  "SL" => "Sierra Leone",
			  "SG" => "Singapore",
			  "SK" => "Slovakia (Slovak Republic)",
			  "SI" => "Slovenia",
			  "SB" => "Solomon Islands",
			  "SO" => "Somalia",
			  "ZA" => "South Africa",
			  "GS" => "South Georgia, South Sandwich Islands",
			  "ES" => "Spain",
			  "LK" => "Sri Lanka",
			  "SH" => "St. Helena",
			  "PM" => "St. Pierre And Miquelon",
			  "SD" => "Sudan",
			  "SR" => "Suriname",
			  "SJ" => "Svalbard And Jan Mayen Islands",
			  "SZ" => "Swaziland",
			  "SE" => "Sweden",
			  "CH" => "Switzerland",
			  "SY" => "Syrian Arab Republic",
			  "TW" => "Taiwan",
			  "TJ" => "Tajikistan",
			  "TZ" => "Tanzania, United Republic Of",
			  "TH" => "Thailand",
			  "TG" => "Togo",
			  "TK" => "Tokelau",
			  "TO" => "Tonga",
			  "TT" => "Trinidad And Tobago",
			  "TN" => "Tunisia",
			  "TR" => "Turkey",
			  "TM" => "Turkmenistan",
			  "TC" => "Turks And Caicos Islands",
			  "TV" => "Tuvalu",
			  "UG" => "Uganda",
			  "UA" => "Ukraine",
			  "AE" => "United Arab Emirates",
			  "GB" => "United Kingdom",
			  "US" => "United States",
			  "UM" => "United States Minor Outlying Islands",
			  "UY" => "Uruguay",
			  "UZ" => "Uzbekistan",
			  "VU" => "Vanuatu",
			  "VE" => "Venezuela",
			  "VN" => "Viet Nam",
			  "VG" => "Virgin Islands (British)",
			  "VI" => "Virgin Islands (U.S.)",
			  "WF" => "Wallis And Futuna Islands",
			  "EH" => "Western Sahara",
			  "YE" => "Yemen",
			  "YU" => "Yugoslavia",
			  "ZM" => "Zambia",
			  "ZW" => "Zimbabwe"
			);
	}
	
	
		/*
		 * except "GpcKits" that is the name of the class of the plugin
		 * Begin Common Code
		 * This can be avoid since PHP 5.3 (http://www.php.net/manual/en/language.oop5.late-static-bindings.php)
		 */
		
		/**
		 * The Object to access DB
		 * @static
		 * @var GpcKits_DBO
		 */
		static $db_obj;
		
		/**
		 * Set DB Object
		 *
		 * @static 
		 * @global $wpdb used to access to WordPress Object that manage DB
		 * @param string $table optional value of the table
		 * @access public
		 */
		static public function set_db_obj($table='')
		{
		   	global $wpdb;
		   	if ($table=='') $table = self::$table_name;
		   	$full_table_name =  $wpdb->prefix . GpcKits::$db_prefix . $table;
		   	
		   	if (class_exists('GpcKits_DBO'))
				self::$db_obj = new GpcKits_DBO($full_table_name);
		}
		
		/**
		 * Get all items from DB
		 * 
		 * @static
		 * @param int $id value of the field to filter
		 * @param string $field name of the column to filter
		 * @param string $order_by name of the column to order by
		 * @param string $field_type type of the column to filter (can be '%s' for strings or '%d' for numeric values)
		 * @return array
		 * @access public
		 */
		static public function get_all($id='', $field='', $order_by='', $field_type='')
		{
			self::set_db_obj();
	   		if (self::$db_obj!=NULL)
	   			return self::$db_obj->get_all($id, $field, $order_by, $field_type);
	   		else
	   			return array();
		}
		
		/**
		 * Get item from DB
		 * 
		 * @static
		 * @param int $id value of the field to filter
		 * @param string $field name of the column to filter
		 * @param string $field_type type of the column to filter (can be '%s' for strings or '%d' for numeric values)
		 * @return array|NULL data when query was executed succesfully, else return NULL
		 * @access public
		 */
		static public function get($id, $field='', $field_type='')
		{
			self::set_db_obj();
			if (self::$db_obj!=NULL)
	   			return self::$db_obj->get($id, $field, $field_type);
	   		else
	   			return NULL;
		}
		
		/**
		 * Update item DB
		 * 
		 * @static
		 * @param array $data with all the key/values to be updated in the table
		 * @param array $where with all the key/values to filter the update
		 * @return bool true when query was executed succesfully, else return FALSE
		 * @access public
		 */
		static public function update($data,$where)
		{
		   	self::set_db_obj();
		   	if (self::$db_obj!=NULL)
	   			return self::$db_obj->update($data,$where);
	   		else 
	   			return FALSE;
		}
		
		/**
		 * Add item DB
		 * 
		 * @static
		 * @param array $data with all the key/values to be added to table
		 * @return int|bool ID generated for an AUTO_INCREMENT column by the most recent INSERT query 
		 * 					or FALSE when the query wasn't executed succesfully
		 * @access public
		 */
		static public function add($data)
		{
			self::set_db_obj();
			if (self::$db_obj!=NULL)
	   			return self::$db_obj->add($data);
	   		else 
	   			return FALSE;
		}
		
		/**
		 * Delete item DB
		 * 
		 * @static
		 * @param int $id value of the field of the data to delete
		 * @param string $field name of the column to filter
		 * @param string $field_type type of the column to filter (can be '%s' for strings or '%d' for numeric values)
		 * @return bool true when query was executed succesfully, else return FALSE
		 * @access public
		 */
		static public function delete($id, $field='', $field_type='')
		{
			self::set_db_obj();
			if (self::$db_obj!=NULL)
	   			return self::$db_obj->delete($id,$field,$field_type);
	   		else 
	   			return FALSE;
		}
		
		/*
		 * End Common Code
		 * This can be avoid since PHP 5.3 (http://www.php.net/manual/en/language.oop5.late-static-bindings.php)
		 */
}
}
?>