<?php 
	/*
	Template Name: FAQ Template
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
		<div class="col-md-3 col-sm-4 no-gutter-mobile-left">
			<?php get_sidebar(); ?>
		</div>
			
		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
		<div class="right-column">
			<span style="color: #ff0000;"> <a class="button" style="color: #ff0000; width:100%;" href="https://campmanitou.campbrainregistration.com/" target="_blank"><b>Register Now</b></a>
			<div class="row">
				<h1><?php echo get_field('page_title'); ?></h1>
				<div class="border-title"></div>
				<?php if (have_posts()): while (have_posts()) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php the_content(); ?>
						
						<div class="col-md-12  no-gutter-left">	
							<?php if( have_rows('faqs') ): ?>					
							<?php $j=1; while ( have_rows('faqs') ) : the_row(); ?>
							
							<h2><?php the_sub_field('faq_section'); ?></h2>
							<div class="panel-group" id="accordion-<?php echo $j; ?>" role="tablist" aria-multiselectable="true">
							<?php if( have_rows('faq') ): ?>
							<?php $i=1; while ( have_rows('faq') ) : the_row(); ?>
							
								<div class="panel panel-default">
								    <div class="panel-heading" role="tab" id="heading-<?php echo $i; ?>">
								      <h3 class="panel-title">
								        <a data-toggle="collapse" data-parent="#accordion-<?php echo $j; ?>" href="#collapse-<?php echo $j; ?>-<?php echo $i; ?>" aria-hidden="false" aria-expanded="true"> 
								         <div class="pm-icon-c"><span class="pm-icon icon-plus"></span></div><?php the_sub_field('question'); ?>								         
								        </a>
								      </h3>
								    </div> <!-- panel heading -->
								    <div id="collapse-<?php echo $j; ?>-<?php echo $i; ?>" class="panel-collapse collapse <?php //if ($i==1) { echo 'in'; } ?>" role="tabpanel" aria-labelledby="heading-<?php echo $i; ?>">
								      <div class="panel-body">
								       <?php the_sub_field('answer'); ?>
								      </div> <!--panel-body-->
								    </div> <!-- collapse -->
								</div> <! -- panel default-->
								
								<?php $i++; endwhile; ?>
								<?php endif; ?>
								</div> <!-- panel group --->	
								<?php $j++; endwhile; ?>
								<?php endif; ?>
						</div> <!--col 12-->				  
						<?php edit_post_link(); ?>
		
					</article>				
					<?php endwhile; ?>
					<?php else: ?>
					<article><h3><?php _e( 'Sorry, nothing to display.', 'manitou' ); ?></h3></article>
					<?php endif; ?>
		
			</div><!-- row -->
		</div> <!-- right-column -->
		</div> <!-- 9 col-->
	</div><!-- layout row-->
</div> <!--/container-->
<?php get_footer(); ?>