<?php

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Custom_Related_Products
 * @subpackage Custom_Related_Products/public
 * @author     markhf
 */
class Custom_Related_Products_Public {

    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $plugin_name    The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string    $version    The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     * @param      string    $plugin_name       The name of the plugin.
     * @param      string    $version    The version of this plugin.
     */
    public function __construct($plugin_name, $version) {

        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_styles() {
        //wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/custom-related-products-public.css', array(), $this->version, 'all');
		$slider_state	 = get_option( 'custom_related_products_slider' );
		if('enable' == $slider_state){
			wp_enqueue_style('swiper-css', plugin_dir_url(__FILE__) . 'css/swiper.min.css', array(), $this->version, 'all');
		}
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {

        //wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/custom-related-products-public.js', array('jquery'), $this->version, false);
		$slider_state	 = get_option( 'custom_related_products_slider' );
		if('enable' == $slider_state){
                  wp_enqueue_script('swiper-js', plugin_dir_url(__FILE__) . 'js/swiper.min.js', array('jquery'), $this->version, false);	
		}
    }

    public function crp_filter_related_products($args) {
        
        global $post;
        $related = get_post_meta($post->ID, '_crp_related_ids', true);

        $related_categories_ids = get_post_meta($product_id, '_crp_related_product_cats', true);
		$related_tags_ids = get_post_meta($product_id, '_crp_related_product_tags', true);

        $related = $this->get_product_category_ids($related_categories_ids,$related);
		$related = $this->get_product_tag_ids($related_tags_ids,$related);

        $disable = get_option('custom_related_products_disable');
        if (isset($related) && !empty($related) && !empty($disable)) { 
            $args['post__in'] = $related;
        } elseif(empty($disable)) { 
            $args = $args;
        }

        return $args;
    }

    public function crp_woocommerce_locate_template($template, $template_name, $template_path) {
       
       
        global $woocommerce;
        $_template = $template;

        if (!$template_path) {
            $template_path = $woocommerce->template_url;
        }

        $plugin_path = CRP_PLUGIN_DIR_PATH . '/woocommerce/';
        
        $template = locate_template(
                array(
                    $template_path . $template_name,
                    $template_name
                )
        );
       
        $overide_theme_rp = ( get_option('custom_related_products_overide_theme_rp', 'enable') == 'enable') ? true : false;
        $override_theme_template = apply_filters( 'wt_crp_override_theme_template', $overide_theme_rp );
        if ( ( !$template ||  $override_theme_template ) && file_exists($plugin_path . $template_name) ) {
            $template = $plugin_path . $template_name;
        }
        // Use default template

        if (!$template) {
            $template = $_template;
        }
        // Return what we found
        return $template;
    }
    function wt_woocommerce_output_related_products() {
        global $product;

		if ( ! $product ) {
			return;
		}
        $related_products = wc_get_related_products( $product->get_id() );
        wc_get_template( 'single-product/related.php', array( 'related_products' => $related_products ), plugin_dir_path( __FILE__ ) . 'woocommerce/', '' );
    }
    
    function crp_display_ids( $result, $product_id ) {
        
        $related_ids = get_post_meta( $product_id, '_crp_related_ids', true );

        $related_categories_ids = get_post_meta($product_id, '_crp_related_product_cats', true);
		
		$related_tag_ids = get_post_meta($product_id, '_crp_related_product_tags', true);

        $related_ids = $this->get_product_category_ids($related_categories_ids,$related_ids);
		$related_ids = $this->get_product_tag_ids($related_tag_ids,$related_ids);

        return empty( $related_ids ) ? $result : true;
		
     }
        
        
	function crp_remove_taxonomy( $result, $product_id ) {
            
        $related = get_post_meta( $product_id, '_crp_related_ids', true );
        
        $related_categories_ids = get_post_meta($product_id, '_crp_related_product_cats', true);
		
		$related_tag_ids = get_post_meta($product_id, '_crp_related_product_tags', true);

        $related = $this->get_product_category_ids($related_categories_ids,$related);
		
		$related = $this->get_product_tag_ids($related_tag_ids,$related);

        if ( ! empty( $related ) ) {
            return false;
        } else {
            return $result;
        }
    }
    
    function crp_related_products_query( $query, $product_id ) {
        $modify_default_mode_query = apply_filters( 'wt_crp_modify_default_mode_query', false );
        $working_mode = Custom_Related_Products::get_current_working_mode();
        if( $working_mode == 'default' && !$modify_default_mode_query ) {
            return $query;
        }
        $related = get_post_meta( $product_id, '_crp_related_ids', true );

        $related_categories_ids = get_post_meta($product_id, '_crp_related_product_cats', true);

        $related = $this->get_product_category_ids($related_categories_ids,$related);
		
		$related_tag_ids = get_post_meta($product_id, '_crp_related_product_tags', true);

        $related = $this->get_product_tag_ids($related_tag_ids,$related);

        if ( ! empty( $related ) && is_array( $related ) ) {
            $related = implode( ',', array_map( 'absint', $related ) );
            $query['where'] .= " AND p.ID IN ( {$related} )";
        }
        return $query;
    }

    function get_product_category_ids($related_categories_ids, $related=array()){

        if(!empty($related_categories_ids)){
    
            foreach($related_categories_ids as $related_categories_id){
    
                $all_ids = get_posts( array(
                    'post_type'     => 'product',
                    'numberposts'   => -1,
                    'post_status'   => 'publish',
                    'fields'        => 'ids',
                    'tax_query'     => array(
                       array(
                          'taxonomy' => 'product_cat',
                          'field'    => 'term_id',
                          'terms'    => $related_categories_id,
                          'operator' => 'IN',
                       )
                    ),
                ) );
    
                if(!empty($related)){
                    $related = array_merge($all_ids,$related);
                }else{
                    $related = $all_ids;
                }
            }
        }
        return $related;
    
    }
	
	    function get_product_tag_ids($related_tag_ids, $related=array()){

        if(!empty($related_tag_ids) && is_array($related_tag_ids)){
    
            foreach($related_tag_ids as $related_tag_id){
    
                $all_ids = get_posts( array(
                    'post_type'     => 'product',
                    'numberposts'   => -1,
                    'post_status'   => 'publish',
                    'fields'        => 'ids',
                    'tax_query'     => array(
                       array(
                          'taxonomy' => 'product_tag',
                          'field'    => 'term_id',
                          'terms'    => $related_tag_id,
                          'operator' => 'IN',
                       )
                    ),
                ) );
    
                if(!empty($related)){
                    $related = array_merge($all_ids,$related);
                }else{
                    $related = $all_ids;
                }
            }
        }
        return $related;
    
    }

}