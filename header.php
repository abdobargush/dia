<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		
		<?php wp_head();?>
		
	</head>
	<body>
		<nav class="navbar navbar-default navbar-static-top text-uppercase">
			<div class="container">
				<div class="navbar-header">
					<a href="<?php echo get_bloginfo( 'wpurl' );?>" class="navbar-brand"><?php echo get_bloginfo( 'name' ); ?></a>
				</div>
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a href="#search-modal" data-toggle="modal">
							<svg id="i-search" viewBox="0 0 32 32" width="18" height="18" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
								<circle cx="14" cy="14" r="12" />
								<path d="M23 23 L30 30"  />
							</svg>
						</a>
					</li>
					<li class="hidden-md hidden-lg">
						<a href="#menu-modal" data-toggle="modal">
							<svg id="i-menu" viewBox="0 0 32 32" width="20" height="20" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
								<path d="M4 8 L28 8 M4 16 L28 16 M4 24 L28 24" />
							</svg>
						</a>
					</li>
					<?php wp_nav_menu( 
						array (
							'menu' => 'top-menu',
							'theme_location' => 'top-menu',
							'items_wrap' =>'%3$s',
							'container' => 'false',
							'fallback_cb' => false
						)
					); ?>
				</ul>
			</div>
		</nav>