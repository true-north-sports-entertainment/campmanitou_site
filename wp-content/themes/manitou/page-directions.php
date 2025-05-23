<?php 
	/* Template Name: Directions Page */
get_header(); ?>
<div class="inside-slider">
<?php if (has_post_thumbnail( $page->ID ) ) { ?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
	<div class="page-banner"><div class="page-banner" style="background-image: url('<?php echo $thumb['0'];?>');"></div>
</div>
<?php } ?>
<a href="#myAnchor" rel="" id="anchor1" class="anchorLink" aria-label="scroll down"><span class="chevron"></span></a>
<a name="myAnchor" id="myAnchor">&nbsp;</a>

<div class="container">
	<div class="row">		
		<div class="col-md-3 col-sm-4">
			<?php get_sidebar(); ?>
		</div>	
		<div class="col-md-9 col-sm-8 col-xs-12  no-gutter-mobile">
			<div class="right-column">
				<div class="row">
					<h1><?php echo get_field('page_title'); ?></h1>
					<div class="border-title"></div>
						<?php if (have_posts()): while (have_posts()) : the_post(); ?>
							<!-- article -->
							<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
								<?php the_content(); ?>
								<div class="google-map"><iframe title="Map to Camp Manitou" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2571.724212818625!2d-97.3476886842897!3d49.866424979399106!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x52ea0bff5f89a49b%3A0x7247dc5dd9275c7e!2sCamp+Manitou!5e0!3m2!1sen!2sca!4v1529527457822" width="100%" height="290" frameborder="0" style="border:0; margin: 15px 0 30px;" allowfullscreen></iframe></div>
								
								<div class="row">
									<div class="col-md-6 col-sm-12">
										<h3>Directions</h3>
										<?php echo get_field('directions'); ?>
									</div> <!-- col6-->
									
									<div class="col-md-6 col-sm-12">
										<h3>Mailing Address</h3> 
										<?php echo get_field('mailing_address'); ?>
										<div class="contact-info">
											<span class="d-icon icon-phone" aria-label="Phone Number"></span><a href="tel://1-<?php echo get_field('phone_number'); ?>" alt="1-204-837-4508"><?php echo get_field('phone_number'); ?></a> <br />
											 <span class="d-icon icon-print" aria-label="Fax Number"></span><?php echo get_field('fax_number'); ?> <br />
											<span class="d-icon icon-envelope" aria-label="Email Address"></span><a href="mailto:<?php echo get_field('email_address'); ?>"><?php echo get_field('email_address'); ?></a>
										</div> <!-- contact info -->
										<p> <?php echo get_field('additional_message'); ?> </p>
									</div> <!-- col 6-->							
								</div> <!--row-->
								<?php edit_post_link(); ?>
							</article>
					</div> <!--row-->	
					<?php endwhile; ?>
					<?php else: ?>
						<article><h3><?php _e( 'Sorry, nothing to display.', 'manitou' ); ?></h3></article>
					<?php endif; ?>
			</div> <!-- right columm-->
		</div><!--col-->
	</div><!--row-->
</div> <!--/container-->
<?php get_footer(); ?>
