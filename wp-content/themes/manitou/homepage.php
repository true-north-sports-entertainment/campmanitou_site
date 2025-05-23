<?php 
/*

Template Name: Homepage

*/
	get_header(); ?>

<div class="container-clearfix">
	<div class="slider"><?php echo do_shortcode('[smartslider3 slider=1]'); ?></div>
	<div class="mobile-slider"><?php echo do_shortcode('[smartslider3 slider=4]'); ?></div>

	<div class="signs-section">
	    <div class="signs-container container">
		    <div class="row" style="display: flex;justify-content: center;">
				
				  <!-- Sign 0 -->
		        <div class="col-sm-3 col-xs-6">
			        <a href="https://campmanitou.campbrainregistration.com/" target="_blank" alt="COVID-19 Update">
		        <div class="feature-sign-container-3">
		            <div class="feature-sign-inner">
		                <div class="feature-sign-text">
		                 Register Now              
		                  </div>
		                 <!--<div class="image-container">
		                <div class="photo-tape-1"></div>
		                     <div class="inside-image">
		              	  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sign-winter-specials.jpg" width="100px" alt="Winter Specials" />
		                </div>
		                
		                 <div class="photo-tape-3"></div>
		                </div>-->
	
		            </div>
		            <div class="feature-sign-bottom"></div>
		        </div>
			        </a>
		        </div> 
			     <!-- Sign 1 -->
			    <div class="col-sm-3 col-xs-6">
			        <a href="<?php get_stylesheet_directory();?>dates-and-rates/">
				        <div class="feature-sign-container-1">
					        
				            <div class="image-container">
					            
					            <div class="photo-tape-1"></div>
					            <div class="photo-tape-2"></div>
				            
				                <div class="inside-image">
								 	<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sign-zipline-dates.jpg" width="100px" alt="Dates & Rates" />
			                	</div>
				            
				            </div>
				            <div class="feature-sign-text">
				                Summer Camp
				            </div>
				        </div> <!-- feature-sign-->
			        </a>
			    </div> <!-- /col-->
		         <!-- Sign 2 -->
		        <div class="col-sm-3 col-xs-6">
			        <a href="<?php get_stylesheet_directory();?>book-now/" alt="Enquiries">
			        <div class="feature-sign-container-3">
			            <div class="feature-sign-inner">
			                <div class="feature-sign-text"  >
			                    Enquiries
			                </div>
<!-- 			                <div class="image-container">
				                
			                <div class="photo-tape-1"></div>
			                <div class="photo-tape-2"></div>
			                
			                <div class="inside-image">
			              	  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sign-booknow-wall.jpg" width="100px" alt="Meet Our Staff" />
			                </div>
			                
			                </div> -->
			            </div>
			            <div class="feature-sign-bottom"></div>
			        </div>
			        </a> 
		        </div> <!-- /col-->
		        
		       <!--/col-->
		        
		         <!-- Sign 4 -->
<!-- 		        <div class="col-sm-3 col-xs-6">
			        <a href="https://campmanitou.mb.ca/upcoming-events/camp-under-construction-faqs/" alt="Under Construction FAQ's">
		        <div class="feature-sign-container-4">
		            <div class="feature-sign-inner">
		                <div class="feature-sign-text">
		                    Under Construction FAQs
		                </div> -->
<!--
		                <div class="image-container">
		                <div class="photo-tape-1"></div>
		                     <div class="inside-image">
		              	  <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/sign-donate-people.jpg" width="100px" alt="Donate Now" />
		                </div>
		                
		                 <div class="photo-tape-3"></div>
-->
		                </div>
		            </div>
		            <div class="feature-sign-bottom"></div>
		        </div> </a>
		        </div> <!-- col -->	        
		    </div> <!-row->
	    </div> <!-signs-section->
</div> <!-signs-cotnainer->
<?php //get_sidebar(); ?><?php get_footer(); ?>