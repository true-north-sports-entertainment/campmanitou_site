<?php 
	/* Template Name: Activities Page */
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
				<h1><?php _e( 'Activities', 'manitou' ); ?></h1>
					<div class="border-title"></div>
					<?php the_content(); ?>
			
			
			 <div class="row">		      
		            <?php 
					$post_type = 'activities';
					$taxonomies = get_object_taxonomies( $post_type );
					
					foreach ($taxonomies as $taxonomy){
					    $terms = get_terms($taxonomy, array('orderby' => 'id', 'order' => 'ASC', 'exclude' => '1'));
					
					     $j=1;   if ( !empty( $terms ) && !is_wp_error( $terms ) ){
					        foreach ( $terms as $term ) {
					            $args = array(
					                'post_type'           => $post_type,
					                'orderby'             => 'title',
					                'order'               => 'ASC',
					                'ignore_sticky_posts' => 1,
					                'post_status'         => 'publish',
					                'posts_per_page'      => - 1,
					                'tax_query'           => array(
					                    array(
					                        'taxonomy'    => $taxonomy,
					                        'field'       => 'slug',
					                        'terms'       => $term->slug
					                    )
					                )
					            );
					            $my_query = null;
					            $my_query = new WP_Query($args);
					               if ($my_query->have_posts()) {
					                echo '<div class="panel-group col-md-4 col-sm-6" role="tablist" aria-multiselectable="true"><h3>' . $term->name . '</h3>';
					
					        $j=1;  while ($my_query->have_posts()) : $my_query->the_post(); ?>
		
		            <div class="panel panel-default activity-panel">
		                <div class="panel-heading" role="tab" id="heading-<?php the_ID(); ?>">
		                    <h3 class="panel-title"><a data-toggle="collapse" data-parent="#accordion-<?php the_ID(); ?>" href="#collapse-<?php the_ID(); ?>" aria-expanded="true">
			                    <?php if(get_field('icon_url')){?>
			                   <img src="<?php the_field('icon_url'); ?>" class="a-icon" alt="+" />
							   <?php } else{?>
							<img src="<?php bloginfo('url'); ?>/wp-content/themes/manitou/images/map/plus.svg" alt="+" class="a-icon" />
							<?php } ?>
<?php the_title(); ?></a></h3>
		                </div><!-- panel heading -->
		
		                <div id="collapse-<?php the_ID(); ?>" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading-<?php the_ID(); ?>">
		                    <div class="panel-body">
<!-- 		                        <a href="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-ArtsCrafts.jpg" data-rel="lightbox"><img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-ArtsCrafts.jpg" class="image-container alignright"></a> -->
		                        
		                        <?php $featured_img = wp_get_attachment_image_src ( get_post_thumbnail_id ( $post->ID ), 'single-post-thumbnail' );  ?>
											<?php if ($featured_img) { ?>
											<a href="<?php echo $featured_img[0]; ?>" data-rel="lightbox"><img src="<?php echo $featured_img[0]; ?>" class="image-container alignright" alt="Activity Thumbnail" /></a>
											
											<?php } ?>
		                        <?php the_content();?>	
		                    </div><!--panel-body-->
		                </div><!-- collapse -->
		            </div> <!-- panel -->
		       
					                    <?php
					                    endwhile; 
					            } // END if have_posts loop
					                echo '</div>'; // Close 'details', 'wrap', & 'aro' DIVs
					            wp_reset_query(); 
					        } // END foreach $terms
					    }
					}
					?>
					
				
	                 <?php
	                    wp_link_pages("\t\t\t\t\t<div class='page-link'>".__('Pages: ', 'manitou'), "</div>\n", 'number');
	                    
	                    edit_post_link(__('Edit', 'manitoucan'),'<span class="edit-link">','</span>') ?>

			 </div>
			 				
					<p><em><strong>* = coming soon</strong></em></p>			
			
				</div> <!-- row -->
			</div> <!-- right column -->
		</div> <!-- cols-->
		
		
		
		
	</div> <!--row-->
</div> <!--container -->

<?php get_footer(); ?>
