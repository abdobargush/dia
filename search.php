<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<h2 class="page-header"><?php printf( __( 'Search Results for: %s'), get_search_query()); ?></h2>
			<?php get_template_part( 'content', get_post_format() ); ?>
		</div>
	</div>
</div>
<?php get_footer(); ?>