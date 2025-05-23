<?php

/*----------------------------------------
	ENQUEUE STYLES
----------------------------------------- */

function campmanitou_styles() {

	wp_enqueue_style('child-theme', get_stylesheet_directory_uri() .'/css/extend.min.css?v=46', array('html5blank'));	
	
	wp_register_style('bootstrap', get_stylesheet_directory_uri() . '/css/bootstrap.min.css', array(), '1.0', 'all');
	wp_enqueue_style('bootstrap'); 
	
	if (is_page_template('page-map.php')  ) {
		wp_register_style('leaflet', get_stylesheet_directory_uri() . '/css/leaflet.css', array(), '1.0', 'all');
		wp_enqueue_style('leaflet'); 
	}
}

add_action('wp_enqueue_scripts','campmanitou_styles');


/*----------------------------------------
	ENQUEUE SCRIPTS
----------------------------------------- */
function camp_manitou_conditional_scripts()
{
   
     wp_register_script('scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), '1.0', 'all'); 
     wp_enqueue_script('scripts'); 
 
		// loads sidebar menu
		wp_deregister_script('jquery'); 
		wp_register_script('jquery', ("http".($_SERVER['SERVER_PORT'] == 443 ? "s" : "")."://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"), false, '3.6.1');
		wp_enqueue_script('jquery');
		
		// only load on Virtual Tour Page
		if (is_page_template('page-map.php')  ) {
			
		wp_register_script('leaflet-js', get_stylesheet_directory_uri() . '/js/leaflet.js', array('jquery'), '1.0', 'all'); 
      wp_enqueue_script('leaflet-js');
	    }

}
add_action('wp_enqueue_scripts', 'camp_manitou_conditional_scripts');


/*----------------------------------------
	ACF SCRIPTS
----------------------------------------- */

function load_yoast_acf_link() {
	wp_register_script('acf_yoastseo', get_template_directory_uri() . '/js/acf_yoastseo.js', array('jquery'), '1.0', 'all'); // Conditional script(s)
	 wp_enqueue_script('acf_yoastseo'); // Enqueue it !
}

add_action( 'admin_init', 'load_yoast_acf_link' );


// Register Custom Navigation Walker
require_once('wp_bootstrap_navwalker.php');

/*----------------------------------------
	SIDEBAR & FOOTER
----------------------------------------- */

if (function_exists('register_sidebar'))
{
    // Define Footer Widget Area 1
    register_sidebar(array(
        'name' => __('Alternative Sidebar'),
        'description' => __('Alternative sidebar for pages that do not have child pages. Archive, 404, Single Posts, etc.', 'campmanitou'),
        'id' => 'sidebar-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
    

    // Define Footer Widget Area 2
    register_sidebar(array(
        'name' => __('Footer Widget Area 2', 'campmanitou'),
        'description' => __('Description for this widget-area...', 'campmanitou'),
        'id' => 'footer-widget-area-2',
        'before_widget' => '<div id="%1$s" class="%2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>'
    ));
}


/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

// Create 1 Custom Post type for a Demo, called HTML5-Blank
function create_post_type_html5() {

    register_post_type('upcoming-events', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('News', 'upcomingevents'), // Rename these to suit
            'singular_name' => __('News Article', 'upcomingevents'),
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'supports' => array(
            'title',
            'editor',
            'excerpt',
            'thumbnail',
            'author'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
    ));
    
    register_taxonomy_for_object_type('category', 'activities'); // Register Taxonomies for Category
    register_post_type('activities', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Activities', 'activities'), // Rename these to suit
            'singular_name' => __('Activity', 'activities'),

        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => false,
        'menu_icon'   => 'dashicons-universal-access',
        'supports' => array(
            'title',
            'editor',
            'author',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
        'taxonomies' => array(
            'category'
        ) // Add Category and Post Tags support
    ));
    

    register_post_type('photo-albums', // Register Custom Post Type
        array(
        'labels' => array(
            'name' => __('Photo Albums', 'photoalbums'), // Rename these to suit
            'singular_name' => __('Photo Album', 'photoalbums'),
        ),
        'public' => true,
        'hierarchical' => true, // Allows your posts to behave like Hierarchy Pages
        'has_archive' => true,
        'menu_icon'   => 'dashicons-format-gallery',
        'supports' => array(
            'title',
            'editor',
            'thumbnail'
        ), // Go to Dashboard Custom HTML5 Blank post for supports
        'can_export' => true, // Allows export in Tools > Export
      ));


}


// CUSTOM EXCERPT LENGTH
function custom_excerpt_length( $length ) {
	return 20;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

/*----------------------------------------
	Sidebar Menu - Child Pages
----------------------------------------- */

function wpb_list_child_pages() { 
global $post; 

if ( is_page() && $post->post_parent )
	$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&depth=1&child_of=' . $post->post_parent . '&echo=0' );
else
	$childpages = wp_list_pages( 'sort_column=menu_order&title_li=&depth=1&child_of=' . $post->ID . '&echo=0' );

if ( $childpages ) {

	$string = '<ul>' . $childpages . '</ul>';
}
return $string;
}
add_shortcode('wpb_childpages', 'wpb_list_child_pages');



// ADDS CUSTOM ATTRIBUTE TO LOCATION MENU ITEM
add_filter( 'nav_menu_link_attributes', 'my_nav_menu_attribs', 10, 3 );
function my_nav_menu_attribs( $atts, $item, $args )
{
  // The ID of the target menu item
  $menu_target = 229;

  // inspect $item
  if ($item->ID == $menu_target) {
    $atts['data-lity'] = 'data-lity';
  }
  return $atts;
}

/*----------------------------------------
	Content Editor Styles, buttons, shortcodes
----------------------------------------- */
add_shortcode('button', 'button');
add_shortcode('button_url', 'button_url');

// Shortcode Demo with Nested Capability
function button($atts, $button = null)
{
    return '<a href="' . do_shortcode($button_url) . ' "><div class="btn">' . do_shortcode($button) . '</div></a>'; // do_shortcode allows for nested Shortcodes
}


// CONTENT EDITOR BUTTON

// Callback function to insert 'styleselect' into the $buttons array
function my_mce_buttons_2( $buttons ) {
    array_unshift( $buttons, 'styleselect' );
    return $buttons;
}
// Register our callback to the appropriate filter
add_filter('mce_buttons_2', 'my_mce_buttons_2');

// Callback function to filter the MCE settings
function my_mce_before_init_insert_formats( $init_array ) {  
    // Define the style_formats array
    $style_formats = array(  
        // Each array child is a format with it's own settings
        array(  
            'title' => 'Button',  
            'selector' => 'a',  
            'classes' => 'button'             
        )
    );  
    // Insert the array, JSON ENCODED, into 'style_formats'
    $init_array['style_formats'] = json_encode( $style_formats );  

    return $init_array;  

} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' );

 
/**
 * Add styles/classes to the "Styles" drop-down
 */
add_filter( 'tiny_mce_before_init', 'tuts_mce_before_init' );
 
function tuts_mce_before_init( $settings ) {
 
    $style_formats = array(
	  	array(
            'title' => 'Image Container',
            'selector' => 'img',
            'classes' => 'image-container'
            ),      
	    array(
            'title' => 'Button',
            'selector' => 'a',
            'classes' => 'button',
        ),
        array(
            'title' => 'Button Outlined',
            'selector' => 'a',
            'classes' => 'button-outline'
            )      
    );
 
    $settings['style_formats'] = json_encode( $style_formats );
 
    return $settings;
 
}
 
add_action('save_post', 'wpds_check_thumbnail');
add_action('admin_notices', 'wpds_thumbnail_error');

function wpds_check_thumbnail($post_id) {

    // change to any custom post type 
    if(get_post_type($post_id) != 'upcoming-events')
        return;
    
    if ( !has_post_thumbnail( $post_id ) ) {
        // set a transient to show the users an admin message
        set_transient( "has_post_thumbnail", "no" );
        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', 'wpds_check_thumbnail');
        // update the post set it to draft
        wp_update_post(array('ID' => $post_id, 'post_status' => 'draft'));

        add_action('save_post', 'wpds_check_thumbnail');
    } else {
        delete_transient( "has_post_thumbnail" );
    }
}

function wpds_thumbnail_error()
{
    // check if the transient is set, and display the error message
    if ( get_transient( "has_post_thumbnail" ) == "no" ) {
        echo "<div id='message' class='error'><p><strong>You must select Featured Image. Your Post is saved but it can not be published.</strong></p></div>";
        delete_transient( "has_post_thumbnail" );
    }

}

function post_remove ()      //creating functions post_remove for removing menu item
{ 
   remove_menu_page('edit.php');
   remove_menu_page( 'edit-comments.php' ); 
}

add_action('admin_menu', 'post_remove');   //adding action for triggering function call

// adds lightbox functionality to foogallery
function add_foogallery_link_rel($attr, $args, $attachment) {
	$attr['data-rel'] = 'lightbox-gallery-wTk0';
	return $attr;
}
add_filter('foogallery_attachment_html_link_attributes', 'add_foogallery_link_rel', 10, 3);

// Removes Widgets pulled from the Parent Theme
add_action( 'widgets_init', 'unregister_a_widget', 99 );

function unregister_a_widget() {
	unregister_sidebar( 'widget-area-1' );
	unregister_sidebar( 'widget-area-2' );
}

/*------------------------------------*\
	Disable Access to Author pages
\*------------------------------------*/

add_action('template_redirect', 'my_custom_disable_author_page');

    function my_custom_disable_author_page() {
        global $wp_query;
        if ( is_author() ) {
            $wp_query->set_404();
            status_header(404);
        }
    }

?>