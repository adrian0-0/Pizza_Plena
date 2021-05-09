<div class="wrap about-wrap full-width-layout qlwrap">
  <form id="qlwapp_license_form" method="post" action="<?php echo admin_url('admin.php?page=' . QLWAPP_DOMAIN . '_license'); ?>">
    <table class="widefat striped">
      <thead>
        <tr>
          <th colspan="2"><b><?php esc_html_e('License', 'wp-whatsapp-chat-pro'); ?></b></th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th scope="row"><?php esc_html_e('Market', 'wp-whatsapp-chat-pro'); ?></th>
          <td>
            <select name="qlwapp_license[market]" style="width:350px">
              <option <?php selected($license['market'], ''); ?> value="">QuadLayers</option>
              <option <?php selected($license['market'], 'envato'); ?> value="envato">Envato</option>
              <option <?php selected($license['market'], 'emp'); ?> value="emp">Elegant Market Place</option>
            </select>
            <p class="description"><?php esc_html_e('Enter the market where you\'ve purchased the license.', 'wp-whatsapp-chat-pro'); ?></p>
          </td>
        </tr>
        <tr>
          <th scope="row"><?php esc_html_e('Key', 'wp-whatsapp-chat-pro'); ?></th>
          <td>
            <input type="password" name="qlwapp_license[key]" placeholder="<?php esc_html_e('Enter your license key.', 'wp-whatsapp-chat-pro'); ?>" value="<?php echo esc_attr($license['key']); ?>" class="qlwapp-input" />
          </td>
        </tr>
        <tr>
          <th scope="row"><?php esc_html_e('Email', 'wp-whatsapp-chat-pro'); ?></th>
          <td>
            <input type="password" name="qlwapp_license[email]" placeholder="<?php esc_html_e('Enter your order email.', 'wp-whatsapp-chat-pro'); ?>" value="<?php echo esc_attr($license['email']); ?>" class="qlwapp-input" />
          </td>
        </tr>
      </tbody>
    </table>
    <?php submit_button() ?>
  </form>
  <table class="widefat striped" cellspacing="0">
    <thead>
      <tr>
        <th colspan="2"><b><?php esc_html_e('Status', 'wp-whatsapp-chat-pro'); ?></b></th>
      </tr>
    </thead>
    <tbody>
      <?php if ($activation = $qlwapp_updater->get_activation()) : ?>
        <?php if (!empty($activation->success)) : ?>
          <tr>
            <td><?php _e('Created', 'wp-whatsapp-chat-pro') ?></td>
            <td><?php echo date(get_option('date_format'), strtotime($activation->license_created)) ?></td>
          </tr>
          <tr>
            <td><?php _e('Limit', 'wp-whatsapp-chat-pro') ?></td>
            <td><?php echo $activation->license_limit ? esc_attr($activation->license_limit) : esc_html__('Unlimited', 'wp-whatsapp-chat-pro'); ?></td>
          </tr>
          <tr>
            <td><?php _e('Activations', 'wp-whatsapp-chat-pro') ?></td>
            <td><?php echo esc_attr($activation->activation_count); ?></td>
          </tr>
          <tr>
            <td><?php _e('Updates', 'wp-whatsapp-chat-pro') ?></td>
            <td><?php echo ($activation->license_expiration != '0000-00-00 00:00:00' && $activation->license_updates) ? sprintf(esc_html__('Expires on %s', 'wp-whatsapp-chat-pro'), $activation->license_expiration) : esc_html__('Unlimited', 'wp-whatsapp-chat-pro'); ?></td>
          </tr>
          <tr>
            <td><?php _e('Support', 'wp-whatsapp-chat-pro') ?></td>
            <td><?php echo ($activation->license_expiration != '0000-00-00 00:00:00' && $activation->license_support) ? sprintf(esc_html__('Expires on %s', 'wp-whatsapp-chat-pro'), $activation->license_expiration) : esc_html__('Unlimited', 'wp-whatsapp-chat-pro'); ?></td>
          </tr>
          <tr>
            <td><?php _e('Expiration', 'wp-whatsapp-chat-pro') ?></td>
            <td><?php echo ($activation->license_expiration != '0000-00-00 00:00:00') ? date_i18n(get_option('date_format'), strtotime($activation->license_expiration)) : __('Unlimited', 'wp-whatsapp-chat-pro'); ?></td>
          </tr>
        <?php endif; ?>
        <tr>
          <td><?php esc_html_e('Status', 'wp-whatsapp-chat-pro'); ?></td>
          <td><?php echo esc_html($activation->message); ?></td>
        </tr>
      <?php endif; ?>
      <tr>
        <td><?php esc_html_e('Message', 'wp-whatsapp-chat-pro'); ?></td>
        <td>
          <span class="description">
            <?php if (empty($activation->activation_instance)) : ?>
              <?php printf(__('Before you can receive plugin updates, you must first authenticate your license. To locate your License Key, <a href="%s" target="_blank">log in</a> to your account and navigate to the <strong>Account > Licenses</strong> page.', 'wp-whatsapp-chat-pro'), QLWAPP_PRO_LICENSES_URL); ?>
            <?php else : ?>
              <?php printf(__('Thanks for register your license! If you have doubts you can request <a href="%s" target="_blank">support</a> through our ticket system.', 'wp-whatsapp-chat-pro'), QLWAPP_PRO_SUPPORT_URL); ?>
            <?php endif; ?>
          </span>
        </td>
      </tr>
    </tbody>
  </table>
</div>