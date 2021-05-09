<?php
class HN_WAAR
{
	public function __construct() {
		$this->init();
	}
	
	public function init()
	{
		add_action('qlwapp_init', array($this, 'includes'));
	}
	
	public function includes()
	{
		// Verifica se é um redirecionamento para o WhatsApp de um atendente
		$this->redirect_whatsapp();
		
		// Substitui o JavaScript
		add_action( 'wp_enqueue_scripts', array($this, 'add_js'), 99 );
		
		// Altera o template do box do WhatsApp
		add_filter( 'qlwapp_box_template', array($this, 'box_premium'),99 );
		
		// Adiciona o link de configurações na página de plugins
		add_filter( 'plugin_action_links_' . HN_WAAR_PLUGIN_SLUG . '/' . HN_WAAR_PLUGIN_SLUG . '.php', array($this, 'settings_link') );
	}


	public function settings_link( $links ) {
		
		// Cria e escape do URL.
		$url = esc_url( add_query_arg(
			'page',
			'hnwaar-options',
			get_admin_url() . 'admin.php'
		) );

		// Cria o link.
		$settings_link = "<a href='$url'>" . __( 'Configurações' ) . '</a>';
		
		// Adiciona o link ao final da matriz.
		array_push(
			$links,
			$settings_link
		);
		return $links;
	}

	public function add_js() {
		wp_deregister_script( QLWAPP_DOMAIN );
		wp_enqueue_script(QLWAPP_DOMAIN, HN_WAAR_PLUGIN_URL . 'assets/js/waar.js', array('jquery'), HN_WAAR_PLUGIN_JS_VERSION, true);
	}
	
	// Se for um redirecionamento do WhatsApp, salva o horário no atendente e limpa o cache
	public function redirect_whatsapp() {
		$this->save_contact_datetime_click();
		if ( !empty($_GET['hn_url_redirect']) ) {
			
			// Limpa o cache se a opção "Com cache" estiver configurada.
			$options = get_option('hnwaar');
			if ($options['rotation-type'] == 1) {
				if ( function_exists( 'rocket_clean_domain' ) ) {
					require(get_home_path() . 'wp-load.php' );
					require(WP_ROCKET_PATH . 'inc/functions/i18n.php');
					require(WP_ROCKET_PATH . 'inc/functions/formatting.php');
					rocket_clean_domain();
				}
			}

			header('Location: ' . $_GET['hn_url_redirect']);
			exit;
		}
	}
	
	// Carrega dados do atendente e salva o horário do último atendimento
	public function save_contact_datetime_click() {
		if ( !empty($_GET['hn_url_redirect']) and !empty($_GET['phone']) ) {
			include_once(QLWAPP_PLUGIN_DIR . 'includes/models/Contact.php');
			$contact_model = new QLWAPP_Contact();
			$ArContacts = $contact_model->get_contacts();
			$id_contact = -1;
			foreach ($ArContacts as $contact) {
				if ($_GET['phone'] == $contact['phone']) {
					$id_contact = $contact['id'];
					break;
				}
			}
			$this->save_data_option($id_contact);
		}
	}
	
	// Salva o horário do último atendimento
	public function save_data_option($id_contact = -1) {
		if ($id_contact == -1) {
			return;
		}
		$option_name = 'waar-contacts' ;
		$ArOptionWaar = get_option( $option_name );
		if ( $ArOptionWaar !== false ) {
			$ArDataOption = $ArOptionWaar;
			$ArDataOption[$id_contact] = time();
			update_option( $option_name, $ArDataOption );

		} else {
			$ArDataOption = array();
			$ArDataOption[$id_contact] = time();
			add_option( $option_name, $ArDataOption );
		}
	}
	
	public function box_premium($template) {
		$template = HN_WAAR_PLUGIN_DIR . 'templates/box_premium_waar.php';
		return $template;
	}
	
	// Carrega a lista de atendentes e faz o rodízio
	public function get_contacts_rotation() {
		include_once(QLWAPP_PLUGIN_DIR . 'includes/models/Contact.php');
		$contact_model = new QLWAPP_Contact();
		$ArContacts = $contact_model->get_contacts();
		$ArRotation = array();
		foreach ($ArContacts as $contact) {
			$ArRotation[ $contact['id'] ] = 0;
		}

		$option_name = 'waar-contacts' ;
		$ArOptionWaar = get_option( $option_name );
		if ( $ArOptionWaar !== false ) {
			foreach ($ArOptionWaar as $key => $value) {
				$ArRotation[ $key ] = $value;
			}
		}

		// Pega o atendente padrão para exibir se não tiver nenhum atendente disponível.
		$options = get_option('hnwaar');
		$standard_attendant = $options['standard-attendant'];
		$participates_in_the_rotation = $options['participates-in-the-rotation'];
		
		$id_contact_rotation = -1;
		$date_click = 99999999999999;
		foreach ($ArRotation as $key => $value) {
			
			$BoRodizio = false;
			
			// Verifica se o atendente está relacionado com um usuário 
			// e se está com disponibilidade Online
			$ArUser = get_users(
				array(
					'meta_query' => array(
						array(
							'key' => 'waar_attendant',
							'value' => $key,
							'compare' => '=='
						)
					),
					'number' => 1,
					'count_total' => false
				)
			);
			
			// Se o usuário estiver associado a um usuário, verifica se está online
			// Senão utiliza as regras de horário do atendente
			if (count($ArUser) > 0) {
				$user_id = $ArUser[0]->ID;
				$waar_available = get_user_meta( $user_id, 'waar_available', true );
				if ($waar_available == '1') {
					$BoRodizio = true;
				}
			}
			
			// Se for o atendente padrão e ele não participar do rodízio
			if ($standard_attendant == $key and $participates_in_the_rotation != '1') {
				$BoRodizio = false;
			}

			// Verifica o atendente que está a mais tempo sem atender
			if ($value <= $date_click and $BoRodizio) {
				$id_contact_rotation = $key;
				$date_click = $value;
			}
		}
		
		
		// Se nenhum atendente estiver disponível, pegar o atendente padrão.
		if ($id_contact_rotation == -1) {
			$id_contact_rotation = $standard_attendant;
		}
		
		// Define o atendente que irá ser exibido
		$ArContactRotation = array();
		foreach ($ArContacts as $contact) {
			if ($contact['id'] == $id_contact_rotation) {
				$ArContactRotation[] = $contact;
			}
		}

        return $ArContactRotation;
    }
	
}

new HN_WAAR();