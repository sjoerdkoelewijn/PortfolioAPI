<?php

add_theme_support( 'title-tag' );
add_theme_support( 'menus' );
add_theme_support( 'automatic-feed-links' );
add_theme_support( 'post-thumbnails' );

add_post_type_support('page', 'excerpt');


/***************************** Register menus *************************************/

register_nav_menus( array(
	'main-navigation' => __( 'Main Navigation', 'sjoerd' ),
	'social-menu' => __( 'Social Menu', 'sjoerd' ),
	'service-navigation' => __( 'Service Menu', 'sjoerd' ),
	'links-menu' => __( 'Links Menu', 'sjoerd' ),
) );


/*************************** Enqueue Styles **********************************/



function sjoerd_styles() {

	$filename = get_stylesheet_directory() . '/styles/app.css';
	$timestamp = filemtime($filename);

	wp_enqueue_style('sjoerd-styles', get_template_directory_uri() . '/styles/app.css', NULL, $timestamp, 'all' );
	wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Heebo:400,900&display=swap', NULL, NULL, 'all' );


}
add_action( 'wp_enqueue_scripts', 'sjoerd_styles', 99 );



/*************************** Remove wordpress functionality **********************************/

remove_action( 'admin_print_styles', 'print_emoji_styles' );
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

remove_filter ('the_excerpt', 'wpautop');
remove_filter ('the_content', 'wpautop');
remove_filter('term_description','wpautop');



if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name' => 'Menu Text',

  )
);


/*************************** REMOVE POSTS & COMMENTS FROM ADMIN **********************************/

function remove_admin_menus() {

	remove_menu_page('edit.php');
	remove_menu_page( 'edit-comments.php' );

}

add_action( 'admin_menu', 'remove_admin_menus' );



/*************************** CUSTOM POST TYPES **********************************/

