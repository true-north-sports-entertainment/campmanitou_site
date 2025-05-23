<?php get_header(); ?>
<div class="inside-slider">
	<div class="page-top-photo">
		<div class="page-banner" style="background-image: url('<?php bloginfo('url'); ?>/wp-content/uploads/2015/11/dates-rates-top-photo.jpg');"></div>
	</div>
	<a href="#myAnchor" rel="" id="anchor1" class="anchorLink" aria-label="scroll down"><span class="chevron"></span></a>
</div>
<a name="myAnchor" id="myAnchor">&nbsp;</a>
<div class="container">	
	<div class="row">		
		<div class="col-md-3 col-sm-4">
			<?php include ('sidebar-2.php'); ?>
		</div> <!-- col 3-->
		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
			<div class="right-column">
				<div class="row">
					<article id="post-404">
						<h1><?php _e( 'Page not found', 'manitou' ); ?></h1>
						<div class="border-title"></div>
						
						<p>Sorry, but we were unable to find what you were looking for. Perhaps searching will help.</p>
						
						<?php get_template_part('searchform'); ?>
						
						&nbsp;
						<h3><a href="<?php echo home_url(); ?>"><?php _e( 'Return home?', 'manitou' ); ?></a></h3>
					</article><!-- /article -->
				</div><!--row-->
			</div><!-- right column-->
		</div> <!-- col 9 -->
	</div> <!-- row-->
</div><!-- container-->
<?php get_footer(); ?>