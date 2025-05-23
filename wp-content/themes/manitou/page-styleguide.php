<?php 
	/* Template Name: Styleguide */
	get_header(); ?>
	
<div class="inside-slider">
<?php if (has_post_thumbnail( $page->ID ) ) { ?>
<?php $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full' ); ?>
	<div class="page-banner"><div class="page-banner" style="background-image: url('<?php echo $thumb['0'];?>');"></div>
</div>
<?php } ?>
<a href="#myAnchor" rel="" id="anchor1" class="anchorLink"><span class="chevron"></span></a>
<a name="myAnchor" id="myAnchor">&nbsp;</a>
<div class="container">
	<div class="row">
		<div class="col-xs-12 no-gutter-mobile">	
			<div class="right-column">
				<div class="row">
				<h1>Camp Manitou Styleguide</h1>
 					<div class="border-title"></div>
					
						<?php the_content(); ?>
 
            <p>This style guide is used to maintain front-end code and visual consistency across the website. The styles and their code snippets are listed below. Code snippets are in HTML and must be applied in the Text tab of Wordpress. If you're unfamiliar with HTML, please use the Visual tab to build out your posts/pages instead.

</p>
<hr>
   
      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-default" id="headings">
            <div class="panel-heading">Headings</div>
            <div class="panel-body">
            <h1 class="page-header">Page Header <small>With Small Text</small></h1>
            <div class="border-title"></div>
            
            <h1>This is an h1 heading</h1>
            <h2>This is an h2 heading</h2>
            <h3>This is an h3 heading</h3>
            <h4>This is an h4 heading</h4>
            <h5>This is an h5 heading</h5>
            <h6>This is an h6 heading</h6>
            </div>
          </div>
          <div class="panel panel-default" id="tables">
            <div class="panel-heading">Tables
            </div>
            <div class="panel-body">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Tables</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Michael</td>
                  <td>Are formatted like this</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Lucille</td>
                  <td>Do you like them?</td>
                </tr>
                <tr class="success">
                  <td>3</td>
                  <td>Success</td>
                  <td></td>
                </tr>
                <tr class="danger">
                  <td>4</td>
                  <td>Danger</td>
                  <td></td>
                </tr>
                <tr class="warning">
                  <td>5</td>
                  <td>Warning</td>
                  <td></td>
                </tr>
                <tr class="active">
                  <td>6</td>
                  <td>Active</td>
                  <td></td>
                </tr>
              </tbody>
            </table>
            <table class="table table-striped table-bordered table-condensed">
              <thead>
                <tr>
                  <th>#</th>
                  <th>First Name</th>
                  <th>Tables</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>1</td>
                  <td>Michael</td>
                  <td>This one is bordered and condensed</td>
                </tr>
                <tr>
                  <td>2</td>
                  <td>Lucille</td>
                  <td>Do you still like it?</td>
                </tr>
              </tbody>
            </table>
            </div>
          </div>
        </div>
        
        <div class="col-lg-6">
          <div class="panel panel-default" id="content-formatting">
            <div class="panel-heading">Content Formatting
            </div>
            <div class="panel-body">
            <p class="lead">This is a lead paragraph.</p>
            <p>This is an <b>ordinary paragraph</b> that is <i>long enough</i> to wrap to <u>multiple lines</u> so that you can see how the line spacing looks.</p>

            <p><small>This is text in a <code>small</code> wrapper. <abbr title="No Big Deal">NBD</abbr>, right?</small></p>
            <hr>
            <address>                <strong>Camp Manitou</strong><br>                c/o True North Youth Foundation<br>               345 Graham Avenue<br>   Winnipeg, MB R3C 5S6 <br>             <abbr title="Phone">P:</abbr> (123) 456-7890              </address><address class="col-6">                <strong>Full Name</strong><br>                <a href="mailto:#">first.last@example.com</a>              </address>

            <hr>
            <blockquote>Here's what a blockquote looks like. You can use this for testimonials, quotes, etc. <br /> <em>Use <code>em</code> to identify the source.</em>
            </blockquote>
            
            <pre><code>&lt;blockquote>Here's what a blockquote looks like. You can use this for testimonials, quotes, etc. &lt;/blockquote></code></pre>
            
            <hr>
            <div class="row">
              <div class="col-xs-6">
                <ul>
                  <li>Normal Unordered List</li>
                  <li>Can Also Work
                    <ul>
                      <li>With Nested Children</li>
                    </ul>
                  </li>
                  <li>Adds Bullets to Page</li>
                </ul>
              </div>
              <div class="col-xs-6">
                <ol>
                  <li>Normal Ordered List</li>
                  <li>Can Also Work
                    <ol>
                      <li>With Nested Children</li>
                    </ol>
                  </li>
                  <li>Adds Bullets to Page</li>
                </ol>
              </div>
            </div>

            </div>
          </div>
        </div>
      </div>
      
      <div class="row">
	      <div class="col-md-12">
		      <div class="panel panel-default" id="colours">
		      	<div class="panel-heading">Colours</div>
			      	<div class="panel-body" style="color: #fff;">
				      	
				      <ul class="color-list">
						<li class="color-box" style="background: #ffc60b;">Yellow <br> #ffc60b</li>
						<li class="color-box" style="background: #f58220;">Orange <br> #f58220</li>
						<li class="color-box" style="background: #008c44;">Green <br> #008c44</li>
						<li class="color-box" style="background: #0069aa;">Light Blue <br> #0069aa</li>
						<li class="color-box" style="background: #c41230;">Red <br> #c41230</li>
						<li class="color-box" style="background: #002453;">Dark Blue <br> #002453</li>
					</ul>
					
