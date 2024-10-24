<?php
/**
 * The JSON file Provider
 *
 * Handles theme settings file resolve.
 *
 * @since             1.0.0
 * @package           Kodi
 * @subpackage        Provider
 */

namespace Kodi\Provider;

/**
 * Class that abstracts the processing of the different data sources
 * for site-level content and offers an API to work with them.
 */
class JSON_Provider implements Provider {

	/**
	 * File name
	 *
	 * @var string
	 */
	protected $filename;

	/**
	 * Constructor
	 *
	 * @param  string $filename File name.
	 */
	public function __construct( string $filename ) {
		$this->filename = $filename;
	}

	/**
	 * Processes a file and returns an array with its contents, or a void array if none found.
	 *
	 * @return array
	 */
	private function read_from_file(): array {
		$content = array();
		if ( ! empty( $this->filename ) && file_exists( $this->filename ) ) {
			$decoded_file = wp_json_file_decode( $this->filename, array( 'associative' => true ) );
			if ( is_array( $decoded_file ) ) {
				$content = $decoded_file;
			}
		}
		return $content;
	}

	/**
	 * Provide data
	 *
	 * @return array
	 */
	public function get_data(): array {
		return $this->read_from_file();
	}
}
