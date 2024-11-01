=== Plugin Name ===
Contributors: tuyenlaptrinh
Donate link: https://www.patreon.com/bePatron?c=954317
Tags: imdb, imdb-api, movie
Requires at least: 3.0.1
Tested up to: 4.7
Stable tag: 1.2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
Here is a short description of the plugin.  This should be no more than 150 characters.  No markup here.
 
== Description ==
 
The IMDb API is a RESTful web service to obtain movie information, all content and images on the site are contributed and maintained by our users.

 
== Installation ==

1. Upload `wp-imdb-api.zip` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place
`$imdb = new IMDbapi();`
`$data = $imdb->get('tt0004614','json');`
in your templates
4. [Click here](http://imdbapi.net/user/api "Generate new API") to generate new API (require login)

== Screenshots ==
 
1. /assets/screenshot-1.png
1. /assets/screenshot-2.png
1. /assets/screenshot-3.png
1. /assets/screenshot-4.png
 
== Changelog ==
= 1.2.0 =
* Update search by title
= 1.1.0 =
* Add metabox for post and page action
* Store Inforamtion In “wp_postmeta” Wp Table.
* Store posters into wordpress upload directory.
* redesign ui.
* Ajax search
* Search results are now editable
* Uploading poster automatically via url.
= 1.0 =
* Start new plugin