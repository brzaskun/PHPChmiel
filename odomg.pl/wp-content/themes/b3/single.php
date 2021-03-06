<?php
/**
 * The Template for displaying all single posts.
 *
 * @package B3
 */

get_header(); ?>

	<div id="primary" class="content-area col-md-9 col-sm-8 col-xs-12">
		<main id="main" class="site-main" role="main">

		<?php while ( have_posts() ) : the_post(); ?>

			<?php get_template_part('content', 'single'); ?>

			<?php b3theme_content_nav('nav-below'); ?>

			<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template();
			?>

		<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer();
