<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<?php while ( have_posts() ) : the_post(); ?>
				<div class="post">
					<?php the_post_thumbnail(array(1000,300), ['class' => 'img-responsive img-rounded thumbnail-img']) ;?>
					<h2 class="post-title"><?php the_title(); ?></h2>
					<p class="text-muted"><?php _e('Published', 'dia') ?> <?php the_time(); ?></p>
					<div class="post-content">
						<?php the_content(); ?>
					</div>
					<?php
						if(get_the_tag_list()) {
							echo get_the_tag_list('<div class="tags">',null,'</div>');
						}
					?>
				</div>
				<?php if ( comments_open() || get_comments_number() ) :
					  comments_template();
				endif; ?>
			<?php endwhile;?>
		</div>
	</div>
</div>
<?php get_footer(); ?>