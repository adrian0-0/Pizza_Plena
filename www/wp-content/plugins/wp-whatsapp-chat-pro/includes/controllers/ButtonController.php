<?php
include_once(QLWAPP_PLUGIN_DIR . 'includes/controllers/QLWAPP_Controller.php');

class QLWAPP_PRO_Button_Controller extends QLWAPP_Controller {

  protected static $instance;

  function add_js() {
    if (isset($_GET['page']) && ($_GET['page'] === 'qlwapp_button')) {
      wp_enqueue_style('qlwapp-icons', plugins_url('/assets/qlwapp-icons.min.css', QLWAPP_PRO_PLUGIN_FILE), array('media-views'), QLWAPP_PRO_PLUGIN_VERSION, 'all');
      wp_enqueue_script('qlwapp-admin-icons', plugins_url('/assets/js/qlwapp-admin-icons.min.js', QLWAPP_PRO_PLUGIN_FILE), array('wp-util', 'jquery', 'backbone'), QLWAPP_PRO_PLUGIN_VERSION, true);
    }
  }

  function add_modal() {
    if (isset($_GET['page']) && ($_GET['page'] === 'qlwapp_button')) {
      ?>
      <script type="text/html" id='tmpl-qlwapp-modal-window'>
        <?php include (QLWAPP_PRO_PLUGIN_DIR . '/includes/view/backend/pages/modals/modal-icons.php'); ?>
      </script>
      <?php
    }
  }

  function init() {
    add_action('admin_enqueue_scripts', array($this, 'add_js'));
    add_action('admin_footer', array($this, 'add_modal'));
  }

  public static function instance() {
    if (!isset(self::$instance)) {
      self::$instance = new self();
      self::$instance->init();
    }
    return self::$instance;
  }

}

QLWAPP_PRO_Button_Controller::instance();
