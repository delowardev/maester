<?php
/**
 * Template part for displaying page content in footer.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

    $footerWidgets = array('footer-1', 'footer-2', 'footer-3', 'footer-4');
    $isFooter1 = is_active_sidebar('footer-1');
    $isFooter2 = is_active_sidebar('footer-2');
    $isFooter3 = is_active_sidebar('footer-3');
    $isFooter4 = is_active_sidebar('footer-4');
    $hasFooterWidget = $isFooter1 || $isFooter2 || $isFooter3 || $isFooter4;

?>

<?php if($hasFooterWidget) : ?>

<div class="footer-widget-area">
    <div class="container">
        <div class='row'>
            <?php
                foreach ($footerWidgets as $widget){
                    if(!is_active_sidebar($widget)) continue;
                    echo "<div class='col-12 col-sm-6 col-md'>";
                        dynamic_sidebar($widget);
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>

<?php endif; ?>

<?php
    $footer_text = get_theme_mod('footer_text', __("&copy; Maester, Developed by idea420", 'maester'));
    if(!empty($footer_text) || has_nav_menu('menu-3')) :
?>

<div class="footer-main">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md">
                <div class="site-info">
                    <p>
                        <?php

                            if($footer_text){
                                echo esc_html($footer_text);
                            }
                        ?>
                    </p>
                </div><!-- .site-info -->
            </div>
            <div class="col-12 col-md-auto footer-menu-column">
                <?php
                    if(has_nav_menu('menu-3')){
                        wp_nav_menu(array(
                            'theme_location' => 'menu-3',
                            'menu_id'        => 'footer-menu',
                        ));
                    }
                ?>
            </div>
        </div>
    </div>
</div>

<?php endif; ?>
