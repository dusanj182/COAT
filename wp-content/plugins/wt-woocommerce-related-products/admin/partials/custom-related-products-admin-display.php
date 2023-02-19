<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @since      1.0.0
 *
 * @package    Custom_Related_Products
 * @subpackage Custom_Related_Products/admin/partials
 */
?>

<div class="wrap wt-crp-container">
	<h2><?php echo esc_html( get_admin_page_title() );?></h2>
	<?php settings_errors(); ?>
	<?php do_action('wt_crp_before_settings_block'); ?>
        <div class="crp-main-container">
                <p style="font-size: 16px;">
                    <b><?php _e('Settings', 'wt-woocommerce-related-products');?></b>
                </p>
                <p style="border-top: 1px dashed rgb(204, 204, 204); padding-top: 5px;"></p>
                <div style="width: 70%;display: inline-block;">
                    <form action="options.php" method="post">
                            <?php
                            settings_fields( $this->plugin_name );
                            do_settings_sections( $this->plugin_name );
                            submit_button();
                            ?>
                    </form>
                </div>
                <div style="width: 25%;float: right; margin-right: 10px;">
                <div style="background: #fff; border-radius: 4px; height:auto; padding: 15px; box-shadow: 0px 0px 2px #ccc;margin-top: 18px; ">
                   <h2 style="text-align: center;margin-top: 10px;"><?php _e('Watch setup video','wt-woocommerce-related-products');?></h2>
                    <iframe src="//www.youtube.com/embed/KOMx3g-ZMQs" allowfullscreen="allowfullscreen" frameborder="0" align="middle" style="width:100%;margin-bottom: 1em;margin-top: 4px;"></iframe>
                </div>
                    
                <div class="wt-blue-info">
                    <p style="font-size: 16px;text-align: center;">
                        <b><?php _e('Quick links', 'wt-woocommerce-related-products');?></b>
                    </p>
                    <p style="font-size: 14px;">
                        <?php _e('Easily display related products for your products on your site based on category, tag or product. Learn how to:', 'wt-woocommerce-related-products');?>
                    </p>
                    <ul style="margin-top:0px; list-style:disc; margin-left:15px;font-size: 14px;line-height: 25px;">
                                <li> <?php echo sprintf(__('%s Relate products by category, tag or both %s', 'wt-woocommerce-related-products'), '<a href="https://www.webtoffee.com/related-products-woocommerce-user-guide/#by-category" target="_blank">', '</a>');?> </li>
                                <li> <?php echo sprintf(__('%s Relate products individually for each product %s', 'wt-woocommerce-related-products'), '<a href="https://www.webtoffee.com/related-products-woocommerce-user-guide/#individually" target="_blank">', '</a>');?></li>
                                <li> <?php echo sprintf(__('%s Exclude products from displaying as related products %s', 'wt-woocommerce-related-products'), '<a href="https://www.webtoffee.com/related-products-woocommerce-user-guide/#exclude-category" target="_blank">', '</a>');?></li>
                                <li> <?php echo sprintf(__('%s Display related products using shortcodes %s', 'wt-woocommerce-related-products'), '<a href="https://www.webtoffee.com/related-products-woocommerce-user-guide/#using-shortcode" target="_blank">', '</a>');?></li>
                    </ul>
                </div>
                <div class="wt_go-review">
                    <h3 style="text-align: center;"><?php echo __('Like this plugin?','wt-woocommerce-related-products'); ?></h3>
                    <p><?php echo __('If you find this plugin useful please show your support and rate it','wt-woocommerce-related-products'); ?> <a href="https://wordpress.org/support/plugin/wt-woocommerce-related-products/reviews/#new-post" target="_blank" style="color: #ffc600; text-decoration: none;">★★★★★</a><?php echo __(' on','wt-woocommerce-related-products'); ?> <a href="https://wordpress.org/support/plugin/wt-woocommerce-related-products/reviews/#new-post" target="_blank">WordPress.org</a> -<?php echo __('  much appreciated!','wt-woocommerce-related-products'); ?> :)</p>

                </div>
            </div>
	</div>

</div>

<style> 
    .wt_go-review{ background: #fff; float: left; border-radius: 4px; height:auto; padding: 15px; box-shadow: 0px 0px 2px #ccc; margin: 32px 0px; }
    .wt_go-review h3{ text-align: center; }
    .wt-blue-info{
        color: #646970;
        background-color: #d9edf7;
        border-color: #bce8f1;
        padding: 2px 18px 18px 18px;
        border: 1px solid transparent;
        border-radius: 4px;
        margin-top: 32px;
    }
    .wt-crp-container .form-table th {
        width : 290px;
    }
	.crp-main-container {
		background-color: white;
		padding: 10px 10px 10px 20px;
	}
	
	.crp-paragraph {
		margin-top: 12px !important;
	}

	.crp-banner {
		width: 92%; 
		margin-top: 5px;
		font-size: 12px;
	}
	.working-mode-field .description {
		margin: 0px 0px 15px 25px;
	}
	.crp-disallow {
		opacity: 0.5;
		cursor: not-allowed;
	}
	.wt-crp-container .crp-disallow select, .wt-crp-container .crp-disallow label, .wt-crp-container .crp-disallow input, .wt-crp-container .crp-disallow span, .wt-crp-container .crp-disallow li {
		cursor: not-allowed !important;
	}
	.wt-crp-container fieldset span.select2 {
		width: 320px !important;
	}
	.wt-crp-select, .wt-crp-input {
		width: 320px;
	}
	.crp-info {
		font-size: 13px;
	}	
	.crp-info-box {
		color: #646970;
		background-color: #d9edf7;
		border-color: #bce8f1;
		padding: 14px;
		margin-bottom: 18px;
		border: 1px solid transparent;
		border-radius: 4px
	}
	
	.crp-alert {
		position: relative;
		padding: 0.75rem 1.25rem;
		margin-bottom: 1rem;
		border: 1px solid transparent;
		border-radius: 0.25rem;
	}
	.crp-seconday-alert {	
		color: #383d41;
  		background-color: #e2e3e5;
  		border-color: #d6d8db;
	}

	.crp-info-alert {
		color: #0c5460;
		background-color: #d1ecf1;
		border-color: #bee5eb;
	}
	.crp-warning-alert {
		color: #856404;
		background-color: #fff3cd;
		border-color: #ffeeba;
	}
	.wt-crp-note {
		font-size: 13px !important;
	}
	.crp-overide-theme .crp-alert {
		margin-top: 8px;
		width: 70%;
		display: none;
	}
	.wt_crp_branding {
		text-align: end; 
		width: 100%;
		margin-bottom: 10px;
	}
	.wt_crp_brand_label {
        width: 100%; 
        padding-bottom: 10px;
        font-size: 11px;
        font-weight: 600;
    }
	.wt_crp_brand_logo img {
		max-width: 100px;
	}

</style>

