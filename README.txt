=== Plugin Name ===
Contributors: Joe Kneeland
Donate link: htts://wpcolr.com
Tags: colors, color scheme, dark mode
Requires at least: 5.9
Tested up to: 5.9.3
Stable tag: 5.9
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Gives users a method to control their personal color theme on your site, with precise customizations on the frontend.

== Description ==

Simply add the shortcode on a members only page and your members will be able to use the color picker to set color for site header, background, links, text, borders, etc.

== Installation ==

1. Upload the plugin through the 'Plugins' menu in WordPress
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place the shortcode [colr_picker] in a members only page
4. Map your themes classes to the colr array at admin > settings > colr schemes

== Frequently Asked Questions ==

= How does it work? =

Color schemes are saved in the database table '_colr'
User sets their colr scheme id, this is stored as user metadata.
The 'wp_head' hook is then utilized to process this into inline css.

== Screenshots ==

== Changelog ==

== Upgrade Notice ==

== Arbitrary section ==
