<?php
/**
 * Chat management controller.
 *
 * This file will render views from views/users/
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
App::uses('AppController', 'Controller');

/**
 * Chat management controller yogi + abhi
 *
 * @package       app.Controllert
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class MeetingsController extends AppController {

	//The $uses attribute states which model(s) the will be available to the controller:
	public $uses = array('Chat', 'PendingRequest', 'PleSetting', 'ChatUser', 'PleUser', 'MeetingUser', 'MeetingInfo', 'ChatSessionLog', 'MeetingLog');
	public $components = array('Email');
	
	/**
	 * Method to check the user login
	 */
	public function beforeFilter()
	{
		//get chatServer host url global setting from bootstrap.php
		$boshUrl = Configure::read('bosh_url');
		$this->set('boshUrl',$boshUrl);
		//get and set site url
		$siteUrl = Configure::read('site_url');
		$this->set('siteUrl',$siteUrl);
		//get user session
		$user = $this->Session->read('UserData.userName');
		if ($user=="") {
			return $this->redirect(array('controller' => 'users', 'action' => 'login'));
		}
	}
	
	/**
	 * finding the meetings ajax call
	 * @param none
	 * @return html
	 */
	public function userMeetings()
	{
		//get user session
		$currenttime = time();
		$extra_time = Configure::read('extra_meetingtime'); //done in bootstrap
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		
		//get allsection setting sections for same course
		$sections_list = $this->__allSections();
		$options['conditions'][] = array(
				'MeetingInfo.chat_from_course'=>$course_name,
				'MeetingInfo.chat_from_section'=>$sections_list,
				'OR'=>array('MeetingInfo.is_active' => '1', 'MeetingInfo.chat_meeting_startdate >='=> $currenttime-$extra_time)
		);		
		$options['joins'][] = array(
				'table' => 'chat_meeting_users',
				'alias' => 'Meetingusers',
				'type' => 'INNER',
				'conditions'=> array('Meetingusers.chat_meeting_name = MeetingInfo.chat_meeting_name',
						'Meetingusers.to_user' => $user,
						'Meetingusers.is_accept !=' => 2)
		);
		$options['fields'] = array( 'MeetingInfo.*', 'Meetingusers.id', 'Meetingusers.is_accept' );
		$options['order'] = array('MeetingInfo.chat_meeting_startdate ASC');
		$meeting_list  = $this->MeetingInfo->find('all', $options);
		$join_group_img= $this->webroot."img/join.png";
		$accept_imgsrc= $this->webroot."img/accept.png";
		$reject_imgsrc= $this->webroot."img/reject.png";
		$detail_imgsrc= $this->webroot."img/meeting_detail.png";
		$msgstr = '';
		if (count($meeting_list))
		 foreach ($meeting_list as $mettings) {
		 	$meetinguser_id = $mettings['Meetingusers']['id'];
		 	$meeting_tilte =  $mettings['MeetingInfo']['chat_meeting_title'];
		 	$meeting_name =  $mettings['MeetingInfo']['chat_meeting_name'];
		 	$meeting_date =  $mettings['MeetingInfo']['chat_meeting_startdate'];
		 	$meeting_active =  $mettings['MeetingInfo']['is_active'];
		 	$is_accept = 	$mettings['Meetingusers']['is_accept'];
		 	@$meetingDetails = $this->__mettingDetail($meeting_name);
		 	$meetingUserNames = implode(', ', $meetingDetails['users']);
			 $msgstr .= "<li id='meeting_".$meetinguser_id."'><span class='meeting_title'>".ucfirst($meeting_tilte)."</span>";
			 //if meeting is not accepted or/denied then showing the buttons for action.
// 			 if(!$is_accept)
// 			 	$msgstr .= "<span class='prq_icon_meeting' id='meetingaction_".$meetinguser_id."'><input type='image' src='".$accept_imgsrc."' title='accept invitation' onClick=acceptMeetingInvitaion('$meetinguser_id','$meeting_name') />
// 			 	&nbsp;&nbsp;&nbsp;<input type='image' src='".$reject_imgsrc."' title='reject invitation' onClick=rejectMeetingInvitaion('$meetinguser_id') /></span>
// 			 	";
			 //showing the join meeting from the start date time of the meeting date till  30 minuteslater.
			 if (($meeting_date <= $currenttime || $meeting_active) && $is_accept == 1) {
			 	$msgstr .= "<span class='meeting-detail' id='meeting_detail_".$meetinguser_id."'>
			 	 <span class='meeting-date' style='display:none;'> Meeting @ ".date('m/d/Y h:i A', $meetingDetails['date'][0])."</span>
				 <input type='image' class='detail-image' id='detail_meeting_".$meetinguser_id."' onclick=detailMeeting('".$meetinguser_id."') src='".$detail_imgsrc."' title='meeting detail' alt='Detail'/></span>
			 	<span class='join_meeting_area'><input type='image' title='start meeting' id='joinmetting_".$meeting_name."' onclick=joinmeeting('".$meetinguser_id."','".$meeting_name."') src='".$join_group_img."' /></span>";
			 	if(!$is_accept)
			 		$msgstr .= "<span class='prq_icon_meeting' id='meetingaction_".$meetinguser_id."'><input type='image' src='".$accept_imgsrc."' title='accept invitation' onClick=acceptMeetingInvitaion('$meetinguser_id','$meeting_name') />
			 		&nbsp;&nbsp;&nbsp;<input type='image' src='".$reject_imgsrc."' title='reject invitation' onClick=rejectMeetingInvitaion('$meetinguser_id') /></span>
			 		";
				$msgstr .= "<div class='meeting-detail-area' id='below_meeting_detail_".$meetinguser_id."'>
				 <span class='meeting-users'><b>Participants:</b> $meetingUserNames</span>
			 	</div>
			 	</li>";
			 } else {
			 	$msgstr .= " <span class='meeting-detail' id='meeting_detail_".$meetinguser_id."'>
			 	<span class='meeting-date'> Meeting @ ".date('m/d/Y h:i A', $meetingDetails['date'][0])."</span>
			 	<input type='image' class='detail-image' id='detail_meeting_".$meetinguser_id."' onclick=detailMeeting('".$meetinguser_id."') src='".$detail_imgsrc."' title='meeting detail' alt='Detail'/></span>";
			 	if(!$is_accept)
			 		$msgstr .= "<span class='prq_icon_meeting' id='meetingaction_".$meetinguser_id."'><input type='image' src='".$accept_imgsrc."' title='accept invitation' onClick=acceptMeetingInvitaion('$meetinguser_id','$meeting_name') />
			 		&nbsp;&nbsp;&nbsp;<input type='image' src='".$reject_imgsrc."' title='reject invitation' onClick=rejectMeetingInvitaion('$meetinguser_id') /></span>
			 		";
			 	$msgstr .= "<div class='meeting-detail-area' id='below_meeting_detail_".$meetinguser_id."'>
			 	<span class='meeting-users'>Participants: $meetingUserNames</span>
			 	</div>
			 	</li>";
			 }
		 }
		 
		 //get current login user
		 //updating the mark read for meeting users as read   
		 $user = $this->Session->read('UserData.userName');
		 $this->MeetingUser->updateAll(
		 		array('MeetingUser.is_read' => 1),
		 		array('MeetingUser.to_user' => $user)
		 );
		 
		 if ($msgstr == "") {
		 	echo "<span class='noresultfound'>No result found</span>";
		 	exit;
		 }
		 echo $msgstr;
		 exit;
	}
	
	/**
	 * joining the meeting
	 * @params id
	 * @return none
	 */
	public function meetingChat($id)
	{
		$this->layout = 'chatwindow';
		$requests = $this->MeetingUser->find('first',array(
				'conditions'=>array('MeetingUser.id'=>$id)
		));

		//get group name
		$room_name = $requests['MeetingUser']['chat_meeting_name'];
		$user = $requests['MeetingUser']['to_user'];
		//set group name
		$this->set('room_name', $room_name);
		//get  host name global setting from bootstrap.php
		$hostName = Configure::read('host_name');
		//set host name
		$this->set('hostName', $hostName);

		//get  room host name global setting from bootstrap.php
		$roomHostName = Configure::read('room_host_name');

		//set host name
		$this->set('roomHostName', $roomHostName);
		$this->MeetingUser->create();
		//set friends name
		$this->set('user', $user);
		$this->set('meeting_id', $id);
		//update the request as attended
		$invite['MeetingUser']['id'] = $id;
		//set notification
		$oldCount1 = $this->Session->read('oldMeetingCount');
		if ($oldCount1>0) {
			$newCount1 = $oldCount1-1;
			$this->Session->write('oldMeetingCount',$newCount1);
		}
		//set status 1 as accepted
		$invite['MeetingUser']['is_attend'] = 1;
		$invite['MeetingUser']['is_read'] = 1;
		$this->MeetingUser->save($invite);
		//making the meeting as active..
		$this->__makeMeetingActive($room_name);
		
		//save the chat session logs
		$this->_saveChatSessionLogs($this->MeetingUser->id, $room_name);
		
		$this->render('meeting_chat');
	}
	
	/**
	 * Accepting the meeting request
	 * @params id, room_name
	 * @return int
	 */
	public function acceptInvitation()
	{
		$id = $this->request->data['id'];
		$room_name = $this->request->data['roomName'];
		$invite['MeetingUser']['id'] = $id;
		//set status 1 as accepted
		$invite['MeetingUser']['is_accept'] = 1;
		$invite['MeetingUser']['is_read'] = 1;
		$invite['MeetingUser']['is_attend'] = 0;
		//set notification
		$oldCount1 = $this->Session->read('oldMeetingCount');
		if ($oldCount1>0) {
			$newCount1 = $oldCount1-1;
			$this->Session->write('oldMeetingCount',$newCount1);
		}
		if($this->MeetingUser->save($invite))
			echo "1";
		else
			echo "0";
		exit;
	}
	
	/**
	 * Rejecting the request for Meeting
	 * @params id
	 * @return int
	 */
	public function rejectInvitation()
	{
		$id = $this->request->data['id'];
		$invite['MeetingUser']['id'] = $id;
		//set status 1 as accepted
		$invite['MeetingUser']['is_accept'] = 2;
		$invite['MeetingUser']['is_read'] = 1;
		$invite['MeetingUser']['is_attend'] = 0;
		//set notification
		$oldCount1 = $this->Session->read('oldMeetingCount');
		if ($oldCount1>0) {
			$newCount1 = $oldCount1-1;
			$this->Session->write('oldMeetingCount',$newCount1);
		}
		if($this->MeetingUser->save($invite))
			echo "1";
		else
			echo "0";
		exit;
	}
	
	/**
	 * Finding the Meeting details(users accept the meeting request, date)
	 * @params group_name
	 * @return array
	 */
	public function __mettingDetail($group_name)
	{
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$options['conditions'][] = array('MeetingUser.chat_meeting_name'=>$group_name, 'MeetingUser.is_accept != 2');
		$options['joins'][] = array(
				'table' => 'chat_meeting_info',
				'alias' => 'Meetinginfo',
				'type' => 'INNER',
				'conditions'=> array('MeetingUser.chat_meeting_name = Meetinginfo.chat_meeting_name')
		);
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'registerUser',
				'type' => 'INNER',
				'conditions'=> array('registerUser.userName = MeetingUser.to_user', 'registerUser.course'=>$course_name)
		);
		$options['fields'] = array( 'MeetingUser.*', 'Meetinginfo.id', 'Meetinginfo.chat_meeting_startdate', 'Meetinginfo.chat_meeting_name', 'registerUser.name' );
		$meetingDetail = $this->MeetingUser->find('all', $options);
		$meetingArray = array();
		foreach ($meetingDetail as $details) {
			$meetingArray['users'][] = ucfirst($details['registerUser']['name']);
				
		}
		$meetingArray['date'][] = $meetingDetail[0]['Meetinginfo']['chat_meeting_startdate'];
		return $meetingArray;

	}
	
	/**
	 * Making the meeting as active if a user attend the meeting.
	 * @params Meeting group name
	 * @return boolean
	 */
	private function __makeMeetingActive($group_name)
	{
		//get current login user session
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$this->MeetingInfo->updateAll(
				array('MeetingInfo.is_active' => 1),
				array('MeetingInfo.chat_meeting_name' => $group_name)
		);
		return true;
	}
	
	/**
	 * levae the meeting the room
	 * @params roomName
	 * @return boolean
	 */
	public function leaveRoom()
	{
		//get current login user session
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$data = $this->request->data;
		$group_name = $data['roomName'];
		$this->MeetingUser->updateAll(
				array('MeetingUser.is_attend' => 0),
				array('MeetingUser.chat_meeting_name' => $group_name, 'MeetingUser.to_user'=>$user)
		);
		//counting if any meeting chat is going on for the same group.
		$count = $this->MeetingUser->find('count', array('conditions'=>array('MeetingUser.chat_meeting_name' => $group_name, 'MeetingUser.is_attend'=> 1)));
		if(!$count)
			$this->MeetingInfo->updateAll(
					array('MeetingInfo.is_active' => 0),
					array('MeetingInfo.chat_meeting_name' => $group_name)
			);
		echo "true";
		exit;
	}
	
	/**
	 * Checking the meeting is active or date is inbetween of current date
	 * @params id, groupname
	 * @return int
	 */
	public function CheckActiveMeeting()
	{
		//get current login user session
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		//get user session
		$currenttime = time();
		$userJoinTime = $currenttime;
		$extra_time = Configure::read('extra_meetingtime');//done in bootstrap
		$data = $this->request->data;
		$group_name = $data['roomname'];
		$requests = $this->MeetingInfo->find('first',array(
				'conditions'=>array('MeetingInfo.chat_meeting_name'=>$group_name)
		));
		$meeting_date =  $requests['MeetingInfo']['chat_meeting_startdate'];
		$meeting_active =  $requests['MeetingInfo']['is_active'];
		$meeting_start_date = $meeting_date;
		$meeting_end_date = $meeting_start_date+$extra_time;
		if((($userJoinTime <= $meeting_end_date) && ($userJoinTime >= $meeting_start_date)) || $meeting_active)
			echo 1;
		else
			echo 0;
		exit;
	}
	
	/**
	 * Get user list to be invited for meeting
	 * based on current setting of section for the same course
	 * @param none
	 * @return array
	 */
	public function getUserslistToInvite()
	{
		//get current login user session
		$results = array();
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		//get allsection setting sections for same course
		$sections_list = $this->__allSections();
		$options = array('course'=>$course_name,'section'=>$sections_list,'userName !='=>$user);
		$results = $this->PleUser->find('all',array('conditions'=>$options,'fields'=>array('userName','name'),'order' => array('PleUser.name ASC')));
		if ($results) {
			return $results;
		}
		return $results;
	}
	
	/**
	 * save meeting info
	 * @param ajax call
	 * @return html
	 */
	public function saveMeeting()
	{
		$data = $this->request['data'];

		//get current login user session
		$results = array();
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$group_name = "roomid_".time();
		//get meeting data

		if ($data) {
			$hours = $data['meeting_start_hours'];
			$minutes = $data['meeting_start_minutes'];
			$newtime = strtotime($data['meeting_start_date']) + ($hours * 3600)+ ($minutes * 60);
			// add the time zone value

			//check for if it is not past
			if ($newtime<time()) {
				echo "Meeting can't be scheduled before current time.";
				exit;
			}
			$data['friends'][]=$user;
			$friends = $data['friends'];

			$invite_data['MeetingInfo']['chat_meeting_from'] = $user;
			$invite_data['MeetingInfo']['chat_meeting_title'] = $data['meeting_title'];
			$invite_data['MeetingInfo']['chat_meeting_name'] = $group_name;
			$invite_data['MeetingInfo']['chat_meeting_startdate'] = $newtime;
			$invite_data['MeetingInfo']['chat_from_course'] = $course_name;
			$invite_data['MeetingInfo']['chat_from_section'] = $course_section;
			$invite_data['MeetingInfo']['is_active'] = 0;
			$invite_data['MeetingInfo']['chat_meeting_request_date'] = time();

			//save the info
			if ($this->MeetingInfo->save($invite_data)) {
				//invite the users
				$this->__inviteFriends($friends,$group_name);
				
				//create log for meeting schedule
				$this->__meetingLogs($data);
				
				echo "<span style='margin-left:5px'> Meeting scheduled successfully.</span>";
				exit;
			}
			echo "failed";
			exit;

		}

	}

	/**
	 * Invite friends
	 * @param friends array
	 * @return none
	 */
	public function __inviteFriends($friends,$group_name)
	{
		$ctime = time();
		//get current login user session
		$user = $this->Session->read('UserData.userName');
		foreach ($friends as $friend) {
			$this->MeetingUser->create();
			$data['MeetingUser']['chat_meeting_name']=$group_name;
			$data['MeetingUser']['to_user']=$friend;
			$data['MeetingUser']['to_course']=0;
			$data['MeetingUser']['to_section']=0;
			$data['MeetingUser']['is_attend']=0;
			if ($user == $friend) {
				$data['MeetingUser']['is_accept']=1;
				$data['MeetingUser']['is_read']=1;
				$data['MeetingUser']['accept_date']=$ctime;
			} else {
				$data['MeetingUser']['is_accept'] = 0;
				$data['MeetingUser']['is_read'] = 0;
				$data['MeetingUser']['accept_date'] = 0;
			}

			$data['MeetingUser']['from_section'] = 0;

			$this->MeetingUser->save($data);

		}
		$this->__sendMeetingNotification($friends,$group_name);
	}

	/**
	 * Send meeting notification by ODU email
	 * @param array, int
	 * @return boolean
	 */
	private function __sendMeetingNotification($friends,$meetingId)
	{
		//get current login user info
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course[0]);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
				
		$cuser_detail = $this->PleUser->find('first',array('conditions'=>array('PleUser.userName'=>$user)));
		$cuserName = $cuser_detail['PleUser']['name'];
		$cuserEmail = $cuser_detail['PleUser']['email'];
		 
		//remove meeting admin name from email list
		$key = array_search($user, $friends);
		if ($key) {
			unset($friends[$key]);
		}
		 
		//get email id of friends
		foreach ($friends as $friend) {

		}
		$options['conditions'][] = array('PleUser.course'=>$course_name, 'PleUser.userName'=>$friends);
		$users_data  = $this->PleUser->find('all', $options);
		//pr($users_data);

		foreach ($users_data as $single) {
			$email[] = $single['PleUser']['email'];
		}
		$unique_email = array_unique($email);

		//get meeting info
		$meeting_info = $this->MeetingInfo->find('first',array('conditions'=>array('chat_meeting_name'=>$meetingId)));
		$meeting_name = $meeting_info['MeetingInfo']['chat_meeting_title'];
		$meeting_start_date = $meeting_info['MeetingInfo']['chat_meeting_startdate'];
		//set time in us format
		$time_format = date('m-d-Y h:i A',$meeting_start_date);
		$meeting_from = $meeting_info['MeetingInfo']['chat_meeting_from'];

		//set the layout for meeting mail
		$this->Email->layout = 'meetinglayout'; //view/Layouts/Emails/html/meetinglayout.php
		//Note: As we have defined $this->Email->sendAs as 'html', so this file should be only in html folder,
		// if pass 'both' then should be in text and html folder also.
		$maildata = 'Dear user, <br>';
		$maildata .= ucfirst($cuserName).'('.$cuserEmail.') has invited you for meeting. Meeting details are:<br />Meeting Name: '.ucfirst($meeting_name).'<br />Meeting time: '.$time_format.'<br /><br />'; //mail content prepare here.
		$this->set('content', $maildata);
		$this->Email->to = $unique_email;
		$this->Email->subject = 'Meeting invitaion';
		$this->Email->from = Configure::read('mail-from');
		$this->Email->template = 'meetingmail'; //view/Emails/html/subscriptionmail.php
		//Note: As we have defined $this->Email->sendAs as 'html', so this file should be only in html folder, if pass 'both' then should be in text and html folder also.
		//Send as 'html', 'text' or 'both' (default is 'text') because we like to send pretty mail
		$this->Email->sendAs = 'html';
		// setting for smtp set the parameter
		$smtparray     = Configure::read('smtpparam');

		$this->Email->smtpOptions = array(
				'port'=> $smtparray['port'],
				'timeout'=> $smtparray['timeout'],
				'host' => $smtparray['host'],
				'username'=> $smtparray['username'],
				'password'=> $smtparray['password'],
		);

		/* Set delivery method */
		$this->Email->delivery = 'smtp';
		if ( $this->Email->send($maildata) ) {
			return true;
		} else {
			return true;
		}
	}
	
	/**
	 * Method to get Meeting request count
	 * @params none
	 * @return json array
	 */
	public function getMeetingRequestsCount()
	{
		//get initial value for old and new count
		$oldMeetingCount = $this->Session->read('oldMeetingCount');
		$newMeetingCount = $this->Session->read('newMeetingCount');

		//initialise the str
		$str = "";
		//get current login user
		$user = $this->Session->read('UserData.userName');
		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$requests = array();
		//get allsection setting sections for same course
		$sections_list = $this->__allSections();
		$postoptions[] = array('Meetinginfo.chat_from_course'=>$course_name,
				'Meetinginfo.chat_from_section'=>$sections_list, 'MeetingUser.chat_meeting_name = Meetinginfo.chat_meeting_name'
		);	
		$options['conditions'][] = array('MeetingUser.to_user' => $user,  'MeetingUser.is_read = '=> 0);
		$options['joins'][] = array(
				'table' => 'chat_meeting_info',
				'alias' => 'Meetinginfo',
				'type' => 'INNER',
				'conditions'=> $postoptions
		);
		$meeting_count  = $this->MeetingUser->find('count', $options);
		//check to show alert notification
		$newMeetingCount = $meeting_count;
		if ($oldMeetingCount < $newMeetingCount ) {
			$showAlert = 1;
		} else {
			$showAlert = 0;
		}
		$oldMeetingCount = $newMeetingCount;
		$this->Session->write('oldMeetingCount', $oldMeetingCount);
		$this->Session->write('newMeetingCount', $newMeetingCount);
		$data = array('count'=>$meeting_count, 'showAlert'=>$showAlert);
		echo json_encode($data);
		exit;
	}
	
	/**
	 * Mark notification as read
	 * @param none
	 * @return boolean
	 */
	public function markNotificationAsRead()
	{
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$this->MeetingUser->updateAll(
				array('MeetingUser.is_read' => 1),
				array('MeetingUser.to_user' => $user)
		);
		echo "true";
		exit;
	}
	
	/**
	 * get section based on all section setting
	 * @param none
	 * @return array
	 */
	public function __allSections()
	{
		//current user course
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//get Course and section name
		$course_info    = $this->getCourseNameOfUser($user_course_section);
		$course_name    = $course_info->course_name;
		$course_section = $course_info->section_name;
		$sectionList = array();
		//getting the course in section/all section setting(changed on 16 April, 2014)
	    $setting = $this->__getDbSetting($user_course_section);
		if ($setting == 2) {
			$sections = $this->PleSetting->find('all',array('conditions'=>array('PleSetting.course'=>$course_name,'PleSetting.setting_value'=>2),'fields'=>array('section')));
			foreach ($sections as $section) {
				$sectionList[] = trim($section['PleSetting']['section']);
			}
			$sectionList[] = $course_section;
	    } else {
			//add current user login section
			$sectionList[] = $course_section;
	    }
		$tz = array_unique($sectionList);
		return $tz;
	}

	/**
	 * saving the data for chat session logs
	 * @param int $chat_id
	 * @param string $room_name
	 */
	private function _saveChatSessionLogs($chat_id, $room_name)
	{
		$data = array();
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];
	
		//get Course and section name
		$course_info     = $this->getCourseNameOfUser($course_name_explode);
		$course_name     = $course_info->course_name;
		$course_section  = $course_info->section_name;
		//getting session info
		$session_info  = $this->getSessionNameOfUser($course_name_explode);
		$session_name  = $session_info->session_name;
		$result_data = $this->ChatSessionLog->find('all', array('conditions'=>
				array("ChatSessionLog.chat_name"=>$room_name)));
		if (!count($result_data)) {
			$data['ChatSessionLog']['type']  = 'owner';
		} else {
			$data['ChatSessionLog']['type']  = 'receiver';
		}
		//prepare the data to be saved.
		$data['ChatSessionLog']['chat_id']         = $chat_id;
		$data['ChatSessionLog']['chat_name']       = $room_name;
		$data['ChatSessionLog']['midas_id']        = $user;
		$data['ChatSessionLog']['time']            = time();
		$data['ChatSessionLog']['course']          = $course_name;
		$data['ChatSessionLog']['section']         = $course_section;
		$data['ChatSessionLog']['session']         = $session_name;
		$data['ChatSessionLog']['chat_type']       = 0;
		$this->ChatSessionLog->create();
		$this->ChatSessionLog->save($data);
		return $this->ChatSessionLog->id;
	}
	
	/**
	 * Create log for meeting
	 * @param array $data
	 */
	private function __meetingLogs($info)
	{
		//get current login user
		$user = $this->Session->read('UserData.userName');
		
		//current user course
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		
		foreach($info['friends'] as $single_user) {
		$this->MeetingLog->create();
		//get course and section name
		$user_info = $this->PleUser->find('first', array('conditions' => array('PleUser.midasId' => $single_user, 'PleUser.course' => $course_name), 'fields' =>array('course','section')));
		
		$course_name = $user_info['PleUser']['course'];
		$section_name = $user_info['PleUser']['section'];

		//get session name
		$session_info = $this->getSessionNameOfUser($course_name);
		$session_name = $session_info->session_name;
		
		//get the last inserted id of meeting
		$last_id = $this->MeetingInfo->getLastInsertId();
		
		//create the data arrray
		$data['MeetingLog']['meeting_id'] = $last_id;
		$data['MeetingLog']['meeting_name'] = $info['meeting_title'];
 		$data['MeetingLog']['midas_id']= $single_user;
 		$data['MeetingLog']['user_type']= 'receiver';
 		
 		//check for user type
 		if($single_user == $user) {
 		$data['MeetingLog']['user_type']= 'sender';
 		}
 		
 		$data['MeetingLog']['time']= time(); //current time
 		$data['MeetingLog']['section'] = $section_name;
 		$data['MeetingLog']['course'] = $course_name;
 		$data['MeetingLog']['session'] = $session_name;
 		
 		$this->MeetingLog->save($data);
		}
		
	}
}