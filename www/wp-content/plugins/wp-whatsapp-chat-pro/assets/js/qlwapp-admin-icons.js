(function ($) {

  var Icons = Backbone.Model.extend({
    defaults: {
      icon: 'qlwapp-whatsapp-icon'
    }
  });

  var IconsView = Backbone.View.extend({
    events: {
      'click .icons .attachment': 'select',
      'click .media-modal-backdrop': 'close',
      'click .media-modal-close': 'close',
      'submit .media-modal-form': 'submit'
    },
    templates: {},
    initialize: function () {
      _.bindAll(this, 'open', 'render', 'close', 'submit');
      this.init();
      this.open();

    },
    init: function () {
      this.templates.window = wp.template('qlwapp-modal-window');
    },
    current: function (e) {
      'use strict';
      var modal = this;
      if (modal.model.attributes.icon != '') {
        modal.$el.find('.' + modal.model.attributes.icon).closest('li').focus();
      }
    },
    select: function (e) {
      'use strict';
      
      this.model.set({
        icon: $(e.target).find('i').attr('class')
      });

      this.render();
      this.enable();
    },
    render: function () {

      var modal = this;

      modal.$el.html(modal.templates.window(modal.model.attributes));

      this.current();

    },
    open: function (e) {
      this.render();
      $('body').addClass('modal-open').append(this.$el);
    },
    close: function (e) {
      e.preventDefault();
      this.undelegateEvents();
      $(document).off('focusin');
      $('body').removeClass('modal-open');
      this.remove();
      return;
    },
    enable: function (e) {
      $('.media-modal-submit').prop('disabled', false);
    },
    submit: function (e) {
      e.preventDefault();
      var modal = this;

      var $input = $('input[name="icon"]');

      if ($input.length && modal.model.attributes.icon) {
        $input.val(modal.model.attributes.icon);
      }

      modal.close(e);
    }
  });

  var IconsModal = Backbone.View.extend({
    initialize: function (e) {
      var $button = $(e.target),
              icon = $button.closest('tr').find('input[name=icon]').val();

      var model = new Icons();

      model.set({
        icon: icon
      });

      new IconsView({
        model: model
      });
    },
  });

  $('#qlwapp_icon_add').on('click', function (e) {
    e.preventDefault();
    new IconsModal(e);
  });

})(jQuery);