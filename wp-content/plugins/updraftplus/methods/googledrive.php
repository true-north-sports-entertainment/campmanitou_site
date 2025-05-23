<?php

if (!defined('UPDRAFTPLUS_DIR')) die('No direct access allowed.');

// Converted to multi-options (Feb 2017-) and previous options conversion removed: Yes

if (!class_exists('UpdraftPlus_BackupModule')) updraft_try_include_file('methods/backup-module.php', 'require_once');

class UpdraftPlus_BackupModule_googledrive extends UpdraftPlus_BackupModule {

	private $client;

	private $ids_from_paths = array();

	private $client_id;

	private $callback_url;
	
	private $multi_directories = array();
	
	private $registered_prune = array();

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->client_id = defined('UPDRAFTPLUS_GOOGLEDRIVE_CLIENT_ID') ? UPDRAFTPLUS_GOOGLEDRIVE_CLIENT_ID : '916618189494-u3ehb1fl7u3meb63nb2b4fqi0r9pcfe2.apps.googleusercontent.com';
		$this->callback_url = defined('UPDRAFTPLUS_GOOGLEDRIVE_CALLBACK_URL') ? UPDRAFTPLUS_GOOGLEDRIVE_CALLBACK_URL : 'https://auth.updraftplus.com/auth/googledrive';

