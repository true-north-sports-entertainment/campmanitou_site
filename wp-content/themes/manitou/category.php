<?php get_header(); ?>
<a name="myAnchor" id="myAnchor">&nbsp;</a>

<div class="container">
	<div class="row">		
		<div class="col-md-3 col-sm-4">
			<?php include ('sidebar-2.php'); ?>
		</div> <!-- col 3-->
		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
			<div class="right-column">
				<div class="row">
						<h1><?php _e( 'Category: ', 'manitou' ); single_cat_title(); ?></h1>
						<div class="border-title"></div>
						
						<?php

					    $cat_args = array(
					        'orderby'      => 'date',
					        'order'        => 'DESC',
					        'child_of'     => 0,
					        'parent'       => '',
					        'type'         => 'post',
					        'hide_empty'   => true,
					        'taxonomy'     => 'category',
					    );
					
					    $categories = get_categories( $cat_args );
					
					    foreach ( $categories as $category ) {
					
					        $query_args = array(
					            'post_type'      => 'activities',
					            'category_name'  => $category->slug,
					            'posts_per_page' => 2,
					            'orderby'        => 'date',
					            'order'          => 'DESC'
					        );
					
					        $recent = new WP_Query($query_args);
					
					        while( $recent->have_posts() ) :
					            $recent->the_post();
					        ?>
					        <article class="post-article row">
						        <div class="col-sm-4 col-xs-12">	
										<div class="loop-img">		
											<?php if ( has_post_thumbnail() ) { the_post_thumbnail(); }
											else { echo '<img src="https://campmanitou.mb.ca/wp-content/uploads/2016/06/manitou-defaultthumb.jpg" alt="News thumbnail" />'; } ?>
										</div>
										
									</div> <!--col 4-->
								
									<div class="col-sm-8 col-xs-12">
										<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> </h3>
										
										<p><?php the_excerpt(); ?></p>
									</div> <!-- col 8 -->
								</article> <!-- post-article -->
					        
					        
					        <?php endwhile;
					    }
					    wp_reset_postdata();
					?>
														
														
						<?php //get_template_part('loop'); ?>
			
						<?php get_template_part('pagination'); ?>
				</div> <!-- right column -->
			</div> <!-- row -->
		</div> <!--col-->
	</div> <!-- layout row -->
</div> <!-- container-->
<?php get_footer(); ?>