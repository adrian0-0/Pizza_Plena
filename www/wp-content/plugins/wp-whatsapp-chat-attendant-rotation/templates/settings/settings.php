<?
if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( __( 'Você não tem permissão suficiente para acessar esta página.', 'hn-whatsapp-chat-pro-attendant-rotation' ) );
}
?>
<div class="xwrap">
	<h1>Hostnet WhatsApp Rodízio de Atendentes</h1>
	<form action="options.php" method="post">
	<?
		settings_fields('hnwaar-options');
		do_settings_sections('hnwaar-options');
		submit_button('Salvar configurações');
	?>
	</form>
</div>