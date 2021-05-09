<?php

class QLWAPP_PRO_Updater {

  protected static $instance;

  function add_updater() {

    global $qlwapp_updater;

    include_once('3rd/QLWDDUpdater.php');
    include_once('models/License.php');

    $license_model = new QLWAPP_PRO_License();

    $license = $license_model->get();

    $qlwapp_updater = qlwdd_updater(array(
        'api_url' => 'https://quadlayers.com/wc-api/qlwdd/',
        'plugin_url' => QLWAPP_PRO_DEMO_URL,
        'plugin_file' => QLWAPP_PRO_PLUGIN_FILE,
        'license_market' => $license['market'],
        'license_key' => $license['key'],
        'license_email' => $license['email'],
        'license_url' => admin_url('admin.php?page=qlwapp_license'),
        'product_key' => '4c3b7745ace5a4648fe6b434964955b6',
        'envato_key' => 'Gn46hMOIcvz8uyVvpe0jB2ge7A1RdH5T',
        'envato_id' => '23125935',
        'emp_id' => '843823'
    ));
  }

  function init() {
    add_action('admin_init', array($this, 'add_updater'));
  }

  public static function instance() {
    if (!isset(self::$instance)) {
      self::$instance = new self();
      self::$instance->init();
    }
    return self::$instance;
  }

}

QLWAPP_PRO_Updater::instance();
