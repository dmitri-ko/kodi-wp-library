<?php
/**
 * BaseAssetsSubscriber
 *
 * Abstract class for managing asset registration for WordPress.
 * Uses AssetLoaderInterface to register styles and scripts.
 *
 * @package    Kodi
 * @subpackage Subscriber
 * @since      1.0.0
 */

namespace Kodi\Subscriber;

use Kodi\AssetManagement\Interfaces\AssetLoaderInterface;
use Kodi\EventManagement\Interfaces\SubscriberInterface;

/**
 * Class BaseAssetsSubscriber
 *
 * Provides base functionality for managing WordPress assets such as styles and scripts.
 * Implements the SubscriberInterface to allow for event subscriptions.
 *
 * @since 1.0.0
 */
abstract class BaseAssetsSubscriber implements SubscriberInterface {

	/**
	 * Asset loader instance used to register styles and scripts.
	 *
	 * @var AssetLoaderInterface
	 */
	protected AssetLoaderInterface $asset_loader;

	/**
	 * Constructor
	 *
	 * Initializes the BaseAssetsSubscriber with an instance of AssetLoaderInterface.
	 *
	 * @since 1.0.0
	 *
	 * @param AssetLoaderInterface $asset_loader Instance of asset loader used for managing assets.
	 */
	public function __construct( AssetLoaderInterface $asset_loader ) {
		$this->asset_loader = $asset_loader;
	}

	/**
	 * Register the assets.
	 *
	 * Calls the asset loader to register both styles and scripts for WordPress.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function manage_assets(): void {
		$this->asset_loader->register_styles();
		$this->asset_loader->register_scripts();
	}
}
