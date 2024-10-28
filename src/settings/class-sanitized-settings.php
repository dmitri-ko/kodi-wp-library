<?php
/**
 * Sanitized Settings
 * Provide functions to handle sanitized settings.
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Settings
 */

namespace Kodi\Settings;

use Kodi\Provider\Provider;
use Kodi\Validator\Validator;

/**
 * Sanitized settings
 */
class Sanitized_Settings implements Settings {
	/**
	 * Data provider
	 *
	 * @var Kodi\Provider\Provider
	 */
	private $provider;

	/**
	 * Validator
	 *
	 * @var Kodi\Validator\Validator
	 */
	private $validator;

	/**
	 * Internal storage
	 *
	 * @var array
	 */
	private $data_storage;

	/**
	 * Constructor
	 *
	 * @param  \Kodi\Provider\Provider   $provider Data provider.
	 * @param  \Kodi\Validator\Validator $validator Data validator.
	 */
	public function __construct( Provider $provider, Validator $validator ) {
		$this->provider     = $provider;
		$this->validator    = $validator;
		$this->data_storage = array();

		$this->load();
	}

	/**
	 * Load data storage
	 *
	 * @return void
	 */
	private function load() {
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
	 * Get unformatted configuration data.
	 *
	 * @return array
	 */
	public function get_raw_data(): array {
		return $this->data_storage;
	}

	/**
	 * Get property.
	 *
	 * @param  string $property_name Property name.
	 *
	 * @return string
	 */
	public function get_property( string $property_name ): string {
		return isset( $this->data_storage[ $property_name ] ) && is_string( $this->data_storage[ $property_name ] ) ? $this->data_storage[ $property_name ] : '';
	}

	/**
	 * Check if option is set
	 *
	 * @param  string $setting Setting name.
	 * @param  string $option Option name.
	 *
	 * @return bool
	 */
	public function has_support( string $setting, string $option ): bool {
		return isset( $this->data_storage[ $setting ] ) && ! empty( $this->data_storage[ $setting ][ $option ] );
	}

	/**
	 * Get setting
	 *
	 * @param  string $setting Setting name.
	 *
	 * @return array
	 */
	public function get_settings( string $setting ): array {
		return isset( $this->data_storage[ $setting ] ) ? $this->data_storage[ $setting ] : array();
	}

	/**
	 * Get option
	 *
	 * @param  string $setting Setting name.
	 * @param  string $option Option name.
	 *
	 * @return mixed
	 */
	public function get_option( string $setting, string $option ): mixed {
		return $this->has_support( $setting, $option ) ? $this->data_storage[ $setting ][ $option ] : false;
	}
}
