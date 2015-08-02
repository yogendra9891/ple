<!--  Dispaly home page when user get login to chat server -->

<?php //echo ucfirst($user) ;?>
<script src='<?php echo $this->webroot;?>js/gab.js'></script>
<script>

  $(document).trigger('connect', {
                    jid: '<?php echo $user ;?><?php echo $hostName;?>',
                    password: '123456'
                });
</script>
<?php 
//get section type
$section_type = $this->requestAction('chats/getChatSectionType');

//get course name
$course_name = $this->requestAction('chats/getChatCourseName');
//get instructor name
//get course name
$getInstructors = $this->requestAction('chats/getChatUserType');

foreach($getInstructors as $getInstructor) {
	$csid = strtolower('outer-'.$getInstructor['PleUser']['course']."-".$getInstructor['PleUser']['section']);
	$userid = $getInstructor['PleUser']['midasId'];
?>
<input type='hidden' value='<?php echo $userid ;?>' id='<?php echo $csid; ?>' />
<?php 
}
//get section setting
$getSectionSettings = $this->requestAction('chats/getChatRoasterUser');

foreach($getSectionSettings as $getSectionSetting){
	$csid = strtolower('outersetting-'.$getSectionSetting['PleSetting']['course']."-".$getSectionSetting['PleSetting']['section']);
	$set_val = $getSectionSetting['PleSetting']['setting_value'];
	echo "<input type='hidden' value='$set_val' id='$csid'/>";
}
//get userlist of same course
$user_name_list = $this->requestAction('chats/getSameCourseUsersList');
?>
<!-- Set hideen setting  -->
<input type="hidden" value="<?php echo $section_type; ?>" id="sectionsettingid" />
<input type="hidden" value="<?php echo $course_name; ?>" id="csnameid" />
<!-- setting the user name(midasId) list of the same course -->
<input type="hidden" value="<?php echo $user_name_list;?>" id="usenamelist" />

<input type="hidden" value="" id="onlineusenamelist" />

<div class="wrapper-area" id="wrapper-area-notifications">
	<div class='chat-top-container'>
		<div id="wrapper-left">
			<div class="top-ic-block">
				<ul>
					<li><input id='notf-lazy' type='image' title="Notifications"
						src="<?php echo $this->webroot;?>img/info_ic.png"
						onClick='notificationTab();' /> <input id='notf-active'
						type='image' title="Notifications"
						src="<?php echo $this->webroot;?>img/info_ic1.png"
						onClick='notificationTab();' style='display: none;' />
						<div id="globalNotify" class="nav-counter"
							style="float: right; display: none;"></div>
					</li>
					<li><input id='jact-lazy' type='image' title="Join Active chat"
						src="<?php echo $this->webroot;?>img/join_active_ic.png"
						onClick='joinActiveChatTab();' /><input id='jact-active'
						type='image' title="Join Active chat"
						src="<?php echo $this->webroot;?>img/join_active_ic1.png"
						onClick='joinActiveChatTab();' style='display: none;' /></li>
					<li><input id='meet-lazy' type='image' title="Meetings"
						src="<?php echo $this->webroot;?>img/ic_meeting.png"
						onClick='planMetting();' /><input id='meet-active' type='image'
						title="Meetings"
						src="<?php echo $this->webroot;?>img/ic_meeting1.png"
						onClick='planMetting();' style='display: none;' /></li>
				</ul>
				<div id='tab-msg'>
					<h3>Who is Online</h3>
				</div>
			</div>
			<div class="left-area">
				<div class="meeting-panel">
					<!--Metting starts-->

					<div class="plan_meeting">
						<?php
						//echo $this->Form->button('Plan Meeting',array('class'=>'gobutton','onclick'=>'planMetting();'));
						?>
					</div>
					<div class="meeting-form" id="meeting-form-id">
						<?php 
						echo $this->Form->create('meetings',array('action'=>'saveMeeting'));
						echo $this->Form->input('Meeting Name',array('name'=>'meeting_title','type'=>'text','id'=>'meeting_title'));
						echo $this->Form->input('Start Date', array('name'=>'start_date','div'=>'st-date', 'label' => 'Start Time', 'class'=>'control-label','id' => 'datepicker','readonly'=>'readonly'));
						//get hours list
						$hours['hr'] = 'Hours';
						$minutes['min'] = 'Minutes';
						for($i=0;$i<24;$i++){
							//change to 12 Hrs format
							$time_in_12_hour_format  = date("g a", strtotime($i.":00"));
							//key value in 24 Hrs format
							$hours[$i] = $time_in_12_hour_format;
							//$hours[$i] = $i;
						}
						//get minute list
						for($i=0;$i<60;$i++){
							$minutes[$i] = $i;
						}
						//get AM PM
						$timePerid = array('AM'=>'AM','PM'=>'PM');
						echo $this->Form->input('hh', array('div'=>'st-hh','options' => $hours,'label'=>'','id'=>'hh'));
						echo $this->Form->input('minutes', array('div'=>'st-min','options' => $minutes,'label'=>'','id'=>'minutes'));
						//echo $this->Form->input('daytype', array('div'=>'st-tp','options' => $timePerid,'label'=>''));
						//get users list to be invite
						$usersLists = $this->requestAction('meetings/getUserslistToInvite');
						$usersOptions = array();
						foreach($usersLists as $usersList){
							$key = $usersList['PleUser']['userName'];
							$uvalue = ucfirst($usersList['PleUser']['name']);
							$usersOptions[$key] = $uvalue;
						}

						echo "<div class='select-users-div'><p>Select Users</p><div id='user-lists'>";
						echo $this->Form->input('users', array(
								'type' => 'select',
								'multiple' => 'checkbox',
								'options' =>$usersOptions,
								'label'=>'',
								'class'=>'in-users-lists'

						));
						echo "</div></div><div class='msg-area'>";
						echo $this->Html->link($this->Html->image('send_invitation.jpg',array('class' => '','id' =>'img_id','alt'=>'invite users','title'=>'invite friends' )), array('controller'=>'','action'=>''), array('escape'=>false, 'onclick' => 'return saveMeeting();','class'=>'linkclass'));


						//echo $this->Form->button('Send Invite',array('class'=>'gobutton','onclick'=>'return saveMeeting();'));
						?>
						<!-- show send email loader -->
						<span id="metting-email-loader"> <img
							src="<?php echo $this->webroot;?>img/tab-loader.gif"
							alt="no-img" />
						</span> <span id="meeting_success"> </span>
					</div>
					<?php 
					echo $this->form->end();?>
				</div>

				<!--Meeting end-->
			</div>
			<div class="upper-area">


				<!-- List Pending Requests Starts Here -->
				<!-- Creating the ajax request to get pending chats requests -->
				<script>
				var refreshIdRequestsCount = setInterval(getRequestsAvailableCount,19000);
                </script>
				<div class="active_chats" id="pending_request-wrapper">
					<div class="active_chats_text">
						Pending Chat Requests

						<div id="pend_req_max" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>img/plus.png"
								onClick="showPendingChatDiv();" />
						</div>
						<div id="pend_req_min" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>img/minus.png"
								onClick="showPendingChatDiv();" />
						</div>
						<div id="pending_request_count" class="nav-counter"
							style="float: right; display: none;"></div>
					</div>
					<ul id="pending_request">
					<!-- Show loader image -->
					 <li class="tab-loader"><img src="<?php echo $this->webroot;?>img/tab-loader.gif" /></li>
					</ul>
				</div>

				<!-- List Pending Requests End Here -->
				<!-- Pending Request Count Starts Here -->
				<script>
				//clearInterval(refreshIdPendingRequestsCount);
