<?php
/**
 * Settings Interface
 *
 * Defines methods to access, retrieve, and manage configuration settings.
 *
 * @package    Kodi
 * @subpackage Settings
 * @since      1.0.0
 */

namespace Kodi\Settings\Interfaces;

/**
 * Interface Settings
 *
 * Provides methods for interacting with configuration data,
 * including retrieving raw data, checking properties, and getting settings or options.
 *
 * @since 1.0.0
 */
interface SettingsInterface {

	/**
	 * Retrieve unformatted configuration data.
	 *
	 * Returns the raw configuration data as an array. This can be used for accessing
	 * all settings without any modifications or formatting.
	 *
	 * @since 1.0.0
	 * @return array Raw configuration data.
	 */
	public function get_raw_data(): array;

	/**
	 * Retrieve a specific property value.
	 *
	 * Fetches the value of a given property from the configuration settings.
	 *
	 * @since 1.0.0
	 * @param string $property_name Name of the property to retrieve.
	 * @return string Property value.
	 */
	public function get_property( string $property_name ): string;

	/**
	 * Check if a specific option is set for a given setting.
	 *
	 * Determines if a particular option is available or enabled within the specified setting.
	 *
	 * @since 1.0.0
	 * @param string $setting Setting name to check.
	 * @param string $option  Option name to verify.
	 * @return bool True if the option is set, false otherwise.
	 */
	public function has_support( string $setting, string $option ): bool;

	/**
	 * Retrieve settings for a given setting name.
	 *
	 * Returns an array containing all options and values for a particular setting.
	 *
	 * @since 1.0.0
	 * @param string $setting Setting name.
	 * @return array Associative array of settings.
	 */
	public function get_settings( string $setting ): array;

	/**
	 * Retrieve a specific option value for a given setting.
	 *
	 * Fetches the value of a specified option within the given setting.
	 *
	 * @since 1.0.0
	 * @param string $setting Setting name.
	 * @param string $option  Option name.
	 * @return mixed Option value, could be any data type depending on the option.
	 */
	public function get_option( string $setting, string $option ): mixed;
}
