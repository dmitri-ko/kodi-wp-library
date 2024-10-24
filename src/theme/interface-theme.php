<?php
/**
 * WordPress OOP theme interface
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Theme
 */

namespace Kodi\Theme;

/**
 * Theme interface
 */
interface Theme {
	/**
	 *  Load theme
	 */
	public function load();
}
