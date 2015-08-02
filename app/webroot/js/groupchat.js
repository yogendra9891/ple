/**
 * Method to inviteUser
 * 
 * @param user
 * @param groupName
 * @return
 */
var roomArray = "global";
var roomArray = [];
var i = 0;
var maxChatWnd = 4;
var updatedGbValue = 0;
var newPendGbValue = 0;
var newReqGbValue = 0;
var newNotfGbValue = 0;
var newMeetGbValue = 0;
var isOpenChat = 0;
var roomsusers;
var t = 0;
// site_url and site_url1 variable defined in the layout file
function inviteFriends(user) {

	// get roomName
	var roomName = "daff" + Math.floor(new Date().getTime() / 1000);
	// get checked user name
	var friends_name = $("input[name='friends[]']:checked");
	var values = new Array();
	$.each(friends_name, function() {
		values.push($(this).val());
	});

	if (values == "") {
		alert("Pls select users");
		return false;
	}

	return false;
	// add the chat area
	var url = site_url1 + "chats/groupChat/" + user + "/" + values + "/" + roomName;
	var html = '<div style="float:left;margin-right: 11px;"><div class="chatarea" id="chatwindow' + roomName + '" style="float:left;"><iframe src="' + url + '" width="200" height="370" scrolling="no"></iframe></div><div class="chatwindowMax" id="chatwindowMax' + roomName + '" style="display:none;">Max</div></div>';
	$('#chatarea').append(html);
	return true;
}
/**
 * Method to accept the invitation
 * 
 * @param user
 * @param room
 * @return
 */

function acceptInvitaion(id, roomname) {
	if (isOpenChat == 0) {
	$('.right-area').show();
	var current_div = $('#chatarea').children('.chatarea-inner:visible').length;

	/*
	 * if(current_div < 4){ var width = $('#chatarea').width(); var newwidth =
	 * width+215; $('#chatarea').css('width',newwidth+'px');}
	 */
	var t1 = $('#chatarea').children('.chatarea-inner:visible').length;
	if (t1 < 4) {
		var r1 = t1 + 1;
		var newwidth1 = (r1 * 215);
	}
	if (t1 == 0) {
		newwidth1 = 215;
	}
	$('#chatarea').css('min-width', newwidth1 + 'px');
	$('.right-area').css('min-width', newwidth1 + 'px');
	if (current_div == 1 || current_div > 1) {
		$('#chatarea').children('.chatarea-inner').removeClass('one-inner');
		$('#chatarea').removeClass('chatarea-wrapper-main');
	}
	// //add the chat area
	$('#li_' + roomname).remove();
	var chatwindowCount = $("#chatarea div:visible").length;
	roomArray.push(roomname);
	var roomLength = roomArray.length;
	if (current_div >= maxChatWnd) {
		
		var browser = check_browser();
		//code for pause
		if ($('#iframe_' + roomArray[i]).length > 0) {
			if ( browser == 'mozilla' ) {
				//below line for firefox
				window.frames['iframe_' + roomArray[i]].contentWindow.pause();
			} else {
				//other browsers
				window.frames['iframe_' + roomArray[i]].pause();
			}
			//code for pause
		}
		//code for resume
		if ($('#iframe_' + roomname).length > 0) {
			if ( browser == 'mozilla' ) {
				//below line for firefox
				window.frames['iframe_' + roomname].contentWindow.resume();
			} else {
				//other browsers
				window.frames['iframe_' + roomname].resume();
			}
			//code for resume
		}
		$('#par_' + roomArray[i]).hide();
		if (roomArray[i] != undefined) {
			var convertj = convertTimeToDate(roomArray[i]);
			$('#active_chats ul').append("<li class='prq' id='li_" + roomArray[i] + "' style='cursor:pointer;' ><span>" + convertj + "&nbsp;&nbsp;&nbsp;&nbsp;<input type='image' onclick=reOpenChat('" + roomArray[i] + "') src='" + site_url1 + "img/gpchat.png'></span></li>");
		}
		i = i + 1;

	}

	var url = site_url1 + "/chats/groupFriendsChat/" + id;
	var html = '<div id="par_' + roomname + '" style="float:left;margin-right: 11px;" class="chatarea-inner"><div class="chatarea" id="chatwindow' + roomname + '" style="float:left;"><iframe id="iframe_' + roomname + '" src="' + url + '" width="200" height="340" scrolling="no" frameBorder="0"></iframe></div><div class="chatwindowMax" id="chatwindowMax' + roomname + '" style="display:none;">Max</div></div>';
	$('#chatarea').append(html);
	var current_div1 = $('#chatarea').children('.chatarea-inner:visible').length;
	if (current_div1 == 1) {
		$('#chatarea').children('.chatarea-inner').addClass('one-inner');
		$('#chatarea').addClass('chatarea-wrapper-main');
	}
	$('#rd' + id).hide();
	isOpenChat = 1; //set the global vairiable to 0 for further chat window open.
}
}

/**
 * Method to show user chat window when he click on the my active chat button
 * 
 * @param id
 * @return
 */
function myActiveChats(id, roomname) {
	$('.right-area').show();
	var current_div = $('#chatarea').children('.chatarea-inner:visible').length;
	/*
	 * if(current_div < 4){ var width = $('#chatarea').width(); var newwidth =
	 * width+215; $('#chatarea').css('width',newwidth+'px');}
	 */
	var t = $('#chatarea').children('.chatarea-inner:visible').length;
	if (t < 4) {
		var r = t + 1;
		var newwidth = (r * 215);
	}
	if (t == 0) {
		newwidth = 215;
	}
	$('#chatarea').css('min-width', newwidth + 'px');
	$('.right-area').css('min-width', newwidth + 'px');
	if (current_div == 1 || current_div > 1) {
		$('#chatarea').children('.chatarea-inner').removeClass('one-inner');
		$('#chatarea').removeClass('chatarea-wrapper-main');
	}
	$('#li_' + roomname).remove();
	var chatwindowCount = $("#chatarea div:visible").length;

	roomArray.push(roomname);
	var roomLength = roomArray.length;

	if (current_div >= maxChatWnd) {
		var browser = check_browser();
		//code for pause
		if ($('#iframe_' + roomArray[i]).length > 0) {
			if ( browser == 'mozilla' ) {
				//below line for firefox
				window.frames['iframe_' + roomArray[i]].contentWindow.pause();
			} else {
				//other browsers
				window.frames['iframe_' + roomArray[i]].pause();
			}
			//code for pause
		}
		//code for resume
		if ($('#iframe_' + roomname).length > 0) {
			if ( browser == 'mozilla' ) {
				//below line for firefox
				window.frames['iframe_' + roomname].contentWindow.resume();
			} else {
				//other browsers
				window.frames['iframe_' + roomname].resume();
			}
		}
		//code for resume
		$('#par_' + roomArray[i]).hide();

		if (roomArray[i] != undefined) {
			var convertj = convertTimeToDate(roomArray[i]);
			$('#active_chats ul').append("<li class='prq' id='li_" + roomArray[i] + "' style='cursor:pointer;' ><span>" + convertj + "&nbsp;&nbsp;&nbsp;&nbsp;<input type='image' onclick=reOpenChat('" + roomArray[i] + "') src='" + site_url1 + "/img/gpchat.png'></span></li>");
		}
		i = i + 1;

	}

	var url = site_url1 + "chats/myActiveChats/" + id;
	var html = '<div id="par_' + roomname + '" style="float:left;margin-right: 11px;" class="chatarea-inner"><div class="chatarea" id="chatwindow' + roomname + '" style="float:left;"> <iframe id="iframe_' + roomname + '" src="' + url + '" width="200" height="340" scrolling="no" frameBorder="0"></iframe></div><div class="chatwindowMax" id="chatwindowMax' + roomname + '" style="display:none;">Max</div></div>';
	$('#chatarea').append(html);
	var current_div1 = $('#chatarea').children('.chatarea-inner:visible').length;
	if (current_div1 == 1) {
		$('#chatarea').children('.chatarea-inner').addClass('one-inner');
		$('#chatarea').addClass('chatarea-wrapper-main');
	}
	$('#act' + id).hide();
}

