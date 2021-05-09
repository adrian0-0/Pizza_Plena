<?php

namespace WebpConverter\Settings;

use WebpConverter\Settings\Option\OptionInterface;
use WebpConverter\Settings\Option\OptionIntegration;
use WebpConverter\Settings\Option\LoaderTypeOption;
use WebpConverter\Settings\Option\OutputFormatsOption;
use WebpConverter\Settings\Option\SupportedExtensionsOption;
use WebpConverter\Settings\Option\SupportedDirectoriesOption;
use WebpConverter\Settings\Option\ConversionMethodOption;
use WebpConverter\Settings\Option\ImagesQualityOption;
use WebpConverter\Settings\Option\ExtraFeaturesOption;

/**
 * Allows to integration with plugin settings by providing list of settings fields and saved values.
 */
class Options {

	/**
	 * Returns options of plugin settings.
	 *
	 * @param bool         $is_debug        Is debugging?
	 * @param array[]|null $posted_settings Settings submitted in form.
	 *
	 * @return array[] Options of plugin settings.
	 */
	public function get_options( bool $is_debug = false, array $posted_settings = null ): array {
		$is_save  = ( $posted_settings !== null );
		$settings = ( $is_save ) ? $posted_settings : get_option( SettingsSave::SETTINGS_OPTION, [] );

		$options = [];
		foreach ( $this->get_option_objects() as $option_object ) {
			$options[] = ( new OptionIntegration( $option_object ) )->get_option_data( $settings, $is_debug, $is_save );
		}
		return $options;
	}

	/**
	 * Returns objects for options of plugin settings.
	 *
	 * @return OptionInterface[] .
	 */
	private function get_option_objects(): array {
		return [
			new LoaderTypeOption(),
			new SupportedExtensionsOption(),
			new SupportedDirectoriesOption(),
			new ConversionMethodOption(),
			new OutputFormatsOption(),
			new ImagesQualityOption(),
			new ExtraFeaturesOption(),
		];
	}

	/**
	 * Returns values of plugin settings.
	 *
	 * @param bool         $is_debug        Is debugging?
	 * @param array[]|null $posted_settings Settings submitted in form.
	 *
	 * @return array[] Values of plugin settings.
	 */
	public function get_values( bool $is_debug = false, array $posted_settings = null ): array {
		$values = [];
		foreach ( $this->get_options( $is_debug, $posted_settings ) as $option ) {
			$values[ $option['name'] ] = $option['value'];
		}
		return $values;
	}
}
