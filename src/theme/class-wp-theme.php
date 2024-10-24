<?php
/**
 * WordPress OOP theme
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Theme
 */

namespace Kodi\Theme;

use Kodi\EventManagement\Event_Manager;
use Kodi\EventManagement\Subscriber_Interface;
use Kodi\Shortcode\Shortcode_Interface;

/**
 * The core theme class.
 * Defines internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * @link https://www.walger-marketing.de/dko-events
 *
 * @author Walger Marketing
 */
class WP_Theme implements Theme {

	/**
	 * The plugin event manager.
	 *
	 * @var Event_Manager
	 */
	private $event_manager;

	/**
	 * Flag to track if the theme is loaded.
	 *
	 * @var bool
	 */
	private $loaded;

	private $name;
	private $slug;
	private $subscribers;

	/**
	 * Constructor.
	 *
	 * @param string $file Path to the plugin dir.
	 */
	public function __construct( string $name, array $subscribers ) {
		$this->event_manager = new Event_Manager();
		$this->loaded        = false;
		$this->name          = $name;
		$this->subscribers   = $subscribers;
	}

	/**
	 * Checks if the theme is loaded.
	 *
	 * @return bool
	 */
	public function is_loaded() {
		return $this->loaded;
	}

	/**
	 * Load the theme into WordPress
	 *
	 * @return void
	 */
	public function load() {
		if ( $this->is_loaded() ) {
			return;
		}

		foreach ( $this->get_subscribers() as $subscriber ) {
			$this->event_manager->add_subscriber( $subscriber );
		}

		foreach ( $this->get_shortcodes() as $shortcode ) {
			$this->register_shortcode( $shortcode );
		}

		$this->loaded = true;
	}

	/**
	 * Get the plugin shortcodes.
	 *
	 * @return Shortcode_Interface[]
	 */
	private function get_shortcodes() {
		return array();
	}
	/**
	 * Get the plugin event subscribers.
	 *
	 * @return Subscriber_Interface[]
	 */
	private function get_subscribers(): array {
		$valid_subscribers = array();
		foreach ( $this->subscribers as $maybe_valid_subscriber ) {
			if ( $maybe_valid_subscriber instanceof Subscriber_Interface ) {
				array_push( $valid_subscribers, $maybe_valid_subscriber );
			}
		}

		return $valid_subscribers;
	}

	/**
	 * Register the given shortcode with the WordPress shortcode API.
	 *
	 * @param Shortcode_Interface $shortcode Shortcode.
	 */
	private function register_shortcode( Shortcode_Interface $shortcode ) {
		add_shortcode( $shortcode::get_name(), array( $shortcode, 'handle' ) );
	}
}
