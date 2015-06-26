<?php
/**
 * Kinkstore Functions
 * 
 */

require_once(ABSPATH . 'wp-content/themes/kinkstore/functions_additional.php');
require_once(ABSPATH . 'wp-content/themes/kinkstore/constants.php');


function kinkstore_widgets_init() {
	
	//** this sidebar is not used in the template
	register_sidebar( array(
		'name'          => __( 'Left Sidebar', 'kinkstore' ),
		'id'            => 'left-sidebar',
		'description'   => __( 'Add Categories and Information p. here to appear in your sidebar.', 'kinkstore' ),
		'before_widget' => '',
		'after_widget'  => '',
		'before_title'  => '<h3 class="label">',
		'after_title'   => '</h3>',
	) );


	/* add background to the theme */
	$bgr_defaults = array(
		'default-color' 		 => '',
		//'wp-head-callback'       => '_custom_background_cb',
		'wp-head-callback'       => 'set_kinkstore_background',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support( 'custom-background', $bgr_defaults );

	/* add header to the theme */
	$header_defaults = array(
		'default-image'          => '',
		'width'                  => 0,
		'height'                 => 0,
		'flex-height'            => false,
		'flex-width'             => false,
		'uploads'                => true,
		'random-default'         => false,
		'header-text'            => true,
		'default-text-color'     => '',
		'wp-head-callback'       => 'set_kinkstore_header',
		'admin-head-callback'    => '',
		'admin-preview-callback' => '',
	);
	add_theme_support( 'custom-header', $header_defaults );

}

add_action( 'widgets_init', 'kinkstore_widgets_init' );

function list_topmenu_categories_twolevels(){
	$categories = get_categories( array(
		'child_of'                 => 0,
		'parent'                   => '0',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'exclude'                  => '1',
		'include'                  => '',
		'orderby'           	   => 'slug',
		'pad_counts'               => true 
	));

	$output = '';

	if ( !empty( $categories ) ) {
		$output = '<ul>';

		foreach ($categories as $category) {  
			$output .= '<li><a href="' . get_category_link( $category->term_id ) . '" title="' . sprintf( __( "View all posts in %s" ), $category->name ) . '" ' . ' $$AddClass$$>'.$category->cat_name;

			$categories_sub = get_categories( array(
				'child_of'                 => 0,
				'parent'                   => $category->cat_ID,
				'hide_empty'               => 0,
				'hierarchical'             => 1,
				'exclude'                  => '1',
				'include'                  => '',
				'orderby'           	   => 'slug',
				'pad_counts'               => true 
			));

			if ( !empty( $categories_sub ) ) {
				$output = str_replace('$$AddClass$$','', $output);

				$output .= '<div class="submenu"><ul>';
				foreach ($categories_sub as $category_sub) {
					$output .= '<li><a href="' . get_category_link( $category_sub->term_id ) . '">'.$category_sub->cat_name.'</a></li>';
				}
				$output .= '</ul></div>';
			}
			else{
				$output = str_replace('$$AddClass$$',' class="non-expand-item"', $output);
			}

			$output .= '</a></li>';
		}
		$output .= '</ul>';
	}

	return $output;
}


/*
list categories
*/
function list_categories_sidebar(){
	$result = wp_list_categories( array(
		'style'              => 'list',
		'orderby'            => 'slug',
		'hide_empty'         => 0,
		'use_desc_for_title' => 1,
		'exclude'            => '1',
		'hierarchical'       => 1,
		'title_li'           => __( '<h3 class="label">' .CATEGORIES_LABEL. '</h3>' ),
		'show_option_none'   => __( '' ),
		'number'             => null,
		'echo'               => 0
		  )); 

	echo substr($result, strpos($result, '>')+1, strlen($result)-strlen('</li>'));
}

//** Product short info template
// <li class="item crsl-item">
// 		<a href="#"><img src="images/item2.jpg"></a>
// 		<p class="item-title"><a href="#"2. the item title and the item title again</a></p>
// 		<p class="price"><span class="old-price">34.8</span>26.5</p>
// 		<a class="addtocard">Add to Cart</a>
// </li>
//---------------------------------------------------------------
//!!!!!! STEF:11.5.15 is it possible to use  php template file instead of php variable for these template???????
//---------------------------------------------------------------
// $PRODUCT_PRICES_TEMPLATE = get_template_part('tmplitemprice');
/*
$PRODUCT_PRICES_TEMPLATE = ' $$IF|SalePrice$$$$IF|BasicPrice$$<span class="old-price">$$PRICE$$</span>$$ENDIF|BasicPrice$$$$SALE_PRICE$$ $$ENDIF|SalePrice$$
 	$$IF|NotSalePrice$$ $$IF|BasicPrice$$$$PRICE$$$$ENDIF|BasicPrice$$ $$ENDIF|NotSalePrice$$';
*/

function fill_product_info_template($data, $args){
	$template = PRODUCT_INFO_TEMPLATE;
	
	if (is_array($data)) {

		if ($args['show_featured']=='1') {
			$show_featured = true;
		}
		else {
			$show_featured = false;
		}

		$is_displayed = (bool)($show_featured && strtolower($data['featured'])=='yes' || !$show_featured);

		if ($is_displayed) {
			$template = str_replace('$$PRODUCT_LINK$$', get_permalink(), $template);
			$template = str_replace('$$PRODUCT_TITLE$$', get_the_title(), $template);
			$template = str_replace('$$THUMBNAIL$$', get_the_post_thumbnail(get_the_ID(), array(225,165)), $template);
		
			$template = replace_pricing_template($data, $args, $template);

			echo $template;	
		}
	}
 }

function replace_pricing_template($data, $args, $template){
	global $eshopoptions;
	
	$currency_symbol = $eshopoptions['currency_symbol'].' ';
	
	if (is_array($data) && is_array($data['products']) &&
		is_array($data['products'][1])) {
 		//** get the first price option
			$price = $data['products'][1]['price'];
			$saleprice = $data['products'][1]['saleprice'];


		    $is_product_in_sale = (strtolower($data[sale])=="yes");
			$template = process_if($template, 'ProductInSale', $is_product_in_sale);
			$template = process_if($template, 'ProductNotInSale', !$is_product_in_sale);

			$template = process_if($template, 'SalePrice', (strlen($saleprice)>0));
			$template = process_if($template, 'NotSalePrice', !(strlen($saleprice)>0));
			$template = process_if($template, 'BasicPrice', (strlen($price)>0));

			$template = str_replace('$$SALE_PRICE$$', $currency_symbol.number_format_i18n((float)$saleprice, 2), $template);
			$template = str_replace('$$PRICE$$', $currency_symbol.number_format_i18n((float)$price,2), $template);

			# display Add to Cart button about this product only if "Stock Available" is selected
			$is_stock_available = get_post_meta( get_the_ID(), '_eshop_stock', true);
			$display_cart_btn = ($args['display_cart_btn']==1 && $is_stock_available);
			$template = process_if($template, 'DisplayCartButton', $display_cart_btn);
			if ($display_cart_btn) {
/* ----------------------------------------------------*/
				$template = generate_add_to_cart_button($data, $template);
				 

/* ----------------------------------------------------*/
				//$template = str_replace($template, '$$TEST_ADDTOCART_BTN$$', '<br>plugins\eshop\eshop-add-cart.php<hr>'.htmlspecialchars($result));
			}
			else{
				$template = str_replace($template, '$$TEST_ADDTOCART_BTN$$', '');
			}
			

	}
 	else {
		$template = process_if($template, 'ProductInSale', false);
		$template = process_if($template, 'ProductNotInSale', false);

		$template = process_if($template, 'SalePrice', true);
		$template = process_if($template, 'NotSalePrice', true);
		$template = process_if($template, 'BasicPrice', true);
		$template = process_if($template, 'DisplayCartButton', false);
	
		$template = str_replace('$$SALE_PRICE$$', '', $template);
		$template = str_replace('$$PRICE$$', '', $template);
	}

 	return $template;
}

function generate_add_to_cart_button($data, $template){
	global $eshopoptions, $wpdb, $post;
	
	$postid = $post->ID;
	$stkav = get_post_meta( $postid, '_eshop_stock',true);
    $eshop_product=maybe_unserialize(get_post_meta( $postid, '_eshop_product',true ));
	$stocktable = $wpdb->prefix ."eshop_stock";
	$uniq = rand();

	//** settings-> eShop -> General -> Product options -> Stock Control 
	if(isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']){
		$anystk = false;
		$stkq = $wpdb->get_results("SELECT option_id, available from $stocktable where post_id=$postid");
		foreach($stkq as $thisstk){
			$stkarr[$thisstk->option_id]=$thisstk->available;
		}
		//** settings-> eShop -> General -> Product options -> Options per product
		$opt=$eshopoptions['options_num'];
		for($i=1;$i<=$opt;$i++){
			$currst=0;
			if(isset($stkarr[$i]) && $stkarr[$i]>0) $currst=$stkarr[$i];
			if($currst>0){
				$anystk=true; 
				$i=$opt;
			}
		}
		if($anystk==false){
			$stkav='0';
			delete_post_meta( $postid, '_eshop_stock' );
		}
	}

	$hiddenfields = '';
	$stkav = apply_filters('eshop_show_addtocart', $stkav, $postid, $post);
	if ($stkav=='1') {
		$currsymbol=$eshopoptions['currency_symbol'];
		//** settings-> eShop -> General -> Product Details -> Add text before or after addtocart form 
		if(isset($eshopoptions['cart_text']) && $eshopoptions['cart_text']!='' && $short=='no'){
			if($eshopoptions['cart_text_where']=='1') 
				$template = '<p class="eshop-cart-text-above">'.stripslashes($eshopoptions['cart_text']).'</p>'.$template;
		}
		
		// $hiddenfields .= '
		// 	<form action="'.get_permalink($eshopoptions['cart']).'" method="post" class="eshop addtocart" id="eshopprod'.$postid.$uniq.'">';
		$template = str_replace('$$ADDTOCART_ACTION$$', get_permalink($eshopoptions['cart']), $template);
		$template = str_replace('$$POSTID_UNIQ$$', $postid.$uniq, $template);

		$theid = sanitize_file_name($data['sku']);

		//** if more than one pricing options entered.-> 
		//** The TEMPLATE IS NOT USING THIS CURRENTLY. There is only one price option that is displayed
		/* *
		if($eshopoptions['options_num']>1 && !empty($eshop_product['products']['2']['option']) && !empty($eshop_product['products']['2']['price'])){
			# not using this case currently
		}
		else {
		* */

		$option = $eshop_product['products']['1']['option'];
		$price = $eshop_product['products']['1']['price'];
		if(isset($eshopoptions['sale_prices']) && $eshopoptions['sale_prices'] == '1'
			&& isset($eshopoptions['sale']) && 'yes' == $eshopoptions['sale'] 
			&& isset($eshop_product['products']['1']['saleprice']) && $eshop_product['products']['1']['saleprice']!=''
			&& isset($eshop_product['sale']) && $eshop_product['sale']=='yes')
		{	
			$saleprice = $eshop_product['products']['1']['saleprice'];
		}

		$currst=1;
		if(isset($eshopoptions['stock_control']) && 'yes' == $eshopoptions['stock_control']){
			if(isset($stkarr[1]) && $stkarr[1]>0) $currst=$stkarr[1];
		}
		$mainoptsecho .='<input type="hidden" name="option" value="1" />';
		if($currst>0){
			if($price!='0.00'){
				$mainoptsecho.='
				<span class="sgloptiondetails"><span class="sgloption">'.stripslashes(esc_attr($option)).'</span> <span class="sglprice">'.sprintf( __('@ %1$s%2$s','eshop'), $currsymbol, number_format_i18n($price,__('2','eshop'))).'</span></span>
				';
			}else{
				$mainoptsecho.='
				<span class="sgloptiondetails"><span class="sgloption">'.stripslashes(esc_attr($option)).'</span></span>
				';
			}
		}

		// $replace .='<label for="qty'.$theid.$uniq.'" class="qty">'.__('<abbr title="Quantity">Qty</abbr>:','eshop').'</label>
		// <input type="text" value="'.$addqty.'" id="qty'.$theid.$uniq.'" maxlength="3" size="3" name="qty" class="iqty" />';
		$template = str_replace('$$SKU_UNIQ$$', $theid.$uniq, $template);

		$hiddenfields .='
		<input type="hidden" name="pclas" value="'.$eshop_product['shiprate'].'" />
		<input type="hidden" name="pname" value="'.stripslashes(esc_attr($eshop_product['description'])).'" />
		<input type="hidden" name="pid" value="'.$eshop_product['sku'].'" />
		<input type="hidden" name="purl" value="'.get_permalink($postid).'" />
		<input type="hidden" name="postid" value="'.$postid.'" />
		<input type="hidden" name="eshopnon" value="set" />';
		$hiddenfields .= wp_nonce_field('eshop_add_product_cart','_wpnonce'.$uniq,true,false);

		/** Disabled button type selection. Will alway be what the Button template has defined in its HTML **/
		// if($eshopoptions['addtocart_image']=='img'){
		// 	$eshopfiles=eshop_files_directory();
		// 	$imgloc=apply_filters('eshop_theme_addtocartimg',$eshopfiles['1'].'addtocart.png');
		// 	$hiddenfields .='<input class="buttonimg eshopbutton" src="'.$imgloc.'" value="'.__('Add to Cart','eshop').'" title="'.__('Add selected item to your shopping basket','eshop').'" type="image" />';
		// }else{
		// 	$hiddenfields .='<input class="button eshopbutton" value="'.__('Add to Cart','eshop').'" title="'.__('Add selected item to your shopping basket','eshop').'" type="submit" />';
		// }

		$hiddenfields .='<div class="eshopajax"></div>';
		//</form>';


		# not used: }
		//.........

		$template = str_replace('$$HIDDEN_FIELDS$$', $hiddenfields, $template);

		if(isset($eshopoptions['cart_text']) && $eshopoptions['cart_text']!=''  && $short=='no'){
			if($eshopoptions['cart_text_where']=='2') 
				$template .= '<p class="eshop-cart-text-below">'.stripslashes($eshopoptions['cart_text']).'</p>';
		}
	}
	
	//echo $hiddenfields;

	return $template;
}

function process_if($text, $tag, $condition){
	
	$openTagPos = strpos($text, '$$IF|'.$tag.'$$');
	if (!!$openTagPos) {
		$closeTagPos = strpos($text, '$$ENDIF|'.$tag.'$$', $openTagPos);
		if ($closeTagPos>$openTagPos) {
			$closeTagLength = strlen('$$ENDIF|'.$tag.'$$');

			if (!!$condition) {
				$text = str_replace('$$IF|'.$tag.'$$', '', $text);
				$text = str_replace('$$ENDIF|'.$tag.'$$', '', $text);
			}
			else {
				$substr = substr($text, $openTagPos, $closeTagPos+$closeTagLength-$openTagPos);
				$text = str_replace( $substr , '' , $text);
			}
		}
	}

	//echo htmlspecialchars($text);
	return $text;
	
}

//** Print product short info
function product_short_info($eshopoptions, $args){
	$products = get_eshop_product(get_the_ID());
		
	fill_product_info_template($products, $args);
}


/* Get featured Products */
function eshop_featured_products($atts){
	global $wpdb;

	$type='featured';
	$allowedsort=array('post_date','post_title','menu_order','random');
	$allowedorder=array('ASC','DESC');
	if(!in_array($sortby,$allowedsort)) 
		$sortby='post_title';
	if(!in_array($order,$allowedorder)) 
		$order='ASC';
	if($sortby=='random')
		$sortby='rand()';

	$pages=$wpdb->get_results("SELECT p.* from $wpdb->postmeta as pm,$wpdb->posts as p WHERE pm.meta_key='_eshop_".$type."' AND p.post_status='publish' AND p.ID=pm.post_id ORDER BY $sortby $order");

	return $pages;
}

/* print custom fields as dropdowns */
function print_custom_fields($array_fields){
	// $all_types_fields = types_get_fields();

	// foreach ( $all_types_fields as $key => $value ) {
	// 	$field_type = $value['type'];
	// 	if ($field_type !== 'image') {
	// 		$prefix = 'wpcf-';
	// 		$field = str_replace($prefix, '', $value['meta_key']);
	// 		$field_values = types_render_field( $field, array('output'=>'raw', 'show_name'=>'true '));
	// 		echo $field .': '. $field_values.'<br>';
	// 	}
 //    }
	$separator = ',';
	foreach ( $array_fields as $field ){
		$field_values = types_render_field( $field, array('output'=>'raw', 'show_name'=>'true ', 'separator'=>$separator));
		
		if (strlen(trim($field_values))>0) {

			$field_values_array = explode ( $separator , $field_values);

			//echo '<div class="custom-field field-'.$field.'">' . $field . ': <select>';
			echo "<div class=\"custom-field field-$field\">$field: <select>";
			foreach ($field_values_array as $value) {
				//echo '<option value="'.$value.'">' . $value . "</option>";
				echo "<option value=\"$value\">$value</option>";
			}
			echo '</select></div>';
		}
	}
}

function get_custom_fields(){
	global $image_custom_fields, $post_custom_fields;
	$image_custom_fields = array();
	$post_custom_fields = array();

	/*
	 * Detect plugin.  check if the types_get_fields exist, i.e if Types plugin is installed
	 */
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	// check for plugin using plugin name
	if ( is_plugin_active( 'types/wpcf.php' ) ) {
	  # plugin is activated

		$all_types_fields = types_get_fields();

		foreach ( $all_types_fields as $key => $value ) {
			$prefix = 'wpcf-';
			$field = str_replace($prefix, '', $value['meta_key']);

			$field_type = $value['type'];
			if ($field_type == 'image') {
				array_push($image_custom_fields, $field);
			}
			else if ($field_type == 'checkboxes') {
				array_push($post_custom_fields, $field);
			}
	    }
	} 
	else {
		//echo "Types is not activated";
	}
}

function print_post_images($array_fields){
	global $wpdb;

	$result = '';
	
	if ( has_post_thumbnail()) {
		//** get image meta data
		$post_thumbnail_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'thumbnail' );
		$post_large_image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id ), 'large' );

		$title = get_post(get_post_thumbnail_id())->post_title; //The Title
		$caption = get_post(get_post_thumbnail_id())->post_excerpt; //The Caption
		$description = get_post(get_post_thumbnail_id())->post_content; // The Description
		
		$result .= replace_image_in_post_template($post_thumbnail_image_url[0], $post_large_image_url[0],$title, $description);
	}
	
	$separator = ',';
	foreach ( $array_fields as $field ){
		$field_values = types_render_field( $field, array('output'=>'raw', 'show_name'=>'true ', 'separator'=>$separator));
		
		if (strlen(trim($field_values))>0) {

			$field_values_array = explode ( $separator , $field_values);
			
			foreach ($field_values_array as $value) {
				//** get image meta data by its URL
				$the_image_post = $wpdb->get_results("SELECT * FROM $wpdb->posts WHERE guid = '$value'");

				$post_thumbnail_image_url = wp_get_attachment_image_src( $the_image_post[0]->ID, 'thumbnail' );
				$post_large_image_url = wp_get_attachment_image_src( $the_image_post[0]->ID, 'large' );
				$title = $the_image_post[0]->post_title;
				$description = $the_image_post[0]->post_content;

				$result .= replace_image_in_post_template($post_thumbnail_image_url[0], $post_large_image_url[0],$title, $description);
			}
		}
		
	}

	echo $result;
}

function replace_image_in_post_template($thumb, $large, $title, $description){
	//** replace tags with image meta data
	$template = IMAGE_GALLERY_ITEM_TEMPLATE;
	$template = str_replace('$$THUMBNAIL$$', $thumb, $template);
	$template = str_replace('$$LARGE_IMAGE$$', $large, $template);
	$template = str_replace('$$ALT_TEXT$$', $title, $template);
	$template = str_replace('$$DESCRIPTION$$', $description, $template);

	return $template;
}

function br(){
	echo '<br>';
}






?>