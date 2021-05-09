<?
if ( ! current_user_can( 'manage_options' ) ) {
	wp_die( __( 'Você não tem permissão suficiente para acessar esta página.', 'hn-whatsapp-chat-pro-attendant-rotation' ) );
}

$StURL = get_admin_url() . 'admin.php?page=hnwaar-attendant-rotation';

if (isset($_GET['action'])) {
	// Tornar Atendente Online
	if ($_GET['action'] == 'online' and $_GET['idu'] > 0) {
		update_user_meta( $_GET['idu'], 'waar_available', '1' );
		wp_redirect( $StURL );
		exit;
	}

	// Tornar Atendente Offline
	if ($_GET['action'] == 'offline' and $_GET['idu'] > 0) {
		update_user_meta( $_GET['idu'], 'waar_available', '0' );
		wp_redirect( $StURL );
		exit;
	}
}

$ListAttendantRotation = new List_Attendant_Rotation();
$ListAttendantRotation->prepare_items();
?>
<div class="wrap">
	<div id="icon-users" class="icon32"></div>
	<h2>Rodízio Atendentes</h2>
	<?php $ListAttendantRotation->display(); ?>
</div>
<?php

/**
 * WP_List_Table não é carregado automaticamente, então precisamos carregá-lo.
 */
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
 * Crie uma nova classe de tabela que estenderá WP_List_Table
 */
class List_Attendant_Rotation extends WP_List_Table
{
    /**
     * Prepara os item da tabela
     *
     * @return Void
     */
    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $data = $this->table_data();
        usort( $data, array( &$this, 'sort_data' ) );

        $perPage = 50;
        $currentPage = $this->get_pagenum();
        $totalItems = count($data);

        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );

        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $data;
    }

    /**
	 * Substitue o método das colunas da classe pai. Define as colunas a serem usadas em sua tabela.
     *
     * @return Array
     */
    public function get_columns()
    {
        $columns = array(
            'id'           => 'ID',
            'display_name' => 'Nome',
            'availability' => 'Disponibilidade',
            'action'       => 'Ação'
        );

        return $columns;
    }

    /**
     * Defina quais colunas serão ocultas
     *
     * @return Array
     */
    public function get_hidden_columns()
    {
        return array();
    }

    /**
     * Define as colunas de ordenação
     *
     * @return Array
     */
    public function get_sortable_columns()
    {
        return array('display_name' => array('display_name', false));
    }

    /**
     * Coleta dos dados
     *
     * @return Array
     */
    private function table_data()
    {
        $data = array();

		$ArUsers = get_users(
			array(
				'meta_query' => array(
					array(
						'key' => 'waar_attendant',
						'value' => 0,
						'compare' => '>'
					)
				),
				'number' => 1000,
				'count_total' => false
			)
		);
		$StURL = get_admin_url() . 'admin.php?page=hnwaar-attendant-rotation';
		foreach ($ArUsers as $ArUser) {
			$waar_available = get_user_meta( $ArUser->data->ID, 'waar_available', true );
			if ($waar_available == '1') {
				$StWaar_available = '<span style="color: #008a20">Online</span>';
				$StAction = '<a class="qlwapp_settings_edit button" href="' . 
					$StURL . '&action=offline&idu=' . $ArUser->data->ID . '">Tornar Offline</a>';
			} else {
				$StWaar_available = '<span style="color: #d63638">Offline</span>';
				$StAction = '<a class="qlwapp_settings_edit button" href="' . 
					$StURL . '&action=online&idu=' . $ArUser->data->ID . '">Tornar Online</a>';
			}
			$data[] = array(
				'id'           => $ArUser->data->ID,
				'display_name' => $ArUser->data->display_name,
				'availability' => $StWaar_available,
				'action'       => $StAction
			);
		}
		
        return $data;
    }

    /**
     * Define quais dados mostrar em cada coluna
     *
     * @param  Array $item        Data
     * @param  String $column_name - Current column name
     *
     * @return Mixed
     */
    public function column_default( $item, $column_name )
    {
        switch( $column_name ) {
            case 'id':
            case 'display_name':
            case 'availability':
            case 'action':
                return $item[ $column_name ];

            default:
                return print_r( $item, true ) ;
        }
    }

    /**
     * Permite que você classifique os dados pelas variáveis definidas no $ _GET
     *
     * @return Mixed
     */
    private function sort_data( $a, $b )
    {
        // Set defaults
        $orderby = 'display_name';
        $order = 'asc';

        // If orderby is set, use this as the sort column
        if(!empty($_GET['orderby']))
        {
            $orderby = $_GET['orderby'];
        }

        // If order is set use this as the order
        if(!empty($_GET['order']))
        {
            $order = $_GET['order'];
        }


        $result = strcmp( $a[$orderby], $b[$orderby] );

        if($order === 'asc')
        {
            return $result;
        }

        return -$result;
    }
}
?>