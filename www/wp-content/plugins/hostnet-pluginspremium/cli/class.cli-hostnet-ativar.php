<?php
/**
 * Logica dos comandos de ativacao dos plugins premiums da Hostnet
 * 
 * @author Eudes
 */

class HNPP_CLI_Hostnet_Ativar {

    private $chave;

    public function __construct ( $chave ) {
        $this->set_chave($chave);
    }

    public function set_chave ( $chave ) {
        $this->chave = $chave;
    }

    public function get_chave ( ) {
        return $this->chave;
    }

    /**
     * Ativa Microthemer
     * 
     * @author Eudes
     */
    public function microthemer ( ) {
        //$tma = new tvr_microthemer_admin();
        //$tma->get_validation_response();

        $microthemer_preferences_themer_loader_slug = 'preferences_themer_loader';
        $microthemer_preferences_themer_loader = get_option($microthemer_preferences_themer_loader_slug);

        $microthemer_preferences_themer_loader['retro_sub_check_done'] = 1;
        $microthemer_preferences_themer_loader['buyer_validated'] = 1;
        $microthemer_preferences_themer_loader['buyer_email'] = $this->chave;

        update_option($microthemer_preferences_themer_loader_slug, $microthemer_preferences_themer_loader);
    }

}