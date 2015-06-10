<?php get_header(); ?>

<section id="content">
	<div id="page-content">	

	<p> It's the shopping cart template only </p>
<?php 
if (have_posts()) : while (have_posts()) : the_post();

	the_content();
	
endwhile; endif;
 ?>
 	</div>
</section>
<?php get_footer(); ?>