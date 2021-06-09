/* 
Created by: Kenrick Beckett

Name: Chat Engine
*/
var EventID = 0;
var instanse = false;
var state;
var mes;
var file = date+'.txt';
var url = "class/chat.php";

function Chat() {
    this.update = updateChat;
    this.send = sendChat;
	this.getState = getStateOfChat;
}

//gets the state of the chat
function getStateOfChat(){
    
	if(!instanse){
		 instanse = true;
        
		 $.ajax({
			   type: "POST",
			   url: url,
			   data: {function:'getState',file:file},
			   dataType: "json",	
			   success: function(data){
				   state = data.state;
				   instanse = false;
			   },
			});
	}	 
    
}

//Updates the chat
function updateChat(){
	 if(!instanse){
		 instanse = true;
	     $.ajax({
			   type: "POST",
			   url: url,
			   data: {  
			   			'function': 'update',
						'state': state,
						'file': file
						},
			   dataType: "json",
			   success: function(data){
				   if(data.text){
						for (var i = 0; i < data.text.length; i++) {
                            $('#chat-area').append($(data.text[i]));
                        }								  
				   }
				   //document.getElementById('chat-area').scrollTop = document.getElementById('chat-area').scrollHeight;
				   instanse = false;
				   state = data.state;
			   },
			});
	 }
	 else {
		 setTimeout(updateChat, 1500);
	 }
}


//send the message
function sendChat(message, nickname)
{       
    updateChat();
     $.ajax({
		   type: "POST",
		   url: url,
		   data: {  
		   			'function': 'send',
					'message': message,
					'nickname': nickname,
					'file': file
				 },
		   dataType: "json",
		   success: function(data){
			   updateChat();
		   },
		});
}