/**
 * Method to open chat window when the chat window crosses the limit of 3
 */
function reOpenChat(roomName) {
	$('.right-area').show();
	var chatwindowCount = $("#chatarea div:visible").length;
	var current_div = $('#chatarea').children('.chatarea-inner:visible').length;
	var t = $('#chatarea').children('.chatarea-inner:visible').length;
	if (t < 4) {
		var r = t + 1;
		var newwidth = (r * 215);
	}
	if (t == 0) {
		newwidth = 215;
	}
	$('#chatarea').css('min-width', newwidth + 'px');
	$('.right-area').css('min-width', newwidth + 'px');
	if (current_div == 1 || current_div > 1) {
		$('#chatarea').children('.chatarea-inner').removeClass('one-inner');
		$('#chatarea').removeClass('chatarea-wrapper-main');
	}
	
	roomArray.push(roomName);
	var roomLength = roomArray.length;
	if (current_div >= maxChatWnd) {
		
		if(current_div >= maxChatWnd){
			var browser = check_browser();
			//code for pause
			if ($('#iframe_' + roomArray[i]).length > 0) {
				if ( browser== 'mozilla' ) {
					//below line for firefox
					window.frames['iframe_' + roomArray[i]].contentWindow.pause();
				} else {
					//other browsers
					window.frames['iframe_' + roomArray[i]].pause();
				}
			}
			//code end for pause
			//code for resume
			if ($('#iframe_' + roomName).length > 0) {
				if ( browser == 'mozilla' ) {
					//below line for firefox
					window.frames['iframe_' + roomName].contentWindow.resume();
				} else {
					//other browsers
					window.frames['iframe_' + roomName].resume();
				}
			}
			//code for resume
		$('#par_' + roomArray[i]).hide();
		}
		//$('#par_' + roomName).hide();
		
		if (roomArray[i] != undefined) {
			var convertj = convertTimeToDate(roomArray[i]);
			$('#active_chats ul').append("<li class='prq' id='li_" + roomArray[i] + "' style='cursor:pointer;' ><span>" + convertj + "&nbsp;&nbsp;&nbsp;&nbsp;<input type='image' onclick=reOpenChat('" + roomArray[i] + "') src='" + site_url1 + "/img/gpchat.png'></span></li>");
		}
		i = i + 1;
	}
	$('#li_' + roomName).remove();
	$('#par_' + roomName).show();
}

/**
 * Method to get pending requests using ajax
 * 
 * @return
 */
function getPendingRequests() {
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/getPendingRequests",
		data : {}
	}).done(function(msg) {
		// set the msg in ul
		$('#pending_request').html(msg);
	});
}

/**
 * Method to get pending requests count
 * 
 * @return
 */
function getPendingRequestsCount() {
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/getPendingRequestsCount",
		data : {}
	}).done(function(msg) {
		var t = JSON.parse(msg);
		var msgCount = t['count'];
		var isAlert = t['showAlert'];
		if (msgCount == "0") {
			$('#pending_request_count').hide();
		} else {

			$('#pending_request_count').show();
			$('#pending_request_count').html(msgCount);

		}
		// get global value
		// var gbValue = $('#hiddenGlobal').val();
		newPendGbValue = parseInt(msgCount);
		updatedGbValue = newPendGbValue + newReqGbValue + newNotfGbValue + newMeetGbValue;
		if (updatedGbValue != 0) {
			$('#globalNotify').show();
			$('#globalNotify').html(updatedGbValue);
		} else
			$('#globalNotify').hide();
		if (isAlert == 1) {
			$.msgBox({
				title : "Notification",
				content : 'New chat request.'
			});
		}
	});
}

/**
 * @param request
 *            id Method to reject the invitaion by friends
 * @return
 */
function rejectInvitaion(id) {
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/rejectInvitaion",
		data : {
			id : id
		}
	}).done(function(msg) {
		// hide the div
		$('#rd' + id).hide();
	});
}

/**
 * Method to leave user from chatroom
 * 
 * @param roomName
 * @return
 */
function leaveRoom(roomName) {
	$('#chatwindow' + roomName, window.parent.document).hide();
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/leaveRoom",
		data : {
			roomName : roomName
		}
	}).done(function(msg) {
		// hide the div
		if (msg == "true") {
			$('#chatwindow' + roomName, window.parent.document).hide();
		}
	});
	var t = $('#chatarea').children('.chatarea-inner:visible').length;
	if (t < 5) {
		var r = t - 1;
		var newwidth = (r * 215);
	}

	// $('#chatarea').css('min-width',newwidth+'px');
	$('#chatarea', window.parent.document).css('min-width', newwidth + 'px');
	$('.right-area', window.parent.document).css('min-width', newwidth + 'px');
	// end
	// $('#chatwindow'+roomName, window.parent.document).hide();
	$('#li_' + roomName, window.parent.document).remove();
	$('#par_' + roomName, window.parent.document).hide();
	var current_div2 = $('#chatarea', window.parent.document).children('.chatarea-inner:visible').length;
	if (current_div2 == 1) {
		$('#chatarea', window.parent.document).children('.chatarea-inner').addClass('one-inner');
		$('#chatarea', window.parent.document).addClass('chatarea-wrapper-main');
	} 
	if (current_div2 == 0) {
		$('.right-area', window.parent.document).hide();
	}
	// $('#par_'+roomName, window.parent.document).remove();
	var index = parent.roomArray.indexOf(roomName);

	if (index > -1) {
		parent.roomArray.splice(index, 1);
	}

	$('#joinmetting_' + roomName, window.parent.document).show(); // showing
	// the chat
	// join
	// button.
	top.isOpenChat = 0;//set the global variable to 0 by which a user can open chat window.

}

/**
 * Method to show the users to be invited for chat
 * 
 * @return
 */
function showNewUsers(roomName) {
	$('#roster-area-group').show();
	$('#chat-area').hide();
	$('#participants').hide();
}

/**
 * Method to show online users for group
 * 
 * @return
 */
function showJoinedUsers() {
	$('#participants').show();
	$('#chat-area').hide();
	$('#roster-area-group').hide();

}

/**
 * 
 * @param chat_room
 * @return
 */
function showChat() {
	$('#chat-area').show();
	$('#roster-area-group').hide();
	$('#participants').hide();
}

/**
 * Method for sending the request to join an group chat
 * 
 * @param roomName
 * @return
 */
function requestForJoin(roomName) {
	// call ajax request
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/requestForJoin",
		data : {
			roomName : roomName
		}
	}).done(function(msg) {
		// check for response
		if (msg == "success") {
			$.msgBox({
				title : "Alert",
				content : "Request Sent Successfully."
			});
			return false;
			// $('#room_'+roomName).hide();
		}
		if (msg == "no_gp_found") {
			$.msgBox({
				title : "Alert",
				content : "This Group not exist now. Please wait to get update."
			});
			return false;
			// alert('This Group not exist now. Please wait to
			// get update.');
		} else if (msg == "already_sent") {
			$.msgBox({
				title : "Alert",
				content : "Already Sent."
			});
			return false;
			// alert('Already Sent');
		}

	});
}

/**
 * Method to get pending chat requests
 * 
 * @return
 */
function getPendingChatRequests() {
	// call ajax request
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/pendingRequests",
		data : {}
	}).done(function(msg) {
		// check for response
		$('#chat_requests').html(msg);
	});
}

