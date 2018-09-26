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
            BX.showWait();
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
            }).always(function(){
                BX.closeWait();
            });
            return false;
        }

    });
    $('input[name="FA_PHONE"]').mask("(999) 99-99-999");
});

var lastWait = [];
/* non-xhr loadings */
BX.showWait = function (node, msg)
{
    node = BX(node) || document.body || document.documentElement;
    msg = msg || BX.message('JS_CORE_LOADING');

    var container_id = node.id || Math.random();

    var obMsg = node.bxmsg = document.body.appendChild(BX.create('DIV', {
        props: {
            id: 'wait_' + container_id,
            className: 'bx-core-waitwindow'
        },
        text: msg
    }));

    setTimeout(BX.delegate(_adjustWait, node), 10);

    $('#win8_wrapper').show();
    lastWait[lastWait.length] = obMsg;
    return obMsg;
};

BX.closeWait = function (node, obMsg)
{
    $('#win8_wrapper').hide();
    if (node && !obMsg)
        obMsg = node.bxmsg;
    if (node && !obMsg && BX.hasClass(node, 'bx-core-waitwindow'))
        obMsg = node;
    if (node && !obMsg)
        obMsg = BX('wait_' + node.id);
    if (!obMsg)
        obMsg = lastWait.pop();

    if (obMsg && obMsg.parentNode)
    {
        for (var i = 0, len = lastWait.length; i < len; i++)
        {
            if (obMsg == lastWait[i])
            {
                lastWait = BX.util.deleteFromArray(lastWait, i);
                break;
            }
        }

        obMsg.parentNode.removeChild(obMsg);
        if (node)
            node.bxmsg = null;
        BX.cleanNode(obMsg, true);
    }
};

function _adjustWait()
{
    if (!this.bxmsg)
        return;

    var arContainerPos = BX.pos(this),
        div_top = arContainerPos.top;

    if (div_top < BX.GetDocElement().scrollTop)
        div_top = BX.GetDocElement().scrollTop + 5;

    this.bxmsg.style.top = (div_top + 5) + 'px';

    if (this == BX.GetDocElement())
    {
        this.bxmsg.style.right = '5px';
    }
    else
    {
        this.bxmsg.style.left = (arContainerPos.right - this.bxmsg.offsetWidth - 5) + 'px';
    }
}