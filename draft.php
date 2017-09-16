<?php

add_theme_support( 'title-tag' );
add_theme_support( 'post-thumbnails' );
// Menus
function dia_custom_menus() {
  register_nav_menus(
    array(
      'top-menu' => __( 'Top Menu' ),
      'social-menu' => __( 'Social Links Menu' )
    )
  );
}
add_action( 'init', 'dia_custom_menus' );

// Add scripts and stylesheets
function dia_scripts() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );
}
add_action( 'wp_enqueue_scripts', 'dia_scripts' );

// Theme Panel
add_action("admin_menu", "add_theme_menu_item");
function add_theme_menu_item()
{
	add_menu_page("Theme Panel", "Theme Panel", "manage_options", "theme-panel", "theme_settings_page", null, 99);
	
	add_action("admin_init", "display_theme_panel_fields");
}
function display_theme_panel_fields()
{
	register_setting("section", "footer_text");
	add_settings_section("section", "Footer", null, "theme-options");
	add_settings_field("footer_text", "Footer Text", "display_footer_element", "theme-options", "section");
}
function theme_settings_page()
{
    ?>
	    <div class="wrap">
	    <h1>Theme Panel</h1>
	    <form method="post" action="options.php">
	        <?php
	            settings_fields("section");
	            do_settings_sections("theme-options");      
	            submit_button(); 
	        ?>          
	    </form>
		</div>
	<?php
}
function display_footer_element()
{
	?>
		<textarea name="footer_text" id="footer_text" value="<?php esc_attr( get_option('footer_text') ); ?>"></textarea>
    <?php
}

// Custom Comments
function dia_comments($comment, $args, $depth) {  
	$GLOBALS['comment'] = $comment; ?>
	   <li id="comment-<?php comment_ID() ?>" class="comment media">
		   <div class="media-left">
			   <?php echo get_avatar( $comment, 64 ); ?>
		   </div>
		   <div class="media-body">
			   <h4 class="media-hading"><?php echo ( get_comment_author($comment) ); ?></h4>
			   <p class="small text-muted"><?php printf(__('%1$s'), get_comment_date() . ' at ' . get_comment_time()) ?></p>
			   <p><?php echo (get_comment_text()); ?></p>
			   <p><?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => '<svg id="i-reply" viewBox="0 0 32 32" width="16" height="16" fill="none" stroke="currentcolor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5">
				<path d="M10 6 L3 14 10 22 M3 14 L18 14 C26 14 30 18 30 26" />
		    	</svg> Reply'))) ?></p>
		   </div>
		   
   <?php 
}

// Replies
function theme_queue_js(){
if ( (!is_admin()) && is_singular() && comments_open() && get_option('thread_comments') )
  wp_enqueue_script( 'comment-reply' );
}
add_action('wp_print_scripts', 'theme_queue_js');

// Portfolio
function create_portfolio_post() {
	register_post_type( 'portfolio-post',
			array(
			'labels' => array(
					'name' => __( 'Portfolio' ),
					'singular_name' => __( 'Portfolio Item' ),
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => array ('slug' => 'portfolio'),
			'menu_icon' => __('dashicons-format-gallery'),
			'supports' => array(
					'title',
					'thumbnail',
			)
	));
}
add_action( 'init', 'create_portfolio_post' );

// Portfolio Metabox
add_action( 'add_meta_boxes', 'portfolio_item_box' );
function portfolio_item_box() {
    add_meta_box( 
        'portfolio_item_metabox',
        'Portfolio Project Link',
        'portfolio_item_box_content',
        'portfolio-post',
        'normal',
        'high'
    );
}

function portfolio_item_box_content( $post ) {
	$values = get_post_custom( $post->ID );
	$text = isset( $values['project_link'] ) ? esc_attr( $values['project_link'][0] ) : '';
	wp_nonce_field( 'portfolio_item_box_nonce' , 'portfolio_item_box_content_nonce' );
	?>
	   <p>
		<label for="project_link">Project link: </label>
		<input type="url" id="project_link" name="project_link" value="<?php echo ( $text ); ?>" />
	   </p>
	<?php
}

add_action( 'save_post', 'portfolio_item_box_save' );
function portfolio_item_box_save( $post_id )
{
    // Bail if we're doing an auto save
    if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
     
    // if nonce isn't there, or we can't verify it, bail
    if( !isset( $_POST['portfolio_item_box_content_nonce'] ) || !wp_verify_nonce( $_POST['portfolio_item_box_content_nonce'], 'portfolio_item_box_nonce' ) ) return;
     
    // if our current user can't edit this post, bail
    if( !current_user_can( 'edit_post' ) ) return;
	
	if( isset( $_POST['project_link'] ) )
        update_post_meta( $post_id, 'project_link', wp_kses( $_POST['project_link'], $allowed ) );
}

?>