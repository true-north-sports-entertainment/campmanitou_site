<?php 
	/* Template Name: Meet Our Staff */
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
		<div class="col-md-3 col-sm-4 ">
			<?php get_sidebar(); ?>
		</div>
			
		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
			<div class="right-column">
				<div class="row">
				<h1><?php echo get_field('page_title'); ?></h1>
					<div class="border-title"></div>
					<?php if (have_posts()): while (have_posts()) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php the_content(); ?>
							
								<?php if( have_rows('staff_member') ): ?>
								<?php while( have_rows('staff_member') ): the_row(); 
									$image = get_sub_field('headshot');
									$name = get_sub_field('name');
									$description = get_sub_field('description'); ?>
									
								<div class="row staff-member">
									<div class="col-xs-12">
										<img class="image-container alignleft" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt'] ?>" width="180" />
										<h3><?php echo $name; ?></h3>
										<?php echo $description; ?>
									</div> <!--col12-->
								</div> <!--row-->
							
								<?php endwhile; ?>
								<?php endif; ?>						
						</article>
						<?php edit_post_link(); ?>
						<?php endwhile; ?>
						<?php else: ?>
						<article><h3><?php _e( 'Sorry, nothing to display.', 'manitou' ); ?></h3></article>
						<?php endif; ?>
				</div> <!--row-->
			</div> <!-- right column -->		
		</div> <!-- col 9 -->	
	</div><!-- layout row-->
</div> <!--/container-->
<?php get_footer(); ?>