<?php
/**
 * @wordpress-plugin
 * Plugin Name:       Plugins Premium Hostnet
 * Plugin URI:        http://www.hostnet.com.br
 * Description:       Plugin para instalar plugins Premiums oferecidos pela Hostnet
 * Version:           1.0.1
 * Author:            Hostnet Internet
 * Author URI:        http://www.hostnet.com.br
 * License:           Todos os direitos reservados a Hostnet desde 2028
 * Text Domain:       hostnet-pluginspremium
 */

// If this file is called directly, abort.
if ( !defined('WPINC') ) {
  die;
}

if ( class_exists('WP_CLI') ) {
  require_once plugin_dir_path(__FILE__) . '/cli/class.cli.php';
}