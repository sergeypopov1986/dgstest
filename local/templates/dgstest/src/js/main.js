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

$(function(){
    $('#show-more-btn').on('click' , function(){
        var nextPageUrl = $(this).data('next-page');
        if(nextPageUrl){
            BX.showWait();
            $.ajax({
                url: nextPageUrl,
                type: 'get',
                dataType: 'html'
            }).done(function(responce){
                $('.ajax-news-list').append($(responce).find('.ajax-news-list').html());
                var nextPageHref = $(responce).find('#show-more-btn').attr('data-next-page');
                console.log(nextPageHref);
                $('#show-more-btn').attr('data-next-page' , nextPageHref);
                $('.navigation-pages').html($(responce).find('.navigation-pages').html());
            }).always(function(){
                BX.closeWait();
            });
        }
    });
});