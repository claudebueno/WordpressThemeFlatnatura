<?php
/**
 * The template for displaying all single posts.
 *
 * @package FlatNatura
 */

get_header(); ?>

	<div class="row">
		<div class="col-md-8 content-area" role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php get_template_part( 'template-parts/content', 'single' ); ?>
			<?php flatnatura_content_nav(); ?>
			<?php
				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
			?>
		<?php endwhile; // End of the loop. ?>
		</div><!-- #main -->

<?php get_sidebar(); ?>
        </div><!-- #primary -->
<?php get_footer(); ?>
