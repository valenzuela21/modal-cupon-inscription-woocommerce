
(function($){
    
setTimeout(function(){  $(".modal").show(); }, 9000);

$(".close-modal").on('click', function(){
    $(".modal").hide();
});

$("#form-subscribe").validate({
    errorClass: "error_input_modal",
    errorElement: "div",

    rules:{
        name_full: "required",
        email_full:{
            required: true,
            email: true,
        },
        check:{
            required: true,
        }
    },

    messages:{
        name_full: "The field is empty enter the full name.",
        email_full:{
            required: "The field is empty enter email.",
            email: "The mail field is invalid."
        },
        check:{
            required: "Please accept the terms and conditions.",
        }
    },

    submitHandler: function(form) {

        let name_full = $("#name_full").val();
        let phone_full = $("#phone_full").val();
        let email_full = $("#email_full").val();

        let respuesta = [name_full, phone_full, email_full];

        let datos = {
            action: 'wp_new_subscribe_user',
            respuesta: respuesta
        }

        $.ajax({
            url: admin_url.ajax_url,
            type: 'post',
            data: datos
        }).done(function(respuesta) {
            //console.log(respuesta);
            if(respuesta == 1){
            $("#alert_form_success").html("<div class='alert_success_fully'>" +
                "<h2 class='titel_product'>The data has been registered correctly</h2>" +
                "<p>Verify the membership coupon in the email</p>"+
                "</div>");
            $("#section_form").hide();
            }else{
                $("#alert_form_success").html("<div class='alert_success_fully'>" +
                "<h2 class='titel_product'>Sorry, you couldn't create the coupon.</h2>" +
             "<p>We are sorry this user has already registered.</p>"+
                "</div>");
                $("#section_form").hide();
            }
        });
        return false;
    }
});
})(jQuery);