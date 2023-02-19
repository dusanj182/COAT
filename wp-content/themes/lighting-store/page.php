<?php
/**
 * Displaying all pages.
 * @package Lighting Store
*/

get_header(); ?>

<?php do_action( 'lighting_store_page_header' ); ?>

<main id="main" role="main" class="main-content">
    <div class="main-content container">
        <div class="wrapper">
            <?php while ( have_posts() ) : the_post(); ?>
               <?php the_post_thumbnail(); ?>
                <h1 class="mb-2 p-0"><?php the_title(); ?></h1>
                <div class="entry-content"><?php the_content();?></div>
                <?php
                    wp_link_pages( array(
                        'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'lighting-store' ),
                        'after'  => '</div>',
                    ) );
                    //If comments are open or we have at least one comment, load up the comment template
                    if ( comments_open() || '0' != get_comments_number() )
                        comments_template();
                ?>
            <?php endwhile; // end of the loop. ?>
            <div class="clear"></div>    
        </div>
    </div>
</main>    

<?php do_action( 'lighting_store_page_footer' ); ?>

<?php get_footer(); ?>