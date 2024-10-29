<?php
/**
 * ThemeSettingsManager
 *
 * Manages the loading and validation of settings from the JSON configuration file.
 *
 * @package    Kodi
 * @subpackage ContentManagement
 * @since      1.0.0
 */

namespace Kodi\ContentManagement;

use Kodi\Settings\SanitizedSettings;
use Kodi\Provider\JSONProvider;
use Kodi\Validator\SettingsValidator;

/**
 * Class ThemeSettingsManager
 *
 * Manages theme settings using JSONProvider and validates them using SettingsValidator.
 *
 * @since 1.0.0
 */
class ThemeSettingsManager {

	/**
	 * Load and validate theme settings.
	 *
	 * @param string $file_path Path to the JSON configuration file.
	 * @param array  $ruleset   Validation ruleset for the settings.
	 * @return SanitizedSettings The sanitized settings instance.
	 */
	public function load_settings( string $file_path, array $ruleset ): SanitizedSettings {
		return new SanitizedSettings(
			new JSONProvider( $file_path ),
			new SettingsValidator( $ruleset )
		);
	}
}
