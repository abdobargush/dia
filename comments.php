<?php if ( post_password_required() ) {
	return;
} ?>

<div id="comments" class="comments-area">
<?php 
$class_form = '<div class="form-group"><div class="col-sm-12"><label for="comment" class="control-label">Comment</label>' . '<textarea id="comment" class="form-control" name="comment" cols="45" rows="8" maxlength="65525" aria-required="true" required="required"></textarea>' . '</div></div>';

$author_field = '<div class="form-group"><div class="col-sm-6">' . '<label for="author" class="control-label">Name</label><input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" maxlength="245"' . $aria_req . $html_req . ' />' . '</div>';

$email_field = '<div class="col-sm-6">' . '<label for="email" class="control-label">E-mail</label><input id="email" class="form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" maxlength="100" aria-describedby="email-notes"' . $aria_req . $html_req  . ' />' . '</div></div>';

$sumit_button = '<div class="form-group"><div class="col-sm-12">' . '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-primary">Post Comment</button>' . '</div></div>';

$logged_in_as = '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>';

comment_form( array (
	'class_form' => 'form-horizontal comment-form',
	'comment_field' => $class_form,
	'fields' => array (
		'author' => $author_field,
		'email' => $email_field,
	),
	'submit_button' => $sumit_button,
	'format' => 'html5',
	'comment_notes_before' => false,
	'logged_in_as' => $logged_in_as,
)); ?>
	
<?php if ( have_comments() ) : ?>
	<h3 class="comments-title">
		<?php
		printf( _nx( 'One comment', '%1$s comments', get_comments_number(), 'comments title'),
			number_format_i18n( get_comments_number() ) );
		?>
	</h3>
	<ul class="comment-list media-list">
		<?php 
		wp_list_comments( array(
			'format' => 'html5',
			'callback' => 'dia_comments',
		) );
		?>
	</ul>
<?php endif; ?>
<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<p class="no-comments">
		<?php _e( 'Comments are closed.' ); ?>
	</p>
<?php endif; ?>

</div>