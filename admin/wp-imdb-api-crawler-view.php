<?php
/**
*
* Display IMdbapi result in metabox area
*
* @package wp-imdb-api
* @subpackage wp-imdb-api/admin
*
*
*/

$options = get_option($this->plugin_name);
set_time_limit ( 0 );
$result = json_decode($handle);

?>

<?php
  if($result->status == "false"){
    ?>
    <div class="crawler-error">
    <center>
    <h1><?php echo $result->message; ?></h1>
    <br/>
    <a class="button-secondary crawler-error-btn" href="#" title="<?php esc_attr_e( "Let's try again" ); ?>"><?php esc_attr_e( "Let's try again", $this->plugin_name ); ?></a>
    </center>
    <br/><br/>
    </div>
    <?php
    die();
  }
?>

<div class="imdbapi-result-search-results">
<?php
if($type == "search"){
  ?>
  <b><a href="#" id="imdbapi_back1"><?php _e('← Back', $this->plugin_name); ?></a></b>
  <br>
  <?php

$fields = array(
  "title" => $result->title,
  "year" => $result->year,
  "rated" => $result->rated,
  "released" => $result->released,
  "runtime" => $result->runtime,
  "genre" => $result->genre,
  "director" => preg_replace("/\(([^\)]+)\)/", '', $result->director), // this regex will remove Parenthesis with anything in it.
  "writer" => preg_replace("/\(([^\)]+)\)/", '', $result->writers),
  "actors" => preg_replace("/\(([^\)]+)\)/", '', $result->actors),
  "plot" => $result->plot,
  "language" => $result->language,
  "country" => $result->country,
  "metascore" => $result->metascore,
  "imdbrating" => $result->rating,
  "imdbvotes" => $result->votes,
  "imdbapi_id" => $result->imdb_id,
  "poster" => $result->poster,
  "type" => $result->type,
  "gross" => $result->gross,
  "budget" => $result->budget,
);



  if($fields["poster"] !== "N/A"){
    ?>
    <div class="imdbapi-result-wrapper">
      <div id="imdbapi-result-poster">
        <?php

          $poster = str_replace($media_server,$no_block,$fields["poster"]); //replace no_block adress if the connection is restricted

          echo "<img src=".$poster." alt=".$fields["title"]."/>" ;
         ?>
      </div>
    </div>
<?php

  $poster = preg_replace("/(SX)([0-9])+/", "SX".$options["posters_size"], $poster); // changing poster size

  }
  else{
    $poster = "N/A";
  }
  ?>
  <div class="imdbapi-result-wrapper">
    <div class="imdbapi-result-info">
      <ul>
        <li>
          <h1 class="imdbapi-result-ltr">
            <?php
            if($result->Year !== "N/A")
                  echo $fields["title"]." (".rtrim($result->Year, '–').")";
            else
                  echo $fields["title"];
             ?>
          </h1>
        </li>

        <li>
          <b><?php _e('Release Date:', $this->plugin_name); ?> </b><span class="imdbapi-result-ltr"><?php echo $fields["released"]; ?></span>
        </li>

        <li>

           <b><?php _e('Genre:',$this->plugin_name); ?> </b><?php echo $fields["genre"]; ?>

        </li>

        <li>
          <b><?php _e('Rating:',$this->plugin_name); ?> </b><?php echo $fields["imdbrating"].'/10'; ?><small><?php printf(__('from %s users',$this->plugin_name),$fields["imdbvotes"]); ?></small>
        </li>

        <li>
          <b><?php _e('Metascore:',$this->plugin_name); ?> </b><?php echo $fields["metascore"].'/100'; ?>
        </li>

        <li>

           <b><?php _e('Director:',$this->plugin_name); ?> </b><span class="imdbapi-result-ltr"><?php echo $fields["director"]; ?></span>

        </li>


        <li>

           <b><?php _e('Stars:',$this->plugin_name); ?> </b><span class="imdbapi-result-ltr"><?php echo $fields["actors"]; ?></span>

        </li>

        <li>
        <span class="imdbapi-result-ltr">
           <?php
           if( $fields["plot"] !== "N/A" && !is_rtl() )
              echo $fields["plot"];
            ?>
      </span>
        </li>

        <li>
          <input class="button-primary imdbapi-submit-info" type="button" name="imdbapi-submit-info" value="<?php esc_attr_e( 'Submit Information',$this->plugin_name ); ?>" />
        </li>

      </ul>
    </div>





    <!--
    this is so important this div will save the crawler result
     and by using jquery set the results into metabox fields
    in order to avoid sending another request to recive data. -->

    <div id="imdbapi-crawler-result" style="display:none !important;">
      <ul>
        <li id="imdbapi-crawler-title"><?php echo $fields["title"]; ?></li>
        <li id="imdbapi-crawler-year"><?php echo $fields["year"]; ?></li>
        <li id="imdbapi-crawler-rated"><?php echo $fields["rated"]; ?></li>
        <li id="imdbapi-crawler-released"><?php echo $fields["released"]; ?></li>
        <li id="imdbapi-crawler-runtime"><?php echo $fields["runtime"]; ?></li>
        <li id="imdbapi-crawler-genre"><?php echo $fields["genre"]; ?></li>
        <li id="imdbapi-crawler-director"><?php echo $fields["director"]; ?></li>
        <li id="imdbapi-crawler-writer"><?php echo $fields["writer"]; ?></li>
        <li id="imdbapi-crawler-actors"><?php echo $fields["actors"]; ?></li>
        <li id="imdbapi-crawler-plot"><?php echo $fields["plot"]; ?></li>
        <li id="imdbapi-crawler-language"><?php echo $fields["language"]; ?></li>
        <li id="imdbapi-crawler-country"><?php echo $fields["country"]; ?></li>
        <li id="imdbapi-crawler-awards"><?php echo $fields["awards"]; ?></li>
        <li id="imdbapi-crawler-poster"><?php if($options['imdbapi_field_download_posters'] == '1'){echo $fields["poster"];}else{echo 'N/A';} ?></li>
        <li id="imdbapi-crawler-metascore"><?php echo $fields["metascore"]; ?></li>
        <li id="imdbapi-crawler-imdbrating"><?php echo $fields["imdbrating"]; ?></li>
        <li id="imdbapi-crawler-imdbvotes"><?php echo $fields["imdbvotes"]; ?></li>
        <li id="imdbapi-crawler-imdbapid"><?php echo $fields["imdbapi_id"]; ?></li>
        <li id="imdbapi-crawler-gross"><?php echo $fields["gross"]; ?></li>
        <li id="imdbapi-crawler-budget"><?php echo $fields["budget"]; ?></li>
        <li id="imdbapi-crawler-type"><?php echo $fields["type"]; ?></li>
      </ul>
    </div>

  </div>
    <div style="clear: both;display: block;content: '';"></div>
    <?php
    die();
}
else{
  ?>
  <b style="display:block;"><a href="#" id="imdbapi_back2"><?php _e('← Back', $this->plugin_name); ?></a></b>
  <br/>

<?php

$fields = array(
  "title" => $result->title,
  "year" => $result->year,
  "rated" => $result->rated,
  "released" => $result->released,
  "runtime" => $result->runtime,
  "genre" => $result->genre,
  "director" => preg_replace("/\(([^\)]+)\)/", '', $result->director), // this regex will remove Parenthesis with anything in it.
  "writer" => preg_replace("/\(([^\)]+)\)/", '', $result->writers),
  "actors" => preg_replace("/\(([^\)]+)\)/", '', $result->actors),
  "plot" => $result->plot,
  "language" => $result->language,
  "country" => $result->country,
  "metascore" => $result->metascore,
  "imdbrating" => $result->rating,
  "imdbvotes" => $result->votes,
  "imdbapi_id" => $result->imdb_id,
  "poster" => $result->poster,
  "type" => $result->type,
  "gross" => $result->gross,
  "budget" => $result->budget,
);



  if($fields["poster"] !== "N/A"){
    ?>
    <div class="imdbapi-result-wrapper">
      <div id="imdbapi-result-poster">
        <?php

          $poster = str_replace($media_server,$no_block,$fields["poster"]); //replace no_block adress if the connection is restricted

          echo "<img src=".$poster." alt=".$fields["title"]."/>" ;
         ?>
      </div>
    </div>
<?php

  $poster = preg_replace("/(SX)([0-9])+/", "SX".$options["posters_size"], $poster); // changing poster size

  }
  else{
    $poster = "N/A";
  }
  ?>
  <div class="imdbapi-result-wrapper">
    <div class="imdbapi-result-info">
      <ul>
        <li>
          <h1 class="imdbapi-result-ltr">
            <?php
            if($result->Year !== "N/A")
                  echo $fields["title"]." (".rtrim($result->Year, '–').")";
            else
                  echo $fields["title"];
             ?>
          </h1>
        </li>

        <li>
          <b><?php _e('Release Date:', $this->plugin_name); ?> </b><span class="imdbapi-result-ltr"><?php echo $fields["released"]; ?></span>
        </li>

        <li>

           <b><?php _e('Genre:',$this->plugin_name); ?> </b><?php echo $fields["genre"]; ?>

        </li>

        <li>
          <b><?php _e('Rating:',$this->plugin_name); ?> </b><?php echo $fields["imdbrating"].'/10'; ?><small><?php printf(__('from %s users',$this->plugin_name),$fields["imdbvotes"]); ?></small>
        </li>

        <li>
          <b><?php _e('Metascore:',$this->plugin_name); ?> </b><?php echo $fields["metascore"].'/100'; ?>
        </li>

        <li>

           <b><?php _e('Director:',$this->plugin_name); ?> </b><span class="imdbapi-result-ltr"><?php echo $fields["director"]; ?></span>

        </li>


        <li>

           <b><?php _e('Stars:',$this->plugin_name); ?> </b><span class="imdbapi-result-ltr"><?php echo $fields["actors"]; ?></span>

        </li>

        <li>
        <span class="imdbapi-result-ltr">
           <?php
           if( $fields["plot"] !== "N/A" && !is_rtl() )
              echo $fields["plot"];
            ?>
      </span>
        </li>

        <li>
          <input class="button-primary imdbapi-submit-info" type="button" name="imdbapi-submit-info" value="<?php esc_attr_e( 'Submit Information',$this->plugin_name ); ?>" />
        </li>

      </ul>
    </div>





    <!--
    this is so important this div will save the crawler result
     and by using jquery set the results into metabox fields
    in order to avoid sending another request to recive data. -->

    <div id="imdbapi-crawler-result" style="display:none !important;">
      <ul>
        <li id="imdbapi-crawler-title"><?php echo $fields["title"]; ?></li>
        <li id="imdbapi-crawler-year"><?php echo $fields["year"]; ?></li>
        <li id="imdbapi-crawler-rated"><?php echo $fields["rated"]; ?></li>
        <li id="imdbapi-crawler-released"><?php echo $fields["released"]; ?></li>
        <li id="imdbapi-crawler-runtime"><?php echo $fields["runtime"]; ?></li>
        <li id="imdbapi-crawler-genre"><?php echo $fields["genre"]; ?></li>
        <li id="imdbapi-crawler-director"><?php echo $fields["director"]; ?></li>
        <li id="imdbapi-crawler-writer"><?php echo $fields["writer"]; ?></li>
        <li id="imdbapi-crawler-actors"><?php echo $fields["actors"]; ?></li>
        <li id="imdbapi-crawler-plot"><?php echo $fields["plot"]; ?></li>
        <li id="imdbapi-crawler-language"><?php echo $fields["language"]; ?></li>
        <li id="imdbapi-crawler-country"><?php echo $fields["country"]; ?></li>
        <li id="imdbapi-crawler-awards"><?php echo $fields["awards"]; ?></li>
        <li id="imdbapi-crawler-poster"><?php if($options['imdbapi_field_download_posters'] == '1'){echo $fields["poster"];}else{echo 'N/A';} ?></li>
        <li id="imdbapi-crawler-metascore"><?php echo $fields["metascore"]; ?></li>
        <li id="imdbapi-crawler-imdbrating"><?php echo $fields["imdbrating"]; ?></li>
        <li id="imdbapi-crawler-imdbvotes"><?php echo $fields["imdbvotes"]; ?></li>
        <li id="imdbapi-crawler-imdbapid"><?php echo $fields["imdbapi_id"]; ?></li>
        <li id="imdbapi-crawler-gross"><?php echo $fields["gross"]; ?></li>
        <li id="imdbapi-crawler-budget"><?php echo $fields["budget"]; ?></li>
        <li id="imdbapi-crawler-type"><?php echo $fields["type"]; ?></li>
      </ul>
    </div>

  </div>
    <div style="clear: both;display: block;content: '';"></div>
  <?php
} //End Else
?>

</div> <!-- End .imdbapi-result-search-results -->
