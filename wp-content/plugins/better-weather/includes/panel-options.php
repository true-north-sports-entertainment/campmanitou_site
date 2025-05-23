<?php


// Admin panel options
add_filter( 'better-framework/panel/options' , 'better_weather_setup_option_panel' );


if( ! function_exists( 'better_weather_setup_option_panel' ) ){
	/**
	 * Setup setting panel for BetterWeather
	 *
	 * @param $options
	 * @return array
	 */
	function better_weather_setup_option_panel( $options ){

		/**
		 * 5.1. => General Options
		 */
		$field[] = array(
			'name' => __( 'API Key', 'better-studio' ),
			'id' => 'bw_settings',
			'type' => 'tab',
			'icon' => 'bsai-key'
		);


		$field['api_key'] = array(
			'name'          =>  __( 'API Key', 'better-studio' ),
			'id'            =>  'api_key',
			'desc'          => __( 'Enter your own API Key for Forecast.io' , 'better-weather' ) ,
			'std'           =>  '',
			'type'          =>  'text',
		);

		$field[] = array(
			'name'          =>  __( 'How to get your own API key!?', 'better-studio' ),
			'id'            =>  'twitter-help',
			'type'          =>  'info',
			'std'           =>  '<p>' . __('Better Weather uses weather API of <a target="_blank" href="http://forecast.io/">Forecast.io</a>. For showing forecast you should get a free API key with a simple sign up to the site.', 'better-studio' ) .

			                    '</p><ol><li>' .  __( 'Go to <a href="http://goo.gl/d1d6Ji" target="_blank">https://developer.forecast.io/register</a> and Sing up', 'better-studio' ) . '<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() .'img/help-singup-page.png"><br></li>
    <li>After you can see your API Key in bottom of page.<br><br><img class="aligncenter" src="' . Better_Weather::dir_url() .'img/help-singup-page-api.png"><br></li>
    <li>Copy "API Key" and paste that in upper input box.</li>
  </ol>

',
			'state'         =>  'open',
			'info-type'     =>  'help',
			'section_class' =>  'widefat',
		);


		/**
		 * => Style
		 */
		$field[] = array(
			'name' => __( 'Style', 'better-studio'),
			'id' => 'style',
			'type' => 'tab',
			'icon' => 'bsai-paint',
			'badge' => array(
				'text'  =>  __( 'New', 'better-studio' ),
				'color' => '#F47878'
			)
		);

		$field[] = array(
			'name'          =>  __( 'How to customize forecasts style!?', 'better-studio' ),
			'id'            =>  'style-help',
			'type'          =>  'info',
			'std'           =>  '<p>' . __( 'You can customize background image and color of all forecasts and also each of them separately.', 'better-studio' ) .

			                    '</p><ul><li><strong>' .  __( 'Change All of forecasts:', 'better-studio' ) . '</strong>
    ' .  __( 'Use options inside following <strong>All Forecasts Style</strong> option group.', 'better-studio' ) . '</li>

    <li><strong>' .  __( 'Customize Each Forecast Style:', 'better-studio' ) . '</strong>
    ' .  __( 'Use options inside each forecast option group.', 'better-studio' ) . '</li>
  </ul>

',
			'state'         =>  'open',
			'info-type'     =>  'help',
			'section_class' =>  'widefat',
		);




		/**
		 * => Style -> Clear Day
		 */
		$field[] = array(
			'name'  =>  __( 'All Forecasts Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_all_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_all_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>All Forecasts</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-clear-day',
						'body .better-weather.with-natural-background.state-clear-night',
						'body .better-weather.with-natural-background.state-rain',
						'body .better-weather.with-natural-background.state-snow',
						'body .better-weather.with-natural-background.state-sleet',
						'body .better-weather.with-natural-background.state-wind',
						'body .better-weather.with-natural-background.state-fog',
						'body .better-weather.with-natural-background.state-thunderstorm',
						'body .better-weather.with-natural-background.state-cloudy',
						'body .better-weather.with-natural-background.state-partly-cloudy-day',
						'body .better-weather.with-natural-background.state-partly-cloudy-night',
						'body .better-weather.with-natural-background.state-sunrise',
						'body .better-weather.with-natural-background.state-sunset',
						'body .better-weather.with-natural-background.state-sunset[max-width~="400px"]'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image'
				)
			)
		);
		$field['style_all_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_all_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>All Forecasts</strong> background color.', 'better-studio' ),
			'std'           =>  '',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-clear-day',
						'body .better-weather.with-natural-background.state-clear-night',
						'body .better-weather.with-natural-background.state-rain',
						'body .better-weather.with-natural-background.state-snow',
						'body .better-weather.with-natural-background.state-sleet',
						'body .better-weather.with-natural-background.state-wind',
						'body .better-weather.with-natural-background.state-fog',
						'body .better-weather.with-natural-background.state-thunderstorm',
						'body .better-weather.with-natural-background.state-cloudy',
						'body .better-weather.with-natural-background.state-partly-cloudy-day',
						'body .better-weather.with-natural-background.state-partly-cloudy-night',
						'body .better-weather.with-natural-background.state-sunrise',
						'body .better-weather.with-natural-background.state-sunset',
						'body .better-weather.with-natural-background.state-sunset[max-width~="400px"]'
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Clear Day
		 */
		$field[] = array(
			'name'  =>  __( 'Clear Day Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_clear_day_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_clear_day_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Clear Day</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-clear-day'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image'
				)
			)
		);
		$field['style_clear_day_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_clear_day_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Clear Day</strong> background color.', 'better-studio' ),
			'std'           =>  '#599ad0',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-clear-day',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Clear Night
		 */
		$field[] = array(
			'name'  =>  __( 'Clear Night Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_clear_night_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_clear_night_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Clear Night</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-clear-night'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image'
				)
			)
		);
		$field['style_clear_night_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_clear_night_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Clear Night</strong> background color.', 'better-studio' ),
			'std'           =>  '#252a26',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-clear-night',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Rain
		 */
		$field[] = array(
			'name'  =>  __( 'Rain Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_rain_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_rain_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Rain</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-rain'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image'
				)
			)
		);
		$field['style_rain_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_rain_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Rain</strong> background color.', 'better-studio' ),
			'std'           =>  '#3b4963',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-rain',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Snow
		 */
		$field[] = array(
			'name'  =>  __( 'Snow Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_snow_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_snow_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Snow</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-snow'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image'
				)
			)
		);
		$field['style_snow_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_snow_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Snow</strong> background color.', 'better-studio' ),
			'std'           =>  '#607592',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-snow',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Cloudy
		 */
		$field[] = array(
			'name'  =>  __( 'Cloudy Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_cloudy_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_cloudy_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Cloudy</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-cloudy'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image',
					'after' => '
					body .better-weather.with-natural-background.state-cloudy.style-modern[max-width~="170px"],
					body .better-weather.with-natural-background.state-cloudy.style-normal[max-width~="170px"],
					body .better-weather.with-natural-background.state-cloudy.style-normal[max-width~="300px"],
					body .better-weather.with-natural-background.state-cloudy.style-modern[max-width~="300px"],
					body .better-weather.with-natural-background.state-cloudy.style-normal[max-width~="400px"],
					body .better-weather.with-natural-background.state-cloudy.style-modern[max-width~="400px"],
					body .better-weather.with-natural-background.state-cloudy.style-normal[max-width~="400px"],
					body .better-weather.with-natural-background.state-cloudy.style-modern[max-width~="400px"],
					body .better-weather.with-natural-background.state-cloudy[max-width~="550px"],
					body .better-weather.with-natural-background.state-cloudy[max-width~="650px"],
					body .better-weather.with-natural-background.state-cloudy[max-width~="830px"],
					body .better-weather.with-natural-background.state-cloudy[max-width~="970px"],
					body .better-weather.with-natural-background.state-cloudy[max-width~="1170px"]
					 {
  background-position: center center !important; }',
				)
			),
		);
		$field['style_cloudy_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_cloudy_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Cloudy</strong> background color.', 'better-studio' ),
			'std'           =>  '#208aae',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-cloudy',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Partly Cloudy Day
		 */
		$field[] = array(
			'name'  =>  __( 'Partly Cloudy Day Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_partly_cloudy_day_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_partly_cloudy_day_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Partly Cloudy Day</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-partly-cloudy-day'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image',
					'after' => '
					body .better-weather.with-natural-background.state-partly-cloudy-day[max-width~="830px"],
					body .better-weather.with-natural-background.state-partly-cloudy-day[max-width~="170px"],
					body .better-weather.with-natural-background.state-partly-cloudy-day[max-width~="100px"],
					body .better-weather.with-natural-background.state-partly-cloudy-day[max-width~="970px"],
					body .better-weather.with-natural-background.state-partly-cloudy-day[max-width~="1170px"]{ background-position: center center !important; }',
				)
			),
		);
		$field['style_partly_cloudy_day_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_partly_cloudy_day_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Partly Cloudy Day</strong> background color.', 'better-studio' ),
			'std'           =>  '#1A4192',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-partly-cloudy-day',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Partly Cloudy Night
		 */
		$field[] = array(
			'name'  =>  __( 'Partly Cloudy Night Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_partly_cloudy_night_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_partly_cloudy_night_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Partly Cloudy Night</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-partly-cloudy-night'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image',
					'after' => '
					body .better-weather.with-natural-background.state-partly-cloudy-night.have-next-days[max-width~="400px"],
					body .better-weather.with-natural-background.state-partly-cloudy-night[max-width~="1170px"]{ background-position: center center !important; }',
				)
			),
		);
		$field['style_partly_cloudy_night_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_partly_cloudy_night_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Partly Cloudy Night</strong> background color.', 'better-studio' ),
			'std'           =>  '#0F0F0F',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-partly-cloudy-night',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Sunrise
		 */
		$field[] = array(
			'name'  =>  __( 'Sunrise Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_sunrise_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_sunrise_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Sunrise</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-sunrise'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image',
					'after' => '
					body .better-weather.with-natural-background.state-sunrise[max-width~="970px"],
					body .better-weather.with-natural-background.state-sunrise[max-width~="870px"],
					body .better-weather.with-natural-background.state-sunrise[max-width~="770px"],
					body .better-weather.with-natural-background.state-sunrise[max-width~="670px"],
					body .better-weather.with-natural-background.state-sunrise.style-modern[max-width~="400px"],
					body .better-weather.with-natural-background.state-sunrise.style-normal[max-width~="400px"],
					body .better-weather.with-natural-background.state-sunrise.style-modern[max-width~="300px"],
					body .better-weather.with-natural-background.state-sunrise.style-normal[max-width~="300px"],
					body .better-weather.with-natural-background.state-sunrise.style-modern[max-width~="170px"],
					body .better-weather.with-natural-background.state-sunrise.style-normal[max-width~="170px"],
					body .better-weather.with-natural-background.state-sunrise.have-next-days[max-width~="100px"],
					body .better-weather.with-natural-background.state-sunrise[max-width~="100px"],
					body .better-weather.with-natural-background.state-sunrise[max-width~="1070px"],
					body .better-weather.with-natural-background.state-sunrise[max-width~="1170px"]{ background-position: center center !important; }',
				)
			),
		);
		$field['style_sunrise_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_sunrise_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Sunrise</strong> background color.', 'better-studio' ),
			'std'           =>  '#fd654d',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-sunrise',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Sunset
		 */
		$field[] = array(
			'name'  =>  __( 'Sunset Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_sunset_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_sunset_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Sunset</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-sunset',
						'body .better-weather.with-natural-background.state-sunset[max-width~="400px"]'
					),
					'prop'      => array(
						'background-image' => '%%value%% !important; background-position: center center !important;',
					),
					'type'      => 'background-image',
					'after' => '
					body .better-weather.with-natural-background.state-sunset[max-width~="970px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="870px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="770px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="670px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="570px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="470px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="400px"],
					body .better-weather.with-natural-background.state-sunset.have-next-days[max-width~="400px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="350px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="300px"],
					body .better-weather.with-natural-background.state-sunset.have-next-days[max-width~="250px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="250px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="200px"],
					body .better-weather.with-natural-background.state-sunset.have-next-days[max-width~="200px"],
					body .better-weather.with-natural-background.state-sunset.have-next-days[max-width~="170px"],
					body .better-weather.with-natural-background.state-sunset.have-next-days[max-width~="470px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="170px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="120px"],
					body .better-weather.with-natural-background.state-sunset.have-next-days[max-width~="120px"],
					body .better-weather.with-natural-background.state-sunset[max-width~="1070px"]{background-position: center center !important; }',
				),
			),
		);
		$field['style_sunset_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_sunset_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Sunset</strong> background color.', 'better-studio' ),
			'std'           =>  '#0F0F0F',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-sunset',
					),
					'prop'      => 'background-color'
				)
			)
		);

		/**
		 * => Style -> Sleet
		 */
		$field[] = array(
			'name'  =>  __( 'Sleet Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_sleet_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_sleet_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Sleet</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-sleet'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image'
				)
			)
		);
		$field['style_sleet_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_sleet_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Sleet</strong> background color.', 'better-studio' ),
			'std'           =>  '#607592',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-sleet',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Wind
		 */
		$field[] = array(
			'name'  =>  __( 'Wind Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_wind_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_wind_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Wind</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-wind'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image'
				)
			)
		);
		$field['style_wind_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_wind_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Wind</strong> background color.', 'better-studio' ),
			'std'           =>  '#607592',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-wind',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Fog
		 */
		$field[] = array(
			'name'  =>  __( 'Fog Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_fog_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_fog_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Fog</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-fog'
					),
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image'
				)
			)
		);
		$field['style_fog_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_fog_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Fog</strong> background color.', 'better-studio' ),
			'std'           =>  '#607592',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-fog',
					),
					'prop'      => 'background-color'
				)
			)
		);


		/**
		 * => Style -> Thunderstorm
		 */
		$field[] = array(
			'name'  =>  __( 'Thunderstorm Style', 'better-studio' ),
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['style_thunderstorm_bg_img'] = array(
			'name'          =>  __( 'Background Image', 'better-studio' ),
			'id'            =>  'style_thunderstorm_bg_img',
			'type'          =>  'background_image',
			'std'           =>  '',
			'upload_label'  =>  __( 'Upload Image', 'better-studio' ),
			'desc'          =>  __( 'Customize <strong>Thunderstorm</strong> background image.', 'better-studio' ),
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-thunderstorm'
					),
					'after' => '
					 body .better-weather.with-natural-background.state-thunderstorm[max-width~="970px"],
					 body .better-weather.have-next-days.with-natural-background.state-thunderstorm[max-width~="970px"],
					 body .better-weather.with-natural-background.state-thunderstorm[max-width~="830px"],
					 body .better-weather.with-natural-background.state-thunderstorm[max-width~="650px"],
					 body .better-weather.with-natural-background.state-thunderstorm[max-width~="550px"],
					 body .better-weather.with-natural-background.state-thunderstorm.style-modern[max-width~="400px"],
					 body .better-weather.with-natural-background.state-thunderstorm.style-normal[max-width~="400px"],
					 body .better-weather.with-natural-background.state-thunderstorm.style-modern[max-width~="300px"],
					 body .better-weather.with-natural-background.state-thunderstorm.style-normal[max-width~="300px"],
					 body .better-weather.with-natural-background.state-thunderstorm.style-modern[max-width~="170px"],
					 body .better-weather.with-natural-background.state-thunderstorm.style-normal[max-width~="170px"],
					 body .better-weather.with-natural-background.state-thunderstorm.style-normal[max-width~="100px"],
					 body .better-weather.with-natural-background.state-thunderstorm.style-modern[max-width~="100px"]
					 {
  background-position: center center !important; }',
					'prop'      => array( 'background-image' => '%%value%%; background-position: center center !important;' ),
					'type'      => 'background-image'
				)
			)
		);
		$field['style_thunderstorm_bg_color'] = array(
			'name'          =>  __( 'Background Color', 'better-studio' ),
			'id'            =>  'style_thunderstorm_bg_color',
			'type'          =>  'color',
			'desc'          =>  __( 'Customize <strong>Thunderstorm</strong> background color.', 'better-studio' ),
			'std'           =>  '#47456e',
			'css'           =>  array(
				array(
					'selector'  => array(
						'body .better-weather.with-natural-background.state-thunderstorm',
					),
					'prop'      => 'background-color'
				)
			)
		);


		$field[] = array(
			'name' => __( 'Translations', 'better-studio'),
			'id' => 'translation',
			'type' => 'tab',
			'icon' => 'bsai-translation',
			'badge' => array(
				'text'  =>  __( 'New', 'better-studio' ),
				'color' => '#62D393'
			)
		);
		$field[] = array(
			'name'  =>  __( 'Weather Forecast Translations', 'better-studio' ),
			'id'    =>  'tr_forecast',
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['tr_forecast_clear'] = array(
			'name'          =>  __( 'Clear', 'better-studio' ),
			'id'            =>  'tr_forecast_clear',
			'std'           =>  'Clear',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_rain'] = array(
			'name'          =>  __( 'Rain', 'better-studio' ),
			'id'            =>  'tr_forecast_rain',
			'std'           =>  'Rain',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_light_rain'] = array(
			'name'          =>  __( 'Light Rain', 'better-studio' ),
			'id'            =>  'tr_forecast_light_rain',
			'std'           =>  'Light Rain',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_drizzle'] = array(
			'name'          =>  __( 'Drizzle', 'better-studio' ),
			'id'            =>  'tr_forecast_drizzle',
			'std'           =>  'Drizzle',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_light_rain_and_windy'] = array(
			'name'          =>  __( 'Light Rain And Windy', 'better-studio' ),
			'id'            =>  'tr_forecast_light_rain_and_windy',
			'std'           =>  'Light Rain And Windy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_flurries'] = array(
			'name'          =>  __( 'Flurries', 'better-studio' ),
			'id'            =>  'tr_forecast_flurries',
			'std'           =>  'Flurries',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_flurries_df'] = array(
			'name'          =>  __( 'Flurries DF', 'better-studio' ),
			'id'            =>  'tr_forecast_flurries_df',
			'std'           =>  'Flurries DF',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
			'desc'          =>  __( 'DF: Daylight Factor', 'better-studio'),
		);
		$field['tr_forecast_cloudy'] = array(
			'name'          =>  __( 'Cloudy', 'better-studio' ),
			'id'            =>  'tr_forecast_cloudy',
			'std'           =>  'Cloudy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_mostly_cloudy'] = array(
			'name'          =>  __( 'Mostly Cloudy', 'better-studio' ),
			'id'            =>  'tr_forecast_mostly_cloudy',
			'std'           =>  'Mostly Cloudy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_partly_cloudy'] = array(
			'name'          =>  __( 'Partly Cloudy', 'better-studio' ),
			'id'            =>  'tr_forecast_partly_cloudy',
			'std'           =>  'Partly Cloudy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_snow'] = array(
			'name'          =>  __( 'Snow', 'better-studio' ),
			'id'            =>  'tr_forecast_snow',
			'std'           =>  'Snow',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_light_snow'] = array(
			'name'          =>  __( 'Light Snow', 'better-studio' ),
			'id'            =>  'tr_forecast_light_snow',
			'std'           =>  'Light Snow',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_snow_and_breezy'] = array(
			'name'          =>  __( 'Snow and Breezy', 'better-studio' ),
			'id'            =>  'tr_forecast_snow_and_breezy',
			'std'           =>  'Snow and Breezy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_snow_and_windy'] = array(
			'name'          =>  __( 'Snow and Windy', 'better-studio' ),
			'id'            =>  'tr_forecast_snow_and_windy',
			'std'           =>  'Snow and Windy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_sleet'] = array(
			'name'          =>  __( 'Sleet', 'better-studio' ),
			'id'            =>  'tr_forecast_sleet',
			'std'           =>  'Sleet',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_wind'] = array(
			'name'          =>  __( 'Wind', 'better-studio' ),
			'id'            =>  'tr_forecast_wind',
			'std'           =>  'Wind',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_windy_and_mostly_cloudy'] = array(
			'name'          =>  __( 'Windy And Most Cloudy', 'better-studio' ),
			'id'            =>  'tr_forecast_windy_and_mostly_cloudy',
			'std'           =>  'Windy And Most Cloudy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_foggy'] = array(
			'name'          =>  __( 'Foggy', 'better-studio' ),
			'id'            =>  'tr_forecast_foggy',
			'std'           =>  'Foggy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_thunderstorm'] = array(
			'name'          =>  __( 'Thunderstorm', 'better-studio' ),
			'id'            =>  'tr_forecast_thunderstorm',
			'std'           =>  'Thunderstorm',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_overcast'] = array(
			'name'          =>  __( 'Overcast', 'better-studio' ),
			'id'            =>  'tr_forecast_overcast',
			'std'           =>  'Overcast',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_overcast_df'] = array(
			'name'          =>  __( 'Overcast DF', 'better-studio' ),
			'id'            =>  'tr_forecast_overcast_df',
			'std'           =>  'Overcast DF',
			'type'          =>  'text',
			'desc'          =>  __( 'DF: Daylight Factor', 'better-studio' ),
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_breezy_and_partly_cloudy'] = array(
			'name'          =>  __( 'Breezy and Partly Cloudy', 'better-studio' ),
			'id'            =>  'tr_forecast_breezy_and_partly_cloudy',
			'std'           =>  'Breezy and Partly Cloudy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_breezy_and_mostly_cloudy'] = array(
			'name'          =>  __( 'Breezy and Mostly Cloudy', 'better-studio' ),
			'id'            =>  'tr_forecast_breezy_and_mostly_cloudy',
			'std'           =>  'Breezy and Mostly Cloudy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_breezy_and_overcast'] = array(
			'name'          =>  __( 'Breezy and Overcast', 'better-studio' ),
			'id'            =>  'tr_forecast_breezy_and_overcast',
			'std'           =>  'Breezy and Overcast',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_humid_and_mostly_cloudy'] = array(
			'name'          =>  __( 'Humid and Mostly Cloudy', 'better-studio' ),
			'id'            =>  'tr_forecast_humid_and_mostly_cloudy',
			'std'           =>  'Humid and Mostly Cloudy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_dry_and_partly_cloudy'] = array(
			'name'          =>  __( 'Dry and Partly Cloudy', 'better-studio' ),
			'id'            =>  'tr_forecast_dry_and_partly_cloudy',
			'std'           =>  'Dry and Partly Cloudy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_dry_and_partly_cloudy_df'] = array(
			'name'          =>  __( 'Dry and Partly Cloudy DF', 'better-studio' ),
			'id'            =>  'tr_forecast_dry_and_partly_cloudy_df',
			'std'           =>  'Dry and Partly Cloudy',
			'type'          =>  'text',
			'desc'          =>  __( 'DF: Daylight Factor', 'better-studio' ),
			'container_class'      =>  'highlight-hover',
		);

		$field['tr_forecast_dry_and_mostly_cloudy'] = array(
			'name'          =>  __( 'Dry and Mostly Cloudy', 'better-studio' ),
			'id'            =>  'tr_forecast_dry_and_mostly_cloudy',
			'std'           =>  'Dry and Mostly Cloudy',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_forecast_dry_and_mostly_cloudy_df'] = array(
			'name'          =>  __( 'Dry and Mostly Cloudy DF', 'better-studio' ),
			'id'            =>  'tr_forecast_dry_and_mostly_cloudy_df',
			'std'           =>  'Dry and Mostly Cloudy DF',
			'type'          =>  'text',
			'desc'          =>  __( 'DF: Daylight Factor', 'better-studio' ),
			'container_class'      =>  'highlight-hover',
		);


		$field[] = array(
			'name'  =>  __( 'Months Name Translations', 'better-studio' ),
			'id'    =>  'tr_month',
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['tr_month_january'] = array(
			'name'          =>  __( 'January', 'better-studio' ),
			'id'            =>  'tr_month_january',
			'std'           =>  'January',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_february'] = array(
			'name'          =>  __( 'February', 'better-studio' ),
			'id'            =>  'tr_month_february',
			'std'           =>  'February',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_march'] = array(
			'name'          =>  __( 'March', 'better-studio' ),
			'id'            =>  'tr_month_march',
			'std'           =>  'March',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_april'] = array(
			'name'          =>  __( 'April', 'better-studio' ),
			'id'            =>  'tr_month_april',
			'std'           =>  'April',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_may'] = array(
			'name'          =>  __( 'May', 'better-studio' ),
			'id'            =>  'tr_month_may',
			'std'           =>  'May',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_june'] = array(
			'name'          =>  __( 'June', 'better-studio' ),
			'id'            =>  'tr_month_june',
			'std'           =>  'June',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_july'] = array(
			'name'          =>  __( 'July', 'better-studio' ),
			'id'            =>  'tr_month_july',
			'std'           =>  'July',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_august'] = array(
			'name'          =>  __( 'August', 'better-studio' ),
			'id'            =>  'tr_month_august',
			'std'           =>  'August',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_september'] = array(
			'name'          =>  __( 'September', 'better-studio' ),
			'id'            =>  'tr_month_september',
			'std'           =>  'September',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_october'] = array(
			'name'          =>  __( 'October', 'better-studio' ),
			'id'            =>  'tr_month_october',
			'std'           =>  'October',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_november'] = array(
			'name'          =>  __( 'November', 'better-studio' ),
			'id'            =>  'tr_month_november',
			'std'           =>  'November',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_month_december'] = array(
			'name'          =>  __( 'December', 'better-studio' ),
			'id'            =>  'tr_month_december',
			'std'           =>  'December',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);

		$field[] = array(
			'name'  =>  __( 'Days Name Translations', 'better-studio' ),
			'id'    =>  'tr_day',
			'type'  =>  'group',
			'state' =>  'close',
		);
		$field['tr_days_sat'] = array(
			'name'          =>  __( 'Sat', 'better-studio' ),
			'id'            =>  'tr_days_sat',
			'std'           =>  'Sat',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_days_sun'] = array(
			'name'          =>  __( 'Sun', 'better-studio' ),
			'id'            =>  'tr_days_sun',
			'std'           =>  'Sun',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_days_mon'] = array(
			'name'          =>  __( 'Mon', 'better-studio' ),
			'id'            =>  'tr_days_mon',
			'std'           =>  'Mon',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_days_tue'] = array(
			'name'          =>  __( 'Tue', 'better-studio' ),
			'id'            =>  'tr_days_tue',
			'std'           =>  'Tue',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_days_wed'] = array(
			'name'          =>  __( 'Wed', 'better-studio' ),
			'id'            =>  'tr_days_wed',
			'std'           =>  'Wed',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_days_thu'] = array(
			'name'          =>  __( 'Thu', 'better-studio' ),
			'id'            =>  'tr_days_thu',
			'std'           =>  'Thu',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);
		$field['tr_days_fri'] = array(
			'name'          =>  __( 'Fri', 'better-studio' ),
			'id'            =>  'tr_days_fri',
			'std'           =>  'Fri',
			'type'          =>  'text',
			'container_class'      =>  'highlight-hover',
		);

		//
		// Caching Options
		//
		$field[] = array(
			'name'      =>  __( 'Caching Options' , 'better-studio' ),
			'id'        =>  'cache_options_title',
			'type'      =>  'tab',
			'icon'      =>  'bsai-database',
		);
		$field[] = array(
			'name'      =>  __( 'Maximum Lifetime of Cache', 'better-studio' ),
			'id'        =>  'cache_time',
			'type'      =>  'select',
			'std'       =>  30,
			'options'   =>  array(
				30   =>  __( '30 Minutes', 'better-studio' ),
				60   =>  __( '1 Hour', 'better-studio' ),
				90   =>  __( '1 Hour and 30 Minutes', 'better-studio' ),
				120  =>  __( '2 Hour', 'better-studio' ),
				150  =>  __( '2 Hour and 30 Minutes', 'better-studio' ),
				180  =>  __( '3 Hour', 'better-studio' ),
			)
		);
		$field[] = array(
			'name'      =>  __( 'Clear Data Base Saved Caches', 'better-studio' ),
			'id'        =>  'cache_clear_all',
			'type'      =>  'ajax_action',
			'button-name' =>  '<i class="fa fa-refresh"></i> ' . __( 'Purge All Caches', 'better-studio' ),
			'callback'  =>  'Better_Weather::clear_cache_all',
			'confirm'  =>  __( 'Are you sure for deleting all caches?', 'better-studio' ),
			'desc'      =>  __( 'This allows you to clear all caches that are saved in data base.', 'better-studio' )
		);

		$field[] = array(
			'name'      =>  __( 'Backup & Restore' , 'better-studio' ),
			'id'        =>  'backup_restore',
			'type'      =>  'tab',
			'icon'      =>  'bsai-export-import',
			'margin-top'=>  '30',
		);
		$field[] = array(
			'name'      =>  __( 'Backup / Export', 'better-studio' ),
			'id'        =>  'backup_export_options',
			'type'      =>  'export',
			'file_name' =>  'betterweather-options-backup',
			'panel_id'  =>  Better_Weather::$panel_id,
			'desc'      =>  __( 'This allows you to create a backup of your options and settings. Please note, it will not backup anything else.', 'better-studio' )
		);
		$field[] = array(
			'name'      =>  __( 'Restore / Import', 'better-studio' ),
			'id'        =>  'import_restore_options',
			'type'      =>  'import',
			'panel_id'  =>  Better_Weather::$panel_id,
			'desc'      =>  __( '<strong>It will override your current settings!</strong> Please make sure to select a valid backup file.', 'better-studio' )
		);

		// Language  name for smart admin texts
		$lang = bf_get_current_lang_raw();
		if( $lang != 'none' ){
			$lang = bf_get_language_name( $lang );
		}else{
			$lang = '';
		}

		$options[Better_Weather::$panel_id] = array(
			'config' => array(
				'parent'                =>    'better-studio',
				'slug' 			        => 'better-studio/better-weather',
				'name'                  =>    __( 'Better Weather', 'better-studio' ),
				'page_title'            =>    __( 'Better Weather', 'better-studio' ),
				'menu_title'            =>    __( 'Weather', 'better-studio' ),
				'capability'            =>    'manage_options',
				'menu_slug'             =>    __( 'BetterWeather', 'better-studio' ),
				'icon_url'              =>    null,
				'position'              =>    '80.01',
				'exclude_from_export'   =>    false,
			),
			'texts'         =>  array(
				'panel-desc-lang'       =>  '<p>' . __( '%s Language Options.', 'better-studio' ) . '</p>',
				'panel-desc-lang-all'   =>  '<p>' . __( 'All Languages Options.', 'better-studio' ) . '</p>',

				'reset-button'      => ! empty( $lang ) ? sprintf( __( 'Reset %s Options', 'better-studio' ), $lang ) : __( 'Reset Options', 'better-studio' ),
				'reset-button-all'  => __( 'Reset All Options', 'better-studio' ),

				'reset-confirm'     =>  ! empty( $lang ) ? sprintf( __( 'Are you sure to reset %s options?', 'better-studio' ), $lang ) : __( 'Are you sure to reset options?', 'better-studio' ),
				'reset-confirm-all' => __( 'Are you sure to reset all options?', 'better-studio' ),

				'save-button'       =>  ! empty( $lang ) ? sprintf( __( 'Save %s Options', 'better-studio' ), $lang ) : __( 'Save Options', 'better-studio' ),
				'save-button-all'   =>  __( 'Save All Options', 'better-studio' ),

				'save-confirm-all'  =>  __( 'Are you sure to save all options? this will override specified options per languages', 'better-studio' )
			),

			'panel-name'    => _x( 'Better Weather', 'Panel title', 'better-studio' ),
			'panel-desc'    =>  '<p>' . __( 'Setup BetterWeather, Translate texts and create backup.', 'better-studio' ) . '</p>',
			'fields' => $field
		);

		return $options;
	}
}
