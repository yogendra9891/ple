
//js for forum

/**
 * Show and hide the comment box
 * @param id
 */
function showReplyBox(id) {
	$('#reply-comment_' + id).toggle();
	//$('.reply-comment').hide();
}

/**
 * Show PopUp
 */
$(function() {
	$("#dialog").dialog({
		autoOpen : false,
		show : {
			effect : "blind",
			duration : 1000
		},
		hide : {
			effect : "explode",
			duration : 1000
		}
	});

	$("#opener").click(function() {
		$("#dialog").dialog("open");
	});
});

/**
 * Show the post preview popUp
 * @return
 */
function ShowPostPreview(id) {
	var text = $('.qreplybox' + id).val();
	$("#dialog").html(text);
	$("#dialog").dialog({
		width : 500
	});
	$("#dialog").dialog({
		height : 300
	});
	$("#dialog").dialog("open");
}

/**
 * Show the reply preview popUp
 * @return
 */
function ShowReplyPreview(id) {
	var text = $('.replybox' + id).val();
	$("#dialog").html(text);
	$("#dialog").dialog({
		width : 500
	});
	$("#dialog").dialog({
		height : 300
	});
	$("#dialog").dialog("open");
}
/**
 * Show and Hide the comment box.
 * @return
 */

function showEditQuesBox() {
	$('#questionDiv').toggle();
	$('#editPostDiv').toggle();
}

/**
 * Show confirm box;
 * @return
 */
function showDeleteConfirmAlert() {
	var send = false;
	var r = confirm("Are you sure!!");
	if (r == true) {
		return true;
	} else {
		return false;
	}
	//	$.msgBox({
	//		title:"Are You Sure",
	//		content: "Would you like a cup of coffee?",
	//		type: "confirm",
	//		buttons: [{ value: "Yes" }, { value: "No" }, { value: "Cancel"}],
	//		success: function (result) {
	//		if (result == "Yes") {
	//			processResult(true);
	//		 }
	//		 }
	//		});
	//	      alert(send);
	//		 return send;
}

/**
 * Date Picker
 */
$(function() {
	$("#datepicker").datepicker({
		changeMonth : true,
		changeYear : true
	});
	$("#datepicker2").datepicker({
		changeMonth : true,
		changeYear : true
	});
});
/**
 * Show and hide the filter box;
 * @return
 */
function showHideFilterBox(site_url,contentPageId) {

	title = $('#show_hide_search_image').attr('title');
	if (title == 'show search area') {
		$('#show_hide_search_image').attr('src', site_url + 'img/minus.png');
		$('#show_hide_search_image').attr('title', 'hide search area');
	} else {
		$('#show_hide_search_image').attr('src', site_url + 'img/plus.png');
		$('#show_hide_search_image').attr('title', 'show search area');
	}
	var url = site_url+"forums/forumFilter/"+contentPageId;
	var iframearea = "<iframe id='iframe4' src='"+url+"'  name='iframeFilter' width='900' height='700'></iframe>";
	//check if iframe open
	if(!$("#iframe4").length) {
		$('#forumDetailArea').html(iframearea);
		
			//$("#iframe4").contents().find("#w-ques-inner").hide();
			//$("#iframe4").contents().find(".search-results-area").hide();
			//$("#iframe4").contents().find("#w-filter-inner").show();

	}
	
	$("#iframe4").contents().find("#w-ques-inner").hide();
	$("#iframe4").contents().find(".search-results-area").hide();
	$("#iframe4").contents().find("#no-result").hide();
	$("#iframe4").contents().find("#w-filter-inner").show();
}
/**
 * Show and hide the Question box;
 * @return
 */
function showHideQuesBox(site_url,contentPageId) {
	title = $('#show_hide_question_image').attr('title');
	if (title == 'show question area') {
		$('#show_hide_question_image').attr('src', site_url + 'img/minus.png');
		$('#show_hide_question_image').attr('title', 'hide question area');
	} else {
		$('#show_hide_question_image').attr('src', site_url + 'img/plus.png');
		$('#show_hide_question_image').attr('title', 'show question area');
	}
	var url = site_url+"/forums/forumFilter/"+contentPageId;
	var iframearea = "<iframe id='iframe4' src='"+url+"' width='900' height='700'></iframe>";
	//check if iframe open
	if(!$("#iframe4").length) {
		$('#forumDetailArea').html(iframearea);
	}
	
	$("#iframe4").contents().find("#w-filter-inner").hide();
	$("#iframe4").contents().find(".search-results-area").hide();
	$("#iframe4").contents().find("#no-result").hide();
	$("#iframe4").contents().find("#w-ques-inner").show();

}

