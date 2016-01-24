<?php
/**
 * Custom template tags for this theme.
 * Eventually, some of the functionality here could be replaced by core features.
 * @package FlatNatura
 */

 if ( ! function_exists( 'flatnatura_content_nav' ) ) :
 /**
  * Display navigation to next/previous pages when applicable.
  */
 function flatnatura_content_nav( $nav_id ) {
 	global $wp_query, $post;

 	// Don't print empty markup on single pages if there's nowhere to navigate.
 	if ( is_single() ) {
 		$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
 		$next = get_adjacent_post( false, '', false );

 		if ( ! $next && ! $previous )
 			return;
 	}

 	// Don't print empty markup in archives if there's only one page.
 	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) )
 		return;

 	$nav_class = ( is_single() ) ? 'post-navigation' : 'paging-navigation';

 	?>
 	<nav id="<?php echo esc_attr( $nav_id ); ?>" class="clearfix <?php echo $nav_class; ?>" role="navigation">
 	<?php if ( is_single() ) : ?>

 		<?php previous_post_link( '<div class="nav-previous">%link</div>', '<span class="meta-nav">' . _x( '<i class="fa fa-chevron-left"></i> Previous Article', 'Previous Article', 'flatnatura' ) . '</span> %title' ); ?>
 		<?php next_post_link( '<div class="nav-next">%link</div>', '<span class="meta-nav">' . _x( 'Next Article <i class="fa fa-chevron-right"></i>', 'Next Article', 'flatnatura' ) . '</span> %title' ); ?>

 	<?php elseif ( $wp_query->max_num_pages > 1 && ( is_home() || is_archive() || is_search() ) ) : ?>

 		<?php if ( get_next_posts_link() ) : ?>
 		<div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav"><i class="fa fa-chevron-left"></i></span> Previous Articles', 'flatnatura' ) ); ?></div>
 		<?php endif; ?>

 		<?php if ( get_previous_posts_link() ) : ?>
 		<div class="nav-next"><?php previous_posts_link( __( 'Next Articles <span class="meta-nav"><i class="fa fa-chevron-right"></i></span>', 'flatnatura' ) ); ?></div>
 		<?php endif; ?>

 	<?php endif; ?>

 	</nav><!-- #<?php echo esc_html( $nav_id ); ?> -->
 	<?php
 }
 endif;
 
