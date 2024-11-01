<?php
/**
 * Created by PhpStorm.
 * User: Tuyen Pham
 * Date: 5/31/2017
 * Time: 6:56 PM
 */
class WP_IMDb_api_admin {
    private $plugin_name;
    private $version;
    public function __construct($plugin_name, $version)
    {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }
    public function enqueue_styles() {

        if( is_rtl() ){
            wp_enqueue_style( $this->plugin_name, plugin_dir_url( dirname(__FILE__) ) . 'admin/css/style-rtl.css', array(), $this->version, 'all' );
        }
        else{
            wp_enqueue_style( $this->plugin_name, plugin_dir_url( dirname(__FILE__) ) . 'admin/css/style.css', array(), $this->version, 'all' );
        }

    }
    public function enqueue_scripts() {
        wp_enqueue_script( $this->plugin_name, plugin_dir_url( dirname(__FILE__) ) . 'admin/js/wp-imdb-api.js', array( 'jquery' ), $this->version, false );

    }

    public function wp_imdb_api_admin_menu()
    {
        add_menu_page(
            __('IMDb api',$this->plugin_name),
            __('IMDb api',$this->plugin_name),
            'manage_options',
            $this->plugin_name,
            array($this,'imdbapi_options_page_html'),
            plugin_dir_url( dirname(__FILE__) ).'admin/img/icon.png'
        );

    }

    public function imdbapi_options_page_html()
    {
        include_once(plugin_dir_path( dirname( __FILE__ ) ) . 'admin/wp-imdb-api-view.php');
    }

    public function imdbapi_settings_init() {

        register_setting( $this->plugin_name, $this->plugin_name );

        add_settings_section('imdbapi_section_developers','',array($this,'imdbapi_section_developers_cb'),$this->plugin_name);

        add_settings_field(
            'imdbapi_field_apikey',
            __( 'Api key', $this->plugin_name ),
            array($this,'imdbapi_field_apikey_cb'),
            $this->plugin_name,
            'imdbapi_section_developers',
            [
                'label_for' => 'imdbapi_field_apikey',
                'class' => 'imdbapi_row',
                'imdbapi_custom_data' => 'custom',
            ]
        );
        add_settings_field(
            'imdbapi_field_active_metabox',
            __( 'Active Metabox', $this->plugin_name ),
            array($this,'imdbapi_field_active_metabox_cb'),
            $this->plugin_name,
            'imdbapi_section_developers',
            [
                'label_for' => 'imdbapi_field_active_metabox',
                'class' => 'imdbapi_row',
                'imdbapi_custom_data' => 'custom',
            ]
        );
        add_settings_field(
            'imdbapi_field_download_posters',
            __( 'Download Poster', $this->plugin_name ),
            array($this,'imdbapi_field_download_posters_cb'),
            $this->plugin_name,
            'imdbapi_section_developers',
            [
                'label_for' => 'imdbapi_field_download_posters',
                'class' => 'imdbapi_row',
                'imdbapi_custom_data' => 'custom',
            ]
        );
    }

    public function imdbapi_section_developers_cb()
    {

    }

    public function imdbapi_field_apikey_cb($args)
    {
        $options = get_option( $this->plugin_name );
        ?>
        <input size="50" type="text" value="<?php echo @$options[ $args['label_for'] ];?>" id="<?php echo esc_attr( $args['label_for'] ); ?>" data-custom="<?php echo esc_attr( $args['imdbapi_custom_data'] ); ?>" name="<?php echo $this->plugin_name;?>[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <p class="description">
            If you have not API key. Please <a href="http://imdbapi.net/register" target="_blank">create new</a> account and <a href="http://imdbapi.net/user/api" target="_blank">generate new API key</a>
        </p>
        <?php
    }

    public function imdbapi_field_active_metabox_cb($args)
    {
        $options = get_option( $this->plugin_name );
        ?>
        <fieldset><legend class="screen-reader-text"><span>Active Metabox</span></legend>
            <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
                <input<?php echo (@$options[ $args['label_for']] == 1)?' checked':'';?> name="<?php echo $this->plugin_name;?>[<?php echo esc_attr( $args['label_for'] ); ?>]" type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" value="1"  />&nbsp;Enable
            </label>
        </fieldset>
        <p class="description">
            Display metabox in Post/Page action
        </p>
        <?php
    }

