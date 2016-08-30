var flag = false;
var state;
var file;

function text_msg() {
	this.update = refresh_msg;
	this.send = send_msg;
	this.getState = msg_state;
}
function msg_state() {
	if (!flag) {
		flag = true;
		$.ajax({
			type : "POST",
			url : "process_chat.php",
			data : {
				'function' : 'getState',
				'file' : file
			},
			dataType : "json",

			success : function(data) {
				state = data.state;
				flag = false;
			},
		});
	}
}

function refresh_msg() {
	if (!flag) {
		flag = true;
		$.ajax({
			type : "POST",
			url : "process_chat.php",
			data : {
				'function' : 'update',
				'state' : state,
				'file' : file
			},
			dataType : "json",
			success : function(data) {
				if (data.text) {
					for (var i = 0; i < data.text.length; i++) {
						$('#chat-area')
								.append($("<p>" + data.text[i] + "</p>"));
					}
				}
				document.getElementById('chat-area').scrollTop = document
						.getElementById('chat-area').scrollHeight;
				flag = false;
				state = data.state;
			},
		});
	} else {
		setTimeout(refresh_msg, 1500);
	}
}

function send_msg(message, nickname) {
	refresh_msg();
	$.ajax({
		type : "POST",
		url : "process_chat.php",
		data : {
			'function' : 'send',
			'message' : message,
			'nickname' : nickname,
			'file' : file
		},
		dataType : "json",
		success : function(data) {
			refresh_msg();
		},
	});
}