function getPendingChatRequestsCount() {

	// call ajax request
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/pendingRequestsCount",
		data : {}
	}).done(function(msg) {
		var t = JSON.parse(msg);
		var msgCount = t['count'];
		var isAlert = t['showAlert'];
		newReqGbValue = parseInt(msgCount);
		// show global notification
		updatedGbValue = newPendGbValue + newReqGbValue + newNotfGbValue + newMeetGbValue;
		if (updatedGbValue != 0) {
			$('#globalNotify').show();
			$('#globalNotify').html(updatedGbValue);
		} else
			$('#globalNotify').hide();

		if (msgCount == "0") {
			$('#chat_requests_count').hide();
		} else {
			$('#chat_requests_count').show();
			// set global notification value

			$('#chat_requests_count').html(newReqGbValue);
		}

		if (isAlert == 1) {
			$.msgBox({
				title : "Notification",
				content : 'New request to join the active chat.'
			});
		}

	});
}

/**
 * Method to accept the request for chat
 * 
 * @param id
 * @param roomName
 * @return
 */
function acceptRequest(id, roomName) {
	// call ajax request
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/approveChatRequests",
		data : {
			id : id
		}
	}).done(function(msg) {
		$.msgBox({
			title : "Alert",
			content : msg
		});
		$('#crd' + id).hide();
		return false;

	});
}

/**
 * Method to get list of chats for which users is not member
 * 
 * @return
 */
function getNotJoinedActiveChats() {
	// call ajax request
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/getNotJoinedActiveChats",
		data : {}
	}).done(function(msg) {
		// check for response
		$('#not_joined_activechats').html(msg);

	});
}

/**
 * Method to reject request for chat
 * 
 * @param request
 *            chat id
 * @return
 */
function rejectRequest(id) {
	// call ajax request
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/rejectChatRequests",
		data : {
			id : id
		}
	}).done(function(msg) {
		$.msgBox({
			title : "Alert",
			content : msg
		});
		$('#crd' + id).hide();
		return false;

	});
}

/**
 * Method to get courseName when the user get loggedIn
 * 
 * @return courseName
 */
function getCourseName() {
	var url = site_url1 + 'chats/getCourseName';
	var currentuser_course;
	obj1 = {};
	$.ajax({
		type : 'POST',
		url : url,
		async : false,
		data : '',
		datatype : 'json',
		success : function(res) {
			currentuser_course = res;
		}
	});
	return currentuser_course;
}

/**
 * Method to minimize the chat box
 * 
 * @param chat_room
 * @return
 */
function minmiseRoom(roomName) {
	$('#chatwindowMax' + roomName, window.parent.document).show();
	$('#chatwindow' + roomName, window.parent.document).removeClass('chatarea');
	$('#chatwindowMax' + roomName, window.parent.document).addClass('maxchat');
	var timedate = roomName.split('_');
	var cctime = new Date(parseInt(timedate[1])*1000);
    var curr_date = cctime.getDate();
    var curr_month = cctime.getMonth() + 1; //Months are zero based
    var curr_year = cctime.getFullYear();
    var curr_hour = cctime.getHours();
    var curr_minutes = cctime.getMinutes();
    var curr_seconds = cctime.getSeconds();
	var suffix = "AM";
	if (curr_hour >= 12) {
		suffix = "PM";
		curr_hour = curr_hour - 12;
	}
	if (curr_hour == 0) {
		curr_hour = 12;
	}
	var html = "<div class='mxchat'><span>" +userCourse+"-"+curr_month+"/"+ curr_date+"/"+curr_year+"/"+curr_hour+":"+curr_minutes+":"+curr_seconds+" "+suffix+"</span><span class='mxwindow'><input type='image' src='" + site_url1 + "img/max_window.png' onClick=maximiseRoom('" + roomName + "') /></span></div>"
	$('#chatwindowMax' + roomName, window.parent.document).html(html);
	$('#chatwindow' + roomName, window.parent.document).hide();

}

function maximiseRoom(roomName) {
	$('#chatwindow' + roomName).show();
	$('#chatwindow' + roomName).addClass('chatarea');
	// edit by yogendra below line
	$('#chatwindowMax' + roomName + ' .mxchat').removeClass('unread_chat');
	$('#chatwindowMax' + roomName).hide();
}
/**
 * Method to show active chats
 * 
 * @param chat_room
 * @return
 */
function showGpActiveUsers(roomName) {
	$('#ac_' + roomName).toggle();
}
/**
 * Method to get section type
 * 
 * @param
 * @return
 */
function getSectionType() {
	var url = site_url1 + 'chats/getSectionType';
	var sectionSetting;
	obj1 = {};
	$.ajax({
		type : 'POST',
		url : url,
		async : false,
		data : '',
		datatype : 'json',
		success : function(res) {
			sectionSetting = res;
		}
	});
	return sectionSetting;
}

/**
 * method for getting the notification when the receiver rejected the chat
 * request
 * 
 * @return
 */
function getDeniedChatMsg() {
	var url = site_url1 + 'chats/getDeniedChatMsg';
	$.ajax({
		type : 'POST',
		url : url,
		async : false,
		data : '',
		datatype : 'json',
		success : function(res) {
			$('#chatdeny_notification').html(res);
		}
	});
}

/**
 * method for getting the notification count when the receiver rejected the chat
 * request
 * 
 * @return
 */
function getDeniedChatMsgCount() {
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/getDeniedChatMsgCount",
		data : {}
	}).done(function(msg) {

		var t = JSON.parse(msg);
		var msgCount = t['count'];
		var isAlert = t['showAlert'];
		newNotfGbValue = msgCount;
		// show global notification
		updatedGbValue = newPendGbValue + newReqGbValue + newNotfGbValue + newMeetGbValue;
		if (updatedGbValue != 0) {
			$('#globalNotify').show();
			$('#globalNotify').html(updatedGbValue);
		} else
			$('#globalNotify').hide();

		if (msgCount == "0") {
			$('#chatdeny_notification_count').hide();
		} else {
			$('#chatdeny_notification_count').show();
			// set global notification value

			$('#chatdeny_notification_count').html(msgCount);
		}
		if (isAlert == 1) {
			$.msgBox({
				title : "Notification",
				content : 'Your request for chat has denied.'
			});
		}
	});

}

/**
 * Method for hide the notifications for chat reject
 * 
 * @param
 * @return
 */
function hideNotification(id) {
	var url = site_url1 + 'chats/hideNotification';
	$.ajax({
		type : 'POST',
		url : url,
		async : false,
		data : 'id=' + id,
		datatype : 'json',
		success : function(res) {
			if (res == "true") {
				$.msgBox({
					title : "Alert",
					content : "Notification removed!!"
				});

				$("#del_" + id).hide();
				return false;
			}
		}
	});
}

/**
 * Method to getOnline users By course name
 * 
 * @return
 */
function getSameCourseUsers(jid) {

	var url = site_url1 + 'users/getSameCourseUsers';
	var currentusers;
	$.ajax({
		type : 'POST',
		url : url,
		async : false,
		data : 'jid=' + jid,
		datatype : 'json',
		success : function(res) {
			currentusers = res;
		}
	});
	return currentusers;
}

/**
 * Method to show chat window when the user click on name
 * 
 * @param user
 *            name
 * @return
 */
