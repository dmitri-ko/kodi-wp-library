<?php
/**
 * SubscriberRegistry Class
 *
 * This file contains the SubscriberRegistry class, which is responsible for registering
 * and managing theme subscribers for both admin and frontend assets. It utilizes sanitized
 * settings to conditionally register subscribers and ensures all necessary assets are loaded.
 *
 * @package Kodi
 * @subpackage ContentManagement
 * @since 1.0.0
 * @version 1.0.0
 * @license GPL-2.0-or-later
 * @author  BuzzDeveloper
 * @link    https://buzzdeveloper.net
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
 * Registers and manages theme subscribers for WordPress assets.
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
	 * Registers subscribers based on provided settings.
	 *
	 * @param array             $subscribers Associative array of subscriber settings.
	 * @param SanitizedSettings $settings    The sanitized settings instance.
	 * @return void
	 */
	public function register_subscribers( array $subscribers, SanitizedSettings $settings ): void {
		foreach ( $subscribers as $setting => $options ) {
			foreach ( $options as $option => $subscriber ) {
				if ( $settings->has_support( $setting, $option ) ) {
					try {
						$this->add_subscriber( $subscriber );
					} catch ( \InvalidArgumentException $th ) {
						error_log( $th->getMessage() ); // TODO: implement error handling.
					}
				}
			}
		}
		$this->register_default_subscribers( $settings );
	}

	/**
	 * Registers default subscribers for frontend and admin assets.
	 *
	 * @param SanitizedSettings $settings The sanitized settings instance.
	 * @return void
	 */
	private function register_default_subscribers( SanitizedSettings $settings ): void {
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
					new AssetPath( 'admin-style', 'assets', get_stylesheet_directory(), get_stylesheet_directory_uri() ),
					new AssetPath( 'admin', 'assets', get_stylesheet_directory(), get_stylesheet_directory_uri() ),
					$settings->get_property( 'slug' ) . '-admin',
					$settings->get_property( 'version' ),
					trailingslashit( get_stylesheet_directory() ) . 'language',
					$settings->get_property( 'slug' )
				)
			),
		);
	}

	/**
	 * Adds an additional subscriber to the registry.
	 *
	 * @param SubscriberInterface $subscriber The subscriber to be added.
	 * @return void
	 */
	public function add_subscriber( SubscriberInterface $subscriber ): void {
		$this->subscribers[] = $subscriber;
	}

	/**
	 * Retrieves all registered subscribers.
	 *
	 * @return SubscriberInterface[] Array of registered subscribers.
	 */
	public function get_subscribers(): array {
		return $this->subscribers;
	}
}