if ( ! function_exists( 'flatnatura_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function flatnatura_posted_on() {
	$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	printf( __( '<span class="byline"><i class="fa fa-user"></i>%1$s</span><span class="posted-on"><i class="fa fa-calendar"></i>%2$s</span>', 'flatnatura' ),
		sprintf( '<span class="author vcard"><a class="url fn n" href="%1$s">%2$s</a></span>',
			esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
			esc_html( get_the_author() )
		),
		sprintf( '<a href="%1$s" rel="bookmark">%2$s</a>',
			esc_url( get_permalink() ),
			$time_string
		)
	);
}
endif;

if ( ! function_exists( 'flatnatura_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function flatnatura_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'flatnatura' ) );
		if ( $categories_list && flatnatura_categorized_blog() ) {
			printf( '<span class="cat-links"><i class="fa fa-folder-open"></i>' . esc_html__( ' %1$s', 'flatnatura' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'flatnatura' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="fa fa-tag"></i>' . esc_html__( ' %1$s', 'flatnatura' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link"><i class="fa fa-comments"></i>';
		comments_popup_link( esc_html__( ' Leave a comment', 'flatnatura' ), esc_html__( '1 Comment', 'flatnatura' ), esc_html__( '% Comments', 'flatnatura' ) );
		echo '</span>';
	}

	edit_post_link( esc_html__( 'Edit', 'flatnatura' ), '<span class="edit-link"><i class="fa fa-pencil"></i>', '</span>' );
}
endif;

if ( ! function_exists( 'the_archive_title' ) ) :
/**
 * Shim for `the_archive_title()`.
 *
 * Display the archive title based on the queried object.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the title. Default empty.
 * @param string $after  Optional. Content to append to the title. Default empty.
 */
function the_archive_title( $before = '', $after = '' ) {
	if ( is_category() ) {
		$title = sprintf( esc_html__( 'Category: %s', 'flatnatura' ), single_cat_title( '', false ) );
	} elseif ( is_tag() ) {
		$title = sprintf( esc_html__( 'Tag: %s', 'flatnatura' ), single_tag_title( '', false ) );
	} elseif ( is_author() ) {
		$title = sprintf( esc_html__( 'Author: %s', 'flatnatura' ), '<span class="vcard">' . get_the_author() . '</span>' );
	} elseif ( is_year() ) {
		$title = sprintf( esc_html__( 'Year: %s', 'flatnatura' ), get_the_date( esc_html_x( 'Y', 'yearly archives date format', 'flatnatura' ) ) );
	} elseif ( is_month() ) {
		$title = sprintf( esc_html__( 'Month: %s', 'flatnatura' ), get_the_date( esc_html_x( 'F Y', 'monthly archives date format', 'flatnatura' ) ) );
	} elseif ( is_day() ) {
		$title = sprintf( esc_html__( 'Day: %s', 'flatnatura' ), get_the_date( esc_html_x( 'F j, Y', 'daily archives date format', 'flatnatura' ) ) );
	} elseif ( is_tax( 'post_format' ) ) {
		if ( is_tax( 'post_format', 'post-format-aside' ) ) {
			$title = esc_html_x( 'Asides', 'post format archive title', 'flatnatura' );
		} elseif ( is_tax( 'post_format', 'post-format-gallery' ) ) {
			$title = esc_html_x( 'Galleries', 'post format archive title', 'flatnatura' );
		} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
			$title = esc_html_x( 'Images', 'post format archive title', 'flatnatura' );
		} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
			$title = esc_html_x( 'Videos', 'post format archive title', 'flatnatura' );
		} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
			$title = esc_html_x( 'Quotes', 'post format archive title', 'flatnatura' );
		} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
			$title = esc_html_x( 'Links', 'post format archive title', 'flatnatura' );
		} elseif ( is_tax( 'post_format', 'post-format-status' ) ) {
			$title = esc_html_x( 'Statuses', 'post format archive title', 'flatnatura' );
		} elseif ( is_tax( 'post_format', 'post-format-audio' ) ) {
			$title = esc_html_x( 'Audio', 'post format archive title', 'flatnatura' );
		} elseif ( is_tax( 'post_format', 'post-format-chat' ) ) {
			$title = esc_html_x( 'Chats', 'post format archive title', 'flatnatura' );
		}
	} elseif ( is_post_type_archive() ) {
		$title = sprintf( esc_html__( 'Archives: %s', 'flatnatura' ), post_type_archive_title( '', false ) );
	} elseif ( is_tax() ) {
		$tax = get_taxonomy( get_queried_object()->taxonomy );
		/* translators: 1: Taxonomy singular name, 2: Current taxonomy term */
		$title = sprintf( esc_html__( '%1$s: %2$s', 'flatnatura' ), $tax->labels->singular_name, single_term_title( '', false ) );
	} else {
		$title = esc_html__( 'Archives', 'flatnatura' );
	}

	/**
	 * Filter the archive title.
	 *
	 * @param string $title Archive title to be displayed.
	 */
	$title = apply_filters( 'get_the_archive_title', $title );

	if ( ! empty( $title ) ) {
		echo $before . $title . $after;  // WPCS: XSS OK.
	}
}
endif;

if ( ! function_exists( 'the_archive_description' ) ) :
/**
 * Shim for `the_archive_description()`.
 *
 * Display category, tag, or term description.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 *
 * @param string $before Optional. Content to prepend to the description. Default empty.
 * @param string $after  Optional. Content to append to the description. Default empty.
 */
function the_archive_description( $before = '', $after = '' ) {
	$description = apply_filters( 'get_the_archive_description', term_description() );

	if ( ! empty( $description ) ) {
		/**
		 * Filter the archive description.
		 *
		 * @see term_description()
		 *
		 * @param string $description Archive description to be displayed.
		 */
		echo $before . $description . $after;  // WPCS: XSS OK.
	}
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function flatnatura_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'flatnatura_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'flatnatura_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so flatnatura_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so flatnatura_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in flatnatura_categorized_blog.
 */
function flatnatura_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'flatnatura_categories' );
}
add_action( 'edit_category', 'flatnatura_category_transient_flusher' );
add_action( 'save_post',     'flatnatura_category_transient_flusher' );
