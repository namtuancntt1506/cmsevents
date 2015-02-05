<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, CMS Event already
 * has for Event Tag archives, Event Category archives.
 *
 * @link https://github.com/vianhtu/cmsevents
 *
 * @package CMS Event
 * @version 1.0.0
 */

get_header(); ?>

	<section id="primary" class="site-content">
		<div id="content" role="main">
			<header class="archive-header">
				<h1 class="archive-title"><?php echo single_cat_title( '', false ); ?></h1>
			</header><!-- .archive-header -->
			<?php
			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/* Include the post format-specific template for the content. If you want to
				 * this in a child theme then include a file called called content-___.php
				 * (where ___ is the post format) and that will be used instead.
				 */
				cmsevent_get_template_part( 'event' );

			endwhile;

			wp_link_pages( array(
    			'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', CMSEVENTS_NAME ) . '</span>',
    			'after'       => '</div>',
    			'link_before' => '<span>',
    			'link_after'  => '</span>',
    			'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', CMSEVENTS_NAME) . ' </span>%',
    			'separator'   => '<span class="screen-reader-text">, </span>',
			) );
			?>
		</div><!-- #content -->
	</section><!-- #primary -->
<?php get_footer(); ?>