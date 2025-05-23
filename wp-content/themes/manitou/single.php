<?php get_header(); ?>
<div class="inside-slider">
	<div class="page-top-photo">
		
			<?php if( is_single( 2396 ) ) { ?> <!-- Under Construction Post -->
		   	<div class="page-banner" style="background-image: url('https://campmanitou.mb.ca/wp-content/uploads/2020/03/under-construction-1920x600-1.jpg');"></div>
	   	<?php } else { ?>
	   		<div class="page-banner" style="background-image: url('https://campmanitou.mb.ca/wp-content/uploads/2015/11/dates-rates-top-photo.jpg');"></div>
	   	<?php } ?>
	</div>
	<a href="#myAnchor" rel="" id="anchor1" class="anchorLink" aria-label="scroll down"><span class="chevron"></span></a>
</div>
<a name="myAnchor" id="myAnchor">&nbsp;</a>
<div class="container">
	<div class="row">
		<div class="col-md-3 col-sm-4">
			<?php include ('sidebar-2.php'); ?>	
		</div>
		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
			<div class="right-column">
				<div class="row">
					<?php if (have_posts()): while (have_posts()) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<h1><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h1>
							<span class="date"><?php the_date(); ?> | By: <?php the_author(); ?></span>							
							<div class="border-title"> </div>
		
							<?php $featured_img = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), 'single-post-thumbnail' );  ?>
							<?php if ($featured_img) { ?>			
							<a href="<?php echo $featured_img[0]; ?>" data-rel="lightbox"><img src="<?php echo $featured_img[0]; ?>" class="image-container alignright" alt="featured thumbnail" /></a>				
							<?php } ?>
							                         														   
							<?php the_content();?>	
							<?php edit_post_link(); ?>
						</article>
					<?php endwhile; ?>
					<?php else: ?>
						<article><h1><?php _e( 'Sorry, nothing to display.', 'manitou' ); ?></h1></article>
					<?php endif; ?>
				</div><!--row-->
			</div><!--right column-->
		</div> <!-- col 9 -->
	</div><!-- layout row -->
</div> <!--container-->
<?php get_footer(); ?>
