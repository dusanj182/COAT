<?php
/**
 * Template Name: Home Custom Page
 */
?>

<?php get_header(); ?>

<main id="main" role="main">
  <?php do_action( 'lighting_store_above_slider' ); ?>

  <?php if( get_theme_mod('lighting_store_slider_hide_show', false) != ''){ ?> 
    <section id="slider" class="m-0 p-0 mw-100">
      <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel"> 
        <?php $lighting_store_content_pages = array();
          for ( $count = 1; $count <= 4; $count++ ) {
            $mod = intval( get_theme_mod( 'lighting_store_slider_page' . $count ));
            if ( 'page-none-selected' != $mod ) {
              $lighting_store_content_pages[] = $mod;
            }
          }
          if( !empty($lighting_store_content_pages) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $lighting_store_content_pages,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
          if ( $query->have_posts() ) :
            $i = 1;
        ?>     
        <div class="carousel-inner" role="listbox">
          <?php  while ( $query->have_posts() ) : $query->the_post(); ?>
            <div <?php if($i == 1){echo 'class="carousel-item active"';} else{ echo 'class="carousel-item"';}?>>
              <div class="row">
                <div class="col-lg-6 col-md-6 slider-content">
                  <div class="carousel-caption">
                    <div class="inner_carousel">
                      <h1><?php the_title(); ?></h1>
                      <p class="my-2"><?php $excerpt = get_the_excerpt(); echo esc_html( lighting_store_string_limit_words( $excerpt,12 ) ); ?></p>
                      <div class="read-btn mt-4">
                        <a href="<?php echo esc_url(get_permalink()); ?>"><?php esc_html_e( 'Read More', 'lighting-store' ); ?><span class="screen-reader-text"><?php esc_html_e( 'Read More', 'lighting-store' );?></span></a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6">
                  <?php the_post_thumbnail(); ?>
                </div>
              </div>
            </div>
          <?php $i++; endwhile; 
          wp_reset_postdata();?>
        </div>
        <?php else : ?>
          <div class="no-postfound"></div>
        <?php endif;
        endif;?>
        <a class="carousel-control-prev" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev" role="button">
          <span class="carousel-control-prev-icon" aria-hidden="true"><i class="fas fa-chevron-left"></i></span><span class="screen-reader-text"><?php esc_html_e( 'Previous', 'lighting-store' );?></span>
        </a>
        <a class="carousel-control-next" data-bs-target="#carouselExampleCaptions" data-bs-slide="next" role="button">
          <span class="carousel-control-next-icon" aria-hidden="true"><i class="fas fa-chevron-right"></i></span><span class="screen-reader-text"><?php esc_html_e( 'Next', 'lighting-store' );?></span>
        </a>
      </div>   
      <div class="clearfix"></div>
    </section>
  <?php }?>

  <?php do_action( 'lighting_store_below_slider' ); ?>

  <section id="feature-section">
    <div class="container">
      <div class="feature-content">
        <div class="row">
          <div class="col-lg-4 col-md-4 align-self-center">
            <?php if(get_theme_mod('lighting_store_support_title') != '' || get_theme_mod('lighting_store_support_text') != ''){ ?>
              <div class="feature-box">
                <div class="row mx-md-0">
                  <div class="col-lg-2 col-md-12 align-self-center text-center">
                    <i class="fas fa-headphones"></i>
                  </div>
                  <div class="col-lg-10 col-md-12 align-self-center">
                    <?php if(get_theme_mod('lighting_store_support_title') != ''){ ?>
                      <p class="feaure-title mb-12"><?php echo esc_html(get_theme_mod('lighting_store_support_title')); ?></p>
                    <?php }?>
                    <?php if(get_theme_mod('lighting_store_support_text') != ''){ ?>
                      <p class="feaure-text mb-12"><?php echo esc_html(get_theme_mod('lighting_store_support_text')); ?></p>
                    <?php }?>
                  </div>
                </div>
              </div>
            <?php }?>
          </div>
          <div class="col-lg-4 col-md-4 align-self-center ps-0">
            <?php if(get_theme_mod('lighting_store_delivery_title') != '' || get_theme_mod('lighting_store_delivery_text') != ''){ ?>
              <div class="feature-box second-box">
                <div class="row mx-md-0">
                  <div class="col-lg-2 col-md-12 align-self-center text-center">
                    <i class="fas fa-truck"></i>
                  </div>
                  <div class="col-lg-10 col-md-12 align-self-center">
                    <?php if(get_theme_mod('lighting_store_delivery_title') != ''){ ?>
                      <p class="feaure-title mb-0"><?php echo esc_html(get_theme_mod('lighting_store_delivery_title')); ?></p>
                    <?php }?>
                    <?php if(get_theme_mod('lighting_store_delivery_text') != ''){ ?>
                      <p class="feaure-text mb-0"><?php echo esc_html(get_theme_mod('lighting_store_delivery_text')); ?></p>
                    <?php }?>
                  </div>
                </div>
              </div>
            <?php }?>
          </div>
          <div class="col-lg-4 col-md-4 align-self-center">
            <?php if(get_theme_mod('lighting_store_nextday_delivery_title') != '' || get_theme_mod('lighting_store_nextday_delivery_text') != ''){ ?>
              <div class="feature-box">
                <div class="row mx-md-0">
                  <div class="col-lg-2 col-md-12 align-self-center text-center">
                    <i class="fas fa-rocket"></i>
                  </div>
                  <div class="col-lg-10 col-md-12 align-self-center">
                    <?php if(get_theme_mod('lighting_store_nextday_delivery_title') != ''){ ?>
                      <p class="feaure-title mb-0"><?php echo esc_html(get_theme_mod('lighting_store_nextday_delivery_title')); ?></p>
                    <?php }?>
                    <?php if(get_theme_mod('lighting_store_nextday_delivery_text') != ''){ ?>
                      <p class="feaure-text mb-0"><?php echo esc_html(get_theme_mod('lighting_store_nextday_delivery_text')); ?></p>
                    <?php }?>
                  </div>
                </div>
              </div>
            <?php }?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php if( get_theme_mod('lighting_store_section_title') != '' || get_theme_mod('lighting_store_section_text') != '' || get_theme_mod('lighting_store_special_products_page') != ''){ ?>
    <section id="special-product" class="text-center py-5">
      <div class="container">     
        <div class="product-head mb-5 text-center">
          <?php if( get_theme_mod('lighting_store_section_title') != ''){ ?>
            <strong class="text-center"><?php echo esc_html(get_theme_mod('lighting_store_section_title')); ?></strong>
          <?php }?>
          <?php if( get_theme_mod('lighting_store_section_text') != ''){ ?>
            <p class="section-text text-center"><?php echo esc_html(get_theme_mod('lighting_store_section_text')); ?></p>
          <?php }?>
        </div>
        <?php if(class_exists( 'WooCommerce' )){?> 
          <?php $lighting_store_special_products_page = array();
          $mod = intval( get_theme_mod( 'lighting_store_special_products_page'));
          if ( 'page-none-selected' != $mod ) {
            $lighting_store_special_products_page[] = $mod;
          }
          if( !empty($lighting_store_special_products_page) ) :
            $args = array(
              'post_type' => 'page',
              'post__in' => $lighting_store_special_products_page,
              'orderby' => 'post__in'
            );
            $query = new WP_Query( $args );
            if ( $query->have_posts() ) :
              while ( $query->have_posts() ) : $query->the_post(); ?>
                <div class="box-image">
                  <?php the_content(); ?>
                </div>
              <?php endwhile; ?>
            <?php else : 
              wp_reset_postdata();?>
              <div class="no-postfound"></div>
            <?php endif;
          endif;?>
          <div class="clearfix"></div>
        <?php } ?>
      </div>
    </section>
  <?php }?>
  <?php do_action( 'lighting_store_below_best_sellers' ); ?>

  <div class="container entry-content">
    <?php while ( have_posts() ) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; // end of the loop. ?>
  </div>
</main>
<?php get_footer(); ?>