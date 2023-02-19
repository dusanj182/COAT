<?php
/**
 * Display Header.
 * @package Lighting Store
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php if ( function_exists( 'wp_body_open' ) ) {
	    wp_body_open();
	} else {
	    do_action( 'wp_body_open' );
	}?>
	<header role="banner">
		<a class="screen-reader-text skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'lighting-store' ); ?></a>
		<div class="header-box">
			<?php  get_template_part( 'template-parts/header/top', 'bar' ); ?>
			<div class="mid-header">
				<div class="container">
				  	<div class="row">
					  	<div class="col-lg-3 col-md-5 col-9 align-self-center">
					  		<?php get_template_part( 'template-parts/header/site', 'branding' ); ?>
					  	</div>
					  	<div class="col-lg-9 col-md-7 col-3 align-self-center">
					  		<div class="<?php if( get_theme_mod( 'lighting_store_sticky_header', false) != '') { ?>sticky-menubox<?php } else { ?>close-sticky <?php } ?>">
					    		<?php get_template_part( 'template-parts/navigation/site', 'nav' ); ?>
							</div>
					  	</div>
				 	</div> 
				</div>
		    </div>
		</div>
	</header>