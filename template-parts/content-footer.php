<?php
/**
 * Template part for displaying page content in footer.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

?>
<div class="footer-widget-area">
    <div class="container">
        <?php
            $footerWidgets = array('footer-1', 'footer-2', 'footer-3', 'footer-4');
            $isFooter1 = is_active_sidebar('footer-1');
            $isFooter2 = is_active_sidebar('footer-2');
            $isFooter3 = is_active_sidebar('footer-3');
            $isFooter4 = is_active_sidebar('footer-4');
            $hasFooterWidget = $isFooter1 || $isFooter2 || $isFooter3 || $isFooter4;

            if($hasFooterWidget) echo "<div class='row'>";
            foreach ($footerWidgets as $widget){
                if(!is_active_sidebar($widget)) continue;
                echo "<div class='col-12 col-sm-6 col-md'>";
                dynamic_sidebar($widget);
                echo "</div>";
            }
            if($hasFooterWidget) echo "</div>";
        ?>
    </div>
</div>
<div class="footer-main">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="site-info">
                    <p>
                        <?php
                            $footer_text = get_theme_mod('footer_text', __("&copy; Maester, Developed by idea420", 'maester'));
                            if($footer_text){
                                echo esc_html($footer_text);
                            }
                        ?>
                    </p>
                </div><!-- .site-info -->
            </div>
            <div class="col-auto footer-menu-column">
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
