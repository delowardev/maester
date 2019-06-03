<?php

	/**
	 * Tutor Course Shortcode
	 */
	if(function_exists('tutor') && !function_exists('maester_course_shortcode')){
		function maester_course_shortcode($atts){
			$args = shortcode_atts(array(
				'post_type'     => tutor()->course_post_type,
				'count'         => -1,
				'id'            => '',
				'exclude_ids'   => '',
				'category'      => '',
				'orderby'       => 'ID',
				'order'         => 'DESC',
				'column'        => 'column-3',
				'rating'        => true,
				'meta'          => true,
				'wishlist'      => true,
				'price'         => true
			), $atts);

			if ( ! empty($args['id'])){
				$ids = (array) explode(',', $args['id']);
				$args['post__in'] = $ids;
			}

			if ( ! empty($args['exclude_ids'])){
				$exclude_ids = (array) explode(',', $args['exclude_ids']);
				$args['post__not_in'] = $exclude_ids;
			}

			if ( ! empty($args['category'])){
				$category = (array) explode(',', $args['category']);

				$args['tax_query'] = array(
					array(
						'taxonomy' => 'course-category',
						'field'    => 'slug',
						'terms'    => $category,
						'operator' => 'IN',
					),
				);
			}

			if(empty($args['rating']) || 'false' === $args['rating']){
				$args['rating'] = false;
			}else{
				$args['rating'] = true;
			}

			if(empty($args['meta']) || 'false' === $args['meta']){
				$args['meta'] = false;
			}else{
				$args['meta'] = true;
			}

			if(empty($args['wishlist']) || 'false' === $args['wishlist']){
				$args['wishlist'] = false;
			}else{
				$args['wishlist'] = true;
			}

			if(empty($args['price']) || 'false' === $args['price']){
				$args['price'] = false;
			}else{
				$args['price'] = true;
			}



			$args['posts_per_page'] = (int) $args['count'];

			wp_reset_query();
			query_posts($args);
			ob_start();
			maester_course_loop($args['rating'], $args['meta'], $args['wishlist'], $args['price'], $args['column']);
			$output = ob_get_clean();
			wp_reset_query();
			return $output;

		}
		add_shortcode('maester_course', 'maester_course_shortcode');
	}

