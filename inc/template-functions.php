<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Maester
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function maester_body_classes( $classes ) {
    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    // Adds a class of no-sidebar when there is no sidebar present.
    if ( ! is_active_sidebar( 'sidebar-1' ) ) {
        $classes[] = 'no-sidebar';
    }

    return $classes;
}
add_filter( 'body_class', 'maester_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function maester_pingback_header() {
    if ( is_singular() && pings_open() ) {
        printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
    }
}
add_action( 'wp_head', 'maester_pingback_header' );


/**
 * Post content length
 * @param $content_str
 * @param int $length
 * @param boolean $echo
 * @return bool|string
 */

function maester_custom_excerpt( $content_str, $length = 150, $echo = true ) {
    if($echo) {
        echo substr(strip_tags($content_str), 0, $length).'...';
        return;
    }
    return substr(strip_tags($content_str), 0, $length).'...';
}

/**
 * Filter the except length to 150 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function maester_custom_excerpt_length( $length ) {
    $maester_excerpt_lenght = get_theme_mod('maester_excerpt_length', 25);
    return $maester_excerpt_lenght;
}

add_filter( 'excerpt_length', 'maester_custom_excerpt_length', 999 );



/**
 * Search Popup
 */
add_filter('maester_after_footer_hook', 'maester_search_pupup', 10, 2);

function maester_search_pupup(){
    ?>
    <form action='<?php esc_url(home_url()); ?>' id='maester-popup-search-form' style='display: none;'>
        <div class='maester-popup-search-overlay'></div>
        <div class='maester-pupup-search-inner'>
            <input type='search' name='s' placeholder='<?php esc_attr_e('Search anything...', 'maester'); ?>'>
            <input type='submit' value='<?php esc_attr_e('Search', 'maester'); ?>'>
        </div>
    </form>
    <?php

}


//add_action('maester_after_header_hook', 'maester_breadcrumbs', 10);
function maester_breadcrumbs(){
    $get_breadcrumb = maester_get_breadcrumb();
    if(function_exists('maester_get_breadcrumb') && !empty($get_breadcrumb)){ ?>
        <div class="maester-breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <?php
                        echo maester_get_breadcrumb();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'maester_cart_link_fragment' ) ) {
    /**
     * Cart Fragments
     * Ensure cart contents update when products are added to the cart via AJAX
     *
     * @param  array $fragments Fragments to refresh via AJAX.
     * @return array            Fragments to refresh via AJAX
     */
    function maester_cart_link_fragment( $fragments ) {
        global $woocommerce;

        ob_start();
        maester_cart_link();
        $fragments['a.cart-contents'] = ob_get_clean();

        ob_start();
        maester_handheld_footer_bar_cart_link();
        $fragments['a.footer-cart-contents'] = ob_get_clean();

        return $fragments;
    }
}


if ( ! function_exists( 'maester_cart_link' ) ) {
    /**
     * Cart Link
     * Displayed a link to the cart including the number of items present and the cart total
     *
     * @return void
     * @since  1.0.0
     */
    function maester_cart_link() {
        ?>
        <a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'maester' ); ?>">
            <?php /* translators: %d: number of items in cart */ ?>
            <?php echo wp_kses_post( WC()->cart->get_cart_subtotal() ); ?> <span class="count"><?php echo wp_kses_data( sprintf( _n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'maester' ), WC()->cart->get_cart_contents_count() ) ); ?></span>
        </a>
        <?php
    }
}

/**
 * Cart fragment
 *
 * @see maester_cart_link_fragment()
 */
if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '2.3', '>=' ) ) {
    add_filter( 'woocommerce_add_to_cart_fragments', 'maester_cart_link_fragment' );
} else {
    add_filter( 'add_to_cart_fragments', 'maester_cart_link_fragment' );
}



if ( ! function_exists( 'maester_handheld_footer_bar_cart_link' ) ) {
    /**
     * The cart callback function for the handheld footer bar
     *
     * @since 2.0.0
     */
    function maester_handheld_footer_bar_cart_link() {
        ?>
        <a class="footer-cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'maester' ); ?>">
            <span class="count"><?php echo wp_kses_data( WC()->cart->get_cart_contents_count() ); ?></span>
        </a>
        <?php
    }
}


