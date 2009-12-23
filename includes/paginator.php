<?php
/**
 * Include to show the paginator
 * 
 * Called from all page with lists
 * 
 * @uses	int		$items_count	the number of items in the list to paginate
 * @uses 	bool	$show_tpl		determine when to show the template file, or only calculate the pagination's variables		
 */

/*
 * Set the page size
 */
@session_start();
if (isset($_GET['page_size'])) {
	// Set value in cookie
	GpcKits_Cookies::add_cookie( GpcKits_Cookies::$cookie_pagination_page_size , $_GET['page_size']);
	$_SESSION[ GpcKits_Cookies::$cookie_pagination_page_size ] = $_GET['page_size'];
	$form['page_size'] = $_GET['page_size'];
}
else {
	// if the user cookie have a value for page size, use it for the page size
	if (isset($_SESSION[ GpcKits_Cookies::$cookie_pagination_page_size ]))
		$form['page_size'] = $_SESSION[ GpcKits_Cookies::$cookie_pagination_page_size ];
	elseif (isset($_COOKIE[ GpcKits_Cookies::$cookie_pagination_page_size ]))
		$form['page_size'] = $_COOKIE[ GpcKits_Cookies::$cookie_pagination_page_size ];
	else { // use the wp default page size
		$form['page_size'] = get_option('posts_per_page');
	}
}

/*
 * Calculate the last page
 */
$form['last_page'] = ceil($items_count / $form['page_size']);

/*
 * Set the current page
 */

$form['current_page'] = 1;
if (isset($_REQUEST['goto'])) {
	if ($_REQUEST['goto']!='' && $_REQUEST['goto']!='0') {
		$form['current_page'] = $_REQUEST['goto'];
	}
}

if ($form['current_page']>$form['last_page'])
	$form['current_page'] = $form['last_page'];
	
// Define first and last item to show of list
$pagination_first_item = ( ($form['current_page'] - 1) * $form['page_size'] ) + 1;
$pagination_last_item = $pagination_first_item + $form['page_size'] - 1;
if ($pagination_last_item>$items_count)
	$pagination_last_item = $items_count;

/*
 * Set the next page
 */
$form['next'] = '';
$next_page = $form['current_page'] + 1;
if ($next_page<=$form['last_page'])
	$form['next'] = $next_page;

/*
 * Set the previous page
 */
$form['prev'] = '';
$prev_page = $form['current_page'] - 1;
if ($prev_page>=1)
	$form['prev'] = $prev_page;

/*
 * Get url of the current page (with all get parameters except "goto" and "a" parameter), 
 * this url will always contain the simbol "?" even if the url haven't parameters
 */
$form['url'] = GpcKits_Miscellaneous::get_current_url(array('goto','a'));
if (substr_count($form['url'],'?')==0)
	$form['url'] .= '?';

// Get parameters passed by GET, except "goto" parameter
$form['query_parameters'] = GpcKits_Miscellaneous::get_parameters_by_get('goto');

if ($show_tpl) {
	// Include the template
	include( GpcKits::$plugin_dir . '/templates/includes/paginator.php');
}
?>