    public function imdbapi_field_download_posters_cb($args)
    {
        $options = get_option( $this->plugin_name );
        ?>
        <fieldset><legend class="screen-reader-text"><span>Download Poster</span></legend>
            <label for="<?php echo esc_attr( $args['label_for'] ); ?>">
                <input<?php echo (@$options[ $args['label_for']] == 1)?' checked':'';?> name="<?php echo $this->plugin_name;?>[<?php echo esc_attr( $args['label_for'] ); ?>]" type="checkbox" id="<?php echo esc_attr( $args['label_for'] ); ?>" value="1"  />&nbsp;Enable
            </label>
        </fieldset>
        <?php
    }

    public function wp_imdb_api_post_metabox_setup(){

        /* Add meta boxes on the 'add_meta_boxes' hook. */
        add_action( 'add_meta_boxes', array($this,'wp_imdb_api_add_post_metabox') );

        /* Save post meta on the 'save_post' hook. */
        add_action( 'save_post', array($this,'wp_imdb_api_save_post_metabox'), 10, 2 );
    }

    public function wp_imdb_api_add_post_metabox(){
        $args = array(
            'public'   => true,
            '_builtin' => false
        );

        foreach ( get_post_types( $args, 'names' ) as $post_type ) {
            if($post_type != null){
                $post_types[] = $post_type;
            }
            else{
                break;
            }
        }

        if(isset($post_types)){
            array_push($post_types, 'post', 'page');
        }
        else{
            $post_types = array('post', 'page');
        }


        add_meta_box(
            'wp_imdb_api_metabox',
            esc_html__( 'Search movies and TV series', $this->plugin_name ),
            array($this,'wp_imdb_api_metabox_callback'),
            $post_types,
            'advanced',
            'default'
        );

    }

    public function wp_imdb_api_save_post_metabox($post_id, $post){

        /* Verify the nonce before proceeding. */
        if ( !isset( $_POST['wp_imdb_api_metabox_nonce'] ) || !wp_verify_nonce( $_POST['wp_imdb_api_metabox_nonce'], basename( __FILE__ ) ) )
            return $post_id;

        /* Get the post type object. */
        $post_type = get_post_type_object( $post->post_type );

        /* Check if the current user has permission to edit the post. */
        if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
            return $post_id;

        /* List of meta box fields (name => meta_key) */
        $fields = array(
            'imdbapi-id-value' => 'imdbapi_id',
            'imdbapi-title-value' => 'imdbapi_title',
            'imdbapi-year-value' => 'imdbapi_year',
            'imdbapi-type-value' => 'imdbapi_type',
            'imdbapi-poster-value' => 'imdbapi_poster',
            'imdbapi-budget-value' => 'imdbapi_budget',
            'imdbapi-gross-value' => 'imdbapi_gross',
            'imdbapi-imdbvotes-value' => 'imdbapi_imdbvotes',
            'imdbapi-imdbrating-value' => 'imdbapi_imdbrating',
            'imdbapi-metascore-value' => 'imdbapi_metascore',
            'imdbapi-actors-value' => 'imdbapi_actors',
            'imdbapi-writer-value' => 'imdbapi_writer',
            'imdbapi-director-value' => 'imdbapi_director',
            'imdbapi-runtime-value' => 'imdbapi_runtime',
            'imdbapi-released-value' => 'imdbapi_released',
            'imdbapi-rated-value' => 'imdbapi_rated',
            'imdbapi-plot-value' => 'imdbapi_plot',
            'imdbapi-language-value' => 'imdbapi_language',
            'imdbapi-country-value' => 'imdbapi_country',
            'imdbapi-genre-value' => 'imdbapi_genre'
        );

        foreach($fields as $name => $meta_key){

            /* Check if meta box fields has a proper value */
            if( isset($_POST[$name]) && $_POST[$name] != 'N/A' ){
                /* Set thumbnail */
                if($name == "imdbapi-poster-value"){
                    global $wpdb;
                    $image_src = $_POST[$name];
                    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
                    $attachment_id = $wpdb->get_var($query);
                    set_post_thumbnail($post_id, $attachment_id);
                }

                $new_meta_value = $_POST[$name];
            }
            else{
                $new_meta_value = '';
            }

            /* Get the meta value of the custom field key */
            $meta_value = get_post_meta($post_id, $meta_key, true);

            /* If a new meta value was added and there was no previous value, add it. */
            if ( $new_meta_value && '' == $meta_value )
                add_post_meta( $post_id, $meta_key, $new_meta_value, true );

            /* If the new meta value does not match the old value, update it. */
            elseif ( $new_meta_value && $new_meta_value != $meta_value )
                update_post_meta( $post_id, $meta_key, $new_meta_value );

            /* If there is no new meta value but an old value exists, delete it. */
            elseif ( '' == $new_meta_value && $meta_value )
                delete_post_meta( $post_id, $meta_key, $meta_value );

        }
    }

