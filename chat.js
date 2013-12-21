$(document).ready(function(){
    var lastId=get_cookie("lastId") || 0;
    $("#submitmsg").click(send_message);
    $( "#usermsg" ).keydown(function( event ) {
      if (event.keyCode == 13 ) {
          event.preventDefault();
          send_message('');
      } 
    });
    var reqInProgress = false;
    loadLog();
    function onMessage(result){
				$('#chatbox').append(result.messageCode);
				var newscrollHeight = $("#chatbox").prop('scrollHeight') - 20;
        // 		if(newscrollHeight > oldscrollHeight){
        			$("#chatbox").animate({ scrollTop: $("#chatbox").prop('scrollHeight') }, 'normal'); //Autoscroll to bottom of div
        // 		}
        		lastId=get_cookie("lastId");
    }
    function loadLog(){	
		var oldscrollHeight =  $("#chatbox").prop('scrollHeight') - 20;
		if(!reqInProgress){
		    $.ajax(
		    {
    		    url:'get.php',
    		    cache: false,
    		    type:'POST',
    		    data:{'last':lastId},
    		    dataType:'json'
    		}).done(function(result){
    		    onMessage(result);
    		    setTimeout(loadLog, 2000);
    		}); // конец ajax	
		} else {
		    setTimeout(loadLog, 2000);
		}
	}
	
	function get_cookie (cookie_name)
    {
        var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
        if ( results )
            return ( unescape ( results[2] ) );
        else
            return null;
    };
	function send_message(text){
	    var clientmsg = $("#usermsg").val();
	    //set_cookie('user','');
	    if(text!=''){
	        clientmsg=text;
	    }
	    var clientmsg = $("#usermsg").val();
	    if(clientmsg != ''){
	        if(!reqInProgress){
    	        reqInProgress = true;
    		    $.ajax({
    		        url: "post.php", 
    		        type: 'POST',
    		        data: {text: clientmsg, last: lastId }, 
    		        dataType: 'json'
    		    }).done(function(result){
    		        $("#usermsg").val("");
    		        onMessage(result);
    		        reqInProgress = false;
    		    });	
	        }
	    }
	};
	
	function set_cookie(name, value, options)
    {
        options = options || {};

  var expires = options.expires;

  if (typeof expires == "number" && expires) {
    var d = new Date();
    d.setTime(d.getTime() + expires*1000);
    expires = options.expires = d;
  }
  if (expires && expires.toUTCString) { 
  	options.expires = expires.toUTCString();
  }

  value = encodeURIComponent(value);

  var updatedCookie = name + "=" + value;

  for(var propName in options) {
    updatedCookie += "; " + propName;
    var propValue = options[propName];    
    if (propValue !== true) { 
      updatedCookie += "=" + propValue;
     }
  }

  document.cookie = updatedCookie;
    };
   
});