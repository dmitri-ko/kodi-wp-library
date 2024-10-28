<?php
/**
 * WordPress OOP theme
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Theme
 */

namespace Kodi\Theme;

use Kodi\Configurator\Configurator;
use Kodi\EventManagement\Event_Manager;
use Kodi\EventManagement\Subscriber_Interface;
use Kodi\Shortcode\Shortcode_Interface;

/**
 * The core theme class.
 * Defines internationalization, admin-specific hooks, and public-facing site hooks.
 *
 * @link https://buzzdeveloper.net
 *
 * @author BuzzDeveloper
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
	private $configurator;


	public function __construct( string $name, Configurator $configurator ) {
		$this->event_manager = new Event_Manager();
		$this->loaded        = false;
		$this->name          = $name;
		$this->configurator  = $configurator;
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

		foreach ( $this->configurator->get_subscribers() as $subscriber ) {
			$this->event_manager->add_subscriber( $subscriber );
		}

		foreach ( $this->configurator->get_shortcodes() as $shortcode ) {
			$this->register_shortcode( $shortcode );
		}

		$this->loaded = true;
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
