<?php
/*
Plugin Name: Local Links
Plugin URI: https://www.authorhelp.uk/wordpress-plugin-local-links/
Description: Make vendor links go to user's local store, and optionally add affiliate codes. Some functions require the <a href="https://wordpress.org/plugins/geoip-detect/" target="_blank">GeoIP Detection plugin</a>.
Version: 4.6
Author: Robin Phillips (Author Help)
Author URI: https://www.authorhelp.uk/
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Local Links is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Local Links is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Local Links. If not, see https://www.gnu.org/licenses/gpl-2.0.html.
*/

// Database options
// Key is option name, value is default value
global $locallinks_db_opts;

$locallinks_db_opts = array (
	'locallinks_abe' => 1,
	'locallinks_alib' => 1,
	'locallinks_amazon' => 1,
	'locallinks_apple' => 1,
	'locallinks_bsorg' => 1,
	'locallinks_google' => 1,
	'locallinks_kobo' => 1,
	'locallinks_obs' => 1,
	'locallinks_sw' => 1,

	'locallinks_ae' => '',
	'locallinks_au' => '',
	'locallinks_br' => '',
	'locallinks_ca' => '',
	'locallinks_cn' => '',
	'locallinks_de' => '',
	'locallinks_es' => '',
	'locallinks_fr' => '',
	'locallinks_in' => '',
	'locallinks_it' => '',
	'locallinks_jp' => '',
	'locallinks_mx' => '',
	'locallinks_nl' => '',
	'locallinks_pl' => '',
	'locallinks_sa' => '',
	'locallinks_se' => '',
	'locallinks_sg' => '',
	'locallinks_tr' => '',
	'locallinks_uk' => '',
	'locallinks_us' => '',

	'locallinks_aplaff' => '',
	'locallinks_bsaff' => '',
	'locallinks_googleaff' => '',
	'locallinks_koboid' => '',
	'locallinks_kobomid' => '',
	'locallinks_obsaff' => '',
	'locallinks_obssrc' => '',
	'locallinks_swaff' => '',
);

// Activation/update function: Create options unless they already exist
function locallinks_activation () {
	global $locallinks_db_opts;

	// Create options with default values if they don't already exist
	foreach ($locallinks_db_opts as $key => $value) {
		if (get_option($key) === false)
			update_option($key, $value);
	}
}

// Uninstall function
function locallinks_uninstall () {
	global $locallinks_db_opts;

	// Remove options
	foreach ($locallinks_db_opts as $key => $value) {
		delete_option($key);
	}
}

// Check plugin version
function locallinks_check_version () {
	// Get current version from this file's header text
	$ll_array = file (__FILE__, FILE_IGNORE_NEW_LINES);
	foreach ($ll_array as $ll) {
		if (substr($ll, 0, 9) == 'Version: ') {
			$thisversion = substr($ll, 9);
		}
	}

	if ($thisversion !== get_option('locallinks_plugin_version')) {
		// Version has changed. Update/add options
		locallinks_activation ();
		// Update the plugin version stored in the database
		update_option('locallinks_plugin_version', $thisversion);
	}
}

function locallinks_pluginpagelinks ($links) {
	// Add a "Settings" link
	$links [] = '<a href="'. get_admin_url(null, 'options-general.php?page=locallinks_config') .'">' .
		esc_html__('Settings', 'mobile-banner') . '</a>';
	return $links;
}

// Register hooks
register_activation_hook( __FILE__, 'locallinks_activation');
register_uninstall_hook(__FILE__, 'locallinks_uninstall');

// Add Settings link to plugin page
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'locallinks_pluginpagelinks');

// Create settings page
add_action('admin_menu', 'locallinks_admin');
// Check the version, so that actions can be taken if the plugin is updated
add_action('plugins_loaded', 'locallinks_check_version');

// Include the main code
require ('public/replacelinks.php');

// Include the admin code
require ('admin/settings.php');
