<?php

include_once(QLWAPP_PRO_PLUGIN_DIR . 'includes/models/License.php');

include_once(QLWAPP_PLUGIN_DIR . 'includes/controllers/QLWAPP_Controller.php');

class QLWAPP_PRO_License_Controller extends QLWAPP_Controller {

  protected static $instance;

  function add_panel() {

    global $qlwapp_updater, $submenu;

    $license_model = new QLWAPP_PRO_License();

    $license = $license_model->get();

    include (QLWAPP_PLUGIN_DIR . '/includes/view/backend/pages/parts/header.php');
    include (QLWAPP_PRO_PLUGIN_DIR . '/includes/view/backend/pages/license.php');
  }

  function add_menu() {
    remove_submenu_page(QLWAPP_DOMAIN, QLWAPP_DOMAIN . '_premium');
    add_submenu_page(QLWAPP_DOMAIN, __('License', 'wp-whatsapp-chat-pro'), __('License', 'wp-whatsapp-chat-pro'), 'manage_options', QLWAPP_DOMAIN . '_license', array($this, 'add_panel'));
  }

  function add_activation() {

    global $qlwapp_updater;

    if (isset($_POST['submit']) && isset($_POST['qlwapp_license'])) {
      $qlwapp_updater->request_activation($_POST['qlwapp_license']['key'], $_POST['qlwapp_license']['email'], $_POST['qlwapp_license']['market']);
    }
  }

  function save_license() {
    $license_model = new QLWAPP_PRO_License();
    if (current_user_can('manage_options')) {
      if (isset($_POST['submit']) && isset($_POST['qlwapp_license'])) {
        $form_data = $_POST['qlwapp_license'];
        if (is_array($form_data)) {
          $license_model->save($form_data);
        }
      }
    }
  }

  function init() {
    add_action('admin_menu', array($this, 'add_menu'));
    add_action('admin_init', array($this, 'add_activation'));
    add_action('admin_init', array($this, 'save_license'));
  }

  public static function instance() {
    if (!isset(self::$instance)) {
      self::$instance = new self();
      self::$instance->init();
    }
    return self::$instance;
  }

}

QLWAPP_PRO_License_Controller::instance();
