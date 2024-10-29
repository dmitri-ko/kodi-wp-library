<?php
/**
 * Theme Interface for WordPress
 *
 * This interface defines the basic structure that any theme implementation should follow.
 *
 * @package Kodi
 * @subpackage Theme
 */

namespace Kodi\Theme\Interfaces;

/**
 * Interface ThemeInterface
 */
interface ThemeInterface {

	/**
	 * Load theme resources and initialize settings.
	 *
	 * @return void
	 */
	public function load_theme();
}
