<?php

/**
 * @param $val
 * ver_dump function with pre tag
 */
function maester_var_dump($val){
    echo "<pre>";
    var_dump($val);
    echo "</pre>";
}

/**
 * @param string $taxonomy
 * @return array
 * Category List Funtion
 */
function maester_category_list($taxonomy = 'category'){
    $terms = get_terms($taxonomy);
    $term_array = array();
    foreach ($terms as $term){
        $term_array[$term->slug] = $term->name;
    }
    return $term_array;
}

/**
 * Get possible search post types
 * @return array
 */

function search_post_types (){
    $get_post_types = get_post_types(array('public'=>true));
    $value = array();
    foreach ($get_post_types as $post){
        if(function_exists('tutor') && tutor()->course_post_type == $post) $value[$post] = 'Course';
        if('product' == $post) $value[$post] = 'Product';
        if('post' == $post) $value[$post] = 'Post';
    }
    return $value;
}

/**
 * Get Post Types for header search
 * @param $post_type
 * @return string
 */
function get_search_category_slug_by_post_type($post_type = 'post'){
    if(function_exists('tutor') && tutor()->course_post_type == $post_type){
        return 'course-category';
    }elseif(function_exists('WC') && 'product' == $post_type){
        return 'product_cat';
    }elseif('post' == $post_type){
        return 'category';
    }else{
        return false;
    }
}


function maester_pagination(){
	?>
		<div class="maester-pagination-wrap">
			<?php
				global $wp_query;
				$big = 999999999; // need an unlikely integer

				echo paginate_links( array(
					'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
					'format' => '?paged=%#%',
					'current' => max( 1, get_query_var('paged') ),
					'total' => $wp_query->max_num_pages
				) );
			?>
		</div>
	<?php
}

function maester_get_post_lists($post_type = 'post'){
	wp_reset_query();
	query_posts(array(
		'post_type' => $post_type,
		'post_status' => 'publish'
	));
	$post_list = array();

	if(have_posts()){
		while(have_posts()){
			the_post();
			$post_list[get_the_ID()] = get_the_title();
		}
	}
	wp_reset_query();
	return $post_list;
}