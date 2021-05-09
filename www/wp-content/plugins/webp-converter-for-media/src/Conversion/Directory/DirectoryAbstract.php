<?php

namespace WebpConverter\Conversion\Directory;

use WebpConverter\Conversion\Directory\DirectoryInterface;

/**
 * Abstract class for class that supports data about directory.
 */
abstract class DirectoryAbstract implements DirectoryInterface {

	/**
	 * Returns label of directory.
	 *
	 * @return string Directory label.
	 */
	public function get_label(): string {
		return '';
	}

	/**
	 * Returns status if directory is available.
	 *
	 * @return bool Directory is available?
	 */
	public function is_available(): bool {
		return ( file_exists( $this->get_server_path() ) );
	}

	/**
	 * Returns status if directory is destined for output.
	 *
	 * @return bool Directory for output?
	 */
	public function is_output_directory(): bool {
		return false;
	}

	/**
	 * Returns server path of directory.
	 *
	 * @return string Server path of directory.
	 */
	public function get_server_path(): string {
		$source_path = apply_filters( 'webpc_site_root', realpath( ABSPATH ) );
		return sprintf( '%1$s/%2$s', $source_path, $this->get_relative_path() );
	}

	/**
	 * Returns URL of directory.
	 *
	 * @return string URL of directory.
	 */
	public function get_path_url(): string {
		$source_url = apply_filters( 'webpc_site_url', get_site_url() );
		return sprintf( '%1$s/%2$s', $source_url, $this->get_relative_path() );
	}
}