<!--



				      	<div class="col-sm-3 img-thumbnail">
					      	Body Text Colour - #00295E
				      	</div>
				      	
				      	<div class="col-sm-3 img-thumbnail" style="background: #00295E">
					      	Link Colour - #0067AC
				      	</div>
				      	
				      <div class="col-sm-3 img-thumbnail" style="background: #002d62; height: 100px;">
				      	h1 - #002d62
				      	   </div>
-->
				      	
				      			      	</div>
		      </div>
      	</div>
      </div>
      
      

	  <div class="row">
		  <div class="panel panel-default" id="buttons">
            <div class="panel-heading">Dates & Rates Layout
            </div>
            <div class="panel-body">
	            
	            

<!-- 	<div class="col-md-4 col-sm-12" align="center" style="text-align: left;padding: 0 30px;"> -->
		<div class="col-sm-1">
			<span class="dr-icons reg-icon"></span>
		</div>
		<div class="col-sm-11">
		<h4>Registration</h4>
		<p><strong><Em>** LIMITED SPACES LEFT **</Em></strong> <br />
		All weeks of day camp are sold out. Wait list is available.
		</p>

		</div>
<!-- 	</div> -->
	
<div class="col-sm-1">
<span class="dr-icons faq-icon"></span>
</div>
<div class="col-sm-11">
		<h4>FAQ's</h4>
		<p>Questions about Camp Registration? Check out our Frequently Asked Questions page</p>
		 
</div>

<div class="col-sm-1">
		<span class="dr-icons regchanges-icon"></span>
</div>
<div class="col-sm-11">
		<h4>Registration Changes</h4>
		<p>Need to make changes to your child’s camp registration? Please follow this link to update your child’s registration.</p>
		<a class="btn red" href="#">REGISTER NOW</a>
		<P><em>*Please contact us for a hard copy registration form</em></P>

	</div>
</div>
&nbsp;		


<hr>

<h2 align="center">Summer Camps</h2>
<div class="cards-container">
    <div class="cards">
         <a class="card" href="#daycamp">
 			<span class="card-header" style="background-image: url('https://campmanitou.mb.ca/wp-content/uploads/2019/12/biking-1920.jpg');">

 			</span>
 			<span class="card-summary">
 				<span class="card-title">
 					<h3>Day Camp</h3>
 					<span></span>
 				</span>
 				
 				<span class="card-summary-text">
 					<p>Experience all the outdoor adventure activities, while still being able to go home at night.</p>