//show dialog window
/**
 * Show the preview window
 */
function ShowPostPreview(id) {
	var sid = 'quest' + id;
	var content = CKEDITOR.instances[sid].getData();

	$("#dialog").html(content);
	$("#dialog").dialog({
		width : 500
	});
	$("#dialog").dialog({
		height : 300
	});
	$("#dialog").dialog("open");
}
/**
 * Show the preview window
 */
function ShowReplyPreview(id) {
	//delete CKEDITOR;

	var rsid = 'rep' + id;
	var content = CKEDITOR.instances[rsid].getData();

	$("#dialog").html(content);
	$("#dialog").dialog({
		width : 500
	});
	$("#dialog").dialog({
		height : 300
	});
	$("#dialog").dialog("open");
}
/**
 * Show the preview window
 */
function ShowReplyPreview1(id) {

	var rsid = 'rep1' + id;
	var content = CKEDITOR.instances[rsid].getData();

	$("#dialog").html(content);
	$("#dialog").dialog({
		width : 500
	});
	$("#dialog").dialog({
		height : 300
	});
	$("#dialog").dialog("open");
}
/**
 * Show the preview window
 */
function ShowReplyPreview2(id) {

	var rsid = 'rep2' + id;
	var content = CKEDITOR.instances[rsid].getData();

	$("#dialog").html(content);
	$("#dialog").dialog({
		width : 500
	});
	$("#dialog").dialog({
		height : 300
	});
	$("#dialog").dialog("open");
}
/**
 * Show the preview window
 */
function ShowEditPostPreview(id) {

	//var rsid = 'editqst'+id;
	var content = CKEDITOR.instances['ForumEditComment'].getData();

	$("#dialog").html(content);
	$("#dialog").dialog({
		width : 500
	});
	$("#dialog").dialog({
		height : 300
	});
	$("#dialog").dialog("open");
}
/**
 * End of dialog window
 */
/**
 * Validation
 */
/**
 * Validation for content
 * content can not be empty
 */
function checkValidation(id) {
	var sid = 'quest' + id;
	var content = CKEDITOR.instances[sid].getData();
	var data = content.replace(/<\/?([a-z][a-z0-9]*)\b[^>]*>?/gi, '');
	var contentData = ($('<div/>').html(data).text()).trim();
	if (contentData == "") {
		$('#cke_quest' + id).addClass('content-error');
		$('#reply1').html('*Comment required');
		return false;
	}
	$('#loader', window.parent.document).show();
}
/**
 * Validation for content
 * content can not be empty
 */
function checkValidation1(id) {
	var sid = 'rep' + id;
	var content = CKEDITOR.instances[sid].getData();
	var data = content.replace(/<\/?([a-z][a-z0-9]*)\b[^>]*>?/gi, '');
	var contentData = ($('<div/>').html(data).text()).trim();
	if (contentData == "") {
		$('#cke_rep' + id).addClass('content-error');
		$('#reply2' + id).html('*Comment required');
		return false;
	}
	$('#loader', window.parent.document).show();
}
/**
 * Validation for content
 * content can not be empty
 */
function checkValidation2(id) {
	var sid = 'rep1' + id;
	var content = CKEDITOR.instances[sid].getData();
	var data = content.replace(/<\/?([a-z][a-z0-9]*)\b[^>]*>?/gi, '');
	var contentData = ($('<div/>').html(data).text()).trim();
	if (contentData == "") {
		$('#cke_rep1' + id).addClass('content-error');
		$('#reply3' + id).html('*Comment required');
		return false;
	}
	$('#loader', window.parent.document).show();
}
/**
 * Validation for content
 * content can not be empty
 */
function checkValidation3(id) {
	var sid = 'rep2' + id;
	var content = CKEDITOR.instances[sid].getData();
	var data = content.replace(/<\/?([a-z][a-z0-9]*)\b[^>]*>?/gi, '');
	var contentData = ($('<div/>').html(data).text()).trim();
	if (contentData == "") {
		$('#cke_rep2' + id).addClass('content-error');
		$('#reply4' + id).html('*Comment required');
		return false;
	}
	$('#loader', window.parent.document).show();
}
/**
 * Validation for content
 * content can not be empty
 */
