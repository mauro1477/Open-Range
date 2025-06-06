<?php

use Timber\Site;

/**
 * Class StarterSite
 */
class StarterSite extends Site {
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'init', array( $this, 'register_post_types' ) ,1);
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber/twig/environment/options', [ $this, 'update_twig_environment_options' ] );
		add_filter('post_type_link', [$this , 'filter_post_type_guide_link'], 10, 2);
		add_action( 'save_post', [$this, 'default_taxonomy_term'], 100, 2 );
		add_action('after_setup_theme', [$this, 'register_menu']);
		add_filter('acf/fields/google_map/api', array($this, 'open_range_map_key'));
		add_filter( 'algolia_post_shared_attributes',array($this, 'my_post_attributes'), 10, 2 );
		add_action( 'wp_insert_post_data', array($this, 'clean_post_title') );

		parent::__construct();
	}

	function clean_post_title($post){
		$post['post_title'] =  str_replace("&amp;","&",$post['post_title']); //Updates the post title to your new title.

		return $post;
	}

	function my_post_attributes( array $attributes, WP_Post $post ) {

		if ( 'guides' !== $post->post_type ) {
			// We only want to add an attribute for the 'guides' post type.
			// Here the post isn't a 'guides', so we return the attributes unaltered.
			return $attributes;
		}
	
		// Get the field value with the 'get_field' method and assign it to the attributes array.
		// @see https://www.advancedcustomfields.com/resources/get_field/
		$attributes['_geoloc']['lat'] = (float) get_post_meta( $post->ID, 'guides_location', true )['lat'];
		$attributes['_geoloc']['lng'] = (float) get_post_meta( $post->ID, 'guides_location', true )['lng'];	
		$attributes['address'] = get_post_meta( $post->ID, 'guides_location', true )['address'];	
		$attributes['state'] = get_post_meta( $post->ID, 'guides_location', true )['state'];	
		$attributes['country'] = get_post_meta( $post->ID, 'guides_location', true )['country'];	
		// Always return the value we are filtering.
		return $attributes;
	}

	public function open_range_map_key($api){
		$api['key'] = Google_api_key;
		return $api;
	}

	/**
	 * Add REST API support to an already registered post type.
	 */
	
	function my_post_type_args_guides( $args, $post_type ) {
	
		if ( 'guides' === $post_type ) {
			$args['show_in_rest'] = true;
	
			// Optionally customize the rest_base or rest_controller_class
			$args['rest_base']             = 'guides';
			$args['rest_controller_class'] = 'WP_REST_Posts_Controller';
		}
	
		return $args;
	}
	
	/**
	 * This is where you can register custom post types.
	 */
	public function register_post_types() {
		$labels = array(
			'name' => _x( 'guides', 'my_custom_post','custom' ),
			'singular_name' => _x( 'Guide', 'my_custom_post', 'custom' ),
			'add_new' => _x( 'Add New', 'my_custom_post', 'custom' ),
			'add_new_item' => _x( 'Add New GuidePost', 'my_custom_post', 'custom' ),
			'edit_item' => _x( 'Edit GuidePost', 'my_custom_post', 'custom' ),
			'new_item' => _x( 'New Guide Post', 'my_custom_post', 'custom' ),
			'view_item' => _x( 'View Guide Post', 'my_custom_post', 'custom' ),
			'search_items' => _x( 'Search Guide Posts', 'my_custom_post', 'custom' ),
			'not_found' => _x( 'No Guide Posts found', 'my_custom_post', 'custom' ),
			'not_found_in_trash' => _x( 'No Guide Posts found in Trash', 'my_custom_post', 'custom' ),
			'parent_item_colon' => _x( 'Parent Guide Post:', 'my_custom_post', 'custom' ),
			'menu_name' => _x( 'Guides Posts', 'my_custom_post', 'custom' ),
		);
	
		$args = array(
			'labels' => $labels,
			'show_in_rest' => true,
			'hierarchical' => true,
			'description' => 'Custom Guide Posts',
			'supports' => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'post-formats', 'custom-fields' ),
			'taxonomies' => array( 'post_tag','guides_categories'),
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 5,
			// 'menu_icon' => get_stylesheet_directory_uri() . '/functions/panel/images/catchinternet-small.png',
			'show_in_nav_menus' => true,
			'publicly_queryable' => true,
			'exclude_from_search' => false,
			'query_var' => true,
			'can_export' => true,
			'rewrite' => array( 'slug' => 'guides/%guides_categories%', 'with_front' => FALSE ),
			'public' => true,
			'has_archive' => 'guides',
			'capability_type' => 'post'
		);
		register_post_type( 'guides', $args ); // max 20 character cannot contain capital letters and spaces
	}

	/**
	 * This is where you can register custom taxonomies.
	 */
	public function register_taxonomies() {
		register_taxonomy(
			'guides_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
			'guides',             // post type name
			array(
				'show_in_rest'      => true,
				'hierarchical' => true,
				'label' => 'Guide Categories', // display name
				'query_var' => true,
				'rewrite' => array(
					'slug' => 'guides',    // This controls the base slug that will display before each term
					'with_front' => false  // Don't display the category base before
				)
			)
		);
	}

	/**
	 * This is where you add some context
	 *
	 * @param string $context context[$post_id, $post 'this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		// Localize the script with new data
		// Main Menu
		$array_menu = wp_get_nav_menu_items('primary-menu');
		$menu = array();
		foreach ($array_menu as $m) {
			if (empty($m->menu_item_parent)) {
				$menu[$m->ID]['ID'] 		= 	$m->ID;
				$menu[$m->ID]['title'] 		= 	$m->title;
				$menu[$m->ID]['url'] 		= 	$m->url;
				$menu[$m->ID]['children']	= 	array();
			}
		}
		$submenu = array();
		foreach ($array_menu as $m) {
			if ($m->menu_item_parent) {
				$submenu = array();
				$submenu[$m->ID]['ID'] 		= 	$m->ID;
				$submenu[$m->ID]['title']	= 	$m->title;
				$submenu[$m->ID]['url'] 	= 	$m->url;
				$menu[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
			}
		} 
		// Footer Menu
		$array_menu_footer = wp_get_nav_menu_items('footer-menu');
		$menuFooter = array();
		foreach ($array_menu_footer as $m) {
			if (empty($m->menu_item_parent)) {
				$menuFooter[$m->ID]['ID'] 		= 	$m->ID;
				$menuFooter[$m->ID]['title'] 		= 	$m->title;
				$menuFooter[$m->ID]['url'] 		= 	$m->url;
				$menuFooter[$m->ID]['children']	= 	array();
			}
		}
		$submenuFooter = array();
		foreach ($array_menu_footer as $m) {
			if ($m->menu_item_parent) {
				$submenu = array();
				$submenuFooter[$m->ID]['ID'] 		= 	$m->ID;
				$submenuFooter[$m->ID]['title']	= 	$m->title;
				$submenuFooter[$m->ID]['url'] 	= 	$m->url;
				$menuFooter[$m->menu_item_parent]['children'][$m->ID] = $submenu[$m->ID];
			}
		} 

		$host_name =  $_SERVER["HTTP_X_FORWARDED_PROTO"] ."://" .$_SERVER["HTTP_HOST"];

		$theme_vars = array(
			'menu' => $menu,
			'menu_footer' => $menuFooter,
			'host_name' => $host_name,
			'current_post_id' => get_the_ID()
		);

		$context['theme_vars'] = $theme_vars;

		$context['site']  = $this;

		return $context;
	}

	public function theme_supports() {
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
		 * @link https://developer.wordpress.org/guides/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
			)
		);

		/*
		 * Enable support for Post Formats.
		 *
		 * See: https://codex.wordpress.org/Post_Formats
		 */
		add_theme_support(
			'post-formats',
			array(
				'aside',
				'image',
				'video',
				'quote',
				'link',
				'gallery',
				'audio',
			)
		);

		add_theme_support( 'menus' );
	}

	/**
	 * his would return 'foo bar!'.
	 *
	 * @param string $text being 'foo', then returned 'foo bar!'.
	 */
	public function myfoo( $text ) {
		$text .= ' bar!';
		return $text;
	}

	/**
	 * This is where you can add your own functions to twig.
	 *
	 * @param Twig\Environment $twig get extension.
	 */
	public function add_to_twig( $twig ) {
		/**
		 * Required when you want to use Twig’s template_from_string.
		 * @link https://twig.symfony.com/doc/3.x/functions/template_from_string.html
		 */
		// $twig->addExtension( new Twig\Extension\StringLoaderExtension() );

		$twig->addFilter( new Twig\TwigFilter( 'myfoo', [ $this, 'myfoo' ] ) );

		return $twig;
	}

	/**
	 * Updates Twig environment options.
	 *
	 * @link https://twig.symfony.com/doc/2.x/api.html#environment-options
	 *
	 * \@param array $options An array of environment options.
	 *
	 * @return array
	 */
	function update_twig_environment_options( $options ) {
	    // $options['autoescape'] = true;

	    return $options;
	}

	function filter_post_type_guide_link($link, $post ){

		if ( $post->post_type !== 'guides' )
		return $link;
	
		if ( $cats = get_the_terms($post->ID, 'guides_categories') )
			$link = str_replace('%guides_categories%', array_pop($cats)->slug, $link);
		return $link;
	}
	
	
	function default_taxonomy_term( $post_id, $post ) {
		if ( 'publish' === $post->post_status ) {
			$defaults = array(
				'guides_categories' => array('other'),
			);
			$taxonomies = get_object_taxonomies( $post->post_type );
			foreach ( (array) $taxonomies as $taxonomy ) {
				$terms = wp_get_post_terms( $post_id, $taxonomy );
				if ( empty($terms) && array_key_exists( $taxonomy, $defaults ) ) {
					wp_set_object_terms( $post_id, $defaults[$taxonomy], $taxonomy );
				}
			}
		}
	}

	public function register_menu(){
		register_nav_menus([
			'primary' => 'Primary Menu',
			'secondary' => 'Secondary Menu',
			'footer' => 'Footer Menu',
		]);
	}



	

}
