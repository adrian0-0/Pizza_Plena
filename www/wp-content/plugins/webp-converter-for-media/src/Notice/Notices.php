<?php

namespace WebpConverter\Notice;

use WebpConverter\Notice\NoticeIntegration;
use WebpConverter\Notice\ThanksNotice;
use WebpConverter\HookableInterface;

/**
 * Adds integration for list of notices.
 */
class Notices implements HookableInterface {

	/**
	 * Integrates with WordPress hooks.
	 *
	 * @return void
	 */
	public function init_hooks() {
		( new NoticeIntegration( new ThanksNotice() ) )->init_hooks();
		( new NoticeIntegration( new WelcomeNotice() ) )->init_hooks();
	}
}
