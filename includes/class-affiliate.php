<?php
/**
 * Yonderbound Widget Affiliate
 * @version 0.5.0
 * @package Yonderbound Widget
 */

class YW_Affiliate {
	/**
	 * Parent plugin class
	 *
	 * @var   class
	 * @since 0.1.0
	 */
	protected $plugin = null;

	/**
	 * Constructor
	 *
	 * @since  0.1.0
	 * @param  object $plugin Main plugin object.
	 * @return void
	 */
	public function __construct( $plugin ) {
		$this->plugin = $plugin;
		$this->hooks();
	}

	/**
	 * Initiate our hooks
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function hooks() {
		add_action('wp_print_scripts', array( $this, 'inject_widget_js' ));
		add_shortcode( 'yo-widget', array( $this, 'yo_widget_shortcode' ) );
	}

	public function inject_widget_js() {
		$affiliate_options = get_option('yonderbound_widget_affiliate_options');
		if ($affiliate_options && array_key_exists('affiliate_code', $affiliate_options)) {
			$code = $affiliate_options['affiliate_code'];
      echo '<script type="text/javascript" src="//widget.yonderbound.com/v1/widget.js" data-yoid="' . esc_attr($code) . '"></script>';
    }
	}

	public function yo_widget_shortcode($attrs){
		$url = esc_url($attrs['href']);
	  return "<div data-href=\"$url\" class=\"yo-widget\"></div>";
	}
}
