<?php
/**
 * The Template for displaying all single event posts
 *
 * @package CMS Event
 * @author Fox
 * @version 1.0.0
 */

get_header(); ?>

	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php cmsevent_get_template_part( 'event' ); ?>

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>