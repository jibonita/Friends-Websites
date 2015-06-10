<?php
/**
 * The template for displaying Search Results pages.
 *
 * @package WordPress
 * @subpackage kinkstore
 */

get_header(); ?>

		<section id="content">
			<ul>

			<?php query_posts($query_string . '&cat=-'.get_category_by_slug($top_menu_category)->term_id); ?>
			<?php if ( have_posts() ) : ?>

				<h4 class="page-title">
				<?php
				echo 'Your search for “'. get_search_query() .'” returned “'. $wp_query->found_posts .'” posts in “';
				timer_stop(1);
				echo '” seconds.';
				?></h4>
				

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>

					<?php
						/* Include the Post-Format-specific template for the content.
						 * If you want to overload this in a child theme then include a file
						 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
						 */
						//get_template_part( 'content', get_post_format() );

						setup_postdata( $post ); 

				  		product_short_info($eshopoptions, array('display_cart_btn'=>1))
					?>

				<?php endwhile; ?>
			
			<?php else : ?>

				<article id="post-0" class="post no-results not-found">
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found' ); ?></h1>
					</header><!-- .entry-header -->

					<div class="empty-content">
						<p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'twentyeleven' ); ?></p><br />
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				</article><!-- #post-0 -->

			<?php endif; ?>

			</ul>
		</section><!-- #primary -->
	
<?php get_footer(); ?>