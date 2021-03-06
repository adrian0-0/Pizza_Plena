<?php

namespace WebpConverter\Plugin;

use WebpConverter\HookableInterface;
use WebpConverter\Settings\Pages;

/**
 * Adds links to plugin in list of plugins in panel.
 */
class Links implements HookableInterface {

	const DONATION_URL = 'https://ko-fi.com/gbiorczyk/?utm_source=webp-converter-for-media&utm_medium=plugin-links';

	/**
	 * Integrates with WordPress hooks.
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_filter( 'plugin_action_links_' . WEBPC_NAME, [ $this, 'add_link_to_settings_for_admin' ] );
		add_filter( 'network_admin_plugin_action_links_' . WEBPC_NAME, [ $this, 'add_link_to_settings_for_network' ] );
		add_filter( 'plugin_action_links_' . WEBPC_NAME, [ $this, 'add_link_to_donate' ] );
		add_filter( 'network_admin_plugin_action_links_' . WEBPC_NAME, [ $this, 'add_link_to_donate' ] );
	}

	/**
	 * Adds links to plugin for non-multisite websites.
	 *
	 * @param string[] $links Plugin action links.
	 *
	 * @return string[] Plugin action links.
	 * @internal
	 */
	public function add_link_to_settings_for_admin( array $links ): array {
		if ( is_multisite() ) {
			return $links;
		}
		return $this->add_link_to_settings( $links );
	}

	/**
	 * Adds links to plugin for multisite websites.
	 *
	 * @param string[] $links Plugin action links.
	 *
	 * @return string[] Plugin action links.
	 * @internal
	 */
	public function add_link_to_settings_for_network( array $links ): array {
		return $this->add_link_to_settings( $links );
	}

	/**
	 * Adds link to plugin settings page.
	 *
	 * @param string[] $links Plugin action links.
	 *
	 * @return string[] Plugin action links.
	 */
	private function add_link_to_settings( array $links ): array {
		array_unshift(
			$links,
			sprintf(
			/* translators: %1$s: open anchor tag, %2$s: close anchor tag */
				esc_html( __( '%1$sSettings%2$s', 'webp-converter-for-media' ) ),
				'<a href="' . Pages::get_settings_page_url() . '">',
				'</a>'
			)
		);
		return $links;
	}

	/**
	 * Adds link to donation.
	 *
	 * @param string[] $links Plugin action links.
	 *
	 * @return string[] Plugin action links.
	 * @internal
	 */
	public function add_link_to_donate( array $links ): array {
		$links[] = sprintf(
		/* translators: %1$s: open anchor tag, %2$s: close anchor tag */
			esc_html( __( '%1$sProvide us a coffee%2$s', 'webp-converter-for-media' ) ),
			'<a href="' . self::DONATION_URL . '" target="_blank">',
			'</a>'
		);
		return $links;
	}
}
