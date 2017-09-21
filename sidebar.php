<!-- Sidebar -->
<div id="sidebar" class="col-md-4 hidden-xs">
	<?php if ( is_active_sidebar( 'blog_sidebar' ) ) : ?>
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'blog_sidebar' ); ?>
		</div><!-- #primary-sidebar -->
	<?php endif; ?>
</div>