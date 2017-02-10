<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link        http://giorgiosaud.com/site/ 
 * @since      1.0.0
 *
 * @package    Ebay_Importer_Giorgiosaud
 * @subpackage Ebay_Importer_Giorgiosaud/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ebay_Importer_Giorgiosaud
 * @subpackage Ebay_Importer_Giorgiosaud/admin
 * @author     Giorgiosaud <jorgelsaud@gmail.com>
 */
class Ebay_Importer_Giorgiosaud_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ebay_Importer_Giorgiosaud_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ebay_Importer_Giorgiosaud_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ebay-importer-giorgiosaud-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ebay_Importer_Giorgiosaud_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ebay_Importer_Giorgiosaud_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ebay-importer-giorgiosaud-admin.js', array( 'jquery' ), $this->version, false );

	}
	public function ebay_importer_menu(){
		add_menu_page('Ebay Importer', 'Ebay Importer', 'edit_others_posts', 'ebay-importer-giorgiosaud', array($this,'ebay_importer_page_view'),'dashicons-migrate',null);



	}
	public function register_ebay_importer_group() {
	//register our settings
		register_setting( 'ebay-importer-giorgiosaud', 'ebay_api_name' );
		register_setting( 'ebay-importer-giorgiosaud', 'ebay_api_key' );
		register_setting( 'ebay-importer-giorgiosaud', 'ebay_api_key_secret' );
		add_settings_section(
			'ebay_importer_giorgiosaud_settings',
			__( 'Settings for the Ebay Importer.', 'ebay-importer-giorgiosaud' ),
			array($this,'ebay_importer_giorgiosaud_settings_cb'),
			'ebay-importer-giorgiosaud'
			);
		add_settings_field(
			'ebay_api_name',
			__('Ebay APP ID (Client ID)','ebay-importer-giorgiosaud' ),
			array($this,'ebay_api_name_cb'),
			'ebay-importer-giorgiosaud',
			'ebay_importer_giorgiosaud_settings',
			array(
				'label_for'=>'ebay_api_name',
				'class'=>'regular-text ebay_api_name'
				)
			);
		add_settings_field(
			'ebay_api_key',
			__('Dev ID','ebay-importer-giorgiosaud' ),
			array($this,'ebay_api_key_cb'),
			'ebay-importer-giorgiosaud',
			'ebay_importer_giorgiosaud_settings',
			array(
				'label_for'=>'ebay_api_key',
				'class'=>'regular-text ebay_api_key'
				)
			);
		add_settings_field(
			'ebay_api_key_secret',
			__('Cert ID (Client Secret)','ebay-importer-giorgiosaud' ),
			array($this,'ebay_api_key_secret_cb'),
			'ebay-importer-giorgiosaud',
			'ebay_importer_giorgiosaud_settings',
			array(
				'label_for'=>'ebay_api_key_secret',
				'class'=>'regular-text ebay_api_key_secret'
				)
			);

	}
	public function ebay_importer_giorgiosaud_settings_cb(){
		echo '<p>Settings for setup ebay dev settings.</p>';
	}
	// field content cb
	
	public function ebay_api_name_cb()
	{
    // get the value of the setting we've registered with register_setting()
		$setting = get_option('ebay_api_name');
    // output the field
		?>
		<input type="text" name="ebay_api_name" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
		<?php
	}

	public function ebay_api_key_cb()
	{
    // get the value of the setting we've registered with register_setting()
		$setting = get_option('ebay_api_key');
    // output the field
		?>
		<input type="text" name="ebay_api_key" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
		<?php
	}
	public function ebay_api_key_secret_cb()
	{
    // get the value of the setting we've registered with register_setting()
		$setting = get_option('ebay_api_key_secret');
    // output the field
		?>
		<input type="text" name="ebay_api_key_secret" value="<?= isset($setting) ? esc_attr($setting) : ''; ?>">
		<?php
	}

	public function ebay_importer_page_view(){
		// check user capabilities
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		// add error/update messages

 // check if the user have submitted the settings
 // wordpress will add the "settings-updated" $_GET parameter to the url
		if ( isset( $_GET['settings-updated'] ) ) {
 // add settings saved message with the class of "updated"
			add_settings_error( 'ebay_importer_giorgiosaud_messages', 'ebay_importer_giorgiosaud_message', __( 'Settings Saved', 'ebay-importer-giorgiosaud' ), 'updated' );
		}
		// show error/update messages
		settings_errors( 'ebay_importer_giorgiosaud_messages' );
		load_template(plugin_dir_path( __FILE__ ).'partials/ebay-importer-giorgiosaud-admin-display.php');
	}

}
