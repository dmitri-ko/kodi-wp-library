<?php
/**
 * ProviderInterface
 *
 * Defines a contract for data retrieval within the WordPress environment.
 *
 * @package    Kodi
 * @subpackage Provider
 * @since      1.0.0
 */

namespace Kodi\Provider\Interfaces;

/**
 * Interface ProviderInterface
 *
 * Represents a data provider that offers a method to retrieve data.
 * Classes implementing this interface should provide specific data-fetching logic.
 *
 * @since 1.0.0
 */
interface ProviderInterface {

	/**
	 * Retrieve data from the provider.
	 *
	 * Implementations should define how data is fetched, which may involve
	 * database queries, external API requests, or other sources.
	 *
	 * @since 1.0.0
	 * @return array An array of data.
	 */
	public function get_data(): array;
}
