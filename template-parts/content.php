<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Maester
 */

    $enable_blog_thumbnail = get_theme_mod('enable_blog_thumbnail', true);
    $enable_blog_category = get_theme_mod('enable_blog_category', true);
    $enable_blog_content = get_theme_mod('enable_blog_content', true);
    $enable_blog_author = get_theme_mod('enable_blog_author', true);
    $enable_blog_date = get_theme_mod('enable_blog_date', true);

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('post-listing'); ?>>

	<?php if($enable_blog_thumbnail) maester_post_thumbnail(); ?>

    <div class="post-content-body">
        <header class="entry-header">
            <?php

            /* translators: used between list items, there is a space after the comma */
            $maester_categories_list = get_the_category_list( esc_html__( ', ', 'maester' ) );
            if ( $enable_blog_category && $maester_categories_list ) {
                /* translators: 1: list of categories. */
                printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'maester' ) . '</span>', $maester_categories_list ); // WPCS: XSS OK.
            }

            the_title( '<h3 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h3>' );
            ?>
        </header><!-- .entry-header -->

        <div class="entry-summary">
            <?php if($enable_blog_content) maester_custom_excerpt(get_the_content(), get_theme_mod('maester_excerpt_length', 150)); ?>
        </div><!-- .entry-content -->

        <?php if($enable_blog_author || $enable_blog_date) { ?>
        <footer class="entry-footer">
            <?php
                if ( 'post' === get_post_type() ) :
                    ?>
                    <div class="entry-meta">
                        <?php
                            if($enable_blog_author) maester_posted_by();
                            if($enable_blog_date) maester_posted_on();
                        ?>
                    </div><!-- .entry-meta -->
                <?php endif;
            ?>
        </footer><!-- .entry-footer -->
        <?php } ?>
    </div> <!--post-content-body-->
</article><!-- #post-<?php the_ID(); ?> -->
