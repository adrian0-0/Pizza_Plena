<?php

namespace WebpConverter\Loader;

use WebpConverter\PluginAccessAbstract;
use WebpConverter\PluginAccessInterface;
use WebpConverter\HookableInterface;
use WebpConverter\Loader\LoaderInterface;
use WebpConverter\Loader\LoaderIntegration;
use WebpConverter\Loader\HtaccessLoader;
use WebpConverter\Loader\PassthruLoader;

/**
 * Adds integration with methods of loading images.
 */
class Loaders extends PluginAccessAbstract implements PluginAccessInterface, HookableInterface {

	/**
	 * Integrates with WordPress hooks.
	 *
	 * @return void
	 */
	public function init_hooks() {
		$this->set_integration( new HtaccessLoader() );
		$this->set_integration( new PassthruLoader() );
	}

	/**
	 * Sets integration for loader.
	 *
	 * @param LoaderInterface $loader .
	 *
	 * @return void
	 */
	private function set_integration( LoaderInterface $loader ) {
		$loader->set_plugin( $this->get_plugin() );
		( new LoaderIntegration( $loader ) )->set_plugin_hookable( $this->get_plugin() );
	}
}
