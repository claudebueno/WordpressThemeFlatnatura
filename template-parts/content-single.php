<?php
/**
 * Template part for displaying single posts.
 *
 * @package FlatNatura
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

		<div class="entry-meta">
			<?php flatnatura_posted_on(); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'flatnatura' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<!-- Bio auteur -->
	<div class="author-bio">
		<div class="bio-avatar"><?php echo get_avatar(get_the_author_meta('user_email'),'128'); ?></div>
		<p class="bio-name"><?php the_author_meta('display_name'); ?></p>
		<p class="bio-desc"><?php the_author_meta('description'); ?></p>
		<div class="clear"></div>
	</div>
		<!-- Similar items -->
		<?php    
		$tags = wp_get_post_tags($post->ID);
		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
				'tag__in' => $tag_ids,
				'post__not_in' => array($post->ID),
				'showposts'=>6, // nombre d'articles à afficher
				'caller_get_posts'=>1
			);
			$my_query = new wp_query($args);
			if( $my_query->have_posts() ) {
				echo '<h4>Articles similaires</h4><ul>';
				while ($my_query->have_posts()) {
					$my_query->the_post();
				?>
					<li>
					  <a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
					</li>
				<?php
				}
				echo '</ul><br>';
			}
			wp_reset_postdata();
		}
		?>
	<footer class="entry-footer">
		<?php flatnatura_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->
