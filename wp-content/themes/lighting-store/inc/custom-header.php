<?php
/**
 * @package Lighting Store
 * Setup the WordPress core custom header feature.
 *
 * @uses lighting_store_header_style()
*/
function lighting_store_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'lighting_store_custom_header_args', array(
		'default-text-color'     => 'fff',
		'header-text' 			 =>	false,
		'width'                  => 1200,
		'height'                 => 85,
		'flex-width'         	=> true,
        'flex-height'        	=> true,
		'wp-head-callback'       => 'lighting_store_header_style',
	) ) );
}
add_action( 'after_setup_theme', 'lighting_store_custom_header_setup' );

if ( ! function_exists( 'lighting_store_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see lighting_store_custom_header_setup().
 */
add_action( 'wp_enqueue_scripts', 'lighting_store_header_style' );
function lighting_store_header_style() {
	//Check if user has defined any header image.
	if ( get_header_image() ) :
	$lighting_store_custom_css = "
        .mid-header{
			background-image:url('".esc_url(get_header_image())."');
			background-position: center top;
			background-size: 100% 100%;
		}";
	   	wp_add_inline_style( 'lighting-store-basic-style', $lighting_store_custom_css );
	endif;
}
endif; // lighting_store_header_style