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

function locallinks_init () {
	// Version for JS files. Set to current timestamp so that they will not be cached
	$version = time();

	// Default values
	$locallinks_amztld = 'com';
	$locallinks_alibtld = 'com';
	$locallinks_abedomain = 'abebooks.com';
	$locallinks_amzaff = '';
	$locallinks_aplaff = '';
	$locallinks_googleaff = '';
	$locallinks_koboid = '';
	$locallinks_kobomid = '';
	$locallinks_bsorgusaff_opt_val = '';
	$locallinks_bsorgukaff_opt_val = '';
	$locallinks_obsaff_opt_val = '';
	$locallinks_obssrc_opt_val = '';
	$locallinks_swaff_opt_val = '';

	// Read in existing option values from database
	$locallinks_amazon_opt_val = get_option('locallinks_amazon');
	$locallinks_apple_opt_val = get_option('locallinks_apple');
	$locallinks_kobo_opt_val = get_option('locallinks_kobo');
	$locallinks_alibris_opt_val = get_option('locallinks_alib');
	$locallinks_google_opt_val = get_option('locallinks_google');
	$locallinks_abe_opt_val = get_option('locallinks_abe');
	$locallinks_bsorg_opt_val = get_option('locallinks_bsorg');
	$locallinks_obs_opt_val = get_option('locallinks_obs');
	$locallinks_sw_opt_val = get_option('locallinks_sw');

	// Other affiliates
	$locallinks_aplaff_opt_val = get_option('locallinks_aplaff');
	$locallinks_googleaff_opt_val = get_option('locallinks_googleaff');
	$locallinks_swaff_opt_val = get_option('locallinks_swaff');

	// Kobo
	$locallinks_koboid_opt_val = get_option('locallinks_koboid');
	$locallinks_kobomid_opt_val = get_option('locallinks_kobomid');

	// Bookshop.org
	$locallinks_bsorgusaff_opt_val = get_option('locallinks_bsorgusaff');
	$locallinks_bsorgukaff_opt_val = get_option('locallinks_bsorgukaff');
	$locallinks_bsorgesaff_opt_val = get_option('locallinks_bsorgesaff');

	// OBS
	$locallinks_obsaff_opt_val = get_option('locallinks_obsaff');
	$locallinks_obssrc_opt_val = get_option('locallinks_obssrc');

	// Amazon country TLDs. Key is country code, value is TLD
	$locallinks_Amazon_domains = array (
		'ae' => 'ae',
		'au' => 'com.au',
		'br' => 'com.br',
		'ca' => 'ca',
		'cn' => 'cn',
		'de' => 'de',
		'es' => 'es',
		'fr' => 'fr',
		'ie' => 'co.uk', // Ireland users buy from Amazon UK
		'in' => 'in',
		'it' => 'it',
		'jp' => 'co.jp',
		'mx' => 'com.mx',
		'nl' => 'nl',
		'nz' => 'com.au', // New Zealand users buy from Amazon Australia
		'pl' => 'pl',
		'sa' => 'sa',
		'se' => 'se',
		'sg' => 'sg',
		'tr' => 'com.tr',
		'uk' => 'co.uk',
		'us' => 'com',
	);

	// Apple country TLDs. Key is ISO country code, value is Apple country code
	$locallinks_Apple_countrycodes = array (
		'ar' => 'ar',
		'at' => 'at',
		'au' => 'au',
		'be' => 'be',
		'bg' => 'bg',
		'bo' => 'bo',
		'br' => 'br',
		'ca' => 'ca',
		'ch' => 'ch',
		'cl' => 'cl',
		'co' => 'co',
		'cr' => 'cr',
		'cy' => 'cy',
		'cz' => 'cz',
		'de' => 'de',
		'dk' => 'dk',
		'do' => 'do',
		'ec' => 'ec',
		'ee' => 'ee',
		'es' => 'es',
		'fi' => 'fi',
		'fr' => 'fr',
		'gr' => 'gr',
		'gt' => 'gt',
		'hn' => 'hn',
		'hu' => 'hu',
		'ie' => 'ie',
		'it' => 'it',
		'jp' => 'jp',
		'lt' => 'lt',
		'lu' => 'lu',
		'lv' => 'lv',
		'mt' => 'mt',
		'mx' => 'mx',
		'ni' => 'ni',
		'nl' => 'nl',
		'no' => 'no',
		'nz' => 'nz',
		'pa' => 'pa',
		'pe' => 'pe',
		'pl' => 'pl',
		'pt' => 'pt',
		'py' => 'py',
		'ro' => 'ro',
		'se' => 'se',
		'si' => 'si',
		'sk' => 'sk',
		'sv' => 'sv',
		'uk' => 'gb',
		'us' => 'us',
		've' => 've',
	);

	// Alibris country TLDs. Key is country code, value is TLD
	$locallinks_Alibris_domains = array (
		'uk' => 'co.uk',
		'us' => 'com',
	);

	// AbeBooks country sites. Key is country code, value is full domain name
	$locallinks_Abe_domains = array (
		'uk' => 'abebooks.co.uk',
		'us' => 'abebooks.com',
		'de' => 'abebooks.de',
		'fr' => 'abebooks.fr',
		'it' => 'abebooks.it',
		'es' => 'iberlibro.com',
		'ca' => 'abebooks.ca',
		'au' => 'abebooks.com/books/ANZ',
		'nz' => 'abebooks.com/books/ANZ',
	);
	// Bookshop.org country sites. Key is country code, value is full domain name
	$locallinks_bsorg_domains = array (
		'es' => 'es.bookshop.org',
		'uk' => 'uk.bookshop.org',
		'us' => 'bookshop.org',
	);

	// Get the user's country code (lower case)
	if (function_exists ('geoip_detect2_get_info_from_current_ip')) {
		$geo_info = geoip_detect2_get_info_from_current_ip();
		$locallinks_cc = strtolower($geo_info->country->isoCode);
	}
	else {
		// GeoIP plugin is not installed. Set CC to US
		$locallinks_cc = 'us';
	}
	// Check for locallinks_cc GET parameter and override GeoIP
	if (isset ($_GET['locallinks_cc']) && $_GET['locallinks_cc'] != '')
		$locallinks_cc = strtolower($_GET['locallinks_cc']);

	// Ensure UK uses uk, not gb
	if ($locallinks_cc == 'gb')
		$locallinks_cc = 'uk';

	// Get relevant Amazon domain and affiliate code, store them in variables
	if (array_key_exists ($locallinks_cc, $locallinks_Amazon_domains)) {
		// Country has an Amazon store
		$locallinks_amztld = $locallinks_Amazon_domains[$locallinks_cc];
		$locallinks_amzaff = get_option('locallinks_' . $locallinks_cc);
	}
	else {
		// Default to US store
		$locallinks_amztld = 'com';
		$locallinks_amzaff = get_option('locallinks_us');
	}

	// Get relevant Apple country code
	if (array_key_exists ($locallinks_cc, $locallinks_Apple_countrycodes))
		$locallinks_aplcc = $locallinks_Apple_countrycodes[$locallinks_cc];
	else
		// Default to US store
		$locallinks_aplcc = 'us';

	// Set Alibris TLD. Default to US
	if (array_key_exists ($locallinks_cc, $locallinks_Alibris_domains))
		$locallinks_alibtld = $locallinks_Alibris_domains[$locallinks_cc];
	else
		$locallinks_alibtld = 'com';

	// Set AbeBooks domain. Default to US
	if (array_key_exists ($locallinks_cc, $locallinks_Abe_domains))
		$locallinks_abedomain = $locallinks_Abe_domains[$locallinks_cc];
	else
		$locallinks_abedomain = 'abebooks.com';

	// Set Bookshop.org domain. Default to US
	if (array_key_exists ($locallinks_cc, $locallinks_bsorg_domains)) {
		$locallinks_bsorgdomain = $locallinks_bsorg_domains[$locallinks_cc];
		$locallinks_bsorgaff = get_option('locallinks_bsorg' . $locallinks_cc . 'aff');
	}
	else {
		$locallinks_bsorgdomain = 'bookshop.org';
		$locallinks_bsorgaff = get_option('locallinks_bsorgusaff');
	}

	// Set up array to pass to JavaScript
	$locallinks_jsarray = array (
		'amz' => $locallinks_amazon_opt_val,
		'apl' => $locallinks_apple_opt_val,
		'kobo' => $locallinks_kobo_opt_val,
		'alib' => $locallinks_alibris_opt_val,
		'google' => $locallinks_google_opt_val,
		'abe' => $locallinks_abe_opt_val,
		'bsorg' => $locallinks_bsorg_opt_val,
		'obs' => $locallinks_obs_opt_val,
		'sw' => $locallinks_sw_opt_val,

		'amztld' => $locallinks_amztld,
		'aplcc' => $locallinks_aplcc,
		'alibtld' => $locallinks_alibtld,
		'abedomain' => $locallinks_abedomain,
		'bsorgdomain' => $locallinks_bsorgdomain,

		'amzaff' => filter_var($locallinks_amzaff, FILTER_SANITIZE_ENCODED),
		'aplaff' => filter_var($locallinks_aplaff_opt_val, FILTER_SANITIZE_ENCODED),
		'googleaff' => filter_var($locallinks_googleaff_opt_val, FILTER_SANITIZE_ENCODED),
		'koboid' => filter_var($locallinks_koboid_opt_val, FILTER_SANITIZE_ENCODED),
		'kobomid' => filter_var($locallinks_kobomid_opt_val, FILTER_SANITIZE_ENCODED),
		'bsorgaff' => filter_var($locallinks_bsorgaff, FILTER_SANITIZE_ENCODED),
		'obsaff' => filter_var($locallinks_obsaff_opt_val, FILTER_SANITIZE_ENCODED),
		'obssrc' => filter_var($locallinks_obssrc_opt_val, FILTER_SANITIZE_ENCODED),
		'swaff' => filter_var($locallinks_swaff_opt_val, FILTER_SANITIZE_ENCODED),
	);

	// Sources. No longer using minified JavaScript because it caused issues with Amazon author pages.
	$js_source = plugin_dir_url(__FILE__) . 'replacelinks.js';
	$tr_source = plugin_dir_url(__FILE__) . 'languages';

	// Register the JavaScript
	wp_register_script('locallinks_js', $js_source, array('jquery', 'wp-i18n'), $version, True);

	// Make the $locallinks_jsarray array available to the JavaScript
	wp_localize_script('locallinks_js', 'locallinks_opts', $locallinks_jsarray);

	// Enqueue the JavaScript
	wp_enqueue_script('locallinks_js', $js_source, array('jquery', 'wp-i18n'), $version, True);
	wp_set_script_translations('locallinks_js', 'local-links', $tr_source);
}

// Enqueue the JavaScript - only in main area, not admin area
if (!is_admin())
	add_action('wp_enqueue_scripts', 'locallinks_init');
