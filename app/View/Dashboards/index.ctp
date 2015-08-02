<?php
$ruserdata = $ruser_object;
//decode the bash64 encoded $ruserobj
$ruserobj = base64_decode($ruserdata);
//json decode
$ruserdecodeObj = json_decode($ruserobj);
$pageContentId = $ruserdecodeObj->contentPageId;
$userType = $ruserdecodeObj->userType;
?>
<div class="api-menu">
<?php
if($pageContentId != ""){
?>
<div class="ask-quest">
<a href="#" onclick="return popitup('<?php echo $this->webroot; ?>forums/forumlist/<?php echo $pageContentId; ?>')"
>Ask a question</a>
</div>
<?php } ?>
<?php
if($pageContentId == ""){
?>
<div class="whos-online">
<a href="#" onclick="return openonline('<?php echo $this->webroot; ?>users/login/<?php echo $ruserdata;?>');">Who's online</a>
</div>
<?php } ?>
<?php
if($pageContentId != ""){
?>
<div class="setting">
<?php 
//echo $this->html->link('Setting',array('controller'=>'dashboards','action'=>'setting'));
?>
<ul id="acc1" class="accordion accordian-common">
     <li>
        <h4 class="h"><a class="trigger" href="#">DashBoard</a></h4>
          <div class="outer"><div class="inner">
                <ul>
                  <li><a href="<?php echo $this->webroot; ?>dashboards/home/whatsnew/<?php echo $ruserdata;?>" target="_parent" >What's New</a> </li>
				  <?php if ($userType == 'instructor') {?>
				  <li><a href="<?php echo $this->webroot; ?>dashboards/home/askaquestion/<?php echo $ruserdata;?>" target="_parent">Question Setting</a></li>
				  <?php }?>
				  <li><!-- <a href="#" onclick="return setting('<?php echo $this->webroot; ?>dashboards/reminders/<?php echo $ruserdata;?>');">Reminders</a></li> -->
				  <li><a href="<?php echo $this->webroot; ?>dashboards/home/notificationsetting/<?php echo $ruserdata;?>" target="_parent">Notification Settings</a></li>
				  <?php if ($userType == 'instructor') {?>
				  <li> <a href="<?php echo $this->webroot; ?>dashboards/home/communitysetting/<?php echo $ruserdata;?>" target="_parent">Community Settings</a></li>
				  <?php }?>
				 </ul>
		  </div></div>
	 </li>
 </ul>

</div>
<?php } ?>
</div>
<script type="text/javascript"> 
$(document).ready(function(){ //code for seeting the height of the iframe same as the page.
var iframeWin = window.parent.document.getElementById("chatframe");
iframeWin.height = (window.parent.document.body.scrollHeight)-90; 
});
</script>
<script type="text/javascript">
/*
 * function for opening the forum popup.
 */
var strWindowFeatures = "height=650,width=850,scrollbars=yes,status=yes,resizable=yes";
function popitup(url) {
	newwindow=window.open(url,'name',strWindowFeatures);
	if (window.focus) {newwindow.focus()}
	return false;
}
/**
 * function for opening the chat popup.
 */
function openonline(url)
{
	var win = window.open(url, "name1", strWindowFeatures);
	if (window.focus) {win.focus()}
	return false;
}
/**
 * function for opening the user dashboard popup.
 */
function setting(url)
{

	var win = window.open(url, "setting", strWindowFeatures);
	if (window.focus) {win.focus()}
	return false;
}
</script>