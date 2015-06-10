<?php get_header() ?>
			<section id="content">
				<h2 class="featured-title">Products</h2>
				<ul> 

				<?php
				//global $eshopoptions;

				//$fposts = eshop_list_featured('');
				//$fposts = eshopw_list_featured_sale('');
				$fposts = eshop_featured_products('');
				//print_r($fposts);
				//echo sizeof($fposts);
					 


				$args = array( 'posts_per_page' => 10, 'orderby' => 'rand', 'category' => $wp_query->query_vars['cat'] );
				$rand_posts = get_posts( $args );
				foreach ( $rand_posts as $post ) : 
					//** setup_postdata() fills the global variables $id, $authordata, $currentday, 
					//** $currentmonth, $page, $pages, $multipage, $more, $numpages
				  setup_postdata( $post ); 

				  product_short_info($eshopoptions, array('display_cart_btn'=>1)); //array('display_cart_btn'=>1, 'show_featured'=>0)
				
				endforeach; 
				wp_reset_postdata(); 
				?>

				</ul>
				
				
			</section>
<?php get_footer(); ?>