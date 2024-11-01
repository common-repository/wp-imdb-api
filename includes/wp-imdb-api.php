<?php

/**
 * Created by PhpStorm.
 * User: Tuyen Pham
 * Date: 5/31/2017
 * Time: 6:43 PM
 */
class WP_IMDb_api
{
    protected $plugin_name;
    protected $version;
    protected $loader;
    public function __construct()
    {
        $this->version = '1.0.1';
        $this->plugin_name = 'wp_imdb_api';

        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
    }

    public function imdbapi_activation_redirect( $plugin ) {
        if( $plugin == plugin_basename( __FILE__ ) ) {
            exit( wp_redirect( admin_url( 'admin.php?page=imdbapi' ) ) );
        }
    }
    private function load_dependencies(){
        /**
         * Crawler source class (imdbapi.net)
         */
        require_once plugin_dir_path(dirname( __FILE__ )).'includes/IMDbapi.class.php';
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-imdb-api-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-imdb-api-i18n.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/wp-imdb-api-admin.php';

        $this->loader = new WP_IMDb_api_loader();
    }

    private function set_locale() {

        $plugin_i18n = new WP_IMdb_api_i18n();

        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

    }
    private function define_admin_hooks() {

        $options = get_option($this->plugin_name);

        $plugin_admin = new WP_IMDb_api_admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

        // Add menu item
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'wp_imdb_api_admin_menu' );
        // register our imdbapi_settings_init to the admin_init action hook
        $this->loader->add_action( 'admin_init', $plugin_admin,'imdbapi_settings_init' );

        // Add settings link to the plugin
        $plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );
//
//        // Add post metabox setup
        $this->loader->add_action( 'load-post.php', $plugin_admin, 'wp_imdb_api_post_metabox_setup' );
        $this->loader->add_action( 'load-post-new.php', $plugin_admin, 'wp_imdb_api_post_metabox_setup' );
//
//        // initialize crawler function to listening into incomming data
        $this->loader->add_action('admin_init', $plugin_admin, 'wp_imdb_api_run_crawler');
//
        if($options['imdbapi_field_download_posters'] == '1'){
            // upload poster via url
            $this->loader->add_action('admin_init', $plugin_admin, 'wp_imdb_api_save_poster');
        }

    }
    public function run() {
        $this->loader->run();
    }

    public function get_plugin_name() {
        return $this->plugin_name;
    }

    public function get_loader() {
        return $this->loader;
    }

    public function get_version() {
        return $this->version;
    }
}