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
 * Post Excerpt Length
 * @param $length
 * @return int
 */

function maester_custom_excerpt_length( $length ) {
    // TODO: Excerpth length must be dynamic
    return 23;
}
add_filter( 'excerpt_length', 'maester_custom_excerpt_length', 999 );

/**
 * Top Bar Menu Customize
 */

function maester_header_links ($items, $args) {
    global $wp;
    $topbar_custom_links = get_theme_mod('topbar_custom_links', array('login', 'profile', 'logout'));
    $topbar_social = get_theme_mod('topbar_social', array());
    $current_page = home_url($wp->request);

    if('topbar' == $args->theme_location){

        foreach ($topbar_social as $social){
            $social_icon = esc_attr($social['topbar_social_icon']);
            $social_link = esc_url($social['topbar_social_link']);
            $topbar_social_link_target = esc_attr($social['topbar_social_link_target']);
            $items .= "<li class='top-bar-custom-links top-bar-social'><a target='$topbar_social_link_target' href='$social_link'><i class='$social_icon'></i></a></li>";
        }


        if(in_array('search', $topbar_custom_links)){
            $items .= "<li class='top-bar-custom-links'><a href='#open_search_popup'><i class='fas fa-search'></i></a></li>";
        }

        if(is_user_logged_in()){
            $logout_url =  wp_logout_url($current_page);
            if(in_array('logout', $topbar_custom_links)){
                $items .= "<li class='top-bar-custom-links'><a href='$logout_url'><i class='fas fa-sign-out-alt'></i></a></li>";
            }
        }else{
            if(in_array('login', $topbar_custom_links)){
                $items .= "<li class='top-bar-custom-links'><a href='#open_user_modal'><i class='fas fa-lock'></i></a></li>";

            }
        }
    }
    return $items;
}

add_filter('wp_nav_menu_items', 'maester_header_links', 10, 2);

/**
 * Menubar Right Icons
 */

function menubar_right_icons(){
    global $wp;
    $enable_header_cart = function_exists('WC') ? get_theme_mod('enable_header_cart', true) : false;
    $enable_header_login_icon = get_theme_mod('enable_header_login_icon', true);
    $enable_menubar_search_icon = get_theme_mod('enable_menubar_search_icon', true);
    $menubar_social = get_theme_mod('menubar_social', array());
    $menubar_social_markup = '';
    foreach ($menubar_social as $social){
        $social_icon = esc_attr($social['menubar_social_icon']);
        $social_link = esc_url($social['menubar_social_link']);
        $link_target = esc_attr($social['menubar_social_link_target']);
        $menubar_social_markup .= "<li><a href='$social_link' target='$link_target'><i class='$social_icon'></i></a></li>";
    }

    ?>
        <div class="col-auto">
            <ul class="header-right-menu clearfix">
                <?php if($enable_header_cart) {?>
                    <li class="header-cart-menu">
                        <div class="cart-menu-parent">
                            <?php echo maester_header_cart(); ?><i class="fas fa-shopping-basket"></i>
                        </div>
                    </li>
                <?php } ?>
                <?php echo wp_kses_post($menubar_social_markup); ?>

                <?php if($enable_menubar_search_icon) {?>
                    <li class='menubar-search-icon'>
                        <a href='#open_search_popup'>
                            <i class='fas fa-search'></i>
                        </a>
                    </li>
                <?php } ?>

                <?php if($enable_header_login_icon) {
                    if(is_user_logged_in()){ ?>
                        <li class='menubar-login-icon'>
                            <a href='<?php echo esc_url(wp_logout_url(home_url($wp->request))); ?>'>
                                <i class='fas fa-sign-out-alt'></i>
                            </a>
                        </li>
                        <?php

                    }else{ ?>
                        <li><a href='#open_user_modal'><i class='fas fa-lock'></i></a></li>
                        <?php
                    }
                }
                ?>

            </ul>
        </div>
    <?php
}

add_action('menubar_item_hook', 'menubar_right_icons');


/**
 * Search Popup
 */
add_filter('maester_after_footer_hook', 'maester_search_pupup', 10, 2);

function maester_search_pupup(){
    ?>
        <form action='<?php esc_url(home_url()); ?>' id='maester-popup-search-form' style='display: none;'>
            <div class='maester-popup-search-overlay'></div>
            <div class='maester-pupup-search-inner'>
                <input type='search' name='s' placeholder='<?php _e('Search anything...', 'maester'); ?>'>
                <input type='submit' value='<?php _e('Search', 'maester'); ?>'>
            </div>
        </form>
    <?php

}


add_action('maester_after_header_hook', 'maester_breadcrumbs', 10);
function maester_breadcrumbs(){
    if(!empty(get_maester_breadcrumb())){ ?>
        <div class="maester-breadcrumb-area">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <?php
                        echo get_maester_breadcrumb();
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php
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

        $posted_on = '
			<span class="posted-on">' .
            /* translators: %s: post date */
            sprintf( __( 'Posted on %s', 'maester' ), $output_time_string ) .
            '</span>';

        // Author.
        $author = sprintf(
            '<span class="post-author">%1$s <a href="%2$s" class="url fn" rel="author">%3$s</a></span>',
            __( 'by', 'maester' ),
            esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
            esc_html( get_the_author() )
        );

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

add_action('maester_menubar_column_hook', 'header_right_menu', 30);
function header_right_menu(){
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