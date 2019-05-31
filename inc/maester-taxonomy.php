<?php


	/**
	 * Meta Registration For Term
	 */
	function maester_reg_meta() {
		register_meta( 'term', 'color', 'maester_sanitize_hex' );
		register_meta( 'term', 'icon', 'maester_sanitize_hex' );
	}
	add_action( 'init', 'maester_reg_meta' );



	function maester_sanitize_hex( $color ) {
		$color = ltrim( $color, '#' );
		return preg_match( '/([A-Fa-f0-9]{3}){1,2}$/', $color ) ? $color : '';
	}

	function maester_get_term_color( $term_id, $hash = false ) {
		$color = get_term_meta( $term_id, 'color', true );
		$color = maester_sanitize_hex( $color );
		return $hash && $color ? "#{$color}" : $color;
	}


	add_action( 'course-category_add_form_fields', 'maester_new_term_color_field', 10, 2 );
	function maester_new_term_color_field() {
		wp_nonce_field( basename( __FILE__ ), 'maester_term_color_nonce' ); ?>
		<div class="form-field maester-term-color-wrap">
			<label for="maester-term-color"><?php _e( 'Color', 'maester' ); ?></label>
			<input type="text" name="maester_term_color" id="maester-term-color" class="maester_colorpicker" value="<?php printf('#%06X', mt_rand(0, 0xFFFFFF)) ?>" data-default-color="" />
		</div>
	<?php }


	add_action( 'course-category_edit_form_fields', 'maester_edit_term_color_field' );
	function maester_edit_term_color_field( $term ) {
		$default = '';
		$color   = maester_get_term_color( $term->term_id, true );
		if ( ! $color ){
			$color = $default;
		}

		?>

		<tr class="form-field maester-term-color-wrap">
			<th scope="row"><label for="maester-term-color"><?php _e( 'Color', 'maester' ); ?></label></th>
			<td>
				<?php wp_nonce_field( basename( __FILE__ ), 'maester_term_color_nonce' ); ?>
				<input type="text" name="maester_term_color" id="maester-term-color"  class="maester_colorpicker" value="<?php echo esc_attr( $color ); ?>" data-default-color="<?php echo esc_attr( $default ); ?>" />
			</td>
		</tr>
	<?php }


	add_action( 'edit_course-category',   'maester_save_term_color', 10, 2 );
	add_action( 'create_course-category', 'maester_save_term_color', 10, 2 );

	function maester_save_term_color( $term_id ) {

		if ( ! isset( $_POST['maester_term_color_nonce'] ) || ! wp_verify_nonce( $_POST['maester_term_color_nonce'], basename( __FILE__ ) ) ){
			return;
		}

		$old_color = maester_get_term_color( $term_id );
		$new_color = isset( $_POST['maester_term_color'] ) ? maester_sanitize_hex( $_POST['maester_term_color'] ) : '';

		if ( $old_color && '' === $new_color ){
			delete_term_meta( $term_id, 'color' );
		} else if ( $old_color !== $new_color ){
			update_term_meta( $term_id, 'color', $new_color );
		}
	}

	add_filter( 'manage_edit-course-category_columns', 'jt_edit_term_columns' );

	function jt_edit_term_columns( $columns ) {

		$columns['color'] = __( 'Color', 'jt' );

		return $columns;
	}

	add_filter( 'manage_course-category_custom_column', 'maester_manage_term_custom_column', 10, 3 );

	function maester_manage_term_custom_column( $out, $column, $term_id ) {

		if ( 'color' === $column ) {

			$color = maester_get_term_color( $term_id, true );

			if ( ! $color )
				$color = '';

			$out = sprintf( '<span class="category-color-block" style="background:%s;">&nbsp;&nbsp;&nbsp;&nbsp;</span>', esc_attr( $color ) );
		}

		return $out;
	}