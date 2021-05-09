<?php

include_once(QLWAPP_PLUGIN_DIR . 'includes/models/License.php');

class QLWAPP_PRO_License extends QLWAPP_License {

  function save($license_data = NULL) {
    return parent::save_data($this->table, $license_data);
  }

}
