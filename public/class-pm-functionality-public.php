<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://cohhe.com
 * @since      1.0.0
 *
 * @package    pm_func
 * @subpackage pm_func/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    pm_func
 * @subpackage pm_func/public
 * @author     Cohhe <support@cohhe.com>
 */
class pm_func_Public {

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
	 * @param      string    $pm_func       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $pm_func, $version ) {

		$this->pm_func = $pm_func;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->pm_func, plugin_dir_url( __FILE__ ) . 'css/pm-functionality-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'pm-animate', plugin_dir_url( __FILE__ ) . 'css/animate.css', array(), $this->version, 'all' );

		// Add Google fonts
		wp_register_style('public-googleFonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700,900&subset=latin');
		wp_enqueue_style( 'public-googleFonts');

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

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

		
		wp_enqueue_script( 'jquery-cookie', plugin_dir_url( __FILE__ ) . 'js/jquery.cookie.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->pm_func, plugin_dir_url( __FILE__ ) . 'js/pm-functionality-public.js', array( 'jquery' ), $this->version, false );

	}

}
