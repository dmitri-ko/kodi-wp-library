<?php
/**
 * FrontendAssetsSubscriber
 *
 * Handles the registration and enqueueing of frontend assets for the WordPress theme or plugin.
 *
 * @package    Kodi
 * @subpackage Subscriber\Frontend
 * @since      1.0.0
 */

namespace Kodi\Subscriber\Frontend;

use Kodi\Subscriber\BaseAssetsSubscriber;

/**
 * Class FrontendAssetsSubscriber
 *
 * Subscribes to WordPress events related to frontend assets, such as styles and scripts,
 * to properly manage asset loading.
 *
 * @since 1.0.0
 */
class FrontendAssetsSubscriber extends BaseAssetsSubscriber {

	/**
	 * Get the list of subscribed events.
	 *
	 * Returns an array of WordPress hooks and corresponding methods to manage
	 * the registration and enqueueing of frontend assets.
	 *
	 * @since 1.0.0
	 * @return array Array of hooks and callback methods.
	 */
	public static function get_subscribed_events(): array {
		return array(
			'wp_enqueue_scripts' => 'manage_assets',
		);
	}
}
