//site_url1 variable is defined in dashboard layout
$(document).ready(function(){
//code for twitter authentication
$('#twitter-login').click( function(){
	var strWindowFeatures = "height=450,width=650,scrollbars=yes,status=yes,resizable=yes";
	var url = site_url1+"dashboards/twitterRedirect";
	newwindow=window.open(url,'twittername',strWindowFeatures);
	if (window.focus) {newwindow.focus()}
	return false;
});

//code for facebook authentication
$('#facebook-login').click( function(){
	var strWindowFeatures = "height=450,width=650,scrollbars=yes,status=yes,resizable=yes";
	var url = site_url1+"dashboards/facebookRedirect";
	newwindow=window.open(url,'facebookname',strWindowFeatures);
	if (window.focus) {newwindow.focus()}
	return false;
});
// script for copy the content in clipboard for RSS Feed URL.
	var url = "";
	//set path
	ZeroClipboard.setMoviePath(site_url1+'js/ZeroClipboard.swf');
	//create client
	var clip = new ZeroClipboard.Client();
	//event
	clip.addEventListener('mousedown',function() {
		clip.setText($('#notf-feed-reader').val());
	});
	clip.addEventListener('complete',function(client,text) {
    	$.msgBox({
		    title:"Alert",
		    content: 'Url copied.'
		});
	});
	//glue it to the button
	clip.glue('feedreader_link');
//script end for copy into clipboard.
// script for copy the content in clipboard for Assignment RSS Feed URL.	
	var clip1 = new ZeroClipboard.Client();
	clip1.addEventListener('mousedown',function() {
		clip1.setText($('#notf-feed-reader-assignments').val());
	});
	clip1.addEventListener('complete',function(client, text) {
    	$.msgBox({
		    title:"Alert",
		    content: 'Url copied.'
		});
	});
	//glue it to the button
	clip1.glue('feedreader_link_assignments');
});
//refresh the parent window when a user logged-in in facebook(calling from facebook login button same view file)
function refreshParentWindow()
{ 
	window.close();
	location.reload();
}

//code for twitter follow
!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");

//code for facebook authentication
//fb_appid variable is facebook app id defined in dashboard layout.
(!function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (!d.getElementById(id)){
  js = d.createElement(s);
  js.id = id;
  js.close = false;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId="+fb_appid;
  fjs.parentNode.insertBefore(js, fjs);
  }
}(document, 'script', 'facebook-jssdk'));
