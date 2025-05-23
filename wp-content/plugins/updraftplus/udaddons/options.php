<?php
// phpcs:disable WordPress.Security.EscapeOutput.HeredocOutputNotEscaped
if (!defined('ABSPATH')) die('No direct access allowed');

/**
 * For all copyright, version, etc. information, please see the main plugin file
 * Gets invoked during admin_menu
 * http://codex.wordpress.org/Creating_Options_Pages
 */
class UpdraftPlusAddOns_Options2 {

	public $slug;

	public $title;

	public $mother;

	private $connected = false;

	// Object with at least get_option(), update_option() and addons_admin_url() methods
	private $options;

	/**
	 * Plugin update URL
	 *
	 * @var String
	 */
	private $plugin_update_url;

	/**
	 * Updated JavaScript code.
	 *
	 * @var String
	 */
	private $update_js;

	public function __construct($slug, $title, $mother) {

		$this->slug = $slug;
		$this->title = $title;
		$this->mother = $mother;

		// We are called in admin_menu
		// $this->options_menu();

		// New actions to output the tab title and content
// add_action('updraftplus_settings_afternavtabs', array($this, 'settings_afternavtabs'));
		add_filter('updraftplus_addonstab_content', array($this, 'updraftplus_addonstab_content'));
		add_filter('updraftplus_com_login_options', array($this, 'updraftplus_com_login_options'));

		add_action('admin_init', array($this, 'show_admin_notices'));
		add_action('admin_init', array($this, 'options_init'));
		register_activation_hook(UDADDONS2_SLUG, array($this, 'options_setdefaults'));

		add_filter((is_multisite() ? 'network_admin_' : '').'plugin_action_links', array($this, 'action_links'), 10, 2);

		global $updraftplus_addons2;
		$this->options = $updraftplus_addons2;

	}

	public function updraftplus_addonstab_content() {
		ob_start();
		$this->options_printpage();
		return ob_get_clean();
	}

	/**
	 * Registers any admin page notices. Runs upon admin_init.
	 */
	public function show_admin_notices() {
		global $pagenow;

		if (apply_filters('updraftplus_settings_page_render', true)) {

			$options = $this->options->get_option(UDADDONS2_SLUG.'_options');
			if (empty($options['email']) && UpdraftPlus_Options::user_can_manage() && isset($_REQUEST['page']) && 'updraftplus' == $_REQUEST['page']) {
				add_action('all_admin_notices', array($this, 'show_admin_warning_notconnected'));
			}

		}

		if ((is_multisite() && 'settings.php' == $pagenow) || (!is_multisite() && 'options-general.php' == $pagenow) && isset($_REQUEST['page']) && (UDADDONS2_PAGESLUG == $_REQUEST['page'] || $_REQUEST['page'] == $this->slug)) {
			$updates_available = get_site_transient('update_plugins');
			global $updraftplus_addons2;
			if (is_object($updates_available) && isset($updates_available->response) && isset($updraftplus_addons2->plug_updatechecker) && isset($updraftplus_addons2->plug_updatechecker->pluginFile) && isset($updates_available->response[$updraftplus_addons2->plug_updatechecker->pluginFile])) {
				$file = $updraftplus_addons2->plug_updatechecker->pluginFile;
				$this->plugin_update_url = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&updraftplus_noautobackup=1&plugin=').$file, 'upgrade-plugin_'.$file);
				add_action('all_admin_notices', array($this, 'show_admin_warning_update'));
			}
		}
	}

	/**
	 * Echoes a div with a WP dashboard admin message in it
	 *
	 * @param String $message - the message text (this is unescaped string which allows HTML tags to be included but only tags that are allowed by wp_kses_post())
	 * @param String $class   - the CSS class for the div
	 */
	private function show_admin_warning($message, $class = "updated") {
		echo '<div class="'.esc_attr($class).'">'."<p>".wp_kses_post($message)."</p></div>";
	}

