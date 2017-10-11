<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<div id="post-<?php the_ID(); ?>" <?php post_class('blog-post'); ?>>
	<a href="<?php the_permalink(); ?>">
		<?php if ( has_post_thumbnail() ) {
			echo ('<div class="post-thumb">');
			the_post_thumbnail(array(1000,300), ['class' => 'img-responsive img-rounded']);
			echo ('</div>');
		} ?>
		<h3 class="post-heading"><?php the_title(); ?></h3>
	</a>
	<div class="sub-info">
		<div class="row">
			<div class="col-xs-6"><p class="text-muted small"><?php _e('Puplished', 'dia') ?> <?php echo get_the_date(); ?></p></div>
			<div class="col-xs-6 text-right">
				<p class="text-muted small"><a href="<?php comments_link(); ?>" class="comments-link"><?php comments_number( __('no responses', 'dia'), __('one response', 'dia'), __('% responses', 'dia') ); ?></a></p>
			</div>
		</div>
	</div>
	<?php if ( !has_post_thumbnail() ) {
		the_excerpt(); 
	} ?>
	<?php
		if(get_the_tag_list()) {
			echo get_the_tag_list('<div class="tags">',null,'</div>');
		}
	?>
</div>
<?php endwhile; ?>
<?php if ( paginate_links() != null ) {
	echo ('<!-- Pagination -->');
	echo ('<div class="text-center">');
	echo ('<nav aria-label="Page navigation">');
			 echo paginate_links( array(
					'type' => 'list',
					'next_text' => '<svg id="i-arrow-right" viewBox="0 0 32 32" width="18" height="18" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
							<path d="M22 6 L30 16 22 26 M30 16 L2 16" />
						</svg>',
					'prev_text' => '<svg id="i-arrow-left" viewBox="0 0 32 32" width="18" height="18" fill="none" 	stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
						<path d="M10 6 L2 16 10 26 M2 16 L30 16" />
					</svg>',
				)		
			);
		echo ('</nav>');
	echo ('</div>');
} ?>
<?php else : ?>
	<p><?php _e('Sorry, no posts matched your criteria.', 'dia'); ?></p>
<?php endif; ?>