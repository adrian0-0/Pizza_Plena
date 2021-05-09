<?php
/**
 * Server configuration error displayed in errors section.
 *
 * @package WebP Converter for Media
 */

?>
<p>
	<?php
	echo wp_kses_post(
		sprintf(
		/* translators: %1$s: br tags, %2$s: open anchor tag, %3$s: close anchor tag */
			__( 'Your server uses the cache for HTTP requests. The rules from .htaccess file or from Nginx configuration are not executed every time when the image is loaded, but the last redirect from cache is performed. With each request to image, your server should execute the rules from .htaccess file or from Nginx configuration. Now it only does this the first time and then uses cache. This means that if your server redirected image to WebP format the first time, it does so on every request. It should check the rules from .htaccess file or from Nginx configuration each time during request to image and redirect only when the conditions are met. %1$sIf you have enabled caching HTTP reverse proxy or another HTTP caching, you must disable it. Otherwise the plugin cannot work properly. Please read %2$sthe plugin FAQ%3$s to learn more (there you will find e.g. solution for Cloudflare servers).', 'webp-converter-for-media' ),
			'<br><br>',
			'<a href="https://wordpress.org/plugins/webp-converter-for-media/#faq" target="_blank">',
			'</a>'
		)
	);
	?>
	<br><br>
	<?php
	echo esc_html(
		__( 'In this case, please contact your server administrator.', 'webp-converter-for-media' )
	);
	?>
</p>
<?php require __DIR__ . '/passthru-info.php'; ?>
