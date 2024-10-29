<?php
/**
 * WP_Theme Class
 *
 * Provides an implementation of the ThemeInterface to load and manage a WordPress theme.
 *
 * @package    Kodi
 * @subpackage Theme
 * @since      1.0.0
 */

namespace Kodi\Theme;

use Kodi\ContentManagement\Interfaces\ContentDataInterface;
use Kodi\EventManagement\EventManager;
use Kodi\Theme\Interfaces\ThemeInterface;

/**
 * Class WP_Theme
 *
 * A concrete implementation of ThemeInterface to manage the loading and configuration
 * of a WordPress theme. This class is responsible for initializing theme settings,
 * managing event subscribers, and registering shortcodes.
 *
 * @since 1.0.0
 */
class ThemeLoader implements ThemeInterface {

	/**
	 * The plugin event manager.
	 *
	 * @var EventManager
	 */
	private $event_manager;

	/**
	 * Flag to track if the theme is loaded.
	 *
	 * @var bool
	 */
	private $is_loaded = false;

	/**
	 * The theme name.
	 *
	 * @var string
	 */
	private $theme_name;

	/**
	 * The theme configurator.
	 *
	 * @var ContentDataInterface
	 */
	private $content_data_interface;

	/**
	 * WP_Theme constructor.
	 *
	 * Initializes the theme with the given name, configurator, and event manager.
	 *
	 * @param string               $theme_name              The theme name.
	 * @param ContentDataInterface $content_data_interface  Configurator for theme settings.
	 * @param EventManager         $event_manager          Event manager for theme event handling.
	 */
	public function __construct( string $theme_name, ContentDataInterface $content_data_interface, EventManager $event_manager ) {
		$this->theme_name             = $theme_name;
		$this->content_data_interface = $content_data_interface;
		$this->event_manager          = $event_manager;
	}

	/**
	 * Checks if the theme is loaded.
	 *
	 * @return bool True if the theme is loaded, false otherwise.
	 */
	public function is_loaded(): bool {
		return $this->is_loaded;
	}

	/**
	 * Load the theme into WordPress.
	 *
	 * Initializes theme by loading subscribers and shortcodes
	 * and sets the loaded flag to true once completed.
	 *
	 * @return void
	 */
	public function load_theme(): void {
		if ( $this->is_loaded() ) {
			return;
		}

		$this->load_subscribers();
		$this->load_shortcodes();

		$this->is_loaded = true;
	}

	/**
	 * Load event subscribers from the configurator.
	 *
	 * This method iterates over the subscribers provided by the configurator
	 * and registers each with the event manager.
	 *
	 * @return void
	 */
	private function load_subscribers(): void {
		foreach ( $this->content_data_interface->get_subscribers() as $subscriber ) {
			$this->event_manager->add_subscriber( $subscriber );
		}
	}

	/**
	 * Load shortcodes from the configurator.
	 *
	 * This method retrieves shortcodes from the configurator and registers each
	 * one using the register_shortcode() method.
	 *
	 * @return void
	 */
	private function load_shortcodes(): void {
		foreach ( $this->content_data_interface->get_shortcodes() as $shortcode ) {
			$this->register_shortcode( $shortcode );
		}
	}

	/**
	 * Register the given shortcode with the WordPress shortcode API.
	 *
	 * This method registers the shortcode by using the provided slug and handler.
	 *
	 * @param array $shortcode An associative array containing 'slug' and 'handle' for the shortcode.
	 * @return void
	 */
	private function register_shortcode( array $shortcode ): void {
		add_shortcode( $shortcode['slug'], $shortcode['handle'] );
	}
}
