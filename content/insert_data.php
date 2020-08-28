<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class insertNewUser{

    public $permited_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    function __construct()
    {
        add_action('wp_ajax_nopriv_wp_new_subscribe_user', array($this, 'wp_new_subscribe_user'));
        add_action('wp_ajax_wp_new_subscribe_user', array($this, 'wp_new_subscribe_user'));
    }

    public function generate_string($input, $strength = 8) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    public function new_cupon_user($mount, $number_coupon, $user_email){

        $email_user = $user_email;

        $coupon_code = $number_coupon;
        $amount = $mount; // Amount
        $discount_type = 'percent'; // Type: fixed_cart, percent, fixed_product, percent_product
        
        $xbox = Xbox::get( 'config-suscribe' );
        $exclude = $xbox->get_field_value( '_natur_exclude_cupon' );
        $limit = $xbox->get_field_value( '_natur_count_cupon' );
        $month = $xbox->get_field_value( '_natur_month' );
        
 
        $exclude_product = $exclude;
        $date = date("d-m-Y");

        $mod_date = strtotime($date." + ".$month." months");
        $date_expire = date("y-m-d", $mod_date) . "\n";
        

        $coupon = array(
            'post_title' => $coupon_code,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_type'     => 'shop_coupon'
        );

        $new_coupon_id = wp_insert_post( $coupon );

        // Add meta
        update_post_meta( $new_coupon_id, 'discount_type', $discount_type );
        update_post_meta( $new_coupon_id, 'coupon_amount', $amount );
        update_post_meta( $new_coupon_id, 'individual_use', 'yes' );
        update_post_meta( $new_coupon_id, 'product_ids', '' );
        update_post_meta( $new_coupon_id, 'exclude_product_ids', $exclude_product);
        update_post_meta( $new_coupon_id, 'usage_limit', $limit );
        update_post_meta( $new_coupon_id, 'expiry_date', $date_expire );
        update_post_meta( $new_coupon_id, 'apply_before_tax', 'yes' );
        update_post_meta( $new_coupon_id, 'free_shipping', 'no' );
        update_post_meta( $new_coupon_id, 'customer_email', "*".$email_user );
        update_post_meta( $new_coupon_id, 'exclude_sale_items', '' );

    }
    protected function insert_wpdb($data){

        global $wpdb;
		update_option( 'WP_config_coupon_admin', $data[3] );
        $table_name = $wpdb->prefix . 'inscriptions';
        $wpdb->insert( $table_name,

            array(
                'nombre' => $data[0],
                'telefono' => $data[1],
                'email' => $data[2],
                'cupon' => $data[3],
            )
        );
        
    }

    public function wp_new_subscribe_user(){
        global $wpdb;
        
        $xbox = Xbox::get( 'config-suscribe' );
        $mount = $xbox->get_field_value( '_natur_number_discount' );
        $month = $xbox->get_field_value( '_natur_month' );
 
        if(isset( $_POST['respuesta'] ) ) {
            $respuesta = wp_unslash( $_POST['respuesta'] );
            array();
        }


        $date = date("d-m-Y");
        $mod_date = strtotime($date." + ".$month." months");
        $date_expire = date("y-m-d",$mod_date) . "\n";

        $name_full =  $respuesta[0];
        $phone_full = $respuesta[1];
        $email_full = $respuesta[2];
        
        $table_name = $wpdb->prefix . 'inscriptions';
        
        $results = $wpdb->get_results( "SELECT * FROM $table_name WHERE email = '$email_full' ");
        
        $results =  $wpdb->num_rows;
        
        if($results <= 0){
        
        $number_coupon = $this->generate_string($this->permited_chars);

        $data = [$name_full, $phone_full, $email_full, $number_coupon];

        //Insert Data wp_option table
        $this->insert_wpdb($data);

        $send_email = new modal_suscribe();

        $this->new_cupon_user($mount, $number_coupon, $email_full );
        $send_email->send_email_new_user($name_full, $phone_full, $email_full, $number_coupon, $date_expire);
        $send_email->send_email_admin($name_full, $phone_full, $email_full, $number_coupon, $date_expire);

        header("Content-type: application/json");
        echo json_encode(1) ;
        die(1);
        
        }else{
            
         header("Content-type: application/json");
        echo json_encode(0) ;
        die(0);
        
        }
            
    
    }


}
new insertNewUser();