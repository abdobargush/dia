<?php // Template Name: Home Page ?>
<?php get_header(); ?>
<!-- Content -->
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div id="intro">
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_content(); ?>
			<?php endwhile;?>
			</div>
		</div>
	</div>
</div>
<?php get_footer(); ?>