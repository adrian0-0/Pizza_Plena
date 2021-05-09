<?php

class QLWAPP_PRO
{

  protected static $instance;

  function includes()
  {
    include_once('updater.php');
    include_once('controllers/ButtonController.php');
    include_once('controllers/LicenseController.php');
    include_once('frontend.php');
    include_once('customizer.php');
  }

  function init()
  {
    include_once('notices.php');
    load_plugin_textdomain('wp-whatsapp-chat-pro', false, QLWAPP_PRO_PLUGIN_DIR . '/languages/');
    add_action('qlwapp_init', array($this, 'includes'));
  }

  public static function instance()
  {
    if (!isset(self::$instance)) {
      self::$instance = new self();
      self::$instance->init();
    }
    return self::$instance;
  }
}

QLWAPP_PRO::instance();
