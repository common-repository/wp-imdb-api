<?php
/**
 * Provide a meta box area view for the plugin
 *
 * @package    Imdb API
 * @subpackage wp-imdb-api/admin
 */
?>

<div class="wrap">
	<div id="col-container">
		<div class="col-wrap imdbapi-metabox-slide1">
		<h1><?php esc_attr_e( 'Wellcome To IMDb API Explorer', $this->plugin_name ); ?></h1>
			<div class="inside">
				<p><?php esc_attr_e("You can use one of the following methods for find your favorite movie and series, then add it to the post", $this->plugin_name); ?></p>
				<fieldset>
						<div class="searchType-wrap">
						<label>
						<input type="radio" name="searchType" class="imdbapi-searchType" id="imdbapi-bytitle" value="bytitle" />
						<span><?php esc_attr_e( 'Search By Title', $this->plugin_name ); ?></span>
						</label>
						</div>
						<div class="searchType-wrap">
						<label>
						<input type="radio" name="searchType" class="imdbapi-searchType" id="imdbapi-byid" value="byid" />
						<span><?php esc_attr_e( 'Search By IMDB ID', $this->plugin_name ); ?></span>
						</label>
						</div>
				</fieldset>
			</div>
		</div>


		<!-- slide2 -->

		<div class="col-wrap imdbapi-metabox-slide2">
		<b><a href="#" id="imdbapi_goto1">← <?php esc_attr_e( 'Change Search Type', $this->plugin_name ); ?></a></b>
			<div class="inside">
				<fieldset>
						<div class="searchType-wrap">
						<span><b><?php esc_attr_e( 'Enter Name of Movie/Series', $this->plugin_name ); ?></b></span>
						<input type="text" value="" name="imdbQuery" id="imdbapi-query" class="all-options" />
						</div>
						<div class="searchType-wrap">
						<span><b><?php esc_attr_e( 'Year', $this->plugin_name ); ?></b> <i><?php esc_attr_e("(optional)", $this->plugin_name); ?></i></span>
						<input type="text" value="" name="imdbYear" id="imdbapi-year" class="small-text" />
						</div>
						<div class="searchType-wrap">
						<input class="button-secondary" type="button" id="imdbapi-search-submit" value="<?php esc_attr_e( 'Search', $this->plugin_name ); ?>" />
						</div>
						<div class="imdbapi-empty-title error" style="display:none;">
						<p><?php _e('title field cannot be empty.', $this->plugin_name) ?></p>
						</div>
				</fieldset>
			</div>
		</div>


		<!-- slide3 -->

		<div class="col-wrap imdbapi-metabox-slide3">
		<b><a href="#" id="imdbapi_goto2">← <?php esc_attr_e( 'Change Search Type', $this->plugin_name ); ?></a></b>
			<div class="inside">
				<fieldset>
						<div class="searchType-wrap">
						<span><b><?php esc_attr_e( 'Enter IMDB ID', $this->plugin_name ); ?></b> <i>(E.g tt1234567)</i></span>
						<input type="text" value="" name="imdbapiD" id="imdbapi-id" class="small" />
						</div>
						<div class="searchType-wrap">
						<input class="button-secondary" type="button" id="imdbapi-id-submit" value="<?php esc_attr_e( 'Retrieve Information', $this->plugin_name ); ?>" />
						</div>
						<div class="imdbapi-empty-id error" style="display:none;">
						<p><?php _e('IMDB ID field cannot be empty.', $this->plugin_name) ?></p>
						</div>
						<div class="imdbapi-invalid-id error" style="display:none;">
						<p><?php _e('invalid IMDB ID pattern.', $this->plugin_name) ?></p>
						</div>
				</fieldset>
			</div>
		</div>


		<div class="col-wrap imdbapi-metabox-slide4">
			<div class="inside">
			</div>
		</div>

		<div class="col-wrap imdbapi-metabox-loader">
		<div class="inside">
		<center>
			<img src="<?php echo untrailingslashit( plugin_dir_url( dirname(__FILE__) ) ); ?>/admin/img/pacman.gif" alt="pacman loader">
			<h2><?php _e('Loading ...', $this->plugin_name); ?></h2>
		</center>
		<br/>
		</div>
		</div>

		<div class="col-wrap omdb-temp-results">
		</div>


		<div class="imdbapi-metabox-notify">
			<div class="inside">
				<center>
				<h1><?php _e("Information was received successfully", $this->plugin_name); ?></h1>
				<br/>
				<a class="button-secondary imdbapi-metabox-edit imdbapi-metabox-btn" href="#" title="<?php _e( 'Translate common fields', $this->plugin_name ); ?>"><?php _e( 'Translate common fields', $this->plugin_name ); ?></a>
				<a class="button-secondary imdbapi-metabox-remove imdbapi-metabox-btn" href="#" title="<?php _e( 'Remove', $this->plugin_name ); ?>"><?php _e( 'Remove', $this->plugin_name ); ?></a>
				<br/><br/><br/>
			</center>
			</div>
		</div>

		<div class="imdbapi-tab-wrapper">

			<h2 class="nav-tab-wrapper">
				<a href="#" class="imdbapi-tab1 nav-tab nav-tab-active"><?php _e("Common Fields", $this->plugin_name); ?></a>
				<a href="#" class="imdbapi-tab2 nav-tab"><?php _e("Other Fields", $this->plugin_name); ?></a>
			</h2>

		</div>

		<!-- tab1 common metabox fields -->

		<div class="imdbapi-metabox-common-fields">
			<div class="inside">
				<table>
					<tbody>

						<tr>
							<th>
								<b><?php _e("Genre:" ,$this->plugin_name); ?></b>
							</th>
							<td>
								<fieldset>
									<input type="text" class="all-options" name="imdbapi-genre-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_genre', true ) ); ?>" />
								</fieldset>
							</td>
					</tr>

					<tr>
						<th>
							<b><?php _e("Country:" ,$this->plugin_name); ?></b>
						</th>
						<td>
							<fieldset>
								<input type="text" class="all-options" name="imdbapi-country-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_country', true ) ); ?>" />
							</fieldset>
						</td>
				</tr>

				<tr>
					<th>
						<b><?php _e("Language:" ,$this->plugin_name); ?></b>
					</th>
					<td>
						<fieldset>
							<input type="text" class="all-options" name="imdbapi-language-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_language', true ) ); ?>" />
						</fieldset>
					</td>
			</tr>




			<tr>
				<th>
					<b><?php _e("Plot:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<textarea name="imdbapi-plot-value" cols="70" rows="10"><?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_plot', true ) ); ?></textarea>
					</fieldset>
				</td>
		</tr>

				</tbody>
			</table>
							<center><i><?php _e("metabox values will change after publish/update the post.", $this->plugin_name); ?></i></center>
			</div>
			<br/>
		</div>


		<!-- tab2 other metabox fields -->


		<div class="imdbapi-metabox-other-fields">
			<div class="inside">
				<table>
					<tbody>

						<tr>
							<th>
								<b><?php _e("MPAA Rating (age):" ,$this->plugin_name); ?></b>
							</th>
							<td>
								<fieldset>
									<input type="text" class="all-options" name="imdbapi-rated-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_rated', true ) ); ?>" />
								</fieldset>
							</td>
					</tr>

					<tr>
						<th>
							<b><?php _e("Relase Date:" ,$this->plugin_name); ?></b>
						</th>
						<td>
							<fieldset>
								<input type="text" class="all-options" name="imdbapi-released-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_released', true ) ); ?>" />
							</fieldset>
						</td>
				</tr>

				<tr>
					<th>
						<b><?php _e("Runtime (minute):" ,$this->plugin_name); ?></b>
					</th>
					<td>
						<fieldset>
							<input type="text" class="all-options" name="imdbapi-runtime-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_runtime', true ) ); ?>" />
						</fieldset>
					</td>
			</tr>


			<tr>
				<th>
					<b><?php _e("Director:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<input type="text" class="all-options" name="imdbapi-director-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_director', true ) ); ?>" />
					</fieldset>
				</td>
		</tr>


			<tr>
				<th>
					<b><?php _e("Writer:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<input type="text" class="all-options" name="imdbapi-writer-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_writer', true ) ); ?>" />
					</fieldset>
				</td>
		</tr>


			<tr>
				<th>
					<b><?php _e("Actors:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<input type="text" class="all-options" name="imdbapi-actors-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_actors', true ) ); ?>" />
					</fieldset>
				</td>
		</tr>


			<tr>
				<th>
					<b><?php _e("Metascore:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<input type="text" class="all-options" name="imdbapi-metascore-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_metascore', true ) ); ?>" />
					</fieldset>
				</td>
		</tr>


			<tr>
				<th>
					<b><?php _e("Rating:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<input type="text" class="all-options" name="imdbapi-imdbrating-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_imdbrating', true ) ); ?>" />
					</fieldset>
				</td>
		</tr>


			<tr>
				<th>
					<b><?php _e("Votes:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<input type="text" class="all-options" name="imdbapi-imdbvotes-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_imdbvotes', true ) ); ?>" />
					</fieldset>
				</td>
		</tr>


			<tr>
				<th>
					<b><?php _e("Gross:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<input type="text" class="all-options" name="imdbapi-gross-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_gross', true ) ); ?>" />
					</fieldset>
				</td>
		</tr>



			<tr>
				<th>
					<b><?php _e("Budget:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<input type="text" class="all-options" name="imdbapi-budget-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_budget', true ) ); ?>" />
					</fieldset>
				</td>
		</tr>


			<tr>
				<th>
					<b><?php _e("Poster Url:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<textarea name="imdbapi-poster-value" cols="70" rows="10"><?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_poster', true ) ); ?></textarea>
					</fieldset>
				</td>
		</tr>


			<!-- these fields are not editable and hidden from user view -->

				<tr>
					<th>
						<b><?php _e("IMDB ID:" ,$this->plugin_name); ?></b>
					</th>
					<td>
						<fieldset>
							<input type="text" id="imdbapi-metabox-id-value" class="all-options" name="imdbapi-id-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_id', true ) ); ?>" />
						</fieldset>
					</td>
				</tr>

				<tr>
					<th>
						<b><?php _e("Title:" ,$this->plugin_name); ?></b>
					</th>
					<td>
						<fieldset>
							<input type="text" class="all-options" name="imdbapi-title-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_title', true ) ); ?>" />
						</fieldset>
					</td>
				</tr>

				<tr>
					<th>
						<b><?php _e("Year:" ,$this->plugin_name); ?></b>
					</th>
					<td>
						<fieldset>
							<input type="text" class="all-options" name="imdbapi-year-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_year', true ) ); ?>" />
						</fieldset>
					</td>
				</tr>

			<tr>
				<th>
					<b><?php _e("Type:" ,$this->plugin_name); ?></b>
				</th>
				<td>
					<fieldset>
						<input type="text" class="all-options" name="imdbapi-type-value" value="<?php echo esc_attr( get_post_meta( $object->ID, 'imdbapi_type', true ) ); ?>" />
					</fieldset>
				</td>
			</tr>

				</tbody>
			</table>
							<center><i><?php _e("metabox values will change after publish/update the post.", $this->plugin_name); ?></i></center>
			</div>
			<br/>
		</div>
	</div>
</div> <!-- .wrap -->
		<footer id="imdbapi-metabox-footer">
			<i id="imdbapi-plugin-url" style="display:none;"><?php echo untrailingslashit( plugins_url( '' ) ); ?></i>
		</footer>
