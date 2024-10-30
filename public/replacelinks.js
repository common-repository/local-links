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

/*
JavaScript to rewrite links
locallinks_opts array is passed from PHP. Elements:
	'amz' => Amazon (0/1)
	'apl' => Apple (0/1)
	'kobo' => Kobo (0/1)
	'alib' => Alibris (0/1)
	'google' => Google (0/1)
	'abe' => AbeBooks (0/1)
	'bsorg' => Bookshop.org (0/1)
	'obs' => OneBookShelf (0/1)
	'sw' => Smashwords (0/1)

	'amztld' => Amazon TLD
	'aplcc' => Apple CC for Apple Books
	'alibtld' => Alibris TLD
	'abedomain' => AbeBooks domain
	'bsorgdomain' = >Bookshop.org domain

	'amzaff' => Amazon affiliate code for the current country
	'aplaff' => Apple affiliate code
	'googleaff' => Google affiliate code
	'koboid' => Kobo affiliate id
	'kobomid' => Kobo affiliate mid
	'bsorgaff' => Bookshop.org affiliate code for the current country
	'obsaff' => OneBookShelf affiliate code
	'obssrc' => OneBookShelf src parameter
	'swaff' => Smashwords affiliate code
*/

jQuery(document).ready(function() {
	const { __, _x, _n, sprintf } = wp.i18n

	// Regular expressions to find relevant links
	locallinks_reAmazon = new RegExp (/https?:\/\/(smile\.|w{3}\.)?amazon\.[^/]+.*/i)
	locallinks_reApple = new RegExp (/https?:\/\/.*itunes\.apple\.com.*/i)
	locallinks_reAppleBooks = new RegExp (/https?:\/\/books\.apple\.com.*/i)
	locallinks_reKobo = new RegExp (/https?:\/\/(w{3}\.)?kobo(books)?\.com\/[a-z]{2}\/[a-z]{2}.*/i)
	locallinks_reKobo = new RegExp (/https?:\/\/(w{3}\.)?kobo(books)?\.com.*/i)
	locallinks_reAlibris = new RegExp (/https?:\/\/(w{3}.)?alibris\./i)
	locallinks_reGoogle = new RegExp (/https?:\/\/(w{3}.)?play\.google\.com/i)
	locallinks_reAbe = new RegExp (/https?:\/\/(w{3}.)?abebooks\.[^/]+.*/i)
	locallinks_reBN = new RegExp (/https?:\/\/(w{3}.)?barnesandnoble\.com/i)
	locallinks_reBSorg = new RegExp (/https?:\/\/([a-z]{2}\.)?bookshop\.org/i)
	locallinks_reOBS = new RegExp (/https?:\/\/(w{3}\.)(drivethru[a-z]{3,7}|wargamevault)\.com.*/i)
	locallinks_reSW = new RegExp (/https?:\/\/(w{3}\.)smashwords\.com.*/i)

	// Loop through links
	jQuery('a').each(function() {

		// Initialise variables
		locallinks_url = ''
		locallinks_aff = false
		locallinks_title = ''

		// Get the URL
		try {
			locallinks_url = new URL(jQuery(this).attr('href'))
			if (jQuery(this)[0].hasAttribute ('title'))
				locallinks_title = jQuery(this).attr('title')

			// Remove Facebook fbclid GET parameter on all links
			if (locallinks_url.searchParams.has('fbclid')) {
				locallinks_url.searchParams.delete('fbclid')
				jQuery(this).attr('href', locallinks_url.toString())
			}

			// Remove Google gclid GET parameter on all links
			if (locallinks_url.searchParams.has('gclid')) {
				locallinks_url.searchParams.delete('gclid')
				jQuery(this).attr('href', locallinks_url.toString())
			}

			// Test for an Amazon link
			if (locallinks_opts['amz'] == '1') {
				if (locallinks_reAmazon.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy on Amazon', 'local-links')

					// Check if it is an author page link
					if (jQuery(this).attr('href').search ('/author/') != -1) {
						// Author link. Just replace country code and strip GET parameters
						locallinks_sAmazon = jQuery(this).attr('href').replace(/(\/.*amazon.)[a-zA-Z.]+\/([^?]+).*/, '$1' + locallinks_opts['amztld'] + '/$2')
					}
					else {
						// Not an author link. Build new URL
						locallinks_sAmazon = 'https://www.amazon.' +
							locallinks_opts['amztld'] +
							locallinks_url.pathname.replace(/\/.*\/([A-Z0-9]{10}).*$/i, '/dp/$1')
					}

					// Add Amazon affiliate code if one has been set for this country
					if (locallinks_opts['amzaff'] != '') {
						if (/\?/.test(locallinks_sAmazon) === false)
							locallinks_sAmazon += '?'
						else
							locallinks_sAmazon += '&'
						locallinks_sAmazon += 'tag=' + locallinks_opts['amzaff']
						locallinks_aff = true
					}

					// If Amazon attribution tagging was included in original URL, re-add it
					var locallinks_params = new URLSearchParams(locallinks_url.search)
					if (locallinks_params.has ('maas'))
						locallinks_maas = locallinks_params.get('maas')
					else
						locallinks_maas = ''
					if (locallinks_params.has ('ref_'))
						locallinks_ref = locallinks_params.get('ref_')
					else
						locallinks_ref = ''
					if (locallinks_maas != '' && locallinks_ref != '') {
						if (/\?/.test(locallinks_sAmazon) === false)
							locallinks_sAmazon += '?'
						else
							locallinks_sAmazon += '&'
						locallinks_sAmazon += 'maas=' + locallinks_maas + '&ref_=' + locallinks_ref
					}

					// Replace the link's href attribute
					jQuery(this).attr('href', locallinks_sAmazon)
				}
			}

			// Test for an Apple link
			if (locallinks_opts['apl'] == '1') {
				// iTunes
				if (locallinks_reApple.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy at Apple', 'local-links')

					// Build new URL
					locallinks_sApple = 'https://geo.itunes.apple.com' +
						locallinks_url.pathname

					// Add Apple affiliate code if one has been set
					if (locallinks_opts['aplaff'] != '') {
						if (/\?/.test(locallinks_sApple) === false)
							locallinks_sApple += '?'
						else
							locallinks_sApple += '&amp;'
						locallinks_sApple += 'at=' + locallinks_opts['aplaff']
						locallinks_aff = true
					}

					// Replace the link's href attribute
					jQuery(this).attr('href', locallinks_sApple)
				}

				// Apple Books
				if (locallinks_reAppleBooks.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy at Apple Books', 'local-links')

					// Set up path, starting with the country code
					locallinks_sApplePath = '/' + locallinks_opts['aplcc']
					// Add the rest of the path
					locallinks_sApplePath += locallinks_url.pathname.replace(/\/[a-z][a-z]\/(audio)?book\//i, '/$1book/')
					// Build new URL
					locallinks_sApple = 'https://books.apple.com' +
						locallinks_sApplePath

					// Add Apple affiliate code if one has been set
					if (locallinks_opts['aplaff'] != '') {
						if (/\?/.test(locallinks_sApple) === false)
							locallinks_sApple += '?'
						else
							locallinks_sApple += '&'
						locallinks_sApple += 'at=' + locallinks_opts['aplaff']
						locallinks_aff = true
					}

					// Replace the link's href attribute
					jQuery(this).attr('href', locallinks_sApple)
				}
			}

			// Test for a Kobo link
			if (locallinks_opts['kobo'] == '1') {
				if (locallinks_reKobo.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy at Kobo', 'local-links')

					// Remove country & language from pathname
					locallinks_kobopath = locallinks_url.pathname.replace(/\/[a-z]{2}\/[a-z]{2}/i, '')
					// Build URL
					locallinks_sKobo = 'https://www.kobo.com' +
						locallinks_kobopath +
						locallinks_url.search
					// Set up affiliate link if id and mid set
					if (locallinks_opts['koboid'] != '' && locallinks_opts['kobomid'] != '') {
						locallinks_sKobo = 'https://click.linksynergy.com/deeplink?murl=' +
							encodeURIComponent (locallinks_sKobo) +
							'&id=' + locallinks_opts['koboid'] +
							'&mid=' + locallinks_opts['kobomid']
						locallinks_aff = true
					}

					// Replace the link's href attribute
					jQuery(this).attr('href', locallinks_sKobo)
				}
			}

			// Test for an Alibris link
			if (locallinks_opts['alib'] == '1') {
				if (locallinks_reAlibris.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy at Alibris', 'local-links')

					// Build new URL
					locallinks_sAlibris = 'https://www.alibris.' +
						locallinks_opts['alibtld'] +
						locallinks_url.pathname

					// Replace the link's href attribute
					jQuery(this).attr('href', locallinks_sAlibris)
				}
			}

			// Test for a Google link
			if (locallinks_opts['google'] == '1') {
				if (locallinks_reGoogle.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy at Google', 'local-links')

					// Build new URL
					locallinks_sGoogle = locallinks_url.protocol + '//' +
						locallinks_url.hostname +
						locallinks_url.pathname +
						'?id=' +
						locallinks_url.searchParams.get('id')

					// Add Google affiliate code if one has been set
					if (locallinks_opts['googleaff'] != '') {
						if (/\?/.test(locallinks_sGoogle) === false)
							locallinks_sGoogle += '?'
						else
							locallinks_sGoogle += '&'
						locallinks_sGoogle += 'PAffiliateID=' + locallinks_opts['googleaff']
						locallinks_aff = true
					}

					// Replace the link's href attribute
					jQuery(this).attr('href', locallinks_sGoogle)
				}
			}

			// Test for an AbeBooks link
			if (locallinks_opts['abe'] == '1') {
				if (locallinks_reAbe.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy at AbeBooks', 'local-links')

					// Build new URL
					locallinks_sAbe = locallinks_url.protocol + '//' +
						locallinks_opts['abedomain'] +
						locallinks_url.pathname
					if (locallinks_url.pathname.substring(1, 8) == 'servlet')
						locallinks_sAbe += '?bi=' + locallinks_url.searchParams.get('bi')
					// Replace the link's href attribute
					jQuery(this).attr('href', locallinks_sAbe)
				}
			}

			// Test for a Barnes & Noble link. Have to work on full URL, not just pathname, because B&N use extra parameters to separate editions
			if (locallinks_reBN.test (jQuery(this).attr('href')) == true) {
				// Set default title if none is set
				if (locallinks_title == '')
					locallinks_title = __('Buy at Barnes and Noble', 'local-links')

				// Remove jsessionid
				locallinks_sBN = jQuery(this).attr('href').replace(/;jsessionid=.*/i, '')
				// Replace the link's href attribute
				jQuery(this).attr('href', locallinks_sBN)
			}

			// Test for a Bookshop.org link
			if (locallinks_opts['bsorg'] == '1') {
				if (locallinks_reBSorg.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy at Bookshop.org', 'local-links')

					// Initialise replacement link
					locallinks_sBSorg = 'https://' + locallinks_opts['bsorgdomain']

					// Work out what type of link it is
					if (locallinks_url.pathname.substring(0, 7) == '/books/') {
						// Book link. Get ISBN
						isbn = locallinks_url.pathname.replace(/.*([0-9]{13}).*/, '$1')
						if (locallinks_opts['bsorgaff'] == '') {
							// No affiliate ID. Just replace the domain
							locallinks_sBSorg += locallinks_url.pathname
						}
						else {
							// Create affiliate link
							locallinks_sBSorg += '/a/' + locallinks_opts['bsorgaff'] + '/' + isbn
							locallinks_aff = true
						}
					}
					else if (locallinks_url.pathname.substring(0, 3) == '/a/') {
						// Affiliate link. Get ISBN
						isbn = locallinks_url.pathname.replace(/.*([0-9]{13}).*/, '$1')
						if (locallinks_opts['bsorgaff'] == '') {
							// No affiliate ID. Create search link
							locallinks_sBSorg += '/books?keywords=' + isbn
						}
						else {
							// Create affiliate link
							locallinks_sBSorg += '/a/' + locallinks_opts['bsorgaff'] + '/' + isbn
							locallinks_aff = true
						}
					}
					else if (locallinks_url.pathname.substring(0, 7) == '/lists/') {
						// Lists are country-specific, so just go to the link
						locallinks_sBSorg = locallinks_url.href
					}
					else if (locallinks_url.pathname.substring(0, 6) == '/shop/') {
						// Shops are country-specific, so just go to the link
						locallinks_sBSorg = locallinks_url.href
					}
					else {
						// Store locator, home page, etc. Just replace domain
						locallinks_sBSorg += locallinks_url.pathname
					}

					// Replace the link's href attribute
					jQuery(this).attr('href', locallinks_sBSorg)
				}
			}

			// Test for a OneBookShelf link
			if (locallinks_opts['obs'] == '1') {
				if (locallinks_reOBS.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy at OneBookShelf', 'local-links')

					// Initialise URL and query
					locallinks_sOBS = locallinks_url.origin + locallinks_url.pathname
					locallinks_obsquery = '?'

					if (locallinks_opts['obsaff'] != '') {
						locallinks_obsquery += 'affiliate_id=' + encodeURIComponent(locallinks_opts['obsaff'])
						locallinks_aff = true
					}
					if (locallinks_opts['obsaff'] != '' && locallinks_opts['obssrc'] != '')
						locallinks_obsquery += '&'
					if (locallinks_opts['obssrc'] != '')
						locallinks_obsquery += 'src=' + encodeURIComponent(locallinks_opts['obssrc'])

					// Replace the link's href attribute
					locallinks_sOBS += locallinks_obsquery
					jQuery(this).attr('href', locallinks_sOBS)
				}
			}

			// Test for a Smashwords link
			if (locallinks_opts['sw'] == '1') {
				if (locallinks_reSW.test (jQuery(this).attr('href')) == true) {
					// Set default title if none is set
					if (locallinks_title == '')
						locallinks_title = __('Buy at Smashwords', 'local-links')

					// Initialise URL and query
					locallinks_sSW = locallinks_url.origin + locallinks_url.pathname
					locallinks_swquery = ''

					if (locallinks_opts['swaff'] != '') {
						locallinks_swquery = '?ref=' + encodeURIComponent(locallinks_opts['swaff'])
						locallinks_aff = true
					}

					// Replace the link's href attribute
					locallinks_sSW += locallinks_swquery
					jQuery(this).attr('href', locallinks_sSW)
				}
			}

			// Replace the link's title attribute
			if (locallinks_aff) {
				if (locallinks_title != '')
					locallinks_title += __(' (affiliate link)', 'local-links')
				else
					locallinks_title = __('Affiliate link', 'local-links')
			}
			if (locallinks_title != '')
				jQuery(this).attr('title', locallinks_title)
		}
		catch (err) {
			// Uncomment next line for debugging
			// console.log (err)
		}
		finally {
			// Ensure locallinks_url is empty
			locallinks_url = ''
		}
	})
})
