<?php
/**
 * Settings interface
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Settings
 */

namespace Kodi\Settings;

/**
 * Settings interface
 */
interface Settings {
	/**
	 * Get unformatted configuration data.
	 *
	 * @return array
	 */
	public function get_raw_data(): array;

	/**
	 * Get property.
	 *
	 * @param  string $property_name Property name.
	 *
	 * @return string
	 */
	public function get_property( string $property_name ): string;

	/**
	 * Check if option is set
	 *
	 * @param  string $setting Setting name.
	 * @param  string $option Option name.
	 *
	 * @return bool
	 */
	public function has_support( string $setting, string $option ): bool;

	/**
	 * Get setting
	 *
	 * @param  string $setting Setting name.
	 *
	 * @return array
	 */
	public function get_settings( string $setting ): array;

	/**
	 * Get option
	 *
	 * @param  string $setting Setting name.
	 * @param  string $option Option name.
	 *
	 * @return mixed
	 */
	public function get_option( string $setting, string $option ): mixed;
}
