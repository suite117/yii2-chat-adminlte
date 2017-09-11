function reloadchat(message, clearChat) {
    var url = $(".btn-send-comment").data("url");
    var model = $(".btn-send-comment").data("model");
    var userfield = $(".btn-send-comment").data("userfield");
    var theme = $(".btn-send-comment").data("theme");
    $.ajax({
        url: url,
        type: "POST",
        data: {message: message, model: model, userfield: userfield, theme : theme},
        success: function (html) {
            if (clearChat == true) {
                $("#chat_message").val("");
            }
            
            //$('#div1').scrollTop($('#div1')[0].scrollHeight);
            $cb = $("#chat-box");
            $cb.html(html).animate({ scrollTop: $cb[0].scrollHeight}, 1000);
        }
    });
}
setInterval(function () {
    reloadchat('', false);
}, 2000);

$(".btn-send-comment").on("click", function () {
    var message = $("#chat_message").val();
    reloadchat(message, true);
});


// Agggiornamento premendo invio
$("#chat_message").keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
	  {
		$(".btn-send-comment").click();
	    return false;  
	  }
	});   