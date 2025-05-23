<?php if (have_posts()): while (have_posts()) : the_post(); ?>
<article class="post-article row">
	<div class="col-sm-4 col-xs-12">	
		<div class="loop-img">		
			<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); }
			else { echo '<img src="https://campmanitou.mb.ca/wp-content/uploads/2016/06/manitou-defaultthumb.jpg" alt="News thumbnail" />'; } ?>
		</div>
		
	</div> <!--col 4-->

	<div class="col-sm-8 col-xs-12">
		<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> </h3>
		<span class="date"><?php the_date(); ?> | By: <?php the_author(); ?></h2></span>
		<p><?php the_excerpt(); ?></p>
	</div> <!-- col 8 -->
</article> <!-- post-article -->
<?php endwhile; ?>
<?php else: ?>

<article><h2><?php _e( 'Sorry, nothing to display.', 'manitou' ); ?></h2></article>
<?php endif; ?>