// Register Custom posttype
function custom_webportfolio() {

	$labels = array(
			'name'                  => _x( 'Work', 'Post Type General Name', 'sjoerd' ),
			'singular_name'         => _x( 'Work Case', 'Post Type Singular Name', 'sjoerd' ),
			'menu_name'             => __( 'Portfolio', 'sjoerd' ),
			'name_admin_bar'        => __( 'Portfolio', 'sjoerd' ),
			'archives'              => __( 'Item Archives', 'sjoerd' ),
			'attributes'            => __( 'Item Attributes', 'sjoerd' ),
			'parent_item_colon'     => __( 'Parent Item:', 'sjoerd' ),
			'all_items'             => __( 'All Items', 'sjoerd' ),
			'add_new_item'          => __( 'Add New Item', 'sjoerd' ),
			'add_new'               => __( 'Add New', 'sjoerd' ),
			'new_item'              => __( 'New Item', 'sjoerd' ),
			'edit_item'             => __( 'Edit Item', 'sjoerd' ),
			'update_item'           => __( 'Update Item', 'sjoerd' ),
			'view_item'             => __( 'View Item', 'sjoerd' ),
			'view_items'            => __( 'View Items', 'sjoerd' ),
			'search_items'          => __( 'Search Item', 'sjoerd' ),
			'not_found'             => __( 'Not found', 'sjoerd' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'sjoerd' ),
			'featured_image'        => __( 'Featured Image', 'sjoerd' ),
			'set_featured_image'    => __( 'Set featured image', 'sjoerd' ),
			'remove_featured_image' => __( 'Remove featured image', 'sjoerd' ),
			'use_featured_image'    => __( 'Use as featured image', 'sjoerd' ),
			'insert_into_item'      => __( 'Insert into item', 'sjoerd' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'sjoerd' ),
			'items_list'            => __( 'Items list', 'sjoerd' ),
			'items_list_navigation' => __( 'Items list navigation', 'sjoerd' ),
			'filter_items_list'     => __( 'Filter items list', 'sjoerd' ),
	);
	$rewrite = array(
			'slug'                  => 'work',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
	);
	$args = array(
			'label'                 => __( 'Work', 'sjoerd' ),
			'description'           => __( 'Work Portfolio', 'sjoerd' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', ),
			'taxonomies'            => array( 'work_taxonomy' ),
			'show_in_graphql' 		=> true,
			'hierarchical'          => false,
			'graphql_single_name' => 'work',
      		'graphql_plural_name' => 'works',
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-portfolio',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'work',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
	);
	register_post_type( 'work', $args );

}
add_action( 'init', 'custom_webportfolio', 0 );



// Register Custom Taxonomy
function custom_taxonomy_work() {

	$labels = array(
		'name'                       => _x( 'Work Categories', 'Taxonomy General Name', 'sjoerd' ),
		'singular_name'              => _x( 'Work Category', 'Taxonomy Singular Name', 'sjoerd' ),
		'menu_name'                  => __( 'Category', 'sjoerd' ),
		'all_items'                  => __( 'All Items', 'sjoerd' ),
		'parent_item'                => __( 'Parent Item', 'sjoerd' ),
		'parent_item_colon'          => __( 'Parent Item:', 'sjoerd' ),
		'new_item_name'              => __( 'New Item Name', 'sjoerd' ),
		'add_new_item'               => __( 'Add New Item', 'sjoerd' ),
		'edit_item'                  => __( 'Edit Item', 'sjoerd' ),
		'update_item'                => __( 'Update Item', 'sjoerd' ),
		'view_item'                  => __( 'View Item', 'sjoerd' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'sjoerd' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'sjoerd' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sjoerd' ),
		'popular_items'              => __( 'Popular Items', 'sjoerd' ),
		'search_items'               => __( 'Search Items', 'sjoerd' ),
		'not_found'                  => __( 'Not Found', 'sjoerd' ),
		'no_terms'                   => __( 'No items', 'sjoerd' ),
		'items_list'                 => __( 'Items list', 'sjoerd' ),
		'items_list_navigation'      => __( 'Items list navigation', 'sjoerd' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'work_taxonomy', array( 'work' ), $args );

}
add_action( 'init', 'custom_taxonomy_work', 0 );



// Register Custom posttype
function custom_services() {

	$labels = array(
			'name'                  => _x( 'Services', 'Post Type General Name', 'sjoerd' ),
			'singular_name'         => _x( 'Service', 'Post Type Singular Name', 'sjoerd' ),
			'menu_name'             => __( 'Services', 'sjoerd' ),
			'name_admin_bar'        => __( 'Services', 'sjoerd' ),
			'archives'              => __( 'Item Archives', 'sjoerd' ),
			'attributes'            => __( 'Item Attributes', 'sjoerd' ),
			'parent_item_colon'     => __( 'Parent Item:', 'sjoerd' ),
			'all_items'             => __( 'All Items', 'sjoerd' ),
			'add_new_item'          => __( 'Add New Item', 'sjoerd' ),
			'add_new'               => __( 'Add New', 'sjoerd' ),
			'new_item'              => __( 'New Item', 'sjoerd' ),
			'edit_item'             => __( 'Edit Item', 'sjoerd' ),
			'update_item'           => __( 'Update Item', 'sjoerd' ),
			'view_item'             => __( 'View Item', 'sjoerd' ),
			'view_items'            => __( 'View Items', 'sjoerd' ),
			'search_items'          => __( 'Search Item', 'sjoerd' ),
			'not_found'             => __( 'Not found', 'sjoerd' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'sjoerd' ),
			'featured_image'        => __( 'Featured Image', 'sjoerd' ),
			'set_featured_image'    => __( 'Set featured image', 'sjoerd' ),
			'remove_featured_image' => __( 'Remove featured image', 'sjoerd' ),
			'use_featured_image'    => __( 'Use as featured image', 'sjoerd' ),
			'insert_into_item'      => __( 'Insert into item', 'sjoerd' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'sjoerd' ),
			'items_list'            => __( 'Items list', 'sjoerd' ),
			'items_list_navigation' => __( 'Items list navigation', 'sjoerd' ),
			'filter_items_list'     => __( 'Filter items list', 'sjoerd' ),
	);
	$rewrite = array(
			'slug'                  => 'services',
			'with_front'            => true,
			'pages'                 => true,
			'feeds'                 => true,
	);
	$args = array(
			'label'                 => __( 'Services', 'sjoerd' ),
			'description'           => __( 'Mogelijke Services', 'sjoerd' ),
			'labels'                => $labels,
			'supports'              => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'custom-fields', ),
			'taxonomies'            => array( 'services_taxonomy' ),
			'show_in_graphql' 		=> true,
			'hierarchical'          => false,
			'graphql_single_name' => 'service',
      		'graphql_plural_name' => 'services',
			'public'                => true,
			'show_ui'               => true,
			'show_in_menu'          => true,
			'menu_position'         => 5,
			'menu_icon'             => 'dashicons-star-filled',
			'show_in_admin_bar'     => true,
			'show_in_nav_menus'     => true,
			'can_export'            => true,
			'has_archive'           => 'services',
			'exclude_from_search'   => false,
			'publicly_queryable'    => true,
			'rewrite'               => $rewrite,
			'capability_type'       => 'post',
			'show_in_rest'          => true,
	);
	register_post_type( 'services', $args );

}
add_action( 'init', 'custom_services', 0 );

// Register Custom Taxonomy
function custom_taxonomy_services() {

	$labels = array(
		'name'                       => _x( 'Services Categories', 'Taxonomy General Name', 'sjoerd' ),
		'singular_name'              => _x( 'Services Category', 'Taxonomy Singular Name', 'sjoerd' ),
		'menu_name'                  => __( 'Category', 'sjoerd' ),
		'all_items'                  => __( 'All Items', 'sjoerd' ),
		'parent_item'                => __( 'Parent Item', 'sjoerd' ),
		'parent_item_colon'          => __( 'Parent Item:', 'sjoerd' ),
		'new_item_name'              => __( 'New Item Name', 'sjoerd' ),
		'add_new_item'               => __( 'Add New Item', 'sjoerd' ),
		'edit_item'                  => __( 'Edit Item', 'sjoerd' ),
		'update_item'                => __( 'Update Item', 'sjoerd' ),
		'view_item'                  => __( 'View Item', 'sjoerd' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'sjoerd' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'sjoerd' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'sjoerd' ),
		'popular_items'              => __( 'Popular Items', 'sjoerd' ),
		'search_items'               => __( 'Search Items', 'sjoerd' ),
		'not_found'                  => __( 'Not Found', 'sjoerd' ),
		'no_terms'                   => __( 'No items', 'sjoerd' ),
		'items_list'                 => __( 'Items list', 'sjoerd' ),
		'items_list_navigation'      => __( 'Items list navigation', 'sjoerd' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'services_taxonomy', array( 'services' ), $args );

}
add_action( 'init', 'custom_taxonomy_services', 0 );


/*************************** Add admin option page **********************************/
// Add options page and menu item
function add_theme_menu_item()
{
    add_menu_page(
		"Microcopy", // This is the menu title
		"Microcopy", // Menu text
		"manage_options", // Level of rights that user need to have to see this page.
		"microcopy-page", // This is the slug
		"microcopy_api_page", // Function called to add content to this page 
		"dashicons-edit", // This is the menu icon
		3
	);
}

// Add content to the options page
function microcopy_api_page() 
{
    ?>
	    <div class="wrap">
	        <h1>Microcopy Overview</h1>
			<form method="post" action="options.php">
				<?php
					settings_fields("microcopy_options");
					do_settings_sections("plugin");      
					submit_button(); 
				?> 
	    	</form>
		</div>
	<?php
}

add_action("admin_menu", "add_theme_menu_item");

function register_settings() 
{
    $args = array(
        'type' => 'string',
        'sanitize_callback' => NULL,
        // 'sanitize_callback' => 'sanitize_text_field',
        'default' => NULL,
        'show_in_graphql' => true,
    );
	
	register_setting(
		"microcopy_options", 
		"menutext", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"heroheader", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"worktitle", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"worktitle", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"worksubtitle", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"worktext", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"servicetitle", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"servicesubtitle", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"servicetext", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"quoteone", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"quotetwo", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"quotesubtitle", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"ctagetintouch", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"ctaletstalk", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"ctaseecase", 
		$args	
	);

	register_setting(
		"microcopy_options", 
		"footertext", 
		$args	
	);
}

function plugin_admin_init(){

	add_settings_section('plugin_main', 'Main Settings', 'plugin_section_text', 'plugin');
	
	add_settings_field(
		'mc_menu_text', 
		'Menu Text', 
		'McMenuText', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_hero_text', 
		'Index Hero Text', 
		'McHeroText', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_work_title', 
		'Work Title', 
		'McWorkTitle', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_work_sub_title', 
		'Work Subtitle', 
		'McWorkSubTitle', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_work_text', 
		'Work Text', 
		'McWorkText', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_service_title', 
		'Service Title', 
		'McServiceTitle', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_service_sub_title', 
		'Service Subtitle', 
		'McServiceSubTitle', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_service_text', 
		'Service Text', 
		'McServiceText', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_quote_one', 
		'First Quote', 
		'McQuoteOne', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_quote_two', 
		'Second Quote', 
		'McQuoteTwo', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_quote_subtitle', 
		'Quote Subtitle', 
		'McQuoteSubtitle', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_cta_getintouch', 
		'Get in touch CTA', 
		'McCTAgetintouch', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_cta_letstalk', 
		'Lets Talk CTA', 
		'McCTAletstalk', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_cta_seecase', 
		'See Case CTA', 
		'McCTAseecase', 
		'plugin', 
		'plugin_main', 
		$args
	);

	add_settings_field(
		'mc_footer_text', 
		'Footer Text', 
		'McFooterText', 
		'plugin', 
		'plugin_main', 
		$args
	);

	$args = array(
        'type' => 'string',
        'sanitize_callback' => NULL,
        // 'sanitize_callback' => 'sanitize_text_field',
        'default' => NULL,
		'show_in_graphql' => true,
		
	);
	
}

function plugin_section_text() {
	echo '<p>This is an overview of all the microcopy used</p>';
} 

function McMenuText() {
	?>
   		<textarea id="mc_menu_text" style="width:30vw;height:250px;" type="text" name="menutext"><?php echo get_option('menutext'); ?></textarea>
	<?php
}

function McHeroText() {
	?>
   		<textarea id="mc_hero_text" style="width:30vw;height:250px;" type="text" name="heroheader"><?php echo get_option('heroheader'); ?></textarea>
	<?php
}

function McWorkTitle() {
	?>
		<input id="mc_work_title" class="regular-text" type="text" style="width:30vw;" name="worktitle" value="<?php echo get_option('worktitle'); ?>"/>
	<?php
}

function McWorkSubTitle() {
	?>
		<input id="mc_work_sub_title" class="regular-text" type="text" style="width:30vw;" name="worksubtitle" value="<?php echo get_option('worksubtitle'); ?>"/>
	<?php
}

function McWorkText() {
	?>
   		<textarea id="mc_work_text" style="width:30vw;height:250px;" type="text" name="worktext"><?php echo get_option('worktext'); ?></textarea>
	<?php
}

function McServiceTitle() {
	?>
		<input id="mc_service_title" class="regular-text" type="text" style="width:30vw;" name="servicetitle" value="<?php echo get_option('servicetitle'); ?>"/>
	<?php
}

function McServiceSubTitle() {
	?>
		<input id="mc_service_sub_title" class="regular-text" type="text" style="width:30vw;" name="servicesubtitle" value="<?php echo get_option('servicesubtitle'); ?>"/>
	<?php
}

function McServiceText() {
	?>
   		<textarea id="mc_service_text" style="width:30vw;height:250px;" type="text" name="servicetext"><?php echo get_option('servicetext'); ?></textarea>
	<?php
}

function McQuoteOne() {
	?>
		<input id="mc_quote_one" class="regular-text" type="text" style="width:30vw;" name="quoteone" value="<?php echo get_option('quoteone'); ?>"/>
	<?php
}


function McQuoteTwo() {
	?>
		<input id="mc_quote_two" class="regular-text" type="text" style="width:30vw;" name="quotetwo" value="<?php echo get_option('quotetwo'); ?>"/>
	<?php
}

function McQuoteSubtitle() {
	?>
		<input id="mc_quote_subtitle" class="regular-text" type="text" style="width:30vw;" name="quotesubtitle" value="<?php echo get_option('quotesubtitle'); ?>"/>
	<?php
}

function McCTAgetintouch() {
	?>
		<input id="mc_cta_getintouch" class="regular-text" type="text" style="width:30vw;" name="ctagetintouch" value="<?php echo get_option('ctagetintouch'); ?>"/>
	<?php
}

function McCTAletstalk() {
	?>
		<input id="mc_cta_letstalk" class="regular-text" type="text" style="width:30vw;" name="ctaletstalk" value="<?php echo get_option('ctaletstalk'); ?>"/>
	<?php
}

function McCTAseecase() {
	?>
		<input id="mc_cta_seecase" class="regular-text" type="text" style="width:30vw;" name="ctaseecase" value="<?php echo get_option('ctaseecase'); ?>"/>
	<?php
}

function McFooterText() {
	?>
   		<textarea id="mc_footer_text" style="width:30vw;height:250px;" type="text" name="footertext"><?php echo get_option('footertext'); ?></textarea>
	<?php
}







// add the admin settings and such
add_action('admin_init', 'plugin_admin_init');
add_action('init', 'register_settings');