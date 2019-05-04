<?php
/**
 * Template part for displaying page content in header.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */



?>

<?php
    $enable_topbar = get_theme_mod('enable_topbar', true);
    if($enable_topbar) {
?>

<div class="top-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <p class='top-bar-description'>
                <?php
                    $topbar_text = get_theme_mod('topbar_text');
                    if($topbar_text){
                        echo esc_html($topbar_text);
                    }
                ?>
                </p>
            </div>
            <div class="col-auto">
                <button style="display:none;" class="menu-toggle" aria-controls="top-bar-menu" aria-expanded="false"><i class="fas fa-bars"></i></button>
                <?php
                    if(has_nav_menu('topbar')){
                        wp_nav_menu( array(
                            'theme_location' => 'topbar',
                            'menu_id'        => 'top-bar-menu',
                            'container'      => 'nav',
                            'container_class'=> 'responsive-menu top-bar-menu-container'
                        ));
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php } //$enable_topbar ?>

<div class="header-main">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <div class="site-branding">
                    <?php
                        if(!empty(get_theme_mod( 'custom_logo' ))){
                            the_custom_logo();
                        }else{
                            $site_url = esc_url(home_url('/'));
                            $site_title = esc_html(get_bloginfo('name'));
                            echo "<a href='$site_url'>$site_title</a>";
                        }
                    ?>
                    <p class="site-description">
                        <?php bloginfo('description'); ?>
                    </p>
                </div><!-- .site-branding -->

            </div>
            <div class="col-auto">
                <button style="display:none;" class="menu-toggle" aria-controls="secondary-menu" aria-expanded="false"><i class="fas fa-bars"></i></button>
                <?php
                    if(has_nav_menu('menu-2')){
                        wp_nav_menu( array(
                            'theme_location' => 'menu-2',
                            'menu_id'        => 'secondary-menu',
                            'container'      => 'nav',
                            'container_class'=> 'responsive-menu secondary-menu-container'
                        ));
                    }
                ?>
            </div>
            <?php
                $enable_header_search = get_theme_mod('enable_header_search', true);
                if($enable_header_search){
            ?>
                <div class="col-12 col-md-auto text-right">
                    <?php do_shortcode('[maester_search]'); ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="header-menu-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <nav id="site-navigation" class="main-navigation">
                    <button style="display:none;" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fas fa-bars"></i></button>
                    <?php
                        if(has_nav_menu('menu-1')){
                            wp_nav_menu( array(
                                'theme_location' => 'menu-1',
                                'menu_id'        => 'primary-menu',
                                'container'      => 'nav',
                                'container_class'=> 'responsive-menu primary-menu-container'
                            ));
                        }
                    ?>
                </nav><!-- #site-navigation -->
            </div>
            <?php
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

            <?php } ?>


        </div>
    </div>
</div>