		if (class_exists('UpdraftPlus_Addon_Google_Enhanced')) {
			add_action('updraftplus_admin_enqueue_scripts', array($this, 'admin_footer_jstree'));
		}
	}

	public function action_auth() {
		if (isset($_GET['state'])) {

			$parts = explode(':', $_GET['state']);
			$state = $parts[0];

			if ('success' == $state) {

				if (isset($_GET['user_id']) && isset($_GET['access_token'])) {
					$code = array(
						'user_id' => $_GET['user_id'],
						'access_token' => $_GET['access_token']
					);
					
					if (isset($_GET['scope'])) {
						$scope = $_GET['scope'];
						$code['scope'] = explode(' ', $scope);
					}
				} else {
					$code = array();
				}

				$this->do_complete_authentication($state, $code);

			} elseif ('token' == $state) {
				$this->gdrive_auth_token();
			} elseif ('revoke' == $state) {
				$this->gdrive_auth_revoke();
			}
		} elseif (isset($_GET['updraftplus_googledriveauth'])) {
			if ('doit' == $_GET['updraftplus_googledriveauth']) {
				$this->action_authenticate_storage();
			} elseif ('deauth' == $_GET['updraftplus_googledriveauth']) {
				$this->action_deauthenticate_storage();
			}
		}
	}

	/**
	 * This method overrides the parent method and lists the supported features of this remote storage option.
	 *
	 * @return Array - an array of supported features (any features not mentioned are asuumed to not be supported)
	 */
	public function get_supported_features() {
		// This options format is handled via only accessing options via $this->get_options()
		return array('multi_options', 'config_templates', 'multi_storage', 'conditional_logic', 'manual_authentication');
	}

	/**
	 * Retrieve default options for this remote storage module.
	 *
	 * @return Array - an array of options
	 */
	public function get_default_options() {
		// parentid is deprecated since April 2014; it should not be in the default options (its presence is used to detect an upgraded-from-previous-SDK situation). For the same reason, 'folder' is also unset; which enables us to know whether new-style settings have ever been set.
		return array(
			'clientid' => '',
			'secret' => '',
			'token' => '',
		);
	}

	/**
	 * Check whether options have been set up by the user, or not
	 *
	 * @param Array $opts - the potential options
	 *
	 * @return Boolean
	 */
	public function options_exist($opts) {
		if (is_array($opts) && (!empty($opts['user_id']) || !empty($opts['token']))) return true;
		return false;
	}

	/**
	 * Get the Google folder ID for the root of the drive
	 *
	 * @return String|Integer
	 */
	private function root_id() {
		return $this->get_storage()->about->get()->getRootFolderId();
	}

	/**
	 * Get folder id from path
	 *
	 * @param String  $path		   folder path
	 * @param Boolean $one_only	   if false, then will be returned as a list (Google Drive allows multiple entities with the same name)
	 * @param Integer $retry_count how many times to retry upon a network failure
	 *
	 * @return Array|String|Integer|Boolean internal id of the Google Drive folder (or list of them if $one_only was false), or false upon failure
	 */
	public function id_from_path($path, $one_only = true, $retry_count = 3) {
		$storage = $this->get_storage();

		try {

			while ('/' == substr($path, 0, 1)) {
				$path = substr($path, 1);
			}

			$cache_key = empty($path) ? '/' : ($one_only ? $path : 'multi:'.$path);
			if (isset($this->ids_from_paths[$this->get_instance_id()][$cache_key])) return $this->ids_from_paths[$this->get_instance_id()][$cache_key];

			$current_parent_id = $this->root_id();
			$current_path = '/';

			if (!empty($path)) {
				$nodes = explode('/', $path);
				foreach ($nodes as $element) {
					$found = array();
					$sub_items = $this->get_subitems($current_parent_id, 'dir', $element);

					foreach ($sub_items as $item) {
						try {
							if ($item->getTitle() == $element) {
								$current_path .= $element.'/';
								$current_parent_id = $item->getId();
								$found[$current_parent_id] = strtotime($item->getCreatedDate());
							}
						} catch (Exception $e) {
							$this->log("id_from_path: exception: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
						}
					}
					
					if (count($found) > 1) {
						asort($found);
						reset($found);
						$current_parent_id = key($found);
					} elseif (empty($found)) {
						$ref = new UDP_Google_Service_Drive_ParentReference;
						$ref->setId($current_parent_id);
						$dir = new UDP_Google_Service_Drive_DriveFile();
						$dir->setMimeType('application/vnd.google-apps.folder');
						$dir->setParents(array($ref));
						$dir->setTitle($element);
						$this->log('creating path: '.$current_path.$element);
						$dir = $storage->files->insert(
							$dir,
							array('mimeType' => 'application/vnd.google-apps.folder')
						);
						$current_path .= $element.'/';
						$current_parent_id = $dir->getId();
					}
				}
			}

			if (empty($this->ids_from_paths[$this->get_instance_id()])) $this->ids_from_paths[$this->get_instance_id()] = array();
			$this->ids_from_paths[$this->get_instance_id()][$cache_key] = ($one_only || empty($found) || 1 == count($found)) ? $current_parent_id : $found;

			return $this->ids_from_paths[$this->get_instance_id()][$cache_key];

		} catch (Exception $e) {
			$msg = $e->getMessage();
			$this->log("id_from_path failure: exception (".get_class($e)."): ".$msg.' (line: '.$e->getLine().', file: '.$e->getFile().')');
			if (is_a($e, 'UDP_Google_Service_Exception') && false !== strpos($msg, 'Invalid json in service response') && function_exists('mb_strpos')) {
				// Aug 2015: saw a case where the gzip-encoding was not removed from the result
				// https://stackoverflow.com/questions/10975775/how-to-determine-if-a-string-was-compressed
				// @codingStandardsIgnoreLine
				$is_gzip = (false !== mb_strpos($msg, "\x1f\x8b\x08"));
				if ($is_gzip) $this->log("Error: Response appears to be gzip-encoded still; something is broken in the client HTTP stack, and you should define UPDRAFTPLUS_GOOGLEDRIVE_DISABLEGZIP as true in your wp-config.php to overcome this.");
			}
			$retry_count--;
			$this->log("id_from_path: retry ($retry_count)");
			if ($retry_count > 0) {
				$delay_in_seconds = defined('UPDRAFTPLUS_GOOGLE_DRIVE_GET_FOLDER_ID_SECOND_RETRY_DELAY') ? UPDRAFTPLUS_GOOGLE_DRIVE_GET_FOLDER_ID_SECOND_RETRY_DELAY : 5-$retry_count;
				sleep($delay_in_seconds);
				return $this->id_from_path($path, $one_only, $retry_count);
			}
			return false;
		}
	}

	/**
	 * Runs upon the WP action updraftplus_prune_retained_backups_finished
	 */
	public function prune_retained_backups_finished() {
		if (empty($this->multi_directories[$this->get_instance_id()]) || count($this->multi_directories[$this->get_instance_id()]) < 2) return;
		$storage = $this->bootstrap();
		if (false == $storage || is_wp_error($storage)) return;
		foreach (array_keys($this->multi_directories[$this->get_instance_id()]) as $drive_id) {
			if (!isset($oldest_reference)) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UndefinedVariable -- The variable is defined below.
				$oldest_id = $drive_id;
				$oldest_reference = new UDP_Google_Service_Drive_ParentReference;
				$oldest_reference->setId($oldest_id);
				continue;
			}

			// All found files should be moved to the oldest folder
			
			try {
				$sub_items = $this->get_subitems($drive_id, 'file');
			} catch (Exception $e) {
				$this->log('list files: failed to access chosen folder:  '.$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
			}

			$without_errors = true;
			
			foreach ($sub_items as $item) {
				$title = "(unknown)";
				try {
					$title = $item->getTitle();
					
					$this->log("Moving: $title (".$item->getId().") from duplicate folder $drive_id to $oldest_id");
					
					$file = new UDP_Google_Service_Drive_DriveFile();
					$file->setParents(array($oldest_reference));
					
					$storage->files->patch($item->getId(), $file);
					
				} catch (Exception $e) {
					$this->log("move: exception: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
					$without_errors = false;
					continue;
				}
			}
			
			if ($without_errors) {
				if (!empty($sub_items)) {
					try {
						$sub_items = $this->get_subitems($drive_id, 'file');
					} catch (Exception $e) {
						$this->log('list files: failed to access chosen folder:  '.$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
					}
				}
				if (empty($sub_items)) {
					try {
						$storage->files->delete($drive_id);
						$this->log("removed empty duplicate folder ($drive_id)");
					} catch (Exception $e) {
						$this->log("delete empty duplicate folder ($drive_id): exception: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
						continue;
					}
				}
			}
			
		}
	}
	
	/**
	 * Get the Google Drive internal ID
	 *
	 * @param Array	  $opts		- storage instance options
	 * @param Boolean $one_only - whether to potentially return them all if there is more than one
	 *
	 * @return String|Array
	 */
	private function get_parent_id($opts, $one_only = true) {

		$storage = $this->get_storage();

		$filtered = apply_filters('updraftplus_googledrive_parent_id', false, $opts, $storage, $this, $one_only);
		if (!empty($filtered)) return $filtered;
		if (isset($opts['parentid'])) {
			if (empty($opts['parentid'])) {
				return $this->root_id();
			} else {
				$parent = is_array($opts['parentid']) ? $opts['parentid']['id'] : $opts['parentid'];
			}
		} else {
			$folder = !empty($opts['folder']) ? $opts['folder'] : 'UpdraftPlus';
			$parent = $this->id_from_path($folder, $one_only);
		}
		return empty($parent) ? $this->root_id() : $parent;
	}

	/**
	 * List files or folders on Google Drive.
	 *
	 * @param string $match      The file or folder name to search for (default: 'backup_').
	 * @param bool   $list_files Whether to search for files (true) or folders (false) (default: true).
	 *
	 * @return array|WP_Error  An array of results containing information about matching files or folders,
	 *                        or a WP_Error object if there are missing settings,
	 *                        or an error occurs while accessing Google Drive.
	 *                        Each result is represented as an associative array with the following keys:
	 *                        - 'name' (string): The name of the file or folder.
	 *                        - 'size' (int, optional): The size of the file in bytes (only for files).
	 *                        - 'id' (string, optional): The unique identifier of the folder (only for folders).
	 */
	public function list_files_or_folders($match = 'backup_', $list_files = true) {

		$opts = $this->get_options();

		$use_master = $this->use_master($opts);

		if (!$use_master) {
			if (empty($opts['secret']) || empty($opts['clientid']) || empty($opts['clientid'])) return new WP_Error('no_settings', sprintf(__('No %s settings were found', 'updraftplus'), __('Google Drive', 'updraftplus')));
		} else {
			if (empty($opts['user_id']) || empty($opts['tmp_access_token'])) return new WP_Error('no_settings', sprintf(__('No %s settings were found', 'updraftplus'), __('Google Drive', 'updraftplus')));
		}

		$storage = $this->bootstrap();
		if (is_wp_error($storage) || false == $storage) return $storage;

		try {
			if ($list_files) {
				$parent_id = $this->get_parent_id($opts);
				$sub_items = $this->get_subitems($parent_id, 'file');
			} else {
				$sub_items = $this->get_subitems($match, 'dir', '');
			}

		} catch (Exception $e) {
			return new WP_Error(__('Google Drive list files: failed to access parent folder', 'updraftplus').":  ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
		}

		$results = array();

		foreach ($sub_items as $item) {
			$title = "(unknown)";
			try {
				$title = $item->getTitle();
				if ($list_files) {
					if (0 === strpos($title, $match)) {
						$results[] = array('name' => $title, 'size' => $item->getFileSize());
					}
				} else {
					$results[] = array('name' => $title, 'id' => $item->getId());
				}
			} catch (Exception $e) {
				$this->log("list: exception: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
				continue;
			}
		}

		return $results;
	}

	/**
	 * List folders in Google Drive.
	 *
	 * @param string $search - The folder to search for (default: 'root').
	 * @return array $results - An array of folder information.
	 */
	public function list_folders($search = 'root') {
		return $this->list_files_or_folders($search, false);
	}

	/**
	 * List files in Google Drive.
	 *
	 * @param string $search - The files to search for (default: 'backup_').
	 * @return array $results - An array of file information.
	 */
	public function listfiles($search = 'backup_') {
		return $this->list_files_or_folders($search);
	}

	/**
	 * Get a Google account access token using the refresh token
	 *
	 * @param  String $refresh_token Specify refresh token
	 * @param  String $client_id 	 Specify Client ID
	 * @param  String $client_secret Specify client secret
	 * @return Boolean
	 */
	private function access_token($refresh_token, $client_id, $client_secret) {

		$this->log("requesting access token: client_id=$client_id");

		$query_body = array(
			'refresh_token' => $refresh_token,
			'client_id' => $client_id,
			'client_secret' => $client_secret,
			'grant_type' => 'refresh_token'
		);

		$result = wp_remote_post('https://accounts.google.com/o/oauth2/token',
			array(
				'timeout' => '20',
				'method' => 'POST',
				'body' => $query_body
			)
		);

		if (is_wp_error($result)) {
			$this->log("error when requesting access token");
			foreach ($result->get_error_messages() as $msg) $this->log("Error message: $msg");
			return false;
		} else {
			$json_values = json_decode(wp_remote_retrieve_body($result), true);
			if (isset($json_values['access_token'])) {
				$this->log("successfully obtained access token");
				return $json_values['access_token'];
			} else {
				$response = json_decode($result['body'], true);
				if (!empty($response['error']) && 'deleted_client' == $response['error']) {
					$this->log(__('The client has been deleted from the Google Drive API console.', 'updraftplus').' '.__('Please create a new Google Drive project and reconnect with UpdraftPlus.', 'updraftplus'), 'error');
				}
				$error_code = empty($response['error']) ? 'no error code' : $response['error'];
				$this->log("error ($error_code) when requesting access token: response does not contain access_token. Response: ".(is_string($result['body']) ? str_replace("\n", '', $result['body']) : json_encode($result['body'])));
				return false;
			}
		}
	}

	/**
	 * This method will return a redirect URL depending on the parameter passed. It will either return the redirect for the user's site or the auth server.
	 *
	 * @param  Boolean $master - indicate whether we want the master redirect URL
	 * @return String          - a redirect URL
	 */
	private function redirect_uri($master = false) {
		if ($master) {
			return $this->callback_url;
		} else {
			return UpdraftPlus_Options::admin_page_url().'?action=updraftmethod-googledrive-auth';
		}
	}

	/**
	 * Acquire single-use authorization code from Google via OAuth 2.0
	 *
	 * @param  String $instance_id - the instance id of the settings we want to authenticate
	 */
	public function do_authenticate_storage($instance_id) {
		$opts = $this->get_options();

		$use_master = $this->use_master($opts);

		// First, revoke any existing token, since Google doesn't appear to like issuing new ones
		if (!empty($opts['token']) && !$use_master) $this->gdrive_auth_revoke();

		// Set a flag so we know this authentication is in progress
		$opts['auth_in_progress'] = true;
		$this->set_options($opts, true);

		$prefixed_instance_id = ':' . $instance_id;
		
		// We use 'force' here for the approval_prompt, not 'auto', as that deals better with messy situations where the user authenticated, then changed settings

		if ($use_master) {
			$client_id = $this->client_id;
			$token = 'token'.$prefixed_instance_id;
			$token .= $this->redirect_uri();
		} else {
			$client_id = $opts['clientid'];
			$token = 'token'.$prefixed_instance_id;
		}
		// We require access to all Google Drive files (not just ones created by this app - scope https://www.googleapis.com/auth/drive.file) - because we need to be able to re-scan storage for backups uploaded by other installs, or manually by the user into their Google Drive. But, if you are happy to lose that capability, you can use the filter below to remove the drive.readonly scope.
		$params = array(
			'response_type' => 'code',
			'client_id' => $client_id,
			'redirect_uri' => $this->redirect_uri($use_master),
			// Nov 2024 - https://www.googleapis.com/auth/drive.readonly temporarily removed for annual re-verification (for which we received no notification)
			'scope' => apply_filters('updraft_googledrive_scope', 'https://www.googleapis.com/auth/drive.file https://www.googleapis.com/auth/userinfo.profile'),
			'state' => $token,
			'access_type' => 'offline',
			// 'approval_prompt' => 'force', // legacy and has been deprected. It can lead to conflicts when specified along with "prompt" param
			// Nov 2024 - changed from `true` for the same reason as a few lines earlier
			'include_granted_scopes' => 'false',
			'enable_granular_consent' => 'true',
			'prompt' => 'select_account consent', // new option param as the replacement to 'approval_prompt'
		);
		$params = apply_filters('updraft_googledrive_auth_params', $params);
		if (headers_sent()) {
			$this->log(sprintf(__('The %s authentication could not go ahead, because something else on your site is breaking it.', 'updraftplus'), 'Google Drive').' '.__('Try disabling your other plugins and switching to a default theme.', 'updraftplus').' ('.__('Specifically, you are looking for the component that sends output (most likely PHP warnings/errors) before the page begins.', 'updraftplus').' '.__('Turning off any debugging settings may also help).', 'updraftplus').')', 'error');
		} else {
			header('Location: https://accounts.google.com/o/oauth2/auth?'.http_build_query($params, '', '&'));
		}
	}

	/**
	 * This function will complete the oAuth flow, if return_instead_of_echo is true then add the action to display the authed admin notice, otherwise echo this notice to page.
	 *
	 * @param string  $state                  - the state
	 * @param string  $code                   - the oauth code
	 * @param boolean $return_instead_of_echo - a boolean to indicate if we should return the result or echo it
	 *
	 * @return void|string - returns the authentication message if return_instead_of_echo is true
	 */
	public function do_complete_authentication($state, $code, $return_instead_of_echo = false) {
		
		// If these are set then this is a request from our master app and the auth server has returned these to be saved.
		if (isset($code['user_id']) && isset($code['access_token'])) {
			$opts = $this->get_options();
			$opts['user_id'] = base64_decode($code['user_id']);
			$opts['tmp_access_token'] = base64_decode($code['access_token']);
			if (isset($opts['auth_in_progress'])) $opts['scope'] = $code['scope'];
			// Unset this value if it is set as this is a fresh auth we will set this value in the next step
			if (isset($opts['expires_in'])) unset($opts['expires_in']);
			// remove our flag so we know this authentication is complete
			if (isset($opts['auth_in_progress'])) unset($opts['auth_in_progress']);
			$this->set_options($opts, true);
		}

		if ($return_instead_of_echo) {
			return $this->show_authed_admin_success($return_instead_of_echo);
		} else {
			add_action('all_admin_notices', array($this, 'show_authed_admin_success'));
		}
	}

	/**
	 * Revoke a Google account refresh token
	 * Returns the parameter fed in, so can be used as a WordPress options filter
	 * Can be called statically from UpdraftPlus::googledrive_clientid_checkchange()
	 *
	 * @param  Boolean $unsetopt unset options is set to true unless otherwise specified
	 */
	public function gdrive_auth_revoke($unsetopt = true) {
		$opts = $this->get_options();
		$result = wp_remote_get('https://accounts.google.com/o/oauth2/revoke?token='.$opts['token']);
		
		// If the call to revoke the token fails, we try again one more time
		if (is_wp_error($result) || 200 != wp_remote_retrieve_response_code($result)) {
			wp_remote_get('https://accounts.google.com/o/oauth2/revoke?token='.$opts['token']);
		}

		if ($unsetopt) {
			$opts['token'] = '';
			unset($opts['ownername']);
			$this->set_options($opts, true);
		}
	}

	/**
	 * Get a Google account refresh token using the code received from do_authenticate_storage
	 */
	public function gdrive_auth_token() {
		$opts = $this->get_options();
		if (isset($_GET['code'])) {
			$post_vars = array(
				'code' => $_GET['code'],
				'client_id' => $opts['clientid'],
				'client_secret' => $opts['secret'],
				'redirect_uri' => UpdraftPlus_Options::admin_page_url().'?action=updraftmethod-googledrive-auth',
				'grant_type' => 'authorization_code'
			);

			$result = wp_remote_post('https://accounts.google.com/o/oauth2/token', array('timeout' => 25, 'method' => 'POST', 'body' => $post_vars));

			if (is_wp_error($result)) {
				$add_to_url = "Bad response when contacting Google: ";
				foreach ($result->get_error_messages() as $message) {
					$this->log("authentication error: ".$message);
					$add_to_url .= $message.". ";
				}
				header('Location: '.UpdraftPlus_Options::admin_page_url().'?page=updraftplus&error='.urlencode($add_to_url));
			} else {
				$json_values = json_decode(wp_remote_retrieve_body($result), true);
				if (isset($json_values['refresh_token'])) {

					 // Save token
					$opts['token'] = $json_values['refresh_token'];
					$this->set_options($opts, true);

					if (isset($json_values['access_token'])) {
						$opts['tmp_access_token'] = $json_values['access_token'];
						$this->set_options($opts, true);
						// We do this to clear the GET parameters, otherwise WordPress sticks them in the _wp_referer in the form and brings them back, leading to confusion + errors
						header('Location: '.UpdraftPlus_Options::admin_page_url().'?action=updraftmethod-googledrive-auth&page=updraftplus&state=success:'.urlencode($this->get_instance_id()));
					}

				} else {

					$msg = __('No refresh token was received from Google.', 'updraftplus').' '.__('This often means that you entered your client secret wrongly, or that you have not yet re-authenticated (below) since correcting it.', 'updraftplus').' '.__('Re-check it, then follow the link to authenticate again.', 'updraftplus').' '.__('Finally, if that does not work, then use expert mode to wipe all your settings, create a new Google client ID/secret, and start again.', 'updraftplus');

					if (isset($json_values['error'])) $msg .= ' '.sprintf(__('Error: %s', 'updraftplus'), $json_values['error']);

					header('Location: '.UpdraftPlus_Options::admin_page_url().'?page=updraftplus&error='.urlencode($msg));
				}
			}
		} else {
			header('Location: '.UpdraftPlus_Options::admin_page_url().'?page=updraftplus&error='.urlencode(sprintf(__('%s authorization failed', 'updraftplus'), 'Google Drive')));
		}
	}

	/**
	 * This method will setup the authenticated admin warning, it can either return this or echo it
	 *
	 * @param boolean $return_instead_of_echo - a boolean to indicate if we should return the result or echo it
	 *
	 * @return void|string - returns the authentication message if return_instead_of_echo is true
	 */
	public function show_authed_admin_success($return_instead_of_echo) {

		global $updraftplus_admin;

		$opts = $this->get_options();

		if (empty($opts['tmp_access_token'])) return;
		$updraftplus_tmp_access_token = $opts['tmp_access_token'];

		$message = '';
		try {
			$storage = $this->bootstrap($updraftplus_tmp_access_token);
			if (false != $storage && !is_wp_error($storage)) {

				$about = $storage->about->get();
				$quota_total = max($about->getQuotaBytesTotal(), 1);
				$quota_used = $about->getQuotaBytesUsed();
				$username = $about->getName();
				$get_user = $about->getUser();
				$email = is_object($get_user) ? $get_user->emailAddress : '';
				$opts['ownername'] = $username;
				$opts['owneremail'] = $email;

				if (is_numeric($quota_total) && is_numeric($quota_used)) {
					$available_quota = $quota_total - $quota_used;
					$used_perc = round($quota_used*100/$quota_total, 1);
					$message .= sprintf(__('Your %s quota usage: %s %% used, %s available', 'updraftplus'), 'Google Drive', $used_perc, round($available_quota/1048576, 1).' MB');
				}
			} elseif (is_wp_error($storage)) {
				$message .= __('However, subsequent access attempts failed:', 'updraftplus');
				$error_codes = $storage->get_error_codes();
				$message .= '<ul style="list-style: disc inside;">';
				foreach ($error_codes as $error_code) {
					$message .= '<li>';
					$message .= $storage->get_error_message($error_code).' ('.$error_code.')';
					$message .= '</li>';
				}
				$message .= '</ul>';
			}
		} catch (Exception $e) {
			if (is_a($e, 'UDP_Google_Service_Exception')) {
				$errs = $e->getErrors();
				$message .= __('However, subsequent access attempts failed:', 'updraftplus');
				if (is_array($errs)) {
					$message .= '<ul style="list-style: disc inside;">';
					foreach ($errs as $err) {
						$message .= '<li>';
						if (!empty($err['reason'])) $message .= '<strong>'.htmlspecialchars($err['reason']).':</strong> ';
						if (!empty($err['message'])) {
							$message .= htmlspecialchars($err['message']);
						} else {
							$message .= htmlspecialchars(serialize($err));
						}
						$message .= '</li>';
					}
					$message .= '</ul>';
				} else {
					$message .= htmlspecialchars(serialize($errs));
				}
			}
		}

		unset($opts['tmp_access_token']);
		$this->set_options($opts, true);

		$final_message = __('Success', 'updraftplus').': '.sprintf(__('you have authenticated your %s account.', 'updraftplus'), __('Google Drive', 'updraftplus')).' '.((!empty($username)) ? sprintf(__('Name: %s.', 'updraftplus'), $username).' ' : '').$message;

		if ($return_instead_of_echo) {
			return "<div class='updraftmessage updated'><p>{$final_message}</p></div>";
		} else {
			$updraftplus_admin->show_admin_warning($final_message);
		}
	}

	/**
	 * This function just does the formalities, and off-loads the main work to upload_file
	 *
	 * @param  array $backup_array
	 */
	public function backup($backup_array) {

		global $updraftplus;

		$storage = $this->bootstrap();
		if (false == $storage || is_wp_error($storage)) return $storage;

		$updraft_dir = trailingslashit($updraftplus->backups_dir_location());

		$opts = $this->get_options();

		try {
			$parent_ids = $this->get_parent_id($opts, false);
			if (is_array($parent_ids)) {
				reset($parent_ids);
				$parent_id = key($parent_ids);
				if (count($parent_ids) > 1) {
					$this->log('there appears to be more than one folder: '.implode(', ', array_keys($parent_ids)));
					if (empty($this->registered_prune[$this->get_instance_id()])) {
						$this->registered_prune[$this->get_instance_id()] = true;
						$this->multi_directories[$this->get_instance_id()] = $parent_ids;
						add_action('updraftplus_prune_retained_backups_finished', array($this, 'prune_retained_backups_finished'));
					}
				}
			} else {
				$parent_id = $parent_ids;
			}
		} catch (Exception $e) {
			$this->log("upload: failed to access parent folder: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
			$this->log(sprintf(__('Failed to upload to %s', 'updraftplus'), __('Google Drive', 'updraftplus')).': '.__('failed to access parent folder', 'updraftplus').' ('.$e->getMessage().')', 'error');
			return false;
		}

		foreach ($backup_array as $file) {

			$available_quota = -1;
			
			do {
				try {
					$try_again = false;
					$about = $storage->about->get();
					$quota_total = max($about->getQuotaBytesTotal(), 1);
					$quota_used = $about->getQuotaBytesUsed();
					$available_quota = $quota_total - $quota_used;
					$message = "quota usage: used=".round($quota_used/1048576, 1)." MB, total=".round($quota_total/1048576, 1)." MB, available=".round($available_quota/1048576, 1)." MB";
					$this->log($message);
				} catch (Exception $e) {
					$msg = $e->getMessage();
					$this->log("quota usage: failed to obtain this information: ".$msg);
					
					// If the issue was a problem refreshing the OAuth2 token, bootstrap again and try again
					if (false !== strpos($msg, 'Error refreshing the OAuth2 token')) {
						$this->log("quota usage: will attempt to refresh OAuth2 token and fetch this information again");
						$this->set_storage(null);
						$storage = $this->bootstrap();
						if (false == $storage || is_wp_error($storage)) return $storage;
						
						$try_again = true;
					}
				}
			} while ($try_again);

			$file_path = $updraft_dir.$file;
			$file_name = basename($file_path);
			$this->log("$file_name: Attempting to upload to Google Drive (into folder id: $parent_id)");

			$filesize = filesize($file_path);
			$already_failed = false;
			if (-1 != $available_quota) {
				if ($filesize > $available_quota) {
					$already_failed = true;
					$this->log("File upload expected to fail: file ($file_name) size is $filesize b, whereas available quota is only $available_quota b");
					$this->log(sprintf(__("Account full: your %s account has only %d bytes left, but the file to be uploaded is %d bytes", 'updraftplus'), __('Google Drive', 'updraftplus'), $available_quota, $filesize), 'error');
				}
			}

			if (!$already_failed && $filesize > 10737418240) {
				// 10GB
				$this->log("File upload expected to fail: file ($file_name) size is $filesize b (".round($filesize/1073741824, 4)." GB), whereas Google Drive's limit is 10GB (1073741824 bytes)");
				$this->log(sprintf(__("Upload expected to fail: the %s limit for any single file is %s, whereas this file is %s GB (%d bytes)", 'updraftplus'), __('Google Drive', 'updraftplus'), '10GB (1073741824)', round($filesize/1073741824, 4), $filesize), 'warning');
			}

			do {
				try {
					$try_again = false;
					$timer_start = microtime(true);
					if ($this->upload_file($file_path, $parent_id)) {
						$this->log('OK: Archive ' . $file_name . ' uploaded in ' . (round(microtime(true) - $timer_start, 2)) . ' seconds');
						$updraftplus->uploaded_file($file);
					} else {
						$this->log("ERROR: $file_name: Failed to upload");
						$this->log("$file_name: ".sprintf(__('Failed to upload to %s', 'updraftplus'), __('Google Drive', 'updraftplus')), 'error');
					}
				} catch (Exception $e) {
					$msg = $e->getMessage();
					$this->log("Upload exception (".get_class($e)."): $msg (line: ".$e->getLine().', file: '.$e->getFile().')');
					
					// If the issue was a problem refreshing the OAuth2 token, bootstrap again and try again
					if (false !== ($p = strpos($msg, 'Error refreshing the OAuth2 token'))) {
						$this->log("$file_name: will attempt to refresh OAuth2 token and upload again");
						$this->set_storage(null);
						$storage = $this->bootstrap();
						if (false == $storage || is_wp_error($storage)) return $storage;
						
						$try_again = true;
					} else {
						if (false !== ($p = strpos($msg, 'The user has exceeded their Drive storage quota'))) {
							$this->log("$file_name: ".sprintf(__('Failed to upload to %s', 'updraftplus'), __('Google Drive', 'updraftplus')).': '.substr($msg, $p), 'error');
						} else {
							$this->log("$file_name: ".sprintf(__('Failed to upload to %s', 'updraftplus'), __('Google Drive', 'updraftplus')), 'error');
						}
						$this->client->setDefer(false);
					}
				}
			} while ($try_again);
		}

		return null;
	}

	public function bootstrap($access_token = false) {
		$storage = $this->get_storage();

		if (!empty($storage) && is_object($storage) && is_a($storage, 'UDP_Google_Service_Drive')) return $storage;

		$opts = $this->get_options();

		$use_master = $this->use_master($opts);

		$curl_exists = function_exists('curl_version') && function_exists('curl_exec');

		if (!$use_master) {
			if (empty($opts['token']) || empty($opts['clientid']) || empty($opts['secret'])) {
				$this->log('this account is not authorised');
				$this->log(__('Account is not authorized.', 'updraftplus'), 'error', 'googledrivenotauthed');
				return new WP_Error('not_authorized', __('Account is not authorized.', 'updraftplus').' (Google Drive)');
			}

			if (empty($access_token)) {
				$access_token = $this->access_token($opts['token'], $opts['clientid'], $opts['secret']);
			}
		} else {

			if (empty($opts['user_id'])) {
				$this->log('this account is not authorised');
				$this->log(__('Account is not authorized.', 'updraftplus'), 'error', 'googledrivenotauthed');
				return new WP_Error('not_authorized', __('Account is not authorized.', 'updraftplus'));
			}

			if (!isset($opts['expires_in']) || $opts['expires_in'] < time()) {

				$user_id = empty($opts['user_id']) ? '' : $opts['user_id'];

				$args = array(
					'code' => 'ud_googledrive_code',
					'user_id' => $user_id,
				);

				$result = wp_remote_post($this->callback_url, array(
					'timeout' => 60,
					'headers' => apply_filters('updraftplus_auth_headers', ''),
					'body' => $args
				));

				if (is_wp_error($result)) {
				
					$body = array('result' => 'error', 'error' => $result->get_error_code(), 'error_description' => $result->get_error_message());
				
				} else {
					$response_code = wp_remote_retrieve_response_code($result);
					
					if ($response_code < 200 || $response_code >= 300) {
						$body = array('result' => 'error', 'error' => $response_code, 'error_description' => sprintf(__("%s for %s", 'updraftplus'), wp_remote_retrieve_response_message($result), $this->callback_url));
					} else {
						$body_json = wp_remote_retrieve_body($result);
						$body = json_decode($body_json, true);
					}
				}
				
				if (!empty($body['result']) && 'error' == $body['result']) {
				
					$access_token = new WP_Error($body['error'], empty($body['error_description']) ? __('Have not yet obtained an access token from Google - you need to authorise or re-authorise your connection to Google Drive.', 'updraftplus') : $body['error_description']);
				
				} else {
				
					$result_body_json = base64_decode($body[0]);
					$result_body = json_decode($result_body_json);

					if (isset($result_body->access_token)) {
						$access_token = array(
							'access_token' => $result_body->access_token,
							'created' => time(),
							'expires_in' => $result_body->expires_in,
							'refresh_token' => ''
						);

						$opts['tmp_access_token'] = $access_token;
						$opts['expires_in'] = $access_token['created'] + $access_token['expires_in'] - 30;
						$this->set_options($opts, true);
					} else {
						$access_token = '';
					}
				}
			} else {
				$access_token = $opts['tmp_access_token'];
			}
		}
		
		// Do we have an access token?
		if (empty($access_token) || is_wp_error($access_token)) {
			$message = 'ERROR: Have not yet obtained an access token from Google (has the user authorised?)';
			$extra = '';
			if (is_wp_error($access_token)) {
				$message .= ' ('.$access_token->get_error_message().') ('.$access_token->get_error_code().')';
				$extra = ' ('.$access_token->get_error_message().') ('.$access_token->get_error_code().')';
			}
			$this->log($message);
			$this->log(__('Have not yet obtained an access token from Google - you need to authorise or re-authorise your connection to Google Drive.', 'updraftplus').$extra, 'error');
			return $access_token;
		}

		$spl = spl_autoload_functions();
		if (is_array($spl)) {
			// Workaround for Google Drive CDN plugin's autoloader
			if (in_array('wpbgdc_autoloader', $spl)) spl_autoload_unregister('wpbgdc_autoloader');
			// http://www.wpdownloadmanager.com/download/google-drive-explorer/ - but also others, since this is the default function name used by the Google SDK
			if (in_array('google_api_php_client_autoload', $spl)) spl_autoload_unregister('google_api_php_client_autoload');
		}

		if ((!class_exists('UDP_Google_Config') || !class_exists('UDP_Google_Client') || !class_exists('UDP_Google_Service_Drive') || !class_exists('UDP_Google_Http_Request')) && !function_exists('google_api_php_client_autoload_updraftplus')) {
			updraft_try_include_file('includes/Google/autoload.php', 'include_once');
		}

		if (!class_exists('UpdraftPlus_Google_Http_MediaFileUpload')) {
			updraft_try_include_file('includes/google-extensions.php', 'include_once');
		}

		$config = new UDP_Google_Config();
		$config->setClassConfig('UDP_Google_IO_Abstract', 'request_timeout_seconds', 60);
		// In our testing, $storage->about->get() fails if gzip is not disabled when using the stream wrapper
		if (!$curl_exists || (defined('UPDRAFTPLUS_GOOGLEDRIVE_DISABLEGZIP') && UPDRAFTPLUS_GOOGLEDRIVE_DISABLEGZIP)) {
			$config->setClassConfig('UDP_Google_Http_Request', 'disable_gzip', true);
		}

		if (!$use_master) {
			$client_id = $opts['clientid'];
			$client_secret = $opts['secret'];
		} else {
			$client_id = $this->client_id;
			$client_secret = '';
		}

		$proxy = new WP_HTTP_Proxy();
		$client = new UDP_Google_Client($config);

		$is_proxy_enabled = false;
		if ($proxy->is_enabled() && $proxy->send_through_proxy($client->getBasePath())) {
			$is_proxy_enabled = true;
			if ($curl_exists && !defined('CURLOPT_PROXY')) {
				$this->log('cURL transports couldn\'t be used because a proxy is set but the installed cURL version doesn\'t support proxy connections. Stream/socket transports (UDP_Google_IO_Stream) are being used instead.');
				$config->setIoClass('UDP_Google_IO_Stream');
				// Redeclare the client to use UDP_Google_IO_Stream
				$client = new UDP_Google_Client($config);
			}
		}

		$client->setClientId($client_id);
		$client->setClientSecret($client_secret);
		// $client->setUseObjects(true);

		if (!$use_master) {
			$client->setAccessToken(json_encode(array(
				'access_token' => $access_token,
				'refresh_token' => $opts['token']
			)));
		} else {
			$client->setAccessToken(json_encode($access_token));
		}

		$io = $client->getIo();
		$setopts = array();

		if (is_a($io, 'UDP_Google_IO_Curl')) {
			$setopts[CURLOPT_SSL_VERIFYPEER] = UpdraftPlus_Options::get_updraft_option('updraft_ssl_disableverify') ? false : true;
			if (!UpdraftPlus_Options::get_updraft_option('updraft_ssl_useservercerts')) $setopts[CURLOPT_CAINFO] = UPDRAFTPLUS_DIR.'/includes/cacert.pem';
			// Raise the timeout from the default of 15
			$setopts[CURLOPT_TIMEOUT] = 60;
			$setopts[CURLOPT_CONNECTTIMEOUT] = 15;
			if (defined('UPDRAFTPLUS_IPV4_ONLY') && UPDRAFTPLUS_IPV4_ONLY) $setopts[CURLOPT_IPRESOLVE] = CURL_IPRESOLVE_V4;
			$setopts[CURLOPT_HTTP_VERSION] = defined('UPDRAFTPLUS_GDRIVE_CURL_HTTP_VERSION') ? UPDRAFTPLUS_GDRIVE_CURL_HTTP_VERSION : CURL_HTTP_VERSION_1_1;

			if ($is_proxy_enabled) {
				$port = (int) $proxy->port();
				if (empty($port)) $port = 8080;

				$setopts[CURLOPT_PROXY] = $proxy->host();
				$setopts[CURLOPT_PROXYPORT] = $port;
				$setopts[CURLOPT_PROXYTYPE] = CURLPROXY_HTTP;
			}
		} elseif (is_a($io, 'UDP_Google_IO_Stream')) {
			$setopts['timeout'] = 60;
			// We had to modify the SDK to support this
			// https://wiki.php.net/rfc/tls-peer-verification - before PHP 5.6, there is no default CA file
			if (!UpdraftPlus_Options::get_updraft_option('updraft_ssl_useservercerts') || (version_compare(PHP_VERSION, '5.6.0', '<'))) $setopts['cafile'] = UPDRAFTPLUS_DIR.'/includes/cacert.pem';
			if (UpdraftPlus_Options::get_updraft_option('updraft_ssl_disableverify')) $setopts['disable_verify_peer'] = true;

			if ($is_proxy_enabled) {
				$port = (int) $proxy->port();
				if (empty($port)) $port = 8080;

				$setopts['proxy'] = $proxy->host().':'.$port;
			}
		}

		$io->setOptions($setopts);

		$storage = new UDP_Google_Service_Drive($client);
		$this->client = $client;
		$this->set_storage($storage);
		
		try {
			// Get the folder name, if not previously known (this is for the legacy situation where an id, not a name, was stored)
			if (!empty($opts['parentid']) && (!is_array($opts['parentid']) || empty($opts['parentid']['name']))) {
				$rootid = $this->root_id();
				$title = '';
				$parentid = is_array($opts['parentid']) ? $opts['parentid']['id'] : $opts['parentid'];
				while ((!empty($parentid) && $parentid != $rootid)) {
					$resource = $storage->files->get($parentid);
					$title = ($title) ? $resource->getTitle().'/'.$title : $resource->getTitle();
					$parents = $resource->getParents();
					if (is_array($parents) && count($parents)>0) {
						$parent = array_shift($parents);
						$parentid = is_a($parent, 'UDP_Google_Service_Drive_ParentReference') ? $parent->getId() : false;
					} else {
						$parentid = false;
					}
				}
				if (!empty($title)) {
					$opts['parentid'] = array(
						'id' => (is_array($opts['parentid']) ? $opts['parentid']['id'] : $opts['parentid']),
						'name' => $title
					);
					$this->set_options($opts, true);
				}
			}
		} catch (Exception $e) {
			$this->log("failed to obtain name of parent folder: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
		}

		return $storage;

	}
	
	/**
	 * Acts as a WordPress options filter
	 *
	 * @param  Array $google - An array of Google Drive options
	 * @return Array - the returned array can either be the set of updated Google Drive settings or a WordPress error array
	 */
	public function options_filter($google) {

		global $updraftplus;
	
		// Get the current options (and possibly update them to the new format)
		$opts = UpdraftPlus_Storage_Methods_Interface::update_remote_storage_options_format('googledrive');
		
		if (is_wp_error($opts)) {
			if ('recursion' !== $opts->get_error_code()) {
				$msg = "(".$opts->get_error_code()."): ".$opts->get_error_message();
				$this->log($msg);
				error_log("UpdraftPlus: Google Drive: $msg");
			}
			// The saved options had a problem; so, return the new ones
			return $google;
		}
		// $opts = UpdraftPlus_Options::get_updraft_option('updraft_googledrive');
		if (!is_array($google)) return $opts;

		// Remove instances that no longer exist
		foreach ($opts['settings'] as $instance_id => $storage_options) {
			if (!isset($google['settings'][$instance_id])) unset($opts['settings'][$instance_id]);
		}
		
		if (empty($google['settings'])) return $opts;

		foreach ($google['settings'] as $instance_id => $storage_options) {
			if (empty($opts['settings'][$instance_id]['user_id'])) {
				$old_client_id = (empty($opts['settings'][$instance_id]['clientid'])) ? '' : $opts['settings'][$instance_id]['clientid'];
				if (!empty($opts['settings'][$instance_id]['token']) && $old_client_id != $storage_options['clientid']) {
					updraft_try_include_file('methods/googledrive.php', 'include_once');
					$updraftplus->register_wp_http_option_hooks();
					$googledrive = new UpdraftPlus_BackupModule_googledrive();
					$googledrive->gdrive_auth_revoke(false);
					$updraftplus->register_wp_http_option_hooks(false);
					$opts['settings'][$instance_id]['token'] = '';
					unset($opts['settings'][$instance_id]['ownername']);
				}
			}

			foreach ($storage_options as $key => $value) {
				// Trim spaces - I got support requests from users who didn't spot the spaces they introduced when copy/pasting
				$opts['settings'][$instance_id][$key] = ('clientid' == $key || 'secret' == $key) ? trim($value) : $value;
			}
			if (isset($opts['settings'][$instance_id]['folder'])) {
				$opts['settings'][$instance_id]['folder'] = apply_filters('updraftplus_options_googledrive_foldername', 'UpdraftPlus', $opts['settings'][$instance_id]['folder']);
				unset($opts['settings'][$instance_id]['parentid']);
			}
		}
		return $opts;
	}

	/**
	 * This function checks if the user has any options for Google Drive saved or if they have defined to use a custom app and if they have we will not use the master Google Drive app and allow them to enter their own client ID and secret
	 *
	 * @param  Array $opts - the Google Drive options array
	 * @return Bool        - a bool value to indicate if we should use the master app or not
	 */
	protected function use_master($opts) {
		if ((!empty($opts['clientid']) && !empty($opts['secret'])) || (defined('UPDRAFTPLUS_CUSTOM_GOOGLEDRIVE_APP') && UPDRAFTPLUS_CUSTOM_GOOGLEDRIVE_APP)) return false;
		return true;
	}

	/**
	 * Returns array of UDP_Google_Service_Drive_DriveFile objects
	 *
	 * @param  String $parent_id This is the Parent ID
	 * @param  String $type 	 This is the type of file or directory but by default it is set to 'any' unless specified
	 * @param  String $match 	 This will specify which match is used for the SQL but by default it is set to 'backup_' unless specified
	 *
	 * @return Array - list of UDP_Google_Service_Drive_DriveFile items
	 */
	private function get_subitems($parent_id, $type = 'any', $match = 'backup_') {

		$storage = $this->get_storage();

		$q = '"'.$parent_id.'" in parents and trashed = false';

		if ('dir' == $type) {
			$q .= ' and mimeType = "application/vnd.google-apps.folder"';
		} elseif ('file' == $type) {
			$q .= ' and mimeType != "application/vnd.google-apps.folder"';
		}
		// We used to use 'contains' in both cases, but this exposed some bug that might be in the SDK or at the Google end - a result that matched for = was not returned with contains
		if (!empty($match)) {
			if ('backup_' == $match) {
				$q .= " and title contains '$match'";
			} else {
				$q .= " and title = '$match'";
			}
		}

		$result = array();
		$page_token = null;

		do {
			try {
				// Default for maxResults is 100
				$parameters = array('q' => $q, 'maxResults' => 200);
				if ($page_token) {
					$parameters['pageToken'] = $page_token;
				}
				$files = $storage->files->listFiles($parameters);

				$result = array_merge($result, $files->getItems());
				$page_token = $files->getNextPageToken();
			} catch (Exception $e) {
				$this->log("get_subitems: An error occurred (will not fetch further): " . $e->getMessage());
				$page_token = null;
			}
		} while ($page_token);
		
		return $result;
	}

	/**
	 * Delete a single file from the service using GoogleDrive API
	 *
	 * @param Array|String $files    - array of file names to delete
	 * @param Array        $data     - unused here
	 * @param Array        $sizeinfo - unused here
	 * @return Boolean|String - either a boolean true or an error code string
	 */
	public function delete($files, $data = null, $sizeinfo = array()) {// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- $data and $sizeinfo unused

		if (is_string($files)) $files = array($files);

		$storage = $this->bootstrap();
		if (is_wp_error($storage)) {
			$this->log("delete: failed due to storage error: ".$storage->get_error_code()." (".$storage->get_error_message().")");
			return 'service_unavailable';
		}
			
		if (false == $storage) return $storage;

		$opts = $this->get_options();

		try {
			$parent_id = $this->get_parent_id($opts);
			$sub_items = $this->get_subitems($parent_id, 'file');
		} catch (Exception $e) {
			$this->log("delete: failed to access parent folder: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
			return 'container_access_error';
		}

		$ret = true;

		foreach ($sub_items as $item) {
			$title = "(unknown)";
			try {
				$title = $item->getTitle();
				if (in_array($title, $files)) {
					$storage->files->delete($item->getId());
					$this->log("$title: Deletion successful");
					if (($key = array_search($title, $files)) !== false) {
						unset($files[$key]);
					}
				}
			} catch (Exception $e) {
				$this->log("delete: exception: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
				$ret = 'file_delete_error';
				continue;
			}
		}

		foreach ($files as $file) {
			$this->log("$file: Deletion failed: file was not found");
		}

		return $ret;

	}

	/**
	 * Used internally to upload files
	 *
	 * @param String  $file		 - the full path to the file to upload
	 * @param String  $parent_id - the internal Google Drive folder identifier
	 * @param Boolean $try_again - whether to retry in the event of a problem
	 *
	 * @return Boolean - success or failure state
	 */
	private function upload_file($file, $parent_id, $try_again = true) {

		global $updraftplus;
		$basename = basename($file);

		$storage = $this->get_storage();
		$client = $this->client;

		// See: https://github.com/google/google-api-php-client/blob/master/examples/fileupload.php (at time of writing, only shows how to upload in chunks, not how to resume)

		$client->setDefer(true);

		$local_size = filesize($file);

		$gdfile = new UDP_Google_Service_Drive_DriveFile();
		$gdfile->title  = $basename;

		$ref = new UDP_Google_Service_Drive_ParentReference;
		$ref->setId($parent_id);
		$gdfile->setParents(array($ref));

		$size = 0;
		$request = $storage->files->insert($gdfile);

		$chunk_size = 1048576;

		$transkey = 'resume_'.md5($file);
		// This is unset upon completion, so if it is set then we are resuming
		$possible_location = $this->jobdata_get($transkey, null, 'gd'.$transkey);

		if (is_array($possible_location)) {

			$headers = array('content-range' => "bytes */".$local_size);

			$http_request = new UDP_Google_Http_Request(
				$possible_location[0],
				'PUT',
				$headers,
				''
			);
			$response = $this->client->getIo()->makeRequest($http_request);
			$can_resume = false;
			
			$response_http_code = $response->getResponseHttpCode();
			
			if (200 == $response_http_code || 201 == $response_http_code) {
				$client->setDefer(false);
				$this->jobdata_delete($transkey, 'gd'.$transkey);
				$this->log("$basename: upload appears to be already complete (HTTP code: $response_http_code)");
				return true;
			}
			
			if (308 == $response_http_code) {
				$range = $response->getResponseHeader('range');
				if (!empty($range) && preg_match('/bytes=0-(\d+)$/', $range, $matches)) {
					$can_resume = true;
					$possible_location[1] = $matches[1]+1;
					$this->log("$basename: upload already began; attempting to resume from byte ".$matches[1]);
				}
			}
			if (!$can_resume) {
				$this->log("$basename: upload already began; attempt to resume did not succeed (HTTP code: ".$response_http_code.")");
			}
		}

		// UpdraftPlus_Google_Http_MediaFileUpload extends Google_Http_MediaFileUpload, with a few extra methods to change private properties to public ones
		$media = new UpdraftPlus_Google_Http_MediaFileUpload(
			$client,
			$request,
			(('.zip' == substr($basename, -4, 4)) ? 'application/zip' : 'application/octet-stream'),
			null,
			true,
			$chunk_size
		);
		$media->setFileSize($local_size);

		if (!empty($possible_location)) {
			// $media->resumeUri = $possible_location[0];
			// $media->progress = $possible_location[1];
			$media->updraftplus_setResumeUri($possible_location[0]);
			$media->updraftplus_setProgress($possible_location[1]);
			$size = $possible_location[1];
		}
		if ($size >= $local_size) return true;

		$status = false;
		if (false == ($handle = fopen($file, 'rb'))) {
			$this->log("failed to open file: $basename");
			$this->log("$basename: ".__('Error: Failed to open local file', 'updraftplus'), 'error');
			return false;
		}
		
		if ($size > 0 && 0 != fseek($handle, $size)) {
			$this->log("failed to fseek file: $basename, $size");
			$this->log("$basename (fseek): ".__('Error: Failed to open local file', 'updraftplus'), 'error');
			return false;
		}

		$pointer = $size;

		try {
			while (!$status && !feof($handle)) {
				$chunk = '';
				// Google requires chunks of the previous indicated size. Short reads are thus problematic. (Or does it? Was this just because the content-length header was hard-coded to the chunk size? Should be investigated, to see if we can change chunk size dynamically).
				while (strlen($chunk) < $chunk_size && !feof($handle)) {
					$chunk .= fread($handle, $chunk_size - strlen($chunk));
				}
				// Do we need any further error handling??
				$pointer += strlen($chunk);
				
				$start_time = microtime(true);
				$status = $media->nextChunk($chunk);

				unset($chunk);
				
				$extra_log = $media->getProgress();
				
				if (!$status && $chunk_size < 67108864 && microtime(true) - $start_time < 2.5 && !feof($handle) && $updraftplus->verify_free_memory($chunk_size * 4)) {
				
					$memory_usage = round(@memory_get_usage(false)/1048576, 1);// phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- Silenced to suppress errors that may arise because of the function.
					$memory_usage2 = round(@memory_get_usage(true)/1048576, 1);// phpcs:ignore Generic.PHP.NoSilencedErrors.Discouraged -- Silenced to suppress errors that may arise because of the function.
				
					$chunk_size = $chunk_size * 2;
					$extra_log .= ' - increasing chunk size to '.round($chunk_size/1024).' KB';
					$extra_log .= " - memory usage: $memory_usage / $memory_usage2";
				}
				
				$this->jobdata_set($transkey, array($media->updraftplus_getResumeUri(), $media->getProgress()));
				$updraftplus->record_uploaded_chunk(round(100*$pointer/$local_size, 1), $extra_log, $file);
			}
			
		} catch (UDP_Google_Service_Exception $e) {
			return $this->catch_upload_engine_exceptions($e, $handle, $try_again, $file, $parent_id);
		} catch (UDP_Google_IO_Exception $e) {
			return $this->catch_upload_engine_exceptions($e, $handle, $try_again, $file, $parent_id);
		}

		// The final value of $status will be the data from the API for the object
		// that has been uploaded.
		$result = (false != $status) ? $status : false;// phpcs:ignore VariableAnalysis.CodeAnalysis.VariableAnalysis.UnusedVariable -- We don't use this at this time.

		fclose($handle);
		$client->setDefer(false);
		$this->jobdata_delete($transkey, 'gd'.$transkey);

		return true;

	}

	/**
	 * This function is used to handle certain exceptions that can rise from uploading files to Google Drive when a retry is possibly desirable.
	 *
	 * @param Exception $e         - the Google exception we caught
	 * @param Resource  $handle    - a file handler object that needs closing
	 * @param Boolean   $try_again - indicates if we should try again
	 * @param String    $file      - the full file path
	 * @param String    $parent_id - the Google Drive ID for the parent folder
	 *
	 * @return Boolean
	 */
	private function catch_upload_engine_exceptions($e, $handle, $try_again, $file, $parent_id) {
		$this->log('ERROR: upload exception ('.get_class($e).'): '.$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
		$this->client->setDefer(false);
		fclose($handle);
		$transkey = $transkey = 'resume_'.md5($file);
		$this->jobdata_delete($transkey, 'gd'.$transkey);
		if (false == $try_again) throw $e;
		// Reset this counter to prevent the something_useful_happened condition's possibility being sent into the far future and potentially missed
		global $updraftplus;
		if ($updraftplus->current_resumption > 9) $updraftplus->jobdata_set('uploaded_lastreset', $updraftplus->current_resumption);
		return $this->upload_file($file, $parent_id, false);
	}
	
	/**
	 * Download method: takes a base name, and brings it back from the cloud storage into the internal directory.
	 *
	 * @param String $file The specific file to be downloaded from the Cloud Storage
	 *
	 * @return Boolean - success or failure state
	 */
	public function download($file) {

		global $updraftplus;

		$storage = $this->bootstrap();
		if (false == $storage || is_wp_error($storage)) return false;

		global $updraftplus;
		$opts = $this->get_options();

		try {
			$parent_id = $this->get_parent_id($opts);
			// $gdparent = $storage->files->get($parent_id);
			$sub_items = $this->get_subitems($parent_id, 'file');
		} catch (Exception $e) {
			$this->log("delete: failed to access parent folder: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
			return false;
		}

		$found = false;
		foreach ($sub_items as $item) {
			if ($found) continue;
			$title = "(unknown)";
			try {
				$title = $item->getTitle();
				if ($title == $file) {
					$gdfile = $item;
					$found = $item->getId();
					$size = $item->getFileSize();
				}
			} catch (Exception $e) {
				$this->log("download: exception: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
			}
		}

		if (false === $found) {
			$this->log('download: failed: file not found');
			$this->log($file.': '.__('Error', 'updraftplus').': '.__('File not found', 'updraftplus'), 'error');
			return false;
		}

		$download_to = $updraftplus->backups_dir_location().'/'.$file;

		$existing_size = file_exists($download_to) ? filesize($download_to) : 0;

		if ($existing_size >= $size) {
			$this->log('download: was already downloaded ('.filesize($download_to)."/$size bytes)");
			return true;
		}

		// We only need a chunk size because the API library won't accept a file handle - otherwise, we could download the whole range. But testing (150Mb/s connection) shows that after 32MB almost all the gains have been realised.
		$chunk_size = 2097152;
		while ($updraftplus->verify_free_memory($chunk_size * 3) && $chunk_size <= 20971520) {
			$chunk_size = $chunk_size * 2;
		}

		try {
			while ($existing_size < $size) {

				$end = min($existing_size + $chunk_size, $size);

				if ($existing_size > 0) {
					$put_flag = FILE_APPEND;
					$headers = array('Range' => 'bytes='.$existing_size.'-'.$end);
				} else {
					$put_flag = 0;
					$headers = ($end < $size) ? array('Range' => 'bytes=0-'.$end) : array();
				}

				$pstart = round(100*$existing_size/$size, 1);
				$pend = round(100*$end/$size, 1);
				$this->log("Requesting byte range: $existing_size - $end ($pstart - $pend %)");

				$request = $this->client->getAuth()->sign(new UDP_Google_Http_Request($gdfile->getDownloadUrl(), 'GET', $headers, null));
				$http_request = $this->client->getIo()->makeRequest($request);
				$http_response = $http_request->getResponseHttpCode();
				if (200 == $http_response || 206 == $http_response) {
					file_put_contents($download_to, $http_request->getResponseBody(), $put_flag);
				} else {
					$this->log("download: failed: unexpected HTTP response code: ".$http_response);
					$this->log(__("download: failed: file not found", 'updraftplus'), 'error');
					return false;
				}

				clearstatcache();
				$new_size = filesize($download_to);
				if ($new_size > $existing_size) {
					$existing_size = $new_size;
				} else {
					throw new Exception('Failed to obtain any new data at size: '.$existing_size);
				}
			}
		} catch (Exception $e) {
			$this->log("download: exception: ".$e->getMessage().' (line: '.$e->getLine().', file: '.$e->getFile().')');
		}

		return true;
	}

	/**
	 * Retrieve a list of template properties by taking all the persistent variables and methods of the parent class and combining them with the ones that are unique to this module, also the necessary HTML element attributes and texts which are also unique only to this backup module
	 * NOTE: Please sanitise all strings that are required to be shown as HTML content on the frontend side (i.e. wp_kses()), or any other technique to prevent XSS attacks that could come via WP hooks
	 *
	 * @return Array an associative array keyed by names that describe themselves as they are
	 */
	public function get_template_properties() {
		global $updraftplus;
		$properties = array(
			'storage_image_url' => UPDRAFTPLUS_URL.'/images/googledrive_logo.png',
			'storage_image_title' => __('Google Drive', 'updraftplus'),
			'input_clientid_label' => __('Google Drive', 'updraftplus').' '.__('Client ID', 'updraftplus'),
			'input_clientid_title' => __('If Google later shows you the message "invalid_client", then you did not enter a valid client ID here.', 'updraftplus'),
			'input_secret_label' => __('Google Drive', 'updraftplus').' '.__('Client Secret', 'updraftplus'),
			'input_secret_type' => apply_filters('updraftplus_admin_secret_field_type', 'password'),
			'input_folder_label' => __('Google Drive', 'updraftplus').' '.__('Folder', 'updraftplus'),
			'clientid_and_secret_instruction_label1' => __('For longer help, including screenshots, follow this link.', 'updraftplus').' '.__('The description below is sufficient for more expert users.', 'updraftplus'),
			'updraftplus_com_link' => apply_filters('updraftplus_com_link', 'https://updraftplus.com/support/configuring-google-drive-api-access-in-updraftplus/'),
			'clientid_and_secret_instruction_label2' => __('Follow this link to your Google API Console, and there activate the Drive API and create a Client ID in the API Access section.', 'updraftplus'),
			'clientid_and_secret_instruction_label3' => __("Select 'Web Application' as the application type.", 'updraftplus'),
			'clientid_and_secret_instruction_label4' => __('You must add the following as the authorised redirect URI (under "More Options") when asked', 'updraftplus'),
			'clientid_and_secret_instruction_label5' => UpdraftPlus_Options::admin_page_url().'?action=updraftmethod-googledrive-auth',
			'clientid_and_secret_instruction_label6' => __('N.B. If you install UpdraftPlus on several WordPress sites, then you cannot re-use your project; you must create a new one from your Google API console for each site.', 'updraftplus'),
			'id_number_instruction_label' => wp_kses(__("<strong>This is NOT a folder name</strong>.", 'updraftplus').' '.__('It is an ID number internal to Google Drive', 'updraftplus'), $this->allowed_html_for_content_sanitisation()),
			'custom_folder_name_label' => __('To be able to set a custom folder name, use UpdraftPlus Premium.', 'updraftplus'),
			'privacy_policy_label' => wp_kses(sprintf(__('Please read %s for use of our %s authorization app (none of your backup data is sent to us).', 'updraftplus'), '<a target="_blank" href="https://updraftplus.com/faqs/privacy-policy-use-google-drive-app/">'.__('this privacy policy', 'updraftplus').'</a>', 'Google Drive'), $this->allowed_html_for_content_sanitisation()),
			'updraftplus_premium_url' => $updraftplus->get_url('premium'),
			'authentication_label' => __('Authenticate with Google', 'updraftplus'),
			'authentication_label2' => wp_kses(sprintf(__("<strong>After</strong> you have saved your settings (by clicking 'Save Changes' below), then come back here once and follow this link to complete authentication with %s.", 'updraftplus'), $updraftplus->backup_methods[$this->get_id()]), $this->allowed_html_for_content_sanitisation()),
			'authentication_link_text' => sprintf(__('Sign in with %s', 'updraftplus'), 'Google'),
			'already_authenticated_label' => __("<strong>(You appear to be already authenticated,</strong> though you can authenticate again to refresh your access if you've had a problem).", 'updraftplus'),
			'deauthentication_nonce' => wp_create_nonce($this->get_id().'_deauth_nonce'),
			'deauthentication_link_text' => sprintf(__("Follow this link to remove these settings for %s.", 'updraftplus'), $updraftplus->backup_methods[$this->get_id()]),
			'deauthorise_use_master_label' => __('To de-authorize UpdraftPlus (all sites) from accessing your Google Drive, follow this link to your Google account settings.', 'updraftplus'),
			'account_name_label' => __("Account holder's name", 'updraftplus'),
		);
		if (preg_match('#^(https?://(\d+)\.(\d+)\.(\d+)\.(\d+))/#i', apply_filters('updraftplus_gdrive_admin_page_url', UpdraftPlus_Options::admin_page_url()), $matches)) $properties['ip_address'] = $matches[1];
		if (isset($properties['ip_address'])) $properties['unallowed_direct_ip_address'] = wp_kses(sprintf(__("%s does not allow authorisation of sites hosted on direct IP addresses.", 'updraftplus').' '.__("You will need to change your site's address (%s) before you can use %s for storage.", 'updraftplus'), __('Google Drive', 'updraftplus'), $matches[1], __('Google Drive', 'updraftplus')), $this->allowed_html_for_content_sanitisation());
		return wp_parse_args(apply_filters('updraft_'.$this->get_id().'_template_properties', array()), wp_parse_args($properties, $this->get_persistent_variables_and_methods()));
	}

	/**
	 * Get the pre configuration template
	 *
	 * @return String - the template
	 */
	public function get_pre_configuration_template() {
		?>
			<tr class="{{get_template_css_classes false}} {{method_id}}_pre_config_container">
				<td colspan="2">
					<img src="{{storage_image_url}}" alt="{{storage_image_title}}">
					{{#unless use_master}}
					<br>
					{{#if ip_address}}
						{{!-- This is advisory - so the fact it doesn't match IPv6 addresses isn't important --}}
						<p><strong>{{{unallowed_direct_ip_address}}}</strong></p>
					{{else}}
						{{!-- If we are not using the master app then show them the instructions for Client ID and Secret --}}
						<p><a href="{{updraftplus_com_link}}" target="_blank"><strong>{{clientid_and_secret_instruction_label1}}</strong></a></p>
						<p><a href="https://console.developers.google.com" target="_blank">{{clientid_and_secret_instruction_label2}}</a> {{clientid_and_secret_instruction_label3}}</p>
						<p>{{clientid_and_secret_instruction_label4}}: <kbd>{{clientid_and_secret_instruction_label5}}</kbd> {{clientid_and_secret_instruction_label6}}</p>
					{{/if}}
					{{/unless}}
					<p>
						{{{privacy_policy_label}}}
					</p>
				</td>
			</tr>
		<?php
	}

	/**
	 * Get the configuration template
	 *
	 * @return String - the template, ready for substitutions to be carried out
	 */
	public function get_configuration_template() {
		ob_start();
		?>
			{{#unless use_master}}
				<tr class="{{get_template_css_classes true}}">
					<th>{{input_clientid_label}}:</th>
					<td><input type="text" autocomplete="off" class="updraft_input--wide" id="{{get_template_input_attribute_value "id" "clientid"}}" name="{{get_template_input_attribute_value "name" "clientid"}}" value="{{clientid}}" /><br><em>{{input_clientid_title}}</em></td>
				</tr>
				<tr class="{{get_template_css_classes true}}">
					<th>{{input_secret_label}}:</th>
					<td><input type="{{input_secret_type}}" class="updraft_input--wide" id="{{get_template_input_attribute_value "id" "secret"}}" name="{{get_template_input_attribute_value "name" "secret"}}" value="{{secret}}" /></td>
				</tr>
			{{/unless}}
			{{#if is_google_enhanced_addon}}
				{{#> gdrive_additional_configuration_top}} {{/gdrive_additional_configuration_top}}
			{{else}}
				{{#if parentid}}
				<tr class="{{get_template_css_classes true}}">
					<th>{{input_folder_label}}:</th>
					<td>
						<input type="hidden" id="{{get_template_input_attribute_value "id" '["parentid","id"]'}}" name="{{get_template_input_attribute_value "name" '["parentid","id"]'}}" value="{{parentid_str}}">
						<input type="text" title="{{parentid_str}}" readonly="readonly" class="updraft_input--wide" value="{{showparent}}">
						{{#if is_id_number_instruction}}
							<em>{{{id_number_instruction_label}}}</em>
						{{else}}
							<input type="hidden" id="{{get_template_input_attribute_value "id" '["parentid","name"]'}}" name="{{get_template_input_attribute_value "name" '["parentid","name"]'}}" value="{{parentid.name}}">
						{{/if}}
				{{else}}
					<tr class="{{get_template_css_classes true}}">
						<th>{{input_folder_label}}:</th>
						<td>
							<input type="text" readonly="readonly" class="updraft_input--wide" id="{{get_template_input_attribute_value "id" "folder"}}" name="{{get_template_input_attribute_value "name" "folder"}}" value="UpdraftPlus" />
				{{/if}}
							<br>
							<em>
								<a href="{{updraftplus_premium_url}}" target="_blank">
									{{custom_folder_name_label}}
								</a>
							</em>
						</td>
					</tr>
			{{/if}}
			<tr class="{{get_template_css_classes true}}">
				<th>{{authentication_label}}:</th>
				<td>
					{{#if is_authenticate_with_google}}
						<p>
							{{{already_authenticated_label}}}
							<a class="updraft_deauthlink" href="{{admin_page_url}}?action=updraftmethod-{{method_id}}-auth&page=updraftplus&updraftplus_{{method_id}}auth=deauth&nonce={{deauthentication_nonce}}&updraftplus_instance={{instance_id}}" data-instance_id="{{instance_id}}" data-remote_method="{{method_id}}">{{deauthentication_link_text}}</a>
						</p>
						{{#if use_master}}
							<p><a target="_blank" href="https://myaccount.google.com/permissions">{{deauthorise_use_master_label}}</a></p>
						{{/if}}
					{{/if}}
					{{#if is_ownername_display}}
						{{#if owneremail}}
						<br>
							{{account_name_label}}: {{ownername}} ({{owneremail}})
						{{else}}
						<br>
							{{account_name_label}}: {{ownername}}
						{{/if}}
					{{/if}}
					<p>
						{{{authentication_label2}}}
					</p>
					<br>
					<a data-pretext="{{{authentication_label2}}}" class="button-ud-google updraft_authlink" href="{{admin_page_url}}?&action=updraftmethod-{{method_id}}-auth&page=updraftplus&updraftplus_{{method_id}}auth=doit&nonce={{storage_auth_nonce}}&updraftplus_instance={{instance_id}}" data-instance_id="{{instance_id}}" data-remote_method="{{method_id}}">{{authentication_link_text}}</a>
				</td>
			</tr>
		<?php
		return ob_get_clean();
	}

	/**
	 * Get partial templates associated to the corresponding backup module (remote storage object)
	 *
	 * @return Array an associative array keyed by names of the partial template
	 */
	public function get_partial_templates() {
		return wp_parse_args(apply_filters('updraft_'.$this->get_id().'_partial_templates', array()), parent::get_partial_templates());
	}

	/**
	 * Modifies handerbar template options
	 *
	 * @param array $opts
	 * @return Array - Modified handerbar template options
	 */
	public function transform_options_for_template($opts) {
		$opts['use_master'] = $this->use_master($opts);
		$opts['is_google_enhanced_addon'] = class_exists('UpdraftPlus_Addon_Google_Enhanced') ? true : false;
		if (isset($opts['parentid'])) {
			$opts['parentid_str'] = (is_array($opts['parentid'])) ? $opts['parentid']['id'] : $opts['parentid'];
			$opts['showparent'] = (is_array($opts['parentid']) && !empty($opts['parentid']['name'])) ? $opts['parentid']['name'] : $opts['parentid_str'];
			$opts['is_id_number_instruction'] = (!empty($opts['parentid']) && (!is_array($opts['parentid']) || empty($opts['parentid']['name'])));
		}
		$opts['is_authenticate_with_google'] = (!empty($opts['token']) || !empty($opts['user_id']));
		$opts['is_ownername_display'] = ((!empty($opts['token']) || !empty($opts['user_id'])) && !empty($opts['ownername']));
		$opts = apply_filters('updraftplus_options_googledrive_options', $opts);
		return $opts;
	}
	
	/**
	 * Gives settings keys which values should not passed to handlebarsjs context.
	 * The settings stored in UD in the database sometimes also include internal information that it would be best not to send to the front-end (so that it can't be stolen by a man-in-the-middle attacker)
	 *
	 * @return Array - Settings array keys which should be filtered
	 */
	public function filter_frontend_settings_keys() {
		return array(
			'expires_in',
			'tmp_access_token',
			'token',
			'user_id',
		);
	}

	/**
	 * This function will build and return the authentication link
	 *
	 * @param String $instance_id - the instance id
	 * @param String $text        - the link text
	 *
	 * @return String - the authentication link
	 */
	public function build_authentication_link($instance_id, $text) {
		
		$id = $this->get_id();

		return '<p>'. $text .'</p><br><a data-pretext="'.$text.'" class="button-ud-google updraft_authlink" href="'.UpdraftPlus_Options::admin_page_url().'?&action=updraftmethod-'.$id.'-auth&page=updraftplus&updraftplus_'.$id.'auth=doit&nonce='.wp_create_nonce('storage_auth_nonce').'&updraftplus_instance='.esc_attr($instance_id).'" data-instance_id="'.esc_attr($instance_id).'" data-remote_method="'.$id.'">'.sprintf(__('Sign in with %s', 'updraftplus'), 'Google').'</a>';
	}
}
