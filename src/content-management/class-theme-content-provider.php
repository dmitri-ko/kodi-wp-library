<?php
/**
 * ThemeContentProvider
 *
 * Manages WordPress theme settings, subscribers, and shortcodes.
 *
 * @package    Kodi
 * @subpackage ContentManagement
 * @since      1.0.0
 */

namespace Kodi\ContentManagement;

use Kodi\ContentManagement\Interfaces\ContentDataInterface;
use Kodi\EventManagement\SubscriberInterface;

/**
 * Class ThemeContentProvider
 *
 * Provides a unified interface to manage theme settings, subscribers, and shortcodes.
 *
 * @since 1.0.0
 */
class ThemeContentProvider implements ContentDataInterface {

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
	 * @var SubscriberRegistry
	 */
	private SubscriberRegistry $subscriber_registry;

	/**
	 * Shortcode registry instance.
	 *
	 * @var ShortcodeRegistry
	 */
	private ShortcodeRegistry $shortcode_registry;

	/**
	 * Constructor
	 *
	 * Initializes the registries.
	 */
	public function __construct() {
		$this->subscriber_registry = new SubscriberRegistry();
		$this->shortcode_registry  = new ShortcodeRegistry();
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
		$theme_settings_manager = new ThemeSettingsManager();
		$file_path              = $this->get_file_path_from_theme( self::CONFIG_NAME );

		$ruleset = array(
			'version',
			'name',
			'slug',
			'settings_key' => array(),
		);

		$settings = $theme_settings_manager->load_settings( $file_path, $ruleset );
		$this->subscriber_registry->register_default_subscribers( $settings );

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
	 * @since 1.0.0
	 * @return array Array of shortcodes.
	 */
	public function get_shortcodes(): array {
		return $this->shortcode_registry->get_shortcodes();
	}
}
