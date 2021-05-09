<?php

/**
 * Plugin Name: WhatsApp Chat PRO
 * Description: Send messages directly to your WhatsApp phone number.
 * Plugin URI: https://quadlayers.com/portfolio/whatsapp-chat/
 * Version: 2.5.5
 * Author: QuadLayers
 * Author URI: https://quadlayers.com
 * Copyright: 2018 QuadLayers (https://quadlayers.com)
 * Text Domain: wp-whatsapp-chat-pro
 */
if (!defined('ABSPATH'))
  exit;

define('QLWAPP_PRO_PLUGIN_NAME', 'WhatsApp Chat PRO');
define('QLWAPP_PRO_PLUGIN_VERSION', '2.5.5');
define('QLWAPP_PRO_PLUGIN_FILE', __FILE__);
define('QLWAPP_PRO_PLUGIN_DIR', __DIR__ . DIRECTORY_SEPARATOR);
define('QLWAPP_PRO_DEMO_URL', 'https://quadlayers.com/portfolio/whatsapp-chat/?utm_source=qlwapp_admin');
define('QLWAPP_PRO_LICENSES_URL', 'https://quadlayers.com/account/licenses/?utm_source=qlwapp_admin');
define('QLWAPP_PRO_SUPPORT_URL', 'https://quadlayers.com/account/support/?utm_source=qlwapp_admin');

if (!class_exists('QLWAPP_PRO')) {
  include_once( QLWAPP_PRO_PLUGIN_DIR . 'includes/qlwapp.php' );
}
