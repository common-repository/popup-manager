<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://cohhe.com/
 * @since             1.0
 * @package           pm_func
 *
 * @wordpress-plugin
 * Plugin Name:       Popup Manager
 * Plugin URI:        http://wppopupmanager.com/
 * Description:       Popup Manager adds popup functionality to the theme
 * Version:           1.6.6
 * Author:            Cohhe
 * Author URI:        https://cohhe.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       popup-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-pm-functionality-activator.php
 */
function pm_activate_pm_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pm-functionality-activator.php';
	pm_func_Activator::pm_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-pm-functionality-deactivator.php
 */
function pm_deactivate_pm_func() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-pm-functionality-deactivator.php';
	pm_func_Deactivator::pm_deactivate();
}

register_activation_hook( __FILE__, 'pm_activate_pm_func' );
register_deactivation_hook( __FILE__, 'pm_deactivate_pm_func' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
define('PM_POPUP_MANAGER', true);
define('PM_PLUGIN', plugin_dir_path( __FILE__ ));
define('PM_PLUGIN_URI', plugin_dir_url( __FILE__ ));
define('PM_PLUGIN_MENU_PAGE', 'popup-manager');
define('PM_PLUGIN_SUBMENU_PAGE', 'popup-manager-list');
define('PM_PLUGIN_ADDON_PAGE', 'popup-manager-addons');
define('PM_PLUGIN_MENU_PAGE_URL', get_admin_url() . 'admin.php?page=' . PM_PLUGIN_MENU_PAGE);
define('PM_PLUGIN_SUBMENU_PAGE_URL', get_admin_url() . 'admin.php?page=' . PM_PLUGIN_SUBMENU_PAGE);
define('PM_PLUGIN_ADDON_PAGE_URL', get_admin_url() . 'admin.php?page=' . PM_PLUGIN_ADDON_PAGE);
require plugin_dir_path( __FILE__ ) . 'includes/class-pm-functionality.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_pm_func() {

	$plugin = new pm_func();
	$plugin->pm_run();

}
run_pm_func();

function pm_register_manager_menu_page() {
	add_menu_page(
		__( 'Popup manager', 'popup-manager' ),
		__( 'Popup manager', 'popup-manager' ),
		'manage_options',
		PM_PLUGIN_MENU_PAGE,
		'',
		'dashicons-welcome-widgets-menus',
		6
	);

	add_submenu_page(
		PM_PLUGIN_MENU_PAGE,
		__('Add New', 'popup-manager'),
		__('Add New', 'popup-manager'),
		'manage_options',
		PM_PLUGIN_MENU_PAGE,
		'pm_main_html'
	);

	add_submenu_page(
		PM_PLUGIN_MENU_PAGE,
		__('Popup List', 'popup-manager'),
		__('Popup List', 'popup-manager'),
		'manage_options',
		PM_PLUGIN_SUBMENU_PAGE,
		'pm_list_html'
	);

	add_submenu_page(
		PM_PLUGIN_MENU_PAGE,
		__('Add-ons', 'popup-manager'),
		__('Add-ons', 'popup-manager'),
		'manage_options',
		PM_PLUGIN_ADDON_PAGE,
		'pm_addon_html'
	);
}
add_action( 'admin_menu', 'pm_register_manager_menu_page' );

function pm_main_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'popup-manager') );
	}
	$first_step_class = '';
	if ( !isset($_GET['pm-template']) ) {
		$first_step_class = 'current';
	} else {
		$first_step_class = 'done disabled';
	}
	$second_step_class = '';
	if ( isset($_GET['pm-template']) && !isset($_GET['popup_id']) ) {
		$second_step_class = 'current';
	} else if ( isset($_GET['popup_id']) ) {
		$second_step_class = 'done disabled';
	} else {
		$second_step_class = 'disabled';
	}
	$third_step_class = '';
	if ( isset($_GET['popup_id']) ) {
		$third_step_class = 'current';
	} else {
		$third_step_class = 'disabled';
	}
	?>
	<div class="pm-main-wrapper container-fluid">
		<div class="pm-steps">
			<div class="steps clearfix">
				<ul role="tablist">
					<li role="tab" class="first <?php echo $first_step_class; ?>" aria-disabled="false" aria-selected="true"><a id="steps-uid-1-t-0" href="<?php echo PM_PLUGIN_MENU_PAGE_URL; ?>" aria-controls="steps-uid-1-p-0">
						<span class="number"></span>Choose a template</a>
					</li>
					<li role="tab" class="step-2 <?php echo $second_step_class; ?>" aria-disabled="true" style="display: none;"><a id="steps-uid-1-t-1" href="javascript:void(0)" aria-controls="steps-uid-1-p-1">
						<span class="number"></span>Configuration</a>
					</li>
					<li role="tab" class="disabled" aria-disabled="true"><a id="steps-uid-1-t-2" href="javascript:void(0)" aria-controls="steps-uid-1-p-2">
						<span class="number"></span>Style</a>
					</li>
					<li role="tab" class="disabled" aria-disabled="true"><a id="steps-uid-1-t-3" href="javascript:void(0)" aria-controls="steps-uid-1-p-3">
						<span class="number"></span>Execution</a>
					</li>
					<li role="tab" class="<?php echo $third_step_class; ?> last" aria-disabled="true"><a id="steps-uid-1-t-4" href="javascript:void(0)" aria-controls="steps-uid-1-p-4">
						<span class="number"></span>Save & Shortcode usage</a>
					</li>
				</ul>
			</div>
			<div class="pm-scroll-reference"></div>
		</div>
		<?php
		if ( !isset($_GET['pm-template']) ) {
			pm_choose_template();
		} else if ( isset($_GET['pm-template']) ) {
			if ( isset($_GET['popup_id']) ) {
				pm_shortcode_usage();
			} else {
				pm_email_template();
			}
		}
		?>
	</div>
	<?php
}

function pm_list_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'popup-manager') );
	}
	?>
	<div class="pm-main-wrapper container-fluid">
		<?php
		if ( !isset($_GET['popup_id']) ) {
			pm_popup_list();
		}
		?>
	</div>
	<?php
}

function pm_addon_html() {
	if ( !current_user_can('manage_options') )  {
		wp_die( __('You do not have sufficient permissions to access this page.', 'popup-manager') );
	}
	?>
	<div class="pm-main-wrapper addons container-fluid">
		<h2 class="pm-page-title">Popup add-ons</h2>
		<ul>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/video.png'; ?>" alt="">
					<h2 class="pm-addon-name">Video popup</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to add video powered popups to your site.</p>
					<a href="http://wppopupmanager.com/portfolio-item/video-modal/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/verification.png'; ?>" alt="">
					<h2 class="pm-addon-name">Age verification</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to add age verification popups to your site.</p>
					<a href="http://wppopupmanager.com/portfolio-item/age-verification/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/templates.png'; ?>" alt="">
					<h2 class="pm-addon-name">Additional templates</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds 10 more templates to your popup manager.</p>
					<a href="http://wppopupmanager.com/portfolio-item/additional-templates/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/targeting.png'; ?>" alt="">
					<h2 class="pm-addon-name">Advanced targeting</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds more targetting options so you can reach your members the best way you can. </p>
					<a href="http://wppopupmanager.com/portfolio-item/advanced-targeting/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/contact-forms.png'; ?>" alt="">
					<h2 class="pm-addon-name">Contact forms</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to add Contact form 7 and Ninja forms popups to your site.</p>
					<a href="http://wppopupmanager.com/portfolio-item/contact-form/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/geo-targeting.png'; ?>" alt="">
					<h2 class="pm-addon-name">Geo targeting</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to restrict your popups to a specific IP address/range or country/city etc.</p>
					<a href="http://wppopupmanager.com/portfolio-item/geo-targeting/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/action-bar.png'; ?>" alt="">
					<h2 class="pm-addon-name">Action bars</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to add action bar popups with subscribe forms.</p>
					<a href="http://wppopupmanager.com/portfolio-item/action-bar/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/messenger.png'; ?>" alt="">
					<h2 class="pm-addon-name">Messenger popups</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to add popups that look like chat windows.</p>
					<a href="http://wppopupmanager.com/portfolio-item/messenger/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/ribbon.png'; ?>" alt="">
					<h2 class="pm-addon-name">Ribbon popups</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to add different ribbons to your page tied to a specific URL.</p>
					<a href="http://wppopupmanager.com/portfolio-item/ribbons/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/sidebar.png'; ?>" alt="">
					<h2 class="pm-addon-name">Sidebar popups</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to add sidebar type popups to your page.</p>
					<a href="http://wppopupmanager.com/portfolio-item/sidebars/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/tabs.png'; ?>" alt="">
					<h2 class="pm-addon-name">Tab popups</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to add popups that act like tabs.</p>
					<a href="http://wppopupmanager.com/portfolio-item/tabs/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/cookie-law.png'; ?>" alt="">
					<h2 class="pm-addon-name">Cookie law popups</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to add cookie law popups to warn people about your site using cookies.</p>
					<a href="http://wppopupmanager.com/portfolio-item/cookie-law/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/analytics.png'; ?>" alt="">
					<h2 class="pm-addon-name">Analytics</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to measure how well your popups perform with built-in A/B splip testing functionality.</p>
					<a href="http://wppopupmanager.com/portfolio-item/analytics/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/locker.png'; ?>" alt="">
					<h2 class="pm-addon-name">Content Locker</h2>
					<p class="pm-addon-desc text-muted font-13">Content locker add-on is a great way to gain more social followers and popularity through various social networks.</p>
					<a href="http://wppopupmanager.com/portfolio-item/locker/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/inline.png'; ?>" alt="">
					<h2 class="pm-addon-name">Inline popups</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to put your popup inline with your page content.</p>
					<a href="http://wppopupmanager.com/portfolio-item/inline/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
			<li class="col-md-3">
				<div class="pm-addon-wrapper pm-card-box">
					<img src="<?php echo PM_PLUGIN_URI . 'admin/images/addons/survey.png'; ?>" alt="">
					<h2 class="pm-addon-name">Survey popups</h2>
					<p class="pm-addon-desc text-muted font-13">This addon adds the ability to put survey, poll and quiz style popups in your page.</p>
					<a href="http://wppopupmanager.com/portfolio-item/survey/" target="_blank" class="button button-primary">Learn More</a>
					<div class="clearfix"></div>
				</div>
			</li>
		</ul>
	</div>	
	<?php
}

function pm_popup_list() {
	?>
	<h2 class="pm-page-title">Popup list</h2>
	<div class="pm-card-box col-md-12">
		<table class="pm-table table-striped list analytics-data" role="grid">
			<thead>
				<tr role="row">
					<th class="popup-id">ID</th>
					<th class="popup-name">Popup name</th>
					<th class="popup-shortcode">Shortcode</th>
					<th class="popup-visitors <?php echo (function_exists('pm_analytics_html')?'':'feature-locked'); ?>">Views</th>
					<th class="popup-conversions <?php echo (function_exists('pm_analytics_html')?'':'feature-locked'); ?>">Conversions</th>
					<th class="popup-cr <?php echo (function_exists('pm_analytics_html')?'':'feature-locked'); ?>">CR%</th>
					<th class="popup-actions">Actions</th>
				</tr>
			</thead>
			<tbody> 
				<?php pm_get_all_popups(); ?>
			</tbody>
		</table>
	</div>

	<?php
}

function pm_popup_edit_link() {
	global $wpdb;
	$popup_id = ( isset($_POST['popup_id']) ? $_POST['popup_id'] : '' );

	$popup_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$popup_id.'"');

	if ( !empty($popup_data) ) {
		$curr_data = json_decode(stripslashes($popup_data['0']->popup_data));
		// if ( $curr_data->popup_template == 'email' ) {
			echo PM_PLUGIN_MENU_PAGE_URL.'&pm-template='.$curr_data->popup_template.'&edit_popup='.$popup_id;
		// }
	}
	die(0);
}
add_action( 'wp_ajax_nopriv_pm_edit_link', 'pm_popup_edit_link' );
add_action( 'wp_ajax_pm_edit_link', 'pm_popup_edit_link' );

function pm_get_popup_row( $popup_value, $popup_type ) {
	global $wpdb;
	$popup_data = json_decode(stripslashes($popup_value->popup_data), true);
	$popup_status = (isset($popup_data['popup_status'])?$popup_data['popup_status']:'live');

	$popup_date_start = $popup_time_start = $popup_date_end = $popup_time_end = '';
	$popup_schedule_text = 'Schedule';
	$popup_schedule_class = 'not-scheduled';
	if ( isset($popup_data['popup_schedule']) ) {
		$start_date = explode(' ', $popup_data['popup_schedule']['start']);
		$popup_date_start = $start_date['0'];
		$popup_time_start = $start_date['1'];

		$end_date = explode(' ', $popup_data['popup_schedule']['end']);
		$popup_date_end = $end_date['0'];
		$popup_time_end = $end_date['1'];

		$popup_schedule_text = 'Scheduled from ' . $popup_data['popup_schedule']['start'] . ' till ' .  $popup_data['popup_schedule']['end'];

		$start_date_arr = explode('/', $popup_date_start);
		if ( intval($start_date_arr['0']) > 12 ) {
			$parsed_start_date = strtotime(str_replace('/', '-', $popup_data['popup_schedule']['start']));
		} else {
			$parsed_start_date = strtotime($popup_data['popup_schedule']['start']);
		}

		$end_date_arr = explode('/', $popup_date_end);
		if ( intval($end_date_arr['0']) > 12 ) {
			$parsed_end_date = strtotime(str_replace('/', '-', $popup_data['popup_schedule']['end']));
		} else {
			$parsed_end_date = strtotime($popup_data['popup_schedule']['end']);
		}

		if ( ( time() >= $parsed_start_date ) && ( time() <= $parsed_end_date ) ) {
			$popup_schedule_class = 'schedule-active';
		} else {
			$popup_schedule_class = 'schedule-inactive';
		}
	}

	$parent_class = '';
	if ( $popup_type == 'child' ) {
		$parent_class = ' parent-'.$popup_value->popup_parent;
	}

	$output = '
	<tr role="row" class="'.$popup_type.$parent_class.'">
		<td data-pid="'.$popup_value->ID.'">' . ($popup_type == 'parent'?$popup_value->ID:'') . '</td>
		<td>' . $popup_value->name . '</td>
		<td>' . ($popup_type == 'parent'?'[popup_manager id="' . $popup_value->ID . '"]':'') . '</td>';
		if ( function_exists('pm_analytics_html') ) {
			$popup_analytics = $wpdb->get_results('SELECT popup_stats FROM '.$wpdb->prefix.'popup_manager_analytics WHERE popup_id="'.$popup_value->ID.'"');

			if ( !empty($popup_analytics) ) {
				$popup_stats = json_decode(stripslashes($popup_analytics['0']->popup_stats), true);
				$popup_stats_views = 0;
				$popup_stats_conversions = 0;

				foreach ($popup_stats as $stats_value) {
					foreach ($stats_value as $stats_value2) {
						if ( isset($stats_value2['views']) ) {
							$popup_stats_views += intval($stats_value2['views']);
						}
						if ( isset($stats_value2['conversions']) ) {
							$popup_stats_conversions += intval($stats_value2['conversions']);
						}
					}
				}

				$output .= '
				<td>' . $popup_stats_views . '</td>
				<td>' . $popup_stats_conversions . '</td>
				<td>' . round($popup_stats_conversions/$popup_stats_views*100, 2) . '%</td>';
			} else {
				$output .= '
				<td>0</td>
				<td>0</td>
				<td>0%</td>';
			}
			
		} else {
			$output .= '
			<td class="feature-locked">0</td>
			<td class="feature-locked">0</td>
			<td class="feature-locked">0%</td>';
		}

		$output .= '
		<td class="actions">
			<a href="javascript:void(0)" class="pm-edit-popup pmicon-pencil" data-tooltip="Edit"></a>';
			if ( function_exists('run_pmsurvey_func') && $popup_data['popup_template'] == 'survey' ) {
				$output .= '<a href="'.PMSURVEY_PLUGIN_SUBMENU_PAGE_URL.'&popup_id='.$popup_value->ID.'" class="pm-survey-popup pmicon-chart-pie" data-tooltip="Survey"></a>';
			}
			if ( function_exists('run_pmanalytics_func') ) {
				$output .= '<a href="'.PMANALYTICS_PLUGIN_SUBMENU_PAGE_URL.'&popup_id='.$popup_value->ID.'" class="pm-analytics-popup pmicon-chart-area" data-tooltip="Analytics"></a>';
			}
			if ( $popup_value->popup_type == 'parent' ) {
				$output .= '<a href="javascript:void(0)" class="pm-clone-popup pmicon-docs" data-tooltip="Clone"></a>';
			}
			if ( function_exists('pm_analytics_html') && $popup_value->popup_type == 'parent' ) {
				$output .= '<a href="javascript:void(0)" class="pm-split-popup pmicon-sitemap" data-tooltip="A/B split"></a>';
			}

			$orig_date_format = get_option('date_format');
			if ( $orig_date_format == 'm/d/Y' ) {
				$date_format = 'mm/dd/yy';
			} else {
				$date_format = 'dd/mm/yy';
			}

			$output .= '
			<a href="javascript:void(0)" class="pm-status-popup '.$popup_status.'" data-tooltip="'.ucfirst($popup_status).'"></a>
			<a href="javascript:void(0)" class="pm-schedule-popup '.$popup_schedule_class.' pmicon-clock" data-tooltip="'.$popup_schedule_text.'"></a>
			<a href="javascript:void(0)" class="pm-delete-popup pmicon-trash-empty" data-tooltip="Delete"></a>
			<script type="text/javascript">
				jQuery(document).ready(function($) {
						function available_end_dates(date, element) {
							var schedule_start_date = element.parent().parent().parent().find(".schedule-date-start").val().split("/");';
							if ( $orig_date_format == 'd/m/Y' ) {
								$output .= 'var start_date = new Date(parseInt(schedule_start_date[2]), parseInt(schedule_start_date[1]-1), parseInt(schedule_start_date[0]));';
							} else {
								$output .= 'var start_date = new Date(parseInt(schedule_start_date[2]), parseInt(schedule_start_date[0]-1), parseInt(schedule_start_date[1]));';
							}
							$output .= '
							var current_date = new Date(date);

							if ( element.parent().parent().parent().find(".schedule-date-start").val() == "" ) {
								return true;
							}

							if ( start_date.getTime() <= current_date.getTime() ) {
								return true;
							} else {
								return false;
							}
						}
						jQuery(".schedule-date-start").datepicker({
							dateFormat: "'.$date_format.'",
							onSelect: function(date) {
					            jQuery(this).val(date);
					        }
						});
						jQuery(".schedule-date-end").datepicker({
							dateFormat: "'.$date_format.'",
							onSelect: function(date) {
					            jQuery(this).val(date);
					        },
							beforeShowDay: function(dt) {
								return [ available_end_dates(dt, jQuery(this)), "" ];
							}
						});
				});
			</script>
			<div class="popup-schedule-dialog" title="Schedule your popup" style="display: none;">
				<input type="hidden" class="popup-schedule-id" value="'.$popup_value->ID.'">
				<div class="popup-dialog-row">
					<div class="col-md-2">Start at</div>
					<div class="col-md-8">
						<input type="text" class="schedule-date-start form-control" value="'.$popup_date_start.'" placeholder="'.$date_format.'">
						<input type="text" class="schedule-time-start form-control" value="'.$popup_time_start.'" placeholder="hh:mm:ss">
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="popup-dialog-row">
					<div class="col-md-2">End at</div>
					<div class="col-md-8">
						<input type="text" class="schedule-date-end form-control" value="'.$popup_date_end.'" placeholder="'.$date_format.'">
						<input type="text" class="schedule-time-end form-control" value="'.$popup_time_end.'" placeholder="hh:mm:ss">
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
				<div class="col-md-8">
					<a href="javascript:void(0)" class="schedule-date-ok">Schedule</a>
					<a href="javascript:void(0)" class="schedule-date-cancel">Cancel</a>
				</div>
			</div>
		</td>
	</tr>';
	
	return $output;
}

