<ul class="list_social_share">
	<li><a href="https://www.facebook.com/TNYFDN" aria-label="Like us on Facebook" target="_blank"><span class="icon-reversed icon-facebook-square"></span><div>Like Us</div></a></li>
	<li><a href="https://twitter.com/TNYouthFDN" aria-label="Follow us on Twitter" target="_blank"><span class="icon-reversed icon-twitter"></span><div>Follow Us</div></a></li>
	<li><a href="https://www.instagram.com/tnyouthfdn/" aria-label="Follow Us on Instagram" target="_blank"><span class="icon-reversed icon-instagram"></span><div>Follow Us</div></a></li>
</ul>
<!-- footer -->				
<footer class="footer" role="contentinfo">
	<div class="container footer-wrapper" style="color: #fff;">	
		<div class="row">
			
			<div class="col-md-2  col-xs-12 footer-logo no-gutter-right no-gutter-mobile">		
				<a href="//www.truenorthyouthfoundation.com/"  target="_blank"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/TNYF-horz-logo.png" alt="True North Foundation" /></a>
			</div>
			<div class="col-md-10  col-xs-12 footer-menu-area">
				<?php wp_nav_menu( array(
				'container_class' => 'extra-menu',
					'theme_location' => 'extra-menu'
					) ); ?>	 								
			
			</div>	
		</div> <!--/row-->
	</div> <!--/footer-wrapper-->	
</footer>
<!-- /footer -->

<div class="footer-btm">
	<a href="//www.tnse.com/" target="_blank"><img src="<?php echo get_stylesheet_directory_uri();?>/images/truenorth-logo.png" alt="True North Sports + Entertainment" width="100px" /></a>
	<p class="copyright"><a href="https://www.tnse.com/privacy-policy/" target="_blank">Privacy Policy</a>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; &copy; <?php echo date('Y'); ?> True North Sports + Entertainment <br> Some icon designs courtesy of flaticon.com</p>

</div>

<!-- secondary footer-->	
		
<!--menu sidebar overlay-->
<div class="overlay" data-sidebar-overlay></div>

<?php wp_footer(); ?>
		
		  <script>
  (function(d) {
    var config = {
      kitId: 'oao2awi',
      scriptTimeout: 3000,
      async: true
    },
    h=d.documentElement,t=setTimeout(function(){h.className=h.className.replace(/\bwf-loading\b/g,"")+" wf-inactive";},config.scriptTimeout),tk=d.createElement("script"),f=false,s=d.getElementsByTagName("script")[0],a;h.className+=" wf-loading";tk.src='https://use.typekit.net/'+config.kitId+'.js';tk.async=true;tk.onload=tk.onreadystatechange=function(){a=this.readyState;if(f||a&&a!="complete"&&a!="loaded")return;f=true;clearTimeout(t);try{Typekit.load(config)}catch(e){}};s.parentNode.insertBefore(tk,s)
  })(document);
</script>
		  
		

	</body>
</html>