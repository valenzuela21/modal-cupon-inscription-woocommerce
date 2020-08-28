<?php
/*
Plugin Name:  Modal Subscriber User
Plugin URI:
Description:  Plugin for new user subscriber with offer system.
Version:      1.0
Author:       David Fernando Valenzuela Pardo
Author URI:
License:      GPL2
License URI:  https://creatives.com.co/
Text Domain:  subscribe-user-natural
*/
if ( ! defined( 'ABSPATH' ) ) exit;

define("HTML_EMAIL_HEADERS", array('Content-Type: text/html; charset=UTF-8'));
define("PATH", plugin_dir_path(__FILE__));

class modal_suscribe{

    function __construct()
    {
    add_action('init', array($this, "modal_require_path"));
    add_filter( 'wp_mail_from_name',  array($this,"wpb_sender_name"));
    add_action('wp', array($this,'crear_data_base'));
    register_activation_hook( __FILE__, array($this,'action_active_component'));

    }

    public function  modal_require_path(){
        require_once PATH . './admin/xbox/xbox.php';
        require_once PATH . './content/shortcode_modal.php';
        require_once PATH . './content/insert_data.php';
        require_once PATH . './admin/admin.php';
        require_once PATH . './admin/admin_config_modal.php';
    }

   
    // Function to change sender name

    public function wpb_sender_name( $original_email_from ) {
        return get_bloginfo('name');
    }

    
    public  function send_email_woocommerce_style($email, $subject, $heading, $message) {
        // Get woocommerce mailer from instance
        $mailer = WC()->mailer();

        // Wrap message using woocommerce html email template
        $wrapped_message = $mailer->wrap_message($heading, $message);

        // Create new WC_Email instance
        $wc_email = new WC_Email;

        // Style the wrapped message with woocommerce inline styles
        $html_message = $wc_email->style_inline($wrapped_message);

        // Send the email using wordpress mail function
        wp_mail( $email, $subject, $html_message, HTML_EMAIL_HEADERS );

    }

    public function send_email_new_user($name_full, $phone_full, $email_full, $number_coupon, $date_expire){
        $xbox = Xbox::get( 'config-suscribe' );
        $subject_responder = $xbox->get_field_value('_natur_affair_reponder');
        $link_facebook = $xbox->get_field_value('_natur_link_facebook');
        $link_instagram = $xbox->get_field_value('_natur_link_instagram');
        $text_auto_responder = $xbox->get_field_value('_natur_text_auto_responder');
        $site_url = get_site_url();

        $email = $email_full;
        $subject = $subject_responder;
        $heading =  $subject_responder;
        $message = "<div>
                     <h3>Thanks for joining us</h3><h3>Gracias por suscribirte</h3>
                        <p>{$name_full} Received a discount coupon for subscription.</p>
                        <p>Discount coupon number: {$number_coupon} expires in  {$date_expire}</p>
                        
                        <p>{$text_auto_responder}</p>
                        <div style='text-align: center; display: flex; justify-content: center; align-items: center; '>
                        <a href='.$link_facebook.' style='width: 35px' target='_blank'><img src=".plugins_url('./assets/images/facebook_icon.svg', __FILE__)." alt='icon_facebook'/></a>
                        <a href='.$link_instagram.' style='width: 35px' target='_blank'><img src=".plugins_url('./assets/images/instragram_icon.svg', __FILE__)." alt='icon_instagram'/></a>
                        </div>
                        <p style='text-align:center; margin-top:20px'><a href='.$site_url.' target='_blank' >".$site_url."<a></p>
                    </div>";

        $this->send_email_woocommerce_style($email, $subject, $heading, $message);

    }

    public function send_email_admin($full_name, $phone, $email_user, $number_coupon, $date_expire){
        $xbox = Xbox::get( 'config-suscribe' );
        $email_to = $xbox->get_field_value('_natur_email_active');
        $subject = $xbox->get_field_value('_natur_affair');

        $email = $email_to;
        $subject =  $subject;
        $heading =   $subject;
        $message = "<div>
                     <h3>Hello, new subscriber!</h3>
                       <p>These are the new subscriber's details:</p>
                       <p>Full name: {$full_name} </p>
                       <p>Phone: {$phone}  </p>
                       <p>Email: {$email_user} </p>    
                       <p>Coupon discount number: {$number_coupon}</p>
                       <p>Date expires: {$date_expire}</p>
                    </div>";

        $this->send_email_woocommerce_style($email, $subject, $heading, $message);
    }

    public function action_active_component(){
       return $this->crear_data_base();
    }


    protected function crear_data_base() {

        global $wpdb;

        // Con esto creamos el nombre de la tabla y nos aseguramos que se cree con el mismo prefijo que ya tienen las otras tablas creadas (wp_form).
        $table_name = $wpdb->prefix . 'inscriptions';

        // Declaramos la tabla que se creará de la forma común.
        $sql = "CREATE TABLE $table_name (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) NOT NULL,
            `telefono` varchar(255) NOT NULL,
            `email` varchar(255) NOT NULL,
            `cupon` varchar(255) NOT NULL,
            UNIQUE KEY id (id)
        );";

        // upgrade contiene la función dbDelta la cuál revisará si existe la tabla.
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        // Creamos la tabla
        dbDelta($sql);
    }

    
}
new modal_suscribe();

