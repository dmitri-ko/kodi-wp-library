<?php
/**
 * Shortcode_Manager Class
 *
 * This file contains the Shortcode_Manager class, which handles
 * the registration, execution, and removal of shortcodes within
 * the WordPress environment.
 *
 * @package Kodi
 * @subpackage Shortcodes
 * @since 1.0.0
 * @version 1.0.0
 * @license GPL-2.0-or-later
 * @link    https://buzzdeveloper.net
 * @author  BuzzDeveloper
 */

namespace Kodi\Shortcodes;

use Kodi\Shortcodes\Interfaces\Shortcode_Interface;

/**
 * Class Shortcode_Manager
 *
 * Manages the registration, execution, and removal of shortcodes.
 *
 * @since 1.0.0
 */
class Shortcode_Manager {

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
	 * @param Shortcode_Interface $shortcode The shortcode object implementing Shortcode_Interface.
	 *
	 * @return void
	 */
	public function add_shortcode( Shortcode_Interface $shortcode ): void {
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
	 * @param Shortcode_Interface $shortcode The shortcode object implementing Shortcode_Interface.
	 *
	 * @return void
	 */
	public function remove_shortcode( Shortcode_Interface $shortcode ): void {
		remove_shortcode( $shortcode->get_tag() );
	}
}
