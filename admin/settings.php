<?php
/*
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

function locallinks_admin() {
	add_submenu_page ('options-general.php', 'Local Links', 'Local Links', 'manage_options', 'locallinks_config', 'locallinks_config_page');
}

function locallinks_config_page() {
	// Check that the user has the required capability
	if (!current_user_can('manage_options'))
		wp_die(esc_html__('You do not have sufficient permissions to access this page.', 'local-links'));

	// variables for the field and option names
	$hidden_field_name = 'locallinks_submit_hidden';
	$amazon_data_field_name = 'locallinks_amazon';
	$amazon_opt_name = 'locallinks_amazon';
	$apple_data_field_name = 'locallinks_apple';
	$apple_opt_name = 'locallinks_apple';
	$kobo_data_field_name = 'locallinks_kobo';
	$kobo_opt_name = 'locallinks_kobo';
	$alib_data_field_name = 'locallinks_alib';
	$alib_opt_name = 'locallinks_alib';
	$google_data_field_name = 'locallinks_google';
	$google_opt_name = 'locallinks_google';
	$abe_data_field_name = 'locallinks_abe';
	$abe_opt_name = 'locallinks_abe';
	$bsorg_data_field_name = 'locallinks_bsorg';
	$bsorg_opt_name = 'locallinks_bsorg';
	$obs_data_field_name = 'locallinks_obs';
	$obs_opt_name = 'locallinks_obs';
	$sw_data_field_name = 'locallinks_sw';
	$sw_opt_name = 'locallinks_sw';

	// Amazon affiliate field names
	$amzaff_ae_data_field_name = 'locallinks_ae';
	$amzaff_au_data_field_name = 'locallinks_au';
	$amzaff_br_data_field_name = 'locallinks_br';
	$amzaff_ca_data_field_name = 'locallinks_ca';
	$amzaff_cn_data_field_name = 'locallinks_cn';
	$amzaff_de_data_field_name = 'locallinks_de';
	$amzaff_es_data_field_name = 'locallinks_es';
	$amzaff_fr_data_field_name = 'locallinks_fr';
	$amzaff_in_data_field_name = 'locallinks_in';
	$amzaff_it_data_field_name = 'locallinks_it';
	$amzaff_jp_data_field_name = 'locallinks_jp';
	$amzaff_mx_data_field_name = 'locallinks_mx';
	$amzaff_nl_data_field_name = 'locallinks_nl';
	$amzaff_pl_data_field_name = 'locallinks_pl';
	$amzaff_sa_data_field_name = 'locallinks_sa';
	$amzaff_se_data_field_name = 'locallinks_se';
	$amzaff_sg_data_field_name = 'locallinks_sg';
	$amzaff_tr_data_field_name = 'locallinks_tr';
	$amzaff_uk_data_field_name = 'locallinks_uk';
	$amzaff_us_data_field_name = 'locallinks_us';

	// Other affiliate field names
	$aplaff_data_field_name = 'locallinks_aplaff';
	$googleaff_data_field_name = 'locallinks_googleaff';
	$swaff_data_field_name = 'locallinks_swaff';

	// Kobo
	$koboid_data_field_name = 'locallinks_koboid';
	$kobomid_data_field_name = 'locallinks_kobomid';

	// Bookshop.org
	$bsorgusaff_data_field_name = 'locallinks_bsorgusaff';
	$bsorgukaff_data_field_name = 'locallinks_bsorgukaff';
	$bsorgesaff_data_field_name = 'locallinks_bsorgesaff';

	// OBS
	$obsaff_data_field_name = 'locallinks_obsaff';
	$obssrc_data_field_name = 'locallinks_obssrc';

	// Amazon affiliate option names
	$amzaff_ae_opt_name = 'locallinks_ae';
	$amzaff_au_opt_name = 'locallinks_au';
	$amzaff_br_opt_name = 'locallinks_br';
	$amzaff_ca_opt_name = 'locallinks_ca';
	$amzaff_cn_opt_name = 'locallinks_cn';
	$amzaff_de_opt_name = 'locallinks_de';
	$amzaff_es_opt_name = 'locallinks_es';
	$amzaff_fr_opt_name = 'locallinks_fr';
	$amzaff_in_opt_name = 'locallinks_in';
	$amzaff_it_opt_name = 'locallinks_it';
	$amzaff_jp_opt_name = 'locallinks_jp';
	$amzaff_mx_opt_name = 'locallinks_mx';
	$amzaff_nl_opt_name = 'locallinks_nl';
	$amzaff_pl_opt_name = 'locallinks_pl';
	$amzaff_sa_opt_name = 'locallinks_sa';
	$amzaff_se_opt_name = 'locallinks_se';
	$amzaff_sg_opt_name = 'locallinks_sg';
	$amzaff_tr_opt_name = 'locallinks_tr';
	$amzaff_uk_opt_name = 'locallinks_uk';
	$amzaff_us_opt_name = 'locallinks_us';

	// Other affiliate option names
	$aplaff_opt_name = 'locallinks_aplaff';
	$googleaff_opt_name = 'locallinks_googleaff';
	$swaff_opt_name = 'locallinks_swaff';

	// Kobo
	$koboid_opt_name = 'locallinks_koboid';
	$kobomid_opt_name = 'locallinks_kobomid';

	// Bookshop.org
	$bsorgusaff_opt_name = 'locallinks_bsorgusaff';
	$bsorgukaff_opt_name = 'locallinks_bsorgukaff';
	$bsorgesaff_opt_name = 'locallinks_bsorgesaff';

	// OBS
	$obsaff_opt_name = 'locallinks_obsaff';
	$obssrc_opt_name = 'locallinks_obssrc';

	// Read in existing option values from database
	$locallinks_amazon_opt_val = get_option($amazon_opt_name);
	$locallinks_apple_opt_val = get_option($apple_opt_name);
	$locallinks_kobo_opt_val = get_option($kobo_opt_name);
	$alib_opt_val = get_option($alib_opt_name);
	$locallinks_google_opt_val = get_option($google_opt_name);
	$locallinks_abe_opt_val = get_option($abe_opt_name);
	$locallinks_bsorg_opt_val = get_option ($bsorg_opt_name);
	$locallinks_obs_opt_val = get_option ($obs_opt_name);
	$locallinks_sw_opt_val = get_option ($sw_opt_name);

	$amzaff_ae_opt_val = get_option($amzaff_ae_opt_name);
	$amzaff_au_opt_val = get_option($amzaff_au_opt_name);
	$amzaff_br_opt_val = get_option($amzaff_br_opt_name);
	$amzaff_ca_opt_val = get_option($amzaff_ca_opt_name);
	$amzaff_cn_opt_val = get_option($amzaff_cn_opt_name);
	$amzaff_de_opt_val = get_option($amzaff_de_opt_name);
	$amzaff_es_opt_val = get_option($amzaff_es_opt_name);
	$amzaff_fr_opt_val = get_option($amzaff_fr_opt_name);
	$amzaff_in_opt_val = get_option($amzaff_in_opt_name);
	$amzaff_it_opt_val = get_option($amzaff_it_opt_name);
	$amzaff_jp_opt_val = get_option($amzaff_jp_opt_name);
	$amzaff_mx_opt_val = get_option($amzaff_mx_opt_name);
	$amzaff_nl_opt_val = get_option($amzaff_nl_opt_name);
	$amzaff_pl_opt_val = get_option($amzaff_pl_opt_name);
	$amzaff_sa_opt_val = get_option($amzaff_sa_opt_name);
	$amzaff_se_opt_val = get_option($amzaff_se_opt_name);
	$amzaff_sg_opt_val = get_option($amzaff_sg_opt_name);
	$amzaff_tr_opt_val = get_option($amzaff_tr_opt_name);
	$amzaff_uk_opt_val = get_option($amzaff_uk_opt_name);
	$amzaff_us_opt_val = get_option($amzaff_us_opt_name);

	$locallinks_aplaff_opt_val = get_option($aplaff_opt_name);
	$googleaff_opt_val = get_option($googleaff_opt_name);
	$swaff_opt_val = get_option($swaff_opt_name);

	// Kobo
	$koboid_opt_val = get_option($koboid_opt_name);
	$kobomid_opt_val = get_option($kobomid_opt_name);

	// Bookshop.org
	$bsorgusaff_opt_val = get_option($bsorgusaff_opt_name);
	$bsorgukaff_opt_val = get_option($bsorgukaff_opt_name);
	$bsorgesaff_opt_val = get_option($bsorgesaff_opt_name);

	// OBS
	$obsaff_opt_val = get_option($obsaff_opt_name);
	$obssrc_opt_val = get_option($obssrc_opt_name);

	// See if the user has posted us some information
	// If they did, this hidden field will be set to 'Y'
	if( isset($_POST[ $hidden_field_name ]) && $_POST[ $hidden_field_name ] == 'Y' ) {
		// Check nonce is valid
		// This call checks the nonce and the referrer, and if the check fails it takes the normal action (terminating script execution with a “403 Forbidden” response and an error message). [https://developer.wordpress.org/apis/security/nonces/]
		check_admin_referer('local_links_update_nonce');

		// Read their posted value
		if (isset($_POST[$amazon_data_field_name]))
			$locallinks_amazon_opt_val = $_POST[$amazon_data_field_name];
		else
			$locallinks_amazon_opt_val = 0;
		if (isset($_POST[$apple_data_field_name]))
			$locallinks_apple_opt_val = $_POST[$apple_data_field_name];
		else
			$locallinks_apple_opt_val = 0;
		if (isset($_POST[$kobo_data_field_name]))
			$locallinks_kobo_opt_val = $_POST[$kobo_data_field_name];
		else
			$locallinks_kobo_opt_val = 0;
		if (isset($_POST[$alib_data_field_name]))
			$alib_opt_val = $_POST[$alib_data_field_name];
		else
			$alib_opt_val = 0;
		if (isset($_POST[$google_data_field_name]))
			$locallinks_google_opt_val = $_POST[$google_data_field_name];
		else
			$locallinks_google_opt_val = 0;
		if (isset($_POST[$abe_data_field_name]))
			$locallinks_abe_opt_val = $_POST[$abe_data_field_name];
		else
			$locallinks_abe_opt_val = 0;
		if (isset($_POST[$bsorg_data_field_name]))
			$locallinks_bsorg_opt_val = $_POST[$bsorg_data_field_name];
		else
			$locallinks_bsorg_opt_val = 0;
		if (isset($_POST[$obs_data_field_name]))
			$locallinks_obs_opt_val = $_POST[$obs_data_field_name];
		else
			$locallinks_obs_opt_val = 0;
		if (isset($_POST[$sw_data_field_name]))
			$locallinks_sw_opt_val = $_POST[$sw_data_field_name];
		else
			$locallinks_sw_opt_val = 0;

		// Amazon affiliates - set values
		if (isset($_POST[$amzaff_au_data_field_name]))
			$amzaff_au_opt_val = filter_var($_POST[$amzaff_au_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_au_opt_val = '';
		if (isset($_POST[$amzaff_br_data_field_name]))
			$amzaff_br_opt_val = filter_var($_POST[$amzaff_br_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_br_opt_val = '';
		if (isset($_POST[$amzaff_ca_data_field_name]))
			$amzaff_ca_opt_val = filter_var($_POST[$amzaff_ca_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_ca_opt_val = '';
		if (isset($_POST[$amzaff_cn_data_field_name]))
			$amzaff_cn_opt_val = filter_var($_POST[$amzaff_cn_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_cn_opt_val = '';
		if (isset($_POST[$amzaff_de_data_field_name]))
			$amzaff_de_opt_val = filter_var($_POST[$amzaff_de_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_de_opt_val = '';
		if (isset($_POST[$amzaff_es_data_field_name]))
			$amzaff_es_opt_val = filter_var($_POST[$amzaff_es_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_es_opt_val = '';
		if (isset($_POST[$amzaff_fr_data_field_name]))
			$amzaff_fr_opt_val = filter_var($_POST[$amzaff_fr_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_fr_opt_val = '';
		if (isset($_POST[$amzaff_in_data_field_name]))
			$amzaff_in_opt_val = filter_var($_POST[$amzaff_in_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_in_opt_val = '';
		if (isset($_POST[$amzaff_it_data_field_name]))
			$amzaff_it_opt_val = filter_var($_POST[$amzaff_it_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_it_opt_val = '';
		if (isset($_POST[$amzaff_jp_data_field_name]))
			$amzaff_jp_opt_val = filter_var($_POST[$amzaff_jp_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_jp_opt_val = '';
		if (isset($_POST[$amzaff_mx_data_field_name]))
			$amzaff_mx_opt_val = filter_var($_POST[$amzaff_mx_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_mx_opt_val = '';
		if (isset($_POST[$amzaff_nl_data_field_name]))
			$amzaff_nl_opt_val = filter_var($_POST[$amzaff_nl_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_nl_opt_val = '';
		if (isset($_POST[$amzaff_uk_data_field_name]))
			$amzaff_uk_opt_val = filter_var($_POST[$amzaff_uk_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_uk_opt_val = '';
		if (isset($_POST[$amzaff_us_data_field_name]))
			$amzaff_us_opt_val = filter_var($_POST[$amzaff_us_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_us_opt_val = '';
		if (isset($_POST[$amzaff_ae_data_field_name]))
			$amzaff_ae_opt_val = filter_var($_POST[$amzaff_ae_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_ae_opt_val = '';
		if (isset($_POST[$amzaff_sg_data_field_name]))
			$amzaff_sg_opt_val = filter_var($_POST[$amzaff_sg_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_sg_opt_val = '';
		if (isset($_POST[$amzaff_sa_data_field_name]))
			$amzaff_sa_opt_val = filter_var($_POST[$amzaff_sa_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_sa_opt_val = '';
		if (isset($_POST[$amzaff_tr_data_field_name]))
			$amzaff_tr_opt_val = filter_var($_POST[$amzaff_tr_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_tr_opt_val = '';

		if (isset($_POST[$amzaff_se_data_field_name]))
			$amzaff_se_opt_val = filter_var($_POST[$amzaff_se_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_se_opt_val = '';
		if (isset($_POST[$amzaff_pl_data_field_name]))
			$amzaff_pl_opt_val = filter_var($_POST[$amzaff_pl_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$amzaff_pl_opt_val = '';

		// Other affiliates - set values
		if (isset($_POST[$aplaff_data_field_name]))
			$locallinks_aplaff_opt_val = filter_var($_POST[$aplaff_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$locallinks_aplaff_opt_val = '';
		if (isset($_POST[$googleaff_data_field_name]))
			$googleaff_opt_val = filter_var($_POST[$googleaff_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$googleaff_opt_val = '';
		if (isset($_POST[$koboid_data_field_name]))
			$koboid_opt_val = filter_var($_POST[$koboid_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$koboid_opt_val = '';
		if (isset($_POST[$kobomid_data_field_name]))
			$kobomid_opt_val = filter_var($_POST[$kobomid_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$kobomid_opt_val = '';
		if (isset($_POST[$bsorgusaff_data_field_name]))
			$bsorgusaff_opt_val = filter_var($_POST[$bsorgusaff_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$bsorgusaff_opt_val = '';
		if (isset($_POST[$bsorgukaff_data_field_name]))
			$bsorgukaff_opt_val = filter_var($_POST[$bsorgukaff_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$bsorgukaff_opt_val = '';
		if (isset($_POST[$bsorgesaff_data_field_name]))
			$bsorgesaff_opt_val = filter_var($_POST[$bsorgesaff_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$bsorgesaff_opt_val = '';
		if (isset($_POST[$obsaff_data_field_name]))
			$obsaff_opt_val = filter_var($_POST[$obsaff_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$obsaff_opt_val = '';
		if (isset($_POST[$obssrc_data_field_name]))
			$obssrc_opt_val = filter_var($_POST[$obssrc_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$obssrc_opt_val = '';
		if (isset($_POST[$swaff_data_field_name]))
			$swaff_opt_val = filter_var($_POST[$swaff_data_field_name], FILTER_SANITIZE_ENCODED);
		else
			$swaff_opt_val = '';

		// Save the posted values in the database
		update_option($amazon_opt_name, $locallinks_amazon_opt_val);
		update_option($apple_opt_name, $locallinks_apple_opt_val);
		update_option($kobo_opt_name, $locallinks_kobo_opt_val);
		update_option($alib_opt_name, $alib_opt_val);
		update_option($google_opt_name, $locallinks_google_opt_val);
		update_option($abe_opt_name, $locallinks_abe_opt_val);
		update_option($bsorg_opt_name, $locallinks_bsorg_opt_val);
		update_option($obs_opt_name, $locallinks_obs_opt_val);
		update_option($sw_opt_name, $locallinks_sw_opt_val);

		update_option($amzaff_ae_opt_name, $amzaff_ae_opt_val);
		update_option($amzaff_au_opt_name, $amzaff_au_opt_val);
		update_option($amzaff_br_opt_name, $amzaff_br_opt_val);
		update_option($amzaff_ca_opt_name, $amzaff_ca_opt_val);
		update_option($amzaff_cn_opt_name, $amzaff_cn_opt_val);
		update_option($amzaff_de_opt_name, $amzaff_de_opt_val);
		update_option($amzaff_es_opt_name, $amzaff_es_opt_val);
		update_option($amzaff_fr_opt_name, $amzaff_fr_opt_val);
		update_option($amzaff_in_opt_name, $amzaff_in_opt_val);
		update_option($amzaff_it_opt_name, $amzaff_it_opt_val);
		update_option($amzaff_jp_opt_name, $amzaff_jp_opt_val);
		update_option($amzaff_mx_opt_name, $amzaff_mx_opt_val);
		update_option($amzaff_nl_opt_name, $amzaff_nl_opt_val);
		update_option($amzaff_pl_opt_name, $amzaff_pl_opt_val);
		update_option($amzaff_sa_opt_name, $amzaff_sa_opt_val);
		update_option($amzaff_se_opt_name, $amzaff_se_opt_val);
		update_option($amzaff_sg_opt_name, $amzaff_sg_opt_val);
		update_option($amzaff_tr_opt_name, $amzaff_tr_opt_val);
		update_option($amzaff_uk_opt_name, $amzaff_uk_opt_val);
		update_option($amzaff_us_opt_name, $amzaff_us_opt_val);

		update_option($aplaff_opt_name, $locallinks_aplaff_opt_val);
		update_option($googleaff_opt_name, $googleaff_opt_val);
		update_option($swaff_opt_name, $swaff_opt_val);

		// Kobo
		update_option($koboid_opt_name, $koboid_opt_val);
		update_option($kobomid_opt_name, $kobomid_opt_val);

		// Bookshop.org
		update_option($bsorgusaff_opt_name, $bsorgusaff_opt_val);
		update_option($bsorgukaff_opt_name, $bsorgukaff_opt_val);
		update_option($bsorgesaff_opt_name, $bsorgesaff_opt_val);

		// OBS
		update_option($obsaff_opt_name, $obsaff_opt_val);
		update_option($obssrc_opt_name, $obssrc_opt_val);

		// Put a "settings saved" message on the screen
		echo '<div class="updated"><p><strong>' . esc_html__('Settings saved.', 'local-links') . '</strong></p></div>';
	}

	// Whether or not checkboxes should be ticked
	if (intval($locallinks_amazon_opt_val) == 1)
		$amazon_checked = 'checked';
	else
		$amazon_checked = '';
	if (intval($locallinks_apple_opt_val) == 1)
		$apple_checked = 'checked';
	else
		$apple_checked = '';
	if (intval($locallinks_kobo_opt_val) == 1)
		$kobo_checked = 'checked';
	else
		$kobo_checked = '';
	if (intval($alib_opt_val) == 1)
		$alib_checked = 'checked';
	else
		$alib_checked = '';
	if (intval($locallinks_google_opt_val) == 1)
		$google_checked = 'checked';
	else
		$google_checked = '';
	if (intval($locallinks_abe_opt_val) == 1)
		$abe_checked = 'checked';
	else
		$abe_checked = '';
	if (intval($locallinks_bsorg_opt_val) == 1)
		$bsorg_checked = 'checked';
	else
		$bsorg_checked = '';
	if (intval($locallinks_obs_opt_val) == 1)
		$obs_checked = 'checked';
	else
		$obs_checked = '';
	if (intval($locallinks_sw_opt_val) == 1)
		$sw_checked = 'checked';
	else
		$sw_checked = '';

	// Now display the settings editing screen
	echo '<div class="wrap"><h2>' . esc_html__('Local Links Settings', 'local-links') . '</h2>';
	echo '<form name="locallinks_form" method="post" action="">';
	echo '<input type="hidden" name="' . $hidden_field_name . '" value="Y">';

	// Find out if the GeoIP plugin is installed and enabled
	if (function_exists ('geoip_detect2_get_info_from_current_ip'))
		$locallinks_geo = '';
	else {
		$locallinks_geo = 'disabled';
		// If GeoIP plugin is not installed, do not check some boxes
		$amazon_checked = '';
		$alib_checked = '';
		$abe_checked = '';
		$bsorg_checked = '';
	}

	// Amazon
	echo "<p><input type='checkbox' name='$amazon_data_field_name' id='locallinks_amazon' $amazon_checked value='1' $locallinks_geo> <label for='locallinks_amazon'>";
	esc_html_e ('Localize Amazon links and add affiliate codes', 'local-links');

	if ($locallinks_geo == 'disabled') {
		echo '. <strong><a href="https://wordpress.org/plugins/geoip-detect/" target="_blank">';
		esc_html_e ('GeoIP Detection plugin', 'local-links');
		echo '</a> ';
		esc_html_e ('not installed or not activated.', 'local-links');
		echo '</strong>';
	}
	echo '</p>';

	// Apple
	echo "<p><input type='checkbox' name='$apple_data_field_name' id='locallinks_apple' $apple_checked value='1'> <label for='locallinks_apple'>";
	esc_html_e ('Localize Apple links (Apple Books, iTunes) and add affiliate codes', 'local-links');

	if ($locallinks_geo == 'disabled') {
		echo '. <strong><a href="https://wordpress.org/plugins/geoip-detect/" target="_blank">';
		esc_html_e ('GeoIP Detection plugin', 'local-links');
		echo '</a> ';
		esc_html_e ('not installed or not activated. Apple Books links require the GeoIP Detection plugin (iTunes links do not).', 'local-links');
		echo '</strong>';
	}
	echo '</p>';

	// Kobo
	echo "<p><input type='checkbox' name='$kobo_data_field_name' id='locallinks_kobo' $kobo_checked value='1'> <label for='locallinks_kobo'>";
	esc_html_e ('Localize Kobo links and add affiliate codes', 'local-links');
	echo '</p>';

	// Alibris
	echo "<p><input type='checkbox' name='$alib_data_field_name' id='locallinks_alib' $alib_checked value='1' $locallinks_geo> <label for='locallinks_alib'>";
	esc_html_e ('Localize Alibris links', 'local-links');
	if ($locallinks_geo == 'disabled') {
		echo '. <strong><a href="https://wordpress.org/plugins/geoip-detect/" target="_blank">';
		esc_html_e ('GeoIP Detection plugin', 'local-links');
		echo '</a> ';
		esc_html_e ('is not installed or not activated.', 'local-links');
		echo '</strong>';
	}
	echo '</p>';

	// Google
	echo "<p><input type='checkbox' name='$google_data_field_name' id='locallinks_google' $google_checked value='1'> <label for='locallinks_google'>";
	esc_html_e ('Localize Google Play links and add affiliate codes', 'local-links');
	echo '</p>';

	// AbeBooks
	echo "<p><input type='checkbox' name='$abe_data_field_name' id='locallinks_abe' $abe_checked value='1' $locallinks_geo> <label for='locallinks_abe'>";
	esc_html_e ('Localize AbeBooks links', 'local-links');
	if ($locallinks_geo == 'disabled') {
		echo '. <strong><a href="https://wordpress.org/plugins/geoip-detect/" target="_blank">';
		esc_html_e ('GeoIP Detection plugin', 'local-links');
		echo '</a> ';
		esc_html_e ('is not installed or not activated.', 'local-links');
		echo '</strong>';
	}
	echo '</p>';

	// Bookshop.org
	echo "<p><input type='checkbox' name='$bsorg_data_field_name' id='locallinks_bsorg' $bsorg_checked value='1' $locallinks_geo> <label for='locallinks_bsorg'>";
	esc_html_e ('Localize Bookshop.org links and add affiliate codes', 'local-links');

	if ($locallinks_geo == 'disabled') {
		echo '. <strong><a href="https://wordpress.org/plugins/geoip-detect/" target="_blank">';
		esc_html_e ('GeoIP Detection plugin', 'local-links');
		echo '</a> ';
		esc_html_e ('not installed or not activated.', 'local-links');
		echo '</strong>';
	}
	echo '</p>';

	// OneBookShelf
	echo "<p><input type='checkbox' name='$obs_data_field_name' id='locallinks_obs' $obs_checked value='1'> <label for='locallinks_obs'>";
	esc_html_e ('Add affiliate codes and/or src parameter to OneBookShelf links (DriveThruFiction, DriveThruCards, DriveThruComics, DriveThruRPG, Wargame Vault)', 'local-links');
	echo '</p>';

	// Smashwords
	echo "<p><input type='checkbox' name='$sw_data_field_name' id='locallinks_sw' $sw_checked value='1'> <label for='locallinks_sw'>";
	esc_html_e ('Add affiliate codes to Smashwords links', 'local-links');
	echo '</p>';

	// Amazon Affiliates - setting text boxes
	echo '<h3>' . esc_html__('Amazon Affiliates', 'local-links') . '</h3>';
	echo '<p>';
	esc_html_e ('Add your Amazon affiliate codes below for each country that you have one for. They will be added to Amazon links for users in that country.', 'local-links');
	echo '<br />';
	esc_html_e ('Note that Amazon affiliate codes will not be added if Amazon localization is disabled above.', 'local-links');
	echo '</p>';
?>

	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.com: <input type='text' style='width:20ex;' name='<?=$amzaff_us_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_us' placeholder='locallinks-20' value='<?=$amzaff_us_opt_val;?>'> <label for='locallinks_amzaff_us'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.co.uk: <input type='text' style='width:20ex;' name='<?=$amzaff_uk_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_uk' placeholder='locallinks-20' value='<?=$amzaff_uk_opt_val;?>'> <label for='locallinks_amzaff_uk'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.com.au: <input type='text' style='width:20ex;' name='<?=$amzaff_au_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_au' placeholder='locallinks-20' value='<?=$amzaff_au_opt_val;?>'> <label for='locallinks_amzaff_au'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.ca: <input type='text' style='width:20ex;' name='<?=$amzaff_ca_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_ca' placeholder='locallinks-20' value='<?=$amzaff_ca_opt_val;?>'> <label for='locallinks_amzaff_ca'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.com.br: <input type='text' style='width:20ex;' name='<?=$amzaff_br_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_br' placeholder='locallinks-20' value='<?=$amzaff_br_opt_val;?>'> <label for='locallinks_amzaff_br'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.cn: <input type='text' style='width:20ex;' name='<?=$amzaff_cn_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_cn' placeholder='locallinks-20' value='<?=$amzaff_cn_opt_val;?>'> <label for='locallinks_amzaff_cn'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.de: <input type='text' style='width:20ex;' name='<?=$amzaff_de_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_de' placeholder='locallinks-20' value='<?=$amzaff_de_opt_val;?>'> <label for='locallinks_amzaff_de'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.es: <input type='text' style='width:20ex;' name='<?=$amzaff_es_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_es' placeholder='locallinks-20' value='<?=$amzaff_es_opt_val;?>'> <label for='locallinks_amzaff_es'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.fr: <input type='text' style='width:20ex;' name='<?=$amzaff_fr_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_fr' placeholder='locallinks-20' value='<?=$amzaff_fr_opt_val;?>'> <label for='locallinks_amzaff_fr'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.in: <input type='text' style='width:20ex;' name='<?=$amzaff_in_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_in' placeholder='locallinks-20' value='<?=$amzaff_in_opt_val;?>'> <label 	for='locallinks_amzaff_in'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.it: <input type='text' style='width:20ex;' name='<?=$amzaff_it_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_it' placeholder='locallinks-20' value='<?=$amzaff_it_opt_val;?>'> <label for='locallinks_amzaff_it'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.co.jp: <input type='text' style='width:20ex;' name='<?=$amzaff_jp_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_jp' placeholder='locallinks-20' value='<?=$amzaff_jp_opt_val;?>'> <label for='locallinks_amzaff_jp'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.com.mx: <input type='text' style='width:20ex;' name='<?=$amzaff_mx_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_mx' placeholder='locallinks-20' value='<?=$amzaff_mx_opt_val;?>'> <label for='locallinks_amzaff_mx'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.nl: <input type='text' style='width:20ex;' name='<?=$amzaff_nl_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_nl' placeholder='locallinks-20' value='<?=$amzaff_nl_opt_val;?>'> <label for='locallinks_amzaff_nl'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.ae: <input type='text' style='width:20ex;' name='<?=$amzaff_ae_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_ae' placeholder='locallinks-20' value='<?=$amzaff_ae_opt_val;?>'> <label for='locallinks_amzaff_ae'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.sg: <input type='text' style='width:20ex;' name='<?=$amzaff_sg_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_sg' placeholder='locallinks-20' value='<?=$amzaff_sg_opt_val;?>'> <label for='locallinks_amzaff_sg'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.sa: <input type='text' style='width:20ex;' name='<?=$amzaff_sa_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_sa' placeholder='locallinks-20' value='<?=$amzaff_sa_opt_val;?>'> <label for='locallinks_amzaff_sa'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.com.tr: <input type='text' style='width:20ex;' name='<?=$amzaff_tr_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_tr' placeholder='locallinks-20' value='<?=$amzaff_tr_opt_val;?>'> <label for='locallinks_amzaff_tr'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.se: <input type='text' style='width:20ex;' name='<?=$amzaff_se_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_se' placeholder='locallinks-20' value='<?=$amzaff_se_opt_val;?>'> <label for='locallinks_amzaff_se'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Amazon.pl: <input type='text' style='width:20ex;' name='<?=$amzaff_pl_data_field_name;?>' <?=$locallinks_geo;?> id='locallinks_amzaff_pl' placeholder='locallinks-20' value='<?=$amzaff_pl_opt_val;?>'> <label for='locallinks_amzaff_pl'>
	</div>

<?php
	// Other Affiliates
	echo '<h3>' . esc_html__('Other Affiliates', 'local-links') . '</h3>';
	echo '<p>';
	esc_html_e ("Add your other affiliate codes below for each vendor that you have one for. They will be added to that vendor's links.", 'local-links');
	echo '<br />';
	esc_html_e ("Note that affiliate codes will not be added if the vendor's localization is disabled above.", 'local-links');
	echo '</p>';
?>

	<p>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Apple: <input type='text' style='width:20ex;' name='<?=$aplaff_data_field_name;?>' id='locallinks_aplaff' placeholder='Apple code' value='<?=$locallinks_aplaff_opt_val;?>'> <label for='locallinks_aplaff'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Google: <input type='text' style='width:20ex;' name='<?=$googleaff_data_field_name;?>' id='locallinks_googleaff' placeholder='Google code' value='<?=$googleaff_opt_val;?>'> <label for='locallinks_googleaff'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Smashwords: <input type='text' style='width:20ex;' name='<?=$swaff_data_field_name;?>' id='locallinks_swaff' placeholder='Smashwords code' value='<?=$swaff_opt_val;?>'> <label for='locallinks_swaff'>
	</div>
	</p>

	<p>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Bookshop.org (USA): <input type='text' style='width:20ex;' name='<?=$bsorgusaff_data_field_name;?>' id='locallinks_bsorgusaff' placeholder='Bookshop.org code' value='<?=$bsorgusaff_opt_val;?>'> <label for='locallinks_bsorgusaff'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Bookshop.org (UK): <input type='text' style='width:20ex;' name='<?=$bsorgukaff_data_field_name;?>' id='locallinks_bsorgukaff' placeholder='Bookshop.org code' value='<?=$bsorgukaff_opt_val;?>'> <label for='locallinks_bsorgukaff'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Bookshop.org (es): <input type='text' style='width:20ex;' name='<?=$bsorgesaff_data_field_name;?>' id='locallinks_bsorgesaff' placeholder='Bookshop.org code' value='<?=$bsorgesaff_opt_val;?>'> <label for='locallinks_bsorgesaff'>
	</div>
	</p>

	<p>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		OneBookShelf: <input type='text' style='width:20ex;' name='<?=$obsaff_data_field_name;?>' id='locallinks_obsaff' placeholder='OneBookShelf code' value='<?=$obsaff_opt_val;?>'> <label for='locallinks_obsaff'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		OneBookShelf <a href='https://www.drivethrufiction.com/pub/sales_sources.php' target='_blank'>src</a> parameter: <input type='text' style='width:20ex;' name='<?=$obssrc_data_field_name;?>' id='locallinks_obssrc' placeholder='website' value='<?=urldecode($obssrc_opt_val);?>'> <label for='locallinks_obssrc'>
	</div>
	</p>

	<p>
	Kobo requires an id and an mid. <a href="https://pubhelp.rakutenmarketing.com/hc/en-us/articles/201105906-Deep-Linking-Structure-Creating-Tracking-Links-Outside-the-Publisher-Dashboard" target="_blank">This FAQ item</a> explains how to find them.
	</p>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Kobo id: <input type='text' style='width:20ex;' name='<?=$koboid_data_field_name;?>' id='locallinks_koboid' placeholder='Kobo id' value='<?=$koboid_opt_val;?>'> <label for='locallinks_koboid'>
	</div>
	<div style='border:none; display:inline-block; padding:1ex; margin:1ex;'>
		Kobo mid: <input type='text' style='width:20ex;' name='<?=$kobomid_data_field_name;?>' id='locallinks_kobomid' placeholder='Kobo mid' value='<?=$kobomid_opt_val;?>'> <label for='locallinks_kobomid'>
	</div>

	<p class='submit'>
<?php
	// Add a nonce to the form [https://developer.wordpress.org/apis/security/nonces/]
	wp_nonce_field('local_links_update_nonce');
	echo '<input type="submit" name="Submit" class="button-primary" value="' . esc_html__('Save Changes', 'local-links') . '" />';
?>
	</p>
	</form>

<?php
	if ($locallinks_geo == 'disabled') {
		echo '<p>';
		esc_html_e ('Amazon affiliates and some links require the', 'local-links');
		echo ' <a href="https://wordpress.org/plugins/geoip-detect/" target="_blank">';
		esc_html_e ('GeoIP Detection');
		echo '</a> ';
		esc_html_e ('plugin.', 'local-links');
		echo '</p>';
	}
?>

	</div>
<?php
}
