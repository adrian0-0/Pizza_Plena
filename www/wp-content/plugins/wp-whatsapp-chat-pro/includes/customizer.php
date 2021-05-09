<?php

if (!defined('ABSPATH'))
  exit;

if (!class_exists('QLWAPP_PRO_Customizer')) {

  class QLWAPP_PRO_Customizer {

    protected static $instance;

    function add_preview_init() {
      wp_enqueue_script('qlwapp-customize', plugins_url('/assets/js/qlwapp-customizer.min.js', QLWAPP_PRO_PLUGIN_FILE), array('jquery'), QLWAPP_PRO_PLUGIN_VERSION, 'all');
    }

    function add_customize_settings() {

      global $qlwapp;

      $qlwapp_customized = array();

      foreach ($customized = json_decode(wp_unslash($_REQUEST['customized']), true) as $key => $value) {
        if (strpos($key, QLWAPP_DOMAIN) !== false) {
          parse_str("$key=$value", $qlwapp_customized[]);
        }
      }

      $qlwapp_customized = call_user_func_array('array_merge_recursive', $qlwapp_customized);

      if (isset($qlwapp_customized[QLWAPP_DOMAIN])) {
        $qlwapp = array_replace_recursive($qlwapp, $qlwapp_customized[QLWAPP_DOMAIN]);
      }

      return $qlwapp;
    }

    function add_selective_refresh($partial) {

      if (isset($_REQUEST['wp_customize']) && $_REQUEST['wp_customize'] == "on" && isset($_REQUEST['customized']) && !empty($_REQUEST['customized'])) {
        $qlwapp = $this->add_customize_settings();
      }

      ob_start();

      include apply_filters('qlwapp_box_template', QLWAPP_PLUGIN_DIR . 'template/box.php');

      return ob_get_clean();
    }

    function save_customize($manager) {

      if (is_customize_preview()) {
        update_option(QLWAPP_DOMAIN, $this->add_customize_settings());
      }
    }

    function add_customize_register($wp_customize) {

      global $qlwapp;

      include_once 'controllers/CustomizerEditor.php';

      $section_id = QLWAPP_DOMAIN . '_settings';

      $wp_customize->add_section($section_id, array(
          'title' => QLWAPP_PLUGIN_NAME,
          'description' => '',
          'priority' => 200,
      ));

      $wp_customize->add_setting(QLWAPP_DOMAIN . '[scheme][brand]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['scheme']['brand'],
          'transport' => 'postMessage',
          'sanitize_callback' => 'sanitize_hex_color',
      ));
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, QLWAPP_DOMAIN . '[scheme][brand]', array(
          'label' => esc_html__('Brand', 'wp-whatsapp-chat-pro'),
          'section' => $section_id,
          'settings' => QLWAPP_DOMAIN . '[scheme][brand]',
              ))
      );
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[scheme][text]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['scheme']['text'],
          'transport' => 'postMessage',
          'sanitize_callback' => 'sanitize_hex_color',
          'sanitize_js_callback' => ''
      ));
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, QLWAPP_DOMAIN . '[scheme][text]', array(
          'label' => esc_html__('Text', 'wp-whatsapp-chat-pro'),
          'section' => $section_id,
          'settings' => QLWAPP_DOMAIN . '[scheme][text]',
      )));
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[scheme][link]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['scheme']['link'],
          'transport' => 'postMessage',
          'sanitize_callback' => 'sanitize_hex_color',
          'sanitize_js_callback' => ''
      ));
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, QLWAPP_DOMAIN . '[scheme][link]', array(
          'label' => esc_html__('Link', 'wp-whatsapp-chat-pro'),
          'section' => $section_id,
          'settings' => QLWAPP_DOMAIN . '[scheme][link]',
              ))
      );
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[scheme][name]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['scheme']['name'],
          'transport' => 'postMessage',
          'sanitize_callback' => 'sanitize_hex_color',
          'sanitize_js_callback' => ''
      ));
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, QLWAPP_DOMAIN . '[scheme][name]', array(
          'label' => esc_html__('Name', 'wp-whatsapp-chat-pro'),
          'section' => $section_id,
          'settings' => QLWAPP_DOMAIN . '[scheme][name]',
      )));
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[scheme][label]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['scheme']['label'],
          'transport' => 'postMessage',
          'sanitize_callback' => 'sanitize_hex_color',
          'sanitize_js_callback' => ''
      ));
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, QLWAPP_DOMAIN . '[scheme][label]', array(
          'label' => esc_html__('Label', 'wp-whatsapp-chat-pro'),
          'section' => $section_id,
          'settings' => QLWAPP_DOMAIN . '[scheme][label]',
      )));
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[scheme][message]', array(
          //'type' => $type,
          'capability' => 'manage_options',
          'default' => $qlwapp['scheme']['message'],
          'transport' => 'postMessage',
          'sanitize_callback' => 'sanitize_hex_color',
      ));
      $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, QLWAPP_DOMAIN . '[scheme][message]', array(
          'label' => esc_html__('Message', 'wp-whatsapp-chat-pro'),
          'section' => $section_id,
          'settings' => QLWAPP_DOMAIN . '[scheme][message]',
      )));
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[button][layout]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['button']['layout'],
          'transport' => 'postMessage',
      ));
      $wp_customize->add_control(QLWAPP_DOMAIN . '[button][layout]', array(
          'type' => 'select',
          'section' => $section_id,
          'label' => esc_html__('Button Layout', 'wp-whatsapp-chat-pro'),
          'description' => '',
          'input_attrs' => array(),
          'choices' => array(
              'button' => esc_html__('Button', 'wp-whatsapp-chat-pro'),
              'bubble' => esc_html__('Bubble', 'wp-whatsapp-chat-pro')
      )));
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[button][position]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['button']['position'],
          'transport' => 'postMessage',
      ));
      $wp_customize->add_control(QLWAPP_DOMAIN . '[button][position]', array(
          'type' => 'select',
          'section' => $section_id,
          'label' => esc_html__('Button Position', 'wp-whatsapp-chat-pro'),
          'choices' => array(
              'middle-left' => esc_html__('Middle Left', 'wp-whatsapp-chat-pro'),
              'middle-right' => esc_html__('Middle Right', 'wp-whatsapp-chat-pro'),
              'bottom-left' => esc_html__('Bottom Left', 'wp-whatsapp-chat-pro'),
              'bottom-right' => esc_html__('Bottom Right', 'wp-whatsapp-chat-pro'),
      )));
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[button][text]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['button']['text'],
          'transport' => 'postMessage',
      ));
      $wp_customize->add_control(QLWAPP_DOMAIN . '[button][text]', array(
          'type' => 'text',
          'section' => $section_id,
          'label' => esc_html__('Button Text', 'wp-whatsapp-chat-pro'),
          'description' => '',
      ));
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[button][icon]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['button']['icon'],
          'transport' => 'postMessage',
      ));
      $wp_customize->add_control(QLWAPP_DOMAIN . '[button][icon]', array(
          'type' => 'text',
          'section' => $section_id,
          'label' => esc_html__('Button Icon', 'wp-whatsapp-chat-pro'),
          'description' => '',
      ));
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[box][header]', array(
          ////'type' => $type,
          'capability' => 'manage_options',
          'default' => $qlwapp['box']['header'],
          'transport' => 'postMessage',
      ));
      $wp_customize->add_control(new QLWAPP_WP_Editor_Control($wp_customize, QLWAPP_DOMAIN . '[box][header]', array(
          'label' => esc_html__('Box Header', 'wp-whatsapp-chat-pro'),
          'section' => $section_id,
          'settings' => QLWAPP_DOMAIN . '[box][header]',
      )));
      $wp_customize->add_setting(QLWAPP_DOMAIN . '[box][footer]', array(
          'capability' => 'manage_options',
          'default' => $qlwapp['box']['footer'],
          'transport' => 'postMessage',
      ));
      $wp_customize->add_control(new QLWAPP_WP_Editor_Control($wp_customize, QLWAPP_DOMAIN . '[box][footer]', array(
          'label' => esc_html__('Box Footer', 'wp-whatsapp-chat-pro'),
          'section' => $section_id,
          'settings' => QLWAPP_DOMAIN . '[box][footer]',
      )));
      $wp_customize->selective_refresh->add_partial(QLWAPP_DOMAIN . '[button][layout]', array(
          'selector' => '#qlwapp',
          'settings' => array(
              QLWAPP_DOMAIN . '[button][layout]',
              QLWAPP_DOMAIN . '[button][position]',
              QLWAPP_DOMAIN . '[button][icon]',
              QLWAPP_DOMAIN . '[button][text]',
              QLWAPP_DOMAIN . '[box][header]',
              QLWAPP_DOMAIN . '[box][footer]',
          ),
          'container_inclusive' => true,
          'fallback_refresh' => false,
          'render_callback' => array($this, 'add_selective_refresh')));
    }

    function init() {
      add_action('customize_register', array($this, 'add_customize_register'));
      add_action('customize_preview_init', array($this, 'add_preview_init'), 10, 2);
      add_action('customize_save_after', array($this, 'save_customize'));
    }

    public static function instance() {
      if (!isset(self::$instance)) {
        self::$instance = new self();
        self::$instance->init();
      }
      return self::$instance;
    }

  }

  QLWAPP_PRO_Customizer::instance();
}

