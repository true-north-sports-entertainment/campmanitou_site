<?php get_header(); ?>
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
		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
			<div class="right-column">
				<div class="row">
					<h1><?php echo get_field('page_title'); ?></h1>
					<div class="border-title"></div>
	
						<?php if (have_posts()): while (have_posts()) : the_post(); ?>
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
							<?php the_content(); ?>
							<br class="clear">
							<div><?php edit_post_link(); ?> </div>
						</article>			
						<?php endwhile; ?>
						<?php else: ?>
						<article>
							<h3><?php _e( 'Sorry, nothing to display.', 'manitou' ); ?></h3>
						</article><!-- /article -->
						<?php endif; ?>
				</div> <!-- row-->
			</div> <!-- right col -->
		</div> <!-- col9 -->
	</div><!--row-->
</div> <!--/container-->
<?php get_footer(); ?>