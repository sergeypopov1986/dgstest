$(function(){
    $('#fa-custom-ajax-form').validate({
        rules: {
            FA_PHONE : {
                required: true
            }
        },
        messages: {
            FA_PHONE : {
                required: "Обязательно для заполнения"
            }
        },
        submitHandler: function(form) {
            var data = $(form).serialize();
            return false;
        }

    });
    $('input[name="FA_PHONE"]').mask("(999) 99-99-999");
});