	/**
	 * Show an administrative warning about the available updates of UpdraftPlus
	 */
	public function show_admin_warning_update() {
		global $updraftplus_addons2;
		if ($updraftplus_addons2->connection_status()) {
			$msg = '<a id="updraftaddons_updatewarning" href="'.$this->plugin_update_url.'">'.esc_html__('An update is available for UpdraftPlus - please follow this link to get it.', 'updraftplus').'</a>';
		} else {
			$msg = '<a id="updraftaddons_updatewarning" href="'.esc_url(admin_url($this->options->addons_admin_url())).'">'.esc_html__('An update is available for UpdraftPlus - please connect here to gain access to it.', 'updraftplus').'</a>';
		}
		$this->show_admin_warning($msg);
	}

	public function show_admin_warning_notconnected() {
		$this->show_admin_warning(esc_html(__('You have not yet connected the UpdraftPlus plugin to your UpdraftPlus licence.', 'updraftplus')).' <a href="https://teamupdraft.com/my-account/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=connect-to-licence&utm_creative_format=notice">'.esc_html__('Connect to your account.', 'updraftplus').'</a>');
	}

	public function show_admin_warning_noupdraftplus() {
		if (is_file(WP_PLUGIN_DIR.'/updraftplus/updraftplus.php')) {
			global $pagenow;
			$msg = esc_html__('UpdraftPlus is not yet activated.', 'updraftplus');
			if ('plugins.php' != $pagenow) $msg .= ' <a href="plugins.php">'.esc_html__('Go here to activate it.', 'updraftplus').'</a>';
			$this->show_admin_warning($msg);
		} else {
			$warning = esc_html__('UpdraftPlus is not yet installed.', 'updraftplus').' <a href="'.$this->mother.'/download/">'.esc_html__('Go here to begin installing it.', 'updraftplus').'</a>';
			if (file_exists(WP_PLUGIN_DIR.'/updraft')) $warning .= ' '.esc_html__('You do seem to have the obsolete Updraft plugin installed - perhaps you got them confused?', 'updraftplus');
			$this->show_admin_warning($warning);
		}
	}

	/**
	 * Output a notice suitable for the dashboard warning that PHP is too old.
	 */
	public function show_admin_warning_php() {
		$this->show_admin_warning(esc_html(sprintf(__("Your web server's version of PHP is too old (%s) - UpdraftPlus expects at least %s.", 'updraftplus'), PHP_VERSION, '5.2.4').' '.__("You can try it, but don't be surprised if it does not work.", 'updraftplus').' '.__("To fix this problem, contact your web hosting company.", 'updraftplus')), 'error');
	}

	/**
	 * Registered under admin_init
	 */
	public function options_init() {

		// Register a new set of options, named $slug_options, stored in the database entry $slug_options
		// We register and use the printing facilities for multisite too

		register_setting(UDADDONS2_SLUG.'_options', UDADDONS2_SLUG.'_options', array($this, 'options_validate'));

		if (is_multisite() && (isset($_POST['action']) && 'update' == $_POST['action']) && !empty($_POST['updraftplus-addons_options'])) {
			$this->update_wpmu_options();
		}

	}

	public function options_setdefaults() {
		$tmp = $this->options->get_option(UDADDONS2_SLUG.'_options');
		if (!is_array($tmp)) {
			$arr = array(
				"email" => "",
				"password" => ""
			);
			$this->options->update_option(UDADDONS2_SLUG.'_options', $arr);
		}
	}

	/**
	 * This function is registered via register_setting. It is intended to return sanitised output, and can optionally call add_settings_error to whinge about anything faulty
	 *
	 * @param  array $input
	 * @return array
	 */
	public function options_validate($input) {
		// When the options are re-saved, clear any previous cache of the connection status
		$ehash = substr(md5($input['email']), 0, 23);
		delete_site_transient('udaddons_connect_'.$ehash);

		return $input;
	}

