<aside class="sidebar" role="complementary">
	<div class="sidebar-title">
		<?php
		$parent_title = get_the_title($post->post_parent);
		echo $parent_title; ?> 
	</div>

	<div class="side-menu">
		<?php echo do_shortcode('[wpb_childpages]'); ?> <!-- every other page pulls child page links -->
	</div>
	
	<ul class="sidebar-buttons">
		<li><a href="/virtual-tour" alt="Virtual Tour">Virtual Tour</a></li>
		<li><a href="/book-now/" alt="Book Now">Enquiry Form</a></li>
		<li class="register-btn" style="background:#C60B2B !important;"><a href="//campmanitou.campbrainregistration.com/" target="_blank" alt="Register Now">Summer Camp Registry</a></li>
		<li><a href="https://truenorthyouthfoundation.com" target="_blank"><img src="//campmanitou.mb.ca/wp-content/themes/manitou/images/TNYF-horz-logo.png" width="200px" height="auto" alt="TNYF" /></a></li>
	</ul>
	<div class="side-logo">
		<a href="//www.projecteleven.ca/" target="_blank">
			<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/project11-logo.jpg" class="p11-logo" alt="Project 11" />
		</a>
	</div>
	<div class="side-logo">
		<a href="//www.mbcamping.ca/" target="_blank">
			<img style="width: auto; height: 80px;" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ManitobaCamping.jpg" class="mca-logo" alt="Manitoba Camping Association" />
		</a>
	</div>
</aside>
