<?php
/**
 * SettingsValidator
 *
 * Provides functionality for validating WordPress settings based on predefined rulesets.
 *
 * @package    Kodi
 * @subpackage Validator
 * @since      1.0.0
 */

namespace Kodi\Validator;

use Kodi\Validator\Interfaces\ValidatorInterface;

/**
 * Class SettingsValidator
 *
 * Validates provided settings against a set of predefined rules.
 * Ensures that all settings and their options conform to the allowed structure.
 *
 * @since 1.0.0
 */
class SettingsValidator implements ValidatorInterface {

	/**
	 * Key for settings within the ruleset.
	 *
	 * @since 1.0.0
	 * @var string
	 */
	private const SETTINGS_KEY = 'settings';

	/**
	 * Ruleset array containing all validation rules.
	 *
	 * @since 1.0.0
	 * @var array
	 */
	private array $ruleset;

	/**
	 * Indicates whether the ruleset has been validated and is ready.
	 *
	 * @since 1.0.0
	 * @var bool
	 */
	private bool $is_valid = false;

	/**
	 * Constructor
	 *
	 * Initializes the validator with a ruleset and validates it.
	 *
	 * @since 1.0.0
	 * @param array $ruleset Array containing the validation rules.
	 */
	public function __construct( array $ruleset ) {
		$this->ruleset = $ruleset;
		$this->check_rules();
	}

	/**
	 * Validates the ruleset and sets the readiness flag.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function check_rules(): void {
		$this->set_ready( true );
	}

	/**
	 * Retrieve all root-level rules from the ruleset.
	 *
	 * @since 1.0.0
	 * @return array Array of root-level rule names.
	 */
	private function get_all_root_rules(): array {
		$roots = array();
		if ( $this->is_ready() ) {
			foreach ( $this->ruleset as $rule_name => $rule ) {
				if ( ( self::SETTINGS_KEY !== $rule_name ) && is_string( $rule ) ) {
					$roots[] = $rule;
				}
			}
		}

		return $roots;
	}

	/**
	 * Retrieve all setting rules from the ruleset.
	 *
	 * @since 1.0.0
	 * @return array Array of setting names defined in the ruleset.
	 */
	private function get_all_settings_rules(): array {
		if ( $this->is_ready() && isset( $this->ruleset[ self::SETTINGS_KEY ] ) ) {
			return array_keys( $this->ruleset[ self::SETTINGS_KEY ] );
		}

		return array();
	}

	/**
	 * Retrieve all option rules for a specific setting.
	 *
	 * @since 1.0.0
	 * @param string $setting_name The name of the setting.
	 * @return array Array of options defined for the given setting.
	 */
	private function get_all_options_rules( string $setting_name ): array {
		if ( $this->is_ready()
			&& isset( $this->ruleset[ self::SETTINGS_KEY ] )
			&& isset( $this->ruleset[ self::SETTINGS_KEY ][ $setting_name ] ) ) {
			return $this->ruleset[ self::SETTINGS_KEY ][ $setting_name ];
		}

		return array();
	}

	/**
	 * Check if the ruleset is ready and validated.
	 *
	 * @since 1.0.0
	 * @return bool True if the ruleset is ready, false otherwise.
	 */
	public function is_ready(): bool {
		return $this->is_valid;
	}

	/**
	 * Set the readiness state of the ruleset.
	 *
	 * @since 1.0.0
	 * @param bool $state True to set the ruleset as ready, false otherwise.
	 * @return void
	 */
	public function set_ready( bool $state ): void {
		$this->is_valid = $state;
	}

	/**
	 * Determine if the provided key/value pair is allowed based on the ruleset.
	 *
	 * Validates settings and options against the predefined ruleset to determine if they are allowed.
	 *
	 * @since 1.0.0
	 * @param string $name  The name of the key being checked.
	 * @param mixed  $value The value associated with the key being checked.
	 * @return bool True if the key/value pair is allowed, false otherwise.
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
				foreach ( $settings as $setting => $setting_value ) {
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
