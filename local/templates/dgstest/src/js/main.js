var isLoading = false;

function is_visible(target) {

    var scrollTop = $(window).scrollTop();
    var windowHeight = $(window).height();
    var currentEl = $(target);
    var offset = currentEl.offset();
    return (scrollTop + windowHeight) >= (currentEl.height() + offset.top);
}

function loadingNextPage(nextPageUrl , clearContainer){
    $(".frame-preloader").show();
    $('#show-more-btn').text('Загружаем...');
    $.ajax({
        url: nextPageUrl,
        type: 'get',
        dataType: 'html'
    }).done(function(responce){
        var content = $(responce).find('.ajax-news-list').html();
        if(clearContainer){
            $('.ajax-news-list').html(content);
        }else{
            $('.ajax-news-list').append(content);
        }
        var nextPage = $(responce).find('#show-more-btn').data('next-page');
        $('#show-more-btn').data('next-page' , nextPage);
        $('.navigation-pages').html($(responce).find('.navigation-pages').html());
        history.pushState(null , null , nextPageUrl);
        $('#show-more-btn').text('Показать еще');
    }).always(function(){
        $(".frame-preloader").hide();
        isLoading = false;
    });
}

$(function(){
    $('#show-more-btn').on('click' , function(){
        var nextPageUrl = $(this).data('next-page');
        if(nextPageUrl){
            loadingNextPage(nextPageUrl);
        }
    });
    $('.navigation-pages').on('click' , 'a' , function(e){
        e.preventDefault();
        var href = $(this).attr('href');
        if(!isLoading && href){
            $('.ajax-news-list').html();
            loadingNextPage(href , true);
        }
    });
    $(document).on('scroll' , function(){
        var nextPageUrl = $('#show-more-btn').data('next-page');
        if(is_visible('.news-list') && nextPageUrl && !isLoading){
            isLoading = true;
            loadingNextPage(nextPageUrl);
        }
    });
});