function pm_get_all_popups() {
	global $wpdb;
	$output = '';

	$popups = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager ORDER BY ID DESC');

	if ( !empty($popups) ) {
		foreach ($popups as $popup_value) {
			if ( $popup_value->popup_type == 'parent' && $popup_value->popup_parent == '0' ) {
				$output .= pm_get_popup_row( $popup_value, 'parent' );

				$child_popups = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE popup_parent = "'.$popup_value->ID.'" ORDER BY ID DESC');
				if ( !empty($child_popups) ) {
					foreach ($child_popups as $cpopup_value) {
						$output .= pm_get_popup_row( $cpopup_value, 'child' );
					}
				}
			}
		}
	}

	echo $output;
}

function pm_delete_popup_data() {
	global $wpdb;
	$popup_id = ( isset($_POST['popup_id']) ? $_POST['popup_id'] : '' );

	$delete_data = $wpdb->query('DELETE FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$popup_id.'" OR popup_parent="'.$popup_id.'"');
	
	if ( $delete_data ) {
		echo 'success';
	} else {
		echo 'failed';
	}

	die(0);
}
add_action( 'wp_ajax_nopriv_pm_delete_popup', 'pm_delete_popup_data' );
add_action( 'wp_ajax_pm_delete_popup', 'pm_delete_popup_data' );

function pm_choose_template() {
	?>
	<h2 class="pm-page-title">Sort your templates</h2>
	<div class="pm-sorting-wrapper">
		<a href="javascript:void(0)" class="pm-sorting-item pmicon-align-justify active" data-sorting="all">All</a>
	</div>
	<div id="popup-preview-box"><div class="inner-box"></div></div>
	<h2 class="pm-page-title">Choose popup template</h2>
	<ul class="pm-template-selection">
		<li>
			<a class="pm-card-box" href="<?php echo PM_PLUGIN_MENU_PAGE_URL . '&pm-template=image'; ?>"><img src="<?php echo PM_PLUGIN_URI . '/admin/images/image-template.png'; ?>"></a>
			<span class="pm-card-footer">Image template</span>
		</li>
		<li>
			<a class="pm-card-box" href="<?php echo PM_PLUGIN_MENU_PAGE_URL . '&pm-template=text'; ?>"><img src="<?php echo PM_PLUGIN_URI . '/admin/images/text-template.png'; ?>"></a>
			<span class="pm-card-footer">Text template</span>
		</li>
		<li>
			<a class="pm-card-box" href="<?php echo PM_PLUGIN_MENU_PAGE_URL . '&pm-template=email&pm-style=default'; ?>"><img src="<?php echo PM_PLUGIN_URI . '/admin/images/email-template-default.png'; ?>"></a>
			<span class="pm-card-footer">Email template</span>
		</li>
		<li>
			<a class="pm-card-box" href="<?php echo PM_PLUGIN_MENU_PAGE_URL . '&pm-template=email&pm-style=inline'; ?>"><img src="<?php echo PM_PLUGIN_URI . '/admin/images/email-template-inline.png'; ?>"></a>
			<span class="pm-card-footer">Email template</span>
		</li>
		<li>
			<a class="pm-card-box" href="<?php echo PM_PLUGIN_MENU_PAGE_URL . '&pm-template=email&pm-style=minimalistic'; ?>"><img src="<?php echo PM_PLUGIN_URI . '/admin/images/email-template-minimalistic.png'; ?>"></a>
			<span class="pm-card-footer">Email template</span>
		</li>
		<?php do_action('pm_template_list'); ?>
		<li>
			<div class="pm-more-designs">
				<div class="pm-more-designs-inner">
					<div class="pm-icon-container"><i class="pmicon-cog-alt"></i></div>
					<span>Additional designs</span>
					<p>Want more designs for your Popup Manager? We're here to help you out, we have plenty of creative designs ready to be used right for you!</p>
					<div class="pm-more-designs-button">
						<a href="http://wppopupmanager.com/portfolio-item/additional-templates/" class="pm-next-step" target="_blank">Add more designs</a>
					</div>
				</div>
			</div>
		</li>
	</ul>
	<?php
}

function pm_get_popup_style_json( $style_name ) {
	$style = '<script type="text/preloaded" class="popup-extra-style">';

	$styles = array(
				'inline' => '{
					"styles": {
						".email-popup-main-title": "text-align: left;padding-top: 11px;font-size: 31px;color: #000;",
						".email-popup-secondary-title": "text-align: left;font-size: 15px;line-height: 18px;padding-top: 3px;color: #000;",
						".email-popup-main-form": "padding-top: 97px;margin-top: 0;",
						".email-popup-preview input:not([type=submit])": "border-radius: 0px;padding: 10px 12px;font-size: 15px;margin-bottom: 0;",
						".email-popup-main-form .form-input-wrapper:nth-child(1)": "float: left;width: 70%;",
						".email-popup-main-form .form-input-wrapper:nth-child(2)": "float: left;width: 30%;",
						".email-popup-preview input[type=submit], .email-popup-preview button": "border-radius: 0;font-size: 19px;padding: 10px 12px;margin-left: 15px;width: 100%;text-transform: inherit;",
						".email-popup-preview": "width: 700px;"
					},
					"image": "' . PM_PLUGIN_URI . '/admin/images/inline-bg.png"
				}',
				'minimalistic' => '{
					"styles": {
						".email-popup-preview": "width: 600px;",
						".email-popup-main-title": "text-align: left;font-size: 32px;padding-top: 23px;color: #fff;text-align: right;",
						".email-popup-secondary-title": "font-size: 14px;line-height: 18px;padding-top: 10px;color: #fff;",
						".email-popup-main-form": "padding-top: 26px;",
						".email-popup-preview input:not([type=submit])": "border-radius: 0;padding: 14px 17px;border: none;",
						".email-popup-preview input[type=submit], .email-popup-preview button": "float: right;border-radius: 0;text-transform: uppercase;color: #000;font-size: 19px;margin-top: 56px;padding: 14px 51px;background-color: #01f6a8;border-color: #01f6a8;",
						".email-popup-preview": "width: 600px;"
					},
					"image": "' . PM_PLUGIN_URI . '/admin/images/minimalistic-bg.png"
				}'
		);

	$styles = apply_filters( 'pm_template_styles', $styles );
	if ( isset($styles[$style_name]) ) {
		if ( ( isset($_GET['pm-template']) && isset($_GET['pm-template']) == 'contact' ) && ( isset($_GET['edit_popup']) ) ) {
			global $wpdb;
			$popup_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$_GET['edit_popup'].'"');
			if ( !empty($popup_data) ) {
				$extra_styles = json_decode(stripslashes($popup_data['0']->popup_data), true);
				if ( !empty($extra_styles['popup_styles']) ) {
					$new_styles = json_decode(stripslashes($styles[$style_name]), true);
					foreach ($extra_styles['popup_styles'] as $style_key => $style_value) {
						$new_styles['styles'][$style_key] = $style_value;
					}
					$styles[$style_name] = json_encode($new_styles);
				}
			}
		}
		$style .= $styles[$style_name];
	}

	$style .= '</script>';

	return $style;
}

