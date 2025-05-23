<?php 
	/*
	Template Name: Testimonials
	*/
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
		<div class="col-md-3 col-sm-4 col-xs-12">
			<?php get_sidebar(); ?>
		</div>
				
		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
			<div class="right-column">
				<div class="row">
					<div class="col-md-12 no-gutter">
					<?php if (have_posts()): while (have_posts()) : the_post(); ?>
			
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<div class="content-wrap">
								 <?php if( have_rows('page_images') ): ?>
									<ul class="page-images row">
									<?php while( have_rows('page_images') ): the_row(); $image = get_sub_field('image');?>
										<li class="col-xs-12">
											<?php if( $image ): ?>
												<a href="<?php echo $image; ?>" data-rel="lightbox-gallery-wTk0">
											<?php endif; ?>
								
											<?php if( $image ): ?>
											<div class="image-container"> <img src="<?php echo $image; ?>" alt="<?php echo $image; ?>" /> </div>
												</a>
											<?php endif; ?>
										    <?php echo $content; ?>
										</li>
									<?php endwhile; ?>
									</ul>
									<?php endif; ?>	
											
									<div class="text-wrap">	
										<h1><?php echo get_field('page_title'); ?></h1>
										<div class="border-title"></div>	
										<?php the_content(); ?>
										<?php if( have_rows('testimonials') ): ?>
	
										<ul class="testimonial-list">
										<?php while( have_rows('testimonials') ): the_row(); 
											$testimonial = get_sub_field('testimonial');
											$author = get_sub_field('author'); ?>
											<li>
												<blockquote>
													<?php echo $testimonial; ?> <br />
													<em><?php echo $author; ?></em>
												</blockquote>
											</li>
										<?php endwhile; ?>
										</ul>
										<?php endif; ?>
								</div> <!-- text wrap -->
								<?php edit_post_link(); ?> 
							</div><!-- content wrap -->
						</article> <!-- article-->

						<?php endwhile; ?>
						<?php else: ?>
						<article><h2><?php _e( 'Sorry, nothing to display.', 'manitou' ); ?></h2></article>
						<?php endif; ?>
					</div> <! -- col 12 -->
				</div> <!-- row -->
			</div> <!-- right-column -->
		</div> <!-- col 9 -->
	</div><!--layout row-->
</div> <!--/container-->
<?php get_footer(); ?>
					