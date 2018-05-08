<div class="team-item">
	
	<div class="image">
		
		<?php $image = get_field('profile_image'); ?>

		<div style="background-image: url(<?php echo $image['url']; ?>);" class="team-profile-image"></div>

	</div><div class="content">
		
		<h3><?php the_title(); ?></h3>
		<p class="role"><?php the_field('role'); ?></p>

		<?php

		// check if the repeater field has rows of data
		if( have_rows('social_media') ): ?>

			<ul class="social-links"><?php

			 	// loop through the rows of data
			    while ( have_rows('social_media') ) : the_row(); ?>

			        <li><a href="<?php the_sub_field('uri'); ?>" target="_blank"><?php the_sub_field('label'); ?></a></li>

			    <?php endwhile; ?>

			</ul><?php

			else :

			// No rows found, just do nothing.

		endif;

		?>

		<div class="details"><?php echo get_field('bio'); ?></div>

		<p><?php the_field('fname'); ?> has worked with companies such as:</p>

		<?php

		// check if the repeater field has rows of data
		if( have_rows('brands') ): ?>

			<ul class="brand-images"><?php

			 	// loop through the rows of data
			    while ( have_rows('brands') ) : the_row(); ?>

			    	<?php $image = get_sub_field('brand_image'); ?>

			        <li><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>"/></li>

			    <?php endwhile; ?>

			</ul><?php

			else :

			// No rows found, just do nothing.

		endif;

		?>

	</div>

</div>