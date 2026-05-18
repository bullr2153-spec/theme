<?php
/**
 * The template for displaying comments
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="betpro-comments-section">
	<?php
	if ( have_comments() ) :
		?>
		<h2 class="betpro-comments-title">
			<?php
			$comment_count = get_comments_number();
			if ( 1 === $comment_count ) {
				esc_html_e( '1 Comment', 'betpro-account' );
			} else {
				echo esc_html( sprintf( _n( '%s Comment', '%s Comments', $comment_count, 'betpro-account' ), $comment_count ) );
			}
			?>
		</h2>

		<ol class="betpro-comment-list">
			<?php
			wp_list_comments( array(
				'style'      => 'ol',
				'short_ping' => true,
				'avatar_size' => 44,
			) );
			?>
		</ol>

		<?php
		// Comment pagination
		if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
			?>
			<div class="betpro-comment-navigation">
				<div class="nav-previous">
					<?php previous_comments_link( esc_html__( '&larr; Older Comments', 'betpro-account' ) ); ?>
				</div>
				<div class="nav-next">
					<?php next_comments_link( esc_html__( 'Newer Comments &rarr;', 'betpro-account' ) ); ?>
				</div>
			</div>
			<?php
		endif;

		// Comment close notification
		if ( ! comments_open() ) :
			?>
			<p class="betpro-no-comments"><?php esc_html_e( 'Comments are closed.', 'betpro-account' ); ?></p>
			<?php
		endif;
	endif;

	// Comment form
	comment_form( array(
		'class_form'         => 'betpro-comment-form',
		'label_submit'       => esc_html__( 'Post Comment', 'betpro-account' ),
		'comment_notes_before' => '',
		'comment_notes_after' => '',
		'cookies'            => false,
		'fields'             => array(
			'author' => '<p class="comment-form-author">' .
				'<label for="author">' . esc_html__( 'Name', 'betpro-account' ) . '</label> ' .
				'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245" required /></p>',
			'email'  => '<p class="comment-form-email">' .
				'<label for="email">' . esc_html__( 'Email', 'betpro-account' ) . '</label> ' .
				'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" maxlength="100" required /></p>',
		),
	) );
	?>
</div>
