<div class="media-modal-backdrop">&nbsp;</div>
<div tabindex="0" id="<?php echo esc_attr(QLWAPP_DOMAIN . '_modal'); ?>" class="media-modal wp-core-ui upload-php qlwapp-modal-icon" role="dialog" aria-modal="true" aria-labelledby="media-frame-title">
  <div class="media-modal-content" role="document">
    <form class="media-modal-form" method="POST">
      <div class="edit-attachment-frame mode-select hide-menu hide-router">
        <div class="edit-media-header ">
          <button type="button" class="media-modal-close"><span class="media-modal-icon"><span class="screen-reader-text"><?php esc_html_e('Close dialog'); ?></span></span></button>
        </div>
        <div class="media-frame-title">
          <h1><?php esc_html_e('Add icon', 'wp-whatsapp-chat-pro'); ?> #{{data.icon}}</h1>
        </div>
        <div class="media-frame-content" data-columns="8" style="bottom:61px;">
          <div class="attachments-browser">
            <ul tabindex="-1" class="icons">
              <?php foreach (explode(',', 'qlwf-chat,qlwf-chat1,qlwf-chat2,qlwf-comments,qlwf-chat3,qlwf-bubble1,qlwf-chat-alt-fill,qlwf-chat-alt-stroke,qlwf-comment-alt2-fill,qlwf-comment-alt2-stroke,qlwf-comment-fill,qlwf-comment-stroke,qlwf-comment,qlwf-comment-alt1-stroke,qlwf-chat4,qlwf-comments1,qlwf-chat5,qlwf-comment1,qlwf-bubble,qlwf-bubbles,qlwf-bubbles2,qlwf-bubble2,qlwf-bubbles3,qlwf-bubbles4,qlwf-whatsapp,qlwf-chat6,qlwf-mode_comment,qlwf-insert_comment,qlwf-chat_bubble_outline,qlwf-chat_bubble,qlwf-bubble_chart,qlwf-comment2,qlwf-chat7,qlwf-commenting-o,qlwf-commenting,qlwf-comments-o,qlwf-comment-o,qlwf-wechat,qlwf-comments2,qlwf-comment3,qlwf-chat8,qlwf-chat-bubble-dots,qlwf-bubbles1,qlwf-bubble3') as $id => $icon) : ?>
                <li tabindex="0" role="checkbox" aria-label="<?php echo esc_attr($icon); ?>" aria-checked="false" class="attachment save-ready icon _<?php echo esc_attr(str_replace(' ', '_', trim($icon))); ?>">
                  <div class="attachment-preview js--select-attachment type-image subtype-jpeg landscape">
                    <div class="thumbnail">
                      <i class="<?php echo esc_attr($icon); ?>"></i>
                    </div>
                  </div>
                  <button type="button" class="check" tabindex="-1">
                    <span class="media-modal-icon"></span>
                    <span class="screen-reader-text"><?php esc_html_e('Deselect'); ?></span>
                  </button>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </div>
        <div class="media-frame-toolbar" style="left:0;">
          <div class="media-toolbar">
            <div class="media-toolbar-secondary"></div>
            <div class="media-toolbar-primary search-form">
              <button type="submit" class="media-modal-submit button button-primary media-button button-large" disabled="disabled"><?php esc_html_e('Save'); ?></button>
              <button type="button" class="media-modal-close button button-secondary media-button button-large" style="
                      height: auto;
                      float: none;
                      position: inherit;
                      padding: inherit;
                      "><?php esc_html_e('Close'); ?></button>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>