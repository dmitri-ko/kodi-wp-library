<?php
/**
 * File name: class-theme-content-provider.php
 *
 * Provides functionality for managing theme configurations and content.
 *
 * @package Kodi
 * @subpackage ContentManagement
 * @since 1.0.0
 * @version 1.0.0
 * @license GPL-2.0-or-later
 * @author  BuzzDeveloper
 * @link    https://buzzdeveloper.net
 */

namespace Kodi\ContentManagement;

use Kodi\ContentManagement\Interfaces\Content_Data_Interface;
use Kodi\EventManagement\SubscriberInterface;
use Kodi\ContentManagement\Subscriber_Registry;
use Kodi\ContentManagement\Shortcode_Registry;

/**
 * Class Theme_Content_Provider
 *
 * Provides a unified interface to manage theme settings, subscribers, and shortcodes.
 *
 * @since 1.0.0
 */
class Theme_Content_Provider implements Content_Data_Interface {

	/**
	 * JSON configuration file name.
	 *
	 * @var string
	 */
	private const CONFIG_NAME = 'theme-settings.json';

	/**
	 * Indicates whether the configuration is loaded.
	 *
	 * @var bool
	 */
	private bool $is_loaded = false;

	/**
	 * Subscriber registry instance.
	 *
	 * @var Subscriber_Registry
	 */
	private Subscriber_Registry $subscriber_registry;

	/**
	 * Shortcode registry instance.
	 *
	 * @var Shortcode_Registry
	 */
	private Shortcode_Registry $shortcode_registry;

	/**
	 * Theme subscribers array.
	 *
	 * @var array
	 */
	private array $theme_subscribers = array();

	/**
	 * Theme shortcodes array.
	 *
	 * @var array
	 */
	private array $theme_shortcodes = array();

	/**
	 * Default settings for the theme configuration.
	 *
	 * @var array
	 */
	private array $default_settings = array();

	/**
	 * Constructor
	 *
	 * Initializes the registries with given subscribers, shortcodes, and default settings.
	 *
	 * @param array $theme_subscribers List of theme subscribers.
	 * @param array $theme_shortcodes  List of theme shortcodes.
	 * @param array $default_settings  Default settings for theme configuration.
	 */
	public function __construct( array $theme_subscribers, array $theme_shortcodes, array $default_settings ) {
		$this->theme_subscribers   = $theme_subscribers;
		$this->theme_shortcodes    = $theme_shortcodes;
		$this->default_settings    = $default_settings;
		$this->subscriber_registry = new Subscriber_Registry();
		$this->shortcode_registry  = new Shortcode_Registry();
	}

	/**
	 * Configures theme settings by loading and validating JSON data.
	 *
	 * Initializes the settings and registers required subscribers.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	private function configure(): void {
		$theme_settings_manager = new Theme_Settings_Manager();
		$file_path              = $this->get_file_path_from_theme( self::CONFIG_NAME );

		$ruleset = array(
			'version',
			'name',
			'slug',
			'settings' => $this->default_settings,
		);

		$settings = $theme_settings_manager->load_settings( $file_path, $ruleset );
		$this->subscriber_registry->register_subscribers( $this->theme_subscribers, $settings );
		$this->shortcode_registry->register_shortcodes( $this->theme_subscribers, $settings );

		$this->is_loaded = true;
	}

	/**
	 * Builds the path to the given file in the theme directory.
	 *
	 * @since 1.0.0
	 *
	 * @param string $file_name Name of the file.
	 * @param bool   $template  Optional. Use the template theme directory. Default false.
	 * @return string Full path to the file or empty string if unreadable.
	 */
	private function get_file_path_from_theme( string $file_name, bool $template = false ): string {
		$path      = $template ? get_template_directory() : get_stylesheet_directory();
		$candidate = $path . '/' . $file_name;

		return is_readable( $candidate ) ? $candidate : '';
	}

	/**
	 * Retrieve the theme's event subscribers.
	 *
	 * Ensures configuration is loaded before retrieving subscribers.
	 *
	 * @since 1.0.0
	 * @return SubscriberInterface[] Array of subscribers.
	 */
	public function get_subscribers(): array {
		if ( ! $this->is_loaded ) {
			$this->configure();
		}
		return $this->subscriber_registry->get_subscribers();
	}

	/**
	 * Retrieve the theme's shortcodes.
	 *
	 * Ensures configuration is loaded before retrieving shortcodes.
	 *
	 * @since 1.0.0
	 * @return array Array of shortcodes.
	 */
	public function get_shortcodes(): array {
		if ( ! $this->is_loaded ) {
			$this->configure();
		}
		return $this->shortcode_registry->get_shortcodes();
	}
}
