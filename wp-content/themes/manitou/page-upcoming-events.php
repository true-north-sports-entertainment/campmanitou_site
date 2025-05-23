<?php 
	/* Template Name: Upcoming Events */
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
					<h1><?php _e( 'News', 'manitou' ); ?></h1>
					<div class="border-title"></div>
				
					<?php $args = array( 'post_type' => 'post', 'post_type' => 'upcoming-events', 'posts_per_page' => 5, 'paged' => ( get_query_var('paged') ? get_query_var('paged') : 1), ); query_posts($args); while (have_posts()) : the_post(); ?>

					<article class="post-article row">
						<div class="col-sm-4 col-xs-12">
							<div class="loop-img"><?php the_post_thumbnail(); ?></div>
						</div> <!--col 4-->
					
						<div class="col-sm-8 col-xs-12">
							<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> </h3>
							<span class="date"><?php the_date(); ?> <?php if( get_field('news_author') ): ?> | By: <?php the_field('news_author'); ?></h2><?php endif; ?></span>
							<p><?php the_excerpt(); ?></p>
						</div> <!-- col -->
					</article>
					<?php endwhile; ?>	
					<?php get_template_part('pagination'); ?>
				

				</div> <!-- row -->
			</div> <!-- right column -->
		</div> <!-- col 9 -->
	</div> <!--row-->
</div> <!--container -->
<?php get_footer(); ?>