function pm_email_template() {
	$email_form = $popup_style = $popup_name = $popup_entry_anim = $popup_exit_anim = $popup_location = $popup_trigger = $video_embed = $popup_close = $popup_close_type = $image_template_link = $popup_target_input = $popup_target_first_time = $popup_target_reset = $popup_target_page_visits = $popup_target_page_after_visit = $popup_contact_form = $popup_contact_map = $popup_template_style = $popup_facebook_url = $popup_ribbon_url = $popup_geo_ip = $popup_geo_country = $popup_geo_city = $popup_selector = $popup_closing = $popup_cookie_readmore = $popup_close_source = $popup_close_position = $popup_close_width = $popup_predefined_image = $popup_schedule_start = $popup_schedule_end = $popup_page_targets = $popup_page_exclude = $locker_facebook_like_status = $locker_facebook_share_status = $locker_twitter_status = $locker_twitter_follow_status = $locker_gplus_status = $locker_gplus_share_status = $locker_linkedin_status = $locker_pinterest_status = $locker_facebook_like_url = $locker_facebook_like_text = $locker_facebook_share_url = $locker_facebook_share_text = $locker_twitter_url = $locker_twitter_tweet_text = $locker_twitter_via = $locker_twitter_text = $locker_twitter_check = $locker_twitter_follow_user = $locker_twitter_follow_check = $locker_twitter_follow_text = $locker_gplus_url = $locker_gplus_text = $locker_gplus_share_url = $locker_gplus_share_text = $locker_linkedin_url = $locker_linkedin_text = $locker_pinterest_text = $locker_twitter_key = $locker_twitter_secret = $locker_facebook_app_id = $popup_target_inline_location = $popup_height = $popup_disabled_mobile = $popup_disabled_mobile_width = $popup_closing_cond = $popup_closing_timer = '';
	if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'text' ) {
		$popup_title = 'Welcome!';
	} else {
		$popup_title = 'Subscribe now!';
	}
	$popup_disclaimer = 'Aliquam semper nisl mauris, at mollis orci gravida at.';
	$popup_text = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras accumsan laoreet feugiat. Aenean ut accumsan magna, id venenatis mauris.';
	$popup_timer = '0';
	$image_template_bg = PM_PLUGIN_URI.'admin/images/image-bg.png';
	$popup_height_select = 'auto';
	$popup_bg_size = 'cover';
	$popup_bg_position = 'center';
	if ( isset($_GET['edit_popup']) ) {
		global $wpdb;
		$popup_id = ( isset($_GET['edit_popup']) ? $_GET['edit_popup'] : '' );
		$popup_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$popup_id.'"');

		if ( !empty($popup_data) ) {
			$curr_data = json_decode(stripslashes($popup_data['0']->popup_data));

			$form_start = strstr($popup_data['0']->popup_html, '<form');
			$email_form = substr($form_start, 0, strpos($form_start, '</form>')+7);

			$popup_style = '{"styles": {';
			$style_match = array();

			foreach ($curr_data->popup_styles as $style_key => $style_value) {
				// $popup_style .= '.pm-main-wrapper .email-template-step2 '.$style_key . '{'.$style_value.'}';
				$popup_style .= '"'.$style_key.'":'.'"'.$style_value.'",';
				if ( $style_key == '.email-popup-preview' && $curr_data->popup_template != 'video' ) {
					preg_match_all('#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $style_value, $style_match);
				}
			}

			$popup_style = rtrim($popup_style, ',');

			if ( isset($style_match['0']['0']) ) {
				$popup_style .= '},
					"image": "' . $style_match['0']['0'] . '"
				}';
			} else {
				$popup_style .= '},
					"image": "no-image"
				}';
			}

			$popup_name = $popup_data['0']->name;
			$popup_entry_anim = $curr_data->popup_entry_animation;
			$popup_exit_anim = $curr_data->popup_exit_animation;
			$popup_location = $curr_data->popup_location;
			$popup_trigger = $curr_data->popup_trigger;
			$popup_timer = $curr_data->popup_timer;
			$popup_title = $curr_data->popup_title;
			$popup_disclaimer = $curr_data->popup_disclaimer;
			$popup_text = $curr_data->popup_text;
			if ( isset($curr_data->popup_video) ) {
				$video_embed = $curr_data->popup_video;
			}
			if ( isset($curr_data->popup_close) ) {
				$popup_close = $curr_data->popup_close;
			}
			$popup_close_type = $curr_data->popup_close_type;
			if ( isset($curr_data->image_bg) ) {
				$image_template_bg = $curr_data->image_bg;
			}
			if ( isset($curr_data->image_link) ) {
				$image_template_link = $curr_data->image_link;
			}
			if ( isset($curr_data->popup_template_style) ) {
				$popup_template_style = $curr_data->popup_template_style;
			}

			if ( isset($curr_data->popup_target_input) ) {
				$popup_target_input = $curr_data->popup_target_input;
				$popup_target_first_time = $curr_data->popup_target_first_time;
				$popup_target_reset = $curr_data->popup_target_reset;
				$popup_target_page_visits = $curr_data->popup_target_page_visits;
				$popup_target_page_after_visit = $curr_data->popup_target_page_after_visit;
			}

			if ( isset($curr_data->popup_contact_form) ) {
				$popup_contact_form = $curr_data->popup_contact_form;
			}

			if ( isset($curr_data->popup_contact_map) ) {
				$popup_contact_map = $curr_data->popup_contact_map;
			}

			if ( isset($curr_data->popup_facebook_url) ) {
				$popup_facebook_url = $curr_data->popup_facebook_url;
			}

			if ( isset($curr_data->popup_ribbon_url) ) {
				$popup_ribbon_url = $curr_data->popup_ribbon_url;
			}

			if ( isset($curr_data->popup_geo_ip) ) {
				$popup_geo_ip = $curr_data->popup_geo_ip;
				$popup_geo_country = $curr_data->popup_geo_country;
				$popup_geo_city = $curr_data->popup_geo_city;
			}

			if ( isset($curr_data->popup_selector) ) {
				$popup_selector = $curr_data->popup_selector;
			}

			if ( isset($curr_data->popup_closing) ) {
				$popup_closing = $curr_data->popup_closing;
			}

			if ( isset($curr_data->popup_cookie_readmore) ) {
				$popup_cookie_readmore = $curr_data->popup_cookie_readmore;
			}

			if ( isset($curr_data->popup_close_source) ) {
				$popup_close_source = $curr_data->popup_close_source;
			}

			if ( isset($curr_data->popup_close_position) ) {
				$popup_close_position = $curr_data->popup_close_position;
			}

			if ( isset($curr_data->popup_close_width) ) {
				$popup_close_width = $curr_data->popup_close_width;
			}

			if ( isset($curr_data->popup_predefined_image) ) {
				$popup_predefined_image = $curr_data->popup_predefined_image;
			}

			if ( isset($curr_data->popup_schedule) ) {
				$popup_schedule_start = $curr_data->popup_schedule->start;
				$popup_schedule_end = $curr_data->popup_schedule->end;
			}

			if ( isset($curr_data->popup_page_targets) ) {
				$popup_page_targets = $curr_data->popup_page_targets;
			}

			if ( isset($curr_data->popup_page_exclude) ) {
				$popup_page_exclude = $curr_data->popup_page_exclude;
			}

			if ( isset($curr_data->locker_facebook_like_status) ) {
				$locker_facebook_like_status = 'true';
				$locker_twitter_status = 'true';
				$locker_gplus_status = 'true';
				$locker_linkedin_status = 'true';
				$locker_pinterest_status = 'true';

				$locker_facebook_like_status = $curr_data->locker_facebook_like_status;
				$locker_facebook_share_status = $curr_data->locker_facebook_share_status;
				$locker_twitter_status = $curr_data->locker_twitter_status;
				$locker_twitter_follow_status = $curr_data->locker_twitter_follow_status;
				$locker_gplus_status = $curr_data->locker_gplus_status;
				$locker_gplus_share_status = $curr_data->locker_gplus_share_status;
				$locker_linkedin_status = $curr_data->locker_linkedin_status;
				$locker_pinterest_status = $curr_data->locker_pinterest_status;
				$locker_facebook_like_url = $curr_data->locker_facebook_like_url;
				$locker_facebook_like_text = $curr_data->locker_facebook_like_text;
				$locker_facebook_share_url = $curr_data->locker_facebook_share_url;
				$locker_facebook_share_text = $curr_data->locker_facebook_share_text;
				$locker_twitter_url = $curr_data->locker_twitter_url;
				$locker_twitter_tweet_text = $curr_data->locker_twitter_tweet_text;
				$locker_twitter_via = $curr_data->locker_twitter_via;
				$locker_twitter_text = $curr_data->locker_twitter_text;
				$locker_twitter_check = $curr_data->locker_twitter_check;
				$locker_twitter_follow_user = $curr_data->locker_twitter_follow_user;
				$locker_twitter_follow_check = $curr_data->locker_twitter_follow_check;
				$locker_twitter_follow_text = $curr_data->locker_twitter_follow_text;
				$locker_gplus_url = $curr_data->locker_gplus_url;
				$locker_gplus_text = $curr_data->locker_gplus_text;
				$locker_gplus_share_url = $curr_data->locker_gplus_share_url;
				$locker_gplus_share_text = $curr_data->locker_gplus_share_text;
				$locker_linkedin_url = $curr_data->locker_linkedin_url;
				$locker_linkedin_text = $curr_data->locker_linkedin_text;
				$locker_pinterest_text = $curr_data->locker_pinterest_text;
				$locker_twitter_key = $curr_data->locker_twitter_key;
				$locker_twitter_secret = $curr_data->locker_twitter_secret;
				$locker_facebook_app_id = $curr_data->locker_facebook_app_id;
			}

			if ( isset($curr_data->popup_target_inline_location) ) {
				$popup_target_inline_location = $curr_data->popup_target_inline_location;
			}

			if ( isset($curr_data->popup_height) ) {
				$popup_height_select = $curr_data->popup_height_select;
				$popup_height = $curr_data->popup_height;
			}

			if ( isset($curr_data->popup_bg_size) ) {
				$popup_bg_size = $curr_data->popup_bg_size;
			}

			if ( isset($curr_data->popup_bg_position) ) {
				$popup_bg_position = $curr_data->popup_bg_position;
			}

			if ( isset($curr_data->popup_disabled_mobile) ) {
				$popup_disabled_mobile = $curr_data->popup_disabled_mobile;
				$popup_disabled_mobile_width = $curr_data->popup_disabled_mobile_width;
			}

			if ( isset($curr_data->popup_closing_cond) ) {
				$popup_closing_cond = $curr_data->popup_closing_cond;
				$popup_closing_timer = $curr_data->popup_closing_timer;
			}

		}
	}
	?>
	<div class="row">
		<?php if ( isset($_GET['pm-template']) && ( $_GET['pm-template'] == 'email' || $_GET['pm-template'] == 'sidebar' || $_GET['pm-template'] == 'actionbar' ) ) { ?>
			<div class="email-template-step1 col-md-12">
				<a href="javascript:void(0)" id="edit-email-template" class="pm-next-step pmicon-right-big">Next step</a>
				<div class="pm-card-box">
					<h2 class="col-md-12 header-title">Email form configuration</h2>
					<p class="col-md-12 text-muted font-13 m-b-30">Currently supported email marketing systems: <b>AWeber, MailChimp, Mad Mimi, ActiveCampaign, GetResponse, Constant Contact, Campaign Monitor, iContact, Freshmail, SendPress, mailpoet, sendinblue, mailer lite, sales autopilot, Elastic Email, AgileCRM, Benchmark, SendPulse, Customer.io, Sendlane, The Newsletter Plugin</b></p>
					<div class="clearfix"></div>
					<div class="alert alert-error email-form"><p><strong>Error!</strong> It seems that there's no form present, please edit your code and try again.</p></div>
					<div class="alert alert-error email-inputs"><p><strong>Error!</strong> It seems that there's no input fields, please edit your code and try again.</p></div>
					<div class="alert alert-info email-inputs email-form"><p><strong>Info!</strong> Having trouble with your form? Look into our <a href="http://documentation.cohhe.com/popup-manager/knowledgebase/email-template-forms/" target="_blank">documentation</a> page.</p></div>
					<div class="form-group clearfix">
						<textarea id="pm-email-template" class="form-control"><?php echo $email_form; ?></textarea>
					</div>
					<p>Found form with action: <b id="pm-email-template-action">None</b></p>
					<p>Currently found fields: <b id="pm-email-template-field">0</b></p>
				</div>
			</div>
		<?php } else if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'image' ) { ?>
			<div class="email-template-step1 image col-md-12 col-xs-6">
				<a href="javascript:void(0)" id="edit-image-template" class="pm-next-step pmicon-right-big">Next step</a>
				<div class="pm-card-box">
					<h2 class="col-md-12 header-title">Image configuration</h2>
					<p class="col-md-12 text-muted font-13 m-b-30">Create and manage powerful and yet, easy to use image promotion popup.</p>
					<div class="form-group clearfix">
						<label for="pm-image-url" class="control-label col-md-3">URL to your image *</label>
						<div class="form-group file-upload col-md-9 clearfix">
							<a href="javascript:void(0)" class="pm-primary-button choose-image pmicon-folder-open">Choose image</a>
							<input type="text" value="<?php echo $image_template_bg; ?>" id="pm-image-url" class="form-control popup" disabled />
							<a href="javascript:void(0)" class="delete-image hidden pmicon-cancel"></a>
						</div>
					</div>
					<div class="form-group clearfix">
						<label for="pm-image-to-url" class="control-label col-md-3">Popup link *</label>
						<div class="input-wrapper col-md-9">
							<input type="text" id="pm-image-to-url" class="form-control" value="<?php echo $image_template_link; ?>">
							<span class="input-notice"></span>
						</div>
					</div>
					<div class="form-group clearfix">
						<label class="col-lg-12 control-label ">(*) Mandatory</label>
					</div>
				</div>
			</div>
		<?php } else if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'video' ) { ?>
			<div class="email-template-step1 col-md-12 col-xs-6">
				<a href="javascript:void(0)" id="edit-video-template" class="pm-next-step pmicon-right-big">Next step</a>
				<div class="pm-card-box">
					<h2 class="col-md-12 header-title">Video configuration</h2>
					<p class="col-md-12 text-muted font-13 m-b-30">You can provide your video embed code below.</p>
					<div class="clearfix"></div>
					<div class="form-group clearfix">
						<textarea id="pm-video-embed" class="form-control"><?php echo $video_embed; ?></textarea>
					</div>
				</div>
			</div>
		<?php } else if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'contact' ) { ?>
			<div class="email-template-step1 col-md-12 col-xs-6">
				<a href="javascript:void(0)" id="edit-contact-template" class="pm-next-step pmicon-right-big">Next step</a>
				<div class="pm-card-box">
					<h2 class="col-md-12 header-title">Contact form shortcode configuration</h2>
					<p class="col-md-12 text-muted font-13 m-b-30">You can use your <strong>Ninja Forms</strong> or <strong>Contact Form 7</strong> forms here.</p>
					<div class="clearfix"></div>
					<div class="form-group clearfix">
						<p class="col-md-12 text-muted font-13 m-b-10">Your <strong>Ninja Forms</strong> or <strong>Contact Form 7</strong> shortcode here.</p>
						<input type="text" id="pm-contact-form" class="form-control" value="<?php echo $popup_contact_form; ?>" />
					</div>
					<div class="form-group clearfix">
						<p class="col-md-12 text-muted font-13 m-b-10">Your google map iframe here.</p>
						<textarea id="pm-contact-map" class="form-control"><?php echo $popup_contact_map; ?></textarea>
					</div>
				</div>
			</div>
		<?php } else if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'likebox' ) { ?>
			<div class="email-template-step1 col-md-12 col-xs-6">
				<a href="javascript:void(0)" id="edit-likebox-template" class="pm-next-step pmicon-right-big">Next step</a>
				<div class="pm-card-box">
					<h2 class="col-md-12 header-title">Likebox widget configuration</h2>
					<p class="col-md-12 text-muted font-13 m-b-30">You'll need to provide your facebook page URL.</p>
					<div class="clearfix"></div>
					<div class="form-group clearfix">
						<p class="col-md-12 text-muted font-13">Example: http://www.facebook.com/cohhethemes</p>
						<input type="text" id="pm-facebook-url" class="form-control" value="<?php echo $popup_facebook_url; ?>" />
					</div>
				</div>
			</div>
		<?php } else if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'ribbon' ) { ?>
			<div class="email-template-step1 col-md-12 col-xs-6">
				<a href="javascript:void(0)" id="edit-ribbon-template" class="pm-next-step pmicon-right-big">Next step</a>
				<div class="pm-card-box">
					<h2 class="col-md-12 header-title">Ribbon configuration</h2>
					<p class="col-md-12 text-muted font-13 m-b-30">You'll need to provide an URL for your ribbon.</p>
					<div class="clearfix"></div>
					<div class="form-group clearfix">
						<input type="text" id="pm-ribbon-url" class="form-control" value="<?php echo $popup_ribbon_url; ?>" />
					</div>
				</div>
			</div>
		<?php } else if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'cookie' ) { ?>
			<div class="email-template-step1 col-md-12 col-xs-6">
				<a href="javascript:void(0)" id="edit-cookie-template" class="pm-next-step pmicon-right-big">Next step</a>
				<div class="pm-card-box">
					<h2 class="col-md-12 header-title">Cookie Law configuration</h2>
					<p class="col-md-12 text-muted font-13 m-b-30">You'll need to provide URL for your cookie law "Read more" button.</p>
					<div class="clearfix"></div>
					<div class="form-group clearfix">
						<p class="col-md-12 text-muted font-13">Provide an URL for your "Read more" button.</p>
						<input type="text" id="pm-cookie-readmore" class="form-control" value="<?php echo $popup_cookie_readmore; ?>" />
					</div>
				</div>
			</div>
		<?php } ?>
		<div class="col-md-12">
			<div class="email-template-step2 row" <?php echo isset($_GET['pm-template']) && ( $_GET['pm-template'] == 'text' || $_GET['pm-template'] == 'verification' || $_GET['pm-template'] == 'tab' || $_GET['pm-template'] == 'messenger' || $_GET['pm-template'] == 'locker' || $_GET['pm-template'] == 'survey' ) ? 'style="display: block;"' : ''; ?>>
				<div class="pm-step2-nav col-md-12">
					<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'text' && $_GET['pm-template'] != 'verification' ) { ?>
						<a href="javascript:void(0)" id="back-edit-email-template" class="pm-prev-step pmicon-left-big">Previous step</a>
					<?php } ?>
					<a href="javascript:void(0)" id="edit-email-template2" class="pm-next-step pmicon-right-big">Next step</a>
				</div>
				<div class="clearfix"></div>
				<div class="email-template-middle col-md-3 col-xs-6">
					<div class="pm-card-box">
						<h2 class="col-md-12 header-title">General popup style</h2>
						<p class="col-md-12 text-muted font-13 m-b-30">Here you can style your popup.</p>
						<div class="form-group clearfix">
							<h4>Popup width (px)</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-popup-width" class="popup" value="500" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<?php if ( !function_exists('pmtemplate_get_popup_height') ) { ?>
						<div class="form-group feature-locked templates clearfix">
							<h4>Popup height</h4>
							<select id="profeature22" disabled>
								<option value="auto">Auto</option>
								<option value="fixed">Fixed</option>
							</select>
						</div>
						<?php } ?>
						<?php do_action( 'pm_template_popup_height' ); ?>
						<div class="form-group clearfix">
							<h4>Popup padding</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus popup">-</span>
								<input type="number" id="email-template-popup-padding" class="popup" value="40" />
								<span class="pm-number-plus popup">+</span>
							</div>
						</div>
						<div class="form-group clearfix">
							<h4>Background color</h4>
							<input type="text" value="#fff" id="email-template-background-color" class="wpcolorpicker popup" />
						</div>
						<div class="form-group clearfix">
							<h4>Popup border radius (px)</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-popup-border-radius" class="popup" value="5" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group clearfix">
							<h4>Popup top margin (px)</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-popup-margin-top" class="popup" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group clearfix">
							<h4>Popup bottom margin (px)</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-popup-margin-bottom" class="popup" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group clearfix">
							<h4>Popup left margin (px)</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-popup-margin-left" class="popup" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group clearfix">
							<h4>Popup right margin (px)</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-popup-margin-right" class="popup" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'image' ) { ?>
							<div class="form-group file-upload clearfix">
								<h4>Background image</h4>
								<a href="javascript:void(0)" class="pm-primary-button choose-image pmicon-folder-open">Choose image</a>
								<input type="text" value="No file" id="email-template-background-image" class="form-control popup" disabled />
								<a href="javascript:void(0)" class="delete-image hidden pmicon-cancel"></a>
							</div>
						<?php } ?>
						<?php if ( !function_exists('pmtemplate_get_background_options') ) { ?>
							<div class="form-group feature-locked templates clearfix">
								<h4>Background size</h4>
								<select id="profeature23" disabled>
									<option value="cover">Cover</option>
									<option value="contain">Contain</option>
									<option value="custom">Custom</option>
								</select>
							</div>
							<div class="form-group feature-locked templates clearfix">
								<h4>Background position</h4>
								<select id="profeature24" disabled>
									<option value="top">Top</option>
									<option value="center">Center</option>
									<option value="bottom">Bottom</option>
									<option value="custom">Custom</option>
								</select>
							</div>
						<?php } ?>
						<?php do_action( 'pm_template_background_options' ); ?>
					</div>
					<div class="pm-card-box">
						<h2 class="col-md-12 header-title">Popup box shadow</h2>
						<p class="col-md-12 text-muted font-13 m-b-30">You can configure your popup box shadow here.</p>
						<div class="form-group clearfix">
							<h4>Shadow type</h4>
							<select id="email-template-box-shadow-type">
								<option value="none">None</option>
								<option value="outset" selected>Outset</option>
								<option value="inset">Inset</option>
							</select>
						</div>
						<div class="form-group clearfix">
							<h4>Shadow color</h4>
							<input type="text" value="#fff" id="email-template-box-shadow-color" class="wpcolorpicker-boxshadow box-shadow" />
						</div>
						<div class="form-group clearfix">
							<h4>Shadow opacity</h4>
							<div class="colorpicker-opacity box-shadow"></div>
						</div>
						<div class="form-group clearfix">
							<h4>Horizontal length</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-box-shadow-horizontal" class="box-shadow" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group clearfix">
							<h4>Vertical length</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-box-shadow-vertical" class="box-shadow" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group clearfix">
							<h4>Blur radius</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-box-shadow-blur" class="box-shadow" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group clearfix">
							<h4>Spread radius</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-box-shadow-spread" class="box-shadow" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
					</div>
					<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'locker' ) { ?>
					<div class="pm-card-box">
						<h2 class="col-md-12 header-title">Popup close link</h2>
						<p class="col-md-12 text-muted font-13 m-b-30">Here you can edit your popup close link.</p>
						<div class="form-group clearfix close-link">
							<div class="form-group clearfix">
								<h4>Close link type</h4>
								<select id="email-template-close-link-type">
									<option value="">Choose...</option>
									<option value="text">Text</option>
									<option value="image" selected>Image</option>
									<option value="nothing">Do not close</option>
								</select>
							</div>
							<div class="close-link-source form-group clearfix">
								<h4>Image source</h4>
								<select id="email-template-close-link-source">
									<option value="">Choose...</option>
									<option value="upload" selected>Upload</option>
									<option value="predefined">Predefined</option>
								</select>
							</div>
							<div class="close-link-predefined form-group clearfix">
								<div class="close-link-images">
									<img src="<?php echo PM_PLUGIN_URI; ?>admin/images/close-images/close-1.png" alt="" data-type="close-1">
									<img src="<?php echo PM_PLUGIN_URI; ?>admin/images/close-images/close-2.png" alt="" data-type="close-2">
									<img src="<?php echo PM_PLUGIN_URI; ?>admin/images/close-images/close-3.png" alt="" data-type="close-3">
									<img src="<?php echo PM_PLUGIN_URI; ?>admin/images/close-images/close-4.png" alt="" data-type="close-4">
									<img src="<?php echo PM_PLUGIN_URI; ?>admin/images/close-images/close-5.png" alt="" data-type="close-5">
									<img src="<?php echo PM_PLUGIN_URI; ?>admin/images/close-images/close-6.png" alt="" data-type="close-6">
									<img src="<?php echo PM_PLUGIN_URI; ?>admin/images/close-images/close-7.png" alt="" data-type="close-7">
									<img src="<?php echo PM_PLUGIN_URI; ?>admin/images/close-images/close-8.png" alt="" data-type="close-8">
									<input type="hidden" id="email-template-predefined-img" value="">
								</div>
							</div>
							<div class="close-link-text form-group clearfix">
								<h4>Close link text</h4>
								<input type="text" value="<?php echo $popup_close; ?>" id="email-template-close-link-text" class="form-control popup" />
							</div>
							<div class="close-link-image form-group file-upload clearfix">
								<h4>Close link image</h4>
								<a href="javascript:void(0)" class="pm-primary-button choose-image pmicon-folder-open">Choose image</a>
								<input type="text" value="<?php echo pm_get_close_image(); ?>" id="email-template-close-link-image" class="form-control popup" disabled />
								<a href="javascript:void(0)" class="delete-image hidden pmicon-cancel"></a>
							</div>
							<div class="form-group close-link-advanced">
								<h4>Close image width</h4>
								<div class="pm-number-field">
									<span class="pm-number-minus">-</span>
									<input type="number" id="email-template-close-image-width" class="popup" value="25" />
									<span class="pm-number-plus">+</span>
								</div>
							</div>
							<div class="form-group close-link-advanced">
								<h4>Position</h4>
								<select id="email-template-close-link-position">
									<option value="inside" selected>Inside modal</option>
									<option value="edge">On modal edge</option>
									<option value="outside">Outside modal</option>
								</select>
							</div>
							<?php
							do_action( 'pm_template_closing_timer' );
							if ( !function_exists('pmtemplate_add_to_closing_settings') ) {
								?>
								<div class="form-group closing-link feature-locked templates clearfix">
									<h4>Close link behavior</h4>
									<select id="profeature88" disabled>
										<option value="default">Show close link instantly</option>
										<option value="timer-show">Show close link after timer</option>
										<option value="timer-close">Close popup after timer</option>
									</select>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<?php } ?>
					<?php
					if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'email' ) {
						if ( !function_exists('pmtemplate_get_thankyou_screen') ) { ?>
							<div class="pm-card-box">
								<h2 class="col-md-12 header-title">Thank you screen</h2>
								<p class="col-md-12 text-muted font-13 m-b-30">You're able to provide a thank you screen that'll be shown after a visitor is subscribed.</p>
								<div class="form-group feature-locked templates clearfix">
									<h4>Thank you screen text</h4>
									<p class="col-md-12 text-muted font-13">You can add a link into the text like this - &lt;a href="http://example.com"&gt;my link text&lt;/a&gt;.</p>
									<textarea id="profeature33" class="form-control" style="min-height: 150px;" disabled></textarea>
								</div>
							</div>
						<?php }
						do_action( 'pm_template_thankyou_screen' );
					}
					?>
				</div>
				<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'image' ) { ?>
				<div class="email-template-left col-md-3 col-xs-6">
					<div class="pm-card-box">
						<h2 class="col-md-12 header-title">Element style configuration</h2>
						<p class="col-md-12 text-muted font-13 m-b-30">Here you're able to style your popup elements.</p>
						<input type="hidden" id="email-template-last-clicked" value="" />
						<input type="hidden" id="email-template-fonts" value="" />
						<div id="custom-google-fonts">
							<?php
							$font_url = '';
							if ( isset($curr_data->popup_fonts) && $curr_data->popup_fonts != '' ) {
								$font_url = "<link href='https://fonts.googleapis.com/css?family=";
								$font_arr = explode('|', $curr_data->popup_fonts);
								foreach ($font_arr as $font_value) {
									$font_value = str_replace(' ', '+', $font_value);
									$font_url .= $font_value . ':300,400,700|';
								}
								$font_url = rtrim($font_url, '|');
								$font_url .= "' rel='stylesheet' type='text/css'>";
							}
							echo $font_url;
							?>
						</div>
						<div class="clearfix"></div>
						<div class="alert alert-error choose-field"><p>At the popup preview window please click on the element you want to edit.</p></div>
						<?php if ( !function_exists('pmtemplate_add_element_animations') ) { ?>
							<div class="form-group show-for-text show-for-input feature-locked templates clearfix">
								<h4>Element entry animation</h4>
								<select id="pm-pro-feature1" disabled>
									<option value="">Choose...</option>
								  </select>
								  <span class="input-notice"></span>
								</div>
								<div class="form-group show-for-text show-for-input feature-locked templates clearfix">
								<h4>Element exit animation</h4>
								<select id="pm-pro-feature2" disabled>
									<option value="">Choose...</option>
								  </select>
								  <span class="input-notice"></span>
								</div>
								<div class="form-group show-for-text feature-locked templates clearfix">
									<h4>Insert URL</h4>
									<p class="col-md-12 text-muted font-13">Enter your desired URL and select the text you want to add it to.</p>
									<input type="text" id="pro-feature-44" class="form-control" value="" disabled/>
								</div>
						<?php } ?>
						<?php do_action( 'pm_template_element_animations' ); ?>
						<?php if ( !function_exists('pmtemplate_get_font_select') ) { ?>
							<div class="form-group show-for-text show-for-input clearfix feature-locked templates">
								<h4>Font family</h4>
								<p class="col-md-12 text-muted font-13">New fonts are loaded upon font changes, there might be a little delay.</p>
								<select id="pro-feature-22" disabled>
									<option value="">Choose...</option>
								</select>
							</div>
						<?php } ?>
						<?php do_action( 'pm_template_google_fonts' ); ?>
						<?php do_action( 'pm_template_verification_url' ); ?>
						<div class="form-group show-for-text show-for-input clearfix">
							<h4>Font size</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-font-size" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group show-for-text clearfix">
							<h4>Line height</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-line-height" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group show-for-text show-for-input clearfix">
							<h4>Font weight</h4>
							<select id="email-template-font-weight">
								<option value="300">Light</option>
								<option value="400">Normal</option>
								<option value="700">Bold</option>
							</select>
						</div>
						<div class="form-group show-for-text show-for-input clearfix">
							<h4>Font color</h4>
							<input type="text" value="#fff" id="email-template-color" class="wpcolorpicker" />
						</div>
						<div class="form-group show-for-text show-for-input clearfix">
							<h4>Background color</h4>
							<input type="text" value="#fff" id="email-template-background-color" class="wpcolorpicker" />
						</div>
						<div class="form-group show-for-input clearfix">
							<h4>Border radius</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-border-radius" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group show-for-input clearfix">
							<h4>Border color</h4>
							<input type="text" value="#fff" id="email-template-border-color" class="wpcolorpicker" />
						</div>
						<div class="form-group show-for-text clearfix">
							<h4>Text align</h4>
							<select id="email-template-text-align">
								<option value="left">Left</option>
								<option value="center" selected>Center</option>
								<option value="right">Right</option>
							</select>
						</div>
						<div class="form-group show-for-text show-for-input clearfix">
							<h4>Top padding</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-padding-top" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group show-for-text show-for-input clearfix">
							<h4>Bottom padding</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-padding-bottom" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group show-for-text show-for-input clearfix">
							<h4>Left padding</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-padding-left" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
						<div class="form-group show-for-text show-for-input clearfix">
							<h4>Right padding</h4>
							<div class="pm-number-field">
								<span class="pm-number-minus">-</span>
								<input type="number" id="email-template-padding-right" value="0" />
								<span class="pm-number-plus">+</span>
							</div>
						</div>
					</div>
					<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'locker' ) { ?>
						<div class="pm-card-box pm-locker-options">
							<h2 class="col-md-12 header-title">Locker button configuration</h2>
							<p class="col-md-12 text-muted font-13 m-b-30">Here you're able to configure your locker icons. Note that some of the features might not be working on localhost.</p>
							<div class="clearfix"></div>
							<div class="form-group locker-button-visibility clearfix">
								<h4>Facebook like button</h4>
								<input type="checkbox" value="" id="email-template-locker-facebook-like-status" />
							</div>
							<div class="form-group locker-button-visibility clearfix">
								<h4>Facebook share button</h4>
								<input type="checkbox" value="" id="email-template-locker-facebook-share-status" />
							</div>
							<div class="form-group locker-button-visibility clearfix">
								<h4>Twitter tweet button</h4>
								<input type="checkbox" value="" id="email-template-locker-twitter-status" />
							</div>
							<div class="form-group locker-button-visibility clearfix">
								<h4>Twitter follow button</h4>
								<input type="checkbox" value="" id="email-template-locker-twitter-follow-status" />
							</div>
							<div class="form-group locker-button-visibility clearfix">
								<h4>Google +1 button</h4>
								<input type="checkbox" value="" id="email-template-locker-gplus-status" />
							</div>
							<div class="form-group locker-button-visibility clearfix">
								<h4>Google+ share button</h4>
								<input type="checkbox" value="" id="email-template-locker-gplus-share-status" />
							</div>
							<div class="form-group locker-button-visibility clearfix">
								<h4>LinkedIn button</h4>
								<input type="checkbox" value="" id="email-template-locker-linkedin-status" />
							</div>
							<div class="form-group locker-button-visibility clearfix">
								<h4>Pinterest button</h4>
								<input type="checkbox" value="" id="email-template-locker-pinterest-status" />
							</div>
							<div class="form-group facebook-like clearfix">
								<h4>URL to like</h4>
								<p class="col-md-12 text-muted font-13">Provide an external URL to be liked, leave blank to use the URL of the page.</p>
								<input type="text" value="" id="email-template-locker-facebook-like-url" class="form-control"/>
							</div>
							<div class="form-group facebook-like clearfix">
								<h4>Button text</h4>
								<p class="col-md-12 text-muted font-13">Provide a text for the like button.</p>
								<input type="text" value="" id="email-template-locker-facebook-like-text" class="form-control"/>
							</div>
							<div class="form-group facebook-share clearfix">
								<h4>URL to share</h4>
								<p class="col-md-12 text-muted font-13">Provide an external URL to be shared, leave blank to use the URL of the page.</p>
								<input type="text" value="" id="email-template-locker-facebook-share-url" class="form-control"/>
							</div>
							<div class="form-group facebook-share clearfix">
								<h4>Button text</h4>
								<p class="col-md-12 text-muted font-13">Provide a text for the share button.</p>
								<input type="text" value="" id="email-template-locker-facebook-share-text" class="form-control"/>
							</div>
							<div class="form-group facebook-like facebook-share clearfix">
								<h4>Facebook app ID<span class="required-star">*</span></h4>
								<p class="col-md-12 text-muted font-13"><span class="required-star">*</span> - Your button won't show without this option filled!</p>
								<p class="col-md-12 text-muted font-13">Provide your facebook app ID, read about it <a href="http://documentation.cohhe.com/popup-manager/knowledgebase/facebook-app-id/" target="_blank">here</a>.</p>
								<input type="text" value="" id="email-template-locker-facebook-app-id" class="form-control"/>
							</div>
							<div class="form-group twitter clearfix">
								<h4>URL to tweet</h4>
								<p class="col-md-12 text-muted font-13">Provide an URL that's going to be included in the tweet.</p>
								<input type="text" value="" id="email-template-locker-twitter-url" class="form-control"/>
							</div>
							<div class="form-group twitter clearfix">
								<h4>Text to tweet</h4>
								<p class="col-md-12 text-muted font-13">Provide the text that's going to be tweeted.</p>
								<input type="text" value="" id="email-template-locker-twitter-tweet-text" class="form-control"/>
							</div>
							<div class="form-group twitter clearfix">
								<h4>Via</h4>
								<p class="col-md-12 text-muted font-13">Provide an twitter username without @.</p>
								<input type="text" value="" id="email-template-locker-twitter-via" class="form-control"/>
							</div>
							<div class="form-group twitter clearfix">
								<h4>Button text</h4>
								<p class="col-md-12 text-muted font-13">Provide a text for the tweet button.</p>
								<input type="text" value="" id="email-template-locker-twitter-text" class="form-control"/>
							</div>
							<div class="form-group twitter-follow clearfix">
								<h4>User to follow</h4>
								<p class="col-md-12 text-muted font-13">Provide an username without @.</p>
								<input type="text" value="" id="email-template-locker-twitter-follow-user" class="form-control"/>
							</div>
							<div class="form-group twitter-follow clearfix">
								<h4>Button text</h4>
								<p class="col-md-12 text-muted font-13">Provide a text for the follow button.</p>
								<input type="text" value="" id="email-template-locker-twitter-follow-text" class="form-control"/>
							</div>
							<div class="form-group twitter twitter-follow clearfix">
								<h4>Twitter API consumer key<span class="required-star">*</span></h4>
								<p class="col-md-12 text-muted font-13"><span class="required-star">*</span> - Your button won't show without this option filled!</p>
								<p class="col-md-12 text-muted font-13">Read more about it <a href="http://documentation.cohhe.com/popup-manager/knowledgebase/twitter-api-keys/" target="_blank">here</a></p>
								<input type="text" value="" id="email-template-locker-twitter-key" class="form-control"/>
							</div>
							<div class="form-group twitter twitter-follow clearfix">
								<h4>Twitter API consumer secret<span class="required-star">*</span></h4>
								<p class="col-md-12 text-muted font-13"><span class="required-star">*</span> - Your button won't show without this option filled!</p>
								<p class="col-md-12 text-muted font-13">Read more about it <a href="http://documentation.cohhe.com/popup-manager/knowledgebase/twitter-api-keys/" target="_blank">here</a></p>
								<input type="text" value="" id="email-template-locker-twitter-secret" class="form-control"/>
							</div>
							<div class="form-group gplus clearfix">
								<p class="col-md-12 text-muted font-13 m-t-30 m-b-0">Note that Google+ returns a positive value while checking if user +1 your link if user is logged in a gmail account but hasn't configured his Google+ page.</p>
							</div>
							<div class="form-group gplus clearfix">
								<h4>URL to +1</h4>
								<p class="col-md-12 text-muted font-13">Provide an external URL to be +1'd</p>
								<input type="text" value="" id="email-template-locker-gplus-url" class="form-control"/>
							</div>
							<div class="form-group gplus clearfix">
								<h4>Button text</h4>
								<p class="col-md-12 text-muted font-13">Provide a text for the +1 button.</p>
								<input type="text" value="" id="email-template-locker-gplus-text" class="form-control"/>
							</div>
							<div class="form-group gplus-share clearfix">
								<h4>URL to share</h4>
								<p class="col-md-12 text-muted font-13">Provide an external URL to be shared</p>
								<input type="text" value="" id="email-template-locker-gplus-share-url" class="form-control"/>
							</div>
							<div class="form-group gplus-share clearfix">
								<h4>Button text</h4>
								<p class="col-md-12 text-muted font-13">Provide a text for the share button.</p>
								<input type="text" value="" id="email-template-locker-gplus-share-text" class="form-control"/>
							</div>
							<div class="form-group linkedin clearfix">
								<p class="col-md-12 text-muted font-13 m-t-30 m-b-0">Note that the content might be accessible if the user closes the popup window without sharing due to the technical bug on LinkedIn side.</p>
							</div>
							<div class="form-group linkedin clearfix">
								<h4>URL to share</h4>
								<p class="col-md-12 text-muted font-13">Provide an external URL to be shared</p>
								<input type="text" value="" id="email-template-locker-linkedin-url" class="form-control"/>
							</div>
							<div class="form-group linkedin clearfix">
								<h4>Button text</h4>
								<p class="col-md-12 text-muted font-13">Provide a text for the linkedin button.</p>
								<input type="text" value="" id="email-template-locker-linkedin-text" class="form-control"/>
							</div>
							<div class="form-group pinterest clearfix">
								<p class="col-md-12 text-muted font-13 m-t-30 m-b-0">Note that the content might be accessible if the user closes the popup window without Pining an image.</p>
							</div>
							<div class="form-group pinterest clearfix">
								<h4>Button text</h4>
								<p class="col-md-12 text-muted font-13">Provide a text for the pinterest button.</p>
								<input type="text" value="" id="email-template-locker-pinterest-text" class="form-control"/>
							</div>
						</div>
					<?php } ?>
				</div>
				<?php } ?>
				<div class="email-template-right col-md-6 col-xs-6">
					<?php
						$template = $template_style = '';
						if ( isset($_GET['pm-template']) ) {
							$template = $_GET['pm-template'];
						}
						if ( isset($_GET['pm-style']) ) {
							$template_style = $_GET['pm-style'];
						} else if ( isset($curr_data->popup_template_style) ) {
							$template_style = $curr_data->popup_template_style;
						}
					?>
					<div class="pm-card-box">
						<h2 class="col-md-12 header-title">Popup preview</h2>
						<p class="col-md-12 text-muted font-13 m-b-30">This is a preview of your popup.</p>
						<div class="clearfix"></div>
						<?php
						if ( isset($_GET['pm-style']) && $_GET['pm-style'] != '' ) {
							$curr_temp_style = $_GET['pm-style'];
						} else if ( $popup_template_style != '' ) {
							$curr_temp_style = $popup_template_style;
						}
						?>
						<input type="hidden" id="email-template-style" value="<?php echo (isset($curr_temp_style)?$curr_temp_style:''); ?>">
						<?php if ( isset($_GET['pm-style']) ) {
							echo pm_get_popup_style_json( $_GET['pm-style'] );
						} else if ( $popup_template_style != '' ) {
							echo pm_get_popup_style_json( $popup_template_style );
						}
						if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'locker' && function_exists('pmlocker_preview_script') ) {
							echo pmlocker_preview_script();
						}
						?>
						<script type="text/preloaded" class="popup-extra-style"><?php echo $popup_style; ?></script>
						<div class="form-group overlay-color clearfix">
							<div class="left-side">
								<h4>Background opacity</h4>
								<div class="colorpicker-opacity"></div>
							</div>
							<div class="right-side">
								<h4>Background color</h4>
								<input type="text" value="#fff" id="email-template-overlay-background-color" class="wpcolorpicker-overlay" />
								<a href="javascript:void(0)" class="popup-live-preview pm-next-step">Preview</a>
							</div>
						</div>
						<div class="email-popup-live-preview">
							<div class="preview-controls">
								<h2>Responsive</h2>
								<span class="live-preview-close pmicon-cancel"></span>
								<ul class="clearfix">
									<li data-device="mobile" class="pmicon-mobile selected"></li>
									<li data-device="mobile-landscape" class="pmicon-mobile"></li>
									<li data-device="tablet" class="pmicon-tablet"></li>
									<li data-device="tablet-landscape" class="pmicon-tablet"></li>
									<li data-device="desktop" class="pmicon-desktop"></li>
								</ul>
								<p>The preview here is not 100% accurate, to be sure you'll have to open your popup on an actual device.</p>
							</div>
							<div class="preview-device-wrapper mobile">
								<div class="preview-device-inner"></div>
							</div>
						</div>
						<div class="email-popup-preview-box <?php echo isset($_GET['pm-template']) ? $_GET['pm-template'].'-template' : ''; ?> <?php echo (isset($curr_temp_style)?$curr_temp_style:'').'-style'; ?>">
							<div class="email-popup-preview-box-overlay"></div>
							<?php
								$popup_id = false;
								if ( isset($_GET['edit_popup']) ) {
									$popup_id = sanitize_key( $_GET['edit_popup'] );
								}
								pm_get_template_preview( $template, $template_style, $popup_id );

								if ( $template == 'survey' && function_exists('pmsurvey_get_survey_dialog') ) {
									pmsurvey_get_survey_dialog( $curr_data );
								}
							?>
						</div>
					</div>
				</div>
			</div>
			<div class="email-template-step3 row">
				<div class="pm-step3-nav col-md-12">
					<a href="javascript:void(0)" id="back-email-template-style" class="pm-prev-step pmicon-left-big">Previous step</a>
					<a href="javascript:void(0)" id="save-email-template" class="pm-next-step pmicon-right-big">Save popup</a>
				</div>
				<div class="email-template-middle col-md-3">
					<?php if ( $popup_entry_anim ) { ?> <input type="hidden" value="<?php echo $popup_entry_anim; ?>" class="email-template-entrance-animation" /> <?php } ?>
					<?php if ( $popup_exit_anim ) { ?> <input type="hidden" value="<?php echo $popup_exit_anim; ?>" class="email-template-exit-animation" /> <?php } ?>
					<?php if ( $popup_location ) { ?> <input type="hidden" value="<?php echo $popup_location; ?>" class="email-template-popup-location" /> <?php } ?>
					<?php if ( $popup_trigger ) { ?> <input type="hidden" value="<?php echo $popup_trigger; ?>" class="email-template-popup-trigger" /> <?php } ?>
					<?php if ( $popup_close_type ) { ?> <input type="hidden" value="<?php echo $popup_close_type; ?>" class="email-template-close-link-type" /> <?php } ?>
					<?php if ( $popup_target_input ) { ?> <input type="hidden" value="<?php echo $popup_target_input; ?>" class="email-template-popup-target-input" /> <?php } ?>
					<?php if ( $popup_target_first_time ) { ?> <input type="hidden" value="<?php echo $popup_target_first_time; ?>" class="email-template-popup-first-time" /> <?php } ?>
					<?php if ( $popup_target_reset ) { ?> <input type="hidden" value="<?php echo $popup_target_reset; ?>" class="email-template-popup-cookie-reset" /> <?php } ?>
					<?php if ( $popup_target_page_visits ) { ?> <input type="hidden" value="<?php echo $popup_target_page_visits; ?>" class="email-template-popup-visited-pages" /> <?php } ?>
					<?php if ( $popup_target_page_after_visit ) { ?> <input type="hidden" value="<?php echo $popup_target_page_after_visit; ?>" class="email-template-popup-after-visited-pages" /> <?php } ?>
					<?php if ( $popup_geo_ip ) { ?> <input type="hidden" value="<?php echo $popup_geo_ip; ?>" class="email-template-popup-geo-ip" /> <?php } ?>
					<?php if ( $popup_geo_country ) { ?> <input type="hidden" value="<?php echo $popup_geo_country; ?>" class="email-template-popup-geo-country" /> <?php } ?>
					<?php if ( $popup_geo_city ) { ?> <input type="hidden" value="<?php echo $popup_geo_city; ?>" class="email-template-popup-geo-city" /> <?php } ?>
					<?php if ( $popup_selector ) { ?> <input type="hidden" value="<?php echo $popup_selector; ?>" class="email-template-popup-selector" /> <?php } ?>
					<?php if ( $popup_closing ) { ?> <input type="hidden" value="<?php echo $popup_closing; ?>" class="email-template-popup-closing" /> <?php } ?>
					<?php if ( $popup_close_source ) { ?> <input type="hidden" value="<?php echo $popup_close_source; ?>" class="email-template-close-link-source" /> <?php } ?>
					<?php if ( $popup_close_position ) { ?> <input type="hidden" value="<?php echo $popup_close_position; ?>" class="email-template-close-link-position" /> <?php } ?>
					<?php if ( $popup_close_width ) { ?> <input type="hidden" value="<?php echo $popup_close_width; ?>" class="email-template-close-image-width" /> <?php } ?>
					<?php if ( $popup_predefined_image ) { ?> <input type="hidden" value="<?php echo $popup_predefined_image; ?>" class="email-template-predefined-img" /> <?php } ?>
					<?php if ( $popup_page_targets ) { ?> <input type="hidden" value="<?php echo $popup_page_targets; ?>" class="email-template-popup-target" /> <?php } ?>
					<?php if ( $popup_page_exclude ) { ?> <input type="hidden" value="<?php echo $popup_page_exclude; ?>" class="email-template-popup-exclude" /> <?php } ?>
					<?php if ( $locker_facebook_like_status ) { ?> <input type="hidden" value="<?php echo $locker_facebook_like_status; ?>" class="email-template-locker-facebook-like-status" /> <?php } ?>
					<?php if ( $locker_facebook_share_status ) { ?> <input type="hidden" value="<?php echo $locker_facebook_share_status; ?>" class="email-template-locker-facebook-share-status" /> <?php } ?>
					<?php if ( $locker_twitter_status ) { ?> <input type="hidden" value="<?php echo $locker_twitter_status; ?>" class="email-template-locker-twitter-status" /> <?php } ?>
					<?php if ( $locker_twitter_follow_status ) { ?> <input type="hidden" value="<?php echo $locker_twitter_follow_status; ?>" class="email-template-locker-twitter-follow-status" /> <?php } ?>
					<?php if ( $locker_gplus_status ) { ?> <input type="hidden" value="<?php echo $locker_gplus_status; ?>" class="email-template-locker-gplus-status" /> <?php } ?>
					<?php if ( $locker_gplus_share_status ) { ?> <input type="hidden" value="<?php echo $locker_gplus_share_status; ?>" class="email-template-locker-gplus-share-status" /> <?php } ?>
					<?php if ( $locker_linkedin_status ) { ?> <input type="hidden" value="<?php echo $locker_linkedin_status; ?>" class="email-template-locker-linkedin-status" /> <?php } ?>
					<?php if ( $locker_pinterest_status ) { ?> <input type="hidden" value="<?php echo $locker_pinterest_status; ?>" class="email-template-locker-pinterest-status" /> <?php } ?>
					<?php if ( $locker_facebook_like_url ) { ?> <input type="hidden" value="<?php echo $locker_facebook_like_url; ?>" class="email-template-locker-facebook-like-url" /> <?php } ?>
					<?php if ( $locker_facebook_like_text ) { ?> <input type="hidden" value="<?php echo $locker_facebook_like_text; ?>" class="email-template-locker-facebook-like-text" /> <?php } ?>
					<?php if ( $locker_facebook_share_url ) { ?> <input type="hidden" value="<?php echo $locker_facebook_share_url; ?>" class="email-template-locker-facebook-share-url" /> <?php } ?>
					<?php if ( $locker_facebook_share_text ) { ?> <input type="hidden" value="<?php echo $locker_facebook_share_text; ?>" class="email-template-locker-facebook-share-text" /> <?php } ?>
					<?php if ( $locker_twitter_url ) { ?> <input type="hidden" value="<?php echo $locker_twitter_url; ?>" class="email-template-locker-twitter-url" /> <?php } ?>
					<?php if ( $locker_twitter_tweet_text ) { ?> <input type="hidden" value="<?php echo $locker_twitter_tweet_text; ?>" class="email-template-locker-twitter-tweet-text" /> <?php } ?>
					<?php if ( $locker_twitter_via ) { ?> <input type="hidden" value="<?php echo $locker_twitter_via; ?>" class="email-template-locker-twitter-via" /> <?php } ?>
					<?php if ( $locker_twitter_text ) { ?> <input type="hidden" value="<?php echo $locker_twitter_text; ?>" class="email-template-locker-twitter-text" /> <?php } ?>
					<?php if ( $locker_twitter_check ) { ?> <input type="hidden" value="<?php echo $locker_twitter_check; ?>" class="email-template-locker-twitter-check" /> <?php } ?>
					<?php if ( $locker_twitter_follow_user ) { ?> <input type="hidden" value="<?php echo $locker_twitter_follow_user; ?>" class="email-template-locker-twitter-follow-user" /> <?php } ?>
					<?php if ( $locker_twitter_follow_check ) { ?> <input type="hidden" value="<?php echo $locker_twitter_follow_check; ?>" class="email-template-locker-twitter-follow-check" /> <?php } ?>
					<?php if ( $locker_twitter_follow_text ) { ?> <input type="hidden" value="<?php echo $locker_twitter_follow_text; ?>" class="email-template-locker-twitter-follow-text" /> <?php } ?>
					<?php if ( $locker_gplus_url ) { ?> <input type="hidden" value="<?php echo $locker_gplus_url; ?>" class="email-template-locker-gplus-url" /> <?php } ?>
					<?php if ( $locker_gplus_text ) { ?> <input type="hidden" value="<?php echo $locker_gplus_text; ?>" class="email-template-locker-gplus-text" /> <?php } ?>
					<?php if ( $locker_gplus_share_url ) { ?> <input type="hidden" value="<?php echo $locker_gplus_share_url; ?>" class="email-template-locker-gplus-share-url" /> <?php } ?>
					<?php if ( $locker_gplus_share_text ) { ?> <input type="hidden" value="<?php echo $locker_gplus_share_text; ?>" class="email-template-locker-gplus-share-text" /> <?php } ?>
					<?php if ( $locker_linkedin_url ) { ?> <input type="hidden" value="<?php echo $locker_linkedin_url; ?>" class="email-template-locker-linkedin-url" /> <?php } ?>
					<?php if ( $locker_linkedin_text ) { ?> <input type="hidden" value="<?php echo $locker_linkedin_text; ?>" class="email-template-locker-linkedin-text" /> <?php } ?>
					<?php if ( $locker_pinterest_text ) { ?> <input type="hidden" value="<?php echo $locker_pinterest_text; ?>" class="email-template-locker-pinterest-text" /> <?php } ?>
					<?php if ( $locker_twitter_key ) { ?> <input type="hidden" value="<?php echo $locker_twitter_key; ?>" class="email-template-locker-twitter-key" /> <?php } ?>
					<?php if ( $locker_twitter_secret ) { ?> <input type="hidden" value="<?php echo $locker_twitter_secret; ?>" class="email-template-locker-twitter-secret" /> <?php } ?>
					<?php if ( $locker_facebook_app_id ) { ?> <input type="hidden" value="<?php echo $locker_facebook_app_id; ?>" class="email-template-locker-facebook-app-id" /> <?php } ?>
					<?php if ( $popup_target_inline_location ) { ?> <input type="hidden" value="<?php echo $popup_target_inline_location; ?>" class="email-template-popup-location-position" /> <?php } ?>
					<?php if ( $popup_height_select ) { ?> <input type="hidden" value="<?php echo $popup_height_select; ?>" class="email-template-popup-height-select" /> <?php } ?>
					<?php if ( $popup_height ) { ?> <input type="hidden" value="<?php echo $popup_height; ?>" class="email-template-popup-height" /> <?php } ?>
					<?php if ( $popup_bg_size ) { ?> <input type="hidden" value="<?php echo $popup_bg_size; ?>" class="email-template-popup-bg-size-select" /> <?php } ?>
					<?php if ( $popup_bg_position ) { ?> <input type="hidden" value="<?php echo $popup_bg_position; ?>" class="email-template-popup-bg-position-select" /> <?php } ?>
					<?php if ( $popup_disabled_mobile ) { ?> <input type="hidden" value="<?php echo $popup_disabled_mobile; ?>" class="email-template-popup-disable-mobile" /> <?php } ?>
					<?php if ( $popup_disabled_mobile_width ) { ?> <input type="hidden" value="<?php echo $popup_disabled_mobile_width; ?>" class="email-template-popup-disable-mobile-width" /> <?php } ?>

					<?php if ( $popup_closing_cond ) { ?> <input type="hidden" value="<?php echo $popup_closing_cond; ?>" class="email-template-popup-closing-cond" /> <?php } ?>
					<?php if ( $popup_closing_timer ) { ?> <input type="hidden" value="<?php echo $popup_closing_timer; ?>" class="email-template-popup-closing-timer" /> <?php } ?>
					<input type="hidden" value="<?php echo $popup_schedule_start; ?>" class="popup-schedule-start">
					<input type="hidden" value="<?php echo $popup_schedule_end; ?>" class="popup-schedule-end">
					<div class="step-3-left-side">
						<div class="pm-card-box">
							<h2 class="col-md-12 header-title">General settings</h2>
							<p class="col-md-12 text-muted font-13 m-b-30">Choose your popup general settings.</p>
							<div class="clearfix"></div>
							<div class="form-group clearfix force-fullwidth">
								<h4>Popup name <span class="required">*</span></h4>
								<input type="text" value="<?php echo $popup_name; ?>" id="email-template-popup-name" class="form-control popup" />
								<span class="input-notice"></span>
							</div>
							<?php if ( isset($_GET['pm-template']) && ( $_GET['pm-template'] != 'messenger' && $_GET['pm-template'] != 'actionbar' && $_GET['pm-template'] != 'tab' && $_GET['pm-template'] != 'ribbon' && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'cookie' && $_GET['pm-template'] != 'locker' ) ) { ?>
							<div class="form-group clearfix">
								<h4>Closing conditions</h4>
								<p class="col-md-12 text-muted font-13">Clicking background will close the popup.</p>
								<input type="checkbox" id="email-template-popup-closing" class="" value="" />
							</div>
							<?php } ?>
						</div>
						<div class="pm-card-box">
							<h2 class="col-md-12 header-title">Popup animations <span class="required">*</span></h2>
							<p class="col-md-12 text-muted font-13 m-b-30">Here you can animate your popup.</p>
							<div class="clearfix"></div>
							<h4>Entry animation effect</h4>
							<div class="form-group clearfix">
								<select id="email-template-entrance-animation">
									<option value="">Choose...</option>
									<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
									<optgroup label="Attention Seekers">
										<option value="bounce">bounce</option>
										<option value="flash">flash</option>
										<option value="pulse">pulse</option>
										<option value="rubberBand">rubberBand</option>
										<option value="shake">shake</option>
										<option value="swing">swing</option>
										<option value="tada">tada</option>
										<option value="wobble">wobble</option>
										<option value="jello">jello</option>
									</optgroup>
									<optgroup label="Bouncing Entrances">
										<option value="bounceIn">bounceIn</option>
										<option value="bounceInDown">bounceInDown</option>
										<option value="bounceInLeft">bounceInLeft</option>
										<option value="bounceInRight">bounceInRight</option>
										<option value="bounceInUp">bounceInUp</option>
									</optgroup>
									<?php } ?>
									<optgroup label="Fading Entrances">
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
										<option value="fadeIn">fadeIn</option>
										<option value="fadeInDown">fadeInDown</option>
										<option value="fadeInDownBig">fadeInDownBig</option>
										<?php } ?>
										<option value="fadeInLeft">fadeInLeft</option>
										<option value="fadeInLeftBig">fadeInLeftBig</option>
										<option value="fadeInRight">fadeInRight</option>
										<option value="fadeInRightBig">fadeInRightBig</option>
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
										<option value="fadeInUp">fadeInUp</option>
										<option value="fadeInUpBig">fadeInUpBig</option>
										<?php } ?>
									</optgroup>
									<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
									<optgroup label="Flippers">
										<option value="flip">flip</option>
										<option value="flipInX">flipInX</option>
										<option value="flipInY">flipInY</option>
									</optgroup>
									<optgroup label="Lightspeed">
										<option value="lightSpeedIn">lightSpeedIn</option>
									</optgroup>
									<optgroup label="Rotating Entrances">
										<option value="rotateIn">rotateIn</option>
										<option value="rotateInDownLeft">rotateInDownLeft</option>
										<option value="rotateInDownRight">rotateInDownRight</option>
										<option value="rotateInUpLeft">rotateInUpLeft</option>
										<option value="rotateInUpRight">rotateInUpRight</option>
									</optgroup>
									<?php } ?>
									<optgroup label="Sliding Entrances">
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
										<option value="slideInUp">slideInUp</option>
										<option value="slideInDown">slideInDown</option>
										<?php } ?>
										<option value="slideInLeft">slideInLeft</option>
										<option value="slideInRight">slideInRight</option>
									</optgroup>
									<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
									<optgroup label="Zoom Entrances">
										<option value="zoomIn">zoomIn</option>
										<option value="zoomInDown">zoomInDown</option>
										<option value="zoomInLeft">zoomInLeft</option>
										<option value="zoomInRight">zoomInRight</option>
										<option value="zoomInUp">zoomInUp</option>
									</optgroup>
									<optgroup label="Specials">
										<option value="hinge">hinge</option>
										<option value="rollIn">rollIn</option>
									</optgroup>
									<?php } ?>
								  </select>
								  <span class="input-notice"></span>
							</div>
							<h4>Exit animation effect</h4>
							<div class="form-group clearfix">
								<select id="email-template-exit-animation">
									<option value="">Choose...</option>
									<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
									<optgroup label="Attention Seekers">
										<option value="bounce">bounce</option>
										<option value="flash">flash</option>
										<option value="pulse">pulse</option>
										<option value="rubberBand">rubberBand</option>
										<option value="shake">shake</option>
										<option value="swing">swing</option>
										<option value="tada">tada</option>
										<option value="wobble">wobble</option>
										<option value="jello">jello</option>
									</optgroup>
									<optgroup label="Bouncing Exits">
										<option value="bounceOut">bounceOut</option>
										<option value="bounceOutDown">bounceOutDown</option>
										<option value="bounceOutLeft">bounceOutLeft</option>
										<option value="bounceOutRight">bounceOutRight</option>
										<option value="bounceOutUp">bounceOutUp</option>
									</optgroup>
									<?php } ?>
									<optgroup label="Fading Exits">
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
										<option value="fadeOut">fadeOut</option>
										<option value="fadeOutDown">fadeOutDown</option>
										<option value="fadeOutDownBig">fadeOutDownBig</option>
										<?php } ?>
										<option value="fadeOutLeft">fadeOutLeft</option>
										<option value="fadeOutLeftBig">fadeOutLeftBig</option>
										<option value="fadeOutRight">fadeOutRight</option>
										<option value="fadeOutRightBig">fadeOutRightBig</option>
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
										<option value="fadeOutUp">fadeOutUp</option>
										<option value="fadeOutUpBig">fadeOutUpBig</option>
										<?php } ?>
									</optgroup>
									<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
									<optgroup label="Flippers">
										<option value="flip">flip</option>
										<option value="flipOutX">flipOutX</option>
										<option value="flipOutY">flipOutY</option>
									</optgroup>
									<optgroup label="Lightspeed">
										<option value="lightSpeedOut">lightSpeedOut</option>
									</optgroup>
									<optgroup label="Rotating Exits">
										<option value="rotateOut">rotateOut</option>
										<option value="rotateOutDownLeft">rotateOutDownLeft</option>
										<option value="rotateOutDownRight">rotateOutDownRight</option>
										<option value="rotateOutUpLeft">rotateOutUpLeft</option>
										<option value="rotateOutUpRight">rotateOutUpRight</option>
									</optgroup>
									<?php } ?>
									<optgroup label="Sliding Exits">
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
										<option value="slideOutUp">slideOutUp</option>
										<option value="slideOutDown">slideOutDown</option>
										<?php } ?>
										<option value="slideOutLeft">slideOutLeft</option>
										<option value="slideOutRight">slideOutRight</option>
									</optgroup>
									<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'tab' ) { ?>
									<optgroup label="Zoom Exits">
										<option value="zoomOut">zoomOut</option>
										<option value="zoomOutDown">zoomOutDown</option>
										<option value="zoomOutLeft">zoomOutLeft</option>
										<option value="zoomOutRight">zoomOutRight</option>
										<option value="zoomOutUp">zoomOutUp</option>
									</optgroup>
									<optgroup label="Specials">
										<option value="hinge">hinge</option>
										<option value="rollOut">rollOut</option>
									</optgroup>
									<?php } ?>
								  </select>
								  <span class="input-notice"></span>
							</div>
						</div>
						<div class="pm-card-box">
							<h2 class="col-md-12 header-title">Popup location <span class="required">*</span></h2>
							<p class="col-md-12 text-muted font-13 m-b-30">Here you can choose where your popup is going to be located.</p>
							<div class="clearfix"></div>
							<div class="form-group clearfix">
								<select id="email-template-popup-location">
									<option value="">Choose...</option>
									<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'messenger' ) { ?>
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'tab' && $_GET['pm-template'] != 'ribbon' && $_GET['pm-template'] != 'actionbar' && $_GET['pm-template'] != 'cookie' ) { ?>
										<option value="modal-popup">Centered modal popup</option>
										<option value="modal-fullscreen">Modal fullscreen</option>
										<?php } ?>
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'actionbar' && $_GET['pm-template'] != 'cookie' ) { ?>
										<option value="sticky-left">Sticky box left</option>
										<option value="sticky-right">Sticky box right</option>
										<?php } ?>
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'tab' && $_GET['pm-template'] != 'ribbon' ) { ?>
										<option value="top-center">Top center</option>
										<?php } ?>
									<?php } ?>
									<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'messenger' && $_GET['pm-template'] != 'actionbar' && $_GET['pm-template'] != 'cookie' ) { ?>
									<option value="top-left">Top left</option>
									<option value="top-right">Top right</option>
									<?php } ?>
									<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' ) { ?>
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'tab' && $_GET['pm-template'] != 'ribbon' && $_GET['pm-template'] != 'messenger' ) { ?>
										<option value="bottom-center">Bottom center</option>
										<?php } ?>
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'actionbar' && $_GET['pm-template'] != 'cookie' ) { ?>
										<option value="bottom-left">Bottom left</option>
										<option value="bottom-right">Bottom right</option>
										<?php } ?>
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] == 'cookie' && $template_style == 'cookie6' ) { ?>
										<option value="bottom-left">Bottom left</option>
										<option value="bottom-right">Bottom right</option>
										<?php } ?>
										<?php if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'tab' && $_GET['pm-template'] != 'ribbon' && $_GET['pm-template'] != 'messenger' && $_GET['pm-template'] != 'actionbar' && $_GET['pm-template'] != 'cookie' ) { ?>
										<option value="full-width">Full width</option>
										<?php } ?>
									<?php } ?>
									<?php
										if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'ribbon' && $_GET['pm-template'] != 'tab' && $_GET['pm-template'] != 'messenger' && $_GET['pm-template'] != 'actionbar' && $_GET['pm-template'] != 'cookie' ) {
											do_action('pm_popup_location');
										}
									?>
								</select>
								<span class="input-notice"></span>
							</div>
						</div>
						<?php if ( !function_exists('pmgeotarget_popup_geotarget_input') ) {
								$countries = array(
									'AF' => 'Afghanistan',
									'AX' => 'Aland Islands',
									'AL' => 'Albania',
									'DZ' => 'Algeria',
									'AS' => 'American Samoa',
									'AD' => 'Andorra',
									'AO' => 'Angola',
									'AI' => 'Anguilla',
									'AQ' => 'Antarctica',
									'AG' => 'Antigua And Barbuda',
									'AR' => 'Argentina',
									'AM' => 'Armenia',
									'AW' => 'Aruba',
									'AU' => 'Australia',
									'AT' => 'Austria',
									'AZ' => 'Azerbaijan',
									'BS' => 'Bahamas',
									'BH' => 'Bahrain',
									'BD' => 'Bangladesh',
									'BB' => 'Barbados',
									'BY' => 'Belarus',
									'BE' => 'Belgium',
									'BZ' => 'Belize',
									'BJ' => 'Benin',
									'BM' => 'Bermuda',
									'BT' => 'Bhutan',
									'BO' => 'Bolivia',
									'BA' => 'Bosnia And Herzegovina',
									'BW' => 'Botswana',
									'BV' => 'Bouvet Island',
									'BR' => 'Brazil',
									'IO' => 'British Indian Ocean Territory',
									'BN' => 'Brunei Darussalam',
									'BG' => 'Bulgaria',
									'BF' => 'Burkina Faso',
									'BI' => 'Burundi',
									'KH' => 'Cambodia',
									'CM' => 'Cameroon',
									'CA' => 'Canada',
									'CV' => 'Cape Verde',
									'KY' => 'Cayman Islands',
									'CF' => 'Central African Republic',
									'TD' => 'Chad',
									'CL' => 'Chile',
									'CN' => 'China',
									'CX' => 'Christmas Island',
									'CC' => 'Cocos (Keeling) Islands',
									'CO' => 'Colombia',
									'KM' => 'Comoros',
									'CG' => 'Congo',
									'CD' => 'Congo, Democratic Republic',
									'CK' => 'Cook Islands',
									'CR' => 'Costa Rica',
									'CI' => 'Cote D\'Ivoire',
									'HR' => 'Croatia',
									'CU' => 'Cuba',
									'CY' => 'Cyprus',
									'CZ' => 'Czech Republic',
									'DK' => 'Denmark',
									'DJ' => 'Djibouti',
									'DM' => 'Dominica',
									'DO' => 'Dominican Republic',
									'EC' => 'Ecuador',
									'EG' => 'Egypt',
									'SV' => 'El Salvador',
									'GQ' => 'Equatorial Guinea',
									'ER' => 'Eritrea',
									'EE' => 'Estonia',
									'ET' => 'Ethiopia',
									'FK' => 'Falkland Islands (Malvinas)',
									'FO' => 'Faroe Islands',
									'FJ' => 'Fiji',
									'FI' => 'Finland',
									'FR' => 'France',
									'GF' => 'French Guiana',
									'PF' => 'French Polynesia',
									'TF' => 'French Southern Territories',
									'GA' => 'Gabon',
									'GM' => 'Gambia',
									'GE' => 'Georgia',
									'DE' => 'Germany',
									'GH' => 'Ghana',
									'GI' => 'Gibraltar',
									'GR' => 'Greece',
									'GL' => 'Greenland',
									'GD' => 'Grenada',
									'GP' => 'Guadeloupe',
									'GU' => 'Guam',
									'GT' => 'Guatemala',
									'GG' => 'Guernsey',
									'GN' => 'Guinea',
									'GW' => 'Guinea-Bissau',
									'GY' => 'Guyana',
									'HT' => 'Haiti',
									'HM' => 'Heard Island & Mcdonald Islands',
									'VA' => 'Holy See (Vatican City State)',
									'HN' => 'Honduras',
									'HK' => 'Hong Kong',
									'HU' => 'Hungary',
									'IS' => 'Iceland',
									'IN' => 'India',
									'ID' => 'Indonesia',
									'IR' => 'Iran, Islamic Republic Of',
									'IQ' => 'Iraq',
									'IE' => 'Ireland',
									'IM' => 'Isle Of Man',
									'IL' => 'Israel',
									'IT' => 'Italy',
									'JM' => 'Jamaica',
									'JP' => 'Japan',
									'JE' => 'Jersey',
									'JO' => 'Jordan',
									'KZ' => 'Kazakhstan',
									'KE' => 'Kenya',
									'KI' => 'Kiribati',
									'KR' => 'Korea',
									'KW' => 'Kuwait',
									'KG' => 'Kyrgyzstan',
									'LA' => 'Lao People\'s Democratic Republic',
									'LV' => 'Latvia',
									'LB' => 'Lebanon',
									'LS' => 'Lesotho',
									'LR' => 'Liberia',
									'LY' => 'Libyan Arab Jamahiriya',
									'LI' => 'Liechtenstein',
									'LT' => 'Lithuania',
									'LU' => 'Luxembourg',
									'MO' => 'Macao',
									'MK' => 'Macedonia',
									'MG' => 'Madagascar',
									'MW' => 'Malawi',
									'MY' => 'Malaysia',
									'MV' => 'Maldives',
									'ML' => 'Mali',
									'MT' => 'Malta',
									'MH' => 'Marshall Islands',
									'MQ' => 'Martinique',
									'MR' => 'Mauritania',
									'MU' => 'Mauritius',
									'YT' => 'Mayotte',
									'MX' => 'Mexico',
									'FM' => 'Micronesia, Federated States Of',
									'MD' => 'Moldova',
									'MC' => 'Monaco',
									'MN' => 'Mongolia',
									'ME' => 'Montenegro',
									'MS' => 'Montserrat',
									'MA' => 'Morocco',
									'MZ' => 'Mozambique',
									'MM' => 'Myanmar',
									'NA' => 'Namibia',
									'NR' => 'Nauru',
									'NP' => 'Nepal',
									'NL' => 'Netherlands',
									'AN' => 'Netherlands Antilles',
									'NC' => 'New Caledonia',
									'NZ' => 'New Zealand',
									'NI' => 'Nicaragua',
									'NE' => 'Niger',
									'NG' => 'Nigeria',
									'NU' => 'Niue',
									'NF' => 'Norfolk Island',
									'MP' => 'Northern Mariana Islands',
									'NO' => 'Norway',
									'OM' => 'Oman',
									'PK' => 'Pakistan',
									'PW' => 'Palau',
									'PS' => 'Palestinian Territory, Occupied',
									'PA' => 'Panama',
									'PG' => 'Papua New Guinea',
									'PY' => 'Paraguay',
									'PE' => 'Peru',
									'PH' => 'Philippines',
									'PN' => 'Pitcairn',
									'PL' => 'Poland',
									'PT' => 'Portugal',
									'PR' => 'Puerto Rico',
									'QA' => 'Qatar',
									'RE' => 'Reunion',
									'RO' => 'Romania',
									'RU' => 'Russian Federation',
									'RW' => 'Rwanda',
									'BL' => 'Saint Barthelemy',
									'SH' => 'Saint Helena',
									'KN' => 'Saint Kitts And Nevis',
									'LC' => 'Saint Lucia',
									'MF' => 'Saint Martin',
									'PM' => 'Saint Pierre And Miquelon',
									'VC' => 'Saint Vincent And Grenadines',
									'WS' => 'Samoa',
									'SM' => 'San Marino',
									'ST' => 'Sao Tome And Principe',
									'SA' => 'Saudi Arabia',
									'SN' => 'Senegal',
									'RS' => 'Serbia',
									'SC' => 'Seychelles',
									'SL' => 'Sierra Leone',
									'SG' => 'Singapore',
									'SK' => 'Slovakia',
									'SI' => 'Slovenia',
									'SB' => 'Solomon Islands',
									'SO' => 'Somalia',
									'ZA' => 'South Africa',
									'GS' => 'South Georgia And Sandwich Isl.',
									'ES' => 'Spain',
									'LK' => 'Sri Lanka',
									'SD' => 'Sudan',
									'SR' => 'Suriname',
									'SJ' => 'Svalbard And Jan Mayen',
									'SZ' => 'Swaziland',
									'SE' => 'Sweden',
									'CH' => 'Switzerland',
									'SY' => 'Syrian Arab Republic',
									'TW' => 'Taiwan',
									'TJ' => 'Tajikistan',
									'TZ' => 'Tanzania',
									'TH' => 'Thailand',
									'TL' => 'Timor-Leste',
									'TG' => 'Togo',
									'TK' => 'Tokelau',
									'TO' => 'Tonga',
									'TT' => 'Trinidad And Tobago',
									'TN' => 'Tunisia',
									'TR' => 'Turkey',
									'TM' => 'Turkmenistan',
									'TC' => 'Turks And Caicos Islands',
									'TV' => 'Tuvalu',
									'UG' => 'Uganda',
									'UA' => 'Ukraine',
									'AE' => 'United Arab Emirates',
									'GB' => 'United Kingdom',
									'US' => 'United States',
									'UM' => 'United States Outlying Islands',
									'UY' => 'Uruguay',
									'UZ' => 'Uzbekistan',
									'VU' => 'Vanuatu',
									'VE' => 'Venezuela',
									'VN' => 'Viet Nam',
									'VG' => 'Virgin Islands, British',
									'VI' => 'Virgin Islands, U.S.',
									'WF' => 'Wallis And Futuna',
									'EH' => 'Western Sahara',
									'YE' => 'Yemen',
									'ZM' => 'Zambia',
									'ZW' => 'Zimbabwe'
								); ?>
							<div class="pm-card-box">
								<h2 class="col-md-12 header-title">Geo targeting</h2>
								<p class="col-md-12 text-muted font-13 m-b-30">Here you can choose some more conditions on what triggers your popup.</p>
								<div class="clearfix"></div>
								<div class="form-group clearfix geotarget feature-locked">
									<h4>IP address/range</h4>
									<p class="col-md-12 text-muted font-13">Enter target IP address or IP range like 127.0.0.1 or 127.0.0.* or 127.0.0.1/60 and separate them by comma.</p>
									<input type="text" id="addon-feature-4" class="form-control" value="" disabled/>
								</div>
								<div class="form-group clearfix geotarget feature-locked">
									<h4>Country</h4>
									<p class="col-md-12 text-muted font-13">Choose target country and the campaign will only show to visitors from that location, you can select multiple countries.</p>
									<select id="addon-feature-5" class="pm-multiselect" multiple disabled>
										<option value="">Choose...</option>';
										<?php foreach ($countries as $country_value) {
											echo '<option value="'.$country_value.'">'.$country_value.'</option>';
										} ?>
									</select>
								</div>
								<div class="form-group clearfix geotarget feature-locked">
									<h4>City</h4>
									<p class="col-md-12 text-muted font-13">Enter target city and the campaign will only show to visitors from that location, separate multiple items with "|".<br>Note that this will use browser geolocation which means that user will be asked to share his location, the campaign will only show if user agrees to share his location and he\'s located in the targeted city.</p>
									<input type="text" id="addon-feature-6" class="form-control" value="" disabled/>
								</div>
							</div>
						<?php } ?>
						<?php do_action('pm_popup_step_bottom'); ?>
					</div>
					<div class="step-3-right-side">
						<div class="pm-card-box popup-triggers">
							<h2 class="col-md-12 header-title">Popup trigger <span class="required">*</span></h2>
							<p class="col-md-12 text-muted font-13 m-b-30">Here you can choose what triggers your popup.</p>
							<div class="clearfix"></div>
							<div class="form-group clearfix">
								<select id="email-template-popup-trigger">
									<option value="" data-trigger-explanation="">Choose...</option>
									<option value="exit-intent" data-trigger-explanation="Your popup will be triggered when user tries to leave your site.">Exit intent</option>
									<option value="timer" data-trigger-explanation="Your popup will be triggered after a specific time has passed.">Timer</option>
									<option value="inactive" data-trigger-explanation="Your popup will be triggered when user becomes inactive.">Inactive</option>
									<option value="after-scroll" data-trigger-explanation="Your popup will be triggered when user starts scrolling.">After scroll</option>
									<?php if ( !function_exists('pmtargeting_popup_triggers') ) { ?>
										<option value="addon-feature-1" disabled>Only on mobile devices</option>
										<option value="addon-feature-2" disabled>Not on mobile devices</option>
										<option value="addon-feature-3" disabled>From a specific referrer</option>
										<option value="addon-feature-4" disabled>Browser</option>
										<option value="addon-feature-5" disabled>Visitor is logged in</option>
										<option value="addon-feature-6" disabled>Visitor is not logged in</option>
										<option value="addon-feature-7" disabled>Visitor has commented before</option>
										<option value="addon-feature-8" disabled>Visitor has never commented before</option>
										<option value="addon-feature-9" disabled>Click trigger</option>
									<?php } ?>
									<?php do_action('pm_popup_triggers'); ?>
								</select>
								<span class="input-notice"></span>
							</div>
							<p class="text-muted font-13 m-t-10 popup-trigger-explanation"></p>
							<div class="form-group trigger-input clearfix">
								<h4>Time in milliseconds</h4>
								<div class="pm-number-field">
									<span class="pm-number-minus">-</span>
									<input type="number" id="email-template-popup-time" value="<?php echo $popup_timer; ?>" />
									<span class="pm-number-plus">+</span>
								</div>
							</div>
							<?php if ( !function_exists('pmtargeting_popup_trigger_input') ) { ?>
								<div class="form-group clearfix targeting feature-locked">
									<h4>First time visit</h4>
									<p class="col-md-12 text-muted font-13">Popup will only be shown to visitors visiting the page for the first time.</p>
									<input type="checkbox" id="addon-feature-2" class="" value="" disabled />
								</div>
								<div class="form-group clearfix targeting feature-locked">
									<h4>Reset "First time visit" after (days)</h4>
									<p class="col-md-12 text-muted font-13">Choose a time period when to reset the first time visitors.</p>
									<input type="number" id="addon-feature-3" class="form-control" value="" disabled />
								</div>
								<div class="form-group clearfix targeting feature-locked">
									<h4>Display on every x visited pages</h4>
									<p class="col-md-12 text-muted font-13">Popup will be displayed on every x visited page.</p>
									<input type="number" id="addon-feature-4" class="form-control" value="" disabled />
								</div>
								<div class="form-group clearfix targeting feature-locked">
									<h4>Display after x visited pages</h4>
									<p class="col-md-12 text-muted font-13">Popup will be displayed after x visited pages.</p>
									<input type="number" id="addon-feature-5" class="form-control" value="" disabled />
								</div>
								<?php if ( $popup_data['0']->popup_type == 'parent' ) { ?>
									<div class="form-group clearfix targeting feature-locked">
										<h4>Display on targeted pages</h4>
										<p class="col-md-12 text-muted font-13">Popup will be displayed on targeted pages.</p>
										<select id="feature-20" class="pm-multiselect" multiple disabled>
											<?php
											foreach (get_pages() as $page_key => $page_value) {
												echo '<option value="'.$page_value->ID.'">'.$page_value->post_title.'</option>';
											} ?>
										</select>
									</div>
									<div class="form-group clearfix targeting feature-locked">
										<h4>Exclude on targeted pages</h4>
										<p class="col-md-12 text-muted font-13">Popup will be displayed on all pages except tha targeted ones.</p>
										<select id="feature-21" class="pm-multiselect" multiple disabled>
											<?php
											foreach (get_pages() as $page_key => $page_value) {
												echo '<option value="'.$page_value->ID.'">'.$page_value->post_title.'</option>';
											} ?>
										</select>
									</div>
								<?php } ?>
							<?php } ?>
							<?php do_action('pm_popup_trigger_input'); ?>
							<?php if ( !isset($_GET['edit_popup']) || $popup_data['0']->popup_type == 'parent' ) {
								do_action('pm_popup_trigger_second_input');
							} ?>
														<?php
								if ( isset($_GET['pm-template']) && $_GET['pm-template'] != 'sidebar' && $_GET['pm-template'] != 'ribbon' && $_GET['pm-template'] != 'tab' && $_GET['pm-template'] != 'messenger' && $_GET['pm-template'] != 'actionbar' && $_GET['pm-template'] != 'cookie' && $_GET['pm-template'] != 'locker' ) {
									do_action('pm_popup_location_position');
								}
							?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}

