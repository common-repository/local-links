=== Local Links ===

Contributors: avantman42
Tags: link,links,url,urls,local,author,book,localise,localize,amazon,kobo
Requires at least: 6.0
Tested up to: 6.6.1
Requires PHP: 8.0
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Stable tag: trunk

Alter vendor links so that they go to the user's local store, and optionally add affiliate codes. Some functions require the GeoIP Detection plugin.

== Description ==

This plugin was originally written for authors, but may be useful for others that link to stores such as Amazon, Apple, and Kobo.

It will automatically edit links to various sites so that the user is directed to their local site. It will work on existing links and new ones. Simply add links to your site as usual, and they will be rewritten on the fly to send your visitors to their local site.

In addition, some tidying up of links is performed to remove extraneous junk. If you have affiliate codes, the relevant code will be added to that store's links.

Changes are only made in the user's browser. WordPress posts and pages are not changed, so if the plugin is deactivated or removed, they will return to their previous state.

Currently Supported Stores:

* Amazon
* Apple Books
* Apple iTunes (audiobooks)
* Kobo
* Alibris
* Google Play
* AbeBooks
* Barnes & Noble
* Bookshop.org
* OneBookShelf sites (DriveThruFiction, DriveThruCards, DriveThruComics, DriveThruRPG, Wargame Vault)
* Smashwords

The locallinks_cc GET parameter can be used for testing. For example, add ?locallinks_cc=fr to test plugin behaviour if the user is in France.

From version 4.1, Amazon Attribution links are supported. If a link has Amazon Attribution tags, they will be retained. For more information about Amazon Attribution, see: https://advertising.amazon.com/help?#GJXTJCLK4WTWTQWU

== Installation ==

Some vendors require the [GeoIP Detection plugin](https://wordpress.org/plugins/geoip-detect/). You may wish to install and configure that before continuing.

1. Upload the plugin zip file using WordPress' plugin installer, or install the plugin through the WordPress plugins screen directly (search for 'Local Links Robin Phillips')
1. Optionally install, activate, and configure the [GeoIP Detection plugin](https://wordpress.org/plugins/geoip-detect/)
1. Activate the plugin through the 'Plugins' screen in WordPress
1. Use the Settings->Local Links screen to select which vendor links should be localised

== Screenshots ==

1. The settings page

== Upgrade Notice ==

Minimum WordPress version is now 5.0

== Changelog ==

= v4.6 =

Bug fix for Amazon author pages

= v4.5 =

Amazon links now direct users in Ireland to Amazon UK

= v4.4 =

Amazon links now direct New Zealand users to Amazon Australia

= v4.3 =

Fixed Cross-Site Request Forgery bug that could lead to unauthorised plugin settings changes

= v4.2 =

Added support for Smashwords affiliate links

= v4.1 =

Added support for Amazon Attribution links. More on Amazon Attribution here: https://advertising.amazon.com/help?#GJXTJCLK4WTWTQWU

= v4.0 =

* Amazon links now always go to the local store. [More information](https://gitlab.com/robinphillips/local-links/-/wikis/Amazon-Links)
