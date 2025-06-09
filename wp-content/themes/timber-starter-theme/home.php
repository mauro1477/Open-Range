<?php
/**
 * The home main template file
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since   Timber 0.1
 */

$context = Timber::context();
// Register the script
$theme_root = get_theme_root_uri();

wp_register_script( 'base-home-page-scripts', $theme_root .'/timber-starter-theme/dist/indexAppHomePage.bundle.js' );
wp_localize_script( 'base-home-page-scripts', 'theme_vars', $context['theme_vars']);

wp_enqueue_script( 'base-home-page-scripts', $theme_root .'/timber-starter-theme/dist/indexAppHomePage.bundle.js', array('jquery','wp-api'),'', true );
wp_enqueue_style( 'base-home-page-styles', $theme_root .'/timber-starter-theme/dist/indexAppHomePage.bundle.css' );
wp_enqueue_style( 'base-styles', $theme_root .'/timber-starter-theme/dist/indexAppStyles.bundle.css' );


wp_deregister_style('wp-block-library');
// You can also remove other Gutenberg-related styles if needed:
wp_deregister_style('wp-block-library-theme');
wp_deregister_style('wc-block-style'); // If using WooCommerce

$templates = array( 'base-apppage.twig' );
if ( is_home() ) {
	array_unshift( $templates, 'base-apphomepage.twig' );
}
Timber::render( $templates, $context );