function pm_shortcode_usage() {
	global $wpdb;
	$popup_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$_GET['popup_id'].'"');
	$inline_locker = false;
	if ( !empty($popup_data) ) {
		$curr_data = json_decode(stripslashes($popup_data['0']->popup_data));
		if ( $curr_data->popup_template == 'locker' && $curr_data->popup_location == 'inline' ) {
			$inline_locker = true;
		}
	}
	?>

	<div class="pm-card-box col-md-6">
		<h2 class="col-md-12 header-title">You have successfully saved your popup!</h2>
		<p class="col-md-12 text-muted font-13 m-b-30">This means that you can now start using your newly created popup!</p>
		<?php if ( $inline_locker ) { ?>
			<p class="col-md-12 font-13 m-b-30">To place your popup into your site just use <b>[popup_manager id="<?php echo $_GET['popup_id']; ?>"]</b>Your hidden content goes here!<b>[/popup_manager]</b> shortcode, edit the page you want to display your popup and put the shortcode there. And that's it, you don't have to do any more configuration or anything, your popup is ready to be used!</p>
		<?php } else { ?>
			<p class="col-md-12 font-13 m-b-30">To place your popup into your site just use <b>[popup_manager id="<?php echo $_GET['popup_id']; ?>"]</b> shortcode, edit the page you want to display your popup and put the shortcode there. And that's it, you don't have to do any more configuration or anything, your popup is ready to be used!</p>
		<?php } ?>
	</div>

	<?php
}

