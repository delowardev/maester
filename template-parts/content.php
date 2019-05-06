<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-listing'); ?>>

	<?php maester_post_thumbnail(); ?>

    <div class="post-content-body">
        <header class="entry-header">
            <?php

            /* translators: used between list items, there is a space after the comma */
            $maester_categories_list = get_the_category_list( esc_html__( ', ', 'maester' ) );
            if ( $maester_categories_list ) {
                /* translators: 1: list of categories. */
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'maester' ) . '</span>', $maester_categories_list ); // WPCS: XSS OK.
            }

            the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
            ?>
        </header><!-- .entry-header -->

        <div class="entry-summary">
            <?php the_excerpt();

            wp_link_pages( array(
                'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'maester' ),
                'after'  => '</div>',
            ) );
            ?>
        </div><!-- .entry-content -->

        <footer class="entry-footer">
            <?php
                if ( 'post' === get_post_type() ) :
                    ?>
                    <div class="entry-meta">
                        <?php
                            maester_posted_by();
                            maester_posted_on();
                        ?>
                    </div><!-- .entry-meta -->
                <?php endif;
            ?>
        </footer><!-- .entry-footer -->
    </div> <!--post-content-body-->
</article><!-- #post-<?php the_ID(); ?> -->