if ( ! function_exists( 'maester_is_woocommerce_activated' ) ) {
    /**
     * Query WooCommerce activation
     */
    function maester_is_woocommerce_activated() {
        return class_exists( 'WooCommerce' ) ? true : false;
    }
}



if ( ! function_exists( 'maester_header_cart' ) ) {
    /**
     * Display Header Cart
     *
     * @since  1.0.0
     * @uses  maester_is_woocommerce_activated() check if WooCommerce is activated
     * @return void
     */
    function maester_header_cart() {
        if ( maester_is_woocommerce_activated() ) {
            if ( is_cart() ) {
                $class = 'current-menu-item';
            } else {
                $class = '';
            }
            ob_start();
            ?>
            <ul id="site-header-cart" class="site-header-cart menu">
                <li class="<?php echo esc_attr( $class ); ?>">
                    <?php maester_cart_link(); ?>
                </li>
                <li>
                    <?php the_widget( 'WC_Widget_Cart', 'title=' ); ?>
                </li>
            </ul>
            <?php
            return ob_get_clean();
        }
    }
}



if ( ! function_exists( 'maester_single_post_meta' ) ) {
    /**
     * Display the post meta
     *
     * @since 1.0.0
     */
    function maester_single_post_meta() {
        if ( 'post' !== get_post_type() ) {
            return;
        }
        $enable_single_blog_date = get_theme_mod('enable_single_blog_date', true);
        $enable_single_blog_author = get_theme_mod('enable_single_blog_author', true);
        $enable_single_blog_comment_number = get_theme_mod('enable_single_blog_comment_number', true);

        // Posted on.
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';

        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
        }

        $time_string = sprintf(
            $time_string,
            esc_attr( get_the_date( 'c' ) ),
            esc_html( get_the_date() ),
            esc_attr( get_the_modified_date( 'c' ) ),
            esc_html( get_the_modified_date() )
        );

        $output_time_string = sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>', esc_url( get_permalink() ), $time_string );

        $posted_on = '<span class="posted-on">' .
            /* translators: %s: post date */
            sprintf( __( 'Posted on %s', 'maester' ), $output_time_string ) .
            '</span>';
        if(!$enable_single_blog_date) $posted_on = '';

        // Author.
        $author = sprintf(
            '<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>',
            __( 'by', 'maester' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_html( get_the_author() )
        );
        if(!$enable_single_blog_author) $author = '';


        // Comments.
        $comments = '';

        if ( ! post_password_required() && ( comments_open() || 0 !== intval( get_comments_number() ) ) ) {
            $comments_number = get_comments_number_text( __( 'Leave a comment', 'maester' ), __( '1 Comment', 'maester' ), __( '% Comments', 'maester' ) );

            $comments = sprintf(
                '<span class="post-comments">&mdash; <a href="%1$s">%2$s</a></span>',
                esc_url( get_comments_link() ),
                $comments_number
            );
        }
        if(!$enable_single_blog_comment_number) $comments = '';

        echo wp_kses(
            sprintf( '%1$s %2$s %3$s', $posted_on, $author, $comments ), array(
                'span' => array(
                    'class' => array(),
                ),
                'a'    => array(
                    'href'  => array(),
                    'title' => array(),
                    'rel'   => array(),
                ),
                'time' => array(
                    'datetime' => array(),
                    'class'    => array(),
                ),
            )
        );
    }
}