function pm_save_popup() {
	global $wpdb;
	$popup_name = ( isset($_POST['form_name']) ? $_POST['form_name'] : '' );
	$popup_data = ( isset($_POST['form_data']) ? $_POST['form_data'] : '' );
	$popup_action = ( isset($_POST['form_action']) ? $_POST['form_action'] : '' );
	$popup_id = ( isset($_POST['form_id']) ? $_POST['form_id'] : '' );
	$popup_html = ( isset($_POST['popup_html']) ? $_POST['popup_html'] : '' );
	$google_key = ( isset($_POST['google_key']) ? $_POST['google_key'] : '' );

	if ( $google_key != '' ) {
		update_option( 'popup_manager_gmap_key', $google_key );
	}

	// if ( function_exists('frm_forms_autoloader') ) {
	// 	$plugin_options = (array)get_option('frm_options');
	// 	$plugin_options['load_style'] = 'none';
	// 	update_option('frm_options', $plugin_options);
	// }

	if ( $popup_action == 'save' ) {
		if ( $wpdb->query('INSERT INTO '.$wpdb->prefix.'popup_manager (`name`, `popup_data`, `popup_html`) VALUES ("'.$popup_name.'", "'.$popup_data.'", "'.$popup_html.'")') === false ) {
			echo 'failed';
		} else {
			echo $wpdb->insert_id;
		}
	} else if ( $popup_action == 'update' ) {
		if ( $wpdb->query('UPDATE '.$wpdb->prefix.'popup_manager SET name="'.$popup_name.'", popup_data="'.$popup_data.'", popup_html="'.$popup_html.'" WHERE ID="'.$popup_id.'"') === false ) {
			echo 'failed';
		} else {
			echo 'updated';
		}
	}


	die(0);
}
add_action( 'wp_ajax_nopriv_pm_save_data', 'pm_save_popup' );
add_action( 'wp_ajax_pm_save_data', 'pm_save_popup' );