function openChatWindow(friend) {
	if (isOpenChat == 0) {
	var current_div = $('#chatarea').children('.chatarea-inner:visible').length;
	// add dynamic css
	/*
	 * if(current_div < 4){ var width = $('#chatarea').width(); var newwidth =
	 * width+215;
	 */
	var t3 = $('#chatarea').children('.chatarea-inner:visible').length;
	$('.right-area').show();
	if (t3 < 4) {
		var r3 = t3 + 1;
		var newwidth = (r3 * 215);
	}
	if (t3 == 0) {
		newwidth = 215;
	}
	$('#chatarea').css('min-width', newwidth + 'px');
	$('.right-area').css('min-width', newwidth + 'px');
	if (current_div == 1 || current_div > 1) {
		$('#chatarea').children('.chatarea-inner').removeClass('one-inner');
		$('#chatarea').removeClass('chatarea-wrapper-main');
	}
	// get roomName
	var roomName = "roomid_" + Math.floor(new Date().getTime() / 1000);
	// get checked user name
	var friends_name = friend
	// add the chat area
	var chatwindowCount = $("#chatarea div:visible").length;
	roomArray.push(roomName);
	var roomLength = roomArray.length;
	
	if (current_div >= maxChatWnd) {
		//code for pause
		var e1 = $('#iframe_' + roomArray[i]);
		
		var browser = check_browser();
		if ( browser == 'mozilla' ) {
			//below line for firefox
			window.frames['iframe_' + roomArray[i]].contentWindow.pause();
		} else {
			//other browsers
			window.frames['iframe_' + roomArray[i]].pause();
		}
		//code for pause
		$('#par_' + roomArray[i]).hide();
		if (roomArray[i] != undefined) {
			var convertj = convertTimeToDate(roomArray[i]);
			//hide the no result fond
			$('#nodata').hide();
			$('#active_chats ul').append("<li class='prq' id='li_" + roomArray[i] + "' style='cursor:pointer;' ><span>" + convertj + "&nbsp;&nbsp;&nbsp;&nbsp;<input type='image' onclick=reOpenChat('" + roomArray[i] + "') src='" + site_url1 + "img/gpchat.png'></span></li>");
		}
		i = i + 1;
	}
	var url = site_url1 + "/chats/groupChat/" + friend + "/" + roomName;
	var html = '<div id="par_' + roomName + '" style="float:left;margin-right: 11px;" class="chatarea-inner"><div class="chatarea" id="chatwindow' + roomName + '" style="float:left;"><iframe id="iframe_' + roomName + '" src="' + url + '" width="200" height="340" frameBorder="0" scrolling="no" ></iframe></div><div class="chatwindowMax" id="chatwindowMax' + roomName + '" style="display:none;">Max</div></div>';
	$('#chatarea').append(html);
	var current_div1 = $('#chatarea').children('.chatarea-inner:visible').length;
	if (current_div1 == 1) {
		$('#chatarea').children('.chatarea-inner').addClass('one-inner');
		$('#chatarea').addClass('chatarea-wrapper-main');
	}
	isOpenChat = 1;
	}
}

/**
 * Active Chats [Joined] accordion
 */
function showJoinedChatDiv() {
	if ($('#act_ch_j').is(':visible')) {
		$('#active_chats .slimScrollDiv').animate({
			height : "0px"
		}, 500);
	} else
		$('#active_chats .slimScrollDiv').animate({
			height : "150px"
		}, 500);
	$('#act_ch_j').toggle('slow', function() {
		showhidetogglearea('act_ch_j', 'act_ch_j_max', 'act_ch_j_min'); // function
		// is
		// calling
		// for
		// hiding
		// the
		// other
		// divs
		// if
		// those
		// are
		// opened
		// check for clicked button
		if ($('#act_ch_j_max').is(':visible')) {
			$('#act_ch_j').slimscroll({
				height : '150px'
			});
			$('#act_ch_j_max').hide();
			$('#act_ch_j_min').show();
		} else if ($('#act_ch_j_min').is(':visible')) {

			$('#act_ch_j_min').hide();
			$('#act_ch_j_max').show();
		}

	});
}

/**
 * Active Chats [Not Joined] accordion
 */
function showNotJoinedChatDiv() {
	if ($('#not_joined_activechats').is(':visible')) {
		$('#not_joined_activechats-wrapper .slimScrollDiv').animate({
			height : "0px"
		}, 500);
	} else
		$('#not_joined_activechats-wrapper .slimScrollDiv').animate({
			height : "190px"
		}, 500);
	$('#not_joined_activechats').toggle('slow', function() {
		showhidetogglearea('not_joined_activechats', 'act_ch_nj_max', 'act_ch_nj_min'); // function
		// is
		// calling
		// for
		// hiding
		// the other divs if those are
		// opened
		// check for clicked button
		if ($('#act_ch_nj_max').is(':visible')) {
			$('#not_joined_activechats').slimscroll({
				height : '190px'
			});
			$('#act_ch_nj_max').hide();
			$('#act_ch_nj_min').show();
			
			var refreshIdNotJoinedActiveChats = getNotJoinedActiveChats();
			
		} else if ($('#act_ch_nj_min').is(':visible')) {

			$('#act_ch_nj_min').hide();
			$('#act_ch_nj_max').show();
		}

	});
}

/**
 * Pending Requests accordion
 * 
 * @param request
 *            type
 */
function showPendingChatDiv() {
	if ($('#pending_request').is(':visible')) {
		$('#pending_request-wrapper	 .slimScrollDiv').animate({
			height : "0px"
		}, 500);
	} else
		$('#pending_request-wrapper	 .slimScrollDiv').animate({
			height : "150px"
		}, 500);
	$('#pending_request').toggle('slow', function() {
		showhidetogglearea('pending_request', 'pend_req_max', 'pend_req_min'); // function
		// is
		// calling
		// for
		// hiding
		// the
		// other
		// divs
		// if
		// those
		// are
		// opened
		// check for clicked button
		if ($('#pend_req_max').is(':visible')) {

			$('#pending_request').slimscroll({
				height : '150px'
			});

			// perform ajax request and mark the notification as read
			$.ajax({
				type : "POST",
				url : site_url1 + "/chats/markNotificationAsRead",
				data : {}
			}).done(function(msg) {
				$('#pend_req_max').hide();
				$('#pend_req_min').show();
			});
			var refreshIdPendingRequests = getPendingRequests();

		} else if ($('#pend_req_min').is(':visible')) {
			// perform ajax request and mark the notification as read
			$.ajax({
				type : "POST",
				url : site_url1 + "/chats/markNotificationAsRead",
				data : {}
			}).done(function(msg) {
				$('#pend_req_min').hide();
				$('#pend_req_max').show();
			});

		}

	});
}

/**
 * Requests by other users to join chat accordion
 */
function showReqChatDiv() {
	if ($('#chat_requests').is(':visible')) {
		$('#chat_requests-wrapper .slimScrollDiv').animate({
			height : "0px"
		}, 500);
	} else
		$('#chat_requests-wrapper .slimScrollDiv').animate({
			height : "150px"
		}, 500);
	$('#chat_requests').toggle('slow', function() {
		showhidetogglearea('chat_requests', 'chat_req_max', 'chat_req_min'); // function
		// is
		// calling
		// for
		// hiding
		// the
		// other
		// divs
		// if
		// those
		// are
		// opened
		// check for clicked button
		if ($('#chat_req_max').is(':visible')) {
			$('#chat_requests').slimscroll({
				height : '150px'
			});
			$('#chat_req_max').hide();
			$('#chat_req_min').show();
			
			var refreshIdPendingChatRequests = getPendingChatRequests();
			
		} else if ($('#chat_req_min').is(':visible')) {

			$('#chat_req_min').hide();
			$('#chat_req_max').show();
		}
		

	});
}

/**
 * Notifications chat accordion
 */
