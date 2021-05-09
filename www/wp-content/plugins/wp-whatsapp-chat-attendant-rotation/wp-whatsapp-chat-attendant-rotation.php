<?php
/**
 * Plugin Name: Hostnet WhatsApp Rodízio
 * Description: Faz o rodízio dos atendentes no WhatsApp Chat Pro. Uso exclusivo para clientes do Plano Cloud da Hostnet.
 * Plugin URI: https://www.hostnet.com.br
 * Version: 1.0.1
 * Author: Hostnet
 * Author URI: https://www.hostnet.com.br
 * Copyright: 2021 Hostnet (https://www.hostnet.com.br)
 * Text Domain: hn-whatsapp-chat-pro-attendant-rotation
 */
if (!defined('ABSPATH'))
  exit;

define('HN_WAAR_PLUGIN_NAME', 'Hostnet WhatsApp Rodízio');
define('HN_WAAR_PLUGIN_VERSION', '1.0.1');
define('HN_WAAR_PLUGIN_JS_VERSION', '1.0.4');
define('HN_WAAR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define('HN_WAAR_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define('HN_WAAR_PLUGIN_SLUG', 'wp-whatsapp-chat-attendant-rotation');
define('HN_WAAR_PLUGIN_INFO_JSON', 'https://plugins.hostnet.com.br/plugins/wp-whatsapp-chat-attendant-rotation/info.json');
define('HN_WAAR_PLUGIN_CACHE_UPDATE', 172800);

if (!class_exists('HN_WAAR_Update')) {
  include_once( HN_WAAR_PLUGIN_DIR . 'includes/class-hn-waar-update.php' );
}

/*
 * Verifica se os plugins necessários estão ativos
 */
$plugin_free = 'wp-whatsapp-chat/wp-whatsapp-chat.php';
$plugin_pro  = 'wp-whatsapp-chat-pro/wp-whatsapp-chat-pro.php';

if (!is_plugin_active($plugin_free)) {
?>
<div class="error">
<p>Para o plugin <strong>Hostnet WhatsApp Rodízio</strong> funcionar você precisa ativar o plugin <strong>WP Social Chat</strong>.</p>
</div>
<?
  return;
}

if (!is_plugin_active($plugin_pro)) {
?>
<div class="error">
<p>Para o plugin <strong>Hostnet WhatsApp Rodízio</strong> funcionar você precisa ativar o plugin <strong>WhatsApp Chat PRO</strong>.</p>
</div>
<?
  return;
}
/* --- */

if (!class_exists('HN_WAAR')) {
  include_once( HN_WAAR_PLUGIN_DIR . 'includes/class-hn-waar.php' );
}
if (!class_exists('HN_WAAR_Settings')) {
  include_once( HN_WAAR_PLUGIN_DIR . 'includes/class-hn-waar-settings.php' );
}
if (!class_exists('HN_WAAR_Profile')) {
  include_once( HN_WAAR_PLUGIN_DIR . 'includes/class-hn-waar-profile.php' );
}