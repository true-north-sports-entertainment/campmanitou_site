<?php get_header(); ?>
<div class="inside-slider">
	<div class="page-top-photo">
		<div class="page-banner" style="background-image: url('https://campmanitou.mb.ca/wp-content/uploads/2015/11/dates-rates-top-photo.jpg');"></div>
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
				<div class="row">
					<article id="post-404"> 
						<h1><?php echo sprintf( __( '%s Search Results for: ', 'manitou' ), $wp_query->found_posts ); echo get_search_query(); ?></h1>
						<div class="border-title"></div>
						
						<?php get_template_part('searchform'); ?>
						<hr>
						<?php get_template_part('loop'); ?>
						<?php get_template_part('pagination'); ?>
					</article><!-- /article -->
				</div><!--row-->
			</div><!-- right column-->
		</div> <!-- col 9 -->
	</div> <!-- row-->
</div><!-- container-->
<?php get_footer(); ?>