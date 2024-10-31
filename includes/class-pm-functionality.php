<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://cohhe.com
 * @since      1.0.0
 *
 * @package    pm_func
 * @subpackage pm_func/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    pm_func
 * @subpackage pm_func/includes
 * @author     Cohhe <support@cohhe.com>
 */
class pm_func {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      pm_func_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $pm_func    The string used to uniquely identify this plugin.
	 */
	protected $pm_func;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->pm_func = 'functionality-for-pm-theme';
		$this->version = '1.0.0';

		$this->pm_load_dependencies();
		$this->pm_set_locale();
		$this->pm_define_admin_hooks();
		$this->pm_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - pm_func_Loader. Orchestrates the hooks of the plugin.
	 * - pm_func_i18n. Defines internationalization functionality.
	 * - pm_func_Admin. Defines all hooks for the admin area.
	 * - pm_func_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pm_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pm-functionality-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pm-functionality-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pm-functionality-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pm-functionality-public.php';

		$this->loader = new pm_func_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the pm_func_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pm_set_locale() {

		$plugin_i18n = new pm_func_i18n();
		$plugin_i18n->pm_set_domain( $this->pm_get_pm_func() );

		$this->loader->pm_add_action( 'plugins_loaded', $plugin_i18n, 'pm_load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pm_define_admin_hooks() {

		$plugin_admin = new pm_func_Admin( $this->pm_get_pm_func(), $this->pm_get_version() );

		$this->loader->pm_add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->pm_add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pm_define_public_hooks() {

		$plugin_public = new pm_func_Public( $this->pm_get_pm_func(), $this->pm_get_version() );

		$this->loader->pm_add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->pm_add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function pm_run() {
		$this->loader->pm_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function pm_get_pm_func() {
		return $this->pm_func;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    pm_func_Loader    Orchestrates the hooks of the plugin.
	 */
	public function pm_get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function pm_get_version() {
		return $this->version;
	}

}
