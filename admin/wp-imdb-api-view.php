<?php
/**
 * Created by PhpStorm.
 * User: Tuyen Pham
 * Date: 5/31/2017
 * Time: 6:48 PM
 */
if ( ! current_user_can( 'manage_options' ) ) {
  return;
}
$options = get_option($this->plugin_name);
    ?>
    <div class="wrap imdbapi_wrap">
        <ul class="imdbapi_tab">
            <li class="imdbapi_active"><a href="#imdbapi_config">Setting</a></li>
            <li><a href="#imdbapi_howtose">How to use</a></li>
        </ul>
        <div class="imdb-tab-content">
            <div id="imdbapi_config" class="imdbapi_tab_element">
                <?php
                if ( isset( $_GET['settings-updated'] ) ) {
                    add_settings_error( 'imdbapi_messages', 'imdbapi_message', __( 'Settings Saved', $this->plugin_name ), 'updated' );
                }
                settings_errors( 'imdbapi_messages' );
                ?>
                <form action="options.php" method="post">
                  <?php
                  settings_fields( $this->plugin_name );
                  do_settings_sections( $this->plugin_name );
                  submit_button( 'Save Settings');
                  ?>
                </form>
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top"><span style="display: inline-block;position: relative;top: -12px;">Help us with</span> <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="PK7JEX22M6GQQ">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <span style="display: inline-block;position: relative;top: -12px;"> or <a href="https://www.patreon.com/bePatron?c=954317" target="_blank">Become patron</a>. Thank you!</span>
                </form>
            </div>
            <div id="imdbapi_howtose" class="imdbapi_tab_element" style="display:none;">
                <p style="margin: 10px -10px;padding: 10px;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;background: #f5f5f5;"><strong>Find by ID</strong></p>
                <p>Use this method to get movie by IMDb ID</p>
                <p><strong>Medthod: </strong> get</p>
                <table class="wp-list-table widefat fixed striped users">
                    <thead>
                    <tr>
                        <td>Element</td>
                        <td>Description</td>
                        <td>Format</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>$id</td>
                        <td><strong>Required</strong></td>
                        <td><i>number</i></td>
                    </tr>
                    <tr>
                        <td>$type</td>
                        <td><i>Optional</i><br>Response type. Default is JSON</td>
                        <td><i>string</i></td>
                    </tr>
                    </tbody>
                </table>
                <pre><code class="language-php" data-lang="php">$imdb = new IMDbapi();
$data = $imdb->get('tt0004614','json'); // get with IMDb ID and response type (json or xml). Default is json
</code></pre>
                <p style="margin: 10px -10px;padding: 10px;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;background: #f5f5f5;"><strong>Find by title</strong></p>
                <p>Use this method to get movie by movie title</p>
                <p><strong>Medthod: </strong> title</p>
                <table class="wp-list-table widefat fixed striped users">
                    <thead>
                    <tr>
                        <td>Element</td>
                        <td>Description</td>
                        <td>Format</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>$title</td>
                        <td><strong>Required</strong></td>
                        <td><i>string</i></td>
                    </tr>
                    <tr>
                        <td>$type</td>
                        <td><i>Optional</i><br>Response type. Default is JSON</td>
                        <td><i>string</i></td>
                    </tr>
                    </tbody>
                </table>
                <pre><code class="language-php" data-lang="php">$imdb = new IMDbapi();
$data = $imdb->title('batman','json'); // get with the title and response type (json or xml). Default is json</code></pre>
                <p style="margin: 10px -10px;padding: 10px;border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;background: #f5f5f5;"><strong>Search movie</strong></p>
                <p>Use this method to search movie by keyword</p>
                <p><strong>Medthod: </strong> search</p>
                <table class="wp-list-table widefat fixed striped users">
                    <thead>
                    <tr>
                        <td>Element</td>
                        <td>Description</td>
                        <td>Format</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>$keyword</td>
                        <td><strong>Required</strong></td>
                        <td><i>string</i></td>
                    </tr>
                    <tr>
                        <td>$year</td>
                        <td><i>Optional</i><br>Filter movies with year</td>
                        <td><i>number</i></td>
                    </tr>
                    <tr>
                        <td>$page</td>
                        <td><i>Optional</i><br>Get movies of page. Default is 0 ( page 1 )</td>
                        <td><i>number</i></td>
                    </tr>
                    <tr>
                        <td>$type</td>
                        <td><i>Optional</i><br>Response type. Default is JSON</td>
                        <td><i>string</i></td>
                    </tr>
                    </tbody>
                </table>
                <pre><code class="language-php" data-lang="php">$imdb = new IMDbapi();
$data = $imdb->search('batman',1980,0,'json'); // get with the title and response type (json or xml). Default is json</code></pre>
            </div>
        </div>
    </div>
