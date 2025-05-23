<?php 
	/*
	Template Name: Map 1
	*/
get_header(); ?>

<div class="mypopup">
<div class="mypopup-overlay"></div>
	<div class="mypopup-wrapper">
		<button class="mypopup-close">x</button>
		<div class="mypopup-content box shadow">
		<h1>Welcome to the Camp Manitou Virtual Tour!</h1>
	   <p>Discover Camp Manitou with our Virtual Map! Click on an icon to find out more information about an activity or amenity. To move around the map, simply click and drag. There are controls in the upper left corner of the map for zoom and full screen options. <em>*The virtual map works best on desktop</em> </p>
	   <a href="https://campmanitou.mb.ca/wp-content/uploads/2023/06/2223TNYF011-10_Camp-Manitou_Map_Update_v1.pdf" class="button" style="padding: 5px 10px;" target="_blank"><strong>Download PDF of Map</strong></a>
		</div> <!--pop content-->
</div><!--popup wrapper-->
</div><!--popup-->

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
		
		<div class="col-md-3 col-sm-4">
			<?php get_sidebar(); ?>
		</div>
			
		<div class="col-md-9 col-sm-8 col-xs-12 no-gutter-mobile">
			<div id="map"></div>

			<div class="map-blurb"> 
				<h1>Welcome to the Camp Manitou Virtual Tour!</h1>
				<p>Discover Camp Manitou with our Virtual Map! Click on an icon to find out more information about an activity or amenity. To move around the map, simply click and drag. There are controls in the upper left corner of the map for zoom and full screen options. <em>*The virtual map works best on desktop</em> <br />
				<br />Visit the <a href="https://campmanitou.mb.ca/summer-camp/activities/" target="_blank"><strong>Activities</strong></a> or <a href="https://campmanitou.mb.ca/school-groups/amenities" target="_blank"><strong>Amenities</strong></a> pages to see the full descriptions of each item.</p>
				<a href="https://campmanitou.mb.ca/wp-content/uploads/2023/06/2223TNYF011-10_Camp-Manitou_Map_Update_v1.pdf" class="button" style="padding: 5px 10px;" target="_blank"><strong>Download PDF of Map</strong></a>
			</div>
			
			</div> <!-- col 9 -->
	</div><!--row-->
</div> <!--/container-->
<?php get_footer(); ?>

<script>
	

	
	var map = L.map('map', {
			crs: L.CRS.Simple,
			center: [51.505, -0.09],
			maxZoom: 2,
			minZoom: 1,
			attributionControl: false,
			fullscreenControl: true,
			fullscreenControlOptions: { // optional
				title:"Show me the fullscreen !",
				titleCancel:"Exit fullscreen mode"
			}
		});
		
		// detect fullscreen toggling
		map.on('enterFullscreen', function(){
			if(window.console) window.console.log('enterFullscreen');
		});
		map.on('exitFullscreen', function(){
			if(window.console) window.console.log('exitFullscreen');
		});
		
		var yx = L.latLng;

		var xy = function(x, y) {
			if (L.Util.isArray(x)) {    // When doing xy([x, y]);
				return yx(x[1], x[0]);
			}
			return yx(y, x);  // When doing xy(x, y);
		};

		map.setMaxBounds(new L.LatLngBounds([0,423], [670,0]));
	
		var imageUrl = 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/background.jpg'
		var imageBounds = [[670,0], [0, 423]];
		L.imageOverlay(imageUrl, imageBounds).addTo(map);
				
		var archery      = xy(142, 46);
		var naturehike      = xy(115, 95);
		var campfirepit1      = xy(153, 119);
		var totempole     = xy(140, 132);
		var lowropes    = xy( 235, 141);	
		var orienteering      = xy(161, 167);
		var zipline    = xy( 253, 178);		
		var climbingwall      = xy(256, 214);
		var craftcabin      = xy(222, 252);
		var gym      = xy(347, 250);
		var basketball      = xy(307, 258);
		var fishing    = xy(237, 281);
		var biking      = xy(305, 523);
		var campfirepit2      = xy(320, 416);
