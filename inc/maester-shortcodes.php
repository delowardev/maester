<?php

function maester_search_shortcode($atts){

//    get_search_category_slug_by_post_type

    $post_type = get_theme_mod('header_search_post_types', 'post');

    $values = shortcode_atts(array(
        'class' => '',
        'all_category'  => 'All Category',
        'placeholder'   => __('Search anything...', 'maester'),
        'post_type'     => $post_type,
        'taxonomy'     => get_search_category_slug_by_post_type($post_type)
    ), $atts);
    $cat_list = maester_category_list($values['taxonomy']);
    ?>
        <form action="<?php echo esc_url(home_url()); ?>" class="custom-search-form">
            <input type="hidden" name="post_type" value="<?php echo $values['post_type']; ?>">
            <select name="category">
                <option value=""><?php echo $values['all_category']; ?></option>
                <?php
                    foreach ($cat_list as $key => $value){
                        echo "<option value='$key'>$value</option>";
                    }
                ?>

            </select>
            <input type="search" placeholder="<?php echo esc_html($values['placeholder']); ?>" name="s" value="<?php echo get_search_query(); ?>">
            <button type="submit"><i class="fas fa-search"></i></button>
        </form>

    <?php
}

add_shortcode('maester_search', 'maester_search_shortcode');