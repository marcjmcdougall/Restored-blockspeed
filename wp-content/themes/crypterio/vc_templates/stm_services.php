<?php
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, vc_shortcode_custom_css_class( $css, ' ' ) );

$css_class .= ' cols_' . $posts_per_row;

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
$args = array(
	'post_type'      => 'stm_service',
	'posts_per_page' => $posts_per_page,
    'paged' 		 => $paged
);

if ( empty( $img_size ) ) {
	$img_size = 'crypterio-image-255x182-croped';
}

if ( $category != 'all' ) {
    $args['stm_service_category'] = $category;
}

$services = new WP_Query( $args );

$count_posts = wp_count_posts( 'stm_service' );
$published_posts = $count_posts->publish;

?>

<?php if ( $services->have_posts() ): ?>
	<div class="stm_services<?php echo esc_attr( $css_class ); ?>">
		<?php while ( $services->have_posts() ): $services->the_post(); ?>
			<div class="item">
				<div class="item_wr">
					<?php if ( has_post_thumbnail() ): ?>
						<?php
						$post_thumbnail = wpb_getImageBySize( array(
								'attach_id'  => get_post_thumbnail_id(),
								'thumb_size' => $img_size,
						) );
						$post_thumbnail = $post_thumbnail['thumbnail'];
						?>

						<div class="item_thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php echo crypterio_sanitize_text_field($post_thumbnail); ?>
							</a>
							<?php if(stm_check_layout('layout_18')): ?>
								<h5 class="stm_title_l18"><?php the_title(); ?></h5>
							<?php endif; ?>
						</div>
					<?php endif; ?>
                    <?php $url = esc_url(get_the_permalink(get_the_id())); ?>
                    <div class="content">
                        <h5><a href="<?php echo crypterio_sanitize_text_field($url); ?>"><?php the_title(); ?></a></h5>
                        <?php if( get_the_excerpt() ) : ?>
                            <?php the_excerpt(); ?>
                        <?php endif; ?>
                        <a class="read_more" href="<?php echo crypterio_sanitize_text_field($url); ?>">
                            <span><?php echo esc_html__( 'read more', 'crypterio' ); ?></span>
                            <i class=" fa fa-chevron-right stm_icon"></i>
                        </a>
                    </div>
				</div>
			</div>
		<?php endwhile; ?>
	</div>
<?php endif;
wp_reset_postdata(); ?>