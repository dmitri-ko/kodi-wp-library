<?php
/**
 * WP theme configurator
 *
 * Handles WordPress theme configuration from theme-settings.json.
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Configurator
 */

namespace Kodi\Configurator;

use DKO\DDNA\AssetManagement\Asset_Path;
use DKO\DDNA\AssetManagement\Asset_Registrator;
use Kodi\EventManagement\Subscriber_Interface;
use Kodi\Provider\JSON_Provider;
use Kodi\Settings\Sanitized_Settings;
use Kodi\Subscriber\Admin_Assets_Subscriber;
use Kodi\Subscriber\Assets_Subscriber;
use Kodi\Validator\Settings_Validator;

/**
 * Class that abstracts the processing of the different data sources
 * for site-level content and offers an API to work with them.
 */
abstract class Base_Theme_Configurator implements Configurator {

	const CONFIG_NAME = 'theme-settings.json';

	/**
	 * Configuration endpoints
	 *
	 * @var array
	 */
	protected $hooks;


	/**
	 * Available settings
	 *
	 * @var array
	 */
	protected $available_settings;


	/**
	 * Subscribers
	 *
	 * @var Kodi\EventManagement\Subscriber_Interface[]
	 */
	protected $subscribers;

	/**
	 * Loaded flag
	 *
	 * @var bool
	 */
	protected $is_loaded;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->hooks              = array();
		$this->available_settings = array();
		$this->is_loaded          = false;
	}

	/**
	 * Builds the path to the given file and checks that it is readable.
	 *
	 * If it isn't, returns an empty string, otherwise returns the whole file path.
	 *
	 * @since 1.0.0
	 *
	 * @param string $file_name Name of the file.
	 * @param bool   $template  Optional. Use template theme directory. Default false.
	 * @return string The whole file path or empty if the file doesn't exist.
	 */
	private static function get_file_path_from_theme( $file_name, $template = false ) {
		$path      = $template ? get_template_directory() : get_stylesheet_directory();
		$candidate = $path . '/' . $file_name;

		return is_readable( $candidate ) ? $candidate : '';
	}

	/**
	 * Configure WordPress theme
	 */
	protected function configure() {
		$ruleset = array(
			'version',
			'name',
			'slug',
			Settings_Validator::SETTINGS_KEY => $this->available_settings,
		);

		$settings = new Sanitized_Settings(
			new JSON_Provider( self::get_file_path_from_theme( self::CONFIG_NAME ) ),
			new Settings_Validator( $ruleset )
		);

		$this->subscribers = array(
			new Assets_Subscriber(
				new Asset_Registrator(
					new Asset_Path( 'bundle-style', 'assets', get_stylesheet_directory(), get_stylesheet_uri() ),
					new Asset_Path( 'bundle', 'assets', get_stylesheet_directory(), get_stylesheet_uri() ),
					$settings->get_property( 'slug' ) . '-bundle',
					$settings->get_property( 'version' ),
					trailingslashit( get_stylesheet_directory() ) . 'language',
					$settings->get_property( 'slug' )
				)
			),
			new Admin_Assets_Subscriber(
				new Asset_Registrator(
					new Asset_Path( 'admin-style', 'assets', get_stylesheet_directory(), get_stylesheet_uri() ),
					new Asset_Path( 'admin', 'assets', get_stylesheet_directory(), get_stylesheet_uri() ),
					$settings->get_property( 'slug' ) . '-admin',
					$settings->get_property( 'version' ),
					trailingslashit( get_stylesheet_directory() ) . 'language',
					$settings->get_property( 'slug' )
				)
			),
		);

		foreach ( $this->hooks as $hook => $options ) {
			foreach ( $options as $option => $value ) {
				if ( $settings->has_support( $hook, $option ) ) {
					if ( $value instanceof Subscriber_Interface ) {
						array_push( $this->subscribers, $value );
					}
				}
			}
		}

		$this->is_loaded = true;
	}

	/**
	 * Get the plugin event subscribers.
	 *
	 * @return Kodi\EventManagement\Subscriber_Interface[]
	 */
	public function get_subscribers(): array {
		if ( ! $this->is_loaded ) {
			$this->configure();
		}
		return $this->subscribers;
	}

	/**
	 * Get the plugin shortcodes.
	 *
	 * @return Kodi\Shortcode\Shortcode_Interface[]
	 */
	abstract public function get_shortcodes(): array;
}
