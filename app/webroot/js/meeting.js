//site_url1 variable is defined in the layout...
/**
 * Date Picker
 */
$(function() {
	$("#datepicker").datepicker({
		changeMonth : true,
		changeYear : true,
		 minDate: new Date()
	});
});

/**
 * Call ajax request to create meetings
 */
function saveMeeting(){
	
	$('#meeting_success').html('')
	//get form value
	 //get title
    var title = $('#meeting_title').val();
    if(title==""){
    	$.msgBox({
		    title:"Alert",
		    content:'Enter meeting name'
		});
    	
    	return false;
    }
    
	//get selected friends name
	var friends_name = $("input[name='data[meetings][users][]']:checked");
	var values = new Array();
	$.each(friends_name, function() {
			values.push($(this).val());
		});
	
    if(values==""){
    	$.msgBox({
		    title:"Alert",
		    content:'Select Users'
		});
    return false;
    }
   
    //get startdate
    var startdate = $('#datepicker').val();
    if(startdate==""){
    	$.msgBox({
		    title:"Alert",
		    content:'Select meeting date'
		});
    	    return false;
    }
    var hh = $('#hh').val();
    var minutes = $('#minutes').val();
	
    //show loader
    $('#metting-email-loader').show();
    //send ajax request
    $.ajax( {
		type : "POST",
		url : site_url1+"meetings/saveMeeting",
		data : {friends:values,
			meeting_title:title,
			meeting_start_date:startdate,
			meeting_start_hours:hh,
			meeting_start_minutes:minutes
			}
	}).done(function(msg) {
		 $('#metting-email-loader').hide();
		 $('#meeting_success').html(msg)
	});
	return false;
}
/*
*code start by yogendra
*/
/**
 * Listing the users meetings
 */
function list_meetings(){
	var url = site_url1+'meetings/userMeetings';
    //show loader
    $('#metting-loader').show();
 	$.ajax({
		type : 'POST',
		url : url,
		data : '',
		datatype : 'json',
		success : function(res) {
			$('#metting-loader').hide();
			$('#meeting_area').html(res);
},
error : function() {
}
	});
}
/**
 * Listing the users meetings by ajax
 */
function list_meetingsBYAjax(){
	var url = site_url1+'meetings/userMeetings';
    //show loader
   // $('#metting-loader').show();
	$.ajax({
		type : 'POST',
		url : url,
		data : '',
		datatype : 'json',
		success : function(res) {
	//		$('#metting-loader').hide();
			$('#meeting_area').html(res);
},
error : function() {
}
	});
}
/**
 * joining the meeting
 * @param id
 * @param roomname
 */
function joinmeeting(id, roomname)
{
	$.ajax({
		type : "POST",
		url : site_url1+"meetings/CheckActiveMeeting",
		data : {
			id: id,
			roomname: roomname
		}
	}).done(function(msg) {
		
		if(msg == "0"){ 
			$.msgBox({
			    title:"Alert",
			    content:'Meeting time expired, please refresh the tab.'
			});
			return false;
		}
	 $('.right-area').show();
     var current_div = $('#chatarea').children('.chatarea-inner:visible').length;
	 var t4 = $('#chatarea').children('.chatarea-inner:visible').length;
	 if(t4 < 4){
		 var r4  = t4+1;
	     var newwidth = (r4*215);
	 }
	 if(t4 == 0){
		 newwidth = 215;
	 }
	 $('#chatarea').css('min-width',newwidth+'px');
	if(current_div == 1 || current_div > 1){
		$('#chatarea').children('.chatarea-inner').removeClass('one-inner');
		$('#chatarea').removeClass('chatarea-wrapper-main');
	}
	//add the chat area
 $('#joinmetting_'+roomname).hide(); //hiding the chat join button.
 var chatwindowCount = $("#chatarea div:visible").length;
	 
	 roomArray.push(roomname);
	 var roomLength = roomArray.length;
	 if(current_div>=maxChatWnd){
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
		}
		//code for pause
			
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
			
		$('#par_'+roomArray[i]).hide();
		if(roomArray[i]!=undefined){
		$('#active_chats ul').append("<li class='prq' id='li_"+roomArray[i]+"' style='cursor:pointer;' ><span>Group Name "+roomArray[i]+"&nbsp;&nbsp;&nbsp;&nbsp;<input type='image' onclick=reOpenChat('"+roomArray[i]+"') src='"+site_url1+"img/gpchat.png'></span></li>");
		}
		i = i+1;
		
	 }
	 
	var url = site_url1+"meetings/meetingChat/" + id;
	var html = '<div id="par_'+roomname+'" style="float:left;margin-right: 11px;" class="chatarea-inner"><div class="chatarea" id="chatwindow'+roomname+'" style="float:left;"><iframe id="iframe_' + roomname + '" src="' + url + '" width="200" height="340" scrolling="no" frameBorder="0"></iframe></div><div class="chatwindowMax" id="chatwindowMax'+roomname+'" style="display:none;">Max</div></div>';
	$('#chatarea').append(html);
	var current_div1 = $('#chatarea').children('.chatarea-inner').length;
	if(current_div1 == 1){
		$('#chatarea').children('.chatarea-inner').addClass('one-inner');
		$('#chatarea').addClass('chatarea-wrapper-main');
	}
	$('#rd'+id).hide();
	});
}
/*
 * Showing the chat meeting div
 */
