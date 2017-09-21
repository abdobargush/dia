<?php

function dia_setup() {
    /*
     * Make theme available for translation.
     * If you're building a theme based on DIA', use a find and replace
     * to change 'twentyseventeen' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'dia' );
	
	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );
	
	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );
	
	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	
	// This theme uses wp_nav_menu() in two locations.
	register_nav_menus( array(
		'top-menu' => __( 'Top Menu', 'dia'),
		'social-menu' => __( 'Social Links Menu', 'dia') )
	);
	
}
add_action( 'after_setup_theme', 'dia_setup' );

// Add scripts and stylesheets
function dia_scripts() {
	wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), '3.3.7' );
	// Add bootstrap-rtl.css to support rtl languages
	if ( is_rtl() ) {
		wp_enqueue_style( 'bootstrap', get_template_directory_uri() . '/css/bootstrap-rtl.min.css', array(), '3.3.7' );
	}
	wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', array( 'jquery' ), '3.3.7', true );
}
add_action( 'wp_enqueue_scripts', 'dia_scripts' );

// Add Google Fonts
function dia_google_fonts() {
	// Add fonts specified for Arabic
	if ( (get_locale() == 'ar') ) {
		wp_register_style('droidArabicKufi', '//fonts.googleapis.com/earlyaccess/droidarabickufi.css', array() , null);
		wp_enqueue_style( 'droidArabicKufi');
		wp_register_style('droidArabicNaskh', '//fonts.googleapis.com/earlyaccess/droidarabicnaskh.css', array() , null);
		wp_enqueue_style( 'droidArabicNaskh');
	}
	// Default fonts for English and languages that use latin characters
	else {
		wp_register_style('defaultFonts', 'https://fonts.googleapis.com/css?family=Arvo:400,700|Raleway:300,400,700', array() , null);
		wp_enqueue_style( 'defaultFonts');
	}
}
add_action('wp_print_styles', 'dia_google_fonts');

// Sidebar Widgets
function sidebart_widgets() {

	register_sidebar( array(
		'name'          => 'Blog sidebar',
		'id'            => 'blog_sidebar',
		'before_widget' => '<div class="sidebar-widget">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="page-header">',
		'after_title'   => '</h2>',
	) );

}
add_action( 'widgets_init', 'sidebart_widgets' );

/* 
 * DIA' Tags
 * Is a custom widget to display tags in theme's style.
 */
function dia_tags_load_widget() {
	register_widget('dia_tags_widget');
}
add_action( 'widgets_init', 'dia_tags_load_widget' );

class dia_tags_widget extends WP_widget {
	function __construct() {
		parent::__construct(
			'dia_tags_widget', // Widget Base ID
			__('DIA\' Tags', 'dia'), // Widget Name
			array('description' => __('A list of your most used tags.', 'dia') ) // Widget Description
		);
	}
	
	/*
	 * Widget Backend
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = '';
		}
		if ( isset( $instance[ 'max_no' ] ) ) {
			$max_no = $instance[ 'max_no' ];
		}
		else {
			$max_no = '5';
		}
		
		// Widget Admin Form
		?>
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'dia'); ?></label>
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'max_no' ); ?>"><?php _e( 'Maximum Number:', 'dia'); ?></label>
				<input id="<?php echo $this->get_field_id( 'max_no' ); ?>" name="<?php echo $this->get_field_name( 'max_no' ); ?>" type="text" value="<?php echo esc_attr( $max_no ); ?>" />
			</p>
		<?php
	}
	
	/*
	 * Widget Frontend
	 */
	public function widget( $args, $instance ) {
		$title = apply_filters( 'widget_title', $instance['title'] );
		// Before Widget
		echo $args['before_widget'];
		if ( ! empty( $title ) ) echo $args['before_title'] . $title . $args['after_title'];
		$tags = get_tags(
			array (
				'number' => $instance['max_no'],
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
		// After Widget
		echo $args['after_widget'];
	}
	
	// Update instances
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['max_no'] = ( ! empty( $new_instance['max_no'] ) ) ? strip_tags( $new_instance['max_no'] ) : '';
		return $instance;
	}
}

// Custom Comments template
function dia_comments($comment, $args, $depth) {  
	$GLOBALS['comment'] = $comment; ?>
	   <li id="comment-<?php comment_ID() ?>" class="comment media">
		   <div class="media-left">
			   <?php echo get_avatar( $comment, 64 ); ?>
		   </div>
		   <div class="media-body">
			   <h4 class="media-hading"><?php echo ( get_comment_author($comment) ); ?></h4>
			   <p class="small text-muted"><?php printf(__('%1$s'), get_comment_date() . ' @ ' . get_comment_time()) ?></p>
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

// Theme options
function theme_options_add_menu() {
  add_menu_page( 'DIA\' Theme Options', 'Theme Options', 'manage_options', 'theme-options', 'theme_options_page', null, 99 );
}
add_action( 'admin_menu', 'theme_options_add_menu' );

function theme_options_page() { ?>
  <div class="wrap">
    <h1>DIA' Theme Options</h1>
    <form method="post" action="options.php">
       <?php
           settings_fields( 'section' );
           do_settings_sections( 'theme-options' );      
           submit_button(); 
       ?>          
    </form>
  </div>
<?php }

function setting_footer_text() { ?>
   <input type="text" name="footer_text" id="footer_text" value="<?php echo str_replace('"','\'',get_option( 'footer_text' )); ?>" />
<?php }

function theme_options_page_setup() {
  add_settings_section( 'section', 'Footer', null, 'theme-options' );
  add_settings_field( 'footer_text', 'Footer Text', 'setting_footer_text', 'theme-options', 'section' );

  register_setting('section', 'footer_text');
}
add_action( 'admin_init', 'theme_options_page_setup' );

// Portfolio
function create_portfolio_post() {
	register_post_type( 'portfolio',
			array(
			'labels' => array(
					'name' => __( 'Portfolio' ),
					'singular_name' => __( 'Portfolio Item' ),
			),
			'public' => true,
			'has_archive' => true,
			'rewrite' => ['slug' => 'portfolio'],
			'menu_icon' => __('dashicons-format-gallery'),
			'supports' => array(
					'title',
					'thumbnail',
			)
	));
}
add_action( 'init', 'create_portfolio_post' );

// portfolio archive
add_action( 'pre_get_posts' ,'portflio_archive_get_posts', 1, 1 );
function portflio_archive_get_posts( $query )
{
    if ( ! is_admin() && is_post_type_archive( 'portfolio' ) && $query->is_main_query() )
    {
        $query->set( 'posts_per_page', 9 ); //set query arg ( key, value )
    }
}

// Portfolio project link Metabox
function project_link_metabox() {
	add_meta_box(
		'project_link_box',
		'Project Link',
		'project_link_box_content',
		'portfolio',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes', 'project_link_metabox' );

function project_link_box_content() {
	global $post; ?>

	<input type="hidden" name="project_link_box_nonce" value="<?php echo wp_create_nonce( basename(__FILE__) ); ?>">

	<p>
		<label for="project_link_fields[url]">Input Text</label>
		<input type="url" name="project_link" id="project_link" class="regular-text" value="<?php echo get_post_meta( $post->ID, 'project_link', true ); ?>">
	</p>

<?php }

function save_project_link_meta( $post_id ) { 
	
	// verify nonce
	if ( !wp_verify_nonce( $_POST['project_link_box_nonce'], basename(__FILE__) ) ) {
		return $post_id; 
	}
	// check autosave
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return $post_id;
	}
	// check permissions
	if ( 'page' === $_POST['post_type'] ) {
		if ( !current_user_can( 'edit_page', $post_id ) ) {
			return $post_id;
		} elseif ( !current_user_can( 'edit_post', $post_id ) ) {
			return $post_id;
		}  
	}
	
	$old = get_post_meta( $post_id, 'project_link', true );
	$new = $_POST['project_link'];

	if ( $new && $new !== $old ) {
		update_post_meta( $post_id, 'project_link', $new );
	} elseif ( '' === $new && $old ) {
		delete_post_meta( $post_id, 'project_link', $old );
	}
}
add_action( 'save_post', 'save_project_link_meta' );

?>