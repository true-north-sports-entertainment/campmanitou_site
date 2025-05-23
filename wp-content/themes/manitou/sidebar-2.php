<!-- This sidebar is for any pages that do not have a Parent page (Search, Archive, Single psots, etc)--->
<aside class="sidebar" role="complementary">
	<h1 class="sidebar-title">Camp Manitou</h1>
		<div class="side-menu">
			<?php if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-2')) ?>
		</div>
	<ul class="sidebar-buttons">
		<li><a href="/virtual-tour" alt="Virtual Tour">Virtual Tour</a></li>
		<li><a href="/book-now/" alt="Book Now">Book Now</a></li>
		<li class="register-btn"><a href="//campmanitou.campbrainregistration.com/" target="_blank" alt="Register Now">Register Now</a></li>
		<li><a href="//tnyf.ca"  target="_blank"><img src="https://campmanitou.mb.ca/wp-content/themes/manitou/images/TNYF-horz-logo.png" alt="TNYF" width="200px" height="auto" /></a></li>
	</ul>
	<div class="side-logo">
		<a href="//www.projecteleven.ca/" target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/project11-logo.jpg" class="p11-logo" alt="Project 11" /></a>
	</div>
	<div class="side-logo">
		<a href="//www.mbcamping.ca/" target="_blank"><img style="width: auto; height: 80px;" src="<?php echo get_stylesheet_directory_uri(); ?>/images/ManitobaCamping.jpg" class="mca-logo" alt="Manitoba Camping Association" /></a>
	</div>
</aside>