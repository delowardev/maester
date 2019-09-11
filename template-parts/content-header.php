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
    $maester_lite_enable_topbar = get_theme_mod('enable_topbar', true);
    $maester_lite_topbar_text = get_theme_mod('topbar_text');

    if(empty($maester_lite_topbar_text) && !has_nav_menu('topbar')){
        $maester_lite_enable_topbar = false;
    }

    if($maester_lite_enable_topbar) {
?>

<div class="top-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <p class='top-bar-description'>
                <?php
                    if($maester_lite_topbar_text){
                        echo esc_html($maester_lite_topbar_text);
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
                    }else if(is_customize_preview()){
	                    printf("%s Topbar menu is empty, Set topbar menu first %s", "<i>", "</i>");
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php } //$maester_lite_enable_topbar ?>

<div class="header-main">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <div class="site-branding">
                    <?php
                        $maester_lite_custom_logo = get_theme_mod( 'custom_logo' );
                        if(!empty($maester_lite_custom_logo)){
                            the_custom_logo();
                        }else{
                            $maester_lite_site_url = home_url('/');
                            $maester_lite_site_title = get_bloginfo('name');
                            echo "<a href='".esc_url($maester_lite_site_url)."'>".esc_html($maester_lite_site_title)."</a>";
                        }
                    ?>
                    <p class="site-description">
                        <?php echo esc_html(get_bloginfo('description')); ?>
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
            <?php do_action('maester_lite_header_item_hook'); ?>
        </div>
    </div>
</div>
<?php
    $maester_lite_en_menubar = get_theme_mod('maester_lite_en_menubar', true);
    if($maester_lite_en_menubar) {
?>
<div class="header-menu-bar">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <div id="site-navigation" class="main-navigation">
                    <button style="display:none;" class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><i class="fas fa-bars"></i></button>
                    <?php
                        if(has_nav_menu('menu-1')){
                            wp_nav_menu( array(
                                'theme_location' => 'menu-1',
                                'menu_id'        => 'primary-menu',
                                'container'      => 'nav',
                                'container_class'=> 'responsive-menu primary-menu-container'
                            ));
                        }else if(is_user_logged_in()){
                            printf("%s Primary menu is empty, Click here to assign %s", "<a href='".esc_url(admin_url('nav-menus.php'))."'><i>", "</i></a>");
                        }

                    ?>
                </div><!-- #site-navigation -->
            </div>

            <?php do_action('maester_lite_menubar_item_hook'); ?>

        </div>
    </div>
</div>
<?php } ?>
