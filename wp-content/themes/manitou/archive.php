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
		<div class="col-md-3 col-sm-4 col-xs-12">
			<?php include ('sidebar-2.php'); ?>	
		</div>

		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
			<div class="right-column">
				<div class="row">
					<h1><?php _e( 'Archives', 'manitou' ); ?></h1>
					<div class="border-title"></div>
					<?php get_template_part('loop'); ?>
		
					<?php get_template_part('pagination'); ?>
				</div> <!-- right column -->
			</div> <!-- row -->
		</div> <!--col-->
	</div> <!-- layout row -->
</div> <!-- container-->
<?php get_footer(); ?>