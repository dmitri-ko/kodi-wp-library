<?php
/**
 * This file is part of the Kodi WordPress Library.
 *
 * (c) BuzzDeveloper
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author     BuzzDeveloper
 * @package    Kodi
 * @subpackage Subscriber
 */

namespace Kodi\Subscriber;

use Kodi\Configurator\Assets_Configurator;
use Kodi\EventManagement\Subscriber_Interface;

/**
 * Event subscriber that registers assets with WordPress.
 *
 * @author BuzzDeveloper
 */
class Admin_Assets_Subscriber implements Subscriber_Interface {
	/**
	 * Assets manager
	 *
	 * @var Assets_Configurator
	 */
	protected $asset_manager;

	/**
	 * Constructor
	 *
	 * @param  \Kodi\Configurator\Assets_Configurator $asset_manager Assets manager.
	 */
	public function __construct( Assets_Configurator $asset_manager ) {
		$this->asset_manager = $asset_manager;
	}

	/**
	 * {@inheritdoc}
	 */
	public static function get_subscribed_events() {
		return array(
			'admin_enqueue_scripts' => 'manage_assets',
		);
	}

	/**
	 * Add assets for the WordPress Admin UI.
	 */
	public function manage_assets() {
		$this->asset_manager->add_assets();
	}
}