function showChatNotifDiv() {
	if ($('#chatdeny_notification').is(':visible')) {
		$('#chatdeny_notification-wrapper .slimScrollDiv').animate({
			height : "0px"
		}, 500);
	} else
		$('#chatdeny_notification-wrapper .slimScrollDiv').animate({
			height : "150px"
		}, 500);
	$('#chatdeny_notification').toggle('slow', function() {
		showhidetogglearea('chatdeny_notification', 'chat_deny_max', 'chat_deny_min'); // function
		var refreshIdDeniedChatMsg = getDeniedChatMsg();
		// is
		// calling
		// for
		// hiding
		// the other divs if those are
		// opened
		// check for clicked button
		if ($('#chat_deny_max').is(':visible')) {

			$('#chatdeny_notification').slimscroll({
				height : '150px'
			});

			// perform ajax request and mark the notification as read
			$.ajax({
				type : "POST",
				url : site_url1 + "/chats/markDenyNotificationAsRead",
				data : {}
			}).done(function(msg) {
				$('#chat_deny_max').hide();
				$('#chat_deny_min').show();
			});
			
			

		} else if ($('#chat_deny_min').is(':visible')) {

			// perform ajax request and mark the notification as read
			$.ajax({
				type : "POST",
				url : site_url1 + "/chats/markDenyNotificationAsRead",
				data : {}
			}).done(function(msg) {
				$('#chat_deny_min').hide();
				$('#chat_deny_max').show();
			});

		}

	});
}

/**
 * Method to get userType student/instructor
 * 
 * @param username
 * @return string
 */
function getUserType(user, gid) {
	var n = user.split('@');
	var userName = n[0];

	var url = site_url1 + '/chats/getUserType';
	var currentusersType;
	$.ajax({
		type : 'POST',
		url : url,
		async : false,
		// data : 'userType='+userName,
		data : {
			userType : userName,
			gid : gid
		},
		datatype : 'json',
		success : function(res) {
		currentusersType = res;
		}
	});
	return currentusersType;
}

function getRoasterUser(user, gid) {
	var n = user.split('@');
	var userName = n[0];

	var url = site_url1 + '/chats/getRoasterUser';
	var currentusersType;
	$.ajax({
		type : 'POST',
		url : url,
		async : false,
		// data : 'userType='+userName,
		data : {
			userType : userName,
			gid : gid
		},
		datatype : 'json',
		success : function(res) {
			currentusersType = res;
		}
	});
	return currentusersType;
}

/*
 * code start by yogendra
 */
/*
 * function for sending the ajax call and checking the roster is not in current
 * room.
 */
function check_groupchat(chat_room) {
	var url = site_url1 + 'chats/checkRosterInChat';
	var chat_room = chat_room;
	$.ajax({
		type : 'POST',
		url : url,
		data : 'chat_room=' + chat_room,
		datatype : 'json',
		success : function(res) {
		},
		error : function() {
		}
	});
}
/*
 * function for keeping the array of the online rosters and can be invited to
 * join a group.
 */

function send_online_rosters(rosters_jid, room_name) {
	var n = rosters_jid.split('@');
	var user_jname = n[0];
	// function for calling for checking the current user are using the
	// specified room(rom_name).
	var roomsusers = getcurrentroomusers(room_name);

	var contact_html = '';
	if ($('#roster-area-group li#' + user_jname).length > 0) {
		// cheking(by jid) a roster is already is exists in the list
		contact_html = '';
	} else {
		var k = 0; // for loop is cheking the users are already is in the room
		// if user in the room then willl not seen for the invitation.
		for ( var n = 0; n < roomsusers.length; n++) {
			if (user_jname == roomsusers[n]) {
				k = 1;
				break;
			}
		}
		if (k) // if user is alraedy in the room then will not seen the user
			// for the invitation.
			contact_html = "<li class='gonline_users' id='" + user_jname + "' style='display:none;' ><input type='checkbox' value='" + rosters_jid + "' name= invite_friends[] />" + "<span class='" + ($('#' + rosters_jid).attr('class') || "roster-contact online") + "'>" + "<span class='roster-name'>" + user_jname + "</span></span></li>";
		else if (rosters_jid == room_name) // check for the room is not
			// same the jid because the
			// strophe is sending the
			// room as a roster..
			contact_html = '';

		else
			contact_html = "<li class='gonline_users' id='" + user_jname + "'><input type='checkbox' value='" + rosters_jid + "' name= invite_friends[] />" + "<span class='" + ($('#' + rosters_jid).attr('class') || "roster-contact online") + "'>" + "<span class='roster-name'>" + user_jname + "</span></span></li>";
	}
	$('#roster-area-group ul').append(contact_html);
	$('#room-name').val(room_name);
}
$(document).ready(function() {
	$('#add_rosters_ingroup').click(function() {
		var users = new Array();
		var i = 0;
		$("input[name='invite_friends[]']:checked").each(function() {
			users[i] = $(this).val();
			i++;
		});
		var url = site_url1 + 'chats/invitedUsers';
		var chat_room = $('#room-name').html();
		$.ajax({
			type : 'POST',
			url : url,
			data : 'chat_room_name=' + chat_room + '&iniviteusers=' + users,
			datatype : 'json',
			success : function(res) {
				for ( var i = 0; i < users.length; i++) {
					var users_splited = users[i].split('@');

					// hide the requested roster, user can't send request to him
					// again, just for prformance.
					$('#roster-area-group li#' + users_splited[0]).hide();
				}
			},
			error : function() {
			}
		});
	});
	window.onbeforeunload = function() {
		//return clearCurrentOnlineLogs();
	};
});
/*
 * function callling from above function send_online_rosters() used to getting
 * the current users for the room.
 */
function getcurrentroomusers(room_name) {
	var url = site_url1 + 'chats/getCurrentRoomUsers';
	var chat_room = room_name;
	currentusers = {};
	obj = {};
	if (chat_room.length)
		$.ajax({
			type : 'POST',
			url : url,
			async : false,
			data : 'chatroom_name=' + chat_room,
			datatype : 'json',
			success : function(res) {
				obj = eval(res); // obj is now an array and an object
				currentusers = obj;
			}
		});
	return currentusers;
}

/*
 * fucntion for removing the roster from the inivted list called form groupie.js
 */
function remove_roster(user_jid, nick) {
	var splited_userjid = user_jid.split('@');
	var user_jid_prefix = splited_userjid[0];
	$('#roster-area-group li#' + user_jid_prefix).hide();
	$('#participants li#participant-' + user_jid_prefix).show();
}
/*
 * function for checking the users are in the room.. if users are not in the
 * current room then remove from the participants area
 */
function getRoomUsers() {
	var roomgroupname = $('#room-name').html();
	var url = site_url1 + 'chats/getRoomsUsers';
	obj = {};
	if (roomgroupname.length) // if we are getting the roomname then send the
		// ajax o/w do nothing.
		$.ajax({
			type : 'POST',
			url : url,
			data : 'chatroomname=' + roomgroupname,
			datatype : 'json',
			success : function(res) {
				//obj_full = eval(res); // obj is now an array and an object
				obj_full = JSON.parse(res); 
				obj  = obj_full['getroomusers'];
				obj1 = obj_full['showinvitedusers'];

				$('#participants li').each(function() {
					var li_id = $(this).attr('id');
					var nickname = li_id.split('-');
					var k = 1; // initialize the variable
					for ( var i = 0; i < obj.length; i++) {
						if (obj[i] != nickname[1]) // checking the users are in
							// room or not
							k = 0;
						else {
							k = 1;
							break;
						}
					}
					if (!k) // if the users leave or close the chat window then
						// update the participaints list of other users.
						$(this).hide();
					else
						$(this).show();
				});
				//second call process	
				$('#roster-area-group li').each(function() {
					var li_id = $(this).attr('id');
					var l = 0;
					for ( var i = 0; i < obj1.length; i++) {
						if (obj1[i] != li_id) // checking the users
							// are in room or
							// not
							l = 0;
						else {
							l = 1;
							break;
						}
					}
					if (!l) { // if the users leave or close the chat
						// window then
						// update the participaints list of other users.
						if ($('#roster-area-group li#' + li_id + ' .roster-contact').hasClass('online')) // if
							// the
							// user
							// is
							// online
							// then show the user for
							// further invitation
							$('#roster-area-group li#' + li_id).show();
						else
							$('#roster-area-group li#' + li_id).hide();
					} else
						$('#roster-area-group li#' + li_id).hide();
				});
			//second call process end.	
			},
			error : function() {
			}
		});
}
/*
 * function for getting the users of the current chat room. if users are not in
 * the current room then show in the invite area of a user in chat window
 */
