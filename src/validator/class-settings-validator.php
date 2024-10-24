<?php
/**
 * Settings validator
 *
 * Handles structure validation according ruleset.
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Validator
 */

namespace Kodi\Validator;

/**
 * Settings validator
 */
class Settings_Validator implements Validator {

	const SETTINGS_KEY = 'settings';

	/**
	 * Rule set for setting structure
	 *
	 * @var array
	 */
	private $ruleset;

	/**
	 * Ruleset valid flag
	 *
	 * @var bool
	 */
	private $is_valid;

	/**
	 * Constructor
	 *
	 * @param  array $ruleset Rule set for setting structure.
	 */
	public function __construct( array $ruleset ) {
		$this->ruleset = $ruleset;

		$this->check_rules();
	}

	/**
	 * Check ruleset structure
	 *
	 * @return void
	 */
	private function check_rules() {
		$this->set_ready( true );
	}

	/**
	 * Get all root rules
	 *
	 * @return array
	 */
	private function get_all_root_rules(): array {
		$roots = array();
		if ( $this->is_ready() ) {
			foreach ( $this->ruleset as $rule_name => $rule ) {
				if ( ( 'settings' !== $rule_name ) && is_string( $rule ) ) {
					array_push( $roots, array( $rule_name => $rule ) );
				}
			}
		}

		return $roots;
	}

	/**
	 * Get all settings rules
	 *
	 * @return array
	 */
	private function get_all_settings_rules(): array {
		$settings = array();
		if ( $this->is_ready() ) {
			$settings = isset( $this->ruleset[ self::SETTINGS_KEY ] ) ? $this->ruleset[ self::SETTINGS_KEY ] : array();
		}

		return $settings;
	}

	/**
	 * Get all option rules for setting
	 *
	 * @param  string $setting_name Setting name.
	 *
	 * @return array
	 */
	private function get_all_options_rules( string $setting_name ): array {
		$options = array();
		if ( $this->is_ready() ) {
			$options = isset( $this->ruleset[ self::SETTINGS_KEY ] ) && isset( $this->ruleset[ self::SETTINGS_KEY ][ $setting_name ] ) ? $this->ruleset[ self::SETTINGS_KEY ][ $setting_name ] : array();
		}

		return $options;
	}

	/**
	 * Check validator state
	 *
	 * @return bool
	 */
	public function is_ready(): bool {
		return $this->is_valid;
	}

	/**
	 * Set validator state
	 *
	 * @param  bool $state Validator state.
	 *
	 * @return void
	 */
	public function set_ready( bool $state ) {
		$this->is_valid = $state;
	}

	/**
	 * Check if provided key/value is allowed.
	 *
	 * @param  string $name Checked key.
	 * @param  mixed  $value Checked value.
	 *
	 * @return bool
	 */
	public function is_allowed( string $name, mixed $value ): bool {
		if ( ! $this->is_ready() ) {
			return false;
		}

		if ( self::SETTINGS_KEY === $name ) {
			foreach ( $value as $setting_name => $settings ) {
				if ( ! in_array( $setting_name, $this->get_all_settings_rules(), true ) ) {
					return false;
				}
				foreach ( $settings as $setting ) {
					if ( ! in_array( $setting, $this->get_all_options_rules( $setting_name ), true ) ) {
						return false;
					}
				}
			}
		} else {
			return in_array( $name, $this->get_all_root_rules(), true );
		}

		return true;
	}
}
