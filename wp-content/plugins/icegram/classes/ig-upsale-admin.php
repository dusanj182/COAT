<?php
if ( !defined( 'ABSPATH' ) ) exit;
/**
* Icegram Compatibility class with other plugins
*/
if ( !class_exists( 'Icegram_upsale' ) ) {
	class Icegram_upsale {
		function __construct() {
			add_action( 'add_meta_boxes', array( &$this, 'add_campaigns_analytics_metaboxes' ), 0 );
			add_action( 'add_meta_boxes', array( &$this, 'add_upsell_notice' ), 0 );
			add_filter( 'icegram_campaign_tabs', array( &$this, 'add_upsale_tab' ), 10, 1 );
			add_action('icegram_after_message_settings', array($this,'display_bt_upsale'),10,2);
			add_filter('icegram_message_field_link' ,array(&$this, 'display_cta_upsale'));
		}

		function add_campaigns_analytics_metaboxes(){
			add_meta_box( 'campaign_stats_upsale', __( 'Statistics', 'icegram' ), array( &$this, 'print_campaign_image' ), 'ig_campaign', 'normal', 'high' );
		}


		function print_campaign_image(){
			global $icegram;
			?>
			<a href="https://www.icegram.com/analytics/?utm_source=in_app&utm_medium=analytics&utm_campaign=ig_upsell" target="blank"><img src="<?php echo $icegram->plugin_url ?>/assets/images/analytics.png"/></a>
			<?php
		}

		/**
         * Add Upsell Notice
         *
		 * @since 1.10.40
		 */
		function add_upsell_notice(){
			add_meta_box( 'premium_upsale', __( 'Upgrade To Premium', 'icegram' ), array( &$this, 'print_premium_message' ), 'ig_campaign', 'side' );
		}

		/**
		 * Added Premium Notice
		 *
		 * @since 1.10.40
		 */
		function print_premium_message() {

			$pricing_url = "https://www.icegram.com/pricing/?utm_source=in_app&utm_medium=campaign_upgrade_notice&utm_campaign=ig_upsell";

			echo "<div style='font-size:14px'><p class='ig_message_upsale'>Unlock high conversion Icegram campaigns and triggers to reduce abandonment & increase sales with <a style='font-weight:500;' href='" . $pricing_url . "' target='_blank' >Icegram Premium</a>!</p>Upgrade now & get <b>10% discount!</b><br/><br/>Use code <b class='ig_upsale_premium_code'>PREMIUM10</b></div>";
		}

		function add_upsale_tab( $tabs ){
			$tabs['nav']['upsale'] = '<li class="ig-admin-nav-upsale ig-admin-nav-notab"><a href="https://www.icegram.com/split-testing/?utm_source=in_app&utm_medium=split-testing&utm_campaign=ig_upsell" target="blank">Split testing<span style="font-size: 0.8em; margin-left: 0.3em; padding: 2px; background: #e66060; color: #fff; border-radius: 2px; ">Premium</span></a></li>';
			return $tabs;
		}

		function display_bt_upsale( $message_id, $message_data ){
		global $icegram;
		?>
			<label class="message_label"><a class="ig_bt_upsale" href="https://www.icegram.com/exit-intent-optins/?utm_source=in_app&utm_medium=exit-intent&utm_campaign=ig_upsell" target="blank"><img src="<?php echo $icegram->plugin_url ?>/assets/images/exit-intent-label.png"/></a></label>
			<a class="ig_bt_upsale" href="https://www.icegram.com/exit-intent-optins/?utm_source=in_app&utm_medium=exit-intent&utm_campaign=ig_upsell" target="blank"><img src="<?php echo $icegram->plugin_url ?>/assets/images/exit-intent-feild.png"/></a>
		<?php
		}

		function display_cta_upsale( $params ){
			global $icegram;
		?>
			<a class="ig_cta_upsale" href="https://www.icegram.com/cta-actions/?utm_source=in_app&utm_medium=cta&utm_campaign=ig_upsell" target="blank"><img src="<?php echo $icegram->plugin_url ?>/assets/images/cta-new-tab.png"/></a>
		<?php
		return $params;
		}

	}
	$icegram_upsale = new Icegram_upsale();
}
