<?php 
	/* Template Name: Dates & Rates */
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
												<a href="<?php echo $image; ?>" >
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
								                                        
                                 <div class="text-wrap">
	                              	<?php the_field('top_content'); ?>
	                             </div>                     
                    
										  <div style="width: 100%; clear:both;">
                          	       <hr>
                                 
                             <?php if (have_rows('camp_cards') ): ?>
                            
                             
                             
                            <h1 align="center"><?php the_field('camp_cards_title');?></h1>
                            <div class="cards-container">
                               <div class="cards">
	                              <?php while( have_rows('camp_cards') ): the_row(); ?>
                            		<a class="card" href="<?php the_sub_field('anchor_tag');?>">
                            			<span class="card-header" style="background-image: url('<?php the_sub_field('image');?>');">
                     
                            			</span>
                            			<span class="card-summary">
                            				<span class="card-title">
                            					<h3><?php the_sub_field('header'); ?></h3>
                            					<span><?php the_sub_field('ages');?></span>
                            				</span>
                            				
                            				<span class="card-summary-text">
                            					<?php the_sub_field('camp_description');?>
                            				</span>
                            			</span>
                            			<span class="card-meta">
                            				See Dates >
                            			</span>
                            		</a>

										<?php endwhile; ?>
										<?php endif;  ?>

                            	</div> <!--cards-->
                            </div>   <!-- cards container -->
                            </div>
                            
                            <hr>
						<?php the_content(); ?> 
						<?php edit_post_link(); ?> 
					</div> <!-- text wrap -->
			</div><!-- content wrap -->
		</article> <!-- article-->
		<?php endwhile; ?>
		<?php else: ?>
		<article>
			<h2><?php _e( 'Sorry, nothing to display.', 'manitou' ); ?></h2>
		</article>
	<?php endif; ?>
	</div> <! -- col 12 -->
</div> <!-- content row -->
</div> <!-- right-column -->
</div> <!-- col 9 -->
</div><!-- layout row-->
</div> <!--/container-->
<?php get_footer(); ?>