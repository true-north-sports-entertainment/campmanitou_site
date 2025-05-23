<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
	<head>
		<meta charset="<?php bloginfo('charset'); ?>">
		<title><?php wp_title(''); ?></title>
		<link href="//www.google-analytics.com" rel="dns-prefetch">
        <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/favicon.ico" rel="shortcut icon">
        <link href="<?php echo get_stylesheet_directory_uri(); ?>/images/touch.png" rel="apple-touch-icon-precomposed">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">	
		<meta name="google-site-verification" content="-ClzAxSnEZ1FQnOEJ94yLDzncVXo40Bid_3O1zHd4T0" />	

		<?php wp_head(); ?>
		
		<script>document.documentElement.className += ' wf-loading';</script>

        <script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
		
		  ga('create', 'UA-72726536-1', 'auto');
		  ga('send', 'pageview');
		
		</script>
		
		<script type="text/javascript">
    var _elqQ = _elqQ || [];
    _elqQ.push(['elqSetSiteId', '1885598250']);
    _elqQ.push(['elqTrackPageView']);
    
    (function () {
        function async_load() {
            var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;
            s.src = '//img02.en25.com/i/elqCfg.min.js';
            var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
        }
        if (window.addEventListener) window.addEventListener('DOMContentLoaded', async_load, false);
        else if (window.attachEvent) window.attachEvent('onload', async_load); 
    })();
</script>

<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-TCZVBTST');</script>
<!-- End Google Tag Manager -->


	</head>
	
<!-- SIDEBAR MENU---->
<aside data-sidebar>
   	<div class="mobile-sidebar">
    <?php 
		wp_nav_menu( array(
		'menu' => 'sidebar-menu',
		'theme_location' => 'sidebar-menu',
		'depth' => 2,
		'container' => 'div',
		 'container_class'   => 'collapse navbar-collapse',
		'container_id'      => 'menu-mobile_menu bs-example-navbar-collapse-1',
		'menu_class' => 'menu navbar nav',
		'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
		'walker'            => new wp_bootstrap_navwalker())
			 );										  
		?>    
    </div>
</aside>
	
<body <?php body_class(); ?>>
	<!-- Google Tag Manager (noscript) -->
	<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TCZVBTST"
	height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
	<!-- End Google Tag Manager (noscript) -->
	<header class="outer-header container-clearfix">	


		<div class="container inner-header no-gutter">
			<div class="logo pull-left">
				<a href="<?php echo home_url(); ?>">
					<img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" alt="Logo" class="logo-img">
				</a>
			</div>	
			<nav class="navbar" role="navigation">
				<div class="desktop-navigation">
					<?php
					wp_nav_menu( array(
							'theme_location' => 'header-menu',
							'menu_class'     => 'main-menu',
							'menu_id' => 'accessibleNav'
						) );
					?>
					<!--
					<div class="countdown">   
						<?php echo do_shortcode('[waiting name="Camp Date"]'); ?> 
							<div class="count-label"> 
								<span class="count1">Days</span> 
								<span class="count2">Until</span> 
								<span class="count3">Camp!</span>
							</div>
				    </div>
					-->
				   <!-- Activated when countdown is over, deactivate countdown when weather widget is active -->
				   <div class="weather">
				    	<?php echo do_shortcode('[BetterWeather-inline location="49.8687,-97.3420" show_date="on" inline_size="medium" icons_type="animated" font_color="#fff" unit="C" show_unit="on"  /]'); ?>
				    </div>
			    </div> <!-/desktop nav->
			</nav> <!--/nav-->
			<a aria-label="menu" class="mobile-button pull-right" href="#" data-sidebar-button><img src="<?php bloginfo('url'); ?>/wp-content/themes/manitou/images/menu_icon.png" alt="menu-icon" /></a>
		</div> <!-/inner header->
	</header> <!--/header-->
<div class="mobile-menu-push container-clearfix"></div>