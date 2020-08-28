<?php

if (!defined('ABSPATH')) exit;


class AdminConfigSubscribe
{

    function __construct()
    {
        add_action('admin_menu', array($this, 'wpdocs_register_my_custom_menu_page'));
        add_action('admin_enqueue_scripts', array($this, 'js_css_admin_require'));
    }


    public function js_css_admin_require($hook)
    {


        if ('toplevel_page_coupon_manager_settings' === $hook) {

            wp_enqueue_script('admin_js_data_tables_min', 'https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js', array('jquery'), 1.0, true);
            wp_enqueue_script('admin_js_data_tables_cui_min', 'https://cdn.datatables.net/1.10.21/js/dataTables.semanticui.min.js', array('jquery'), 1.0, true);
            wp_enqueue_script('admin_js_data_tables_buttons_min', 'https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js', array('jquery'), 1.0, true);
            wp_enqueue_script('admin_js_data_tables_semati_cui', 'https://cdn.datatables.net/buttons/1.6.2/js/buttons.semanticui.min.js', array('jquery'), 1.0, true);
            wp_enqueue_script('admin_js_data_tables_jszip', 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js', array('jquery'), 1.0, true);
            wp_enqueue_script('admin_js_data_tables_pdfmake', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js', array('jquery'), 1.0, true);
            wp_enqueue_script('admin_js_data_tables_fonts', 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js', array('jquery'), 1.0, true);
            wp_enqueue_script('admin_js_data_tables_html5', 'https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js', array('jquery'), 1.0, true);
            wp_enqueue_script('admin_js_data_tables_print_min', 'https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js', array('jquery'), 1.0, true);
            wp_enqueue_script('admin_js_data_tables_colvis_min', 'https://cdn.datatables.net/buttons/1.6.2/js/buttons.colVis.min.js', array('jquery'), 1.0, true);

            wp_enqueue_script('admin_js_config_coupon', plugins_url('./js/script-config.js', __FILE__), array('jquery'), 1.0, true);

            wp_enqueue_style('admin_semantic_ui_min', 'https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.3.1/semantic.min.css');
            wp_enqueue_style('admin_semantic_cui_min', 'https://cdn.datatables.net/1.10.21/css/dataTables.semanticui.min.css');
            wp_enqueue_style('admin_semantic_buttons_cui_min', 'https://cdn.datatables.net/buttons/1.6.2/css/buttons.semanticui.min.css');

        }

    }

    /**
     * Register a custom menu page.
     */
    function wpdocs_register_my_custom_menu_page()
    {
        add_menu_page(
            __('Tabla Subscribers', 'subscribe-user-natural'),
            __('Tabla Subscribers', 'subscribe-user-natural'),
            'read',
            'coupon_manager_settings',
            array($this, 'my_custom_menu_page'),
            plugins_url("./images/icon_creatives.png", __FILE__),
            6
        );
    }

    /**
     * Display a custom menu page
     */
    function my_custom_menu_page()
    {
        global $wpdb;
        echo '<div class="wrap">
        <table id="example" class="ui celled table" style="width:100%">
   <thead>
      <tr>
         <th>'.__('Name','subscribe-user-natural').'</th>
         <th>'.__('Telephone','subscribe-user-natural').'</th>
         <th>'.__('Email','subscribe-user-natural').'</th>
         <th>'.__('Cupon','subscribe-user-natural').'</th>
      </tr>
   </thead>
   <tbody>';
        $table_name = $wpdb->prefix . 'inscriptions';
        $db_select = $wpdb->get_results( "SELECT * FROM $table_name" );
		$db_select = maybe_unserialize( $db_select );

		 foreach ($db_select as $value) {
            echo '<tr>
                     <td>'.$value->nombre.'</td>
                     <td>'.$value->telefono.'</td>
                     <td>'.$value->email.'</td>
                     <td>'.$value->cupon.'</td>
                   </tr>';
        }

      echo '</tbody>
      <tfoot>
       <tr>
         <th>'.__('Name','subscribe-user-natural').'</th>
         <th>'.__('Telephone','subscribe-user-natural').'</th>
         <th>'.__('Email','subscribe-user-natural').'</th>
         <th>'.__('Cupon','subscribe-user-natural').'</th>
      </tr>
      </tfoot>
</table>

</div>   ';
    }


}

new AdminConfigSubscribe();