<ul>
<li>Monday-Friday</li>
<li>Grades K-8</li>
<li>Camp programming runs 9:00 am to 4:00 pm</li>
<li>Drop off as early as 8:00 am, pick up as late as 5:00 pm</li>
<li>Price includes lunch, one daily snack, and before &amp; after care</li>
</ul>
 				</span>
 			</span>
 			<span class="card-meta">
 				See Dates &gt;
 			</span>
 		</a>

	      <a class="card" href="#2nightcamp">
 			<span class="card-header" style="background-image: url('https://campmanitou.mb.ca/wp-content/uploads/2019/12/IMG_6675.jpg');">

 			</span>
 			<span class="card-summary">
 				<span class="card-title">
 					<h3>2-Night Overnight Camp </h3>
 					<span></span>
 				</span>
 				
 				<span class="card-summary-text">
 					<p>Get the best of both worlds!</p>
<ul>
<li>Day camp Monday &amp; Tuesday, stay overnight Wednesday &amp; Thursday, go home Friday.</li>
<li>Grades 4-8</li>
<li>Price includes lunch for day camp, one daily snack, applicable meals for overnight camp, and before &amp; after care for day camp.</li>
</ul>
 				</span>
 			</span>
 			<span class="card-meta">
 				See Dates &gt;
 			</span>
 		</a>

	      <a class="card" href="#fullweekcamp">
 			<span class="card-header" style="background-image: url('https://campmanitou.mb.ca/wp-content/uploads/2016/01/bannockmaking.jpg');">

 			</span>
 			<span class="card-summary">
 				<span class="card-title">
 					<h3>Full Week Overnight Camp</h3>
 					<span></span>
 				</span>
 				
 				<span class="card-summary-text">
 					<p>Stay overnight Monday to Friday to get the full camp experience!</p>
<ul>
<li>Monday-Friday</li>
<li>Grades 4-8</li>
<li>NEW! 2 weeks to choose from!</li>
</ul>
 				</span>
 			</span>
 			<span class="card-meta">
 				See Dates &gt;
 			</span>
 		</a>

	      <a class="card" href="#prospectsweek">
 			<span class="card-header" style="background-image: url('https://campmanitou.mb.ca/wp-content/uploads/2019/12/prospects-week.jpg');">

 			</span>
 			<span class="card-summary">
 				<span class="card-title">
 					<h3>Manitou Prospects Week </h3>
 					<span></span>
 				</span>
 				
 				<span class="card-summary-text">
 					<p>Moving from camper to counsellor!</p>
<ul>
<li>Day camp Monday-Friday</li>
<li>Grades 8-10</li>
<li>Price includes lunch and one daily snack</li>
<li>Camp week includes a combination of leadership training, volunteer opportunities, and traditional camp activities.</li>
</ul>
 				</span>
 			</span>
 			<span class="card-meta">
 				See Dates &gt;
 			</span>
 		</a>

											
 	</div> <!--cards-->
</div> <!--cards container-->
	                            
</div>
</div>
	  
      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-default" id="buttons">
            <div class="panel-heading">Buttons
            </div>
            <div class="panel-body">
	         
	        <p>You can replicate the following buttons by applying different classes to <code>&lt;a></code> links. Always make sure to include the default btn class as well.   
            <p>
            
                 <a type="button" class="btn">Red/Default Button</a>
                <pre><code>&lt;a type="button" class=" <b>btn</b>">Red Button&lt;/a></code></pre>
                
                 <a type="button" class="btn btn-full">Full Width Red Button</a>
                <pre><code>&lt;a type="button" class="<b>btn</b>  <b>btn-full</b>">Full Width Red Button&lt;/a></code></pre>
                  
                  <a type="button" class="btn blue">Blue Button</a>
                <pre><code>&lt;a type="button" class="<b>btn</b> <b>blue</b>">Blue Button&lt;/a></code></pre>
                
                 <a type="button" class="btn blue btn-full">Full Width Blue Button</a>
                <pre><code>&lt;a type="button" class="<B>btn</B> <B>blue</B> <b>btn-full</b>">Full Width Blue Button&lt;/a></code></pre>
                
                <a type="button" class="btn btn-sm">Small Button</a> <a type="button" class="btn blue btn-sm">Small Button</a>
                <pre><code>&lt;a type="button" class="<b>btn</b> <b>btn-sm</b>">Small Button&lt;/a></code></pre>
                
              <a type="button" class="button-outline">Outline Button</a>
                <pre><code>&lt;a type="button" class="button-outline">Outline Button&lt;/a>
