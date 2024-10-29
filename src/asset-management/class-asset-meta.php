<?php
/**
 * AssetMeta
 *
 * Handles retrieval and parsing of metadata for assets in the WordPress environment.
 *
 * This class provides functionality to retrieve metadata, such as dependencies and versioning,
 * for JavaScript or CSS assets.
 *
 * @package    Kodi
 * @subpackage AssetManagement
 * @since      1.0.0
 */

namespace Kodi\AssetManagement;

/**
 * Class AssetMeta
 *
 * Retrieves asset metadata, such as dependencies and version, from specified files.
 *
 * @since 1.0.0
 */
class AssetMeta {

	/**
	 * Path to the metadata file.
	 *
	 * @var string
	 */
	private string $file_path;

	/**
	 * Constructor
	 *
	 * Initializes the AssetMeta object with the path to the metadata file.
	 *
	 * @param string $file_path Path to the metadata file.
	 */
	public function __construct( string $file_path ) {
		$this->file_path = $file_path;
	}

	/**
	 * Retrieve asset metadata.
	 *
	 * Reads metadata from the file path provided during initialization. Metadata typically
	 * includes dependencies and versioning information required for WordPress to properly
	 * enqueue styles and scripts.
	 *
	 * @since 1.0.0
	 * @throws \RuntimeException If the file cannot be read.
	 * @return array Associative array containing 'dependencies' and 'version'.
	 */
	public function get_assets(): array {
		if ( ! is_readable( $this->file_path ) ) {
			throw new \RuntimeException( sprintf( 'Asset metadata file %s is not readable.', $this->file_path ) );
		}

		$assets = include $this->file_path;

		if ( ! is_array( $assets ) || ! isset( $assets['dependencies'], $assets['version'] ) ) {
			throw new \RuntimeException( sprintf( 'Asset metadata file %s is not valid.', $this->file_path ) );
		}

		return $assets;
	}

	/**
	 * Check if metadata file exists and is readable.
	 *
	 * This method can be used to verify if the specified metadata file is available and can be read.
	 *
	 * @since 1.0.0
	 * @return bool True if the metadata file is readable, false otherwise.
	 */
	public function is_valid(): bool {
		return is_readable( $this->file_path );
	}
}
