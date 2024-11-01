<?php
/**
 * Plugin Name: IMDb API
 * Plugin URI: http://imdbapi.net
 * Description: The IMDb API is a RESTful web service to obtain movie information, all content and images on the site are contributed and maintained by our users.
 * Version: 1.2.0
 * Author: Tuyen Pham
 * Author URI: http://tuyen.vn
 */
require plugin_dir_path( __FILE__ ) . 'includes/wp-imdb-api.php';
function run_wp_imdb_api() {

    $plugin = new WP_IMDb_api();
    $plugin->run();

}
run_wp_imdb_api();
?>