=== NR Infinite Scroll Posts ===
Contributors: (this should be a list of wordpress.org userid's)
Donate link: http://nrtechwebsolution.com
Tags: AJAX, Custom Post Type, Shortcode, Scroll Pagination
Requires at least: 4.6
Tested up to: 4.7
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Nr Infinite Scroll Posts plugin is for displaying post or custom post type posts with control.
There is shortcode that will help to display posts on page scroll down.

Shortcode :
[NR_INIFINITE_SCROLL]
You can use this shortcode in any page Or
You can directly call in php file using 
 do_shortcode('[NR_INIFINITE_SCROLL]');

Shortcode Parameters :

post_type="Custom Post Type"  Or Default post
posts_per_page =number of post in integer or Default 5 posts per page
author_label = 'true' or 'false' default value is true
comments_label = 'true' or 'false' default value is true
date_label = 'true' or 'false' default value is true
So here is the complate shortcode with all parameters.

[NR_INIFINITE_SCROLL post_type="post" posts_per_page='10' author_label='true' comments_label='true' date_label='true' ]



