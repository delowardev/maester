<?php
/**
 * Template part for displaying page content in footer.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

    $maester_footerWidgets = array('footer-1', 'footer-2', 'footer-3', 'footer-4');
    $maester_isFooter1 = is_active_sidebar('footer-1');
    $maester_isFooter2 = is_active_sidebar('footer-2');
    $maester_isFooter3 = is_active_sidebar('footer-3');
    $maester_isFooter4 = is_active_sidebar('footer-4');
    $maester_hasFooterWidget = $maester_isFooter1 || $maester_isFooter2 || $maester_isFooter3 || $maester_isFooter4;

    $maester_enable_footer = get_theme_mod('enable_footer', true);
    $maester_enable_footer_bottom = get_theme_mod('enable_footer_bottom', true);

?>

<?php if($maester_enable_footer && $maester_hasFooterWidget) : ?>

<div class="footer-widget-area">
    <div class="container">
        <div class='row'>
            <?php
                foreach ($maester_footerWidgets as $maester_widget){
                    if(!is_active_sidebar($maester_widget)) continue;
                    echo "<div class='col-12 col-sm-6 col-md'>";
                        dynamic_sidebar($maester_widget);
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>

<?php endif; ?>

<?php
    $maester_footer_text = get_theme_mod('footer_text', sprintf("&copy; %s %s. ", date('Y') , get_bloginfo('name')) );
	$footer_credit = get_theme_mod('footer_credit', "credit_1");
	$copyright_credit = maester_get_copyright_credits();
    if((!empty($maester_footer_text) || !empty($footer_credit) || has_nav_menu('menu-3')) && $maester_enable_footer_bottom) :
?>

<div class="footer-main">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md">
                <div class="site-info">
                    <p>
                        <?php

                            if($maester_footer_text){
                                echo esc_html($maester_footer_text). " ";
                            }

                            echo "none" != $footer_credit ? $copyright_credit[$footer_credit] : '';

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
