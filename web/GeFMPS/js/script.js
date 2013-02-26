// JavaScript Document

$(document).ready(function(){
$("a.tab").click(function () {
			
			
			// switch all tabs off
			$(".active").removeClass("active");
			
			// switch this tab on
			$(this).addClass("active");
			
			// slide all content up
			$(".content").hide();
			
			// slide this content up
			var content_show = $(this).attr("title");
			$("#"+content_show).show();
		});
		
		var i = 0;
$("#nouveau").live("click",function(){
	i += 1;
	$(this).hide();
	var text='<div id="box'+i+'" class="box modifi">';
	text+='<div class="head"><span>Ongle'+i+'</span></div>';
	text+='<div class="body"></div></div>';
	text+='<div id="nouveau" class="box"><a><img src="img/nouveau.png" width="462" height="228" /></a></div>';
	$('#Visu').append(text);
	
});

});



