<?php

add_action( 'wp_enqueue_scripts', 'crypterio_child_enqueue_parent_styles');

function crypterio_child_enqueue_parent_styles() {

	wp_enqueue_style( 'crypterio-style', get_template_directory_uri() . '/style.css', array( 'bootstrap' ), CRYPTERIO_THEME_VERSION, 'all' );
	wp_enqueue_style( 'child-style', get_stylesheet_uri(), array( 'crypterio-layout' ), CRYPTERIO_THEME_VERSION, 'all' );
}

// add_filter('the_title', 'remove_title_on_homepage', 10, 2);

// function remove_title_on_homepage($title, $id){

// 	if(is_home()){

// 		return '';
// 	}
// }