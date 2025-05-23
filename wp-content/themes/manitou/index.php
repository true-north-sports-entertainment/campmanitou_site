<?php get_header(); ?>

 <div class="hide-slider">
    <div class="inside-slider">
	    <?php echo do_shortcode('[smartslider3 slider=2]'); ?>
	</div>
	  <a href="#myAnchor" rel="" id="anchor1" class="anchorLink" aria-label="scroll down"><span class="chevron"></span></a>
</div>

<a name="myAnchor" id="myAnchor">&nbsp;</a>

<div class="container">
	<div class="row">
		<div class="col-md-3 col-sm-4 col-xs-12">
			<?php include ('sidebar-2.php'); ?>
		</div>
	
		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
			<div class="right-column">	

				<h1><?php _e( 'Latest Posts', 'html5blank' ); ?></h1>
					<div class="border-title"></div>
				
				<?php get_template_part('loop'); ?>
				<?php get_template_part('pagination'); ?>
	
			</div>
		</div>
		
	</div> <!-- row -->
</div> <!-- container-->

<?php get_footer(); ?>

