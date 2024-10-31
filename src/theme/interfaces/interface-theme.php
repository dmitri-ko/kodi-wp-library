<?php
/**
 * Theme_Interface for WordPress
 *
 * This interface defines the basic structure that any theme implementation should follow.
 *
 * @package    Kodi
 * @subpackage Theme
 * @since      1.0.0
 * @version    1.0.0
 * @license    GPL-2.0-or-later
 * @link       https://buzzdeveloper.net
 * @author     BuzzDeveloper
 */

namespace Kodi\Theme\Interfaces;

/**
 * Interface Theme_Interface
 *
 * Specifies methods required for theme implementation.
 *
 * @since 1.0.0
 */
interface Theme_Interface {

	/**
	 * Load theme resources and initialize settings.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function load_theme(): void;
}
