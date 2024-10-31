<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://cohhe.com
 * @since      1.0.0
 *
 * @package    pm_func
 * @subpackage pm_func/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    pm_func
 * @subpackage pm_func/admin
 * @author     Cohhe <support@cohhe.com>
 */
class pm_func_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $pm_func    The ID of this plugin.
	 */
	private $pm_func;

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
	 * @param      string    $pm_func       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $pm_func, $version ) {

		$this->pm_func = $pm_func;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( $hook ) {
		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in pm_func_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The pm_func_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( 'pm-main-admin-css', plugin_dir_url( __FILE__ ) . 'css/pm-main-admin.css', array(), $this->version, 'all' );

		if ( $hook != 'popup-manager_page_popup-manager-addons' && $hook != 'popup-manager_page_popup-manager-list' && $hook != 'toplevel_page_popup-manager' && $hook != 'admin_page_popup-manager-survey' && $hook != 'admin_page_popup-manager-analytics' ) {
			return;
		}

		wp_enqueue_style( $this->pm_func, plugin_dir_url( __FILE__ ) . 'css/pm-functionality-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pm-grid', plugin_dir_url( __FILE__ ) . 'css/grid.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pm-animate', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );

		// // Add Google fonts
		wp_register_style('googleFonts', '//fonts.googleapis.com/css?family=Noto+Sans:400,700|Source+Sans+Pro:300,400,700,900&subset=latin');
		wp_enqueue_style( 'googleFonts');

		wp_enqueue_style('thickbox');
		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_style( 'jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css');

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( $hook ) {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in pm_func_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The pm_func_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( 'pm-main-admin', plugin_dir_url( __FILE__ ) . 'js/pm-main-admin.js', array( 'jquery' ), $this->version, false );

		if ( $hook != 'popup-manager_page_popup-manager-addons' && $hook != 'popup-manager_page_popup-manager-list' && $hook != 'toplevel_page_popup-manager' && $hook != 'admin_page_popup-manager-survey' && $hook != 'admin_page_popup-manager-analytics' ) {
			return;
		}

		wp_enqueue_media();
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'jquery-ui-datepicker' );
		wp_enqueue_script( 'jquery-ui-dialog' );
		wp_enqueue_script( 'jquery-maskedinput', plugin_dir_url( __FILE__ ) . 'js/jquery.maskedinput.min.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->pm_func, plugin_dir_url( __FILE__ ) . 'js/pm-functionality-admin.js', array( 'jquery', 'wp-color-picker' ), $this->version, false );
		wp_localize_script( $this->pm_func, 'pm_main', array( 
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
			'submenu' => PM_PLUGIN_SUBMENU_PAGE_URL,
			'pm_plugin_uri' => PM_PLUGIN_URI
		));

	}

}
