
		</div>
		<section id="featured">
			<h2 class="featured-title">Hot Deals</h2>
			1. Please check why 'display_cart_btn'=>0 is not taken into consideration. 
			<br> 2. Hide this section if no featured images
			<div id="nav-featured" class="crsl-nav">
				<a href="#" class="previous">Previous</a>
				<a href="#" class="next">Next</a>

				<div class="crsl-items"  data-navigation="nav-featured">
				<ul class="crsl-wrap">
				<?php
					global $eshopoptions;
					
					$args = array( 'posts_per_page' => 10, 'orderby' => 'rand');
					$rand_posts = get_posts( $args );

					foreach ( $rand_posts as $post ) : 

						product_short_info($eshopoptions, array('display_cart_btn'=>0, 'show_featured'=>1)); 

					endforeach; 

					wp_reset_postdata();
				?>
					
				</ul>
			</div>
			</div>
			
		</section>
	</div>

	<?php //** footer_template.php should be included here is necessary ?>

	<scriptA type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/libs/jquery-2.1.1.min.js"></script>
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/main.js"></script>
	<script src="<?php echo get_template_directory_uri()?>/scripts/libs/responsiveCarousel.js"></script>

<!------------------ Gallery files ---------------->
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/features/ResponsiveImageGallery/js/jquery.tmpl.min.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/features/ResponsiveImageGallery/js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/features/ResponsiveImageGallery/js/jquery.elastislide.js"></script>
	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/features/ResponsiveImageGallery/js/gallery.js"></script>
<!------------------ end Gallery files ---------------->

	<!-- </div> --> <!-- closing #wrapper div -->
</body>
</html>