    public function wp_imdb_api_metabox_callback($object, $box){

        wp_nonce_field(basename( __FILE__ ), 'wp_imdb_api_metabox_nonce');

        include_once( plugin_dir_path(dirname( __FILE__ ) ). 'admin/wp-imdb-api-metabox-view.php' );
    }

    public function wp_imdb_api_run_crawler(){

        isset($_REQUEST['imdbQuery']) ? $query = urlencode($_REQUEST['imdbQuery']): $query = '';
        isset($_REQUEST['imdbYear']) ? $year = urlencode($_REQUEST['imdbYear']): $year = '';
        isset($_REQUEST['imdbID']) ? $imdbID = urlencode($_REQUEST['imdbID']): $imdbID = '';

        /* prevent leaking out data */
        if( !isset($_POST['action']) || $_POST['action'] != 'editpost' ){

            if( !empty($imdbID) ){
                $imdb = new IMDbapi();
                $data = $imdb->get($imdbID);
                $this->imdbapi_view('get', $data);
                die();
            }
            elseif ( !empty($query) ) {
                $imdb = new IMDbapi();
                $data = $imdb->search($query,$year);
                $this->imdbapi_view('search',$data);
                die();
            }

        }

    }

    public function imdbapi_view($type,$handle){
        include_once( plugin_dir_path(dirname( __FILE__ ) ). 'admin/wp-imdb-api-crawler-view.php' );
    }

    public function wp_imdb_api_save_poster(){

        isset($_REQUEST['poster_url']) ? $poster_url = $_REQUEST['poster_url']: $poster_url = NULL;

        global $wpdb;

        $wp_upload_dir = wp_upload_dir();

        if($poster_url !== NULL){

            // let's assume that poster already exist (uploaded once before).
            $file_name =  rtrim(basename($poster_url), '.jpg');

            //Searching
            $query = "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_title='$file_name'";
            $count = $wpdb->get_var($query);


            if($count == 0){

                /*
                * so poster wasn’t uploaded before.
                */

                $tmp = download_url($poster_url);

                $file_array = array(

                    "name" 		=> basename($poster_url),
                    "tmp_name"  => $tmp

                );

                //Check for download errors.

                if( is_wp_error($tmp) ){
                    @chown($file_array['tmp_name'],465);
                    @unlink( $file_array['tmp_name'] );
                    echo "something went wrong while downloading this file.";
                    //var_dump($tmp);
                    die();
                }

                $id = media_handle_sideload($file_array, 0);

                // Check for handle sideload errors.

                if( is_wp_error( $id ) ){
                    @chown($file_array['tmp_name'],465);
                    @unlink( $file_array['tmp_name'] );
                    //var_dump($id);
                    echo "something went wrong.";
                    die();
                }

                $attachment_url = wp_get_attachment_url( $id );

                echo $attachment_url;

                die();
            }
            else{
                $query = "SELECT guid FROM {$wpdb->posts} WHERE post_title='$file_name'";
                $poster_path = $wpdb->get_var($query);
                echo $poster_path;
                die();
            }
        }
    }
}