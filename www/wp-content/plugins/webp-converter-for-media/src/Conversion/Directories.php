<?php

namespace WebpConverter\Conversion;

use WebpConverter\HookableInterface;
use WebpConverter\Conversion\Directory\DirectoriesIntegration;
use WebpConverter\Conversion\Directory\UploadsDirectory;
use WebpConverter\Conversion\Directory\GalleryDirectory;
use WebpConverter\Conversion\Directory\UploadsWebpcDirectory;
use WebpConverter\Conversion\Directory\PluginsDirectory;
use WebpConverter\Conversion\Directory\ThemesDirectory;
use WebpConverter\Plugin\Uninstall\WebpFiles;

/**
 * Initializes integration for all directories.
 */
class Directories implements HookableInterface {

	/**
	 * Objects of supported directories.
	 *
	 * @var DirectoriesIntegration
	 */
	private $directories_integration;

	/**
	 * Directories constructor.
	 */
	public function __construct() {
		$this->directories_integration = ( new DirectoriesIntegration() )
			->add_directory( new GalleryDirectory() )
			->add_directory( new PluginsDirectory() )
			->add_directory( new ThemesDirectory() )
			->add_directory( new UploadsDirectory() )
			->add_directory( new UploadsWebpcDirectory() );
	}

	/**
	 * Integrates with WordPress hooks.
	 *
	 * @return void
	 */
	public function init_hooks() {
		$this->directories_integration->init_hooks();
	}

	/**
	 * Returns list of source directories.
	 *
	 * @return string[] Types of directories with labels.
	 */
	public function get_directories(): array {
		return $this->directories_integration->get_input_directories();
	}

	/**
	 * Removes converted files from output directory.
	 *
	 * @param string[] $source_dirs Types of source directories.
	 *
	 * @return void
	 */
	public function remove_unused_output_directories( array $source_dirs ) {
		$all_dirs = $this->directories_integration->get_output_directories();
		foreach ( $all_dirs as $output_dir => $output_path ) {
			if ( in_array( $output_dir, $source_dirs ) ) {
				continue;
			}
			WebpFiles::remove_webp_files( $output_path );
		}
	}
}
