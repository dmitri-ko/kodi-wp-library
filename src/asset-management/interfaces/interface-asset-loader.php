<?php
/**
 * AssetLoaderInterface
 *
 * Interface for registering and enqueuing assets (styles and scripts) in WordPress themes or plugins.
 *
 * @package     Kodi
 * @subpackage AssetManagement
 * @since      1.0.0
 */

 namespace Kodi\AssetManagement\Interfaces;

/**
 * Interface AssetLoaderInterface
 *
 * Provides methods for registering and enqueuing styles and scripts for a WordPress theme or plugin.
 *
 * This interface defines the essential methods that any asset loader should implement
 * to ensure styles and scripts are properly enqueued or registered, promoting consistent
 * asset management across the theme or plugin.
 *
 * @since 1.0.0
 */
interface AssetLoaderInterface {
	/**
	 * Registers styles.
	 */
	public function register_styles(): void;

	/**
	 * Registers scripts.
	 */
	public function register_scripts(): void;
}
