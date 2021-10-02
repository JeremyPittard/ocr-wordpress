<?php
/**
 * ocr-projects functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package ocr-projects
 */

if ( ! defined( '_S_VERSION' ) ) {
	// Replace the version number of the theme on each release.
	define( '_S_VERSION', '1.0.0' );
}

if ( ! function_exists( 'ocr_projects_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function ocr_projects_setup() {
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on ocr-projects, use a find and replace
		 * to change 'ocr-projects' to the name of your theme in all the template files.
		 */
		load_theme_textdomain( 'ocr-projects', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

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

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus(
			array(
				'menu-1' => esc_html__( 'Primary', 'ocr-projects' ),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Set up the WordPress core custom background feature.
		add_theme_support(
			'custom-background',
			apply_filters(
				'ocr_projects_custom_background_args',
				array(
					'default-color' => 'ffffff',
					'default-image' => '',
				)
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			array(
				'height'      => 250,
				'width'       => 250,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);
	}
endif;
add_action( 'after_setup_theme', 'ocr_projects_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function ocr_projects_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'ocr_projects_content_width', 640 );
}
add_action( 'after_setup_theme', 'ocr_projects_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function ocr_projects_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'ocr-projects' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'ocr-projects' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'ocr_projects_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function ocr_projects_scripts() {
	wp_enqueue_style( 'ocr-projects-style', get_stylesheet_uri(), array(), _S_VERSION );
	wp_style_add_data( 'ocr-projects-style', 'rtl', 'replace' );

	wp_enqueue_script( 'ocr-projects-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ocr_projects_scripts' );

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if ( defined( 'JETPACK__VERSION' ) ) {
	require get_template_directory() . '/inc/jetpack.php';
}

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title' 	=> 'Theme General Settings',
		'menu_title'	=> 'OCR Projects Settings',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts',
		'redirect'		=> false
	));	

	acf_add_options_sub_page(array(
		'page_title' 	=> 'Seo Settings',
		'menu_title'	=> 'Seo Settings',
		'parent_slug'	=> 'theme-general-settings',
	));
}
function add_banner_ocr() {
 
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Banner', 'Post Type General Name', 'ocr' ),
			'singular_name'       => _x( 'Banner', 'Post Type Singular Name', 'ocr' ),
			'menu_name'           => __( 'Banner', 'ocr' ),
			'parent_item_colon'   => __( 'Parent Banner', 'ocr' ),
			'all_items'           => __( 'All', 'ocr' ),
			'view_item'           => __( 'View Banner', 'ocr' ),
			'add_new_item'        => __( 'Add New Banner', 'ocr' ),
			'add_new'             => __( 'Add Banner', 'ocr' ),
			'edit_item'           => __( 'Edit Banner', 'ocr' ),
			'update_item'         => __( 'Update Banner', 'ocr' ),
			'search_items'        => __( 'Search Banner', 'ocr' ),
			'not_found'           => __( 'Not Found', 'ocr' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'ocr' ),
		);
		 
	// Set other options for Custom Post Type
		 
		$args = array(
			'label'               => __( 'Banner', 'ocr' ),
			'description'         => __( 'Banner', 'ocr' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			// You can associate this CPT with a taxonomy or custom taxonomy. 
			'taxonomies'          => array( 'genres' ),
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-cover-image',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
			'show_in_graphql' => true,
			'graphql_single_name' => 'banner_post',
			'graphql_plural_name' => 'banner'
	 
		);
		 
		// Registering your Custom Post Type
		register_post_type( 'banner', $args );
	 
	}
	 
	/* Hook into the 'init' action so that the function
	* Containing our post type registration is not 
	* unnecessarily executed. 
	*/
	 
	add_action( 'init', 'add_banner_ocr', 0 );

function add_about_ocr() {
 
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'About', 'Post Type General Name', 'ocr' ),
			'singular_name'       => _x( 'About', 'Post Type Singular Name', 'ocr' ),
			'menu_name'           => __( 'About', 'ocr' ),
			'parent_item_colon'   => __( 'Parent About', 'ocr' ),
			'all_items'           => __( 'All', 'ocr' ),
			'view_item'           => __( 'View About', 'ocr' ),
			'add_new_item'        => __( 'Add New About', 'ocr' ),
			'add_new'             => __( 'Add About', 'ocr' ),
			'edit_item'           => __( 'Edit About', 'ocr' ),
			'update_item'         => __( 'Update About', 'ocr' ),
			'search_items'        => __( 'Search About', 'ocr' ),
			'not_found'           => __( 'Not Found', 'ocr' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'ocr' ),
		);
		 
	// Set other options for Custom Post Type
		 
		$args = array(
			'label'               => __( 'About', 'ocr' ),
			'description'         => __( 'About', 'ocr' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			// You can associate this CPT with a taxonomy or custom taxonomy. 
			'taxonomies'          => array( 'genres' ),
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/ 
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'menu_icon'           => 'dashicons-admin-users',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
			'show_in_graphql' => true,
			'graphql_single_name' => 'about_post',
			'graphql_plural_name' => 'about'
	 
		);
		 
		// Registering your Custom Post Type
		register_post_type( 'about', $args );
	 
	}
	 
	/* Hook into the 'init' action so that the function
	* Containing our post type registration is not 
	* unnecessarily executed. 
	*/
	 
	add_action( 'init', 'add_about_ocr', 0 );

	function add_services_ocr() {
 
		// Set UI labels for Custom Post Type
			$labels = array(
				'name'                => _x( 'Services', 'Post Type General Name', 'ocr' ),
				'singular_name'       => _x( 'Service', 'Post Type Singular Name', 'ocr' ),
				'menu_name'           => __( 'Services', 'ocr' ),
				'parent_item_colon'   => __( 'Parent Service', 'ocr' ),
				'all_items'           => __( 'All', 'ocr' ),
				'view_item'           => __( 'View Service', 'ocr' ),
				'add_new_item'        => __( 'Add New Service', 'ocr' ),
				'add_new'             => __( 'Add Service', 'ocr' ),
				'edit_item'           => __( 'Edit Service', 'ocr' ),
				'update_item'         => __( 'Update Service', 'ocr' ),
				'search_items'        => __( 'Search Service', 'ocr' ),
				'not_found'           => __( 'Not Found', 'ocr' ),
				'not_found_in_trash'  => __( 'Not found in Trash', 'ocr' ),
			);
			 
		// Set other options for Custom Post Type
			 
			$args = array(
				'label'               => __( 'Service', 'ocr' ),
				'description'         => __( 'Service', 'ocr' ),
				'labels'              => $labels,
				// Features this CPT supports in Post Editor
				'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
				// You can associate this CPT with a taxonomy or custom taxonomy. 
				'taxonomies'          => array( 'genres' ),
				/* A hierarchical CPT is like Pages and can have
				* Parent and child items. A non-hierarchical CPT
				* is like Posts.
				*/ 
				'hierarchical'        => false,
				'public'              => true,
				'show_ui'             => true,
				'show_in_menu'        => true,
				'show_in_nav_menus'   => true,
				'show_in_admin_bar'   => true,
				'menu_position'       => 5,
				'menu_icon'           => 'dashicons-admin-tools',
				'can_export'          => true,
				'has_archive'         => true,
				'exclude_from_search' => false,
				'publicly_queryable'  => true,
				'capability_type'     => 'post',
				'show_in_rest' => true,
				'show_in_graphql' => true,
				'graphql_single_name' => 'service',
				'graphql_plural_name' => 'services'
		 
			);
			 
			// Registering your Custom Post Type
			register_post_type( 'service', $args );
		 
		}
		 
		/* Hook into the 'init' action so that the function
		* Containing our post type registration is not 
		* unnecessarily executed. 
		*/
		 
		add_action( 'init', 'add_services_ocr', 0 );


		function add_portfolio_ocr() {
 
			// Set UI labels for Custom Post Type
				$labels = array(
					'name'                => _x( 'Portfolio', 'Post Type General Name', 'ocr' ),
					'singular_name'       => _x( 'Portfolio Item', 'Post Type Singular Name', 'ocr' ),
					'menu_name'           => __( 'Portfolio', 'ocr' ),
					'parent_item_colon'   => __( 'Parent Portfolio', 'ocr' ),
					'all_items'           => __( 'All', 'ocr' ),
					'view_item'           => __( 'View Portfolio Item', 'ocr' ),
					'add_new_item'        => __( 'Add New Portfolio Item', 'ocr' ),
					'add_new'             => __( 'Add Portfolio Item', 'ocr' ),
					'edit_item'           => __( 'Edit Portfolio Item', 'ocr' ),
					'update_item'         => __( 'Update Portfolio Item', 'ocr' ),
					'search_items'        => __( 'Search Portfolio', 'ocr' ),
					'not_found'           => __( 'Not Found', 'ocr' ),
					'not_found_in_trash'  => __( 'Not found in Trash', 'ocr' ),
				);
				 
			// Set other options for Custom Post Type
				 
				$args = array(
					'label'               => __( 'Portfolio', 'ocr' ),
					'description'         => __( 'Portfolio', 'ocr' ),
					'labels'              => $labels,
					// Features this CPT supports in Post Editor
					'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
					// You can associate this CPT with a taxonomy or custom taxonomy. 
					'taxonomies'          => array( 'genres' ),
					/* A hierarchical CPT is like Pages and can have
					* Parent and child items. A non-hierarchical CPT
					* is like Posts.
					*/ 
					'hierarchical'        => false,
					'public'              => true,
					'show_ui'             => true,
					'show_in_menu'        => true,
					'show_in_nav_menus'   => true,
					'show_in_admin_bar'   => true,
					'menu_position'       => 5,
					'menu_icon'           => 'dashicons-admin-home',
					'can_export'          => true,
					'has_archive'         => true,
					'exclude_from_search' => false,
					'publicly_queryable'  => true,
					'capability_type'     => 'post',
					'show_in_rest' => true,
					'show_in_graphql' => true,
					'graphql_single_name' => 'portfolio_item',
					'graphql_plural_name' => 'portfolio'
			 
				);
				 
				// Registering your Custom Post Type
				register_post_type( 'portfolio', $args );
			 
			}
			 
			/* Hook into the 'init' action so that the function
			* Containing our post type registration is not 
			* unnecessarily executed. 
			*/
			 
			add_action( 'init', 'add_portfolio_ocr', 0 );
	

			function add_review_ocr() {
 
				// Set UI labels for Custom Post Type
					$labels = array(
						'name'                => _x( 'Review', 'Post Type General Name', 'ocr' ),
						'singular_name'       => _x( 'Review', 'Post Type Singular Name', 'ocr' ),
						'menu_name'           => __( 'Reviews', 'ocr' ),
						'parent_item_colon'   => __( 'Parent Review', 'ocr' ),
						'all_items'           => __( 'All', 'ocr' ),
						'view_item'           => __( 'View Review', 'ocr' ),
						'add_new_item'        => __( 'Add New Review', 'ocr' ),
						'add_new'             => __( 'Add Review', 'ocr' ),
						'edit_item'           => __( 'Edit Review', 'ocr' ),
						'update_item'         => __( 'Update Review', 'ocr' ),
						'search_items'        => __( 'Search Reviews', 'ocr' ),
						'not_found'           => __( 'Not Found', 'ocr' ),
						'not_found_in_trash'  => __( 'Not found in Trash', 'ocr' ),
					);
					 
				// Set other options for Custom Post Type
					 
					$args = array(
						'label'               => __( 'Review', 'ocr' ),
						'description'         => __( 'Review', 'ocr' ),
						'labels'              => $labels,
						// Features this CPT supports in Post Editor
						'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
						// You can associate this CPT with a taxonomy or custom taxonomy. 
						'taxonomies'          => array( 'genres' ),
						/* A hierarchical CPT is like Pages and can have
						* Parent and child items. A non-hierarchical CPT
						* is like Posts.
						*/ 
						'hierarchical'        => false,
						'public'              => true,
						'show_ui'             => true,
						'show_in_menu'        => true,
						'show_in_nav_menus'   => true,
						'show_in_admin_bar'   => true,
						'menu_position'       => 5,
						'menu_icon'           => 'dashicons-format-quote',
						'can_export'          => true,
						'has_archive'         => true,
						'exclude_from_search' => false,
						'publicly_queryable'  => true,
						'capability_type'     => 'post',
						'show_in_rest' => true,
						'show_in_graphql' => true,
						'graphql_single_name' => 'review',
						'graphql_plural_name' => 'reviews'
				 
					);
					 
					// Registering your Custom Post Type
					register_post_type( 'review', $args );
				 
				}
				 
				/* Hook into the 'init' action so that the function
				* Containing our post type registration is not 
				* unnecessarily executed. 
				*/
				 
				add_action( 'init', 'add_review_ocr', 0 );
		