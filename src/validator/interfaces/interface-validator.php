<?php
/**
 * ValidatorInterface
 *
 * Defines the contract for validating key/value pairs in the WordPress environment.
 *
 * @package    Kodi
 * @subpackage Validator
 * @since      1.0.0
 */

namespace Kodi\Validator\Interfaces;

/**
 * Interface ValidatorInterface
 *
 * Represents a validator that checks whether specific key/value pairs meet defined criteria.
 *
 * @since 1.0.0
 */
interface ValidatorInterface {

	/**
	 * Check if the provided key/value pair is allowed.
	 *
	 * Determines if the given key and its associated value satisfy validation rules.
	 *
	 * @since 1.0.0
	 *
	 * @param string $name  The key to be validated.
	 * @param mixed  $value The value associated with the key.
	 * @return bool True if the key/value pair is valid, false otherwise.
	 */
	public function is_allowed( string $name, mixed $value ): bool;
}
