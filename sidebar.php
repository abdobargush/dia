<!-- Sidebar -->
<div id="sidebar" class="col-md-4 hidden-xs">
	<h2 class="page-header">Tags</h2>
	<?php
	$tags = get_tags(
		array (
			'number' => 15,
			'order' => 'count',
		)
	);
	$html = '<ul class="tags tags-list">';
	foreach ( $tags as $tag ) {
		$tag_link = get_tag_link( $tag->term_id );
		$html .= "<li><a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug}'>{$tag->name}</a></li>";
	}
	$html .= '</ul>';
	echo $html;
	?>
	<?php if ( is_active_sidebar( 'blog_sidebar' ) ) : ?>
		<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
			<?php dynamic_sidebar( 'blog_sidebar' ); ?>
		</div><!-- #primary-sidebar -->
	<?php endif; ?>
</div>