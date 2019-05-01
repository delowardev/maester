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
    $term_array = [];
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
    $value = [];
    foreach ($get_post_types as $post){
        if('course' == $post) $value[$post] = 'Course';
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
    if('course' == $post_type){
        return 'course-category';
    }elseif('product' == $post_type){
        return 'product_cat';
    }elseif('post' == $post_type){
        return 'category';
    }else{
        return false;
    }
}