	/**
	 * Return an array of errors (if any);
	 *
	 * @return array
	 */
	public function update_wpmu_options() {
		if (!UpdraftPlus_Options::user_can_manage()) return;
		$options = $this->options->get_option(UDADDONS2_SLUG.'_options');
		if (!is_array($options)) $options = array();

		foreach ($_POST as $key => $value) {
			if ('updraftplus-addons_options' == $key && is_array($value) && isset($value['email']) && isset($value['password'])) {
				$options['email'] = $value['email'];
				$options['password'] = $value['password'];
			}
		}

		$options = $this->options_validate($options);

		$this->options->update_option(UDADDONS2_SLUG.'_options', $options);
	}

	/**
	 * This function will return the saved options and if there are none returns the default options passed in.
	 *
	 * @param array $default_options - an array that includes the default options
	 *
	 * @return array                 - returns an array of options
	 */
	public function updraftplus_com_login_options($default_options) {
		$options = $this->options->get_option(UDADDONS2_SLUG.'_options');
		return is_array($options) ? $options : $default_options;
	}

	/**
	 * This is the function outputting the HTML for our options page
	 */
	public function options_printpage() {
		if (!UpdraftPlus_Options::user_can_manage()) wp_die(esc_html__('You do not have sufficient permissions to access this page.'));

		$options = $this->options->get_option(UDADDONS2_SLUG.'_options');

		echo "\t<div class=\"wrap\">\n";

		global $updraftplus_addons2, $updraftplus_admin, $updraftplus;

		$this->connected = !empty($options['email']) ? $updraftplus_addons2->connection_status() : false;

		if (true !== $this->connected) {
			if (is_wp_error($this->connected)) {
				$connection_errors = array();
				foreach ($this->connected->get_error_messages() as $key => $msg) {
					$connection_errors[] = $msg;
				}
			} else {
				if (!empty($options['email']) && !empty($options['password'])) $connection_errors = array(esc_html__('An unknown error occurred when trying to connect to UpdraftPlus.Com', 'updraftplus'));
			}
			$this->connected = false;
		}

		if ('updraftplus' != basename(dirname(dirname(__FILE__)))) {
			echo '<div class="error below-h2" style="font-size: 120%;"><p><strong>'.esc_html__('Error', 'updraftplus').':</strong> '.sprintf(esc_html__("You have installed this plugin in your plugins folder (%s) with a non-default name %s which is different to %s.", 'updraftplus'), esc_html(WP_PLUGIN_DIR), '<strong>'.esc_html(basename(dirname(dirname(__FILE__)))).'</strong>', '<strong>updraftplus</strong>').' '.esc_html__("This is incompatible with WordPress's updates mechanism; you will not be able to receive updates.", 'updraftplus').'</p></div>';
		}

		if (defined('WP_HTTP_BLOCK_EXTERNAL') && WP_HTTP_BLOCK_EXTERNAL) {
			echo '<div class="notice inline"><p>'.sprintf(esc_html__('Please make sure that %s is not set to "true" in your wp-config file - this ensures UpdraftPlus can connect and update.', 'updraftplus'), '<strong>WP_HTTP_BLOCK_EXTERNAL</strong>').'</p></div>';
		}

		$wp_http = new WP_Http();
		if (is_callable(array($wp_http, 'block_request')) && $wp_http->block_request($updraftplus_addons2->url)) {
			echo '<div class="notice inline"><p>'.sprintf(esc_html__('Please list %s in the %s constant.', 'updraftplus'), '<strong>updraftplus.com</strong>', '<strong>WP_ACCESSIBLE_HOSTS</strong>').' '.sprintf(esc_html__('This ensures %s can connect and update.', 'updraftplus'), 'UpdraftPlus').'</p></div>';
		}

		if ($this->connected) {
			/* translators: %s: Plugin's connection status (it's either connected or not connected) */
			echo '<div class="udp-notice below-h2"><h3>'.sprintf(esc_html__('You are presently %s to a TeamUpdraft account.', 'updraftplus'), '<strong class="success">'.
			esc_html__('connected', 'updraftplus').'</strong>').'</h3>';

			echo '<p>';

			// Not translated; it's only seen in development
			if (false === strpos($this->mother, '//updraftplus.com')) echo ' <strong>(Updates URL: '.esc_url($this->mother).')</strong>.';
			
			echo ' <a href="'.esc_url(UpdraftPlus::get_current_clean_url()).'" onclick="jQuery(\'#updraft-navtab-addons-content .ud_connectsubmit\').click(); return false;">'.esc_html__('If you bought new add-ons, then follow this link to refresh your connection', 'updraftplus').'</a>.';
			if (!empty($options['password'])) echo ' '.esc_html__("Note that after you have claimed your add-ons, you can remove your password (but not the email address) from the settings below, without affecting this site's access to updates.", 'updraftplus');

			echo '</p>';

			echo '</div>';
		} else {
			/* translators: %s: Plugin's connection status (it's either connected or not connected) */
			echo "<div class=\"udp-notice below-h2\"><p>".sprintf(esc_html__('You are presently %s to a TeamUpdraft account.', 'updraftplus'), '<strong>'.
			esc_html__('not connected', 'updraftplus').'</strong>').'</p></div>';

		}

		if (isset($connection_errors)) {
			echo '<div class="error"><p><strong>'.esc_html__('Errors occurred when trying to connect to your TeamUpdraft account:', 'updraftplus').'</strong></p><ul>';
			foreach ($connection_errors as $err) {
				echo '<li style="list-style:disc inside;">'.wp_kses_post($err).'</li>';
			}
			echo '</ul></div>';
		}

		if (UpdraftPlus_Options::get_updraft_option('updraftplus_com_and_udc_connection_success', false)) {
			UpdraftPlus_Options::delete_updraft_option('updraftplus_com_and_udc_connection_success');
			echo '<div class="updated below-h2">';
			echo '<p>';
			echo esc_html__('You successfully logged in to UpdraftPlus and connected this site to UpdraftCentral Cloud.', 'updraftplus');
			echo '<br> <a href="'.esc_url($updraftplus->get_url('mothership')).'/?udm_action=updraftcentral_cloud_redirect'.'" target="_blank">'.esc_html__('Go to your UpdraftCentral Cloud dashboard', 'updraftplus').'</a>';
			echo '</p>';
			echo '</div>';
		}

		$sid = $updraftplus_addons2->siteid();

		$home_url = home_url();

		// Enumerate possible unclaimed/re-claimable purchases, and what should be active on this site
		$unclaimed_available = array();
		$assigned = array();
		$have_all = false;
		if ($this->connected && isset($updraftplus_addons2->user_addons) && is_array($updraftplus_addons2->user_addons)) {
			foreach ($updraftplus_addons2->user_addons as $akey => $addon) {
				// Keys: site, sitedescription, key, status
				if (isset($addon['status']) && 'active' == $addon['status'] && isset($addon['site']) && ('unclaimed' == $addon['site'] || 'unlimited' == $addon['site'])) {
					$key = $addon['key'];
					$unclaimed_available[$key] = array('eid' => $akey, 'status' => 'available');
				} elseif (isset($addon['status']) && 'active' == $addon['status'] && isset($addon['site']) && $addon['site'] == $sid) {
					$key = $addon['key'];
					$assigned[$key] = $akey;
					if ('all' == $key) $have_all = true;
				} elseif (isset($addon['sitedescription']) && ($this->normalise_url($home_url) === $this->normalise_url($addon['sitedescription']) || 0 === strpos($addon['sitedescription'], $home_url.' - '))) {
					// Is assigned to a site with the same URL as this one - allow a reclaim
					$key = $addon['key'];
					$unclaimed_available[$key] = array('eid' => $akey, 'status' => 'reclaimable');
				}
			}
		}

		if (!$this->connected) $updraftplus_admin->build_credentials_form(UDADDONS2_SLUG, true);

		$ourpageslug = UDADDONS2_PAGESLUG;

		$href = UpdraftPlus_Options::admin_page_url();

		if (count($unclaimed_available) > 0) {
			$nonce = wp_create_nonce('udmanager-nonce');
			$pleasewait = htmlspecialchars(esc_html__('Please wait whilst we make the claim...', 'updraftplus'));
			$notgranted = esc_js(__('Claim not granted - perhaps you have already used this purchase somewhere else, or your paid period for downloading from updraftplus.com has expired?', 'updraftplus'));
			$notgrantedlogin = esc_js(__('Claim not granted - your account login details were wrong', 'updraftplus'));
			$ukresponse = esc_js(__('An unknown response was received.', 'updraftplus').' '.esc_html__('Response was:', 'updraftplus'));
			$addon_installed = esc_html__('The claim and installation was successful.', 'updraftplus').' '.esc_html__('You can now use your purchase!', 'updraftplus');
			echo <<<ENDHERE
		<script type="text/javascript">
			function udm_claim(key) {
				if (jQuery('#addon-'+key).children('.addon-activation-notice').length) {
					return false;
				}
				var data = {
					action: 'udaddons_claimaddon',
					nonce: '$nonce',
					key: key
				};
				
				jQuery('#addon-'+key).prepend('<div class="addon-activation-notice updated" style="border: 1px solid; padding: 10px; margin-top: 10px; margin-bottom: 10px; position: absolute; z-index:99; "><strong>$pleasewait</strong></div>');
				
				jQuery.post(ajaxurl, data, function(resp) {
				
					var response_code;
					var addons_written = false;
				
					try {
						response = ud_parse_json(resp);
						response_code = response.hasOwnProperty('code') ? response.code : 'UNKNOWN';
						addons_written = response.hasOwnProperty('addons_written') ? response.addons_written : false;
					} catch (e) {
						console.log(e);
						response_code = 'PARSE_ERROR';
					}
					
					if ('ERR' == response_code) {
						alert("$notgranted");
					} else if ('OK' == response_code) {
						// We used to force udm_refresh to 1, before (Oct 2017) the possibility that there was already an updates result in the claim response
						var new_location = '$href?page=$ourpageslug&tab=addons';
						// Aug 2018: The check updates process does not refresh the user_addons list, so the plugin does not recognise the claim was granted. We need to force a refresh when a claim is activated
						if (addons_written) {
							alert("$addon_installed");
						}
						// Still do the page refresh so that the version number + other UI elements update
						new_location += '&udm_refresh=1';
						window.location.href = new_location;
					} else if ('BADAUTH' == response_code) {
						alert("$notgrantedlogin");
					} else {
						alert("$ukresponse "+response);
					}
				});
				
				return false;
			}
		</script>
ENDHERE;
		}

		echo '<h3 style="clear:left; margin-top: 10px;">'.esc_html__('UpdraftPlus Premium', 'updraftplus').'</h3><div>';

		$addons = $updraftplus_addons2->get_available_addons();

		$this->plugin_update_url = 'update-core.php';
		// Can we get a direct update URL?
		$updates_available = get_site_transient('update_plugins');

		if (is_object($updates_available) && isset($updates_available->response) && isset($updraftplus_addons2->plug_updatechecker) && isset($updraftplus_addons2->plug_updatechecker->pluginFile) && isset($updates_available->response[$updraftplus_addons2->plug_updatechecker->pluginFile])) {
			$file = $updraftplus_addons2->plug_updatechecker->pluginFile;
			$this->plugin_update_url = wp_nonce_url(self_admin_url('update.php?action=upgrade-plugin&updraftplus_noautobackup=1&plugin=').$file, 'upgrade-plugin_'.$file);
			$this->update_js = true;

		}

		$first = '';
		$second = '';
		$third = '';

		if (is_array($addons)) {
			// Making $addons['installed'] = true manually.
			// FIX: It's the "All add-ons" link that was always show as available for activation, because there's no particular "all-addons" add-on.
			$does_all_addons_installed = true;
			foreach ($addons as $key => $addon) {
				if ('all' == $key) continue;
				if (empty($addon['installed'])) {
					$does_all_addons_installed = false;
					break;
				}
			}
			if ($does_all_addons_installed) {
				$addons['all']['installed'] = true;
				if (empty($addons['all']['name'])) {
					$addons['all']['name'] = 'UpdraftPlus Premium';
					$addons['all']['shopurl'] = $updraftplus->get_url('premium');
					$addons['all']['description'] = 'UpdraftPlus Premium';
				}
			}

			foreach ($addons as $key => $addon) {
				// check if premium add-on is purchased. If it is then don't display other add-ons.
				if (!empty($addons['all']['installed']) && ('all' != $key)) continue;
				$latestversion = empty($addon['latestversion']) ? false : $addon['latestversion'];
				$installedversion = empty($addon['installedversion']) ? false : $addon['installedversion'];
				$installed = (empty($addon['installed']) && false == $installedversion) ? false : $addon['installed'];
				$unclaimed = (isset($unclaimed_available[$key])) ? $unclaimed_available[$key] : false;
				$is_assigned = (isset($assigned[$key])) ? $assigned[$key] : false;
				$box = $this->addonbox($key, $addon['name'], $addon['shopurl'], $addon['description'], trim($installedversion), trim($latestversion), $installed, $unclaimed, $is_assigned, $have_all);
				if ($is_assigned) {
					$first .= $box;
				} elseif (!empty($unclaimed)) {
					$second .= $box;
				} else {
					$third .= $box;
				}
			}
		} else {
			echo "<em>".esc_html__('An error occurred when trying to retrieve your add-ons.', 'updraftplus')."</em>";
		}

		echo $first.$second.$third;// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- contains HTML <a> tags that has inline onclick event

		echo <<<ENDHERE
		</div>
ENDHERE;

		if ($this->update_js) {
		?>
			<script>
				jQuery(function() {
						jQuery('#updraftaddons_updatewarning').html('<?php echo esc_js(__('A new update for UpdraftPlus is available - follow this link to get it', 'updraftplus')); ?>');
					}
				);
			</script>
		<?php
		}

		// TODO: Show their support package, if any - ?
		if (is_array($updraftplus_addons2->user_support)) {
			// Keys:
		}

		echo '<h3>'.esc_html__('UpdraftPlus Support', 'updraftplus').'</h3>
<ul>
<li style="list-style:disc inside;">'.esc_html__('Need to get support?', 'updraftplus').' <a aria-label="'.esc_html__('Need to get support?', 'updraftplus').esc_html__('Go here', 'updraftplus').'" target="_blank" href="https://teamupdraft.com/support/?utm_source=udp-plugin&utm_medium=referral&utm_campaign=paac&utm_content=go-here&utm_creative_format=text">'.esc_html__('Go here', 'updraftplus')."</a>.</li>
</ul>";

		if ($this->connected) {
			echo "<hr>";
			$updraftplus_admin->build_credentials_form(UDADDONS2_SLUG, true);
		}

		echo '</div>';

	}

