<?php

namespace WebpConverter\Settings\Page;

use WebpConverter\PluginAccessAbstract;
use WebpConverter\PluginAccessInterface;
use WebpConverter\Settings\Page\PageInterface;

/**
 * Abstract class for class that supports tab in plugin settings page.
 */
abstract class PageAbstract extends PluginAccessAbstract implements PluginAccessInterface, PageInterface {

	/**
	 * Returns status if view is active.
	 *
	 * @return bool Is view active?
	 */
	public function is_page_active(): bool {
		return false;
	}
}
