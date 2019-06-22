<?php

/**
 * Template for displaying courses
 *
 * @since v.1.0.0
 *
 * @author Themeum
 * @url https://themeum.com
 */

get_header();
maester_breadcrumbs();

?>
	<div id="content" class="site-content">
		<div class="container">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
					<?php tutor_course_archive_filter_bar(); ?>
					<?php maester_course_loop(); ?>
					<?php the_posts_pagination(); ?>
				</main>
			</div> <!--#primary-->
		</div> <!--.container-->
	</div> <!--.site-content-->
<?php get_footer();

