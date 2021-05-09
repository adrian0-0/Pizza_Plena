<?php
/*
Plugin Name: Hostnet Avisos
Description: Avisos da Hostnet
Version:     1
Author:      Hostnet Internet
Author URI:  https://www.hostnet.com.br
Text Domain: hostnet
*/

function my_error_notice() {
    ?>
<div class="notice is-dismissible" style="border-left-color: #7D4CD3;">
  <p style="font-size: 2em; color: #4751C5; font-weight: bold;">ATENÇÃO</p>
  <p style="font-size: 1.2em">Enquanto você estiver hospedado na <strong>Hostnet</strong>, seu site ou loja virtual pode utilizar alguns <strong>temas e plugins premiums</strong> que disponibilizamos para clientes.</p>
  <p style="font-size: 1.2em">Para ativar estes temas e plugins, acesse o painel de controle da Hostnet e abra uma chamado no Helpdesk com a mensagem "Solicito ativação dos temas e plugins pagos".<br><strong>Informe no chamado os dados de acesso ao seu WordPress.</strong></p>
  <p style="font-size: 1.2em">A ativação pode demorar até 24 horas úteis.</p>
  <p style="font-size: 1.2em">Para não exibir esta mensagem desative o plugin Hostnet Avisos.</p>  
  <button type="button" class="notice-dismiss"><span class="screen-reader-text">Dispensar este aviso.</span></button>
</div>
    <?php
}
add_action( 'admin_notices', 'my_error_notice' );