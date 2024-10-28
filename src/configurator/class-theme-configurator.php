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

use Kodi\Provider\JSON_Provider;
use Kodi\Settings\Sanitized_Settings;
use Kodi\Settings\Settings;
use Kodi\Validator\Settings_Validator;

/**
 * Class that abstracts the processing of the different data sources
 * for site-level content and offers an API to work with them.
 */
class Theme_Configurator implements Configurator {

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

	public function __construct( array $hooks, array $available_settings ) {
		$this->hooks              = $hooks;
		$this->available_settings = $available_settings;
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
	public function configure(): array {
		$cfg     = array();
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

		foreach ( $this->hooks as $hook => $options ) {
			foreach ( $options as $option => $value ) {
				if ( $settings->has_support( $hook, $option ) ) {
					array_push( $cfg, $value );
				}
			}
		}

		return $cfg;
	}
}
