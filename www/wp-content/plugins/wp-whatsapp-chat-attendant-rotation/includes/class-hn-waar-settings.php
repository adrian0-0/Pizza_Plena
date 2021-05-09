<?php
class HN_WAAR_Settings {
	public function __construct() {
		add_action( 'admin_menu', array($this, 'register_menu') );
		add_action( 'admin_menu',  array($this, 'register_submenu'), 99 );
		add_action( 'admin_init',  array($this, 'register_settings') );
	}
	
	// Registra o menu
	function register_menu() {
		$user_id = get_current_user_id();
		if ( current_user_can( 'manage_options', $user_id ) ) {
			add_menu_page(
				__( 'WhatsApp Rodízio', 'hn-whatsapp-chat-pro-attendant-rotation' ),
				__( 'WhatsApp Rodízio', 'hn-whatsapp-chat-pro-attendant-rotation' ),
				'read',
				'hnwaar',
				array($this, 'page_waar'),
				'dashicons-format-status',
				71
			);

			// Adiciona um submenu em branco para tirar duplicidade
			add_submenu_page(
				'hnwaar',
				'',
				'',
				'read', 
				'hnwaar',
				array($this, 'page_waar'), 
				71
			);
			
			// Remove submenu em branco adicionado
			remove_submenu_page( 'hnwaar', 'hnwaar' );
		}
	}
	
	function page_waar() {
	}
	
	// Registra o submenu de configurações
	function register_submenu() {
		$user_id = get_current_user_id();
		if ( current_user_can( 'manage_options', $user_id ) ) {
			add_submenu_page(
				'hnwaar',
				__( 'Configurações', 'hn-whatsapp-chat-pro-attendant-rotation' ),
				__( 'Configurações', 'hn-whatsapp-chat-pro-attendant-rotation' ),
				'manage_options', 
				'hnwaar-options',
				array($this, 'page_options'), 
				10
			);

			add_submenu_page(
				'hnwaar',
				__( 'Rodízio Atendentes', 'hn-whatsapp-chat-pro-attendant-rotation' ),
				__( 'Rodízio Atendentes', 'hn-whatsapp-chat-pro-attendant-rotation' ),
				'manage_options', 
				'hnwaar-attendant-rotation',
				array($this, 'page_attendant_rotation'), 
				10
			);
		}
	}
	
	// Template da página de configurações
	function page_options() {
		include HN_WAAR_PLUGIN_DIR . 'templates/settings/settings.php';
	}
	
	// Template da página listagem de atendentes no rodízio
	function page_attendant_rotation() {
		include HN_WAAR_PLUGIN_DIR . 'templates/settings/attendant-rotation.php';
	}
	
	// Registra as opções de configurações
	function register_settings() {
		register_setting('hnwaar-options', 'hnwaar');
		add_settings_section('hnwaar-section', 'Configurações', array($this, 'section'), 'hnwaar-options');
		add_settings_field(
			'hnwaar-rotation-type',
			'Tipo de rotação',
			array($this, 'field_select'),
			'hnwaar-options', 
			'hnwaar-section', 
			array(
				'field' => 'rotation-type', 
				'default' => 0,
				'items' => array(0 => 'Não limpar o cache', 1 => 'Limpar o cache')
			)
		);
		
		include_once(QLWAPP_PLUGIN_DIR . 'includes/models/Contact.php');
		$contact_model = new QLWAPP_Contact();
		$ArContacts = $contact_model->get_contacts();
		$ArItems = array();
		$ArItems['naoexibir'] = 'Não exibir se não tiver atendente disponível';
		foreach ($ArContacts as $contact){			
			$ArItems[ $contact['id'] ] = trim( $contact['firstname'] . ' ' . $contact['lastname']);
		}
		add_settings_field(
			'hnwaar-standard-attendant',
			'Atendente padrão',
			array($this, 'field_select'),
			'hnwaar-options', 
			'hnwaar-section', 
			array(
				'field' => 'standard-attendant', 
				'default' => 'naoexibir',
				'message' => 'Atendente que será exibido caso nenhum atendente esteja disponível.',
				'items' => $ArItems
			)
		);
	
		add_settings_field(
			'hnwaar-participates-in-the-rotation',
			'Participa do rodízio',
			array($this, 'field_select'),
			'hnwaar-options', 
			'hnwaar-section', 
			array(
				'field' => 'participates-in-the-rotation', 
				'default' => 0,
				'message' => 'Selecione "Sim" caso o atendente padrão também participe do rodízio.',
				'items' => array(0 => 'Não', 1 => 'Sim')
			)
		);
	}
	
	// Texto explicativo da seção
	function section() {
		echo '<p>Caso você esteja utilizando o plugin de cache WP Rocket, e o rodízio não esteja funcionando recomendamos que selecione a opção "Limpar o cache" no "Tipo de rotação".</p>';
	}
	
	// Campo do tipo input
	function field_input($args) {
		$options 	= get_option('hnwaar');
		$name		= $args['field'];
		$type		= $args['type'] ?? 'text';
		$default	= $args['default'] ?? '';
		$value		= $options[$name] ?? $default;
		$size		= $args['size'] ?? '100';
		
		include HN_WAAR_PLUGIN_DIR . 'templates/settings/input.php';
	}
	
	// Campo do tipo select
	function field_select($args) {
		$options 	= get_option('hnwaar');
		$name		= $args['field'];
		$default	= $args['default'] ?? '';
		$message	= $args['message'] ?? '';
		$value		= $options[$name] ?? $default;
		$items		= $args['items'];
		
		include HN_WAAR_PLUGIN_DIR . 'templates/settings/select.php';
	}
	
}

new HN_WAAR_Settings();