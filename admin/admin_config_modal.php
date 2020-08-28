<?php
if ( ! defined( 'ABSPATH' ) ) exit;
if( ! defined( 'XBOX_HIDE_DEMO' ) ){
    define( 'XBOX_HIDE_DEMO', true );
}
class adminConfig{

    function __construct()
    {
        add_action( 'xbox_init', array($this,'my_admin_page'));
    }

    public function my_admin_page(){

        $options = array(
                'id' => 'config-suscribe',//It will be used as "option_name" key to save the data in the wp_options table
                'title' => '',
                'menu_title' => 'Configuraci&#243;n Modal',
                'icon' =>'',
                'skin' => 'blue',// Skins: blue, lightblue, green, teal, pink, purple, bluepurple, yellow, orange'.
                'layout' => 'boxed',//Layouts: wide, boxed
                'position' => 60,
                'parent' => 'coupon_manager_settings',//The slug name for the parent menu (or the file name of a standard WordPress admin page).
                'capability' => 'read',//https://codex.wordpress.org/Roles_and_Capabilities
                'header' => array(
                    'icon' => '<img src="'.XBOX_URL.'./../../admin/images/cloud_creatives.png"/>',
                    'desc' => 'More information: <a href="https://creatives.com.co/"> www.creatives.com.co</a> <br>
                               contacto@creatives.com.co , services@cloudberry.com.co <br>',
            ),
            'saved_message' => __( 'Settings updated', 'xbox' ),
            'reset_message' => __( 'Settings reset', 'xbox' ),
            'form_options' => array(
                'id' => 'id-form-tag',
                'action' => '',
                'method' => 'post',
                'save_button_text' => __('Save Changes', 'xbox'),
                'save_button_class' => '',
                'reset_button_text' => __('Reset to Defaults', 'xbox'),
                'reset_button_class' => '',
            ),
            'import_settings' => array(
                'update_uploads_url' => true,
                'update_plugins_url' => true,
                'show_authentication_fields' => false,//Show username and password fields
            ),

        );
        $xbox = xbox_new_admin_page( $options );

        $prefix = "_natur";

        $xbox->add_field(array(
            'id' => $prefix.'_titulo_modal',
            'name' => __( 'Estilos Modal', 'subscribe-user-natural' ),
            'type' => 'title',
            'desc' => __('Modal Styles', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_logo_modal',
            'name' => __( 'Default Logo', 'subscribe-user-natural' ),
            'type' => 'file',
            'desc' => __('Image header logo superior', 'subscribe-user-natural'),
			'options' => array(
				'multiple' => false,//Default: false
				'mime_types' => array( 'jpg', 'jpeg', 'png'),//Default: array()
				'protocols' => array( 'http', 'https' ),//Default: array()
				'preview_size' => array( 'width' => '90px' ),//Default: array( 'width' => '64px', 'height' => 'auto' )
				)
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_slogan',
            'name' => __( 'Slogan', 'subscribe-user-natural' ),
            'type' => 'text',
            'grid' => '3-of-6',
            'desc' => __('Short description of modal', 'subscribe-user-natural'),
        ));
        
        
        $xbox->add_field(array(
            'id' => $prefix.'_month',
            'name' => __( 'Number Month ', 'subscribe-user-natural' ),
            'type' => 'number',
            'grid' => '1-of-6',
            'default' => '1',
            'options' => array(
		            'unit' => 'Month',
		            'show_unit' => true,
		            'show_spinner' => true,
		            'disable_spinner' => false,
	            ),
            'desc' => __('Enter the number of months of said coupon', 'subscribe-user-natural'),
        ));
        

        $xbox->add_field(array(
            'id' => $prefix.'_font_size',
            'name' => __( 'Font Size Slogan', 'subscribe-user-natural' ),
            'type' => 'number',
            'default' => 30,
            'desc' => __('Short size text description of modal', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_text_color',
            'name' => __( 'Texto Color Slogan', 'subscribe-user-natural' ),
            'type' => 'colorpicker',
            'default' => '#fff',
            'desc' => __('Color text slogan', 'subscribe-user-natural'),
        ));
        
        $xbox->add_field(array(
            'id' => $prefix.'_count_cupon',
            'name' => __( 'Limite Use', 'subscribe-user-natural' ),
            'type' => 'text',
            'grid' => '2-of-6',
            'desc' => __('Number Limit Use Cupon', 'subscribe-user-natural'),
        ));
        
        $xbox->add_field(array(
            'id' => $prefix.'_background_content',
            'name' => __( 'Background content', 'subscribe-user-natural' ),
            'type' => 'colorpicker',
            'default' => '#a3aa87',
            'desc' => __('Background color modal content', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_background_color',
            'name' => __( 'Background Color', 'subscribe-user-natural' ),
            'type' => 'colorpicker',
            'default' => '#7b864b',
            'desc' => __('Color text description of modal general', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_opacity',
            'name' => __( 'Background Opacity', 'subscribe-user-natural' ),
            'type' => 'text',
            'default' => '.4',
            'grid' => '1-of-6',
        ));


        $xbox->add_field(array(
            'id' => $prefix.'_text_butom',
            'name' => __( 'Text Butom', 'subscribe-user-natural' ),
            'type' => 'text',
            'default' => '',
            'desc' => __('Button name value', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_background_button',
            'name' => __( 'Background Buttom', 'subscribe-user-natural' ),
            'type' => 'colorpicker',
            'default' => '#747b58',
        ));


        $xbox->add_field(array(
            'id' => $prefix.'_description',
            'name' => __( 'Description large', 'subscribe-user-natural' ),
            'type' => 'wp_editor',
            'default' => '',
            'grid' => '5-of-6'

        ));

        $xbox->add_field(array(
            'id' => $prefix.'_titulo_config',
            'name' => __( 'Setting', 'subscribe-user-natural' ),
            'type' => 'title',
            'desc' => __('Configuration data', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_number_discount',
            'name' => __( 'Discount Number', 'subscribe-user-natural' ),
            'type' => 'text',
            'desc' => __('The discount is for %', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_link_facebook',
            'name' => __( 'Link Facebook', 'subscribe-user-natural' ),
            'type' => 'text',
            'default' => '',
            'desc' => __('This is link you facebook in the email <br> Example: https://www.facebook.com/Agenciadigitalcreatives ', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_link_instagram',
            'name' => __( 'Link Instagram', 'subscribe-user-natural' ),
            'type' => 'text',
            'default' => '',
            'desc' => __('This is link you instagram in the email <br> Example: https://www.instagram.com/creatives_agencia/?igshid=3obju94nyhk7', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_email_active',
            'name' => __( 'Email', 'subscribe-user-natural' ),
            'type' => 'text',
            'default' => '',
            'desc' => __('Email where you receive subscribers', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_affair',
            'name' => __( 'Affair', 'subscribe-user-natural' ),
            'type' => 'text',
            'default' => '',
            'desc' => __('Email subject ', 'subscribe-user-natural'),

        ));

        $xbox->add_field(array(
            'id' => $prefix.'_affair_reponder',
            'name' => __( 'Subject Autoresponder', 'subscribe-user-natural' ),
            'type' => 'text',
            'default' => '',
            'desc' => __('Auto reply issue', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_link_term',
            'name' => __( 'Link Terms and conditions', 'subscribe-user-natural' ),
            'type' => 'text',
            'default' => '',
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_exclude_cupon',
            'name' => __( 'ID Product Exclude Cupon', 'subscribe-user-natural' ),
            'type' => 'text',
            'default' => '',
            'desc' => __('Enter the identifiers that you do not want the discount to be found.', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_text_auto_responder',
            'name' => __( 'Auto Respuesta', 'subscribe-user-natural' ),
            'type' => 'textarea',
            'default' => '',
            'desc' => __('Enter the text you want in the auto reply.', 'subscribe-user-natural'),
        ));

        $xbox->add_field(array(
            'id' => $prefix.'_custom_css',
            'name' => __( 'Custom css', 'subscribe-user-natural' ),
            'type' => 'code_editor',
            'options' => array(
                'language' => 'css',//css, php, javascript, html, xml. Default: javascript
                'theme' => 'cobalt', // ambiance, chrome, cobalt, dreamweaver, monokai, solarized_light. Default: tomorrow_night
                'height' => '200px'//Default: 240px
            ),
            'default' => '
.logo_modal_input{
   width: 50%;
   margin: auto;
   margin-top: auto;
   margin-top: 30px;
            }'
        ));

    }
}
new adminConfig();