function pm_netMatch($network, $ip) {
    $network=trim($network);
    $orig_network = $network;
    $ip = trim($ip);
    if ($ip == $network) {
        return TRUE;
    }
    $network = str_replace(' ', '', $network);
    if (strpos($network, '*') !== FALSE) {
        if (strpos($network, '/') !== FALSE) {
            $asParts = explode('/', $network);
            $network = @ $asParts[0];
        }
        $nCount = substr_count($network, '*');
        $network = str_replace('*', '0', $network);
        if ($nCount == 1) {
            $network .= '/24';
        } else if ($nCount == 2) {
            $network .= '/16';
        } else if ($nCount == 3) {
            $network .= '/8';
        } else if ($nCount > 3) {
            return TRUE; // if *.*.*.*, then all, so matched
        }
    }

    $d = strpos($network, '-');
    if ($d === FALSE) {
        $ip_arr = explode('/', $network);
        if (!preg_match("@\d*\.\d*\.\d*\.\d*@", $ip_arr[0], $matches)){
            $ip_arr[0].=".0";    // Alternate form 194.1.4/24
        }
        $network_long = ip2long($ip_arr[0]);
        $x = ip2long($ip_arr[1]);
        $mask = long2ip($x) == $ip_arr[1] ? $x : (0xffffffff << (32 - $ip_arr[1]));
        $ip_long = ip2long($ip);
        return ($ip_long & $mask) == ($network_long & $mask);
    } else {
        $from = trim(ip2long(substr($network, 0, $d)));
        $to = trim(ip2long(substr($network, $d+1)));
        $ip = ip2long($ip);
        return ($ip>=$from and $ip<=$to);
    }
}

