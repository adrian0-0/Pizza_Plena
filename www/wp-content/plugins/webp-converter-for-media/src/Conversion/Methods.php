<?php

namespace WebpConverter\Conversion;

use WebpConverter\Conversion\Method\MethodInterface;
use WebpConverter\Conversion\Method\GdMethod;
use WebpConverter\Conversion\Method\ImagickMethod;

/**
 * Adds support for all conversion methods and returns information about them.
 */
class Methods {

	/**
	 * Objects of supported conversion methods.
	 *
	 * @var MethodInterface[]
	 */
	private $methods = [];

	/**
	 * Methods constructor.
	 */
	public function __construct() {
		$this->methods[ GdMethod::METHOD_NAME ]      = new GdMethod();
		$this->methods[ ImagickMethod::METHOD_NAME ] = new ImagickMethod();
	}

	/**
	 * Returns objects of conversion methods.
	 *
	 * @return MethodInterface[] .
	 */
	public function get_methods_objects(): array {
		$values = [];
		foreach ( $this->methods as $method ) {
			$values[ $method->get_name() ] = $method;
		}
		return $values;
	}

	/**
	 * Returns list of conversion methods.
	 *
	 * @return string[] Names of conversion methods with labels.
	 */
	public function get_methods(): array {
		$values = [];
		foreach ( $this->get_methods_objects() as $method_name => $method ) {
			$values[ $method_name ] = $method->get_label();
		}
		return $values;
	}

	/**
	 * Returns list of installed conversion methods.
	 *
	 * @return string[] Names of conversion methods with labels.
	 */
	public function get_available_methods(): array {
		$values = [];
		foreach ( $this->get_methods_objects() as $method_name => $method ) {
			if ( ! $method::is_method_installed() ) {
				continue;
			}
			$values[ $method_name ] = $method->get_label();
		}
		return $values;
	}

	/**
	 * Returns status if conversion method is active.
	 *
	 * @param string $method_name   Name of conversion method.
	 * @param string $output_format Extension of output format.
	 *
	 * @return bool Is method active?
	 */
	public function is_method_available( string $method_name, string $output_format ): bool {
		return ( isset( $this->methods[ $method_name ] )
			&& $this->methods[ $method_name ]->is_method_active( $output_format ) );
	}
}