//var refreshIdPendingRequestsCount = setInterval(getPendingRequestsCount,19000);
</script>
				<!-- End Here -->

				<!-- List Active Chats Starts Here -->
				<div id="active_chats" class="active_chats">
					<div class="active_chats_text">
						Active Chats [Joined]

						<div id="act_ch_j_max" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>img/plus.png"
								onClick="showJoinedChatDiv();" />
						</div>
						<div id="act_ch_j_min" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>img/minus.png"
								onClick="showJoinedChatDiv();" />
						</div>
					</div>

					<ul id="act_ch_j">
						<?php
						//get active chat session
						$active_chats_sessions = $this->requestAction('chats/getMyActiveChats');
						$userCourse = $this->Session->read('UserData.usersCourses');
						$user_course_section = $userCourse[0];
						//get Course and section name
						$course_info = $this->requestAction(array('controller'=>'chats','action'=>'getCourseNameOfUser', $user_course_section));
						$course_name = $course_info->course_name;
						$course_section = $course_info->section_name;
						if(count($active_chats_sessions)>0){
							foreach($active_chats_sessions as $active_chat){
								$new_room = explode('_', $active_chat['Chat']['room_name']);
								?>
						<li class='prq' id='act<?php echo $active_chat['Chat']['id'];?>'><?php echo ucfirst($course_name).'-'.date('m/d/Y/h:i:s A', $new_room[1]);?>.&nbsp;&nbsp;&nbsp;&nbsp;<input
							type="image" src="<?php echo $this->webroot;?>img/gpchat.png"
							onClick="myActiveChats('<?php echo $active_chat['Chat']['id'];?>','<?php echo $active_chat['Chat']['room_name'];?>')" />
						</li>
						<?php
							}
						}else{
							echo "<li id='nodata'>No result found</li>";
						}
						?>
					</ul>
				</div>
				<!-- List Active Chats Ends Here -->

				<!-- List Requests by other users to join chat Start Here -->
				<script>
					//clearInterval(refreshIdPendingChatRequests);
					//var refreshIdPendingChatRequests = setInterval(getPendingChatRequests,19000);
					//clearInterval(chat_metting);
					//var chat_metting = setInterval(list_meetingsBYAjax, 19000);
				</script>
				<div class="active_chats" id="chat_requests-wrapper">
					<div class="active_chats_text">
						Requests by other users to join chat
						<div id="chat_req_max" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>img/plus.png"
								onClick="showReqChatDiv();" />
						</div>
						<div id="chat_req_min" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>img/minus.png"
								onClick="showReqChatDiv();" />
						</div>
						<div id="chat_requests_count" class="nav-counter"
							style="float: right; display: none;"></div>
					</div>
					<ul id="chat_requests">
                    <!-- Show loader image -->
					 <li class="tab-loader"><img src="<?php echo $this->webroot;?>img/tab-loader.gif" /></li>
					</ul>
				</div>
				<!-- List Requests by other users to join chat End Here -->
				<!-- Get Pending Chat Request Count Starts here -->
				<script>
				//clearInterval(refreshIdPendingChatRequestsCount);