function checkEditQuestValidation(){
    var contentCheck;
    var subCheck;
    var subcontent = $('#editsubject').val();
    var subData = ($('<div/>').html(subcontent).text()).trim();
   
    if(subData==""){
            var subCheck = 0;
            $('#editsubject').addClass('content-error');
            $('#editsubjectMsg').html('*Subject required');
    }else{
            var subCheck = 1;
            $('#editsubject').removeClass('content-error');
            $('#editsubjectMsg').html('');
    }
    var content = CKEDITOR.instances['ForumEditComment'].getData();
    var data = content.replace(/<\/?([a-z][a-z0-9])\b[^>]>?/gi, '');
    var contentData = ($('<div/>').html(data).text()).trim();
    if(contentData==""){
            var contentCheck = 0;
            $('#cke_ForumEditComment').addClass('content-error');
            $('#editcommentMsg').html('*Comment required');
    }else{
            var contentCheck = 1;
            $('#cke_ForumEditComment').removeClass('content-error');
            $('#editcommentMsg').html('');
    }

    if(subCheck && contentCheck){
	$('#loader', window.parent.document).show();
return true;
    }
    return false;
}
/*
 * checking the post subject and body is not blank.
 */
function checkAskValidation(){
	var variable = 0;
	var variable1 = 0;
	var subjectData = $('#subject').val().trim();
	if(subjectData == ""){
		$('#subject').addClass('content-error');
		$('#subject-error-msg').html('*Subject required');
		variable = 0;
		}else{
			$('#subject').removeClass('content-error');
			$('#subject-error-msg').html('');
			variable = 1;
		}
	var content = CKEDITOR.instances["content"].getData();
	var data = content.replace(/<\/?([a-z][a-z0-9]*)\b[^>]*>?/gi, '');
	var contentData = ($('<div/>').html(data).text()).trim();
	if (contentData == "") {
		$('#cke_content').addClass('content-error');
		$('#content-error-msg').html('*Comment required');
		variable1 = 0;
	}else{
		$('#cke_content').removeClass('content-error');
		$('#content-error-msg').html('');
		variable1 = 1;
	}
	if(variable && variable1){
		$('#loader', window.parent.document).show();
		return true;
		}
	    return false;

}
/**
 * End of validation
 */
 /**
  *Set url for image upload
  */
 function setCkUrl(url){
var dialog = CKEDITOR.dialog.getCurrent();
dialog.setValueOf('info','txtUrl',url);
return false;
}

function notificationTab(){
alert('djdkj');
}

/*
 * code start written by yogendra..
 */
/**
 * function for pin/unpin a post
 */
function pinunpinpost(site_base_url, current_id, title) {

	var question = current_id.split('_');
	var question_id = question[1];
	if (title == 'pin post') {
		title1 = 'unpin post';
		img = site_base_url + 'img/unpin.png';
	} else {
		title1 = 'pin post';
		img = site_base_url + 'img/pin.png';
	}
	$.ajax({
		type : "POST",
		url : site_base_url + "forums/pinunpinQuestion",
		data : {
			question_id : question_id,
			title : title
		}
	}).done(function(msg) {
		$('#' + current_id).attr('title', title1);
		$('#' + current_id).attr('src', img);
		$('#comments').each(function() {
			var element_id = $(this).attr('id');
			$('#' + element_id + ' li').removeClass('backgroud_work');
		});
		$('#qid_' + question_id).addClass('backgroud_work');
	});
}
/**
 * function for flag/unflag a post
 */
function flagunflagpost(site_base_url, current_id, title) {
	var question = current_id.split('_');
	var question_id = question[1];
	if (title == 'flag post') {
		title1 = 'unflag post';
		img1 = site_base_url + 'img/unflag.png';
	} else {
		title1 = 'flag post';
		img1 = site_base_url + 'img/flag.png';
	}
	$.ajax({
		type : "POST",
		url : site_base_url + "forums/flagunflagQuestion",
		data : {
			question_id : question_id,
			title : title
		}
	}).done(function(msg) {
		$('#' + current_id).attr('title', title1);
		$('#' + current_id).attr('src', img1);
		$('#comments').each(function() {
			var element_id = $(this).attr('id');
			$('#' + element_id + ' li').removeClass('backgroud_work');
		});
		$('#qid_' + question_id).addClass('backgroud_work');
	});
}
/**
 * function for publish a post
 */
