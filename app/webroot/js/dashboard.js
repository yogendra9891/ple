/*
 * function for showing it before the result in Forum setting
 */
function before(id){
	//$(id).html('saving...');
	$('#loadererr').hide();
	$('#loader').show();
}

/*
 * function for showing it before the result in Forum setting
 */
function complete(id){
	//$(id).html('saved.');
	$('#loader').hide();
	$('#loadererr').show();
	$('#loadererr').html('Community setting saved successfully.');
	$('#loadererr').delay(3000).fadeOut();
}

/*
 * on twiiter save success
 */
function twitterComplete(data, id)
{
	//$(id).html(data);
	if(data != '') {
	$('#loader').hide();
	$('#loadererr').show();
	$('#loadererr').html(data);
	} else {
		location.reload();
	}
}

/*
 * Showing the saving message before rendering the saved message
 */
function beforeSaveDate(id){
	$('#messagecontent_'+id).html('saving...');
}

/*
 * Showing the success
 */
function completeDateSave(id)
{
	$('#messagecontent_'+id).show();
}

/**
 * Js start for Accordian content page ids.
 */
$("html").addClass("js");
$.fn.accordion.defaults.container = false; 

$(document).ready(function(){
	//we have done it with a common class name, but we have to make different ids of element of accordian-common classes
	  $(".accordian-common").accordion({
	      el: ".h",
	      head: "h4, h5",
	      next: "div",
	      initShow : ""
	  });
	  $(".accordian-common-module").accordion({
	      el: ".h",
	      head: "h4, h5",
	      next: "div",
	      initShow : ""
	  });
	  $(".accordian-common-forum-setting").accordion({
	      el: ".h",
	      head: "h4, h5",
	      next: "div",
	      initShow : "div.outer:eq(0)"
	  });
	  $(".accordian-common-commonsetting").accordion({
	      el: ".h",
	      head: "h4, h5",
	      next: "div",
	      initShow : "div.outer:eq(0)"
	  });
  $("html").removeClass("js");

	/**
	 * Js end for Accordian content page ids.
	 */
	$(".startdatefield").datepicker({showOn: 'button', 
		                   changeMonth : true,
		                   changeYear : true,
                           minDate: new Date(),
						   buttonImage: site_url1+'img/calendar_icon.png', 
						   buttonImageOnly: true,
						   onSelect: allCrossImageClassStart
						 });
	
	//display Calendar
	$(".enddatefield").datepicker({showOn: 'button', 
			                 changeMonth : true,
                             changeYear : true,
	                         minDate: new Date(),
							 buttonImage: site_url1+'img/calendar_icon.png', 
							 buttonImageOnly: true,
							 beforeShow: function() {
							 var cid = $(this).attr('id');
							 var t = cid.split('_');
							 var d = $("#"+t[0]+"_startdate_"+t[2]).datepicker('getDate');
							 var y = $.trim(d);
							  if (y) {return {minDate: d, maxDate: '+100000'} }
							  else { $.msgBox({
								    title:"Alert",
								    content: 'Select start date first.'
								}); return {minDate: '+1', maxDate: '-1'} }
							},
							   onSelect: allCrossImageClassEnd
				      });
	
	//Js for showing and hiding the cross icon on date picker input field..
	jQuery(function($) {
		
		  function tog(v){return v?'addClass':'removeClass';} 
		  
		  //mouse enter event..
		  $(document).on('mouseenter', '.clearable', function(){
		     $(this)[tog(this.value)]('x');
		  }).on('mousemove', '.x', function( e ){
		    $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX'); //add event of clickable  
		  }).on('click', '.onX', function(){
		     $(this).removeClass('x onX').val('');
		     var t = $(this).attr('id').toString();
		     callEnddateBlank(t); //function calling for make end adet blank.
		  });

	});
	//code for adding the clear image if a date is exists in the date field.
	 	if ($('.clearable').length > 0) {
	 		$('.clearable').each(function(){
		 	if ($(this).val() != "")
		       $(this).addClass('x');
		 	});
	 	  }
	 	
	//showing/hiding the claendar area(Question setting tab).. 
	$('.editdatesetting').click(function(){
		var element_id = $(this).attr('id');
		var content_page_array = element_id.split('_');
		var content_id = content_page_array[1];
		//code for showing/hiding the posts setting area
		$('#poststartdateinput_'+content_id).toggle();
		$('#postenddateinput_'+content_id).toggle();
		$('#poststartdatelabel_'+content_id).toggle();
		$('#postenddatelabel_'+content_id).toggle();
		
		//code for showing/hiding the posts setting area
		$('#replystartenddateinput_'+content_id).toggle();
		$('#replystartenddatelabel_'+content_id).toggle();
		
		//code for showing/hiding the posts setting area
		$('#readonlystartenddateinput_'+content_id).toggle();
		$('#readonlystartenddatelabel_'+content_id).toggle();
		
		//Showing save button
		$('#submit_'+content_id).toggle();
		if ($('#messagecontent_'+content_id).html())
			$('#messagecontent_'+content_id).hide();
	});
	
      //submit the form on change radio button
//	   $('input[name=post-active-area]').change(function(){
//	        $('#unreadposts').submit();
//	   });
	 //submit the form on change select dropdown
	   $('#dashboards').change(function(){
	        $('#unreadposts').submit();
	   });
	   //hiding the flash message after specified time.
	   $('#flashMessage').delay(3000).fadeOut();
	   
});

