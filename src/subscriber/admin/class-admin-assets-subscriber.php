<?php
/**
 * AdminAssetsSubscriber
 *
 * Handles the registration and management of admin assets for WordPress.
 *
 * @package    Kodi
 * @subpackage Subscriber\Admin
 * @since      1.0.0
 */

namespace Kodi\Subscriber\Admin;

use Kodi\Subscriber\BaseAssetsSubscriber;

/**
 * Class AdminAssetsSubscriber
 *
 * Subscribes to WordPress events related to admin asset loading,
 * specifically enqueuing styles and scripts for the WordPress admin dashboard.
 *
 * @since 1.0.0
 */
class AdminAssetsSubscriber extends BaseAssetsSubscriber {

	/**
	 * Get the list of events to subscribe to.
	 *
	 * Returns an array of WordPress events and their respective callback methods.
	 * This class handles enqueuing admin scripts by hooking into the 'admin_enqueue_scripts' event.
	 *
	 * @since 1.0.0
	 * @return array Array of events with their callback methods.
	 */
	public static function get_subscribed_events(): array {
		return array(
			'admin_enqueue_scripts' => 'manage_assets',
		);
	}
}
