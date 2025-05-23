<?php get_header(); ?>
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
							<div class="border-title"> </div>
  									
  							<?php 
							$images = get_field('gallery');
							if( $images ): ?>
							    <div class="gallery-wrap">
							        <?php foreach( $images as $image ): ?>
							            	<div class="photo-thumbnail">
							                <a href="<?php echo $image['url']; ?>" rel="lightbox" style="background-image:url(<?php echo $image['sizes']['medium']; ?>)"></a>
							          </div>
							        <?php endforeach; ?>
							    </div>
							<?php endif; ?>

					   
							<?php// the_content();?>	
							<br />
                   <a type="button" class="btn blue btn-sm" href="/whats-new/photo-albums/">« Back to albums list</a>
                   <p><?php edit_post_link(); ?></p>

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
