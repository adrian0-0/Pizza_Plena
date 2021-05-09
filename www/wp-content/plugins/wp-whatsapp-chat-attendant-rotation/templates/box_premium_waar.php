<?
// Faz a rotação dos contatos
include_once( HN_WAAR_PLUGIN_DIR . 'includes/class-hn-waar.php' );
$hn_waar_rotation = new HN_WAAR();
$contacts = $hn_waar_rotation->get_contacts_rotation();

// Se tiver operador disponível inclui a template padrão
if (count($contacts) > 0) {
	include(QLWAPP_PRO_PLUGIN_DIR . 'template/box_premium.php');
}
?>