// 		var lodge      = = xy(323, 291);
		var sheltersetup      = xy(257, 244);
		var skating      = xy(352, 330);
		var pool      = xy(301, 310);
		var playstructure      = xy(285, 316);
		var teambuilding      = xy(342, 212);
		var tobogganing      = xy(270, 284);
		var naturehike2      = xy(241, 624);
		var mbiking      = xy(347, 627);
		var mbiking2      = xy(240, 545);
		var ccs      = xy(208, 227);
		var bm      = xy(292, 238);
		var bvb      = xy(285, 553);
		var bh      = xy(307, 553);
		var kay      = xy(265, 580);
		var can      = xy(315, 580);
		var ph      = xy(290, 580);
		var pt      = xy(334, 525);
		var sr      = xy(357, 354);
		var tpc      = xy(323, 291);
		var wc      = xy(353, 499);
		
		

		var LeafletIcon = L.Icon.extend({
		options: {
		iconSize: [52,52],
		popupAnchor:  [0, -25],
		className: 'map-icon'
		  }
		});

		var archeryIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/archery.svg'});
		var basketballIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/sports-and-games.svg'});
		var bikingIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/biking.svg'});
		var climbingwallIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/climbing-wall.svg'});
		var craftcabinIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/craft-cabin.svg'});
		var campfirepit1Icon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/fire-building.svg'});
		var campfirepit2Icon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/fire-building.svg'});
		var fishingIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/fishing.svg'});
		var gymIcon = new LeafletIcon({iconSize: [66,66], iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/gym.svg'});
		var lodgeIcon = new LeafletIcon({iconSize: [66,66], iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/lodge.svg'});
		var lowropesIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/low-ropes.svg'});	
		var natureIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/nature-hike.svg'});
		var orienteeringIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/orienteering.svg'});
		var sheltersetupIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/shelter-setup.svg'});
		var skatingIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/skating.svg'});
		var poolIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/swimming.svg'});
		var playstructureIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/play-structure.svg'});
		var teambuildingIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/team-building.svg'});
		var tobogganingIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/tobogganing.svg'});
		var totempoleIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/totem-pole.svg'});
		var ziplineIcon = new LeafletIcon({iconUrl: '<?php echo get_stylesheet_directory_uri(); ?>/images/map/zipline.svg'});
		var mbikingIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/mbiking.svg'});
		var ccsIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/ccs.svg'});
	var bmIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/bannock-making.svg'});
	var bvbIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/beach-vb.svg'});
	var bhIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/boathouse.svg'});
	var cIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/kayaking.svg'});
	var kIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/canoeing.svg'});
	var phIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/pondhockey.svg'});
	var ptIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/pump-track.svg'});
	var srIcon = new LeafletIcon({iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/skating-rink.svg'});
	var tpcIcon = new LeafletIcon({iconSize: [66,66], iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/travis-place-centre.svg'});
	var wcIcon = new LeafletIcon({iconSize: [66,66], iconUrl: 'https://campmanitou.mb.ca/wp-content/themes/manitou/images/map/welcome-centre.svg'});
	
	
		
				L.marker(archery, {icon: archeryIcon, alt: 'archery'}).addTo(map).bindPopup('<h2>Archery</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/12/schoolgroups-main-photo-01.jpg"  alt="Archery" /> <p>Can you hit the bullseye? Archery is a fun and safe activity for all ages! Come channel your inner Robin Hood at our outdoor wilderness archery range.</p> ').bindLabel('Archery', { offset: [-20, 35] });	
		
		L.marker(basketball, {icon: basketballIcon, alt: 'basketball'}).addTo(map).bindPopup('<h2>Sports and Games</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-Sports-Games.jpg"  alt="Basketball" /> <p>At Camp Manitou we have so many fun games that you can play! Come join us for floor hockey, basketball, baseball, lacrosse, Frisbee, disc golf, soccer, dodgeball, and so much more! </p> ').bindLabel('Basketball', { offset: [-15,30] });
		
		L.marker(biking, {icon: bikingIcon, alt: 'biking'}).addTo(map).bindPopup('<h2>Biking</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-Biking.jpg"  alt="Biking" /> <p>What could be more fun than biking through the forest covered paths of Camp Manitou?</p> ').bindLabel('Biking', { offset: [25,0] });
	
		L.marker(mbiking, {icon: mbikingIcon, alt: 'mbiking'}).addTo(map).bindPopup('<h2>Mountain Biking</h2>').bindLabel('Mountain Biking', { offset: [25,0] });
	L.marker(mbiking2, {icon: mbikingIcon, alt: 'mbiking'}).addTo(map).bindPopup('<h2>Mountain Biking</h2>').bindLabel('Mountain Biking', { offset: [25,0] });
	
		L.marker(ccs, {icon: ccsIcon, alt: 'ccs'}).addTo(map).bindPopup('<h2>Cross-Country Skiing</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-Biking.jpg"  alt="Biking" /> <p>What could be more fun than biking through the forest covered paths of Camp Manitou?</p> ').bindLabel('Cross-Country Skiing', { offset: [25,0] });
		
		L.marker(campfirepit1, {icon: campfirepit1Icon, alt: 'Campfire Pit'}).addTo(map).bindPopup('<h2>Campfire Pit</h2><img src="http://campmanitou.mb.ca/wp-content/uploads/2016/04/campfire.jpg" alt="Fire Building" /><p>Learn this vital camping skill at Camp Manitou! Our trained staff will lead you through the safety of starting and maintaining a fire and how to make sure that when you pack up you ‘leave no trace’ behind.</p> ').bindLabel('Campfire Pit', { offset: [-35,27] });
		
		L.marker(campfirepit2, {icon: campfirepit2Icon, alt: 'Campfire Pit'}).addTo(map).bindPopup('<h2>Campfire Pit</h2><img src="http://campmanitou.mb.ca/wp-content/uploads/2016/04/campfire.jpg" alt="Fire Building" /><p>Learn this vital camping skill at Camp Manitou! Our trained staff will lead you through the safety of starting and maintaining a fire and how to make sure that when you pack up you ‘leave no trace’ behind.</p> ').bindLabel('Campfire Pit', { offset: [-35,35] });
		
		L.marker(climbingwall, {icon: climbingwallIcon, alt: 'climbing wall'}).addTo(map).bindPopup('<h2>Climbing Wall</h2><img src="http://campmanitou.mb.ca/wp-content/uploads/2017/01/climbingwall-thumbnail.jpg" alt="Climbing Wall" /> <p>One of our newest and most exciting adventure activities at Camp Manitou! Come test your skills at our 25 foot, 6 sided climbing wall. Can you make it to the top?</p>').bindLabel('Climbing Wall', { offset: [0,25] });
		
		L.marker(craftcabin, {icon: craftcabinIcon, alt: 'craft cabin'}).addTo(map).bindPopup('<h2>Craft Cabin</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-ArtsCrafts.jpg"  alt="Craft Cabin" /> <p>Nature based arts at Camp Manitou connect campers and students with the outdoors in a creative and decorative way. Create your own take home design or craft and have your own souvenir of your time at camp!</p> ').bindLabel('Craft Cabin', { offset: [-68,10] });	

		L.marker(fishing, {icon: fishingIcon, alt: 'fishing'}).addTo(map).bindPopup('<h2>Fishing</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-Fishing.jpg"  alt="Fishing" /> <p>Come test your skills as a fisherman on the lakes of the Assiniboine River. Our fishing experts will have you catching a fish in no time! No experience needed!</p> ').bindLabel('Fishing', { offset: [-10,30] });
		
		L.marker(gym, {icon: gymIcon, alt: 'gymnasium'}).addTo(map).bindPopup('<h2>Gym</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2016/01/John-Bock.jpg"  alt="John Bock Friendship Centre" /> <p>The Friendship Centre is an ideal space for indoor games/activities, rainy day programming, classes/meetings and a variety of functions (such as receptions, family reunions, and weddings).</p> ').bindLabel('Gym', { offset: [35,-10] });
		
// 		L.marker(lodge, {icon: lodgeIcon, alt: 'lodge'}).addTo(map).bindPopup('<h2>Lodge</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/12/Lodge-1.jpg"  alt="Kinsmen Lodge" /> <p>The Kinsmen Lodge is a year round, wheelchair accessible facility with a fully-equipped commercial kitchen, dining hall, bedrooms furnished with bunk beds, and a cozy sitting area by a large fireplace. </p> ').bindLabel('Lodge', { offset: [35,-5] });
		
		L.marker(lowropes, {icon: lowropesIcon, alt: 'low ropes'}).addTo(map).bindPopup('<h2>Low Ropes</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2017/10/low-ropes.jpg" alt="Low Ropes" /><p></p>').bindLabel('Low Ropes', { offset: [20,10] });
		
		L.marker(naturehike, {icon: natureIcon, alt: 'nature hike'}).addTo(map).bindPopup('<h2>Nature Hike</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-Nature-Walk.jpg"  alt="Nature Hike" /> <p>Can you spot Edison the owl? Walk through over 2 miles of trails at Camp Manitou and see how many different plants and animals you can spot! All while learning about nature, history of the area and surprising facts!</p> ').bindLabel('Nature Hike', { offset: [-75,-30] });
	
		L.marker(naturehike2, {icon: natureIcon, alt: 'hiking'}).addTo(map).bindPopup('<h2>Hiking</h2>').bindLabel('Hiking', { offset: [-75,-30] });
		
		L.marker(orienteering, {icon: orienteeringIcon, alt: 'orienteering'}).addTo(map).bindPopup('<h2>Orienteering</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-Orienteering.jpg"  alt="Orienteering" /> <p>Do you know how to work a compass? Come on down to orienteering at Camp Manitou and we guarantee you will be an expert before you leave! Race through our orienteering course and see who will be the ultimate compass master.</p> ').bindLabel('Orienteering', { offset: [-110,-15] });
		
		L.marker(sheltersetup, {icon: sheltersetupIcon, alt: 'shelter setup'}).addTo(map).bindPopup('<h2>Shelter Setup</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2016/01/shelter-setup.jpg"  alt="Shelter Setup" /> <p>Tents are fun, but you can still enjoy camping without one. Camp Manitou staff will show you what you can use in nature to set up a shelter. And how to make your own tent out of only a rope and a tarp!</p> <p></p>').bindLabel('Shelter Setup', { offset: [25,-12] });
		
		L.marker(skating, {icon: skatingIcon, alt: 'skating'}).addTo(map).bindPopup('<h2>Skating Rink</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-Skating.jpg"  alt="Orienteering" /> <p>Outdoor skating is a winter staple in Canada. Go for a skate, grab a hockey stick, even play a little shinny. Getting chilly? Head into our heated dressing rooms to warm up!</p> ').bindLabel('Skating Rink', { offset: [28,5] });
		
		
		L.marker(pool, {icon: poolIcon, alt: 'swimming pool'}).addTo(map).bindPopup('<h2>Pool</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2015/11/Activities-Swimming.jpg"  alt="Swimming" /> <p>Come for a dip and cool off from the summer heat in our pool! Camp Manitou has an outdoor pool that is open during the summer months, subject to weather conditions. The pool is available from dawn to dusk according to Manitoba health regulations and Camp Manitou policies.</p> ').bindLabel('Swimming Pool', { offset: [-40,30] });
		
		L.marker(playstructure, {icon: playstructureIcon, alt: 'play structube'}).addTo(map).bindPopup('<h2>Play Structure</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2017/01/Play-Structure_IMG_9647_edit_smresized-1.jpg"  alt="Play Structure" /> <p> Our play structure is fully accessible and conveniently located right beside the pool and green space for free time play.</p> ').bindLabel('Play Structure', { offset: [-85,-20] });
		
		L.marker(teambuilding, {icon: teambuildingIcon, alt: 'teambuilding'}).addTo(map).bindPopup('<h2>Team Building</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2017/01/JK2_9636_Fotor_Fotor.jpg"  alt="Swimming" /> <p>Learn how to work together! At camp you can learn all about working in teams and helping each other out by playing lots of different fun activities and games. Let us show you how!</p> ').bindLabel('Team Building', { offset: [-30,30] });
		
		L.marker(tobogganing, {icon: tobogganingIcon, alt: 'tobogganing'}).addTo(map).bindPopup('<h2>Tobogganing Slide</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2016/01/tobogganing.jpg"  alt="Tobogganing" /> <p>We are super excited about our NEW toboggan hill. Will you come help us test it out?!</p><p> </p>').bindLabel('Tobogganing Slide', { offset: [25,-10] });
		
		L.marker(totempole, {icon: totempoleIcon, alt: 'totem pole'}).addTo(map).bindPopup('<h2>Totem Pole</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2016/04/Totem-Pole-248x165.jpeg" alt="Totem Pole" />').bindLabel('Totem Pole', { offset: [-75,-30] });
		
		L.marker(zipline, {icon: ziplineIcon, alt: 'zipline'}).addTo(map).bindPopup('<h2>Zipline</h2> <img src="http://campmanitou.mb.ca/wp-content/uploads/2017/01/zipline-thumbnail.jpg" alt="Zipline" /><p>Fly through the air on our NEW zipline! Do a trick or just sail like a bird, either way, you’re bound to have a blast!</p>').bindLabel('Zipline', { offset: [20,15] });
		
		L.marker(bm, {icon: bmIcon, alt: 'bannock'}).addTo(map).bindPopup('<h2>Bannock Making</h2>').bindLabel('Bannock Making', { offset: [20,15] });
		L.marker(bvb, {icon: bvbIcon, alt: 'beach volleyball'}).addTo(map).bindPopup('<h2>Beach Volleyball</h2>').bindLabel('Beach Volleyball', { offset: [20,15] });
		L.marker(bh, {icon: bhIcon, alt: 'boathouse'}).addTo(map).bindPopup('<h2>Boathouse</h2>').bindLabel('Boathouse', { offset: [20,15] });
		L.marker(can, {icon: cIcon, alt: 'canoeing'}).addTo(map).bindPopup('<h2>Canoeing</h2>').bindLabel('Canoeing', { offset: [20,15] });
		L.marker(kay, {icon: kIcon, alt: 'kayaking'}).addTo(map).bindPopup('<h2>Kayaking</h2> ').bindLabel('Kayaking', { offset: [20,15] });
		L.marker(ph, {icon: phIcon, alt: 'pond hockey'}).addTo(map).bindPopup('<h2>Pond Hockey</h2> ').bindLabel('Pond Hockey', { offset: [20,15] });
	L.marker(pt, {icon: ptIcon, alt: 'pump track'}).addTo(map).bindPopup('<h2>Pump Track</h2> ').bindLabel('Pump Track', { offset: [20,15] });
		L.marker(sr, {icon: srIcon, alt: 'broomball'}).addTo(map).bindPopup('<h2>Broom Ball</h2> ').bindLabel('Broom Ball', { offset: [20,15] });
		L.marker(tpc, {icon: tpcIcon, alt: 'travis place centre'}).addTo(map).bindPopup('<h2>Travis Place Centre</h2>').bindLabel('Travis Place Centre', { offset: [20,15] });
	L.marker(wc, {icon: wcIcon, alt: 'welcome centre'}).addTo(map).bindPopup('<h2>Welcome Centre</h2>').bindLabel('Welcome Centre', { offset: [20,15] });
	
	
	
	
		map.on('popupopen', function(e) {
			var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
			px.y -= e.popup._container.clientHeight/2 // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
			map.panTo(map.unproject(px),{animate: true})
			map.scrollWheelZoom.disable(); // pan to new center
		});
		
		map.on('popupclose', function(e) {
			var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
			px.y -= e.popup._container.clientHeight/2 // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
			map.panTo(map.unproject(px),{animate: true})
			map.scrollWheelZoom.enable(); // pan to new center
		});
			
		map.setView(xy(130, 285), 1);

	
</script>