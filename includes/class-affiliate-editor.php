<?php
/**
 * Yonderbound Widget Affiliate Editor
 * @version 0.5.0
 * @package Yonderbound Widget
 */

class YW_Affiliate_Editor {
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
		add_action('admin_init', array($this, 'add_shortcode_button'));
		add_action('admin_enqueue_scripts', array($this, 'yonderbound_editor_css'));
	}

	public function add_shortcode_button() {
		if( current_user_can('edit_posts') &&  current_user_can('edit_pages') ) {
			add_filter( 'mce_external_plugins', array($this, 'editor_add_buttons' ));
			add_filter( 'mce_buttons', array($this, 'register_buttons' ));
		}
	}

	public function yonderbound_editor_css() {
		wp_enqueue_script('algoliasearch', '//cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js');
		wp_enqueue_script('algolia-autocomplete', '//cdn.jsdelivr.net/autocomplete.js/0/autocomplete.min.js');
	}

	public function editor_add_buttons( $plugin_array ) {
		$plugin_array['yonderboundshortcode'] = plugins_url( 'yonderbound-widget/assets/editor.js' );

		return $plugin_array;
	}

	public function register_buttons( $buttons ) {
		array_push( $buttons, 'separator', 'yonderboundshortcode' );
		return $buttons;
	}
}
