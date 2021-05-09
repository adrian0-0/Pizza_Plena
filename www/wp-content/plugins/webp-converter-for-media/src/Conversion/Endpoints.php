<?php

namespace WebpConverter\Conversion;

use WebpConverter\PluginAccessAbstract;
use WebpConverter\PluginAccessInterface;
use WebpConverter\HookableInterface;
use WebpConverter\Conversion\Endpoint\EndpointInterface;
use WebpConverter\Conversion\Endpoint\EndpointIntegration;
use WebpConverter\Conversion\Endpoint\PathsEndpoint;
use WebpConverter\Conversion\Endpoint\RegenerateEndpoint;

/**
 * Initializes integration for all endpoints.
 */
class Endpoints extends PluginAccessAbstract implements PluginAccessInterface, HookableInterface {

	/**
	 * Integrates with WordPress hooks.
	 *
	 * @return void
	 */
	public function init_hooks() {
		$this->set_integration( new PathsEndpoint() );
		$this->set_integration( new RegenerateEndpoint() );
	}

	/**
	 * Sets integration for endpoint.
	 *
	 * @param EndpointInterface $endpoint .
	 *
	 * @return void
	 */
	private function set_integration( EndpointInterface $endpoint ) {
		$endpoint->set_plugin( $this->get_plugin() );
		( new EndpointIntegration( $endpoint ) )->init_hooks();
	}
}