function pm_popup_manager_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'id'   => '',
		'pm_demo' => 'false'
	), $atts ) );
	$output = '';
	global $wpdb;
	$popup = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$id.'"');

	if ( !empty($popup) && $popup['0']->popup_type == 'child' ) {
		return;
	}

	if ( function_exists('pm_analytics_html') ) {
		$popup_childs = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE popup_parent="'.$id.'"');
		if ( !empty($popup_childs) ) {
			$ab_splits = array_merge($popup, $popup_childs);
			$random_popup = array_rand($ab_splits);

			$popup = array( $ab_splits[$random_popup] );
		}
	}

	if ( !empty($popup) ) {
		global $post;

		$popup_data = json_decode(stripslashes($popup['0']->popup_data));
		$popup_status = (array)$popup_data;
		
		if ( isset($popup_status['popup_status']) && $popup_status['popup_status'] == 'paused' ) {
			return;
		}

		if ( isset($popup_status['popup_schedule']) ) {
			$start_date_arr = explode('/', $popup_status['popup_schedule']->start);
			if ( intval($start_date_arr['0']) > 12 ) {
				$parsed_start_date = strtotime(str_replace('/', '-', $popup_status['popup_schedule']->start));
			} else {
				$parsed_start_date = strtotime($popup_status['popup_schedule']->start);
			}

			$end_date_arr = explode('/', $popup_status['popup_schedule']->end);
			if ( intval($end_date_arr['0']) > 12 ) {
				$parsed_end_date = strtotime(str_replace('/', '-', $popup_status['popup_schedule']->end));
			} else {
				$parsed_end_date = strtotime($popup_status['popup_schedule']->end);
			}

			if ( ( time() >= $parsed_start_date ) && ( time() <= $parsed_end_date ) ) {
				// Show popup
			} else {
				return;
			}
		}

		$is_first_time = '';
		if ( isset($popup_data->popup_target_first_time) && $popup_data->popup_target_first_time == 'true' && isset($_COOKIE['pm-'.$popup['0']->ID.'-first-time']) ) {
			$is_first_time = 'opened';
		}

		$page_visits = 'true';
		$reset_cookie = '';
		if ( function_exists('pmtargeting_page_visit_cookie') ) {
			$popup_page_visits = (isset($popup_data->popup_target_page_visits)?$popup_data->popup_target_page_visits:'');
			$popup_after_visit = (isset($popup_data->popup_target_page_after_visit)?$popup_data->popup_target_page_after_visit:'');

			if ( $popup_page_visits != '' || $popup_after_visit != '' ) {
				$page_visits = 'false';
			}

			if ( $popup_page_visits != '' && isset($_COOKIE["pm-".$popup['0']->ID."-page-visit"]) && ( intval( $_COOKIE["pm-".$popup['0']->ID."-page-visit"] ) % intval( $popup_page_visits ) == 0 ) ) {
				$page_visits = 'true';
			}

			if ( $popup_after_visit != '' && isset($_COOKIE["pm-".$popup['0']->ID."-after-page-visit"]) && ( intval( $_COOKIE["pm-".$popup['0']->ID."-after-page-visit"] ) > intval( $popup_after_visit ) ) ) {
				$page_visits = 'true';
				$reset_cookie = 'jQuery(document).ready(function($) { $.cookie("pm-'.$popup['0']->ID.'-after-page-visit", "-999999", { path: "/" }); });';
			}
		}

		// Check user IP address/range
		if ( isset($popup_data->popup_geo_ip) && $popup_data->popup_geo_ip != '' ) {
			$geo_ips = explode(',', $popup_data->popup_geo_ip);
			foreach ($geo_ips as $ip_value) {
				if ( preg_match('/^[0-9.*\/]*$/', $ip_value) ) {
					if ( isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '::1' && !pm_netMatch( $ip_value, $_SERVER['REMOTE_ADDR'] ) ) {
						$page_visits = 'false';
					} else {
						$page_visits = 'true';
						break;
					}
				}
			}
		}

		// Check user Country
		if ( isset($popup_data->popup_geo_country) && $popup_data->popup_geo_country != '' && isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] != '::1' ) {
			$visitor_country = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$_SERVER['REMOTE_ADDR']));
			$countries = explode('|', $popup_data->popup_geo_country);
			if ( !empty($countries) ) {
				foreach ($countries as $country_value) {
					if ( strpos(strtolower($country_value), strtolower($visitor_country['geoplugin_countryName'])) !== false ) {
						$page_visits = 'true';
						break;
					} else {
						$page_visits = 'false';
					}
				}
			}
		}

		if ( isset($_COOKIE['pm-locker-'.$popup['0']->ID]) && $_COOKIE['pm-locker-'.$popup['0']->ID] == 'true' ) {
			$page_visits = 'false';
		}

		if ( isset($_COOKIE['pm-survey-'.$popup['0']->ID]) && $_COOKIE['pm-survey-'.$popup['0']->ID] == 'true' ) {
			$page_visits = 'false';
		}

		if ( isset($_COOKIE['pm-'.$popup['0']->ID.'-verification']) && $_COOKIE['pm-'.$popup['0']->ID.'-verification'] == 'true' ) {
			$page_visits = 'false';
		}

		$geolocation = '';
		if ( isset($popup_data->popup_geo_city) && $popup_data->popup_geo_city != '' ) {
			$geolocation = '
			jQuery(document).ready(function($) {
				if ( navigator.geolocation ) {
					window.pm_popup_visits = false;
					function geocode_callback( status ) {
						if ( status == "true" ) {
							window.pm_popup_visits = true;
						}
					}
					function getLocationData(position, latitude, longitude) {
						geocoder = new google.maps.Geocoder();
						if( geocoder ) {
							geocoder.geocode({ "address": position }, function (results, status) {
								if( status == google.maps.GeocoderStatus.OK && typeof results["0"].geometry.bounds != "undefined" ) {
									if ( results["0"].geometry.bounds.contains(new google.maps.LatLng(latitude, longitude)) ) {
										geocode_callback("true");
									} else {
										geocode_callback("false");
									}
								}
							});
						}
					}
					navigator.geolocation.getCurrentPosition(function(position) {
						var latitude = position.coords.latitude;
						var longitude = position.coords.longitude;';
						$geo_cities = explode('|', $popup_data->popup_geo_city);
						if ( !empty($geo_cities) ) {
							$geolocation .= 'var geo_addresses = '.json_encode($geo_cities);
							$geolocation .= '
							jQuery.each(geo_addresses, function(index, value) {
								getLocationData(value, latitude, longitude);
							});';
						}
					$geolocation .= '
					}, function(error) {
						window.pm_popup_visits = false;
					});
				} else {
					window.pm_popup_visits = false;
				}
			});';
		}

		$output .= '
		<div class="email-main-wrapper pm-location-' . $popup_data->popup_location . ' pm-trigger-' . $popup_data->popup_trigger . ' pm-entry-' . $popup_data->popup_entry_animation . ' pm-exit-' . $popup_data->popup_exit_animation . ' pm-popup-hidden '.$is_first_time	.' pm-'.$popup_data->popup_template.'-template" data-popupid="'.$id.'">
			<div class="email-popup-preview-box-overlay"></div>
			<input type="hidden" id="pm-popup-id" value="'.$id.'" >';
			if ( $popup_data->popup_template == 'locker' ) {
				$output .= "
					<div id='fb-root'></div>
					<script>(function(d, s, id) {
					  var js, fjs = d.getElementsByTagName(s)[0];
					  if (d.getElementById(id)) return;
					  js = d.createElement(s); js.id = id;
					  js.src = '//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.6&appId=376094672578810';
					  fjs.parentNode.insertBefore(js, fjs);
					}(document, 'script', 'facebook-jssdk'));</script>";
				$output .= '<script src="https://apis.google.com/js/platform.js" async defer></script>';
				$output .= '<script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>';
				$output .= '<script type="text/javascript" src="//platform.twitter.com/widgets.js"></script>';
				
				$twitter_custom_url = '';
				if ( $popup_data->locker_twitter_url != '' ) {
					$twitter_custom_url = $popup_data->locker_twitter_url;
				} else {
					$twitter_custom_url = get_permalink();
				}
				$twitter_via = '';
				if ( $popup_data->locker_twitter_via ) {
					$twitter_via = $popup_data->locker_twitter_via;
				}
				$twitter_text = 'Check out this great content at';
				if ( $popup_data->locker_twitter_tweet_text ) {
					$twitter_text = $popup_data->locker_twitter_tweet_text;
				}
				if ( $popup_data->locker_gplus_share_url ) {
					$gplus_share_url = $popup_data->locker_gplus_share_url;
				} else {
					$gplus_share_url = get_permalink();
				}
				$output .= '
				<script type="text/javascript">
					jQuery(document).ready(function($) {
						FB.init({
					      appId: \''.$popup_data->locker_facebook_app_id.'\',
					      version: \'v2.6\'
					    });

						FB.Event.subscribe(\'edge.create\', function(response) {
							jQuery.cookie(\'pm-locker-\'+jQuery(\'#pm-popup-id\').val(), \'true\', { path: \'/\' });
							var popup_classes = jQuery(\'.email-main-wrapper\').attr(\'class\').split(\' \');
							jQuery(".email-popup-preview").removeClass(popup_classes[\'3\'].replace(\'pm-entry-\', \'\'));
							jQuery(".email-popup-preview").addClass(popup_classes[\'4\'].replace(\'pm-exit-\', \'\'));
							setTimeout(function() {
								jQuery(".email-main-wrapper").addClass("pm-popup-hidden-after");
								jQuery(".email-main-wrapper.pm-location-inline").next().attr("style", "");
							}, 800);
						});

						window.onmessage = function (mes) {
							var s = mes.data.replace("!_", "");
							if ( s.charAt(0) == "_" ) {
								return;
							}
							s = $.parseJSON(s);
							if (s.s.indexOf("_g_restyleMe") != -1 && Object.keys(s.a[0]).length == 1 && s.a[0].hasOwnProperty("height")) {
								jQuery.cookie("pm-locker-"+jQuery("#pm-popup-id").val(), "true", { path: "/" });
								var popup_classes = jQuery(".email-main-wrapper").attr("class").split(" ");
								jQuery(".email-popup-preview").removeClass(popup_classes["3"].replace("pm-entry-", ""));
								jQuery(".email-popup-preview").addClass(popup_classes["4"].replace("pm-exit-", ""));
								setTimeout(function() {
									jQuery(".email-main-wrapper").addClass("pm-popup-hidden-after");
									jQuery(".email-main-wrapper.pm-location-inline").next().attr("style", "");
								}, 800);
							}
						}

						jQuery(document).on("click", ".facebook-share-overlay", function() {
							FB.ui({
								display: "popup",
								method:  "share",
								href:    "'.$gplus_share_url.'",
							}, function(response) {
								if (response && response.post_id) {
									jQuery.cookie("pm-locker-"+jQuery("#pm-popup-id").val(), "true", { path: "/" });
									var popup_classes = jQuery(".email-main-wrapper").attr("class").split(" ");
									jQuery(".email-popup-preview").removeClass(popup_classes["3"].replace("pm-entry-", ""));
									jQuery(".email-popup-preview").addClass(popup_classes["4"].replace("pm-exit-", ""));
									setTimeout(function() {
										jQuery(".email-main-wrapper").addClass("pm-popup-hidden-after");
										jQuery(".email-main-wrapper.pm-location-inline").next().attr("style", "");
									}, 800);
								}
							});
						});
					});

					jQuery(window).load(function() {
						gapi.plus.render("share-googleplus", {
							action: "share",
							annotation: "none",
							href: "'.$gplus_share_url.'"
						})
					});
				</script>';
			}
			$output .= '
			<style type="text/css">';
					foreach ($popup_data->popup_styles as $style_key => $style_value) {
						$output .= '.email-main-wrapper[data-popupid="'.$id.'"] '.$style_key . '{'.$style_value.'}';
					}
		$output .= '</style>';
					if ( isset($popup_data->popup_template_style) ) {
						$output .= pm_get_popup_style_json($popup_data->popup_template_style);
					}
					if ( function_exists('pmtargeting_popup_trigger_cookie') && isset($popup_data->popup_target_first_time) && $popup_data->popup_target_first_time == 'true' ) {
						$output .= pmtargeting_popup_trigger_cookie( $popup['0']->ID, $popup_data->popup_target_first_time, $popup_data->popup_target_reset );
					}
					if ( function_exists('pmtargeting_page_visit_cookie') && $popup_page_visits != '' ) {
						$output .= pmtargeting_page_visit_cookie( $popup['0']->ID );
					}
					if ( function_exists('pmtargeting_page_after_visit_cookie') && $popup_after_visit != '' ) {
						$output .= pmtargeting_page_after_visit_cookie( $popup['0']->ID );
					}
					if ( function_exists('pmcookie_agree_cookie') && $popup_data->popup_template == 'cookie' ) {
						$output .= pmcookie_agree_cookie( $popup['0']->ID );
					}
					if ( function_exists('pmanalytics_shortcode_info') ) {
						$output .= pmanalytics_shortcode_info( $popup['0']->ID );
					}
					if ( function_exists('pmtemplate_closing_cond') && isset($popup_data->popup_closing_cond) && ( $popup_data->popup_closing_cond == 'timer-show' ||  $popup_data->popup_closing_cond == 'timer-close' ) ) {
						$output .= pmtemplate_closing_cond( $popup['0']->ID, $popup_data->popup_closing_cond, $popup_data->popup_closing_timer );
					}
					$output .= '
						<script type="text/javascript">
							window.pm_popup_visits = '.$page_visits.';'.$reset_cookie.$geolocation.'
							jQuery(document).ready(function($) {
								if ( typeof jQuery(".email-popup-preview").attr("data-width") == "undefined" ) {
									jQuery(".email-popup-preview").attr("data-width", jQuery(".email-popup-preview").outerWidth() );
								}
								if ( jQuery(window).width() < jQuery(".email-popup-preview").css("width").replace("px", "") ) {
									if ( jQuery(".email-popup-preview").hasClass("modal-fullscreen") || jQuery(".email-popup-preview").hasClass("full-width") ) {
										jQuery(".email-popup-preview").css("width", jQuery(this).outerWidth());
									} else {
										jQuery(".email-popup-preview").css("width", jQuery(window).outerWidth()*0.9);
									}
								}';
								if ( isset($popup_data->popup_disabled_mobile) && $popup_data->popup_disabled_mobile == 'true' ) {
									$output .= 'if ( jQuery(window).width() < '.$popup_data->popup_disabled_mobile_width.' ) {
										window.pm_popup_visits = false;
									}';
								}
								$output .= '
								jQuery( window ).resize( function() {
									if ( jQuery(window).width() < jQuery(".email-popup-preview").attr("data-width").replace("px", "") ) {
										if ( jQuery(".email-popup-preview").hasClass("modal-fullscreen") || jQuery(".email-popup-preview").hasClass("full-width") ) {
											jQuery(".email-popup-preview").css("width", jQuery(this).outerWidth());
										} else {
											jQuery(".email-popup-preview").css("width", jQuery(window).outerWidth()*0.9);
										}
									} else {
										jQuery(".email-popup-preview").css("width", jQuery(".email-popup-preview").attr("data-width"));
									}
								});
							});
						</script>';
					if ( $popup_data->popup_trigger == 'timer' ) {
						$output .= '
						<script type="text/javascript">
							setTimeout(function() {
								if ( !jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").hasClass("opened") && window.pm_popup_visits ) {
									if ( !jQuery(".pm-tab-template").length ) {
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").removeClass("pm-popup-hidden");
										jQuery(".email-popup-preview").addClass("animated '.$popup_data->popup_entry_animation.'");
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").addClass("opened");
									} else {
										var popup_width = jQuery(".email-popup-preview").width() - jQuery(".form-input-wrapper.tab-rotated").height();
										if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").is(".pm-location-top-right, .pm-location-sticky-right, .pm-location-bottom-right") ) {
											jQuery(".email-popup-preview-wrapper").css("right", "-"+popup_width+"px");
										} else if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").is(".pm-location-top-left, .pm-location-sticky-left, .pm-location-bottom-left") ) {
											jQuery(".email-popup-preview-wrapper").css("left", "-"+popup_width+"px");
										}
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").css("visibility", "visible").addClass("pm-popup-hidden");
									}
								}
							}, '.$popup_data->popup_timer.');';
					} else if ( $popup_data->popup_trigger == 'inactive' ) {
						$output .= '
						<script type="text/javascript">
							var idleTime = 0;
							var $idleInterval;
							jQuery(document).ready(function () {
								$idleInterval = setInterval(pm_timerIncrement, 1000);

								jQuery(this).mousemove(function (e) {
									idleTime = 0;
								});
								jQuery(this).keypress(function (e) {
									idleTime = 0;
								});
							});

							function pm_timerIncrement() {
								idleTime = idleTime + 1000;
								if (idleTime > '.$popup_data->popup_timer.' && !jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").hasClass("opened") && window.pm_popup_visits ) {
									if ( !jQuery(".pm-tab-template").length ) {
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").removeClass("pm-popup-hidden");
										jQuery(".email-popup-preview").addClass("animated '.$popup_data->popup_entry_animation.'");
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").addClass("opened");
									} else {
										var popup_width = jQuery(".email-popup-preview").width() - jQuery(".form-input-wrapper.tab-rotated").height();
										if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").is(".pm-location-top-right, .pm-location-sticky-right, .pm-location-bottom-right") ) {
											jQuery(".email-popup-preview-wrapper").css("right", "-"+popup_width+"px");
										} else if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").is(".pm-location-top-left, .pm-location-sticky-left, .pm-location-bottom-left") ) {
											jQuery(".email-popup-preview-wrapper").css("left", "-"+popup_width+"px");
										}
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").css("visibility", "visible").addClass("pm-popup-hidden");
									}
									clearInterval($idleInterval);
								}
							}';
					} else if ( $popup_data->popup_trigger == 'after-scroll' ) {
						$output .= '
						<script type="text/javascript">
							jQuery(window).scroll(function() {
								if ( !jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").hasClass("opened") && window.pm_popup_visits ) {
									if ( !jQuery(".pm-tab-template").length ) {
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").removeClass("pm-popup-hidden");
										jQuery(".email-popup-preview").addClass("animated '.$popup_data->popup_entry_animation.'");
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").addClass("opened");
									} else {
										var popup_width = jQuery(".email-popup-preview").width() - jQuery(".form-input-wrapper.tab-rotated").height();
										if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").is(".pm-location-top-right, .pm-location-sticky-right, .pm-location-bottom-right") ) {
											jQuery(".email-popup-preview-wrapper").css("right", "-"+popup_width+"px");
										} else if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").is(".pm-location-top-left, .pm-location-sticky-left, .pm-location-bottom-left") ) {
											jQuery(".email-popup-preview-wrapper").css("left", "-"+popup_width+"px");
										}
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").css("visibility", "visible").addClass("pm-popup-hidden");
									}
								}
								
							});';
					} else if ( $popup_data->popup_trigger == 'exit-intent' ) {
						$output .= '
						<script type="text/javascript">
							jQuery(document).on("mouseleave", function(e) {
								if ( !jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").hasClass("opened") && window.pm_popup_visits ) {
									if ( !jQuery(".pm-tab-template").length ) {
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").removeClass("pm-popup-hidden");
										jQuery(".email-popup-preview").addClass("animated '.$popup_data->popup_entry_animation.'");
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").addClass("opened");
									} else {
										var popup_width = jQuery(".email-popup-preview").width() - jQuery(".form-input-wrapper.tab-rotated").height();
										if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").is(".pm-location-top-right, .pm-location-sticky-right, .pm-location-bottom-right") ) {
											jQuery(".email-popup-preview-wrapper").css("right", "-"+popup_width+"px");
										} else if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").is(".pm-location-top-left, .pm-location-sticky-left, .pm-location-bottom-left") ) {
											jQuery(".email-popup-preview-wrapper").css("left", "-"+popup_width+"px");
										}
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").css("visibility", "visible").addClass("pm-popup-hidden");
									}
								}
							});';
					} else if ( $popup_data->popup_trigger == '' ) {
						$output .= '<script type="text/javascript">';
					}
					if ( function_exists('pmtargeting_popup_trigger_script') ) {
						$popup_target_input = (isset($popup_data->popup_target_input)?$popup_data->popup_target_input:'');
						$output .= pmtargeting_popup_trigger_script( $popup_data->popup_trigger, $popup_data->popup_entry_animation, $popup_target_input, $id );
					}
					if ( $popup_data->popup_closing == 'true' ) {
						$popup_closing_param = ', .email-popup-preview-box-overlay';
					} else {
						$popup_closing_param = '';
					}
							$output .= '
							jQuery(document).on("click", ".email-popup-close, .pm-verification-accept'.$popup_closing_param.'", function() {
								if ( jQuery(this).hasClass("pm-verification-accept") && jQuery(this).attr("data-custom-url") != undefined && jQuery(this).attr("data-custom-url") != "" ) {
									window.open(jQuery(this).attr("data-custom-url"), "_blank")
								}
								var all_classes = jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").attr("class").split(" ");
								var exit_animation = all_classes["4"].replace("pm-exit-", "");
								var entry_animation = all_classes["3"].replace("pm-entry-", "");
								jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"] .email-popup-preview").removeClass(entry_animation);
								jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"] .email-popup-preview").addClass(exit_animation);';
								if ( $popup_data->popup_template != 'sidebar' ) {
									$output .= '
									setTimeout(function() {
										jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").addClass("pm-popup-hidden-after");
										if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").hasClass("pm-trigger-click") ) {
											jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").removeClass("opened");
											jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"] [data-exit]").each(function() {
												jQuery(this).removeClass(jQuery(this).attr("data-exit"));
											});
											var class_change = setInterval(function() {
												if ( jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"]").hasClass("opened") ) {
													clearInterval(class_change);
													
													jQuery(".email-main-wrapper[data-popupid=\"'.$popup['0']->ID.'\"] [data-entry]").each(function() {
														jQuery(this).addClass(jQuery(this).attr("data-entry"));
													});
												}
											}, 250);
										}
									}, 1000);';
								}
								$output .= '
							});
						</script>';
			$output .= '<div class="email-popup-preview-wrapper pm-'.$popup_data->popup_template.'-template pm-'.$popup_data->popup_template_style.'-style">';
				if ( $popup_data->popup_template == 'contact' ) {	
					$output .= str_replace('wp-admin/admin-ajax.php', $post->post_name.'/', $popup['0']->popup_html);
				} else {
					if ( $popup_data->popup_template == 'locker' && function_exists('pmlocker_prepare_buttons') ) {
						$popup['0']->popup_html = pmlocker_prepare_buttons( $popup['0'] );						
					}
					$output .= $popup['0']->popup_html;
				}
				if ( isset($popup_data->popup_thankyou) && $popup_data->popup_thankyou != '' ) {
					$output .= '<div id="pmtus" style="display: none;">'.$popup_data->popup_thankyou.'</div>';
				}
			$output .= '</div>';
		$output .= '</div>';
	}

	if ( $pm_demo == 'false' ) {
		if ( $popup_data->popup_location != 'inline' ) {
			global $pm_shortcode_content;
			$pm_shortcode_content .= $output;
			add_action('wp_footer', 'pm_add_to_footer', 25);
		} else {
			if ( $content != '' && $popup_data->popup_template == 'locker' ) {
				$hidden_content = '<p style="display: none !important;">'.$content.'</p>';
				return $output.$hidden_content;
			} else {
				return $output;
			}
		}
	} else if ( $pm_demo == 'true' ) {
		return $output;
	}

	return;
}
add_shortcode('popup_manager','pm_popup_manager_shortcode');

