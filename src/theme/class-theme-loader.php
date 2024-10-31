<?php
/**
 * ThemeLoader Class
 *
 * This file contains the ThemeLoader class, which is responsible for loading
 * and initializing a WordPress theme, including registering event subscribers
 * and shortcodes. It ensures the theme is fully prepared for the WordPress
 * environment by utilizing EventManager and ShortcodeManager services.
 *
 * @package Kodi
 * @subpackage Theme
 * @since 1.0.0
 * @version 1.0.0
 * @author  BuzzDeveloper
 * @license GPL-2.0-or-later
 * @link    https://buzzdeveloper.net
 */

namespace Kodi\Theme;

use Kodi\ContentManagement\Interfaces\ContentDataInterface;
use Kodi\EventManagement\EventManager;
use Kodi\Shortcodes\ShortcodeManager;
use Kodi\Theme\Interfaces\ThemeInterface;

/**
 * Class ThemeLoader
 *
 * Loads and initializes the WordPress theme, including subscribers and shortcodes.
 *
 * @since 1.0.0
 */
class ThemeLoader implements ThemeInterface {

	/**
	 * Event manager instance for managing theme events.
	 *
	 * @var EventManager
	 */
	private $event_manager;

	/**
	 * Shortcode manager instance for managing shortcodes.
	 *
	 * @var ShortcodeManager
	 */
	private $shortcode_manager;

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
	 * The theme content configurator.
	 *
	 * @var ContentDataInterface
	 */
	private $content_data_interface;

	/**
	 * ThemeLoader constructor.
	 *
	 * Initializes the theme with the given name, configurator, event manager, and shortcode manager.
	 *
	 * @param string               $theme_name             The theme name.
	 * @param ContentDataInterface $content_data_interface Content configurator for theme settings.
	 * @param EventManager         $event_manager          Event manager for handling theme events.
	 * @param ShortcodeManager     $shortcode_manager      Shortcode manager for handling theme shortcodes.
	 */
	public function __construct( string $theme_name, ContentDataInterface $content_data_interface, EventManager $event_manager, ShortcodeManager $shortcode_manager ) {
		$this->theme_name             = $theme_name;
		$this->content_data_interface = $content_data_interface;
		$this->event_manager          = $event_manager;
		$this->shortcode_manager      = $shortcode_manager;
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
	 * Initializes the theme by loading subscribers and shortcodes,
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
	 * Load event subscribers from the content configurator.
	 *
	 * This method iterates over subscribers provided by the configurator
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
	 * Load shortcodes from the content configurator.
	 *
	 * This method iterates over shortcodes provided by the configurator
	 * and registers each with the shortcode manager.
	 *
	 * @return void
	 */
	private function load_shortcodes(): void {
		foreach ( $this->content_data_interface->get_shortcodes() as $shortcode ) {
			$this->shortcode_manager->add_shortcode( $shortcode );
		}
	}
}
