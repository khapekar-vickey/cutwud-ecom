=== WP Reel ===
Contributors: altert
Tags: gallery, 3d, 360, slideshow, reel, JQuery, animation, panorama
Donate link: http://altert.net/demo/donate/
Requires at least: 4.0.0
Tested up to: 4.8.1
Stable tag: 1.0
License: MIT License
License URI: http://altert.net/MIT-LICENSE.txt

Create interactive 360° object movie, panorama or stop-motion animation from wordpress gallery.


== Description ==
WP Reel is an implementation of [JQuery Reel 360 Javascript player](http://jquery.vostrel.cz/reel/) by [Petr Vostřel](http://petr.vostrel.cz).

It allows to create interactive 360° object movie, panorama or stop-motion animation from wordpress gallery.

You can see [live demo here](http://altert.net/demo/wp-reel-demo/)

It follows MIT license that is used for JQuery Reel, so feel free to download, modify and work on it. 

== Installation ==
Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page. 

To replace wordpress gallery with reel you need to add reel="1" to gallery shortcode. You can also use other shortcode parameters to set JQuery Reel parameters (for parameters description see [http://jquery.vostrel.cz/reel#syntax](http://jquery.vostrel.cz/reel#syntax)) You can also use Media options to replace all galleries with reel gallery. 

== Screenshots ==

1. Options for WP Reel (found in Media options). You can choose to replace all wordpress media galleries on site and set default speed (0 means no animation without user interaction)
2. Options for single gallery. Reel="1" replaces gallery with reel gallery if above option was not chosen, other parameters conform to JQuery Reel parameters (see [http://jquery.vostrel.cz/reel#syntax](http://jquery.vostrel.cz/reel#syntax)


== Frequently Asked Questions ==

= How to quickly add 360 rotating object to my site =

Create gallery in your post or page containing frames for rotation and add reel="1" to gallery shortcode.

= How to quickly add panorama to my site =

Add gallery with just one image, in that case WP Reel assumes it's panorama, and add width and height parameters to shortcode, defining visible window of panorama.

= How to replace all galleries with reel gallery? =

Use WP Reel Options section in Settings => Media.

= How to replace specific gallery with reel gallery? =

To replace wordpress gallery with reel you need to add reel="1" to gallery shortcode.

= Are other JQuery.reel options supported =

Yes, just add them to gallery shortcode, e.g. speed="0.4".

= How default width and height are determined =

By default width and height of first frame are used.


== Changelog ==

= 1.0 =
* Fix for initial position for stitched panoramas

= 0.9 =
* Add internationalization, russian language

= 0.8 =
* Initial release