if ( ! function_exists( 'maester_comment' ) ) {
    /**
     * Maester comment template
     *
     * @param array $comment the comment array.
     * @param array $args the comment args.
     * @param int   $depth the comment depth.
     * @since 1.0.0
     */
    function maester_comment( $comment, $args, $depth ) {
        if ( 'div' === $args['style'] ) {
            $tag       = 'div';
            $add_below = 'comment';
        } else {
            $tag       = 'li';
            $add_below = 'div-comment';
        }
        ?>
        <<?php echo esc_attr( $tag ); ?> <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body">
        <div class="comment-meta commentmetadata">
            <div class="comment-author vcard">
                <?php echo get_avatar( $comment, 128 ); ?>
                <?php printf( wp_kses_post( '<cite class="fn">%s</cite>', 'maester' ), get_comment_author_link() ); ?>
            </div>
            <?php if ( '0' === $comment->comment_approved ) : ?>
                <em class="comment-awaiting-moderation"><?php esc_attr_e( 'Your comment is awaiting moderation.', 'maester' ); ?></em>
                <br />
            <?php endif; ?>

            <a href="<?php echo esc_url( htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ); ?>" class="comment-date">
                <?php echo '<time datetime="' . get_comment_date( 'c' ) . '">' . get_comment_date() . '</time>'; ?>
            </a>
        </div>
        <?php if ( 'div' !== $args['style'] ) : ?>
        <div id="div-comment-<?php comment_ID(); ?>" class="comment-content">
    <?php endif; ?>
        <div class="comment-text">
            <?php comment_text(); ?>
        </div>
        <div class="reply">
            <?php
            comment_reply_link(
                array_merge(
                    $args, array(
                        'add_below' => $add_below,
                        'depth'     => $depth,
                        'max_depth' => $args['max_depth'],
                    )
                )
            );
            ?>
            <?php edit_comment_link( __( 'Edit', 'maester' ), '  ', '' ); ?>
        </div>
        </div>
        <?php if ( 'div' !== $args['style'] ) : ?>
            </div>
        <?php endif; ?>
        <?php
    }
}

add_action('maester_menubar_column_hook', 'maester_header_right_menu', 30);
function maester_header_right_menu(){
    global $wp;
    $enable_header_cart = function_exists('WC') ? get_theme_mod('enable_header_cart', true) : false;
    $enable_header_login_icon = get_theme_mod('enable_header_login_icon', true);
    if($enable_header_cart || $enable_header_login_icon){
        ?>
        <div class="col-auto">
            <ul class="header-right-menu">
                <?php if($enable_header_cart) {?>
                    <li class="header-cart-menu">
                        <div class="cart-menu-parent">
                            <?php echo maester_header_cart(); ?><i class="fas fa-shopping-basket"></i>
                        </div>
                    </li>
                <?php } if($enable_header_login_icon) {
                    if(is_user_logged_in()){ ?>
                        <li>
                            <a href='<?php echo esc_url(wp_logout_url(home_url($wp->request))); ?>'>
                                <i class='fas fa-sign-out-alt'></i>
                            </a>
                        </li>
                        <?php

                    }else{
                        ?>
                        <li><a href='#open_user_modal'><i class='fas fa-lock'></i></a></li>
                        <?php
                    }
                } ?>
            </ul>
        </div>
    <?php  }
}



/**
 * Course Loop Function
 * @param bool $rating
 * @param bool $meta
 * @param bool $wishlist
 * @param bool $price
 */
