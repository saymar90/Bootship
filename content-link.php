<?php
/**
 * The template for displaying posts in the Link post format
 *
 * @package WordPress
 * @since Bootship 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<h1 class="entry-title">
			<a href="<?php echo esc_url( bootship_get_link_url() ); ?>"><?php the_title(); ?></a>
		</h1>

		<div class="entry-meta">
			<?php bootship_entry_date(); ?>
			<?php edit_post_link( __( 'Edit', 'bootship' ), '<span class="edit-link">', '</span>' ); ?>
		</div><!-- .entry-meta -->
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'bootship' ) ); ?>
		<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'bootship' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
	</div><!-- .entry-content -->

	<?php if ( is_single() ) : ?>
	<footer class="entry-meta">
		<?php bootship_entry_meta(); ?>
		<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : ?>
			<?php get_template_part( 'author-bio' ); ?>
		<?php endif; ?>
	</footer><!-- .entry-meta -->
	<?php endif; // is_single() ?>
</article><!-- #post -->