/**
 * adding the cross image id date is exists for start date
 * @param datetext
 */
function allCrossImageClassStart(datetext) {
	if ($(this).val() != "")
	  $(this).addClass('x');
	var id = $(this).attr('id');
	var split_id = id.split('_');
	var unique_field_value = $('#'+split_id[0]+'_'+split_id[1]+'-hidden_'+split_id[2]).val();
	var current_flag = '0';
	var current_flag = $('#'+split_id[0]+'-flag_'+split_id[2]).val(); //getting current flag value
	if (unique_field_value != datetext) { //checking a user making changes in a date
	   $('#'+split_id[0]+'-flag_'+split_id[2]).val('1'); //set flag value
	 } else if ((unique_field_value == datetext) && (current_flag == '1')) {
		 $('#'+split_id[0]+'-flag_'+split_id[2]).val('0'); //set flag value
	 }
}

/**
 * adding the cross image id date is exists for end date
 * @param datetext
 */
function allCrossImageClassEnd(datetext) {
	 if ($(this).val() != "")
	   $(this).addClass('x');
	 var id = $(this).attr('id');
	 var split_id = id.split('_');
	 var unique_field_value = $('#'+split_id[0]+'_'+split_id[1]+'-hidden_'+split_id[2]).val();
	 var current_flag = '0';
	 var current_flag = $('#'+split_id[0]+'-flag_'+split_id[2]).val(); //getting current flag value
	 if (unique_field_value != datetext) { //checking a user making changes in a date
	   $('#'+split_id[0]+'-flag_'+split_id[2]).val('1'); //set flag value
	 } else if ((unique_field_value == datetext) && (current_flag == '1')) {
		 $('#'+split_id[0]+'-flag_'+split_id[2]).val('0'); //set flag value
	 }
}
/**
 * removing the end date also if start date is bank
 * @param datetext
 */
function callEnddateBlank(id)
{
	 var t = id.split('_');
	 var d = $("#"+t[0]+"_enddate_"+t[2]).removeClass('x onX').val('');;
}

/**
 * Show and hide the edit for notification
 */
function enableOption(copydivId, orgdivId, linkId ){

	$('#'+copydivId).toggle();
	$('#'+orgdivId).toggle();
	$('#'+linkId).toggleClass('activelink');
	//calling the function of ZeroClipboard js for repositioning the copy link
	//create client
	var clip = new ZeroClipboard.Client();
	clip.reposition('feedreader_link');
	clip.reposition_assignments('feedreader_link_assignments');
}

/**
 * enabling the feed reader text field
 */
function enableFeedOption()
{
	$('#feed-reader').toggle();
	$('#feedreader_link').toggleClass('activelink');
	$('#feed-reader-label').toggle();
	$('#feed-notify-message').toggle();
}

/**
 * set date picker
 */
$(function() {
	$(".asst-datepicker").datepicker({
		showOn: 'button', 
		changeMonth : true,
		changeYear : true,
		buttonImage: site_url1+'img/calendar_icon.png', 
        buttonImageOnly: true,
		beforeShow: function() {
        	var cid = $(this).attr('id');
        	var t = cid.split('-');
        	var oDate = $('#adate2-'+t[1]).val();
			if(oDate == "01/01/1970")
        	return {minDate: new Date()}
			
        	return {minDate: new Date(), maxDate: new Date(oDate)}
        	}
	});
	
});

/**
 * Clear assignment setting form
 * return boolean
 */
function clearAssignmentSetting(){
	//show confirm box
	$.msgBox({
				title:"Are You Sure",
				content: "Clear your assignment reminder settings !!",
				type: "confirm",
				buttons: [{ value: "Yes" }, { value: "No" }, { value: "Cancel"}],
				success: function (result) {
				if (result == "Yes") {
					$('.asst-chkbox').prop('checked', false);
					$('.asst-datepicker').val('');
					$('.locked-reminder-date').html('mm/dd/yy');
					$('#assignment_setting_form').submit(); //submit the form if condition is true
				 }
				 }
				});
	return false;
}

/**
 * Adding the Iframe on a post click
 * @param site_url
 * @param id
 * @param content_page
 */
function forumDetail(site_url, id, content_page)
{
	var url = site_url+"forums/replyQuestion/"+id+"/"+content_page;
	var iframearea = "<iframe src='"+url+"' width='900' height='700'></iframe>";
	$('#forumDetailArea').html(iframearea);
}

/**
 * Clear ask a question setting form
 * return boolean
 */
function clearAskQuestionSetting(){
	//show confirm box
	$.msgBox({
				title:"Are You Sure",
				content: "Clear Ask a question reminder settings !!",
				type: "confirm",
				buttons: [{ value: "Yes" }, { value: "No" }, { value: "Cancel"}],
				success: function (result) {
				if (result == "Yes") {
					$('#clear-field').val('clear');
					$('#savecontent-askquestion').submit(); //submit the form if condition is true
				 }
				 }
				});
	return false;
}