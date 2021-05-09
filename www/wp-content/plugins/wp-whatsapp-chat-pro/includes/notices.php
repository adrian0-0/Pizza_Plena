<?php

class QLWAPP_PRO_Notices {

  protected static $_instance;
  
  var $free_name = 'WhatsApp Chat';
  var $free_slug = 'wp-whatsapp-chat';

  public function __construct() {
    $this->init();
  }

  public static function instance() {
    if (is_null(self::$_instance)) {
      self::$_instance = new self();
    }
    return self::$_instance;
  }

  public function init() {
    add_action('admin_notices', array($this, 'add_admin_notices'));
    add_filter('plugin_action_links_' . plugin_basename(QLWAPP_PRO_PLUGIN_FILE), array($this, 'add_action_links'));
  }

  function add_action_links($links) {

    $links[] = '<a target="_blank" href="' . QLWAPP_PRO_SUPPORT_URL . '">' . esc_html__('Support', 'wp-whatsapp-chat-pro') . '</a>';
    $links[] = '<a target="_blank" href="' . QLWAPP_PRO_LICENSES_URL . '">' . esc_html__('License', 'wp-whatsapp-chat-pro') . '</a>';

    return $links;
  }

  function add_admin_notices() {

    $screen = get_current_screen();

    if (isset($screen->parent_file) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id) {
      return;
    }

    $plugin = "{$this->free_slug}/{$this->free_slug}.php";

    if (is_plugin_active($plugin)) {
      return;
    }

    if ($this->is_installed($plugin)) {

      if (!current_user_can('activate_plugins')) {
        return;
      }
      ?>
      <div class="error">
        <p>
          <a href="<?php echo wp_nonce_url('plugins.php?action=activate&amp;plugin=' . $plugin . '&amp;plugin_status=all&amp;paged=1', 'activate-plugin_' . $plugin); ?>" class='button button-secondary'><?php printf(esc_html__('Activate %s', 'wp-whatsapp-chat-pro'), $this->free_name); ?></a>
          <?php printf(esc_html__('%s not working because you need to activate the %s plugin.', 'wp-whatsapp-chat-pro'), QLWAPP_PRO_PLUGIN_NAME, $this->free_name); ?>   
        </p>
      </div>
      <?php
    } else {
      if (!current_user_can('install_plugins')) {
        return;
      }
      ?>
      <div class="error">
        <p>
          <a href="<?php echo wp_nonce_url(self_admin_url("update.php?action=install-plugin&plugin={$this->free_slug}"), "install-plugin_{$this->free_slug}"); ?>" class='button button-secondary'><?php printf(esc_html__('Install %s', 'wp-whatsapp-chat-pro'), $this->free_name); ?></a>
          <?php printf(esc_html__('%s not working because you need to install the %s plugin.', 'wp-whatsapp-chat-pro'), QLWAPP_PRO_PLUGIN_NAME, $this->free_name); ?>
        </p>
      </div>
      <?php
    }
  }

  function is_installed($path) {

    $installed_plugins = get_plugins();

    return isset($installed_plugins[$path]);
  }

}

QLWAPP_PRO_Notices::instance();