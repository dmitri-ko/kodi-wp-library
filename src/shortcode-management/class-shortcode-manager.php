<?php
/**
 * ShortcodeManager Class
 *
 * This file contains the ShortcodeManager class, which handles
 * the registration, execution, and removal of shortcodes within
 * the WordPress environment.
 *
 * @package Kodi
 * @subpackage Shortcodes
 * @author  BuzzDeveloper
 * @license GPL-2.0-or-later
 * @link    https://buzzdeveloper.net
 */

namespace Kodi\Shortcodes;

use Kodi\Shortcodes\Interfaces\ShortcodeInterface;

/**
 * Class ShortcodeManager
 *
 * Manages the registration, execution, and removal of shortcodes.
 */
class ShortcodeManager {

	/**
	 * Register a callback function for a given shortcode tag.
	 *
	 * @param string   $tag      The unique tag for the shortcode.
	 * @param callable $callback The callback function for the shortcode.
	 *
	 * @return void
	 */
	private function add_callback( string $tag, callable $callback ): void {
		add_shortcode( $tag, $callback );
	}

	/**
	 * Register a shortcode by its interface.
	 *
	 * @param ShortcodeInterface $shortcode The shortcode object implementing ShortcodeInterface.
	 *
	 * @return void
	 */
	public function add_shortcode( ShortcodeInterface $shortcode ): void {
		$this->add_callback( $shortcode->get_tag(), array( $shortcode, $shortcode->get_handler() ) );
	}

	/**
	 * Execute registered shortcodes.
	 *
	 * @param mixed ...$args Arguments to pass to do_shortcode.
	 *
	 * @return void
	 */
	public function execute( ...$args ): void {
		do_shortcode( ...$args );
	}

	/**
	 * Check if a shortcode with a specific tag exists.
	 *
	 * @param string $tag The shortcode tag to check for existence.
	 *
	 * @return bool True if the shortcode exists, false otherwise.
	 */
	public function has_shortcode( string $tag ): bool {
		return shortcode_exists( $tag );
	}

	/**
	 * Remove a shortcode by its interface.
	 *
	 * @param ShortcodeInterface $shortcode The shortcode object implementing ShortcodeInterface.
	 *
	 * @return void
	 */
	public function remove_shortcode( ShortcodeInterface $shortcode ): void {
		remove_shortcode( $shortcode->get_tag() );
	}
}
