<?php

if ( ! function_exists( 'crypterio_print_styles' ) ) {
	function crypterio_print_styles() {
		$post_id        = get_the_ID();
		$is_shop        = false;
		$page_for_posts = get_option( 'page_for_posts' );
		if ( is_home() || is_category() || is_search() || is_tag() || is_tax() ) {
			$post_id = $page_for_posts;
		}

		if ( ( function_exists( 'is_shop' ) && is_shop() )
		     || ( function_exists( 'is_product_category' ) && is_product_category() )
		     || ( function_exists( 'is_product_tag' ) && is_product_tag() )
		) {
			$is_shop = true;
		}
		if ( $is_shop ) {
			$post_id = get_option( 'woocommerce_shop_page_id' );
		}

		$css = "";

		$title_box = array();

		$title_box['color']               = get_post_meta( $post_id, 'title_box_title_color', true );
		$title_box['background-color']    = get_post_meta( $post_id, 'title_box_title_bg_color', true );
		$title_box['background-image']    = wp_get_attachment_image_src( get_post_meta( $post_id, 'title_box_bg_image', true ), 'full' );
		$title_box['background-position'] = get_post_meta( $post_id, 'title_box_bg_position', true );
		$title_box['background-size']     = get_post_meta( $post_id, 'title_box_bg_size', true );
		$title_box['background-repeat']   = get_post_meta( $post_id, 'title_box_bg_repeat', true );

		if ( $title_box ) {
			$css .= '.page_title{ ';
			foreach ( $title_box as $key => $val ) {
				if ( $val ) {
					if ( $key != 'background-image' ) {
						$css .= $key . ': ' . esc_attr( $val ) . ' !important; ';
					} else {
						$css .= $key . ': url(' . esc_url( $val[0] ) . ') !important; ';
					}
				}
			}
			$css .= '}';
		}

		if( $title_box_title_line_color = get_post_meta( $post_id, 'title_box_title_line_color', true ) ){
			$css .= 'body .page_title h1:after{
				background: ' . $title_box_title_line_color . ';
			}';
		}

		if( get_theme_mod( 'site_boxed' ) && get_theme_mod( 'custom_bg_image' ) ){
			$css .= '
				body.boxed_layout{
					background-image: url( ' . esc_url( get_theme_mod( 'custom_bg_image' ) ) . ' ) !important;
				}
			';
		}

		$config = crypterio_config();
		$base_color = $config['base_color'];
		$secondary_color = $config['secondary_color'];
		$third_color = $config['third_color'];

		$css .= 'body.site_creative_ico .vc_custom_heading.stripe_bottom:before, body.site_creative_ico .vc_custom_heading.stripe_top:before {
			background: linear-gradient(to right, ' . $third_color . ', ' . $secondary_color . ');
		}';

		$css_styles = array(
			'color' => array(
				'base' => array(
					'.mtc',
					'.mtc_h:hover',
					'.stm_news_list__more.loading:before',
					'.site_crypto_blog ul.comment-list .comment .comment-author a',
					'.site_crypto_blog ul.comment-list .comment .comment-meta a',
				),
				'secondary' => array(
					'.stc, .stc_h:hover',
					'.stm_post_view__related .stm_news_widget .stm_news_grid__category a:hover',
					'.stm_posts_carousel_single__category:hover a',
					'.stm_single_ico__button.stm_single_ico__button_whitepaper i',
					'.font-color_secondary'
				),
				'third' => array(
					'.ttc, .ttc_h:hover'
				)
			),
			'background-color' => array(
				'base' => array(
					'.mbc',
					'.mbc_h:hover',
				),
				'secondary' => array(
					'.sbc, .sbc_h:hover',
					'.sbc_a:after',
					'.stm_news_carousel .owl-controls .owl-nav>div:hover',
					'.stm_single_ico__comments h4.comments-title:after',
				),
				'third' => array(
					'.tbc, .tbc_h:hover',
					'.tbc_a_h:hover:after',
					'.stm_single_ico__button',
					'.stm_single_ico__button.stm_single_ico__button_whitepaper:hover'
				)
			),
			'border-color' => array(
				'base' => array(
					'.mbdc',
					'.mbdc_h:hover',
				),
				'secondary' => array(
					'.sbdc, .sbdc_h:hover',
					'.stm_news_carousel .owl-controls .owl-nav>div:hover',
				),
				'third' => array(
					'.tbdc, .tbdc_h:hover',
					'.stm_single_ico__button.stm_single_ico__button_whitepaper',
				)
			),
		);

		foreach($css_styles as $property => $colors) {
			foreach($colors as $color => $elements) {
				$css .= implode(', ', $elements) . '{
					'. $property . ': ' . ${$color . '_color'} . '!important
				}';
			}
		}

		$custom_css = get_theme_mod( 'custom_css' );

		if ( $custom_css ) {
			$css .= preg_replace( '/\s+/', ' ', $custom_css );
		}

		wp_add_inline_style( 'crypterio-layout', $css );
	}
}

