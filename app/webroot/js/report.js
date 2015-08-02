var report = {
		on_test: function (iq) {
			
		}
		
};
$("html").addClass("js");
$.fn.accordion.defaults.container = false; 
$(function() {
    //getting the course name by term name onchange event(current online logs)
	$('#current-termlist').change(function(){
		var url = site_url1 + 'chatreports/getCoursesNameByTerm';
		var term_name = $(this).val();
	    $.ajax({
	            type  : 'POST',
	            url   : url,
	            data  : {term: term_name},
	            async : true,
	            success : function(res) {
	            	$('#current-courselist').html(res);
	            }
	    });
	});




//Abhishek

$('.datefilter').click(function(){
	var value = $(this).attr('value');

	//check for date selection
	if(value == "1"){
		$('#dateonly').hide();
		$('#daterange').hide();
		$('#datetime').show();
		
	}if(value == "2"){
		$('#datetime').hide();
		$('#daterange').hide();
		$('#dateonly').show();
		
	}if(value == "3"){
		$('#dateonly').hide();
		$('#datetime').hide();
		$('#daterange').show();
	}
	
});

/**
 * Date Picker
 */
$('#datepicker-time').datetimepicker({
    hours12: false,
    format: 'Y/m/d H:i',
    step: 1,
    opened: false,
    validateOnBlur: false,
    closeOnDateSelect: false,
    closeOnTimeSelect: false
});

$('#datepicker-day').datetimepicker({
    hours12: false,
    format: 'Y/m/d',
    step: 1,
    opened: false,
    validateOnBlur: false,
    closeOnDateSelect: true,
    closeOnTimeSelect: false,
    timepicker:false
});

$('#datepicker-startday').datetimepicker({
    hours12: false,
    format: 'Y/m/d',
    step: 1,
    opened: false,
    validateOnBlur: false,
    closeOnDateSelect: true,
    closeOnTimeSelect: false,
    timepicker:false
});

$('#datepicker-endday').datetimepicker({
    hours12: false,
    format: 'Y/m/d',
    step: 1,
    opened: false,
    validateOnBlur: false,
    closeOnDateSelect: true,
    closeOnTimeSelect: false,
    timepicker:false,
    onShow:function( ct ){
    	   this.setOptions({
    	    minDate:$('#datepicker-startday').val()?$('#datepicker-startday').val():false
    	   })
    	  },
});
$(".accordian-common").accordion({
    el: ".h",
    head: "h4, h5",
    next: "div",
    initShow : ""
});
$("html").removeClass("js");
});
/**
 * Change the course html for the different 
 * @param term_uuid
 */
function showCourseHtml()
{

	var term_uuid = $('#terms-cs').val();
	$.ajax({
		type : "POST",
		url : site_url1 + "ChatReports/showCourseHtml",
		data : {
			term_uuid : term_uuid
		}
	}).done(function(msg) {
		$('.course-filter').html(msg);
	});
}
