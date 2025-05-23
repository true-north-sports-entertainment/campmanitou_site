<?php get_header(); ?>
<div class="inside-slider">

	<div class="page-banner" style="background-image: url('<?php bloginfo('url'); ?>/wp-content/uploads/2015/11/dates-rates-top-photo.jpg');"></div>
</div>

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
					<h1><?php _e( 'Photo Albums', 'manitou' ); ?></h1>
					<div class="border-title"></div>
					<!-- don't forget to add custom CSS for these cards *-->
					<div class="cards-container photo-albums">
    					<div class="cards">
        					<?php if (have_posts()): while (have_posts()) : the_post(); ?>
                            	<a class="card" href="<?php the_permalink(); ?>">
                        			<?php if (has_post_thumbnail( $page->ID ) ) { ?>
                                    <?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
                                    	<span class="card-header" style="background-image: url('<?php echo $thumb['0'];?>');">
                                    <?php } ?>
    
                        				<span class="card-title">
                        					<h3><?php the_title(); ?></h3>
                        				</span>
                        			</span>
                        		</a>
                        		
                        		
                        <?php endwhile; ?>
                        <?php else: ?>
                        
                        <article><h2><?php _e( 'Sorry, nothing to display.', 'manitou' ); ?></h2></article>
                        <?php endif; ?>
                        
                        </div> <!--- cards --->
					</div> <!-- cards - container -->
					<?php get_template_part('pagination'); ?>
				</div> <!-- right column -->
			</div> <!-- row -->
		</div> <!--col-->
	</div> <!-- layout row -->
</div> <!-- container-->
<?php get_footer(); ?>