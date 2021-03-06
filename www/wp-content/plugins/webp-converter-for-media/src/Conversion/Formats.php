<?php

namespace WebpConverter\Conversion;

use WebpConverter\Conversion\Format\FormatInterface;
use WebpConverter\Conversion\Format\AvifFormat;
use WebpConverter\Conversion\Format\WebpFormat;

/**
 * Adds support for all output formats and returns information about them.
 */
class Formats {

	/**
	 * Objects of supported output formats.
	 *
	 * @var FormatInterface[]
	 */
	private $formats = [];

	/**
	 * Formats constructor.
	 */
	public function __construct() {
		$this->formats[] = new AvifFormat();
		$this->formats[] = new WebpFormat();
	}

	/**
	 * Returns list of output formats.
	 *
	 * @return string[] Extensions of output formats with labels.
	 */
	public function get_formats(): array {
		$values = [];
		foreach ( $this->formats as $format ) {
			$values[ $format->get_extension() ] = $format->get_label();
		}
		return $values;
	}

	/**
	 * Returns list of available output formats.
	 *
	 * @param string $conversion_method Name of conversion method.
	 *
	 * @return string[] Extensions of output formats with labels.
	 */
	public function get_available_formats( string $conversion_method ): array {
		$values = [];
		foreach ( $this->formats as $format ) {
			if ( ! $format->is_available( $conversion_method ) ) {
				continue;
			}
			$values[ $format->get_extension() ] = $format->get_label();
		}
		return $values;
	}

	/**
	 * Returns extensions of output formats.
	 *
	 * @return string[] Extensions of output formats.
	 */
	public function get_format_extensions(): array {
		$values = [];
		foreach ( $this->formats as $format ) {
			$values[] = $format->get_extension();
		}
		return $values;
	}

	/**
	 * Returns mime types of output formats.
	 *
	 * @param string[] $output_formats Extensions of output formats.
	 *
	 * @return string[] Mime types of output formats.
	 */
	public function get_mime_types( array $output_formats ): array {
		$values = [];
		foreach ( $this->formats as $format ) {
			if ( ! in_array( $format->get_extension(), $output_formats ) ) {
				continue;
			}
			$values[ $format->get_extension() ] = $format->get_mime_type();
		}
		return $values;
	}
}