function showUsersforInvitation() {
	var roomgroupname = $('#room-name').html();
	var url = site_url1 + 'chats/getRoomsUsersInvited';
	obj = {};
	if (roomgroupname.length) // if we are getting the roomname then send the
		// ajax o/w do nothing.
		$.ajax({
			type : 'POST',
			url : url,
			data : 'chatroomname=' + roomgroupname,
			datatype : 'json',
			success : function(res) {
				obj_full = JSON.parse(res); // obj is now an array and an object
				obj = obj_full['showinvitedusers'];
				$('#roster-area-group li').each(function() {
					var li_id = $(this).attr('id');
					var l = 0;
					for ( var i = 0; i < obj.length; i++) {
						if (obj[i] != li_id) // checking the users
							// are in room or
							// not
							l = 0;
						else {
							l = 1;
							break;
						}
					}
					if (!l) { // if the users leave or close the chat
						// window then
						// update the participaints list of other users.
						if ($('#roster-area-group li#' + li_id + ' .roster-contact').hasClass('online')) // if
							// the
							// user
							// is
							// online
							// then show the user for
							// further invitation
							$('#roster-area-group li#' + li_id).show();
						else
							$('#roster-area-group li#' + li_id).hide();
					} else
						$('#roster-area-group li#' + li_id).hide();
				});

			},
			error : function() {
			}
		});
	// code for showing the group name if users are online for the invitation in
	// group chat window
	/*
	 * $('#roster-area-group ul div.online_user_area_gruopchat').each(function() {
	 * var element_id = $(this).attr('id'); $('#'+element_id).show(); var laen =
	 * $('#'+element_id+' li:visible').length; if(laen){
	 * $('#'+element_id).show();} else{ $('#'+element_id).hide();} });
	 */
}
/*
 * fucntion for showing/hiding the chat window.
 */
function show_hidechatwindow(window_id) {
	$('#chatwindow' + window_id).toggle();
}
/*
 * function for adding the users(rosters) according to the group
 */
function send_rosters_bygroup(elem, room_name) {
	var jid = elem.find('.roster-jid').text();
	var gid = elem.find('.roaster-group').text();
	var inUserSetting = 2;
	var section_type =  $('#sectionsettingid', window.parent.document).val();
	var courseName = $('#csnameid', window.parent.document).val();
	
	if (jid != "" && gid != '') {
        //check for setting type
        var lowercase_gid = gid.toLowerCase();
        var userChatNameArray = jid.split("@");
        var loweruserChatNameArray = userChatNameArray[0].toLowerCase();
        
        var section_setting = $('#outersetting-'+lowercase_gid, window.parent.document).val();
        if(section_setting) {
          inUserSetting = section_setting;
        }
         //var userType = getUserType(jid, gid);
		//changed bove line commented
	}
	// remove blank space
	var newCourseName = courseName.replace(/\s+/g, "");
	var pres = presence_value(elem.find('.roster-contact'));

	var contacts = $('#roster-area-group li');
	// check for section type in section or all section

	if (section_type == 1) {
		// Show the user's roaster according to the Course
		if (courseName == gid) {
			if (contacts.length > 0) {
				var inserted = false;
				contacts.each(function() {
					var cmp_pres = presence_value($(this).find('.roster-contact'));
					var cmp_jid = $(this).find('.roster-jid').text();

					if (pres > cmp_pres) {
						$(this).before(elem);
						inserted = false;
						return false;
					} else {
						if (jid < cmp_jid) {
							$(this).before(elem);
							inserted = false;
							return false;
						}
					}
				});
				if (!inserted) {
					var oldid = gid;
					// remove blank space
					var newid = oldid.replace(/\s+/g, "");
					if (!$('#' + newid).length) {
						$('#roster-area-group ul').append('<div id="' + newid + '" class="online_user_area_gruopchat"><p>' + gid + '</p></div>');
					}
					$('#' + newid).append(elem);
				}
			} else {
				var oldid = gid;
				// remove blank space
				var newid = oldid.replace(/\s+/g, "");
				if (!$('#' + newid).length) {
					$('#roster-area-group ul ').append('<div id="' + newid + '" class="online_user_area_gruopchat"><p>' + gid + '</p></div>');
				}
				$('#' + newid).append(elem);
			}
		}
	}
	//if current user section setting and coming roster setting is equal and all section then it will see
	if (inUserSetting == 2 && section_type == 2) { // for all section setting..

		// get course name

		var crse = courseName.split("-");

		var crse_name = crse[0];

		// get course name from group id from openfire
		var crse_gid = gid.split("-");
		var crse_gid_name = crse_gid[0];

		if (crse_name == crse_gid_name) {

			if (contacts.length > 0) {
				var inserted = false;
				contacts.each(function() {
					var cmp_pres = presence_value($(this).find('.roster-contact'));
					var cmp_jid = $(this).find('.roster-jid').text();

					if (pres > cmp_pres) {
						$(this).before(elem);
						inserted = false;
						return false;
					} else {
						if (jid < cmp_jid) {
							$(this).before(elem);
							inserted = false;
							return false;
						}
					}
				});

				if (!inserted) {
					var oldid = gid;
					// remove blank space
					var newid = oldid.replace(/\s+/g, "");
					if (!$('#' + newid).length) {
						$('#roster-area-group ul ').append('<div id="' + newid + '" class="online_user_area_gruopchat"><p>' + gid + '</p></div>');
					}
					$('#' + newid).append(elem);
				}
			} else {
				var oldid = gid;
				// remove blank space
				var newid = oldid.replace(/\s+/g, "");
				if (!$('#' + newid).length) {
					$('#roster-area-group ul ').append('<div id="' + newid + '" class="online_user_area_gruopchat"><p>' + gid + '</p></div>');
				}
				$('#' + newid).append(elem);
			}
		}
	}
}

function presence_value(elem) {
	if (elem.hasClass('online')) {
		return 2;
	} else if (elem.hasClass('away')) {
		return 1;
	}

	return 0;
}
/*
 * function for showing the online rosters.
 */
function send_online_rosters_bygroup(rosters_jid, room_name) {
	var n = rosters_jid.split('@');
	var user_jname = n[0];
	// function for calling for checking the current user are using the
	// specified room(rom_name).
	if (t == 0) { // call only one time global variable defined at the top of the file.
		roomsusers = getcurrentroomusers(room_name); // variable is defined at the top(global function)
		t = 1;
	}
	$('#roster-area-group li#' + user_jname + ' .roster-contact').removeClass('offline').addClass("online");
	// code for checking the user is currently in the group or not
	var k = 0; // for loop is cheking the users are already is in the room
	// if user in the room then will not seen for the invitation.
	for ( var n = 0; n < roomsusers.length; n++) {
		if (user_jname == roomsusers[n]) {
			k = 1;
			break;
		}
	}
	if (!k) // if user is already in the room then will not seen the user for
	// the invitation.
	{
		$('#roster-area-group li#' + user_jname).css('display', 'block');
	}
}
/*
 * code edit end by yogendra
 */
