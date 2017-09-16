<?php get_header(); ?>
<div class="container">
	<div class="row">
		<!-- Main Content -->
		<div class="col-md-8 col-xs-12">
			<h2 class="page-header"><?php wp_title(''); ?></h2>
			<div class="blog-posts">
				<?php get_template_part( 'content', get_post_format() ); ?>
			</div>
		</div>
		<?php get_sidebar(); ?>
	</div>
</div>
<?php get_footer(); ?>