function publishpost(site_base_url, current_id,contentpageid) {
	var question = current_id.split('_');
	var question_id = question[1];
	$('#' + current_id).hide();
	$.ajax({
		type : "POST",
		url : site_base_url + "forums/publishPost",
		data : {
			question_id : question_id,
			contentpage_id: contentpageid
		}
	}).done(function(msg) {
		$('#comments').each(function() {
			var element_id = $(this).attr('id');
			$('#' + element_id + ' li').removeClass('backgroud_work');
		});
		$('#qid_' + question_id).addClass('backgroud_work');
		$('#' + current_id).hide();
	});
}
/*
 *function for showing the filter area 
 */
function opensearcharea(param, siteurl) {
	if (param == 'open') {
		$('#w-filter-inner').show();
		$('#w-ques-inner').hide();
		$('#show_hide_search_image').attr('title', 'hide search area');
		$('#show_hide_search_image').attr('src', siteurl + 'img/minus.png');
	}
}

/*
 * function for showing the question preview.
 */
function ShowQuestionPreview() {
	var htmldata = $(".cke_wysiwyg_frame").contents().find("body").html();
	$("#dialog1").html(htmldata);
	$("#dialog1").dialog({
		autoOpen: true,
		width : 550,
		height : 340,
		position: 'center',
		 hide: {
		 effect: "explode",
		 duration: 1000
		 }
	});
	
	if ($(this).is(":visible")) {
		
		} else {
	 $("#dialog1").dialog("open");
		}
	$('.ui-dialog').css('position', 'absolute');
	$('.ui-dialog').css('min-height', '300px');
	$('#dialog1').css('height', '250px');
	$('#dialog1').css('min-height', '50%');
	$('#dialog1').css('overflow-y', 'scroll');
	$('.ui-dialog').css('top', '20%');
}

/*
 * code end written by yogendra..
 */

/*
 *New Forum Js
 */
function showForumDetail(site_url, forumId,conId){
	//var $url = forumId/conIdp;
	$('.cmmnt-ask').css('background-color','#ffffff');
	$('#qid_'+forumId).css('background-color','#e5e3e3');
	var site_url1 = site_url;
	var url = site_url1+"forums/replyQuestion/" + forumId + "/" + conId;
	var iframearea = "<iframe src='"+url+"' width='900' height='700'></iframe>";
	//$('.right-area').parent().html(iframearea);
	$('#w-ques-inner', window.parent.document).hide();
	$('#w-filter-inner', window.parent.document).hide();
	$('#forumDetailArea', window.parent.document).show();
	$('#flashMessage', window.parent.document).hide();
    $('#forumDetailArea', window.parent.document).removeClass('forumDetailClass');	
	$('#forumDetailArea', window.parent.document).html(iframearea);	
}

function showForumDetail2(site_url,forumId,conId){
$('.cmmnt-ask').css('background-color','#ffffff');
	$('#qid_'+forumId).css('background-color','#e5e3e3')
	//var $url = forumId/conIdp;
	var site_url1 = site_url;
	var url = site_url1+"forums/replyQuestion/" + forumId + "/" + conId;
	var iframearea = "<iframe src='"+url+"' width='900' height='700'></iframe>";
	//$('.right-area').parent().html(iframearea);
	$('#w-ques-inner').hide();
	$('#w-filter-inner').hide();
	$('#forumDetailArea').show();	
	$('#flashMessage', window.parent.document).hide();
	$('#forumDetailArea').removeClass('forumDetailClass');
	$('#forumDetailArea').html(iframearea);	
}
/*
*Marking the replies read/unread
*/
function markGlobalRread(site_base_url, currentreply_id, title)
{
	var question = currentreply_id.split('_');
	var question_id = question[1];
//	if (title == 'mark all replies as read') {
//		title1 = 'mark all replies as unread';
//		img1 = site_base_url + 'img/unread.png';
//	} else {
//		title1 = 'mark all replies as read';
//		img1 = site_base_url + 'img/read.png';
//	}
	$.ajax({
		type : "POST",
		url : site_base_url + "forums/markReadUnreadReply",
		data : {
				question_id : question_id,
				title : title
			}
		}).done(function(msg) {
		//	$('#' + currentreply_id).attr('title', title1);
		//	$('#' + currentreply_id).attr('src', img1);
			$('#' + currentreply_id).hide();
			$('.mark-read-reply').hide();
			$('.mark-readconfirmation').show();
			$('#iframe1', window.parent.document).contents().find("#unread_count_"+question_id).hide();
		});
}
/**
 * Mark read a reply
 */
