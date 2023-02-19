<?php
/**
 * The Sidebar containing the main widget areas.
 * @package Lighting Store
 */
?>
<div id="sidebar">    
    <?php if ( ! dynamic_sidebar( 'sidebar-1' ) ) : ?>
        <aside role="complementary" aria-label="sidebar-1" id="archives" class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Archives', 'lighting-store' ); ?></h3>
            <ul>
                <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
            </ul>
        </aside>
        <aside role="complementary" aria-label="sidebar-2" id="archives" class="widget">
            <h3 class="widget-title"><?php esc_html_e( 'Meta', 'lighting-store' ); ?></h3>
            <ul>
                <?php wp_register(); ?>
                <li><?php wp_loginout(); ?></li>
                <?php wp_meta(); ?>
            </ul>
        </aside>
    <?php endif; // end sidebar widget area ?>  
</div>