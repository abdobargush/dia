<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<?php the_post_thumbnail(array(1000,300), ['class' => 'img-responsive img-rounded thumbnail-img']) ;?>
			<h2 class="page-header"><?php wp_title(''); ?></h2>
			<div class="page-content">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php the_content(); ?>
				<?php endwhile;?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>