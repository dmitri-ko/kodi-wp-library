<?php
/**
 * Validator interface
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Validator
 */

namespace Kodi\Validator;

/**
 * Validator interface
 */
interface Validator {
	/**
	 * Check if provided key/value is allowed.
	 *
	 * @param  string $name Checked key.
	 * @param  mixed  $value Checked value.
	 *
	 * @return bool
	 */
	public function is_allowed( string $name, mixed $value ): bool;
}
