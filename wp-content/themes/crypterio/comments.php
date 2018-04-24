<?php
if ( post_password_required() ) {
	return;
}

?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ): ?>
		<h4 class="comments-title">
			<?php comments_number(); ?>
		</h4>

		<ul class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ul',
					'short_ping'  => true,
					'avatar_size' => 87,
					'callback'    => 'crypterio_comment'
				) );
			?>
		</ul>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ): ?>
			<nav class="navigation comment-navigation" role="navigation">
				<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'crypterio' ); ?></h2>
				<div class="nav-links">
					<?php
					if ( $prev_link = get_previous_comments_link( esc_html__( 'Older Comments', 'crypterio' ) ) ) {
						printf( '<div class="nav-previous">%s</div>', $prev_link );
					}
					if ( $next_link = get_next_comments_link( esc_html__( 'Newer Comments', 'crypterio' ) ) ) {
						printf( '<div class="nav-next">%s</div>', $next_link );
					}
					?>
				</div>
			</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ): ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'crypterio' ); ?></p>
	<?php endif; ?>

	<?php comment_form( array(
		'comment_notes_before' => '',
		'title_reply' => esc_html__('Add a Comment', 'crypterio'),
		'comment_notes_after' => ''
	) ); ?>

</div>