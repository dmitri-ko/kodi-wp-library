<?php
/**
 * This file is part of the Kodi WordPress Library.
 *
 * (c) BuzzDeveloper
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author     BuzzDeveloper
 * @package    Kodi
 * @subpackage AssetManagement
 */

namespace DKO\DDNA\AssetManagement;

use DKO\DDNA\AssetManagement\Asset_Meta;
use DKO\DDNA\AssetManagement\Asset_Path;
use Kodi\Configurator\Assets_Configurator;

/**
 * Event subscriber that registers assets with WordPress.
 *
 * @author BuzzDeveloper
 */
class Asset_Registrator implements Assets_Configurator {


	/**
	 * Path to the style.
	 *
	 * @var Asset_Path
	 */
	private $style_path;

	/**
	 * Path to the script.
	 *
	 * @var Asset_Path
	 */
	private $script_path;

	/**
	 * The language path for translations.
	 *
	 * @var string
	 */
	private $lang_path;

	/**
	 * The asset name.
	 *
	 * @var string
	 */
	private $asset_name;

	/**
	 * The asset version
	 *
	 * @var string
	 */
	private $asset_version;

	/**
	 * The asset text domain.
	 *
	 * @var string
	 */
	private $asset_domain;

	/**
	 * Constructor
	 *
	 * @param Asset_Path $style_path    Path to the style.
	 * @param Asset_Path $script_path   Path to the script.
	 * @param string     $asset_name    The asset name.
	 * @param string     $asset_version The asset version.
	 * @param string     $lang_path     The language path for translations.
	 * @param string     $asset_domain     The text domain for translations.
	 */
	public function __construct( Asset_Path $style_path, Asset_Path $script_path, string $asset_name, string $asset_version, string $lang_path, string $asset_domain = 'default' ) {
		$this->style_path    = $style_path;
		$this->script_path   = $script_path;
		$this->asset_name    = $asset_name;
		$this->asset_version = $asset_version;
		$this->lang_path     = $lang_path;
		$this->asset_domain  = $asset_domain;
	}
	/**
	 * Add assets for the WordPress Admin UI.
	 */
	public function add_assets() {

		if ( $this->style_path->exists( 'css', true ) ) {
			wp_enqueue_style(
				$this->asset_name,
				$this->style_path->get_url( 'css', true ),
				array(),
				$this->asset_version,
				'all'
			);
		}

		if ( $this->script_path->exists( 'js', true ) ) {
			try {
				$assets = ( new Asset_Meta( $this->script_path->get_full_filename( 'php', true ) ) )->get_assets();
			} catch ( \Error $e ) {
				$assets = array(
					'dependencies' => array( 'wp-plugins', 'wp-edit-post', 'wp-element', 'wp-i18n' ),
					'version'      => $this->asset_version,
				);
			}
			$assets['dependencies'] = array_merge( $assets['dependencies'], array( 'wp-api' ) );
			wp_enqueue_script(
				$this->asset_name,
				$this->script_path->get_url( 'js', true ),
				$assets['dependencies'],
				$assets['version'],
				true
			);

			if ( function_exists( 'wp_set_script_translations' ) ) {
				wp_set_script_translations(
					$this->asset_name,
					$this->asset_domain,
					$this->lang_path
				);
			}
		}
	}
}
