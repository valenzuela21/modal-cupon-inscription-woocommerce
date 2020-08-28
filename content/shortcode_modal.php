<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class shortcodeModalSubscribe{

 function __construct()
 {
     add_action('wp_head', array($this,'shortcodeView'));
     add_action('wp_enqueue_scripts', array($this, 'js_css_frontend'));
 }

 public function js_css_frontend(){
    
     wp_enqueue_style('css_js_frontend_modal_subscribe_1', plugins_url('../assets/css/style_frond.css', __FILE__) );
     wp_enqueue_script('jquery_validate_form','https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js', array('jquery'), 1.0, true );
     
      if(is_front_page()): 
     wp_enqueue_script('css_js_frontend_modal_subcribe_2', plugins_url('../assets/js/script_frondtend.js', __FILE__), array('jquery'), 1.0, true );
     wp_localize_script( 'css_js_frontend_modal_subcribe_2', 'admin_url', array(
         'ajax_url' => admin_url('admin-ajax.php')
     ) );
      endif;
    
 }

 public function shortcodeView(){

     $xbox = Xbox::get( 'config-suscribe' );
     $logo_url = $xbox->get_field_value( '_natur_logo_modal' );
     $css = $xbox->get_field_value( '_natur_custom_css' );
     $slogan = $xbox->get_field_value( '_natur_slogan' );
     $natur_font_size = $xbox->get_field_value( '_natur_font_size' );
     $natur_text_butom = $xbox->get_field_value( '_natur_text_butom' );
     $natur_description = $xbox->get_field_value( '_natur_description' );
     $natur_background_buttom = $xbox->get_field_value( '_natur_background_button' );
     $natur_text_color = $xbox->get_field_value( '_natur_text_color' );
     $natur_background_color = $xbox->get_field_value( '_natur_background_color');
     $natur_background_content = $xbox->get_field_value( '_natur_background_content');
     $natur_opacity = $xbox->get_field_value( '_natur_opacity');

     if(!empty($logo_url)){
         $image_logo = '<img src="'.$logo_url.'" alt="image_logo" class="logo_modal_input" />';
     }else{
         $image_logo = '';
     }

     echo '
        <style>
        '.$css.'
        </style>
    <div class="modal">
    <div class="modal-shadow" style="background-color: '.$natur_background_color.'; opacity: '.$natur_opacity.' ">
    </div>
    <div class="modal-content" style="background-color: '.$natur_background_content.'"">
        <div class="close-modal"></div>
        <div id="section_form">
        '.$image_logo.'
        <h2 class="texto-title" style="font-size:'.$natur_font_size.'px; color: '.$natur_text_color.'">'.__($slogan, 'subscribe-user-natural').'</h2>
        <div class="container_modal">
        <p class="text-parrafo"   >'.__($natur_description, 'subscribe-user-natural').'</p>
        </div>
        <form class="form-subscribe" id="form-subscribe" >
            <input type="text" id="name_full" name="name_full" class="input-form" placeholder="'.__('Name', 'subscribe-user-natural').'" />
            <input type="tel" id="phone_full" name="phone_full" class="input-form" placeholder="'.__('Telephone','subscribe-user-natural').'" />
            <input type="email" id="email_full" name="email_full" class="input-form" placeholder="'.__('Email', 'subscribe-user-natural').'" />
            <input type="submit" class="submit-form" style="background:'.$natur_background_buttom.'" value="'.__($natur_text_butom, 'subscribe-user-natural').'" />
        </form>
        </div>
        <div id="alert_form_success"></div>
    </div>
</div>';

 }

}
new shortcodeModalSubscribe();