</code></pre>
              <a type="button" class="red-button">Red Full Width</a>
                <pre><code>&lt;a type="button" class="red-button">Red Full Width&lt;/a></code></pre>
          </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="panel panel-default" id="images">
            <div class="panel-heading">Images</div>
	            <div class="panel-body">
	            	<p><img src="http://placehold.it/120x100" class="img-rounded">
		              <img src="http://placehold.it/120x100" class="img-circle">
		              <img src="http://placehold.it/120x100" class="img-thumbnail"></p>
	            </div>
          </div>
        </div>
         <div class="col-lg-6">
          <div class="panel panel-default" id="images">
            <div class="panel-heading">Icons</div>

			<span class="icon icon-download"></span>
			<span class="icon icon-facebook-square"></span>                
			<span class="icon icon-twitter"></span>               
			<span class="icon icon-instagram"></span>
			<span class="d-icon icon-print"></span>
			<span class="d-icon icon-map-marker"></span>
			<span class="d-icon icon-phone"></span>
			<span class="d-icon icon-envelope"></span>
			<span class="pm-icon icon-plus"></span>
			<span class="pm-icon icon-minus"></span>
			


<pre  data-lang='html'>
&lt;span class="icon icon-download">&lt;/span>
&lt;span class="icon icon-facebook-square">&lt;/span>                
&lt;span class="icon icon-twitter">&lt;/span>               
&lt;span class="icon icon-instagram">&lt;/span>
&lt;span class="d-icon icon-print">&lt;/span>
&lt;span class="d-icon icon-map-marker">&lt;/span>
&lt;span class="d-icon icon-phone">&lt;/span>
&lt;span class="d-icon icon-envelope">&lt;/span>
&lt;span class="pm-icon icon-plus">&lt;/span>
&lt;span class="pm-icon icon-minus">&lt;/span>
</pre>	
        	            </div>
          </div>
        </div>
      
          
          
      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-default" id="pagination">
            <div class="panel-heading">Pagination
            </div>
            <div class="panel-body">
            	<div class="pagination">
						<span aria-current="page" class="page-numbers current">1</span>
					<a class="page-numbers" href="#">2</a>
					<a class="page-numbers" href="#">3</a>
					<a class="next page-numbers" href="#">Next »</a></div>
             </div>
        </div>
          
        </div>
        <div class="col-lg-6">
         
       
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-default" id="progress">
            <div class="panel-heading">Responsive Videos
            </div>
            <div class="panel-body">
            	<div class="video-wrapper"><iframe src="//www.youtube.com/embed/evXkWcAFAZM" width="100%" height="450" allowfullscreen="allowfullscreen"></iframe></div>            	
				<pre><code>&lt;div class="video-wrapper">&lt;iframe src="//www.youtube.com/embed/evXkWcAFAZM" width="100%" height="450" allowfullscreen="allowfullscreen">&lt;/iframe>&lt;/div></code></pre>           	
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="panel panel-default" id="media-object">
            <div class="panel-heading">Media Object
            </div>
            <div class="panel-body">
            <p></p>
            <div class="media">
              <a class="pull-left" href="#">    <img class="media-object" src="https://app.divshot.com/img/placeholder-64x64.gif">  </a>
              <div class="media-body">
                <h4 class="media-heading">Media heading</h4>
                <p>This is the content for your media.</p>
                <div class="media">
                  <a class="pull-left" href="#">    <img class="media-object" src="https://app.divshot.com/img/placeholder-64x64.gif">  </a>
                  <div class="media-body">
                    <h4 class="media-heading">Media heading</h4>
                    <p>This is the content for your media.</p>
                  </div>
                </div>
              </div>
            </div>
            </div>
          </div>
        </div>
      </div
      >
      <div class="row">
             
        <div class="col-lg-4">
        
            
        <h4>List group item heading</h4>          
        <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>                   
             <h4>List group item heading</h4>         
              <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>               
	              
	          <h4>List group item heading</h4>          
	          <p class="list-group-item-text">Donec id elit non mi porta gravida at eget metus. Maecenas sed diam eget risus varius blandit.</p>   
  
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          <div class="panel panel-primary" id="panels">
            <div class="panel-heading">This is a header
            </div>
            <p class="panel-body">This is a panel</p>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="panel panel-success">
            <div class="panel-heading">This is a header
            </div>
            <div class="panel-body">This is a panel</div>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="panel panel-danger">
            <div class="panel-heading">This is a header
            </div>
            <div class="panel-body">This is a panel</div>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="panel panel-warning">
            <div class="panel-heading">This is a header
            </div>
            <div class="panel-body">This is a panel</div>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-3">
          <div class="panel panel-info">
            <div class="panel-heading">This is a header
            </div>
            <p class="panel-body">This is a panel</p>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="panel panel-default">
            <div class="panel-heading">This is a header
            </div>
            <div class="panel-body">This is a panel</div>
            <ul class="list-group list-group-flush">
              <li class="list-group-item">First Item</li>
              <li class="list-group-item">Second Item</li>
              <li class="list-group-item">Third Item</li>
            </ul>
            <div class="panel-footer">This is a footer
            </div>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="well" id="wells">Default Well
          </div>
          <div class="well well-small">Small Well
          </div>
        </div>
        <div class="col-lg-3">
          <div class="well well-large">Large Padding Well
          </div>
        </div>
      </div>
    </div>
        <hr />
        
	<div class="panel panel-default" id="progress">
            <div class="panel-heading">Page Templates</div>
            <div class="panel-body">
  <div class="row">
  <div class="col-lg-4">
 	page-activities.php - Activities Tabs
	page-contentbox-images.php - Amenities 
	page-directions.php 
	page-faq.php - FAQ Tabs
	page-full-content.php
	page-manitou-blog.php
	page-map.php - Map 
	page-side-images.php - Default Page with Side images
	page-staff.php - Staff Content Boxes
	page-styleguide.php
	page-testimonials.php - Testimonial Tabs 
	page-upcoming-events.php - News
	page.php

  </div>
