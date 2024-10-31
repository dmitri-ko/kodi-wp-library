<?php
/**
 * File name: class-theme-settings-manager.php
 *
 * Provides functionality for managing theme configurations and content.
 *
 * @package Kodi
 * @subpackage ContentManagement
 * @since 1.0.0
 * @version 1.0.0
 * @license GPL-2.0-or-later
 * @author  BuzzDeveloper
 * @link    https://buzzdeveloper.net
 */

namespace Kodi\ContentManagement;

use Kodi\Settings\Sanitized_Settings;
use Kodi\Provider\JSON_Provider;
use Kodi\Validator\Settings_Validator;

/**
 * Class Theme_Settings_Manager
 *
 * Manages theme settings using JSONProvider and validates them using SettingsValidator.
 *
 * @since 1.0.0
 */
class Theme_Settings_Manager {

	/**
	 * Load and validate theme settings.
	 *
	 * @param string $file_path Path to the JSON configuration file.
	 * @param array  $ruleset   Validation ruleset for the settings.
	 * @return Sanitized_Settings The sanitized settings instance.
	 */
	public function load_settings( string $file_path, array $ruleset ): Sanitized_Settings {
		return new Sanitized_Settings(
			new JSON_Provider( $file_path ),
			new Settings_Validator( $ruleset )
		);
	}
}
