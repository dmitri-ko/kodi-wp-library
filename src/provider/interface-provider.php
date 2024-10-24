<?php
/**
 * Provider interface
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Provider
 */

namespace Kodi\Provider;

/**
 * Provider interface
 */
interface Provider {
	/**
	 * Return data.
	 *
	 * @return array
	 */
	public function get_data(): array;
}
