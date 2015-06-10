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

/////////////////////////////////////////////////////////////////////////
/*
override wp_list_categories

*/
function wp_list_categories_custom1( $args = '' ) {
	$defaults = array(
		'show_option_all' => '', 'show_option_none' => __('No categories'),
		'orderby' => 'name', 'order' => 'ASC',
		'style' => 'list',
		'show_count' => 0, 'hide_empty' => 1,
		'use_desc_for_title' => 1, 'child_of' => 0,
		'feed' => '', 'feed_type' => '',
		'feed_image' => '', 'exclude' => '',
		'exclude_tree' => '', 'current_category' => 0,
		'hierarchical' => true, 'title_li' => __( 'Categories' ),
		'echo' => 1, 'depth' => 0,
		'taxonomy' => 'category'
	);

	$r = wp_parse_args( $args, $defaults );

	// if ( !isset( $r['pad_counts'] ) && $r['show_count'] && $r['hierarchical'] )
	// 	$r['pad_counts'] = true;

	// if ( true == $r['hierarchical'] ) {
	// 	$r['exclude_tree'] = $r['exclude'];
	// 	$r['exclude'] = '';
	// }

	// if ( ! isset( $r['class'] ) )
	// 	$r['class'] = ( 'category' == $r['taxonomy'] ) ? 'categories' : $r['taxonomy'];

	// if ( ! taxonomy_exists( $r['taxonomy'] ) ) {
	// 	return false;
	// }

	$show_option_all = $r['show_option_all'];
	$show_option_none = $r['show_option_none'];

	$categories = get_categories( $r );

	
	$output = '';
	if ( $r['title_li'] && 'list' == $r['style'] ) {
		$output = '<li class="' . esc_attr( $r['class'] ) . '">' . $r['title_li'] . '<ul>';
	}
	if ( empty( $categories ) ) {
		if ( ! empty( $show_option_none ) ) {
			if ( 'list' == $r['style'] ) {
				$output .= '<li class="cat-item-none">' . $show_option_none . '</li>';
			} 
			// else {
			// 	$output .= $show_option_none;
			// }
		}
	} else {
		if ( ! empty( $show_option_all ) ) {
			$posts_page = ( 'page' == get_option( 'show_on_front' ) && get_option( 'page_for_posts' ) ) ? get_permalink( get_option( 'page_for_posts' ) ) : home_url( '/' );
			$posts_page = esc_url( $posts_page );
			if ( 'list' == $r['style'] ) {
				$output .= "<li class='cat-item-all'><a href='$posts_page'>$show_option_all</a></li>";
			} 
			// else {
			// 	$output .= "<a href='$posts_page'>$show_option_all</a>";
			// }
		}

		if ( empty( $r['current_category'] ) && ( is_category() || is_tax() || is_tag() ) ) {
			$current_term_object = get_queried_object();
			if ( $current_term_object && $r['taxonomy'] === $current_term_object->taxonomy ) {
				$r['current_category'] = get_queried_object_id();
			}
		}

		if ( $r['hierarchical'] ) {
			$depth = $r['depth'];
		} else {
			$depth = -1; // Flat.
		}
		$output .= walk_category_tree( $categories, $depth, $r );
	}

	if ( $r['title_li'] && 'list' == $r['style'] )
		$output .= '</ul></li>';

	/**
	 * Filter the HTML output of a taxonomy list.
	 *
	 * @since 2.1.0
	 *
	 * @param string $output HTML output.
	 * @param array  $args   An array of taxonomy-listing arguments.
	 */
	$html = apply_filters( 'wp_list_categories', $output, $args );

	if ( $r['echo'] ) {
		echo $html;
	} else {
		return $html;
	}
}

/**
	 * Starts the list before the elements are added.
	 *
	 * @see Walker::start_lvl()
	 *
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of category. Used for tab indentation.
	 * @param array  $args   An array of arguments. Will only append content if style argument value is 'list'.
	 *                       @see wp_list_categories()
	 */
	 function start_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent<div class='submenu'><ul class='children'>\n";
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @see Walker::end_lvl()
	 *
	 * @since 2.1.0
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param int    $depth  Depth of category. Used for tab indentation.
	 * @param array  $args   An array of arguments. Will only append content if style argument value is 'list'.
	 *                       @wsee wp_list_categories()
	 */
	 function end_lvl( &$output, $depth = 0, $args = array() ) {
		if ( 'list' != $args['style'] )
			return;

		$indent = str_repeat("\t", $depth);
		$output .= "$indent</ul></div>\n";
	}



?>