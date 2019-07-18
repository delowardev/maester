<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Maester
 */

get_header();
maester_breadcrumbs();
?>
    <div id="content" class="site-content">
        <div class="container">
            <div id="primary" class="content-area">
                <main id="main" class="site-main">
                    <section class="error-404 not-found">
                        <header class="page-header">
                            <h1 class="page-title"><?php esc_html_e( 'Oops! That page can&rsquo;t be found.', 'maester' ); ?></h1>
                        </header><!-- .page-header -->

                        <div class="page-content">
                            <p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'maester' ); ?></p>
                            <?php get_search_form(); ?>
                        </div><!-- .page-content -->
                        <div class="widget-area-404">
                            <div class="row">
                                <div class="col-md-6">
                                    <?php the_widget( 'WP_Widget_Recent_Posts' ); ?>
                                </div>
                                <div class="col-md-6">
                                    <div class="widget widget_categories">
                                        <h2 class="widget-title"><?php esc_html_e( 'Most Used Categories', 'maester' ); ?></h2>
                                        <ul>
                                            <?php
                                            wp_list_categories( array(
                                                'orderby'    => 'count',
                                                'order'      => 'DESC',
                                                'show_count' => 1,
                                                'title_li'   => '',
                                                'number'     => 10,
                                            ) );
                                            ?>
                                        </ul>
                                    </div><!-- .widget -->
                                </div>
                                <div class="col-md-6">
                                    <?php
                                        /* translators: %1$s: smiley */
                                        $maester_archive_content = '<p>' . sprintf( esc_html__( 'Try looking in the monthly archives. %1$s', 'maester' ), convert_smilies( ':)' ) ) . '</p>';
                                        the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$maester_archive_content" );
                                        the_widget( 'WP_Widget_Tag_Cloud' );
                                    ?>
                                </div>
                            </div>
                        </div>

                    </section><!-- .error-404 -->

                </main><!-- #main -->
            </div><!-- #primary -->
        </div><!-- .container -->
    </div><!-- #content -->
<?php
get_footer();