</div>
            </div></div>

	<div class="panel panel-default" id="progress">
            <div class="panel-heading">Layout Options</div>
            <div class="panel-body">
  <div class="row">
  <div class="col-lg-4">
    <h2>Heading</h2>
    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
    <p><a class="btn red" href="#">View details »</a></p>
  </div>
  <div class="col-lg-4">
    <h2>Heading</h2>
    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
    <p><a class="btn red" href="#">View details »</a></p>
 </div>
  <div class="col-lg-4">
    <h2>Heading</h2>
    <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
    <p><a class="btn red" href="#">View details »</a></p>
  </div>
</div>
            </div></div>
  
  <hr />
  
  <div class="row">
        <div class="col-lg-4">
          <div class="thumbnail">
            <img data-src="http://placehold.it/300x200" alt="300x200" src="http://placehold.it/300x200" style="width: 300px; height: 200px;" class="img-thumbnail">
            <div class="caption">
              <h3>Thumbnail label</h3>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a href="#" class="btn btn-sm blue">Button</a> <a href="#" class="btn btn-sm">Button</a></p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="thumbnail">
             <img data-src="http://placehold.it/300x200" alt="300x200" src="http://placehold.it/300x200" style="width: 300px; height: 200px;" class="img-thumbnail">
            <div class="caption">
              <h3>Thumbnail label</h3>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a href="#" class="btn btn-sm blue">Button</a> <a href="#" class="btn btn-sm">Button</a></p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="thumbnail">
             <img data-src="http://placehold.it/300x200" alt="300x200" src="http://placehold.it/300x200" style="width: 300px; height: 200px;" class="img-thumbnail">
            <div class="caption">
              <h3>Thumbnail label</h3>
              <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
              <p><a href="#" class="btn btn-sm blue">Button</a> <a href="#" class="btn btn-sm">Button</a></p>
            </div>
          </div>
        </div>
      </div>
         
          
                
  
          <hr />
         
          <hr />
          
          
<div class="panel-group" id="accordion">
  <div class="panel">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Collapsible Group Item #1
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
          Collapsible Group Item #2
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
  <div class="panel">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
          Collapsible Group Item #3
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse">
      <div class="panel-body">
        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
      </div>
    </div>
  </div>
</div>

     	                  
	                 <?php  edit_post_link(); ?>

				</div> <!-- row -->
			</div> <!-- right column -->
		</div> <!-- cols 9-->
	</div> <!--row-->
</div> <!--container -->
<?php get_footer(); ?>