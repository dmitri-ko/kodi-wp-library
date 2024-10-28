<?php
/**
 * Configurator interface
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Configurator
 */

namespace Kodi\Configurator;

/**
 * Configurator interface
 */
interface Configurator {
	/**
	 * Get the plugin event subscribers.
	 *
	 * @return Kodi\EventManagement\Subscriber_Interface[]
	 */
	public function get_subscribers(): array;

	/**
	 * Get the plugin shortcodes.
	 *
	 * @return Kodi\Shortcode\Shortcode_Interface[]
	 */
	public function get_shortcodes(): array;
}
