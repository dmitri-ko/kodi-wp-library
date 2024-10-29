<?php
/**
 * SanitizedSettings
 *
 * Handles the loading, validation, and retrieval of settings from a provider.
 *
 * @package    Kodi
 * @subpackage Settings
 * @since      1.0.0
 */

namespace Kodi\Settings;

use Kodi\Provider\Interfaces\ProviderInterface;
use Kodi\Validator\Interfaces\ValidatorInterface;
use Kodi\Settings\Interfaces\SettingsInterface;

/**
 * Class SanitizedSettings
 *
 * Loads settings from a data provider, validates them using a validator, and provides access to the sanitized settings.
 *
 * @since 1.0.0
 */
class SanitizedSettings implements SettingsInterface {

	/**
	 * Data provider instance.
	 *
	 * @var ProviderInterface
	 */
	private ProviderInterface $provider;

	/**
	 * Validator instance.
	 *
	 * @var ValidatorInterface
	 */
	private ValidatorInterface $validator;

	/**
	 * Storage for validated data.
	 *
	 * @var array
	 */
	private array $data_storage = array();

	/**
	 * Constructor
	 *
	 * Initializes the settings with a data provider and a validator.
	 * Loads the data and sanitizes it based on the provided rules.
	 *
	 * @param ProviderInterface  $provider  The data provider instance.
	 * @param ValidatorInterface $validator The validator instance.
	 *
	 * @since 1.0.0
	 */
	public function __construct( ProviderInterface $provider, ValidatorInterface $validator ) {
		$this->provider  = $provider;
		$this->validator = $validator;
		$this->load();
	}

	/**
	 * Load and validate data from the provider.
	 *
	 * Iterates over the data from the provider, validating and storing only the allowed settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function load(): void {
		foreach ( $this->provider->get_data() as $name => $value ) {
			if ( $this->validator->is_allowed( $name, $value ) ) {
				if ( is_array( $value ) ) {
					$this->data_storage = array_merge( $this->data_storage, $value );
				} else {
					$this->data_storage[ $name ] = $value;
				}
			}
		}
	}

	/**
	 * Retrieve all raw data.
	 *
	 * Returns all sanitized settings as an associative array.
	 *
	 * @since 1.0.0
	 *
	 * @return array The array of sanitized settings.
	 */
	public function get_raw_data(): array {
		return $this->data_storage;
	}

	/**
	 * Retrieve a specific property by its name.
	 *
	 * Returns the value of the specified property if it exists and is a string.
	 * If the property is not found or is not a string, an empty string is returned.
	 *
	 * @since 1.0.0
	 *
	 * @param string $property_name The name of the property to retrieve.
	 * @return string The value of the property, or an empty string if not found.
	 */
	public function get_property( string $property_name ): string {
		return isset( $this->data_storage[ $property_name ] ) && is_string( $this->data_storage[ $property_name ] )
			? $this->data_storage[ $property_name ]
			: '';
	}

	/**
	 * Check if a setting has support for a specific option.
	 *
	 * Determines whether the given setting has the specified option and that it is not empty.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting.
	 * @param string $option  The name of the option within the setting.
	 * @return bool True if the setting has support for the option, false otherwise.
	 */
	public function has_support( string $setting, string $option ): bool {
		return isset( $this->data_storage[ $setting ] ) && ! empty( $this->data_storage[ $setting ][ $option ] );
	}

	/**
	 * Retrieve the entire settings data for a specific setting.
	 *
	 * Returns an associative array representing the setting, or an empty array if the setting is not found.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting.
	 * @return array The data of the specified setting, or an empty array if not found.
	 */
	public function get_settings( string $setting ): array {
		return $this->data_storage[ $setting ] ?? array();
	}

	/**
	 * Retrieve a specific option from a given setting.
	 *
	 * Returns the value of an option within a setting if it exists, otherwise returns false.
	 *
	 * @since 1.0.0
	 *
	 * @param string $setting The name of the setting.
	 * @param string $option  The name of the option within the setting.
	 * @return mixed The value of the option, or false if not found.
	 */
	public function get_option( string $setting, string $option ): mixed {
		return $this->has_support( $setting, $option ) ? $this->data_storage[ $setting ][ $option ] : false;
	}
}