function showChatMeetingDiv()
{

	if( $('#meeting_area').is(':visible') ){
		$('#meeting_area-wrapper .slimScrollDiv').animate({height: "0px"}, 500);}
	else
		$('#meeting_area-wrapper .slimScrollDiv').animate({height: "150px"}, 500);
	$('#meeting_area').toggle('slow',function(){
		showhidetogglearea('meeting_area', 'chat_meetings_max', 'chat_meetings_min'); //function is calling for hiding the other divs if those are opened, defined in groupchat.js
		//check for clicked button
		if ( $('#chat_meetings_max').is(':visible') ){
			list_meetings();
			$('#meeting_area').slimscroll({
				  height: '150px'
			});		
			
			$('#chat_meetings_max').hide();
			$('#chat_meetings_min').show();
//above two lines added here from below ajax call
			//perform ajax request and mark the notification as read
//			$.ajax({
//				type : "POST",
//				url : site_url1+"meetings/markNotificationAsRead",
//				data : {}
//			}).done(function(msg) {
//			$('#chat_meetings_max').hide();
//			$('#chat_meetings_min').show();
//			});
			///changed above ajax call and paste
		}
		else if( $('#chat_meetings_min').is(':visible') ){
			    $('#meeting_area').empty();
				$('#chat_meetings_min').hide();
				$('#chat_meetings_max').show();
		}
		$('#list-meetings').toggle();
	});	
}
/**
 * accepting the meeting invitation.
 * @param id
 * @param room_name
 */
function acceptMeetingInvitaion(id, room_name)
{
	$.ajax( {
		type : "POST",
		url : site_url1+"meetings/acceptInvitation",
		data : {
			id: id,
			roomName: room_name
		}
	}).done(function(msg) {
		$('#meetingaction_'+id).hide();
	});
}
/**
 * denying the meeting invitation.
 * @param id
 * @param room_name
 */
function rejectMeetingInvitaion(id)
{
	$.ajax( {
		type : "POST",
		url : site_url1+"meetings/rejectInvitation",
		data : {
			id: id
		}
	}).done(function(msg) {
		$('#meeting_'+id).hide();
	});
}
/**
 * Showing/Hiding the chat meeting detail.
 */
function detailMeeting(id)
{
 $('#below_meeting_detail_'+id).toggle();
}
/*
*code end by yogendra
*/
/**
 *Show hide meeting tab
 */
function planMetting(){
	$('.friends_list').hide();
	$('.upper-area').hide();
	$('#activeChatTab').hide();
	$('.meeting-panel').toggle();
	if ( $('.meeting-panel').is(':visible') ){
		  $('#meet-active').show();
		  $('#meet-lazy').hide();
		  $('#notf-active').hide();
		  $('#notf-lazy').show();
		  $('#jact-active').hide();
		  $('#jact-lazy').show();
		 $('#tab-msg').html('<h3>Plan Meeting</h3>');
		
	}else{
		 $('#meet-active').hide();
		 $('#meet-lazy').show();
		$('.friends_list').show();
		 $('#tab-msg').html('<h3>Who is Online</h3>');
	}
}
/**
 * Method to get Meeting requests count
 * @return
 */
function getMeetingRequestsCount(){
	$.ajax({
		type : "POST",
		url : site_url1+"meetings/getMeetingRequestsCount",
		data : {}
	}).done(function(msg) {
		var t = JSON.parse(msg);
		var msgCount = t['count'];
		var isAlert = t['showAlert'];
		
		newMeetGbValue = msgCount;
		updatedGbValue = newPendGbValue + newReqGbValue + newNotfGbValue + newMeetGbValue;
		if (updatedGbValue != 0) {
			$('#globalNotify').show();
		$('#globalNotify').html(updatedGbValue);
		} else
			$('#globalNotify').hide();
			
		if(msgCount=="0"){
			$('#chat_meetings_count').hide();
		}else{
			
		$('#chat_meetings_count').show();
		$('#chat_meetings_count').html(msgCount);
		}
		if(isAlert == 1){
			$.msgBox({
			    title:"Alert",
			    content:'New Meeting Notification'
			});
		}
	});
}
/**
 * Method to leave user from chatroom
 * 
 * @param roomName
 * @return
 */
function leaveMeetingRoom(roomName) {

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
	var current_div2 = $('#chatarea', window.parent.document).children(
			'.chatarea-inner:visible').length;
	if (current_div2 == 1) {
		$('#chatarea', window.parent.document).children('.chatarea-inner')
				.addClass('one-inner');
		$('#chatarea', window.parent.document)
				.addClass('chatarea-wrapper-main');
	}
	if (current_div2 == 0) {
		$('.right-area', window.parent.document).hide();
	}
	// $('#par_'+roomName, window.parent.document).remove();
	var index = parent.roomArray.indexOf(roomName);

	if (index > -1) {
		parent.roomArray.splice(index, 1);
	}

	$.ajax({
		type : "POST",
		url : site_url1 + "meetings/leaveRoom",
		data : {
			roomName : roomName
		}
	}).done(function(msg) {
		// hide the div
		if (msg == "true") {

			$('#chatwindow' + roomName, window.parent.document).hide();

		}
	});
	$('#joinmetting_' + roomName, window.parent.document).show(); // showing the chat join button.

}