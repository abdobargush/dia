<?php // Template Name: Contact Page ?>
<?php
// Custom php for Mailing thing
//response generation function

$response = "";

//function to generate response
function generate_response($type, $message){
	global $response;
	if($type == "success") $response = "<div class='alert alert-success'>{$message}</div>";
	else $response = "<div class='alert alert-danger'>{$message}</div>";
}

// response messages
$missing_content = __("Please supply all information.", 'dia');
$email_invalid   = __("Email Address Invalid.", 'dia');
$message_unsent  = __("Message was not sent. Try Again.", 'dia');
$message_sent    = __("Thanks! Your message has been sent.", 'dia');

// Sender posted vars
$contact_name = $_POST['contact_name'];
$contact_email = $_POST['contact_email'];
$contact_message = $_POST['contact_message'];

// php Mailer Vars
$to = get_option('admin_email');
$subject = __('You got a message via ', 'dia').get_bloginfo('name');
$headers = __('From: ', 'dia'). $contact_email . "\r\n" .
    	   __('Reply-To: ', 'dia') . $contact_email . "\r\n";

//validate email
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
	if (!filter_var($contact_email, FILTER_VALIDATE_EMAIL)) {
		generate_response("error", $email_invalid);
	} 
	else //email is valid
	{
		//validate presence of name and message
		if(empty($contact_name) || empty($contact_message)){
			generate_response("error", $missing_content);
		}
		else //ready to go!
		{
			$sent = wp_mail($to, $subject, $contact_message, $headers);
			if($sent) generate_response("success", $message_sent); //message sent!
			else generate_response("error", $message_unsent); //message wasn't sent
		}
	}
}

?>

<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2 class="page-header"><?php the_title(); ?></h2>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
				<hr class="invisible">
				<div class="well">
					<?php echo $response; ?>
					<form method="post" class="form-horizontal">
						<div class="form-group">
							<div class="col-sm-6">
								<label for="contact_name" class="control-label"><?php _e('Name' , 'dia') ?></label>
								<input type="text" id="contact_name" name="contact_name" class="form-control">
							</div>
							<div class="col-sm-6">
								<label for="contact_email" class="control-label"><?php _e('E-mail', 'dia') ?></label>
								<input type="email" id="contact_email" name="contact_email" class="form-control">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12">
								<label for="contact_message" class="control-label"><?php _e('Message', 'dia') ?></label>
								<textarea id="contact_message" name="contact_message" class="form-control" rows="8"></textarea>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-12 text-center">
								<input type="hidden" name="submitted" value="1">
								<button type="submit" class="btn btn-primary"><?php _e('Send Message', 'dia') ?></button>
							</div>
						</div>
					</form>
				</div>
			<?php endwhile;?>
		</div>
	</div>
</div>
<?php get_footer(); ?>