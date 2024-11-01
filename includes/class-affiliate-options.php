<?php
/**
 * Yonderbound Widget Affiliate_options
 * @version 0.5.0
 * @package Yonderbound Widget
 */

require_once dirname(__FILE__) . '/../vendor/cmb2/init.php';

class YW_Affiliate_options {
	/**
	 * Parent plugin class
	 *
	 * @var    class
	 * @since  0.1.0
	 */
	protected $plugin = null;

	/**
	 * Option key, and option page slug
	 *
	 * @var    string
	 * @since  0.1.0
	 */
	protected $key = 'yonderbound_widget_affiliate_options';

	/**
	 * Options page metabox id
	 *
	 * @var    string
	 * @since  0.1.0
	 */
	protected $metabox_id = 'yonderbound_widget_affiliate_options_metabox';

	/**
	 * Options Page title
	 *
	 * @var    string
	 * @since  0.1.0
	 */
	protected $title = '';

	/**
	 * Options Page hook
	 * @var string
	 */
	protected $options_page = '';

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

		$this->title = __( 'Yonderbound', 'yonderbound-widget' );
	}

	/**
	 * Initiate our hooks
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function hooks() {
		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'add_options_page' ) );
		add_action( 'cmb2_admin_init', array( $this, 'add_options_page_metabox' ) );
	}

	/**
	 * Register our setting to WP
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function admin_init() {
		register_setting( $this->key, $this->key );
	}

	/**
	 * Add menu options page
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function add_options_page() {
		$this->options_page = add_menu_page(
			$this->title,
			$this->title,
			'manage_options',
			$this->key,
			array( $this, 'admin_page_display' ),
			plugins_url( 'yonderbound-widget/assets/logo-plugin2.png' )
		);

		// Include CMB CSS in the head to avoid FOUC.
		wp_enqueue_style('yonderbound-editor-css', plugins_url('yonderbound-widget/assets/settings.css'));
		add_action( "admin_print_styles-{$this->options_page}", array( 'CMB2_hookup', 'enqueue_cmb_css' ) );
	}

	/**
	 * Admin page markup. Mostly handled by CMB2
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function admin_page_display() {
		?>
		<div class="wrap cmb2-options-page <?php echo esc_attr( $this->key ); ?>">
			<h2><img src="<?php echo plugins_url( 'yonderbound-widget/assets/logo-yonderbound.png' ) ?>" /></h2>
			<div id="yo-settings">
				<div class="yo-wrap yo-wrap-preview">
					<h3>Widget Preview</h3>
					<div class="yo-preview">
						<p>
							Don't read this text. It is here just to represent an example of any article on your blog.
							So this is kinda the paragraph of usual text in your article and what you see below is the
							widget created by the Yonderbound plugin.
						</p>
						<div class="yo-img-container">
							<img src="<?php echo plugins_url( 'yonderbound-widget/assets/plugin-preview.png' ) ?>" />
						</div>
					</div>
				</div>
				<div class="yo-wrap">
					<h3>Add widget from the "visual editor"</h3>
					<p>When activated, the youderbound button is available in the visual editor</p>
					<img src="<?php echo plugins_url( 'yonderbound-widget/assets/editor3.png' ) ?>" />
					<p>You then enter the url of the activity or hotel to embed. You can browse available activities or hotels
						on <a target="_blank" href="https://www.yonderbound.com/search/activities">yonderbound.com</a>.</p>
					<img src="<?php echo plugins_url( 'yonderbound-widget/assets/lightbox2.png' ) ?>" />
				</div>
				<div class="yo-wrap-footer">
					<h3>Settings</h3>
					<?php cmb2_metabox_form( $this->metabox_id, $this->key ); ?>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Add custom fields to the options page.
	 *
	 * @since  0.1.0
	 * @return void
	 */
	public function add_options_page_metabox() {

		$cmb = new_cmb2_box( array(
			'id'         => $this->metabox_id,
			'hookup'     => false,
			'cmb_styles' => false,
			'show_on'    => array(
				// These are important, don't remove.
				'key'   => 'options-page',
				'value' => array( $this->key ),
			),
		) );

		$cmb->add_field( array(
			'name'    => __( 'Affiliate code', 'yonderbound_widget' ),
			'desc'    => __( 'Affiliate code provided by yonderbound.com', 'yonderbound_widget' ),
			'id'      => 'affiliate_code', // no prefix needed
			'type'    => 'text',
			'default' => __( '', 'yonderbound_widget' ),
		) );

	}
}
