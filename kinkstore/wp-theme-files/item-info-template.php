<?php
global $post_custom_fields, $products;
?>
<form action="<?php echo get_addtocart_action(); ?>" method="post" id="<?php echo get_add_tocart_form_id(); ?>">
	<h2 class="item-title"><?php the_title(); ?></h2>
	<div class="item-desc"><?php echo $post->post_content; ?>
		<?php print_custom_fields($post_custom_fields); ?>
	</div>
	<div class="item-price">
	<?php 
	echo replace_pricing_template($products, array(), PRODUCT_PRICES_TEMPLATE);
	?>
	</div>
	<?php 
	# "Add to Cart" btn is displayed only of the product is "Stock Available" and 'display_cart_btn' parameter=1
	echo replace_pricing_template($products, array('display_cart_btn'=>1), ITEM_TO_CART_TEMPLATE);
	?>
</form>