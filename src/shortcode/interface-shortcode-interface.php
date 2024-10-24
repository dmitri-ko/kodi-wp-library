<?php
/**
 * WordPress shortcodes
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Shortcode
 */

 namespace Kodi\Shortcode;

/**
 * A shortcode represents the shortcode registered with the WordPress shortcode API.
 *
 * @author Walger Marketing
 */
interface Shortcode_Interface {

	/**
	 * Get the tag name used by the shortcode.
	 *
	 * @return string
	 */
	public static function get_name(): string;

	/**
	 * Handles the output of the shortcode.
	 *
	 * @param  array|string $attributes Shortcode attributes.
	 * @param  string       $content    Shortcode content.
	 * @return string
	 */
	public function handle( $attributes, string $content = '' ) : string;

}
