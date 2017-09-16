<?php get_header(); ?>
<!-- Content -->
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2 class="page-header">
				<?php if ( is_tag() ) {
						echo ( wp_title('#') );
					} 
					else {
						echo ( wp_title('') );
					}
				?>
			</h2>
			
				<?php get_template_part( 'content', get_post_format() ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>