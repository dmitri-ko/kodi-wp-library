<?php
/**
 * SubscriberRegistry
 *
 * Registers and manages theme-related subscribers.
 *
 * @package    Kodi
 * @subpackage ContentManagement
 * @since      1.0.0
 */

namespace Kodi\ContentManagement;

use Kodi\AssetManagement\AssetPath;
use Kodi\AssetManagement\DefaultAssetLoader;
use Kodi\EventManagement\Interfaces\SubscriberInterface;
use Kodi\Settings\SanitizedSettings;
use Kodi\Subscriber\Admin\AdminAssetsSubscriber;
use Kodi\Subscriber\Frontend\FrontendAssetsSubscriber;

/**
 * Class SubscriberRegistry
 *
 * Registers and manages theme subscribers.
 *
 * @since 1.0.0
 */
class SubscriberRegistry {

	/**
	 * Array of registered subscribers.
	 *
	 * @var SubscriberInterface[]
	 */
	private array $subscribers = array();

	/**
	 * Register default subscribers.
	 *
	 * @param SanitizedSettings $settings The validated settings.
	 * @return void
	 */
	public function register_default_subscribers( SanitizedSettings $settings ): void {
		$this->subscribers = array(
			new FrontendAssetsSubscriber(
				new DefaultAssetLoader(
					new AssetPath( 'bundle-style', 'assets', get_stylesheet_directory(), get_stylesheet_uri() ),
					new AssetPath( 'bundle', 'assets', get_stylesheet_directory(), get_stylesheet_uri() ),
					$settings->get_property( 'slug' ) . '-bundle',
					$settings->get_property( 'version' ),
					trailingslashit( get_stylesheet_directory() ) . 'language',
					$settings->get_property( 'slug' )
				)
			),
			new AdminAssetsSubscriber(
				new DefaultAssetLoader(
					new AssetPath( 'admin-style', 'assets', get_stylesheet_directory(), get_stylesheet_uri() ),
					new AssetPath( 'admin', 'assets', get_stylesheet_directory(), get_stylesheet_uri() ),
					$settings->get_property( 'slug' ) . '-admin',
					$settings->get_property( 'version' ),
					trailingslashit( get_stylesheet_directory() ) . 'language',
					$settings->get_property( 'slug' )
				)
			),
		);
	}

	/**
	 * Add additional subscriber.
	 *
	 * @param SubscriberInterface $subscriber The subscriber to be added.
	 * @return void
	 */
	public function add_subscriber( SubscriberInterface $subscriber ): void {
		$this->subscribers[] = $subscriber;
	}

	/**
	 * Get all subscribers.
	 *
	 * @return SubscriberInterface[] Array of subscribers.
	 */
	public function get_subscribers(): array {
		return $this->subscribers;
	}
}
