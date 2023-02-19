<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @author      WooThemes
 * @package     WooCommerce/Templates
 * @version     4.9.0
 */
if (!defined('ABSPATH')) {
	exit;
}


if ( ! function_exists( 'crp_get_all_product_ids_from_cat_ids' ) ) {

	/**
	* Get all product ids from the given category ids
	* @since 1.3.7
	* @return array  
	*/
	function crp_get_all_product_ids_from_cat_ids( array $cat_ids ) {
		$all_ids = get_posts(
			array(
				'post_type'		 => 'product',
				'numberposts'	 => -1,
				'post_status'	 => 'publish',
				'fields'		 => 'ids',
				'tax_query'		 => array(
					array(
						'taxonomy'	 => 'product_cat',
						'field'		 => 'term_id',
						'terms'		 => $cat_ids,
						'operator'	 => 'IN',
					)
				),
			)
		);

		return $all_ids;
	}
}

if ( ! function_exists( 'crp_get_all_product_ids_from_tag_ids' ) ) {

	/**
	* Get all product ids from the given tag ids
	* @since 1.3.7
	* @return array  
	*/
	function crp_get_all_product_ids_from_tag_ids( array $tag_ids ) {
		$all_ids = get_posts(
			array(
				'post_type'		 => 'product',
				'numberposts'	 => -1,
				'post_status'	 => 'publish',
				'fields'		 => 'ids',
				'tax_query'		 => array(
					array(
						'taxonomy'	 => 'product_tag',
						'field'		 => 'term_id',
						'terms'		 => $tag_ids,
						'operator'	 => 'IN',
					)
				),
			)
		);

		return $all_ids;
	}
}

if ( ! function_exists( 'crp_get_all_product_ids_from_attr_ids' ) ) {

	/**
	* Get all product ids from the given attributes
	* @since 1.4.0
	* @return array  
	*/
	function crp_get_all_product_ids_from_attr_ids( array $attr_data ) {
	
		$tax_query = array( 'relation'=> 'OR' );
		foreach ($attr_data as $attr_name => $attr_term_ids) {
			$tax_query[] = array(
				'taxonomy'        => "pa_$attr_name",
				'terms'           =>  $attr_term_ids,
				'operator'        => 'IN',
			);
		}
		$all_ids = new WP_Query(
			array(
				'post_type'		 => array('product', 'product_variation'),
				'posts_per_page'	 => -1,
				'post_status'	 => 'publish',
				'fields'		 => 'ids',
				'tax_query' => $tax_query
			)
		);

		if( $all_ids->have_posts() ) {
			return $all_ids->posts;
		}    

		return array();
	}
}

$global_related_by = (array) apply_filters( 'wt_crp_global_related_by', get_option('custom_related_products_crp_related_by') );

if ( $related_products || !empty($global_related_by) ) :

