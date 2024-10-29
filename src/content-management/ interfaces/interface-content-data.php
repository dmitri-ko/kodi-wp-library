<?php
/**
 * ContentDataInterface
 *
 * Defines methods for retrieving theme or plugin data such as subscribers and shortcodes.
 *
 * @package    Kodi
 * @subpackage ContentManagement
 * @since      1.0.0
 */

namespace Kodi\ContentManagement\Interfaces;

/**
 * Interface ContentDataInterface
 *
 * Provides methods for accessing different types of content data.
 * Classes implementing this interface should handle data retrieval,
 * focusing on specific types of data like subscribers and shortcodes.
 *
 * @since 1.0.0
 */
interface ContentDataInterface {

	/**
	 * Retrieve an array of subscribers.
	 *
	 * Implementations should return all event or action subscribers
	 * associated with the theme or plugin.
	 *
	 * @since 1.0.0
	 * @return array Array of subscribers.
	 */
	public function get_subscribers(): array;

	/**
	 * Retrieve an array of shortcodes.
	 *
	 * Implementations should return all shortcodes registered by
	 * the theme or plugin.
	 *
	 * @since 1.0.0
	 * @return array Array of shortcodes.
	 */
	public function get_shortcodes(): array;
}