function pm_add_to_footer() {
	global $pm_shortcode_content;
	echo $pm_shortcode_content;

	$page_load_time = timer_stop();
	$pm_page_load_times = get_option('pm_page_load_times', array());
	$todays_date = date('d-m-Y');
	if ( !isset( $pm_page_load_times[$todays_date] ) ) {
		$pm_page_load_times[$todays_date] = array( $page_load_time );
	} else {
		$pm_page_load_times[$todays_date][] = $page_load_time;
	}
	update_option('pm_page_load_times', $pm_page_load_times);
}

function pm_content_fonts( $content ) {
	if ( has_shortcode( $content, 'popup_manager') ) {
		global $wpdb, $post;

		$pattern = get_shortcode_regex();
		preg_match('/'.$pattern.'/s', $content, $matches);
		if (is_array($matches) && $matches[2] == 'popup_manager') {
			$shortcode = $matches[0];
			preg_match_all('!\d+!', $shortcode, $pmid);
			if ( isset($pmid['0']['0']) ) {
				$popup_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$pmid['0']['0'].'"');
				if ( !empty($popup_data) ) {
					$curr_data = json_decode(stripslashes($popup_data['0']->popup_data), true);

					$font_url = '';
					if ( isset($curr_data['popup_fonts']) && $curr_data['popup_fonts'] != '' ) {
						$font_url = "<link href='https://fonts.googleapis.com/css?family=";
						$font_arr = explode('|', $curr_data['popup_fonts']);
						foreach ($font_arr as $font_value) {
							$font_value = str_replace(' ', '+', $font_value);
							$font_url .= $font_value . ':300,400,700|';
						}
						$font_url = rtrim($font_url, '|');
						$font_url .= "' rel='stylesheet' type='text/css'>";
					}
					return $font_url.$content;
				}
			}
		}
	}

	return $content;
}
add_filter( 'the_content', 'pm_content_fonts' );

function pm_get_template_preview( $template, $style, $popup_id ) {
	global $wpdb;
	if ( !$popup_id ) {
		$template_data = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'popup_manager_templates WHERE template="' . $template . '" AND template_style="' . $style . '"');
	} else {
		$template_data = $wpdb->get_results('SELECT * FROM ' . $wpdb->prefix . 'popup_manager WHERE ID="' . $popup_id . '"');
	}

	if ( !empty($template_data) ) {
		echo $template_data['0']->popup_html;
	}
}

function pm_get_close_image() {
	if ( isset($_GET['pm-style']) ) {
		$style = $_GET['pm-style'];
	} else {
		$style = $_GET['pm-template'];
	}
	if ( $style == 'subtle' ) {
		return PM_PLUGIN_URI.'admin/images/close-images/close-1.png';
	} else if ( $style == 'image' || $style == 'minimalistic' || $style == 'dark' || $style == 'plain' || $style == 'party' || $style == 'paris' || $style == 'universe' || $style == 'video' || $style == 'likebox' || $style == 'style1' || $style == 'actionbar1' ) {
		return PM_PLUGIN_URI.'admin/images/close-white.png';
	} else {
		return PM_PLUGIN_URI.'admin/images/close.png';
	}
}

function pm_admin_rating_notice() {
	$user = wp_get_current_user();
	if ( get_option('pm_rating_notice') != 'hide' && time() - get_option('pm_rating_notice') > 432000 ) { ?>
		<div class="pm-rating-notice">
			<span class="pm-notice-left">
				<img src="<?php echo PM_PLUGIN_URI; ?>admin/images/logo-square.png" alt="">
			</span>
			<div class="pm-notice-center">
				<p>Hi there, <?php echo $user->data->display_name; ?>, we noticed that you've been using our Popup manager plugin for a while now.</p>
				<p>We spent many hours developing this free plugin for you and we would appriciate if you supported us by rating our plugin!</p>
			</div>
			<div class="pm-notice-right">
				<a href="https://wordpress.org/support/view/plugin-reviews/popup-manager?rate=5#postform" class="button button-primary button-large pm-rating-rate">Rate at WordPress</a>
				<a href="javascript:void(0)" class="button button-large preview pm-rating-dismiss">No, thanks</a>
			</div>
			<div class="clearfix"></div>
		</div>
	<?php }
}
add_action( 'admin_notices', 'pm_admin_rating_notice' );

function pm_dismiss_rating_notice() {
	update_option('pm_rating_notice', 'hide');

	die(0);
}
add_action( 'wp_ajax_nopriv_pm_dismiss_notice', 'pm_dismiss_rating_notice' );
add_action( 'wp_ajax_pm_dismiss_notice', 'pm_dismiss_rating_notice' );

function pm_clone_popup_data() {
	global $wpdb;
	$popup_id = ( isset($_POST['popup_id']) ? $_POST['popup_id'] : '' );

	$clone_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$popup_id.'"');
	$clone_sucess = false;

	if ( !empty($clone_data) ) {
		$cloned_name = $clone_data['0']->name . ' Cloned';
		$cloned_data = $clone_data['0']->popup_data;
		$cloned_html = $clone_data['0']->popup_html;

		$clone_data_insert = $wpdb->query('INSERT INTO '.$wpdb->prefix.'popup_manager (name, popup_data, popup_html) VALUES ("'.$cloned_name.'", "'.str_replace('"', '\"', $cloned_data ).'", "'.str_replace('"', '\"', $cloned_html ).'")');

		if ( $clone_data_insert ) {
			$clone_sucess = true;
		}
	}

	if ( $clone_sucess ) {
		echo $wpdb->insert_id;
	} else {
		echo 'failed';
	}

	die(0);
}
add_action( 'wp_ajax_nopriv_pm_clone_popup', 'pm_clone_popup_data' );
add_action( 'wp_ajax_pm_clone_popup', 'pm_clone_popup_data' );

function pm_speed_notice_func() {
	$pm_page_load_times = array_reverse(get_option('pm_page_load_times', array()));
	unset($pm_page_load_times[key($pm_page_load_times)]);
	$notice_status = get_option('pm_page_load_notice_status', 'show');

	$num_of_days = 7; // For how many days show load times
	if ( count($pm_page_load_times) >= $num_of_days && $notice_status == 'show' ) {
		$load_count = 0;
		$load_sum = 0;
		$days = 1;
		foreach ( $pm_page_load_times as $day_load_times ) {
			$load_sum = array_sum($day_load_times);
			$load_count = count($day_load_times);

			if ( $days == $num_of_days ) {
				break;
			}

			$days++;
		}
		$load_average = $load_sum / $load_count;
	 	if ( $load_average > 2 ) {
			?>
			<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				jQuery(document).on('click', '.pm-load-notice .notice-dismiss', function() {
					jQuery.ajax({
						type: 'POST',
						url: ajaxurl,
						data: { 
							'action': 'pm_dismiss_admin_notice'
						}
					});
				});
			});
			</script>
			<div class="notice notice-error is-dismissible pm-load-notice">
				<p>The average page load time of your site for the past <strong><?php echo $num_of_days; ?> days</strong> has been <strong><?php echo round($load_average, 2); ?> seconds</strong>. Nearly half of web users expect a site to load in 2 seconds or less, and they tend to abandon a site that isn't loaded within 3 seconds. You should install caching plugin and tune your WordPress to improve your website loading time. Or you can host your website on WordPress managed hosting like <a href="https://vitaminwp.com/?start=true">VitaminWP.com</a> and they will ensure your website loads much quicker.</p>
			</div>
			<?php
		}
	}
}
add_action( 'admin_notices', 'pm_speed_notice_func' );

function pm_dismiss_admin_notice() {
	update_option('pm_page_load_notice_status', 'hide');

	die(0);
}
add_action( 'wp_ajax_pm_dismiss_admin_notice', 'pm_dismiss_admin_notice' );

function pm_popup_status_update() {
	global $wpdb;
	$popup_id = ( isset($_POST['popup_id']) ? $_POST['popup_id'] : '' );
	$popup_status = ( isset($_POST['popup_status']) ? $_POST['popup_status'] : '' );

	$popup_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$popup_id.'"');
	$status_changed = false;

	if ( !empty($popup_data) ) {
		$current_data = json_decode(stripslashes($popup_data['0']->popup_data), true);

		if ( $popup_status == 'live' ) {
			$current_data['popup_status'] = 'paused';
		} else {
			$current_data['popup_status'] = 'live';
		}

		$new_data = str_replace('"', '\"', json_encode($current_data));
		$new_data = str_replace('\'', '\\\'', $new_data);

		$status_query = $wpdb->query('UPDATE '.$wpdb->prefix.'popup_manager SET popup_data="'.$new_data.'" WHERE ID="'.$popup_id.'"');

		if ( $status_query !== false ) {
			$status_changed = true;
		}
	}

	if ( $status_changed ) {
		echo 'success';
	} else {
		echo 'failed';
	}

	die(0);
}
add_action( 'wp_ajax_nopriv_pm_popup_status', 'pm_popup_status_update' );
add_action( 'wp_ajax_pm_popup_status', 'pm_popup_status_update' );


function pm_popup_schedule_update() {
	global $wpdb;
	$popup_id = ( isset($_POST['popup_id']) ? $_POST['popup_id'] : '' );
	$schedule_start = ( isset($_POST['schedule_start']) ? $_POST['schedule_start'] : '' );
	$schedule_end = ( isset($_POST['schedule_end']) ? $_POST['schedule_end'] : '' );

	$popup_data = $wpdb->get_results('SELECT * FROM '.$wpdb->prefix.'popup_manager WHERE ID="'.$popup_id.'"');
	$schedule_changed = false;

	if ( !empty($popup_data) ) {
		$popup_new_schedule = array( 'start' => $schedule_start, 'end' => $schedule_end );
		$current_data = json_decode(stripslashes($popup_data['0']->popup_data), true);
		$current_data['popup_schedule'] = $popup_new_schedule;
		$new_data = str_replace('"', '\"', json_encode($current_data));
		$new_data = str_replace('\'', '\\\'', $new_data);

		$status_query = $wpdb->query('UPDATE '.$wpdb->prefix.'popup_manager SET popup_data="'.$new_data.'" WHERE ID="'.$popup_id.'"');

		if ( $status_query ) {
			$schedule_changed = true;
		}
	}

	if ( $schedule_changed ) {
		echo 'success';
	} else {
		echo 'failed';
	}

	die(0);
}
add_action( 'wp_ajax_nopriv_pm_popup_schedule', 'pm_popup_schedule_update' );
add_action( 'wp_ajax_pm_popup_schedule', 'pm_popup_schedule_update' );

function pm_get_popup_preview() {
	global $wpdb;
	$popup_template = ( isset($_POST['popup_template']) ? $_POST['popup_template'] : '' );
	$popup_style = ( isset($_POST['popup_style']) ? $_POST['popup_style'] : '' );

	$popup_data = $wpdb->get_results('SELECT popup_html FROM '.$wpdb->prefix.'popup_manager_templates WHERE template="'.$popup_template.'" AND template_style="'.$popup_style.'"');

	if ( !empty($popup_data) ) {
		echo $popup_data['0']->popup_html;
	}

	die(0);
}
add_action( 'wp_ajax_nopriv_pm_demo_popup', 'pm_get_popup_preview' );
add_action( 'wp_ajax_pm_demo_popup', 'pm_get_popup_preview' );