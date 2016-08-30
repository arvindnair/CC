<html>
<head>
<title>Chat</title>

<link rel="stylesheet" href="./css/style.css" type="text/css" />
<link rel="stylesheet" href="./css/bootstrap.css" media="screen">
<script type="text/javascript"
	src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script type="text/javascript" src="./js/chat.js"></script>
<script type="text/javascript">
        var id = prompt("Enter your chat name:", "Anon");
   
    	if (!id || id === ' ') {
    	   id = "Anon";	
    	}
    	$("#id-area").html("You are: <span>" + id + "</span>");
    	var new_msg =  new text_msg();
    	$(function() {
    	
    		new_msg.getState(); 
    	     $("#chatter").keydown(function(event) {  
                 var key = event.which;  
        
                 if (key >= 33) {
                   
                     var size = $(this).attr("maxlength");  
                     var lsize = this.value.length;  
                     
        
                     if (lsize >= size) {  
                         event.preventDefault();  
                     }  
                  }  
    		 																																																});
    	
    		 $('#chatter').keyup(function(e) {	
    	 					 
    			  if (e.keyCode == 13) { 
    			  
                    var text = $(this).val();
    				var size = $(this).attr("maxlength");  
                    var lsize = text.length; 
                     
         
                    if (lsize <= size + 1) { 
                     
                    	new_msg.send(text, id);	
    			        $(this).val("");
    			        
                    } else {
                    
    					$(this).val(text.substring(0, size));
    					
    				}	
    				
    				
    			  }
             });
            
    	});
    </script>
</head>
<body onload="setInterval('new_msg.update()', 500)">
	<div id="page-wrap">
		<p id="id-area"></p>
		<div id="chat-wrap">
			<div id="chat-area"></div>
		</div>
		<form id="send-message-area">
			<p>Your message:</p>
			<textarea id="chatter" maxlength='140'></textarea>
			</br> </br> </br> <font color="white">(press enter to send message)</font>
		</form>
	</div>
	</br>
	</br>
	</br>
	</br>
	</br>
	<form action="index.php">
		<span class='glyphicon glyphicon-home pull-left'
			style='color: #c09853;'> <input type="submit"
			class="btn btn-warning btn-md" value="Back to Home">
	
	</form>
	</span>
</body>
</html>