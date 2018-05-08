<?php

add_action( 'wp_enqueue_scripts', 'crypterio_child_enqueue_parent_styles');

function crypterio_child_enqueue_parent_styles() {

	wp_enqueue_style( 'crypterio-style', get_template_directory_uri() . '/style.css', array( 'bootstrap' ), CRYPTERIO_THEME_VERSION, 'all' );
	wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'crypterio-layout' ), CRYPTERIO_THEME_VERSION, 'all' );
}

// Include customization files.
function custom_scripts(){

	// Enqueue the style file.
	wp_register_script('app', get_stylesheet_directory_uri() . '/includes/js/app.js', array('jquery'), '1.0.0', true);   

	// Enqueue the script.
	wp_enqueue_script('app');
}

// Hook it into the Wordpress install.
add_action( 'wp_enqueue_scripts', 'custom_scripts' );

// Add custom team shortcode.
add_shortcode( 'team_list', 'output_team_list' );

function output_team_list( $atts ) {

	return retreiveTeamList();
}

function retreiveTeamList(){

	ob_start();

	$args = array('orderby' => 'date', 'order' => 'ASC', 'post_type' => 'stm_staff', 'posts_per_page' => -1, 'post_status' => 'publish');

	// The Query
	$the_query = new WP_Query($args);

	// The Loop
	if ( $the_query->have_posts() ) {
		
		while ( $the_query->have_posts() ) {

			$the_query->the_post();

			get_template_part( 'templates/content', 'team' );
		}
	}

	wp_reset_postdata();

	return ob_get_clean();
}