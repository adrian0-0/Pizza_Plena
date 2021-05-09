<?php
class HN_WAAR_Update {

	public function __construct() {
		add_filter('plugins_api', array($this, 'plugin_info'), 20, 3);
		add_filter('site_transient_update_plugins', array($this,'push_update'), 10, 1 );
		add_action('upgrader_process_complete', array($this, 'after_update'), 10, 2 );
	}
 
	// Armazene os resultados em cache para torná-lo incrivelmente rápido
	function after_update( $upgrader_object, $options ) {
		if ( $options['action'] == 'update' && $options['type'] === 'plugin' )  {
			// Apenas limpe o cache quando uma nova versão do plugin for instalada
			delete_transient( 'hnwaar-upgrade-' . HN_WAAR_PLUGIN_SLUG );
		}
	}
 
	// Empurre as informações de atualização para os transientes WP
	public function push_update( $transient ) {
	 
		if ( empty($transient->checked ) ) {
			return $transient;
		}
	 
		// Tentando obter do cache primeiro, para desativar o comentário do cache 10,20,21,22,24
		if( false == $remote = get_transient( 'hnwaar-upgrade-' . HN_WAAR_PLUGIN_SLUG ) ) {	 
			// info.json é o arquivo com as informações reais do plugin em seu servidor
			$remote = wp_remote_get( HN_WAAR_PLUGIN_INFO_JSON, array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json'
				) )
			);
	 
			if ( !is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && !empty( $remote['body'] ) ) {
				set_transient( 'hnwaar-upgrade-' . HN_WAAR_PLUGIN_SLUG, $remote, HN_WAAR_PLUGIN_CACHE_UPDATE );
			}
	 
		}

		if( $remote ) {
			$remote = json_decode( $remote['body'] );
	 
			// your installed plugin version should be on the line below! You can obtain it dynamically of course 
			if( $remote && version_compare( HN_WAAR_PLUGIN_VERSION, $remote->version, '<' ) 
				&& version_compare($remote->requires, get_bloginfo('version'), '<' ) ) {
				$res = new stdClass();
				$res->slug = HN_WAAR_PLUGIN_SLUG;
				
				// pode ser apenas YOUR_PLUGIN_SLUG.php se o seu plugin não tiver seu próprio diretório
				$res->plugin = HN_WAAR_PLUGIN_SLUG . '/' . HN_WAAR_PLUGIN_SLUG. '.php';
				$res->new_version = $remote->version;
				$res->tested = $remote->tested;
				$res->package = $remote->download_url;
				$transient->response[$res->plugin] = $res;
				//$transient->checked[$res->plugin] = $remote->version;
			}
	 
		}

		return $transient;
	}

	/*
	 * $res Vazio neste etapa
	 * $action 'plugin_information'
	 * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
	 */
	public function plugin_info( $res, $action, $args ){
	 
		// Não faça nada se não for para obter informações do plugin
		if( 'plugin_information' !== $action ) {
			return false;
		}
	 
		// Não faça nada se não for nosso plugin
		if( HN_WAAR_PLUGIN_SLUG !== $args->slug ) {
			return false;
		}
	 
		// Tentando obter do cache primeiro
		if( false == $remote = get_transient( 'hnwaar-update-' . HN_WAAR_PLUGIN_SLUG ) ) {
	 
			// info.json é o arquivo com as informações reais do plugin em seu servidor
			$remote = wp_remote_get( HN_WAAR_PLUGIN_INFO_JSON, array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json'
				) )
			);
	 
			if ( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
				set_transient( 'hnwaar-update-' . HN_WAAR_PLUGIN_SLUG, $remote, HN_WAAR_PLUGIN_CACHE_UPDATE );
			}
	 
		}
	 
		if( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
	 
			$remote = json_decode( $remote['body'] );
			$res = new stdClass();
	 
			$res->name = $remote->name;
			$res->slug = HN_WAAR_PLUGIN_SLUG;
			$res->version = $remote->version;
			$res->tested = $remote->tested;
			$res->requires = $remote->requires;
			$res->author = '<a href="https://www.hostnet.com.br">Hostnet Internet</a>';
			$res->author_profile = 'https://www.hostnet.com.br';
			$res->download_link = $remote->download_url;
			$res->trunk = $remote->download_url;
			$res->requires_php = '5.3';
			$res->last_updated = $remote->last_updated;
			$res->sections = array(
				'description' => $remote->sections->description,
				'installation' => $remote->sections->installation,
				'changelog' => $remote->sections->changelog
				// você pode adicionar suas seções personalizadas (guias) aqui
			);
	 
			// Caso deseje a aba de capturas de tela, use o seguinte formato HTML para seu conteúdo:
			// <ol><li><a href="IMG_URL" target="_blank"><img src="IMG_URL" alt="CAPTION" /></a><p>CAPTION</p></li></ol>
			if( !empty( $remote->sections->screenshots ) ) {
				$res->sections['screenshots'] = $remote->sections->screenshots;
			}

			$res->banners = array(
				'low' => $remote->banners->low,
				'high' => $remote->banners->high
			);

			return $res;
	 
		}
	 
		return false;
	 
	}
	
}

new HN_WAAR_Update();