/*
 * new code edit by yogendra
 */
function emoticon(test) {
	$('#input').focus();
	$('#input').val($('#input').val() + " " + test + " ");
	// $('#smileyarea').toggle();
}
/*
 * replacing the text by emoticons icons
 */
function replaceImage(text) {

	var searchFor = /:D|:-D|:\)|:-\)|;\)|';-\)|:\(|:-\(|:o|:\?|8-\)|:x|:X|:P|:p|:q|:8|8\)|:lol:|:shock:|:red:|:cry:|:evil:|:twisted:|:roll:|:wink:|:!:|:idea:|:arrow:/gi;

	var map = {
		":D" : 'icon_biggrin.gif',
		":d" : 'icon_e_biggrin.gif',
		":-D" : 'icon_e_biggrin.gif',
		":-d" : 'icon_e_biggrin.gif',
		":)" : 'icon_smile.gif',
		":-)" : 'icon_e_smile.gif',
		":(" : 'icon_sad.gif',
		":-(" : 'icon_e_sad.gif',
		":O" : 'icon_surprised.gif',
		":o" : 'icon_surprised.gif',
		";)" : 'icon_e_wink.gif',
		":wink:" : 'icon_wink.gif',
		"';-)" : 'icon_e_wink.gif',
		":shock:" : 'icon_eek.gif',

		":?" : 'icon_confused.gif',
		":8" : 'icon_cool.gif',
		"8)" : 'icon_cool.gif',
		":lol:" : 'icon_lol.gif',
		":X" : 'icon_mad.gif',
		":x" : 'icon_mad.gif',
		":P" : 'icon_razz.gif',
		":p" : 'icon_razz.gif',

		":red:" : 'icon_redface.gif',
		":cry:" : 'icon_cry.gif',
		":evil:" : 'icon_evil.gif',
		":twisted:" : 'icon_twisted.gif',
		":roll:" : 'icon_rolleyes.gif',
		":!:" : 'icon_exclaim.gif',
		":q" : 'icon_question.gif',
		":idea:" : 'icon_idea.gif',
		":arrow:" : 'icon_arrow.gif'
	};

	text = text.replace(searchFor, function(match) {
		var rep;
		rep = map[match];
		var url = site_url; // defined in the layout file
		var url_new = url + "/img/smiley/";
		return rep ? '<img src="' + url_new + rep + '" class="emoticons" />' : match;
	});
	return text;

}

/*
 * function for sending the current chat on email id
 */
function emailChat(room_name) {
	var chat = $('#chat').html();
	var chat1 = $.trim(chat);
	var url = site_url1 + 'chats/sendNewUserMail';
	if (chat1 != '') {
		var chat_new_encoded = encodeURIComponent(chat1);
		$('#email_chatt').toggle();
		$('#email_loader').show();
		$.ajax({
			type : 'POST',
			url : url,
			data : 'chat_html=' + chat_new_encoded,
			datatype : 'json',
			success : function(res) {
				// alert('chat mailed');
			},
			complete : function() {
				$('#email_loader').hide();
				$('#email_chatt').toggle();
			}
		});
	}
}
/*
 * new code edit end by yogendra
 */

function showhidetogglearea(area, max, min) {
	if (($('#pend_req_min').is(':visible')) && ($('#pending_request').is(':visible')) && (area != 'pending_request')) {
		if ($('#pend_req_min').is(':visible'))
			$('#pending_request-wrapper .slimScrollDiv').animate({
				height : "0px"
			}, 500);
		$('#pend_req_max').show();
		$('#pend_req_min').hide();
		$('#pending_request').toggle('slow', function() {

		});
	}
	if (($('#act_ch_j_min').is(':visible')) && ($('#act_ch_j').is(':visible')) && (area != 'act_ch_j')) {
		if ($('#act_ch_j_min').is(':visible'))
			$('#active_chats .slimScrollDiv').animate({
				height : "0px"
			}, 500);
		$('#act_ch_j_max').show();
		$('#act_ch_j_min').hide();
		$('#act_ch_j').toggle('slow', function() {

		});
	}
	if (($('#act_ch_nj_min').is(':visible')) && ($('#not_joined_activechats').is(':visible')) && (area != 'not_joined_activechats')) {
		if ($('#act_ch_nj_min').is(':visible'))
			$('#not_joined_activechats-wrapper .slimScrollDiv').animate({
				height : "0px"
			}, 500);
		$('#act_ch_nj_max').show();
		$('#act_ch_nj_min').hide();
		$('#not_joined_activechats').toggle('slow', function() {

		});
	}
	if (($('#chat_req_min').is(':visible')) && ($('#chat_requests').is(':visible')) && (area != 'chat_requests')) {
		if ($('#chat_req_min').is(':visible'))
			$('#chat_requests-wrapper .slimScrollDiv').animate({
				height : "0px"
			}, 500);
		$('#chat_req_max').show();
		$('#chat_req_min').hide();
		$('#chat_requests').toggle('slow', function() {

		});
	}
	if (($('#chat_deny_min').is(':visible')) && ($('#chatdeny_notification').is(':visible')) && (area != 'chatdeny_notification')) {
		if ($('#chat_deny_min').is(':visible'))
			$('#chatdeny_notification-wrapper .slimScrollDiv').animate({
				height : "0px"
			}, 500);
		$('#chat_deny_max').show();
		$('#chat_deny_min').hide();
		$('#chatdeny_notification').toggle('slow', function() {

		});
	}
	if (($('#chat_meetings_min').is(':visible')) && ($('#meeting_area').is(':visible')) && (area != 'meeting_area')) {
		if ($('#chat_meetings_min').is(':visible'))
			$('#meeting_area-wrapper .slimScrollDiv').animate({
				height : "0px"
			}, 500);
		$('#chat_meetings_max').show();
		$('#chat_meetings_min').hide();
		$('#list-meetings').toggle();
		$('#meeting_area').toggle('slow', function() {

		});
	}
}
/**
 * Show Hide notification tab
 */
function notificationTab() {
	$('.friends_list').hide();
	$('.meeting-panel').hide();
	$('#activeChatTab').hide();
	$('.upper-area').toggle();
	if ($('.upper-area').is(':visible')) {
		$('#notf-lazy').hide();
		$('#meet-active').hide();
		$('#jact-active').hide();
		$('#notf-active').show();
		$('#meet-lazy').show();
		$('#jact-lazy').show();
		$('#tab-msg').html('<h3>Notifications</h3>');
	} else {
		$('#notf-active').hide();
		$('#notf-lazy').show();
		$('.friends_list').show();
		$('#tab-msg').html('<h3>Who is Online</h3>');

	}
}

/**
 * Show Hide notification tab
 */
