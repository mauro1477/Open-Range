<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 * To generate specific templates for your pages you can use:
 * /mytheme/templates/page-mypage.twig
 * (which will still route through this PHP file)
 * OR
 * /mytheme/page-mypage.php
 * (in which case you'll want to duplicate this file and save to the above path)
 *
 * Methods for TimberHelper can be found in the /lib sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::context();

$timber_post     = Timber::get_post();
$context['post'] = $timber_post;
// Register the script
$theme_root = get_theme_root_uri();

wp_register_script( 'base-page-scripts', $theme_root .'/timber-starter-theme/dist/indexAppSinglePage.bundle.js' );
wp_localize_script( 'base-page-scripts', 'theme_vars', $context['theme_vars']);

wp_enqueue_script( 'base-page-scripts', $theme_root .'/timber-starter-theme/dist/indexAppSinglePage.bundle.js', array('jquery','wp-api'),'', true );
wp_enqueue_style( 'base-page-styles', $theme_root .'/timber-starter-theme/dist/indexAppSinglePage.bundle.css' );

Timber::render( array( 'base-appsinglepage.twig' ), $context );