add_action( 'wp_enqueue_scripts', 'crypterio_print_styles' );


/*In crypterio 3.5 CSS saved in uploads folder*/
function crypterio_skin_custom() {
	$site_color = get_theme_mod( 'site_skin', 'skin_default' );

	if( $site_color == 'skin_custom' ) {
		global $wp_filesystem;

		if ( empty( $wp_filesystem ) ) {
			require_once ABSPATH . '/wp-admin/includes/file.php';
			WP_Filesystem();
		}

		$crypterio_config = crypterio_config();
		$custom_style_css = $wp_filesystem->get_contents( get_template_directory() . '/assets/css/'. $crypterio_config['layout'] .'/main.css' );

		$base_color = get_theme_mod( 'site_skin_base_color', $crypterio_config['base_color'] );
		$secondary_color = get_theme_mod( 'site_skin_secondary_color', $crypterio_config['secondary_color'] );
		$third_color = get_theme_mod( 'site_skin_third_color', $crypterio_config['third_color'] );

		$colors_arr = array();
		$colors_arr[] = $base_color;
		$colors_arr[] = $secondary_color;
		$colors_arr[] = $third_color;
		$colors_differences = false;

		$search_colors = array(
			$crypterio_config['base_color'],
			$crypterio_config['secondary_color'],
			$crypterio_config['third_color'],
			'../../'
		);

		$replace_colors = array(
			$base_color,
			$secondary_color,
			$third_color,
			'/wp-content/themes/crypterio/assets/'
		);

		if( !empty( $crypterio_config['base_rgb_color']['alpha'] ) ) {
			foreach( $crypterio_config['base_rgb_color']['alpha'] as $val ) {
				$search_colors[] = 'rgba('. $crypterio_config['base_rgb_color']['rgb'] .', '. $val .')';
				$replace_colors[] = crypterio_hex2rgba( $base_color, $val );
			}
		}

		if( !empty( $crypterio_config['secondary_rgb_color']['alpha'] ) ) {
			foreach( $crypterio_config['secondary_rgb_color']['alpha'] as $val ) {
				$search_colors[] = 'rgba('. $crypterio_config['secondary_rgb_color']['rgb'] .', '. $val .')';
				$replace_colors[] = crypterio_hex2rgba( $secondary_color, $val );
			}
		}

		if( !empty( $crypterio_config['third_rgb_color']['alpha'] ) ) {
			foreach( $crypterio_config['third_rgb_color']['alpha'] as $val ) {
				$search_colors[] = 'rgba('. $crypterio_config['third_rgb_color']['rgb'] .', '. $val .')';
				$replace_colors[] = crypterio_hex2rgba( $third_color, $val );
			}
		}

		$custom_style_css = str_replace( $search_colors, $replace_colors, $custom_style_css );
		$custom_style_css = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $custom_style_css );

		$upload_dir = wp_upload_dir();

		if( ! $wp_filesystem->is_dir( $upload_dir['basedir'] . '/stm_uploads' ) ) {
			wp_mkdir_p( $upload_dir['basedir'] . '/stm_uploads' );
		}

		if( $custom_style_css ) {
			$css_to_filter = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $custom_style_css );
			$css_to_filter = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $css_to_filter );

			$custom_style_file = $upload_dir['basedir'] . '/stm_uploads/skin-custom.css';

			if( $custom_style_file ) {
				$custom_style_content = $wp_filesystem->get_contents( $custom_style_file );

				if( is_array( $colors_arr ) && !empty( $colors_arr ) ) {
					foreach( $colors_arr as $color ) {
						$color_find = strpos( $custom_style_content, $color );
						if( ! $color_find && ! $colors_differences ) {
							$colors_differences = true;
						}
					}
				}

				if( $colors_differences ) {
					$wp_filesystem->put_contents($custom_style_file, $css_to_filter);
				}
			} else {
				$wp_filesystem->put_contents($custom_style_file, $css_to_filter);
			}
		}
	}
}

add_action( 'customize_save_after', 'crypterio_skin_custom', 20 );

function stm_migrate_prev_settings() {
	$transition = get_option('stm_css_transition', 'no');

	if($transition == 'no') {
		crypterio_skin_custom();
		update_option('stm_css_transition', 'yes');
	}
}

add_action('init', 'stm_migrate_prev_settings');