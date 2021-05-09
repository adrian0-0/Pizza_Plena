<?php
class HN_WAAR_Profile {
	
	public function __construct() {
		// Adiciona campo extra para conectar usuário do WordPress ao atendente
		add_action( 'show_user_profile', array( $this, 'extra_user_profile_fields' ), 1 );
		add_action( 'edit_user_profile', array( $this, 'extra_user_profile_fields' ), 1 );
		
		// Salva campo extra de atendente no usuário do WordPress
		add_action( 'personal_options_update', array( $this, 'save_extra_user_profile_fields' ) );
		add_action( 'edit_user_profile_update', array( $this, 'save_extra_user_profile_fields' ) );
	}

	function extra_user_profile_fields( $user ) {
		$BoAddExtraFields = false;
		$BoAdmin = false;
		$attendant = esc_attr( get_the_author_meta( 'waar_attendant', $user->ID ) );
		$available = esc_attr( get_the_author_meta( 'waar_available', $user->ID ) );
		
		// Se for um administrador
		if ( current_user_can( 'manage_options', $user->ID ) ) {
			$BoAddExtraFields = true;
			$BoAdmin = true;
			include_once(QLWAPP_PLUGIN_DIR . 'includes/models/Contact.php');
			$contact_model = new QLWAPP_Contact();
			$ArContacts = $contact_model->get_contacts();
			
		}
		
		if (!empty($attendant)) {
			$BoAddExtraFields = true;
		}
		
		// Se tiver for administrador, ou o usuário for um atendente
		if ($BoAddExtraFields) {
			include HN_WAAR_PLUGIN_DIR . 'templates/profile_fields.php';
		}
	}
	
	function save_extra_user_profile_fields( $user_id ) {
		// Se pode editar um usuário
		if ( current_user_can( 'edit_user', $user_id ) ) { 
			if ( current_user_can( 'manage_options', $user->ID ) and isset($_POST['waar_attendant']) ) {
				update_user_meta( $user_id, 'waar_attendant', $_POST['waar_attendant'] );
			}
			update_user_meta( $user_id, 'waar_available', $_POST['waar_available'] );
		}
	}
	
}

new HN_WAAR_Profile();