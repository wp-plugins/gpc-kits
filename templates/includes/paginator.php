<?php
/**
 * Template to display paginator for any list
 *
 * //Class: request_offer
 * @uses number	$form['page_size'] //number of items per page
 * @uses number $form['next'] //number of the next page
 * @uses number $form['prev'] //number of the previous page
 * @uses number $form['current_page'] //number of the current page
 * @uses number $form['last_page'] //number of the current page
 * @uses string $form['url'] //url of the current page (with all get parameters except "page" parameter), this url will always contain the simbol "?" even if the url haven't parameters
 *
 * @package general
 * 
 * Security 
 *
 * Actions
 * 1- All files that display lists will have the action Go to page ($_GET['goto'])
 		- if this parameter is omited display the first page
		- if this parameter is greater thank the last page:
			- use last page
		- else if page no exist:
			- use the first page
 		- if the user cookie have a value for page size:
			- use it for the page size
		- else:
			- use the wp default page size
		- assign to $form['page_size'] the page size value
		- the list will display only items according page in $_GET['page']		
   2- Save Page Size ($_GET[page_size])
   		NOTE: This action will be done in all pages that display this template and before to display it.
   		- Save|Change in the user cookies this value
		- if this value is loaded to a sesssion variable: update it
 *
 * <code>
 <?php
	$form['page_size'] = 10;
	$form['next'] = '';
	$form['prev'] = 1;
	$form['current_page'] = 2;
	$form['last_page'] = 8;
	$form['url'] = B2bPlugin4::$plugin_url . '/pages/catalogue.php?';
 ?>
 * </code>
 * 
 */
?>
<div class="tablenav">
<div class="tablenav-pages"><span class="displaying-num"><?php _e('Displaying','b2b-plugin4')?> <?php echo $pagination_first_item?>&#8211;<?php echo $pagination_last_item?> of <?php echo $items_count?></span>
<?php if ($form['prev'] != '') { ?>
<a class='prev page-numbers' href='<?php echo $form['url']; ?>&amp;goto=<?php echo $form['prev']; ?>'>&laquo;</a>
<?php }
// Go trhough each page
for ($i=1;$i<=$form['last_page'];$i++) {
	if ($i==$form['current_page']) {
	?>
	<span class='page-numbers current'><?php echo $i ?></span>
	<?php } else { ?>
	<a class='page-numbers' href='<?php echo $form['url']; ?>&amp;goto=<?php echo $i ?>'><?php echo $i ?></a>
	<?php
	}
}
?>
<?php if ($form['next'] != '') { ?>
<a class='next page-numbers' href='<?php echo $form['url']; ?>&amp;goto=<?php echo $form['next']; ?>'>&raquo;</a>
<?php } ?>
</div>
</div>
<form method="get" action="<?php echo $form['url']; ?>&amp;goto=<?php echo $form['current_page']; ?>">
<?php foreach ($form['query_parameters'] as $name => $value) {?>
<input type="hidden" name="<?php echo $name?>" value="<?php echo $value ?>" />
<?php } ?>
<input type="hidden" name="goto" value="<?php echo $form['current_page']; ?>" />
<label for="page-size"><?php _e('Items per page','b2b-plugin4'); ?>:</label>
<input type="text" name="page_size" value="<?php echo $form['page_size']; ?>" id="page-size" size="2" />
<input type="submit" value="<?php _e('Save','b2b-plugin4'); ?>" />
</form>