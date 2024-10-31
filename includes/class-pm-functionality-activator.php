<?php

/**
 * Fired during plugin activation
 *
 * @link       https://cohhe.com
 * @since      1.0.0
 *
 * @package    pm_func
 * @subpackage pm_func/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    pm_func
 * @subpackage pm_func/includes
 * @author     Cohhe <support@cohhe.com>
 */
class pm_func_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function pm_activate() {
		global $wpdb;

		$main_table = $wpdb->prefix . 'popup_manager';
		$template_table  = $wpdb->prefix . 'popup_manager_templates';
		$charset_collate = $wpdb->get_charset_collate();

		$main_sql = "CREATE TABLE IF NOT EXISTS $main_table (
				  `ID` int(9) NOT NULL AUTO_INCREMENT,
				  `name` text NOT NULL,
				  `popup_data` text NOT NULL,
				  `popup_html` text NOT NULL,
				  PRIMARY KEY (`ID`)
				) $charset_collate;";

		$template_sql = "CREATE TABLE IF NOT EXISTS $template_table (
				  `ID` int(9) NOT NULL AUTO_INCREMENT,
				  `template` text NOT NULL,
				  `template_style` text NOT NULL,
				  `popup_html` text NOT NULL,
				  PRIMARY KEY (`ID`)
				) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $main_sql );
		dbDelta( $template_sql );

		$type_sql = "SHOW COLUMNS FROM `".$main_table."` LIKE 'popup_type'";
		$type_results = $wpdb->get_var($type_sql);
		if ( $type_results != 'popup_type' ) {
			$type_add_sql = "ALTER TABLE ".$main_table." ADD popup_type VARCHAR(10) NOT NULL DEFAULT 'parent' AFTER name";
			$wpdb->query($type_add_sql);

			$parent_add_sql = "ALTER TABLE ".$main_table." ADD popup_parent VARCHAR(10) NOT NULL DEFAULT '0' AFTER popup_type";
			$wpdb->query($parent_add_sql);
		}

		// Image template
		$image_popup_html = '<a href=\"\" class=\"email-popup-preview\" style=\"background: url('.PM_PLUGIN_URI . 'admin/images/image-bg.png) no-repeat;\"><span class=\"email-popup-close-wrapper\"><span class=\"email-popup-close\"><img src=\"' . PM_PLUGIN_URI . 'admin/images/close-white.png\" alt=\"\"></span></span></a>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="image" && template_style=""') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_style,popup_html) VALUES ("image","","'.$image_popup_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET popup_html="'.$image_popup_html.'" WHERE template="image" && template_style=""');
		}

		// Text template
		$text_popup_html = '<div class=\"email-popup-preview\"><div class=\"email-popup-preview-inner\"><span class=\"email-popup-close-wrapper\"><span class=\"email-popup-close\"></span></span><div class=\"form-input-wrapper\"><div class=\"email-popup-main-title\" spellcheck=\"false\" contenteditable=\"true\" style=\"color: #2AAA79; text-align: center; font-weight: 700;\">WANT MORE TRAFFIC?</div></div><div class=\"form-input-wrapper\"><div class=\"email-popup-disclaimer\" spellcheck=\"false\" contenteditable=\"true\" style=\"color: #A0A0A0; text-align: center; font-size: 25px; font-weight: 300;\">Let\'s Go Surfing Baby!</div></div><div class=\"form-input-wrapper\"><div class=\"email-popup-secondary-title\" spellcheck=\"false\" contenteditable=\"true\" style=\"color: #A5A5A5; text-align: center; font-size: 16px; line-height: 23px; font-weight: 300;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras accumsan laoreet feugiat. Aenean ut accumsan.</div></div></div></div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="text" && template_style=""') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_style,popup_html) VALUES ("text","","'.$text_popup_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET popup_html="'.$text_popup_html.'" WHERE template="text" && template_style=""');
		}

		// Default template
		$default_popup_html = '<div class=\"email-popup-preview\"><div class=\"email-popup-preview-inner\"><span class=\"email-popup-close-wrapper\"><span class=\"email-popup-close\"></span></span><div class=\"form-input-wrapper\"><div class=\"email-popup-main-title\" spellcheck=\"false\" contenteditable=\"true\">Subscribe now!</div></div><div class=\"form-input-wrapper\"><div class=\"email-popup-secondary-title\" spellcheck=\"false\" contenteditable=\"true\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras accumsan laoreet feugiat. Aenean ut accumsan magna, id venenatis mauris.</div></div><form class=\"email-popup-main-form clearfix\"></form></div></div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="email" && template_style="default"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_style,popup_html) VALUES ("email","default","'.$default_popup_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET popup_html="'.$default_popup_html.'" WHERE template="email" && template_style="default"');
		}

		// Inline template
		$inline_popup_html = '<div class=\"email-popup-preview\" style=\"width: 700px;background: url(' . PM_PLUGIN_URI . 'admin/images/inline-bg.png) no-repeat;\"><div class=\"email-popup-preview-inner\"><style type=\"text/css\">.email-popup-preview input:not([type=submit]) {border-radius: 0px;padding: 10px 12px;font-size: 15px;margin-bottom: 0;}.email-popup-main-form .form-input-wrapper:nth-child(1) {float: left;width: 70%;}.email-popup-main-form .form-input-wrapper:nth-child(2) {float: left;width: 30%;}.email-popup-preview input[type=submit], .email-popup-preview button {border-radius: 0;font-size: 19px;padding: 10px 12px;margin-left: 15px;width: 100%;text-transform: inherit;}</style><span class=\"email-popup-close-wrapper\"><span class=\"email-popup-close\"></span></span><div class=\"form-input-wrapper\"><div class=\"email-popup-main-title\" spellcheck=\"false\" contenteditable=\"true\" style=\"text-align: left;padding-top: 11px;font-size: 31px;color: #000;\">Subscribe now!</div></div><div class=\"form-input-wrapper\"><div class=\"email-popup-secondary-title\" spellcheck=\"false\" contenteditable=\"true\" style=\"text-align: left;font-size: 15px;line-height: 18px;padding-top: 3px;color: #000;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras accumsan laoreet feugiat. Aenean ut accumsan magna, id venenatis mauris.</div></div><form class=\"email-popup-main-form clearfix\" style=\"padding-top: 97px;margin-top: 0;\"></form></div></div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="email" && template_style="inline"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_style,popup_html) VALUES ("email","inline","'.$inline_popup_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET popup_html="'.$inline_popup_html.'" WHERE template="email" && template_style="inline"');
		}

		// Minimalistic template
		$minimalistic_popup_html = '<div class=\"email-popup-preview\" style=\"width: 600px;background: url(' . PM_PLUGIN_URI . 'admin/images/minimalistic-bg.png) no-repeat;\"><div class=\"email-popup-preview-inner\"><style type=\"text/css\">.email-popup-preview input:not([type=\"submit\"]) {border-radius: 0;padding: 14px 17px;border: none;}.email-popup-preview input[type=submit], .email-popup-preview button {float: right;border-radius: 0;text-transform: uppercase;color:#000;font-size: 19px;margin-top: 56px;padding: 14px 51px;background-color: #01f6a8;border-color: #01f6a8}</style><span class=\"email-popup-close-wrapper\"><span class=\"email-popup-close\"></span></span><div class=\"form-input-wrapper\"><div class=\"email-popup-main-title\" spellcheck=\"false\" contenteditable=\"true\" style=\"text-align: left;font-size: 32px;padding-top: 23px;color: #fff;text-align: right;\">Subscribe now!</div></div><div class=\"form-input-wrapper\"><div class=\"email-popup-secondary-title\" spellcheck=\"false\" contenteditable=\"true\" style=\"font-size: 14px;line-height: 18px;padding-top: 10px;color: #fff;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras accumsan laoreet feugiat. Aenean ut accumsan magna, id venenatis mauris.</div></div><form class=\"email-popup-main-form clearfix\" style=\"padding-top: 26px;\"></form></div></div>';
		if ( !$wpdb->query('SELECT * FROM ' . $template_table . ' WHERE template="email" && template_style="minimalistic"') ) {
			$wpdb->query('INSERT INTO ' . $template_table . ' (template,template_style,popup_html) VALUES ("email","minimalistic","'.$minimalistic_popup_html.'")');
		} else {
			$wpdb->query('UPDATE ' . $template_table . ' SET popup_html="'.$minimalistic_popup_html.'" WHERE template="email" && template_style="minimalistic"');
		}

		$main_notice = get_option('pm_rating_notice');
		
		if ( !$main_notice ) {
			update_option('pm_rating_notice', time());
		}

	}

}