<?
if ($BoAddExtraFields == false) {
	return;
}
?>
<h3><?php _e("WhatsApp Rodízio de Atendentes", 'hn-whatsapp-chat-pro-attendant-rotation'); ?></h3>
<table class="form-table">


<? if ($BoAdmin) : ?>
<tr>
	<th><label for="Attendant"><?php _e("Atendente", 'hn-whatsapp-chat-pro-attendant-rotation'); ?></label></th>
	<td>
		<select name="waar_attendant" id="waar_attendant">
			<option value="" selected="selected"><?php _e("Selecione um atendente.", 'hn-whatsapp-chat-pro-attendant-rotation'); ?></option>
			<?php foreach ($ArContacts as $contact) : ?>
			<?php
			$k = $contact['id'];
			$v = trim( $contact['firstname'] . ' ' . $contact['lastname']);
			?>
			<option value="<?php echo $k; ?>" <?php selected($k, $attendant) ?>><?php echo $v; ?></option>
			<?php endforeach ?>
		</select>
		<span class="description"><?php _e("Selecione um atendente.", 'hn-whatsapp-chat-pro-attendant-rotation'); ?></span>
	</td>
</tr>
<? endif; ?>

<tr>
	<th><label for="Available"><?php _e("Disponibilidade", 'hn-whatsapp-chat-pro-attendant-rotation'); ?></label></th>
	<td>
		<select name="waar_available" id="waar_available">
			<option value="0" <?php selected(0, $available) ?>>Offline</option>
			<option value="1" <?php selected(1, $available) ?>>Online</option>
		</select>
		<span class="description"><?php _e("Selecione a disponibilidade do atendente.", 'hn-whatsapp-chat-pro-attendant-rotation'); ?></span>
	</td>	
</tr>

</table>