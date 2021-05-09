<?php

namespace WebpConverter\Settings;

use WebpConverter\PluginAccessAbstract;
use WebpConverter\PluginAccessInterface;
use WebpConverter\HookableInterface;
use WebpConverter\Notice\WelcomeNotice;
use WebpConverter\Settings\AdminAssets;
use WebpConverter\Settings\Page\DebugPage;
use WebpConverter\Settings\Page\PageInterface;
use WebpConverter\Settings\Page\SettingsPage;

/**
 * Adds plugin settings page in admin panel.
 */
class Pages extends PluginAccessAbstract implements PluginAccessInterface, HookableInterface {

	const ADMIN_MENU_PAGE = 'webpc_admin_page';

	/**
	 * Integrates with WordPress hooks.
	 *
	 * @return void
	 */
	public function init_hooks() {
		add_action( 'admin_menu', [ $this, 'add_settings_page_for_admin' ] );
		add_action( 'network_admin_menu', [ $this, 'add_settings_page_for_network' ] );
	}

	/**
	 * Returns URL of plugin settings page.
	 *
	 * @return string
	 */
	public static function get_settings_page_url(): string {
		if ( ! is_multisite() ) {
			return menu_page_url( self::ADMIN_MENU_PAGE, false );
		} else {
			return network_admin_url( 'settings.php?page=' . self::ADMIN_MENU_PAGE );
		}
	}

	/**
	 * Adds settings page to menu for non-multisite websites.
	 *
	 * @return void
	 * @internal
	 */
	public function add_settings_page_for_admin() {
		if ( is_multisite() ) {
			return;
		}
		$this->add_settings_page( 'options-general.php' );
	}

	/**
	 * Adds settings page to menu for multisite websites.
	 *
	 * @return void
	 * @internal
	 */
	public function add_settings_page_for_network() {
		$this->add_settings_page( 'settings.php' );
	}

	/**
	 * Creates plugin settings page in WordPress Admin Dashboard.
	 *
	 * @param string $menu_page Parent menu page.
	 *
	 * @return void
	 */
	private function add_settings_page( string $menu_page ) {
		$page = add_submenu_page(
			$menu_page,
			'WebP Converter for Media',
			'WebP Converter',
			'manage_options',
			self::ADMIN_MENU_PAGE,
			[ $this, 'load_settings_page' ]
		);
		add_action( 'load-' . $page, [ $this, 'load_scripts_for_page' ] );
	}

	/**
	 * Loads selected view on plugin settings page.
	 *
	 * @return void
	 * @internal
	 */
	public function load_settings_page() {
		$this->init_page_is_active( new DebugPage() );
		$this->init_page_is_active( new SettingsPage() );
	}

	/**
	 * Initializes page loading if is active.
	 *
	 * @param PageInterface $page .
	 *
	 * @return void
	 */
	private function init_page_is_active( PageInterface $page ) {
		$page->set_plugin( $this->get_plugin() );
		if ( $page->is_page_active() ) {
			$page->show_page_view();
		}
	}

	/**
	 * Loads assets on plugin settings page.
	 *
	 * @return void
	 * @internal
	 */
	public function load_scripts_for_page() {
		WelcomeNotice::disable_notice();
		( new AdminAssets() )->init_hooks();
	}
}
