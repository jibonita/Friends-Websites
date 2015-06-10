<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element, banner and aside bar
 *
 * @package KinkStore Theme
 * 
 */
?><!DOCTYPE html>
<html>
<head>
	<title><?php bloginfo('name'); ?><?php wp_title(); ?></title>

	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	
	<!-- <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/styles/reset.css" /> -->
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url')?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/styles/skin.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri()?>/styles/media-queries.css" />

	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">var appPath = '<?php echo get_template_directory_uri()?>/';</script>

    </style>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<!-- <div id="wrapper"> -->
	<div id="account-bar">
		<a href="  <?php echo site_url(); ?>/shopping-cart">Shopping Cart Temp Link</a>
		<div class="holder">
			Some Lang choice
			<ul id="lang">
				<li>BG</li>
				<li>EN</li>
				<li>DE</li>
			</ul>
			Currency choice
			<ul id="currency">
				<li>LV</li>
				<li>USD</li>
				<li>EUR</li>
			</ul>
		</div>
	</div>
	<div class="holder">
		<header>
			<div id="logo-bar">
				<?php
				$header = get_header_image();
				if ($header) {
				?>
				<img src="<?php header_image(); ?>" height="auto" width="100%" alt="" />
				<?php
				}
				else {
				?>
				<div id="logo"><a href="<?php echo home_url(); ?>">
					<span>KINK</span><span>STORE</span><span></span><span>NET</span></a>
				</div>
				<?php	
				}
				?>
				<div class="navbar-fluid">
					<button type="button" class="navbar-toggle">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>
				<!-- <div id="search-box">
					<?php get_search_form(); ?>
				</div> -->
			</div>
			<nav id="menu">
				<?php //echo list_topmenu_categories_twolevels(); ?>
				
				<?php
				wp_nav_menu( array(
					'container'       => '',
					) );
				?>

				<div id="search-box">
					<?php get_search_form(); ?>
				</div>
			</nav>
		</header>
		<!-- <div id="banner"></div> -->
		<div id="container">
			<aside id="sidebar">
				<?php list_categories_sidebar();  ?> 			

				<?php //dynamic_sidebar( 'left-sidebar' ); ?>
			</aside>