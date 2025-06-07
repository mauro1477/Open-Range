<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context         = Timber::context();
$timber_post     = Timber::get_post();
$context['post'] = $timber_post;

$context['guides_location'] = get_field('guides_location',$context['post']->ID);
$context['guides_location']['title'] = $context['post']->title;
$context['googleDirectionLink'] = "https://www.google.com/maps/dir/?api=1&destination=" . urlencode($context['guides_location']['address']);

// Register the script
$theme_root = get_theme_root_uri();

wp_register_script( 'base-guide-scripts', $theme_root .'/timber-starter-theme/dist/indexAppSingleGuide.bundle.js' );
wp_localize_script( 'base-guide-scripts', 'theme_vars', $context['theme_vars']);

wp_enqueue_script( 'base-guide-scripts', $theme_root .'/timber-starter-theme/dist/indexAppSingleGuide.bundle.js', array('jquery','wp-api'),'', true );
wp_enqueue_style( 'base-guide-styles', $theme_root .'/timber-starter-theme/dist/indexAppSingleGuide.bundle.css' );

if ( post_password_required( $timber_post->ID ) ) {
	Timber::render( 'single-password.twig', $context );
} else {
	Timber::render( array( 'base-appsingleguide.twig' ), $context );
}

