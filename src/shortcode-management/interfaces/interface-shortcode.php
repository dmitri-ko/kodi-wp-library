<?php
/**
 * Interface ShortcodeInterface
 *
 * Defines a contract for shortcode handlers, specifying required methods
 * for retrieving shortcode tag and handler.
 *
 * @package Kodi
 * @subpackage Shortcode
 * @author  BuzzDeveloper
 */

namespace Kodi\Shortcodes\Interfaces;

interface ShortcodeInterface {

	/**
	 * Retrieve the shortcode tag.
	 *
	 * @return string The unique tag for the shortcode.
	 */
	public function get_tag(): string;

	/**
	 * Retrieve the shortcode handler function name or callable.
	 *
	 * @return string The handler associated with the shortcode.
	 */
	public function get_handler(): string;
}