//var refreshIdPendingChatRequestsCount = setInterval(getPendingChatRequestsCount,19000);
</script>
				<!-- End -->
				<!-- Get notification when the user deny the chat request -->
				<script>
				//clearInterval(refreshIdDeniedChatMsg);
//var refreshIdDeniedChatMsg = setInterval(getDeniedChatMsg,19000);
</script>
				<div class="active_chats" id="chatdeny_notification-wrapper">
					<div class="active_chats_text">
						Notifications
						<div id="chat_deny_max" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>img/plus.png"
								onClick="showChatNotifDiv();" />
						</div>
						<div id="chat_deny_min" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>img/minus.png"
								onClick="showChatNotifDiv();" />
						</div>
						<div id="chatdeny_notification_count" class="nav-counter"
							style="float: right; display: none;"></div>
					</div>
					<ul id="chatdeny_notification">
					<!-- Show loader image -->
					 <li class="tab-loader"><img src="<?php echo $this->webroot;?>img/tab-loader.gif" /></li>
					</ul>
				</div>
				<script>
				//clearInterval(meetingcount);
//var meetingcount = setInterval(getMeetingRequestsCount,19000);
</script>
				<!--  new code start for meeting works-->
				<div class="chat_meetings" id="meeting_area-wrapper">
					<div class="active_chats_text">
						Meetings
						<div id="chat_meetings_max" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>img/plus.png"
								onClick="showChatMeetingDiv();" />
						</div>
						<div id="chat_meetings_min" style="float: right; display: none;">
							<input type="image"
								src="<?php echo $this->webroot;?>img/minus.png"
								onClick="showChatMeetingDiv();" />
						</div>
						<div id="chat_meetings_count" class="nav-counter"
							style="float: right; display: none;"></div>
					</div>
					<div class="list-mettings">
						<!--<a href="javascript:void(0);" onClick="list_meetings();"
							id="list-meetings" style="display: none;"> <input type="image"
							src="<?php echo $this->webroot;?>/img/group_meeting.png"
							title='meeting-list' /> 
						</a>-->
						<!-- show send email loader -->
						<span id="metting-loader" style="display: none;"> <img
							src="<?php echo $this->webroot;?>img/tab-loader.gif"
							alt="no-img" />
						</span>
					</div>
					<ul id="meeting_area"></ul>
				</div>
				<!--  new code end for meeting works-->

				<!-- End -->
				<!-- Get Notification Count starts here -->
				<script>
				//clearInterval(refreshIdDeniedChatMsgCount);
//var refreshIdDeniedChatMsgCount = setInterval(getDeniedChatMsgCount,19000);
</script>
			</div>
			<div id='activeChatTab'>
				<!-- List Not Join Active Chats Starts Here -->
				<script>
				//clearInterval(refreshIdNotJoinedActiveChats);
//var refreshIdNotJoinedActiveChats = setInterval(getNotJoinedActiveChats,19000);
</script>

				<div class="active_chats" id="not_joined_activechats-wrapper">
					<div class="active_chats_text">
						Active Chats [Not Joined]
						<div id="act_ch_nj_max" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>/img/plus.png"
								onClick="showNotJoinedChatDiv();" />
						</div>
						<div id="act_ch_nj_min" style="float: right">
							<input type="image"
								src="<?php echo $this->webroot;?>/img/minus.png"
								onClick="showNotJoinedChatDiv();" />
						</div>
					</div>
					<ul id="not_joined_activechats">
                    <!-- Show loader image -->
					 <li class="tab-loader"><img src="<?php echo $this->webroot;?>img/tab-loader.gif" /></li>
					</ul>
				</div>

				<!-- List Not Join Active Chats End Here -->
			</div>
			<!-- End -->
			<!-- List contacts Starts Here-->
			<div class="friends_list">
				<div id='roster-area' class="top_cat_list">
					<ul></ul>
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="right-area">
	<div class="absolute-btm">
		<!-- Show Chat Window Starts Here -->
		<div id="chatarea"
			style="bottom: 0; position: fixed; right: 0px; width: 0px;">
			<div style="float: left; height: 348px;"></div>
		</div>
		<!-- Show Chat Window End Here -->
	</div>
</div>
<div class="clear"></div>
</div>
<!-- List contacts Ends Here-->
<script type="text/javascript"> 
$(document).ready(function(){ //code for seeting the height of the iframe same as the page.
$('#roster-area').slimscroll({
	  height: '150px',
	  alwaysVisible: true
});

$('#user-lists').slimscroll({
	  height: '150px'
});
});

</script>
