<?php get_header(); ?>

<section id="content">
	<div id="page-content">	

	<p> It's the shopping cart template only </p>
<?php 
if (have_posts()) : while (have_posts()) : the_post();

	//the_content();
	
	if (function_exists('custom_eshop_show_cart')) {
		echo 'eshop_show_cart exists';
		echo custom_eshop_show_cart();
	}
	else{
		echo 'eshop_show_cart DOES NOT exist';
	}
	
endwhile; endif;



 ?>
 	</div>
</section>
<?php get_footer(); ?>