<?php 
/*
* Display Top Bar
*/
?>
<?php if( get_theme_mod('lighting_store_show_topbar', false) != false){ ?>
  <div class="top-header">
    <div class="container">
      <div class="row">
        <div class="col-lg-5 col-md-12 align-self-center">
          <?php if( get_theme_mod( 'lighting_store_topar_text' ) != '') { ?>
            <p class="topbar-text text-lg-start text-center my-lg-0 my-2"><?php echo esc_html( get_theme_mod('lighting_store_topar_text') ); ?></p>
          <?php } ?>
        </div>
        <div class="col-lg-3 col-md-5 text-center contact-detail contact-1">
          <?php if(get_theme_mod('lighting_store_email') != ''){ ?>
            <span class="contact">
              <a href="mailto:<?php echo esc_attr(get_theme_mod('lighting_store_email')); ?>"><i class="fas fa-envelope me-2"></i><?php echo esc_html(get_theme_mod('lighting_store_email')); ?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('lighting_store_email')); ?></span></a>
            </span>
          <?php }?>
        </div>
        <div class="col-lg-3 col-md-5 text-center contact-detail">
          <?php if(get_theme_mod('lighting_store_phoneno') != ''){ ?>
            <span class="contact">
              <a href="tel:<?php echo esc_attr(get_theme_mod('lighting_store_phoneno')); ?>"><i class="fas fa-phone me-2"></i><?php echo esc_html(get_theme_mod('lighting_store_phoneno')); ?><span class="screen-reader-text"><?php echo esc_html(get_theme_mod('lighting_store_phoneno')); ?></span></a>
            </span>
          <?php }?>
        </div>
        <div class="col-lg-1 col-md-1 text-center contact-detail">
          <?php if(class_exists('woocommerce')){ ?>
            <span class="cart_no">              
              <a href="<?php if(function_exists('wc_get_cart_url')){ echo esc_url(wc_get_cart_url()); } ?>"><i class="fas fa-shopping-cart ms-2"></i><span class="screen-reader-text"><?php esc_html_e( 'Cart','lighting-store' );?></span></a>
              <span class="cart-value"> <?php echo esc_html(wp_kses_data( WC()->cart->get_cart_contents_count() ));?></span>
            </span>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
<?php }?>