function readComment(site_url, question_id, comment_id, content_id)
{
	$.ajax({
		type : "POST",
		url : site_url+"forums/markReadComment",
		data : {
			comment_id : comment_id,
			question_id: question_id,
			content_id: content_id
		}
	}).done(function(msg) {
		var t = JSON.parse(msg);
		var unreadReplyCount = t['unread_count'];
		var isMessage = t['message'];
		if(isMessage == 'true'){
			$('#reply_read_'+comment_id).hide();
			if(unreadReplyCount == '0')
			 $('#markreadreplies_'+question_id).hide();	
			 			//marking one less from the current unread count..
			var tt = parseInt($('#iframe1', window.parent.document).contents().find("#unread_count_"+question_id).html());
			if(tt>1){
				var y = tt-1;
				$('#iframe1', window.parent.document).contents().find("#unread_count_"+question_id).html(y);}
			else
				$('#iframe1', window.parent.document).contents().find("#unread_count_"+question_id).hide();	
		}
	});
}
/**
 * Mark draft comment as published
 */
function publishComment(cmtid,qid,site_urll,contId){
$('#cmtdraftId'+cmtid).hide();
$('#replyLink-'+cmtid).show();
	$.ajax({
		type : "POST",
		url : site_urll+"forums/publishComment",
		data : {
			comment_id : cmtid,
			qid        : qid,
			contentPageId : contId
		}
	}).done(function(msg) {
		$('#cmtdraftId'+cmtid).hide();
		
	});
}
/**
 * Save the edited comment through ajax
 */
function saveReplyAjax(qid,cmtid){
    $('#reply_'+cmtid).hide();
	$('#edit-reply-comment_'+cmtid).toggle();
	$('#comment-body_'+cmtid).toggle();
}

/**
 * toggle the edit icon last comment
 */
function editReplyToggle(qid,cmtid){
	$('#save_'+cmtid).hide();
	$('#edit-reply-comment_'+cmtid).toggle();
	$('#comment-body_'+cmtid).toggle();
}
/**
 *save draft comment
 */
function saveDraftAjax(site_url, cmtid){
	var sid = 'edit-cmt-' + cmtid;
	var content = CKEDITOR.instances[sid].getData();
	$.ajax({
		type : "POST",
		url : site_url+"forums/editComment",
		data : {
			comment_id : cmtid,
			content : content
		}
	}).done(function(msg) {
		$('#pubdateId-'+cmtid).html(msg);
		$('#edit-reply-comment_'+cmtid).hide();
		$('#comment-body_'+cmtid).show();
		$('#comment-body_'+cmtid).html(content);
	});
}
/**
 * Show the preview window
 */
function ShowEditReplyPreview(id) {

	var rsid = 'edit-cmt-' + id;
	var content = CKEDITOR.instances[rsid].getData();

	$("#dialog").html(content);
	$("#dialog").dialog({
		width : 500
	});
	$("#dialog").dialog({
		height : 300
	});
	$("#dialog").dialog("open");
}
/**
 * Search the result
 */
function searchAll(site_url){
//get contentPageId
	var conId = $('#globalContId').val();
//get search value
	var searchData =  $('#forumSearchText').val();
	//encode search data
	var encodSearchData = encodeURIComponent(searchData);
//generate query string
	var queryString = "forums/searchAll?searchData="+encodSearchData+"&submit=Search&contId="+conId;
	var url = site_url+"/"+queryString;
	var iframearea = "<iframe id='iframe4' src='"+url+"' width='900' height='700'></iframe>";
	//check if iframe open
	$('#forumDetailArea').html(iframearea);
	
}

/**
 * Publish the comment after editing it
 * @param int 
 */
function publishReplyComment(cmtid,qid,site_urll,contId){
	var sid = 'edit-cmt-' + cmtid;
	var content = CKEDITOR.instances[sid].getData();
	$.ajax({
		type : "POST",
		url : site_urll+"forums/publishReplyComment",
		data : {
			comment_id : cmtid,
			qid        : qid,
			contentPageId : contId,
			content : content
		}
	}).done(function(msg) {
		$('#pubdateId-'+cmtid).html(msg);
		$('#edit-reply-comment_'+cmtid).hide();
		$('#comment-body_'+cmtid).show();
		$('#comment-body_'+cmtid).html(content);
		
	});
}

/**
 * show subscribe loader
 */
function showSubscribeLoader(){
	$('#subid').hide();
	$('#subscribe_loader').show();
}