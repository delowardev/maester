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

?>
	<div id="content" class="site-content">
		<div class="container">
			<div id="primary" class="content-area">
				<main id="main" class="site-main">
					<?php tutor_course_archive_filter_bar(); ?>
					<div class="maester-tutor-courses">
						<?php maester_course_loop(); ?>
					</div>
					<?php the_posts_pagination(); ?>
				</main>
			</div> <!--#primary-->
		</div> <!--.container-->
	</div> <!--.site-content-->
<?php get_footer();

