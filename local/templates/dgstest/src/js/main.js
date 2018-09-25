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
            $.ajax({
                url: window.location.pathname,
                type: 'post',
                dataType: 'json',
                data: data
            }).success(function(responce){
                if(typeof responce.SUCCESS !== 'undefined'){
                    $('#exampleModal p').text(responce.SUCCESS);
                    $('#exampleModal').arcticmodal({
                        afterClose: function(){
                            $(form).find('input[type="text"]').each(function(i,el){
                                $(el).val('');
                            });
                        }
                    });
                }else if(typeof responce.ERRORS !== 'undefined'){
                    if(responce.ERRORS.SESSID){
                        $('#exampleModal p').html(responce.ERRORS.SESSID);
                        $('#exampleModal').arcticmodal({
                            afterClose: function(){
                                $(form).find('input[type="text"]').each(function(i,el){
                                    $(el).val('');
                                });
                            }
                        });
                    }
                }
            });
            return false;
        }

    });
    $('input[name="FA_PHONE"]').mask("(999) 99-99-999");
});