	/**
	 * This may produce a URL that does not actually reference the same location; its purpose is to use in comparisons of two URLs that *both* go through this function, only
	 *
	 * @param  string $url
	 * @return string
	 */
	private function normalise_url($url) {
		if (preg_match('/^(\S+) - /', ltrim($url), $matches)) $url = $matches[1];
		$parsed_descrip_url = parse_url($url);
		if (is_array($parsed_descrip_url) && isset($parsed_descrip_url['host'])) {
			if (preg_match('/^www\./i', $parsed_descrip_url['host'], $matches)) $parsed_descrip_url['host'] = substr($parsed_descrip_url['host'], 4);
			$normalised_descrip_url = 'http://'.strtolower($parsed_descrip_url['host']);
			if (!empty($parsed_descrip_url['port'])) $normalised_descrip_url .= ':'.$parsed_descrip_url['port'];
			if (!empty($parsed_descrip_url['path'])) $normalised_descrip_url .= untrailingslashit($parsed_descrip_url['path']);
		} else {
			$normalised_descrip_url = untrailingslashit($url);
		}
		return $normalised_descrip_url;
	}

	private function addonbox($key, $name, $shopurl, $description, $installedversion, $latestversion = false, $installed = false, $unclaimed = false, $is_assigned = false, $have_all = false) {
		$urlbase = UPDRAFTPLUS_URL.'/images/addons-images';
		$mother = $this->mother;
		$extra_description = '';

		// Remove pCloud from the individual add-ons list.
		if ('pcloud' == $key) {
			return;
		} elseif ('all' == $key) {
			$name = esc_html('Get every feature of UpdraftPlus Premium', 'updraftplus');
			$description = esc_html__('Reduce server load by backing up only incremental changes made to your website or by backing up at set times, like overnight when server resources are high.', 'updraftplus');
			$extra_description = esc_html(__('Back up automatically before updates and protect more of your hard work by backing up more files and more databases.', 'updraftplus').' '.__('Anonymise personal backup data, encrypt the database and more.', 'updraftplus'));
		}

		if ($installed && ($is_assigned || ($have_all && 'all' != $key))) {
			$blurb = "<p>";
			$preblurb = "<div style=\"float:right;padding-top:10px;\"><img title=\"".esc_html__('You\'ve got it', 'updraftplus')."\" src=\"$urlbase/$key.png\" width=\"100\" height=\"100\" alt=\"".esc_html__("You've got it", 'updraftplus')."\"></div>";
			if ('all' != $key) {
				$blurb .= sprintf(esc_html__('Your version: %s', 'updraftplus'), $installedversion);
				if (!empty($latestversion) && $latestversion == $installedversion) {
					$blurb .= " (".esc_html__('latest', 'updraftplus').')';
				} elseif (!empty($latestversion) && version_compare($latestversion, $installedversion, '>')) {
					$blurb .= " (".esc_html__('latest', 'updraftplus').": $latestversion - <a href=\"".$this->plugin_update_url."\">update</a>)";
				} else {
					$blurb .= " ".esc_html__('(apparently a pre-release or withdrawn release)', 'updraftplus');
				}
			}
			$blurb .= "</p>";
		} else {
			if ($have_all && 'all' != $key) {
				$blurb = '<p><strong>'.esc_html__('Available for this site (via your all-addons purchase)', 'updraftplus').' - <a href="'.$this->plugin_update_url.'">'.esc_html__('please follow this link to update the plugin in order to get it', 'updraftplus').'</a></strong></p>';
				$preblurb = "<div style=\"border: 2px solid #189c5f;padding: 10px;width: 72px;height: 72px;border-radius: 5px;position: relative;background: #1a9c5e0f;\"><img style=\"-webkit-filter: grayscale(100%);filter: grayscale(100%);width: 56px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);\" src=\"$urlbase/$key.png\"></div>";
			} elseif ($is_assigned) {
				$blurb = '<p><strong>'.esc_html__('Assigned to this site', 'updraftplus').' - <a href="'.$this->plugin_update_url.'">'.esc_html__('please  follow this link to update the plugin in order to activate it', 'updraftplus').'</a></strong></p>';
				$preblurb = "<div style=\"border: 2px solid #189c5f;padding: 10px;width: 72px;height: 72px;border-radius: 5px;position: relative;background: #1a9c5e0f;\"><img style=\"-webkit-filter: grayscale(100%);filter: grayscale(100%);width: 56px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);\" src=\"$urlbase/$key.png\"></div>";
			} elseif (is_array($unclaimed)) {
				// Keys: eid = unique ID, status = available|reclaimable
				// Value of $unclaimed is a unique id, though we won't particularly use it
				if (isset($unclaimed['status']) && 'reclaimable' == $unclaimed['status']) {
					$blurb ='<p><strong>'.esc_html__('Available to claim on this site', 'updraftplus').' - <a aria-label="'.sprintf(esc_html__('%s available to claim on this site.', 'updraftplus').' '.esc_html__('Follow this link to activate this licence', 'updraftplus'), $name).'" href="#" onclick="return udm_claim(\''.esc_js($key).'\');">'.esc_html__('activate it on this site', 'updraftplus').'</a></strong></p>';
				} else {
					$blurb ='<p><strong>'.esc_html__('You have an inactive purchase', 'updraftplus').' - <a href="#" onclick="return udm_claim(\''.esc_js($key).'\');">'.esc_html__('activate it on this site', 'updraftplus').'</a></strong></p>';
				}
				$preblurb = "<div style=\"border: 2px solid #189c5f;padding: 10px;width: 72px;height: 72px;border-radius: 5px;position: relative;background: #1a9c5e0f;\"><img style=\"-webkit-filter: grayscale(100%);filter: grayscale(100%);width: 56px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);\" src=\"$urlbase/$key.png\"></div>";
			} else {
				/* translators: %s: Add-on name */
				$blurb = '<p><a aria-label="'.sprintf(esc_html__('Get %s from teamupdraft.com', 'updraftplus'), $name).
						(($this->connected) ? '' : ' '.esc_html__('(or connect using the form on this page if you have already purchased it)', 'updraftplus')).'" target="_blank" href="'.$mother.$shopurl.'">'.esc_html__('Get it from teamupdraft.com', 'updraftplus').'</a>'.(($this->connected) ? '' : ' '.esc_html__('(or connect using the login form on this page if you have already bought it)', 'updraftplus')).'</p>';
				$preblurb = "<div style=\"border: 2px solid #8c8c8c;padding: 10px;width: 72px;height: 72px;border-radius: 5px;position: relative;background: #8c8c8c0f;\"><a href=\"".$mother.$shopurl."\" title=\"".sprintf(esc_html__('Buy %s', 'updraftplus'), $name)."\"><img style=\"-webkit-filter: grayscale(100%);filter: grayscale(100%);width: 56px;position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);\" src=\"$urlbase/$key.png\" alt=\"".esc_html__('Buy It', 'updraftplus')."\"></a></div>";
			}
		}
		if ($extra_description) $extra_description = '<p>'.$extra_description.'</p>';
		return <<<ENDHERE
			<div id="addon-$key" style="border: 1px solid #d0d0d0;border-radius: 5px;padding: 12px;max-width: 680px;margin-bottom: 22px;background-color:#fff;box-shadow: 0 0 20px 5px rgb(0 0 0 / 7%);display: flex;justify-content: space-between;align-items: center;">
				<div style="max-width: 80%;"><h2 style="">$name</h2><p>$description</p>$extra_description$blurb</div>
				$preblurb
			</div>
ENDHERE;
	}

	/**
	 * Adds links to the plugin on the 'Plugins' dashboard page, via hooking the appropriate filter.
	 *
	 * @param Array  $links - current array of links
	 * @param String $file  - the current file that links are being fetched for
	 */
	public function action_links($links, $file) {
		if ('updraftplus/updraftplus.php' == $file) {
			array_unshift($links, '<a href="'.$this->options->addons_admin_url().'">'.esc_html__('Manage Addons', 'updraftplus').'</a>');
		}
		return $links;
	}
}
