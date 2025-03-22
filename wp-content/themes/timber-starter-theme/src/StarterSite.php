<?php

use Timber\Site;

/**
 * Class StarterSite
 */
class StarterSite extends Site {
	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'theme_supports' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_filter( 'timber/context', array( $this, 'add_to_context' ) );
		add_filter( 'timber/twig', array( $this, 'add_to_twig' ) );
		add_filter( 'timber/twig/environment/options', [ $this, 'update_twig_environment_options' ] );
		add_filter('post_type_link', [$this , 'filter_post_type_guide_link'], 10, 2);
		add_action( 'save_post', [$this, 'default_taxonomy_term'], 100, 2 );
		add_action('after_setup_theme', [$this, 'register_menu']);
		add_action( 'after_setup_theme', array( $this, 'enqueue_styles_and_scripts' ) );

		parent::__construct();
	}

	function enqueue_styles_and_scripts(){
		$theme_root = get_theme_root_uri();
		wp_enqueue_script( 'base-scripts', $theme_root .'/timber-starter-theme/dist/bundle.js', array('jquery','wp-api'),'', true );
		wp_enqueue_style( 'base-styles', $theme_root .'/timber-starter-theme/dist/main.css');
 	}


	/**
	 * This is where you can register custom post types.
	 */
	public function register_post_types() {
		$labels = array(
			'name' => _x( 'guides', 'my_custom_post','custom' ),
			'singular_name' => _x( 'Theme', 'my_custom_post', 'custom' ),
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
			'hierarchical' => false,
			'description' => 'Custom Theme Posts',
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
	 * @param string $context context['this'] Being the Twig's {{ this }}.
	 */
	public function add_to_context( $context ) {
		$context['foo']   = 'bar';
		$context['stuff'] = 'I am a value set in your functions.php file';
		$context['notes'] = 'These values are available everytime you call Timber::context();';
		$context['menu'] = Timber::get_menu('primary');
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
