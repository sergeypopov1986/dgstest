function _adjustWait(){if(this.bxmsg){var t=BX.pos(this),a=t.top;a<BX.GetDocElement().scrollTop&&(a=BX.GetDocElement().scrollTop+5),this.bxmsg.style.top=a+5+"px",this==BX.GetDocElement()?this.bxmsg.style.right="5px":this.bxmsg.style.left=t.right-this.bxmsg.offsetWidth-5+"px"}}var lastWait=[];BX.showWait=function(t,a){t=BX(t)||document.body||document.documentElement,a=a||BX.message("JS_CORE_LOADING");var e=t.id||Math.random(),i=t.bxmsg=document.body.appendChild(BX.create("DIV",{props:{id:"wait_"+e,className:"bx-core-waitwindow"},text:a}));return setTimeout(BX.delegate(_adjustWait,t),10),$("#win8_wrapper").show(),lastWait[lastWait.length]=i,i},BX.closeWait=function(t,a){if($("#win8_wrapper").hide(),t&&!a&&(a=t.bxmsg),t&&!a&&BX.hasClass(t,"bx-core-waitwindow")&&(a=t),t&&!a&&(a=BX("wait_"+t.id)),a||(a=lastWait.pop()),a&&a.parentNode){for(var e=0,i=lastWait.length;e<i;e++)if(a==lastWait[e]){lastWait=BX.util.deleteFromArray(lastWait,e);break}a.parentNode.removeChild(a),t&&(t.bxmsg=null),BX.cleanNode(a,!0)}},$(function(){$("#show-more-btn").on("click",function(){var t=$(this).data("next-page");t&&(BX.showWait(),$.ajax({url:t,type:"get",dataType:"html"}).done(function(a){$(".ajax-news-list").append($(a).find(".ajax-news-list").html());var e=$(a).find("#show-more-btn").data("next-page");$("#show-more-btn").data("next-page",e),$(".navigation-pages").html($(a).find(".navigation-pages").html()),history.pushState(null,null,t)}).always(function(){BX.closeWait()}))})});