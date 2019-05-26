<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

get_header();
$enable_search_sidebar = get_theme_mod('enable_search_sidebar', true);
maester_breadcrumbs();
?>
    <div id="content" class="site-content">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-<?php echo esc_attr($enable_search_sidebar ? 8 : 12); ?>">
                    <div id="primary" class="content-area">
                        <main id="main" class="site-main">

                            <?php
                            if ( have_posts() ) :

                                if ( is_home() && ! is_front_page() ) :
                                    ?>
                                    <header>
                                        <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
                                    </header>
                                <?php
                                endif;
                                echo "<div class='row'>";
                                /* Start the Loop */
                                while ( have_posts() ) :
                                    the_post();

                                    /*
                                     * Include the Post-Type-specific template for the content.
                                     * If you want to override this in a child theme, then include a file
                                     * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                                     */
                                    echo "<div class='col-md-12 post-column'>";
                                    get_template_part( 'template-parts/content-search' );
                                    echo "</div>"; // .col-md-*

                                endwhile;

                                echo "</div>"; // .row

                                the_posts_pagination();

                            else :

                                get_template_part( 'template-parts/content', 'none' );

                            endif;
                            ?>

                        </main><!-- #main -->
                    </div><!-- #primary -->
                </div><!-- .col-md-* -->
                <div class="col-lg-4">
                    <?php if($enable_search_sidebar) get_sidebar(); ?>
                </div><!-- .col-md-* -->
            </div><!-- .row -->
        </div><!-- .container -->
    </div><!-- #content -->

<?php

get_footer();