if(!function_exists('maester_course_loop')){
    function maester_course_loop($rating = true, $meta = true, $wishlist = true, $price = true, $column = 'column-4'){
        ob_start();
        if( function_exists('tutor') && have_posts()){
            ?>
            <div class="maester-tutor-courses <?php echo esc_attr($column); ?>">
                <?php
                while (have_posts()){
                    the_post();
                    $profile_url = tutor_utils()->profile_url(get_the_author_meta('ID'));
                    $post_thumbnail_id = (int) get_post_thumbnail_id( get_the_ID() );

                    if($post_thumbnail_id){
                        $image = wp_get_attachment_image($post_thumbnail_id, 'maester-post-thumbnail');
                    }else{
                        $image = sprintf('<img alt="%s" src="' . get_template_directory_uri().'/img/course.jpg' . '" />', __('Placeholder', 'maester'));
                    }

                    ?>
                    <div class="maester-tutor-course">
                        <a class="maester-course-image-wrap" href="<?php the_permalink() ?>" title="<?php the_title() ?>">
                            <?php echo $image; ?>
                        </a>
                        <div class="maester-course-content">
                            <?php
                            if($rating){
                                tutor_course_loop_rating();
                            }
                            ?>
                            <?php if($meta) { ?>
                                <ul class="maester-course-meta">
                                    <li>
                                        <strong><?php esc_html_e('By', 'maester') ?> </strong>
                                        <a href="<?php esc_url($profile_url); ?>"><?php the_author(); ?></a>
                                    </li>
                                    <li>
                                        <?php
                                        $category = get_tutor_course_categories();
                                        if(!empty($category) && is_array($category ) && count($category)){
                                            ?>
                                            <strong><?php esc_html_e('In', 'maester') ?> </strong>
                                            <?php
                                            foreach ($category as $course_category){
                                                $category_name = $course_category->name;
                                                $category_link = get_term_link($course_category->term_id);
                                                echo "<a href='$category_link'>$category_name </a>";
                                            }
                                        }
                                        ?>
                                    </li>
                                </ul>
                            <?php } ?>
                            <h3>
                                <?php
                                if($wishlist) {
                                    $is_wishlisted = tutor_utils()->is_wishlisted(get_the_ID());
                                    $wishlist_class = $is_wishlisted ? 'wishlisted' : '';
                                    $bookmark_msg = $is_wishlisted ? __('Remove from bookmark', 'maester') : __('Add to bookmark', 'maester');
                                    ?>
                                    <i data-course-id="<?php echo get_the_ID(); ?>" title="<?php echo esc_attr($bookmark_msg); ?>" class="<?php echo esc_attr($wishlist_class); ?> far fa-bookmark course-bookmark-icon"></i>
                                    <?php
                                }
                                ?>
                                <a href="<?php the_permalink() ?>"><?php the_title() ?></a>
                            </h3>
                            <?php
                            if($price){
                                maester_course_loop_price();
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
            <?php
        }
        $output = ob_get_clean();
        echo $output;
    }
}

/**
 * Tutor Template Hooks
 */

function maester_tutor_breadcrumb(){
    echo maester_get_breadcrumb();
}

add_action('tutor_course/single/before/wrap', 'maester_breadcrumbs', 10, 2);
add_action('tutor_course/single/enrolled/before/wrap', 'maester_breadcrumbs', 10, 2);


/**
 * Showing Notice
 */


function maester_site_notice(){
    $maester_enable_notice = get_theme_mod('maester_enable_notice', false);
    $maester_notice_text = get_theme_mod('maester_notice_text', 'Notice text here');
    if($maester_enable_notice){
        ?>
        <p class="maester-site-notice"><i class="fas fa-exclamation-circle"></i> <?php echo esc_html($maester_notice_text) ?> <a href="#" class="maester-notice-dismiss"><i class="fas fa-times-circle"></i> <?php esc_html_e('Dissmis', 'maester') ?></a></p>
        <?php
    }
}
add_action('maester_after_footer_hook', 'maester_site_notice');


/**
 * Get Copyright Credits
 * @param bool $strip_tags
 * @return array|mixed|void
 * @Since 1.0.4
 */

function maester_get_copyright_credits($strip_tags = false){
    $copyright_link = apply_filters('maester_copyright_link', "https://wordpress.org/themes/maester-lite/");
    $credits = apply_filters('maester_copyright_credits', array(
        "credit_1" => sprintf(__("Built with %1\$s Maester Lite WordPress Theme %2\$s", 'maester'), "<a href='$copyright_link' rel='author'>", "</a>"),
        "credit_2" => sprintf(__("Powered by %1\$s Maester Lite by FeehaThemes %2\$s", 'maester'), "<a href='$copyright_link' rel='author'>", "</a>"),
        "credit_3" => sprintf(__("Proudly powered by WordPress | Theme: %1\$s Maester Lite by FeehaThemes %2\$s", 'maester'), "<a href='$copyright_link' rel='author'>", "</a>"),
        "credit_4" => sprintf(__("A WordPress Website | Theme: %1\$s Maester Lite by FeehaThemes %2\$s", 'maester'), "<a href='$copyright_link' rel='author'>", "</a>"),
        "credit_5" => sprintf(__("Theme: %1\$s Maester Lite by FeehaThemes %2\$s", 'maester'), "<a href='$copyright_link' rel='author'>", "</a>"),
    ));
    if($strip_tags == true){
        $credits = array_map( function($item){
            return strip_tags($item);
        }, $credits);
    }
    return $credits;
}