<?php


function set_kinkstore_background(){
	// $background is the saved custom image, or the default image.
	$background = set_url_scheme( get_background_image() );

	// $color is the saved custom color.
	// A default has to be specified in style.css. It will not be printed here.
	$color = get_background_color();

	if ( $color === get_theme_support( 'custom-background', 'default-color' ) ) {
		$color = false;
	}

	if ( ! $background && ! $color )
		return;

	$style = $color ? "background-color: #$color;" : '';

	if ( $background ) {
		$image = " background-image: url('$background');";

		$repeat = get_theme_mod( 'background_repeat', get_theme_support( 'custom-background', 'default-repeat' ) );
		if ( ! in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) )
			$repeat = 'repeat';
		$repeat = " background-repeat: $repeat;";

		$position = get_theme_mod( 'background_position_x', get_theme_support( 'custom-background', 'default-position-x' ) );
		if ( ! in_array( $position, array( 'center', 'right', 'left' ) ) )
			$position = 'left';
		$position = " background-position: top $position;";

		$attachment = get_theme_mod( 'background_attachment', get_theme_support( 'custom-background', 'default-attachment' ) );
		if ( ! in_array( $attachment, array( 'fixed', 'scroll' ) ) )
			$attachment = 'scroll';
		$attachment = " background-attachment: $attachment;";

		
		//** for the kinkstore theme we expect to have background image with the "right" word in its name
		//** and a second image with the "left" word in its name, so let's check for the "left" one
		$second_bgr_image = get_left_background_image($background);
		if ($second_bgr_image) {
			$image = " background-image: url('$background'), url('$second_bgr_image');";
			$position = " background-position: top right, top left;";
		}
		
		$style .= $image . $repeat . $position . $attachment;
	}
?>
<style type="text/css" id="custom-background-css">
	body.custom-background { <?php echo trim( $style ); ?> }
</style>
<?php
}

function get_left_background_image($image_link){
	if (strpos($image_link,'right') !== false) {
	    $left_image_link = str_replace('right', 'left', $image_link);

	    if ($image_link !== $left_image_link) {
	    	# there are 'right' and 'left' images uploade so we can set them as backgrounds.
	    	return $left_image_link;
	    }

	    return '';
	}
}

/*
 * If there is custom header uploaded, change some CSS
 *
 * 
 *
 */
function set_kinkstore_header(){

	$header = get_header_image();
	if ($header) {
?>
	<style type="text/css" id="custom-header-css">
		#logo-bar{height: auto;}
	</style>
<?php
	}
}
/** Add to Cart form properties **/
function get_addtocart_action(){
	global $eshopoptions;
	return get_permalink($eshopoptions['cart']);		
}
function get_add_tocart_form_id(){
	global $post, $uniq;
	
	$postid = $post->ID;
	if (!isset($uniq)) {
		$uniq = rand();
	}
	else {
		//echo "$uniq was already set in 1<br>";
	}
	return 'eshopprod'.$postid.$uniq;
}



function custom_eshop_show_cart() {
	global $wpdb, $blog_id,$wp_query,$eshopoptions;
	$echo='';
	include ABSPATH . "wp-content/plugins/eshop/cart-functions.php";
	
	br();
	print_r($_POST) ; 
	br();
	print_r($_SESSION) ; 
	//cache
	eshop_cache();
	if(isset($_SESSION['eshopcart'.$blog_id]['error'])){
		$echo .= $_SESSION['eshopcart'.$blog_id]['error'];
		unset($_SESSION['eshopcart'.$blog_id]['error']);
	}
	if(isset($_SESSION['eshopcart'.$blog_id]['enote'])){
		$echo .= $_SESSION['eshopcart'.$blog_id]['enote'];
		unset($_SESSION['eshopcart'.$blog_id]['enote']);
	}
	if(isset($_SESSION['eshopcart'.$blog_id])){
		if((isset($wp_query->query_vars['eshopaction']) && urldecode($wp_query->query_vars['eshopaction'])=='cancel') && !isset($_POST['save'])){
			$echo.= "<h3>".__('The order was cancelled.','eshop')."</h3>"; 
			$echo.= '<p>'.__('We have not deleted the contents of your shopping cart in case you may want to edit its content.','eshop').'</p>';
		}
		if($eshopoptions['shop_page']!=''){
			$return=get_permalink($eshopoptions['shop_page']);
		}elseif(isset($_SESSION['lastproduct'.$blog_id])){
			$return=get_permalink($_SESSION['lastproduct'.$blog_id]);
		}else{
			$return=get_permalink($eshopoptions['cart']);
		}
		$echo.= display_cart($_SESSION['eshopcart'.$blog_id],'true', $eshopoptions['checkout']);
		$echo.='<ul class="continue-proceed eshopcp0"><li class="rtnshopping"><a href="'.$return.'">'.__('&laquo; Continue Shopping','eshop').'</a></li>
		<li class="gotocheckout"><a href="'.get_permalink($eshopoptions['checkout']).'">'.__('Proceed to Checkout &raquo;','eshop').'</a></li></ul>';
	}else{
		//can be altered as desired.
		$echo.= '<p><strong class="eshoperror error">'.__('Your shopping cart is currently empty.','eshop').'</strong></p>';
	}
	return $echo;
}
?>