function joinActiveChatTab() {

	$('.friends_list').hide();
	$('.meeting-panel').hide();
	$('.upper-area').hide();
	$('#activeChatTab').toggle();
	if ($('#activeChatTab').is(':visible')) {
		$('#meet-active').hide();
		$('#notf-active').hide();
		$('#jact-lazy').hide();
		$('#jact-active').show();
		$('#meet-lazy').show();
		$('#notf-lazy').show();

		$('#tab-msg').html('<h3>Join active chats</h3>');

	} else {
		$('#jact-active').hide();
		$('#jact-lazy').show();
		$('.friends_list').show();
		$('#tab-msg').html('<h3>Who is Online</h3>');

	}
}
/*
 * calculating the time format course-m/d/y: H:I:S PM/AM
*/
function convertTimeToDate(roomName)
{
	var timedate = roomName.split('_');
	var cctime = new Date(parseInt(timedate[1])*1000);
    var curr_date = cctime.getDate();
    var curr_month = cctime.getMonth() + 1; //Months are zero based
    var curr_year = cctime.getFullYear();
    var curr_hour = cctime.getHours();
    var curr_minutes = cctime.getMinutes();
    var curr_seconds = cctime.getSeconds();
	var suffix = "AM";
	if (curr_hour >= 12) {
		suffix = "PM";
		curr_hour = curr_hour - 12;
	}
	if (curr_hour == 0) {
		curr_hour = 12;
	}
	var dateformated = userCourse+"-"+curr_month+"/"+ curr_date+"/"+curr_year+"/"+curr_hour+":"+curr_minutes+":"+curr_seconds+" "+suffix;
	return dateformated;
}
/**
* Check if user is offline
* @param username
* @return string
*/
function getUserStatusData(jid){
	var url = site_url1 + 'users/getUserStatusData';
    var currentusers;
    $.ajax({
            type : 'POST',
            url : url,
            async : false,
            data : 'jid=' + jid,
            datatype : 'json',
            success : function(res) {
                    currentusers = res;
            }
    });

    return currentusers; 
}

/**
 * clear the current online user session logs
 */
function clearCurrentOnlineLogs()
{
	var url = site_url1 + 'chats/clearCurrentOnlineLogs';
    $.ajax({
            type : 'POST',
            url : url,
            async : true,
            datatype : 'json',
            success : function(res) {
            }
    });
    return true;
}

/**
 * Get all notifications
 */
function getRequestsAvailableCount()
{
	$.ajax({
		type : "POST",
		url : site_url1 + "chats/getRequestsAvailableCount",
		data : {}
	}).done(function(msg) {
		
		//pendingrequestcount starts
		var t = JSON.parse(msg);
		var msgCount = t['getpendingrequestcount']['count'];
		var isAlert = t['getpendingrequestcount']['showAlert'];
		//below two lines edit for checking current online users
		var onlineUserList = t['onlineuserlist'];
		$('#onlineusenamelist').val(onlineUserList);
		
		if (msgCount == "0") {
			$('#pending_request_count').hide();
		} else {
			$('#pending_request_count').show();
			$('#pending_request_count').html(msgCount);

		}
		// get global value
		// var gbValue = $('#hiddenGlobal').val();
		newPendGbValue = parseInt(msgCount);
		updatedGbValue = newPendGbValue + newReqGbValue + newNotfGbValue + newMeetGbValue;
		if (updatedGbValue != 0) {
			$('#globalNotify').show();
			$('#globalNotify').html(updatedGbValue);
		} else
			$('#globalNotify').hide();
		if (isAlert == 1) {
			$.msgBox({
				title : "Notification",
				content : 'New chat request.'
			});
		}
		
		//getPendingChatRequestsCount
		var t1 = JSON.parse(msg);
		var msgCount1 = t1['pendingrequestcount']['count'];
		var isAlert1 = t1['pendingrequestcount']['showAlert'];
		newReqGbValue = parseInt(msgCount1);
		// show global notification
		updatedGbValue = newPendGbValue + newReqGbValue + newNotfGbValue + newMeetGbValue;
		if (updatedGbValue != 0) {
			$('#globalNotify').show();
			$('#globalNotify').html(updatedGbValue);
		} else
			$('#globalNotify').hide();

		if (msgCount1 == "0") {
			$('#chat_requests_count').hide();
		} else {
			$('#chat_requests_count').show();
			// set global notification value

			$('#chat_requests_count').html(newReqGbValue);
		}

		if (isAlert1 == 1) {
			$.msgBox({
				title : "Notification",
				content : 'New request to join the active chat.'
			});
		}
		
		//getDeniedChatMsgCount
		var t2 = JSON.parse(msg);
		var msgCount2 = t2['getdeniedchatmsgcount']['count'];
		var isAlert2 = t2['getdeniedchatmsgcount']['showAlert'];
		newNotfGbValue = msgCount2;
		// show global notification
		updatedGbValue = newPendGbValue + newReqGbValue + newNotfGbValue + newMeetGbValue;
		if (updatedGbValue != 0) {
			$('#globalNotify').show();
			$('#globalNotify').html(updatedGbValue);
		} else
			$('#globalNotify').hide();

		if (msgCount2 == "0") {
			$('#chatdeny_notification_count').hide();
		} else {
			$('#chatdeny_notification_count').show();
			// set global notification value

			$('#chatdeny_notification_count').html(msgCount2);
		}
		if (isAlert2 == 1) {
			$.msgBox({
				title : "Notification",
				content : 'Your request for chat has denied.'
			});
		}
		
		//getMeetingRequestsCount
		var t3 = JSON.parse(msg);
		var msgCount3 = t3['getmeetingrequestcount']['count'];
		var isAlert3 = t3['getmeetingrequestcount']['showAlert'];
		
		newMeetGbValue = msgCount3;
		updatedGbValue = newPendGbValue + newReqGbValue + newNotfGbValue + newMeetGbValue;
		if (updatedGbValue != 0) {
			$('#globalNotify').show();
		$('#globalNotify').html(updatedGbValue);
		} else
			$('#globalNotify').hide();
			
		if(msgCount3=="0"){
			$('#chat_meetings_count').hide();
		}else{
			
		$('#chat_meetings_count').show();
		$('#chat_meetings_count').html(msgCount3);
		}
		if(isAlert3 == 1){
			$.msgBox({
			    title:"Alert",
			    content:'New Meeting Notification'
			});
		}
		
	});
}

/**
*checking the browser
*/
function check_browser()
{
	var nVer = navigator.appVersion;
	var nAgt = navigator.userAgent;
	var browserName  = navigator.appName;
	var fullVersion  = ''+parseFloat(navigator.appVersion); 
	var majorVersion = parseInt(navigator.appVersion,10);
	var nameOffset,verOffset,ix;

	// In Opera, the true version is after "Opera" or after "Version"
	if ((verOffset=nAgt.indexOf("Opera"))!=-1) {
	 browserName = "Opera";
	 fullVersion = nAgt.substring(verOffset+6);
	 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
	   fullVersion = nAgt.substring(verOffset+8);
	}
	// In MSIE, the true version is after "MSIE" in userAgent
	else if ((verOffset=nAgt.indexOf("MSIE"))!=-1) {
	 browserName = "Microsoft Internet Explorer";
	 fullVersion = nAgt.substring(verOffset+5);
	}
	// In Chrome, the true version is after "Chrome" 
	else if ((verOffset=nAgt.indexOf("Chrome"))!=-1) {
	 browserName = "Chrome";
	 fullVersion = nAgt.substring(verOffset+7);
	}
	// In Safari, the true version is after "Safari" or after "Version" 
	else if ((verOffset=nAgt.indexOf("Safari"))!=-1) {
	 browserName = "Safari";
	 fullVersion = nAgt.substring(verOffset+7);
	 if ((verOffset=nAgt.indexOf("Version"))!=-1) 
	   fullVersion = nAgt.substring(verOffset+8);
	}
	// In Firefox, the true version is after "Firefox" 
	else if ((verOffset=nAgt.indexOf("Firefox"))!=-1) {
	 browserName = "Firefox";
	 fullVersion = nAgt.substring(verOffset+8);
	}
	// In most other browsers, "name/version" is at the end of userAgent 
	else if ( (nameOffset=nAgt.lastIndexOf(' ')+1) < 
	          (verOffset=nAgt.lastIndexOf('/')) ) 
	{
	 browserName = nAgt.substring(nameOffset,verOffset);
	 fullVersion = nAgt.substring(verOffset+1);
	 if (browserName.toLowerCase()==browserName.toUpperCase()) {
	  browserName = navigator.appName;
	 }
	}
	if (browserName == 'Firefox')
		return 'mozilla';
	return 'other';
}