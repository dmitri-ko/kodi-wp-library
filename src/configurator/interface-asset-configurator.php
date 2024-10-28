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
 * @subpackage Configurator
 */

namespace Kodi\Configurator;

/**
 * Assets configurator interface for WordPress.
 *
 * @author BuzzDeveloper
 */
interface Assets_Configurator {
	/**
	 * Add assets for the WordPress Admin UI.
	 */
	public function add_assets();
}
