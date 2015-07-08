<?php get_header() ?>
<!----------- gallery files ---->
			<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/features/ResponsiveImageGallery/css/demo.css" />
			<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/features/ResponsiveImageGallery/css/style.css" />
			<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/features/ResponsiveImageGallery/css/elastislide.css" />
			
			<script id="img-wrapper-tmpl" type="text/x-jquery-tmpl">	
				<div class="rg-image-wrapper">
					{{if itemsCount > 1}}
						<div class="rg-image-nav">
							<a href="#" class="rg-image-nav-prev">Previous Image</a>
							<a href="#" class="rg-image-nav-next">Next Image</a>
						</div>
					{{/if}}
					<div class="rg-image"></div>
					<div class="rg-loading"></div>
					<div class="rg-caption-wrapper">
						<div class="rg-caption" style="display:none;">
							<p></p>
						</div>
					</div>
				</div>
			</script>
<!----- end gallery files -------->



			<section id="content">
				<p id="item-path">
					<?php 
					$cat = get_the_category();
					echo get_category_parents( $cat[0], true, ' &raquo; ' ); 

					?>	
				</p>			
			<?php
			global $product_prices_template, $products;
			
			// Start the loop.
			while ( have_posts() ) : the_post();
				$post_id = get_the_ID();
				$post = get_post($post_id);

				$products = get_eshop_product($post_id);

				get_custom_fields();
			?>
				<div class="item-img">
					<!--
					!!!!use $image_custom_fields to display the other images associated<br>
	<h1>стиловете на галерията override-ват стиловете на темплейта. Провери го! </h1>
-->

<!------------------------------------------------------------------------------>
					<?php //print_post_images($image_custom_fields); ?>
					<div id="rg-gallery" class="rg-gallery">
						<div class="rg-thumbs">
							<!-- Elastislide Carousel Thumbnail Viewer -->
							<div class="es-carousel-wrapper">
								<div class="es-nav">
									<span class="es-nav-prev">Previous</span>
									<span class="es-nav-next">Next</span>
								</div>
								<div class="es-carousel">
									<ul>
										<?php print_post_images($image_custom_fields); ?>
										<!-- 
										<li><a href="#"><img src="<?php echo get_template_directory_uri()?>/features/ResponsiveImageGallery/images/thumbs/1.jpg" data-large="<?php echo get_template_directory_uri()?>/features/ResponsiveImageGallery/images/1.jpg" alt="image01" data-description="From off a hill whose concave womb reworded" /></a></li>
										-->
									</ul>
								</div>
							</div>
							<!-- End Elastislide Carousel Thumbnail Viewer -->
						</div><!-- rg-thumbs -->
					</div><!-- rg-gallery -->


<!------------------------------------------------------------------------------>


				</div>
				<div class="item-info">
					<?php get_template_part( 'item-info-template' ); ?>
				</div>
				
				<div class="navigation"><?php previous_post_link('%link', '&laquo;&laquo; Previous ', 'yes'); ?>
						   |    <?php next_post_link('%link', 'Next &raquo;&raquo; ', 'yes'); ?></div>
			
			<?php
			// End the loop.
			endwhile;
			?>
			</section>


		
<?php get_footer(); ?>