?>

	<section class="related products wt-related-products">

		<?php
		$slider_state	 = get_option('custom_related_products_slider');
		$crp_title		 = get_option('custom_related_products_crp_title', esc_html__('Related Products', 'wt-woocommerce-related-products'));
		$crp_heading 	 = apply_filters('wt_related_products_heading', "<h2 class='wt-crp-heading'>" . esc_html( $crp_title ) . " </h2>", $crp_title);

		$bxslider		 = '';
                $few_slider		 = '';
		
		
		global $post;

		// when rendering through shortcode
		if (isset($shortcode_post)) {

			$post = $shortcode_post;
		}
		
		$working_mode = class_exists('Custom_Related_Products') ? Custom_Related_Products::get_current_working_mode() : '';

		if ( $working_mode == 'custom' ) {

			$current_post_id = $post->ID;
			global $sitepress;
			$use_primary_id_wpml = apply_filters( 'wt_crp_use_primary_id_wpml', get_option('custom_related_products_use_primary_id_wpml') );
			if( $use_primary_id_wpml == 'enable' && isset( $sitepress ) && defined('ICL_LANGUAGE_CODE') ) {
				$default_lang = $sitepress->get_default_language();
				if( $default_lang != ICL_LANGUAGE_CODE && function_exists('icl_object_id') ) {
					$default_id = icl_object_id ($post->ID, "product", false, $default_lang);
					$default_post = get_post( $default_id );
					$post = $default_post;
				}
			}

			$reselected = get_post_meta($post->ID, 'selected_ids', true);

			if (!empty($reselected)) {
				add_post_meta($post->ID, '_crp_related_ids', $reselected);
			}

			$related = apply_filters( 'wt_crp_related_product_ids', array_filter(array_map('absint', (array) get_post_meta($post->ID, '_crp_related_ids', true))));

			


			//gets selected related categories
			$related_categories_ids = apply_filters( 'wt_crp_related_category_ids',array_filter(array_map('absint', (array) get_post_meta($post->ID, '_crp_related_product_cats', true))));
				
			//gets selected related tags
			$related_tags_ids = apply_filters( 'wt_crp_related_tag_ids', get_post_meta($post->ID, '_crp_related_product_tags', true) );
			
			//gets selected related attributes
			$related_attr_ids = apply_filters( 'wt_crp_related_attribute_ids', get_post_meta($post->ID, '_crp_related_product_attr', true) );
		
			if(!empty($related) || !empty($related_categories_ids) || !empty($related_tags_ids) || !empty($related_attr_ids)) {

				if (!empty($related_categories_ids)) {
					$all_ids = crp_get_all_product_ids_from_cat_ids( $related_categories_ids );

					if (!empty($related)) {
						$related = array_merge($all_ids, $related);
					} else {
						$related = $all_ids;
					}
				}
	
				if (!empty($related_tags_ids) && is_array($related_tags_ids)) {
					$all_ids = crp_get_all_product_ids_from_tag_ids( $related_tags_ids );

					if (!empty($related)) {
						$related = array_merge($all_ids, $related);
					} else {
						$related = $all_ids;
					}
				}

				if (!empty($related_attr_ids)) {

					$all_ids = crp_get_all_product_ids_from_attr_ids( $related_attr_ids );

					if (!empty($related)) {
						$related = array_merge($all_ids, $related);
					} else {
						$related = $all_ids;
					}
				}
			} else if(!empty($global_related_by)) {
				
				if( in_array( 'category', $global_related_by ) ) {
					$product_cat_ids = array();
					$prod_terms = get_the_terms( $post->ID, 'product_cat' );
					

					if ( ! empty( $prod_terms ) && ! is_wp_error( $prod_terms ) ) {
						$subcategory_only = apply_filters('wt_crp_subcategory_only', false);
						$category_count = count($prod_terms);
                        $term_ids = array_column($prod_terms, 'term_id');

						foreach ($prod_terms as $prod_term) {
							if( $subcategory_only && $category_count > 1 ) {
                                $has_term_id = false;
                                $children = function_exists('get_categories') ? get_categories( array ('taxonomy' => 'product_cat', 'child_of' => $prod_term->term_id )) : array();
                                foreach ($children as $term) {
                                    if( in_array($term->term_id, $term_ids) ) {
                                        $has_term_id = true;
                                        break;
                                    }
                                }
                                
                                if ( count($children) == 0 || !$has_term_id ) {
									// if no children, then it may be the deepest sub category.
									$product_cat_ids[] = $prod_term->term_id;
								}
							}else {
								// gets product cat id
								$product_cat_ids[] = $prod_term->term_id;
							}	
						}
						if(!empty($product_cat_ids)) {
							$related = crp_get_all_product_ids_from_cat_ids( $product_cat_ids );
						}
					}
					
				}

				if( in_array( 'tag', $global_related_by ) ) {
					$product_tag_ids = $related_ids = array();
					$prod_terms = get_the_terms( $post->ID, 'product_tag' );
					if ( ! empty( $prod_terms ) && ! is_wp_error( $prod_terms ) ) {
						foreach ($prod_terms as $prod_term) {
							// gets product tag id
							$product_tag_ids[] = $prod_term->term_id;
						}
						if(!empty($product_tag_ids)) {
							$related_ids = crp_get_all_product_ids_from_tag_ids( $product_tag_ids );
							$related = ( !empty($related) && is_array($related) ) ? array_merge($related, $related_ids) : $related_ids;
						}
					}
				}
			}

			//gets excluded categories
			$excluded_categories_ids = apply_filters( 'wt_crp_excluded_category_ids',get_post_meta($post->ID, '_crp_excluded_cats', true) );

			if (!empty($excluded_categories_ids) && !empty($related)) {
				$all_ids = crp_get_all_product_ids_from_cat_ids( $excluded_categories_ids );

				if (!empty($all_ids)) {
					$related = array_diff($related, $all_ids);
				}
			}

			delete_post_meta($post->ID, 'selected_ids');
			$related	= is_array($related) ? array_diff($related, array($post->ID, $current_post_id)) : array();
			if (!empty($related)) {

				$related_products	 = array();
				$copy				 = array();
				
				$related_products	 = $related;
				while (count($related_products)) {
					// takes a rand array elements by its key
					$element			 = array_rand($related_products);
					// assign the array and its value to an another array
					$copy[$element]	 = $related_products[$element];
					//delete the element from source array
					unset($related_products[$element]);
				}

				$number_of_products	 = get_option('custom_related_products_crp_number', 3);
				$number_of_products	 = apply_filters('wt_related_products_number', $number_of_products);
				$orderby 			 = get_option('custom_related_products_crp_order_by', 'title');
				$orderby			 = apply_filters('wt_related_products_orderby', $orderby);
				$order 				 = get_option('custom_related_products_crp_order', 'ASC');	
				$order				 = apply_filters('wt_related_products_order', $order);

				$i = 1;

				// Setup your custom query
				$args = array(
					'post_type' => 'product', 
					'posts_per_page' => $number_of_products, 
					'orderby' => $orderby, 
					'order' => $order, 
					'post__in' => $copy
				);
				$custom_orderby = class_exists('Custom_Related_Products') ? Custom_Related_Products::get_custom_order_by_values() : array();
				if( array_key_exists( $orderby, $custom_orderby ) ) {
					$args['orderby'] =  $custom_orderby[$orderby]['orderby'];
					$args['meta_key'] = $custom_orderby[$orderby]['meta_key'];
				}
				
				// To exclude out of stock products
				$exclude_os	 = get_option('custom_related_products_exclude_os');
				if (!empty($exclude_os)) {
					$args['meta_query'] = array(
						array(
							'key'       => '_stock_status',
							'value'     => 'outofstock',
							'compare'   => 'NOT IN'
						)
					);
				}
                                $copy = apply_filters("woocommerce_crp_set_product_visibility", $copy);  
                                
                                if ('enable' == $slider_state) :
                                    $auto_start_slider = apply_filters('wt_custom_related_products_slider_autostart', false);
                                    $bxslider = 'bxslider';
                                    $slide_width = get_option('custom_related_products_crp_banner_width') ? get_option('custom_related_products_crp_banner_width'): 100;//apply_filters('wt_crp_slide_width', 300);
                                    $slider_touch = apply_filters('wt_crp_slider_touch_enabled', true);
                                    $min_slides = get_option('custom_related_products_crp_banner_product_width') ? get_option('custom_related_products_crp_banner_product_width'): 3;//apply_filters('wt_crp_min_slides', 3);
                                    //$max_slides = apply_filters('wt_crp_max_slides', 3);
                                    if(count($copy) < $min_slides){
                                        $slide_width = count($copy) * ($slide_width / $min_slides);
                                        $min_slides = count($copy);
                                        $few_slider = true;
                                    }
                                    $slide_width = $slide_width.'%';

                                    ?>

                                    <script>

                                        jQuery(document).ready(function () {
                                        // Swiper: Slider
                                        new Swiper('.swiper-container', {
                                          loop: true,
                                          nextButton: '.swiper-button-next',
                                          prevButton: '.swiper-button-prev',
                                          slidesPerView: <?php echo $min_slides ?>,
                                          paginationClickable: true,
                                          spaceBetween: 10,
                                          breakpoints: {


                                            480: {
                                              slidesPerView: 1,
                                              spaceBetween: 10 } } });



                                      });
                                    </script>
                                    <style>
                                        <?php if($few_slider === true){?>
                                        .wt-related-products .wt-crp-heading{
                                            text-align : center;
                                        }
                                        <?php }?>
                                          .swiper-container {
                                            width:<?php echo $slide_width ?>;
                                            height: 50%;
                                        }
                                        .swiper-slide {
                                            text-align: center;
                                            font-size: 18px;
                                            background: #fff;

                                            /* Center slide text vertically */
                                            display: -webkit-box;
                                            display: -ms-flexbox;
                                            display: -webkit-flex;
                                            display: flex;
                                            -webkit-box-pack: center;
                                            -ms-flex-pack: center;
                                            -webkit-justify-content: center;
                                            justify-content: center;
                                            -webkit-box-align: center;
                                            -ms-flex-align: center;
                                            -webkit-align-items: center;
                                            align-items: center;
                                        }
                                        .swiper-slide li {
                                            list-style-type: none;display: flex;
                                        flex-direction: column;

                                        }
                                         .swiper-slide h2 {
                                              font-size: 22px;
                                              font-weight: 400;
                                              margin-bottom: .5rem !important;
                                              margin-top: 1rem !important;
                                         }
                                         .swiper-slide .amount {
                                              color:#8f8a8a !important;
                                         }
                                         .swiper-slide .button {
                                              background-color: #28303d;
                                               color: #eeeeee;
                                                margin-top: .5rem !important;
                                                /*width: 68% !important;*/
                                                margin: 0 auto ;

                                         }
                                          .swiper-slide a {
                                            text-decoration: none !important;
                                        }

                                    </style>
                            <?php endif; ?>
                            <?php                     
				$loop	 = new WP_Query($args);
				if($loop->have_posts()) {
					echo $crp_heading;

					if ($bxslider) {
                                        ?>
                                    <div class='swiper-container'>
                                        <!-- Additional required wrapper -->
                                        <div class='swiper-wrapper'>
						<?php 
					} else {
						woocommerce_product_loop_start();
					}

					while ($loop->have_posts()) : $loop->the_post();
                                        if ($bxslider) {
						?>
						<div class="swiper-slide">
						<?php 
					}
						wc_get_template_part('content', 'product'); 
                                                if ($bxslider) {
						?>
						</div>
						<?php 
					}
					endwhile; // end of the loop. 
					woocommerce_product_loop_end();
                                        if ($bxslider) {
                                                ?>
                                             </div>

                                                <!-- If we need navigation buttons -->
                                                <div class='swiper-button-prev'></div>
                                                <div class='swiper-button-next'></div>
                                            </div>
                                        <?php 
					} 
				}
			} else {
				?>
				<section class="related_products" style="display: none;"></section>
			<?php
			}
		} else if( $working_mode == 'default' && !empty( $related_products )) {
			?>
			<?php echo $crp_heading; ?>
			<?php
			$crelated = get_post_meta($post->ID, '_crp_related_ids', true);

			if (!empty($crelated))
				update_post_meta($post->ID, 'selected_ids', $crelated);
			?>
			<?php if ($bxslider) { ?>
				<ul class="<?php echo esc_attr( $bxslider ); ?> crp-slider products columns-<?php echo esc_attr(wc_get_loop_prop('columns')); ?>">
				<?php } else {

				woocommerce_product_loop_start();
			} ?>
				<?php
				foreach ($related_products as $related_product) :
					if (!is_object($related_product)) {
						$related_product = wc_get_product($related_product);
					}

					$post_object		 = get_post($related_product->get_id());
					setup_postdata($GLOBALS['post']	 = &$post_object);
					wc_get_template_part('content', 'product');
				?>
			<?php
				endforeach;
				woocommerce_product_loop_end();
		}
		?>

	</section>

<?php
endif;
wp_reset_postdata();


