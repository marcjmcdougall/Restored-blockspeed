<?php
$video = get_post_meta(get_the_ID(), 'stm_post_video', true);
if (!empty($video)): ?>
	<a class="stm_post__video sbc_a tbc_a_h stm_iframe_btn" href="<?php echo esc_attr($video); ?>"></a>
<?php endif; ?>