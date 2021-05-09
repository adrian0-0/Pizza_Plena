<?php
/**
 * Comando de ativacao dos plugins premiums da Hostnet
 * 
 * @author Eudes
 */

require_once plugin_dir_path(__FILE__) . '../lib/class.file-text-log.php';

class HNPP_CLI extends WP_CLI_Command {

	public function __construct ( ) {
        require_once plugin_dir_path(__FILE__) . '/class.cli-hostnet-ativar.php';
	}

    /**
     * Comando para ativar plugins Premiums oferecidos pela Hostnet
     *
     * ## EXAMPLES
     *
     *  1. wp hostnet ativar astra-pro-sites <chave>
     *  2. wp hostnet ativar uabb <chave>
     *  3. wp hostnet ativar microthemer <email>
     * 
     * @author Eudes
     */
    public function ativar ( $args, $assoc_args ) {
        
        $l = new File_Text_Log('wp-hostnet-ativar', plugin_dir_path(__FILE__) . '../log');
        $l->log('Commando chamado', $args);

		if ( isset($args[0]) ) {
			$plugin = $args[0];
		} else {
			WP_CLI::error('Digite o plugin: uabb, microthemer, astra-pro-sites, astra-addon');
		}

		if ( isset( $args[1] ) ) {
			$chave = $args[1];
		} else {
			WP_CLI::error('Digite a chave ou email');
		}

        $ret = '';
        switch ( $plugin ) {
            case 'uabb':
                $ret = WP_CLI::runcommand('brainstormforce license activate uabb ' . $chave, ['return' => true]);
                WP_CLI::success('Ultimate Addons for Beaver Builder ativado');
            break;
            case 'astra-pro-sites':
                $ret = WP_CLI::runcommand('brainstormforce license activate astra-pro-sites ' . $chave, ['return' => true]);
                WP_CLI::success('Astra Pro ativado');
            break;
            case 'astra-addon':
                $ret = WP_CLI::runcommand('brainstormforce license activate astra-addon ' . $chave, ['return' => true]);
                WP_CLI::success('Astra Premium Sites ativado');
            break;
            case 'microthemer': 
                $com = new HNPP_CLI_Hostnet_Ativar($chave);
                $com->microthemer();
                WP_CLI::success('Microthemer ativado');

                $ret = 'Microthemer ativado';
                //if ( class_exists('tvr_microthemer_admin') ) {
                    
                    //$tma = new tvr_microthemer_admin();

                    // $microthemer_preferences_themer_loader = get_option('preferences_themer_loader');

                    // $microthemer_preferences_themer_loader['retro_sub_check_done'] = 1;
                    // $microthemer_preferences_themer_loader['buyer_validated'] = 1;
                    // $microthemer_preferences_themer_loader['buyer_email'] = $chave;

                    // update_option('preferences_themer_loader', $microthemer_preferences_themer_loader);

                    // WP_CLI::success('Micro result' . print_r(['micro' => $microthemer_preferences_themer_loader], true));
                    
                    //$tma->get_validation_response($chave);
                //}
            break;
        }

        $l->log("Ativacao $plugin - $chave - $ret");

    }
}

if ( class_exists('WP_CLI') ) {
    WP_CLI::add_command('hostnet', 'HNPP_CLI');
}