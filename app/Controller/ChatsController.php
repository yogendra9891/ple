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
class ChatsController extends AppController
{

	//The $uses attribute states which model(s) the will be available to the controller:
	public $uses = array('Chat', 'PendingRequest', 'PleSetting', 'ChatUser', 'PleUser', 'EmailUser', 'User', 'ChatCurrentOnlineLog', 'ChatSessionLog', 'MeetingUser');
	public $components = array('Email');

	/**
	 * Check the user login
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
	 * Display home page when the user get login
	 * @param userName, courseName
	 * $return none
	 */
	public function home($user, $request_course)
	{
		if(($user == '') || ($this->Session->read('UserData.userName') != $user)) // check for the user is come from logged-in area.
			$this->redirect(array("controller"=> "users", "action"=> "login"));
		$roomUsers = $this->__checkRoomUser();
        
		//checking who's online is disabled
		$availability = $this->_checkOnlineAvailabilty();
		if ($availability) {
			$this->render('chatUnavailable');
		}
		//saving the data for logs(current login) for user
		$this->_saveCurrentOnlineLogs();
		//get  host name global setting from bootstrap.php
		$hostName = Configure::read('host_name');

		//set host name
		$this->set('hostName',$hostName);
		$this->set('user', $user);
	}

	/**
	 * Create user room when he get login
	 * @param userName. UserName will be unique
	 * @return none
	 */
	public function groupChat($friends=null,$roomName)
	{
		//get current login userName
		$user = $this->Session->read('UserData.userName');
		$this->layout = 'chatwindow';
		//convert friends in an array
		$friend_array = explode(',',$friends);

		//get group name
		$room_name = $roomName;
		//set group name
		$this->set('room_name',$room_name);

		//set admin name
		$this->set('user',$user);
		//get  host name global setting from bootstrap.php
		$hostName = Configure::read('host_name');
		//set host name
		$this->set('hostName',$hostName);

		//get  room host name global setting from bootstrap.php
		$roomHostName = Configure::read('room_host_name');

		//set host name
		$this->set('roomHostName',$roomHostName);

		//save the friends to be invited
		foreach ($friend_array as $friend) {
			//get friend name
			$friend_data = explode('&',$friend);
			$friend = $friend_data[0];
			$friend_course_section = $friend_data[1];
			$userCourse = $this->Session->read('UserData.usersCourses');
			$sender_course_section = $userCourse[0];
				
			// Create: id isn't set or is null
			$this->Chat->create();
				
			//get friend name
			//$friendName = strstr($friend,'@',true);
			//create the array to invite users
			$invite['Chat']['chat_from'] = $user;
			$invite['Chat']['room_name'] = $room_name;
			$invite['Chat']['chat_to'] = $friend;
			$invite['Chat']['request_date'] = time();
			$invite['Chat']['from_course_section'] = $sender_course_section;
			$invite['Chat']['to_course_section'] = $friend_course_section;
			$this->Chat->save($invite);
			
			//save the chat session logs
			$this->_saveChatSessionLogs($this->Chat->id, $room_name, 'owner');
			//unset the invite friends array
			unset($invite);
		}
	}

	/**
	 * Show the chat window if user accept the invitation
	 * @param int $id
	 * @return none
	 */
	public function groupFriendsChat($id)
	{
		$this->layout = 'chatwindow';
		$requests = $this->Chat->find('first',array(
				'conditions'=>array('Chat.id'=>$id)
		));

		//get group name
		$room_name = $requests['Chat']['room_name'];
		$user = $requests['Chat']['chat_to'];

		//set group name
		$this->set('room_name',$room_name);

		//get  host name global setting from bootstrap.php
		$hostName = Configure::read('host_name');

		//set host name
		$this->set('hostName',$hostName);

		//get  room host name global setting from bootstrap.php
		$roomHostName = Configure::read('room_host_name');

		//set host name
		$this->set('roomHostName',$roomHostName);

		//set friends name
		$this->set('user',$user);
		$this->set('chat_id',$id);

		//update the request as accepted
		$invite['Chat']['id'] = $id;

		//set status 2 as accepted
		$invite['Chat']['status'] = 2;
		$this->Chat->save($invite);

		//save the chat session logs
		$this->_saveChatSessionLogs($this->Chat->id, $room_name, 'receiver');
		
		//set notification
		$oldCount = $this->Session->read('oldCount');
		if ($oldCount>0) {
			$newCount = $oldCount-1;
			$this->Session->write('oldCount',$newCount);
		}
	}

	/**
	 * Method to get pending request of current login user
	 * for chat
	 */
	public function getPendingRequest($user)
	{
		//get pending request
		$requests = $this->Chat->find('all',array(
				'conditions'=>array('Chat.chat_to'=>$user,'Chat.status'=>'0')
		));
		return $requests;
	}

	/*
	 * Checking the rosters are available in the current group
	* @param none
	* @return encoded data
	*/
	public function checkRosterInChat()
	{
		$chat_room = $this->request->data['chat_room'];
		$chatroom = @explode('@', $chat_room);
		$grouped_roster = $this->Chat->find('all', array('conditions' => array("Chat.room_name" => $chatroom[0])));
		$current_rosters = array();
		$current_selected_rosters = array();
		$current_rosters = $grouped_roster;
		if (count($current_rosters)) {
			foreach ($current_rosters as $rosters) {
				$current_selected_rosters[] = $rosters['Chat']['chat_to'];
				$current_selected_rosters[] = $rosters['Chat']['chat_from'];
			}
			array_unique($current_selected_rosters);
		}
		echo json_encode($current_selected_rosters);
		exit;
	}

	/**
	 * Show the active chats of user
	 * @params userObject
	 * @return array
	 */
	public function getMyActiveChats()
	{
		$userName = $this->Session->read('UserData.userName');

		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		
		//finding the current setting of the admin(in section/all section)
		$db_setting  = $this->__getDbSetting($user_course_section);

		// for all-section setting
		if ($db_setting == 2) {
			//get active chats
			$myChats = $this->Chat->find('all',array(
					'conditions'=>array("OR"=>
							array("Chat.chat_to"=>$userName,
									'Chat.chat_from'=>$userName
							),
							'Chat.status'=>2,
							array('OR'=>
									array('Chat.from_course_section LIKE '=>$course_name."%",
											'Chat.to_course_section LIKE '=>$course_name."%")
							)
					)

			));

			//get active chats
			$adminChats = $this->Chat->find('all',array(
					'conditions'=>array("OR"=>
							array('Chat.chat_from'=>$userName),
							'Chat.status'=>array(1,0),
							array('OR'=>
									array('Chat.from_course_section LIKE '=>$course_name."%",
											'Chat.to_course_section LIKE '=>$course_name."%")
							))
			));
		}
		//end of if
		//for in-section setting
		if($db_setting == 1) {
			//get active chats
			$myChats = $this->Chat->find('all',array(
					'conditions'=>array("OR"=>
							array("Chat.chat_to"=>$userName,'Chat.chat_from'=>$userName),
							'Chat.status'=>2,
							'Chat.from_course_section'=>$user_course_section,
							'Chat.to_course_section'=>$user_course_section
					)
					//'group' => array('Chat.room_name')
			));

			//get active chats
			$adminChats = $this->Chat->find('all',array(
					'conditions'=>array("OR"=>
							array('Chat.chat_from'=>$userName),
							'Chat.status'=>array(1,0),
							'Chat.from_course_section'=>$user_course_section,
							'Chat.to_course_section'=>$user_course_section
					)
			));
		}
		//end of if
		$allChats = array_merge($myChats,$adminChats);
     
	   //die;

		// Obtain a list of columns
        foreach ($allChats as $key => $row) {
        $room[$key]  = $row['Chat']['room_name'];
        //$id[$key]  = $row['Chat']['id'];
       }

       // Sort the data with mid descending
       // Add $data as the last parameter, to sort by the common key
       array_multisort($room, SORT_STRING, $allChats);
   // pr($allChats);
	//die;
		return $allChats;
	}

	/**
	 * Show the chat window if user click on my active chats
	 * @param int $id
	 * @return null
	 */
	public function myActiveChats($id)
	{
		$this->layout = 'chatwindow';
		$requests = $this->Chat->find('first',array(
				'conditions'=>array('Chat.id'=>$id)
		));
		
		//get group name
		$room_name = $requests['Chat']['room_name'];
		$user = $requests['Chat']['chat_to'];
		
		//set group name
		$this->set('room_name',$room_name);
		$userName = $this->Session->read('UserData.userName');
		
		//set friends name
		$this->set('user',$userName);
		$this->set('chat_id',$id);

		//get  host name global setting from bootstrap.php
		$hostName = Configure::read('host_name');
		
		//set host name
		$this->set('hostName',$hostName);

		//get  room host name global setting from bootstrap.php
		$roomHostName = Configure::read('room_host_name');

		//set host name
		$this->set('roomHostName',$roomHostName);

		$this->render('group_friends_chat');
	}

	/**
	 * Get pending Requests for chat using ajax
	 * @params userObject
	 * @return string
	 */
	public function getPendingRequests()
	{
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
		
		//finding the current setting of the admin(in section/all section)
		$result  = $this->__getDbSetting($user_course_section);

		if($result == 2) // for all-section setting
			$requests = $this->Chat->find('all',array(
					'conditions'=>array('Chat.chat_to'=>$user,'Chat.status'=>'0','NOT'=>array('Chat.chat_from'=>array(-1)),  "Chat.to_course_section LIKE"=> $course_name."%"),
					'order' => array('Chat.id DESC')
			));

		if($result == 1) //for in-section setting
			$requests = $this->Chat->find('all',array(
					'conditions'=>array('Chat.chat_to'=>$user,'Chat.status'=>'0','NOT'=>array('Chat.chat_from'=>array(-1)), "Chat.from_course_section"=>$user_course_section, "Chat.to_course_section"=>$user_course_section),
					'order' => array('Chat.id DESC')
			));

		foreach ($requests as  $pending_request) {
			$id = $pending_request['Chat']['id'];
			$room_name = $pending_request['Chat']['room_name'];
			$new_room = explode('_', $room_name);
			$accept_imgsrc= $this->webroot."img/accept.png";
			$reject_imgsrc= $this->webroot."img/reject.png";
			if ($pending_request['Chat']['pis_read']==0) {
				$cls = "newNotif";
			} else {
				$cls = "oldNotif";
			}
			$str .= "<li class='prq $cls' id='rd".$id."'><span>".ucfirst($this->__getUserNickName($pending_request['Chat']['chat_from']))." has Invited you for chat on group ".ucfirst($course_name).'-'.date('m/d/Y/h:i:s A', $new_room[1])."</span><span class='prq_icon'><input type='image' src='".$accept_imgsrc."'  onClick=acceptInvitaion('$id','$room_name') />&nbsp;&nbsp;&nbsp;<input type='image' src='".$reject_imgsrc."'  onClick='rejectInvitaion($id)' /></span></li>";
		}
		if ($str == "") {
			echo "<span class='noresultfound'>No result found</span>";
			exit;
		}
		echo $str;
		exit;
	}

	/**
	 * Get pending request count
	 * @param userObject
	 * @return int
	 */
	public function getPendingRequestsCount()
	{
	    //get initial value for old and new count
		$oldCount = $this->Session->read('oldCount');
		$newCount = $this->Session->read('newCount');
			
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
		
		//finding the current setting of the admin(in section/all section)
		$result  = $this->__getDbSetting($user_course_section);

		if($result == 2) // for all-section setting
			$requests = $this->Chat->find('count',array(
					'conditions'=>array('Chat.chat_to'=>$user,'Chat.status'=>'0','Chat.pis_read'=>'0','NOT'=>array('Chat.chat_from'=>array(-1)),  "Chat.to_course_section LIKE"=> $course_name."%")
			));

		if($result == 1) //for in-section setting
			$requests = $this->Chat->find('count',array(
					'conditions'=>array('Chat.chat_to'=>$user,'Chat.status'=>'0','Chat.pis_read'=>'0','NOT'=>array('Chat.chat_from'=>array(-1)), "Chat.from_course_section"=>$user_course_section, "Chat.to_course_section"=>$user_course_section)
			));

		//check to show alert notification
		$newCount = $requests;
		if ($oldCount < $newCount) {
			$showAlert = 1;
		} else {
			$showAlert = 0;
		}

		$oldCount = $newCount;

		$this->Session->write('oldCount',$oldCount);
		$this->Session->write('newCount',$newCount);
		$data = array('count'=>$requests,'showAlert'=>$showAlert);
		return $data;
		//echo json_encode($data);
		//exit;
	}

	/**
	 * Reject the invitaion for chat
	 * @param request data
	 * @return boolean
	 */
	public function rejectInvitaion()
	{
		$data = $this->request->data;
		$id = $data['id'];
		
		//update the request as accepted
		$invite['Chat']['id'] = $id;
		
		//set status 1 as denied
		$invite['Chat']['status'] = 1;
		$invite['Chat']['pis_read'] = 1;
		$invite['Chat']['dis_read'] = 0;
		$result = $this->Chat->save($invite);
		
		//check for response
		if (!$result) {
			echo "false";
			exit;
		}
		echo "true";

		//set notification
		$oldCount = $this->Session->read('oldCount');
		if ($oldCount>0) {
			$newCount = $oldCount-1;
			$this->Session->write('oldCount',$newCount);
		}
		exit;
	}

	/**
	 * Leave room
	 * @param userObject
	 * @return string
	 */
	public function leaveRoom()
	{
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$data = $this->request->data;
		//	$ro = $data['id'];
		$roomName = $data['roomName'];

		//check if room has no user
		$roomUsers = $this->__checkRoomUser();
		
		//delete the row if Chat.from and Chat.to is -1
		//get active chats
		$myChats = $this->Chat->find('all',array(
				'conditions'=>array("OR"=>
						array("Chat.chat_to"=>$user,'Chat.chat_from'=>$user),'Chat.room_name'=>$roomName)
		));

		foreach ($myChats as $myChat) {

		 $invite['Chat']['id'] = $myChat['Chat']['id'];
		 if ($myChat['Chat']['chat_from'] == $user) {
		 	$invite['Chat']['chat_from'] = "-1";
		 } elseif ($myChat['Chat']['chat_to'] == $user) {
		 	$invite['Chat']['chat_to'] = "-1";
		 }
		 if ($myChat['Chat']['status'] == 0) {
		 	$invite['Chat']['status'] = 0;
		 } else {
		 	$invite['Chat']['status'] = 2;
		 }
		 $result = $this->Chat->save($invite);
		 unset($invite);
		}
		$this->__checkRoomUser();
		
		//check for response
		if (!$result) {
			echo "false";
			exit;
		}
		echo "true";
		exit;
	}

	/**
	 * Check room user count. If it is null then it will delete that row
	 * @param chat request id
	 * @return boolean
	 */
	public function __checkRoomUser()
	{
		$this->Chat->create();
		$roomRequest = $this->Chat->deleteAll(array('Chat.chat_from'=>'-1','Chat.chat_to'=>'-1'));
		
		//check for response
		return true;
	}

	/**
	 * Get the not joined active chats in the same section of the users
	 */
	public function getNotJoinedActiveChats()
	{
		$str1 = "";
		
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		//get joined users array
		$joined_users = array();
		$joined_users = $this->__joinedRoomUsers($user_course_section);

		//check if current users is the member of the room_name
		$notJoinedChat = array();
		foreach ($joined_users as $single_user) {

			if (in_array($user,$single_user['users'])) {

			} else {
				$notJoinedChat[] = array('room_name'=>$single_user['room_name']);
			}
		}
		
		//return $notJoinedChat;
		$join_img = $this->webroot."img/join.png";
		$active_users_img = $this->webroot."img/active_users.png";
		foreach ($notJoinedChat as $chat_session) {
			$str3 = array();
			$room_name = $chat_session['room_name'];
			$new_room = explode('_', $room_name);
			
			//get Active users joined to this room
			$active_users = $this->__getActiveUsersForRoom($room_name);
			foreach ($active_users as $active_user) {
				$str3[] = ucfirst($this->__getUserNickName($active_user));
			}
			$str2 = implode(',', $str3);
			$str1 .="<li class='pending_chat_session' id='room_".$room_name."'>
			<span>".ucfirst($course_name).'-'.date('m/d/Y/h:i:s A', $new_room[1])."&nbsp;&nbsp;&nbsp;&nbsp;<input type='image' src='$active_users_img' title='Active users' onClick=showGpActiveUsers('$room_name') />&nbsp;&nbsp;&nbsp;&nbsp;<input title='Click to join' type='image' src='$join_img' onClick=requestForJoin('$room_name') value='Join'/></span>
			<div class='ac_usr' id='ac_$room_name' style='display:none;'> ".ucfirst($str2)."</div></li>";
		}
		if ($str1 == "") {
			echo "<span class='noresultfound'>No result found</span>";
			exit;
		}
		echo $str1;
		exit;
	}

	/**
	 * Method to get joined users to room
	 * @param course name
	 * @return users array
	 */
	public function __joinedRoomUsers($user_course_section)
	{
		$chat_sessions  = array();
		$result = array();

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		
		//finding the current setting of the admin(in section/all section)
		$setting_result  = $this->__getDbSetting($user_course_section);
		
		//get current active room name according to the in-section/all-section setting for which user has not joined
		if ($setting_result == 1) { // for in-section setting

			$chat_sessions = $this->Chat->find('all',array('conditions'=>
					array( 'Chat.from_course_section'=>$user_course_section,
							'Chat.to_course_section'=>$user_course_section,
							'Chat.status'=>2
					),
					'fields' => array('Chat.room_name'),
					'group' => array('Chat.room_name')
			));
		}
		if($setting_result == 2) //for all-section setting
			$chat_sessions = $this->Chat->find('all',array('conditions'=>
					array( 'OR'=>array('Chat.from_course_section LIKE'=>$course_name."%",
							'Chat.to_course_section LIKE'=>$course_name."%"),
							'Chat.status'=>2
					),
					'fields' => array('Chat.room_name'),
					'group' => array('Chat.room_name')
			));

		foreach ($chat_sessions as $chat_session) {
			$room_name = $chat_session['Chat']['room_name'];
			
			//get group user
			$joined_users = $this->Chat->find('all',array('conditions'=>array('Chat.room_name'=>$room_name)));
			foreach ($joined_users as $joined_user) {
				$room_name1 = $joined_user['Chat']['room_name'];
				$user1 = $joined_user['Chat']['chat_from'];
				$user2 = $joined_user['Chat']['chat_to'];
				$group[$room_name1][] =  $user1;
				$group[$room_name1][] =  $user2;

			}
			$result[$room_name]['users'] = array_unique($group[$room_name]);
			$result[$room_name]['room_name'] = $room_name;
		}
		return $result;
	}

	/**
	 * Method to request to join for a group chat
	 * @param roomName
	 */
	public function requestForJoin()
	{
		$roomName = $this->request->data['roomName'];
		
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$data['PendingRequest']['user_name'] = $user;
		$data['PendingRequest']['room_name'] = $roomName;
		
		//check if group is active
		$gpActive_count = $this->Chat->find('count',array(
				'conditions'=>array('room_name'=>$roomName),
				'fields'=>array('Chat.room_name')
		));
		if ($gpActive_count==0) {
			echo "no_gp_found";
			exit;
		}
		
		//check if same request has already sent
		$request_count = $this->PendingRequest->find('count',array(
				'conditions'=>array('user_name'=>$user,'room_name'=>$roomName),
				'fields'=>array('Chat.room_name')
		));
		if ($request_count>0) {
			echo "already_sent";
			exit;
		}
		
		//get current time
		$data['PendingRequest']['date'] = time();
		
		//set status 0 as pending
		$data['PendingRequest']['status'] = 0;
		$data['PendingRequest']['course_section'] = $userCourse[0];
		$this->PendingRequest->save($data);
		echo "success";
		exit;
	}

	/**
	 * Method for get notification on user home page for pending requests to join
	 * group chat
	 */
	public function pendingRequests()
	{
		//get current login user
		$str = "";
		$results = array();
		$user = $this->Session->read('UserData.userName');
		
		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		
		//finding the current setting of the admin(in section/all section)
		$setting_result  = $this->__getDbSetting($user_course_section);
		if($setting_result == 1)
			//get room_name for which the user is active member
			$rooms = $this->Chat->find('all',array(
					'conditions'=>array(
							'OR'=>array('Chat.chat_to'=>$user,'Chat.chat_from'=>$user), 'Chat.from_course_section'=>$user_course_section, 'Chat.to_course_section'=>$user_course_section,'Chat.status'=>2
					),
					'fields' => array('Chat.room_name'),
					'group'=>'Chat.room_name'));
		if($setting_result == 2)
			//get room_name for which the user is active member
			$rooms = $this->Chat->find('all',array(
					'conditions'=>array(
							array('OR'=>array('Chat.chat_to'=>$user,'Chat.chat_from'=>$user)), array('OR'=>array('Chat.from_course_section LIKE '=>$course_name."%", 'Chat.to_course_section LIKE '=>$course_name."%")), 'Chat.status'=>2
					),
					'fields' => array('Chat.room_name'),
					'group'=>'Chat.room_name'));
		//get pending request
		foreach ($rooms as $room) {
			$room_name = $room['Chat']['room_name'];
			$results[] = $this->PendingRequest->find('all',array('conditions'=>
					array('PendingRequest.room_name'=>$room_name,'PendingRequest.status'=>0)
			));

		}
		$accept_imgsrc= $this->webroot."img/accept.png";
		$reject_imgsrc= $this->webroot."img/reject.png";
		foreach ($results as  $pending_chatrequests) {

			foreach ($pending_chatrequests as $pending_chatrequest) {
				$id = $pending_chatrequest['PendingRequest']['id'];
				$room_name = $pending_chatrequest['PendingRequest']['room_name'];
				$new_room = explode('_', $room_name);
				$user_name = $pending_chatrequest['PendingRequest']['user_name'];
				$course_section = $pending_chatrequest['PendingRequest']['user_name'];
				$str .= "<li class='crq' id='crd".$id."'><span>".ucfirst($this->__getUserNickName($user_name))." wants to join chat in group ".ucfirst($course_name).'-'.date('m/d/Y/h:i:s A', $new_room[1])."</span><span class='prq_icon'><input title='Accept' type='image' src='$accept_imgsrc' onClick=acceptRequest('$id','$room_name') />&nbsp;&nbsp;&nbsp;<input title='Reject' type='image' src='$reject_imgsrc' onClick='rejectRequest($id)' /></span></li>";
			}
		}

		if ($str == "") {
			echo "<span class='noresultfound'>No result found</span>";
			exit;
		}
		echo $str;
		exit;
	}

	/**
	 * Method for get notification count on user home page for pending requests to join
	 * group chat
	 */
	public function pendingRequestsCount()
	{
		//get initial value for old and new count
		$roldCount = $this->Session->read('roldCount');
		$rnewCount = $this->Session->read('rnewCount');
		
		//get current login user
		$str = "";
		$results = array();
		$user = $this->Session->read('UserData.userName');
		
		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		
		//finding the current setting of the admin(in section/all section)
		$setting_result  = $this->__getDbSetting($user_course_section);
		if($setting_result == 1)
			//get room_name for which the user is active member
			$rooms = $this->Chat->find('all',array(
					'conditions'=>array(
							'OR'=>array('Chat.chat_to'=>$user,'Chat.chat_from'=>$user), 'Chat.from_course_section'=>$user_course_section, 'Chat.to_course_section'=>$user_course_section,'Chat.status'=>2
					),
					'fields' => array('Chat.room_name'),
					'group'=>'Chat.room_name'));
		if($setting_result == 2)
			//get room_name for which the user is active member
			$rooms = $this->Chat->find('all',array(
					'conditions'=>array(
							array('OR'=>array('Chat.chat_to'=>$user,'Chat.chat_from'=>$user)), array('OR'=>array('Chat.from_course_section LIKE '=>$course_name."%", 'Chat.to_course_section LIKE '=>$course_name."%")), 'Chat.status'=>2
					),
					'fields' => array('Chat.room_name'),
					'group'=>'Chat.room_name'));
		//get pending request
		foreach ($rooms as $room) {
			$room_name = $room['Chat']['room_name'];
			$results_data = $this->PendingRequest->find('all',array('conditions'=>
					array('PendingRequest.room_name'=>$room_name,'PendingRequest.status'=>0,'PendingRequest.is_read'=>0)
			));
			if($results_data)
				$results[]  = $results_data;
		}
		$notify_count = count($results);

		//check to show alert notification
		$rnewCount = $notify_count;
		if ($roldCount < $rnewCount) {
			$showAlert = 1;
		} else {
			$showAlert = 0;
		}
		$roldCount = $rnewCount;
		$this->Session->write('roldCount',$roldCount);
		$this->Session->write('rnewCount',$rnewCount);
		$data = array('count'=>$notify_count,'showAlert'=>$showAlert);
		return $data;
		//echo json_encode($data);
		//exit;
	}

	/**
	 * Acceting the request by user
	 */
	public function approveChatRequests()
	{
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$id = $this->request->data['id'];

		//check if user has already added to the room chat
		$is_join = $this->PendingRequest->find('count',array('conditions'=>
				array('PendingRequest.id'=>$id,'PendingRequest.status'=>0)
		));

		if ($is_join==0) {
			echo "Request is already accepted by active member of this group.";
			exit;
		}

		$results = $this->PendingRequest->find('first',array('conditions'=>
				array('PendingRequest.id'=>$id,'PendingRequest.status'=>0)
		));
			
		$data['Chat']['chat_from'] = $user;
		$data['Chat']['chat_to'] = $results['PendingRequest']['user_name'];
		$data['Chat']['room_name'] = $results['PendingRequest']['room_name'];
		$data['Chat']['status'] = 0;
		$data['Chat']['from_course_section'] = $userCourse[0];
		$data['Chat']['to_course_section'] = $results['PendingRequest']['course_section'];
		$data['Chat']['request_date'] = time();
			

		$response = $this->Chat->save($data);
		if ($response) {
			$roomRequest = $this->PendingRequest->deleteAll(array('PendingRequest.id'=>$id));
		}
		echo "Request accepted";
		exit;
	}

	/**
	 * Method to reject the chat request by user
	 */
	public function rejectChatRequests()
	{
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');

		//get request id
		$id = $this->request->data['id'];

		//check if user has already added to the room chat
		$is_join = $this->PendingRequest->find('count',array('conditions'=>
				array('PendingRequest.id'=>$id,'PendingRequest.status'=>0)
		));

		if ($is_join==0) {
			echo "Request is already rejected by active member of this group.";
			exit;
		}

		$requestData = $this->PendingRequest->find('first',array('conditions'=>array('PendingRequest.id'=>$id)));

		//current login user name
		$fromUser = $user;
		$fromCourse = $userCourse[0];
		$toUser = $requestData['PendingRequest']['user_name'];
		$toCourse = $requestData['PendingRequest']['course_section'];
		$roomName = $requestData['PendingRequest']['room_name'];
		$data['Chat']['chat_from']=$toUser;
		$data['Chat']['chat_to']=$fromUser;
		$data['Chat']['room_name']=$roomName;
		$data['Chat']['status']=1;
		$data['Chat']['from_course_section']=$fromCourse;
		$data['Chat']['to_course_section']=$toCourse;
		$data['Chat']['request_date']= $requestData['PendingRequest']['date'];
		
		//save the record in pending request table as request rejected
		$this->Chat->save($data);
		
		//delete the request from table
		$result = $this->PendingRequest->deleteAll(array('PendingRequest.id'=>$id));
		if ($result) {
			echo "Request Rejected";
			exit;
		}
	}

	/**
	 * Method for getting current user courseName
	 */
	public function getCourseName() {
		//get current login user
		$userCourses = $this->Session->read('UserData.usersCourses');
		echo $userCourses[0];
		exit;
	}

	/**
	 * Method to get active users for room
	 * @param room name
	 * @return users array
	 */
	public function __getActiveUsersForRoom($roomName) {

		//get group user
		$joined_users = $this->Chat->find('all',array('conditions'=>array('Chat.room_name'=>$roomName,'status'=>2)));
		foreach ($joined_users as $joined_user) {
			$room_name1 = $joined_user['Chat']['room_name'];
			$user1 = $joined_user['Chat']['chat_from'];
			$user2 = $joined_user['Chat']['chat_to'];
			$group[$room_name1][] =  $user1;
			$group[$room_name1][] =  $user2;
		}
		$result = array_unique($group[$roomName]);
		$unique_users = array_diff($result, array("", "-1"));
		return $unique_users;
	}

	/**
	 * Method for getting the notification when the receiver rejected the chat request
	 * @return (string) msg
	 */
	public function getDeniedChatMsg()
	{
		$results = array();
		//get current login user
		$user = $this->Session->read('UserData.userName');
		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		//finding the current setting of the admin(in section/all section)
		$setting_result  = $this->__getDbSetting($user_course_section);
		if($setting_result == 1)
			$results = $this->Chat->find('all',array(
					'conditions'=>array('Chat.chat_from'=>$user,'Chat.status'=>1,'NOT'=>array('Chat.chat_to'=>array(-1)), 'Chat.from_course_section'=>$user_course_section, 'Chat.to_course_section'=>$user_course_section),
					'fields'=>array('Chat.id','Chat.chat_to','Chat.room_name')
			));
		if($setting_result == 2)
			$results = $this->Chat->find('all',array(
					'conditions'=>array('Chat.chat_from'=>$user,'Chat.status'=>1,'NOT'=>array('Chat.chat_to'=>array(-1)), 'OR'=>array('Chat.from_course_section LIKE '=>$course_name."%", 'Chat.to_course_section LIKE '=>$course_name."%")),
					'fields'=>array('Chat.id','Chat.chat_to','Chat.room_name')
			));
		$reject_imgsrc= $this->webroot."img/reject.png";
		$msgstr = "";
		foreach ($results as $result) {
			$id = $result['Chat']['id'];
			$to = $result['Chat']['chat_to'];
			$room_name = $result['Chat']['room_name'];
			$new_room = explode('_', $room_name);
			$msgstr .= "<li id='del_".$id."' ><span class='denied_message_chat'>".ucfirst($this->__getUserNickName($to))." has rejected your chat request for group ".ucfirst($course_name).'-'.date('m/d/Y/h:i:s A', $new_room[1])."
			</span><input type='image' src='$reject_imgsrc' onClick=hideNotification('$id') /></li>";
		}

		if ($msgstr == "") {
			echo "<span class='noresultfound'>No result found</span>";
			exit;
		}
		echo $msgstr;
		exit;
	}

	/**
	 * Method for getting the notification count when the receiver rejected the chat request
	 * @return (string) msg
	 */
	public function getDeniedChatMsgCount()
	{

		//get initial value for old and new count
		$doldCount = $this->Session->read('doldCount');
		$dnewCount = $this->Session->read('dnewCount');

		$results = array();
		
		//get current login user
		$user = $this->Session->read('UserData.userName');
		
		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
			
		//finding the current setting of the admin(in section/all section)
		$setting_result  = $this->__getDbSetting($user_course_section);
		if($setting_result == 1)
			$results = $this->Chat->find('count',array(
					'conditions'=>array('Chat.chat_from'=>$user,'Chat.status'=>1,'Chat.dis_read'=>0,'NOT'=>array('Chat.chat_to'=>array(-1)), 'Chat.from_course_section'=>$user_course_section, 'Chat.to_course_section'=>$user_course_section),
					'fields'=>array('Chat.id','Chat.chat_to','Chat.room_name')
			));
		if($setting_result == 2)
			$results = $this->Chat->find('count',array(
					'conditions'=>array('Chat.chat_from'=>$user,'Chat.status'=>1,'Chat.dis_read'=>0,'NOT'=>array('Chat.chat_to'=>array(-1)), 'OR'=>array('Chat.from_course_section LIKE '=>$course_name."%", 'Chat.to_course_section LIKE '=>$course_name."%")),
					'fields'=>array('Chat.id','Chat.chat_to','Chat.room_name')
			));


		//check to show alert notification
		$dnewCount = $results;
		if ($doldCount != $dnewCount) {
			$showAlert = 1;
		} else {
			$showAlert = 0;
		}

		$doldCount = $dnewCount;

		$this->Session->write('doldCount',$doldCount);
		$this->Session->write('dnewCount',$dnewCount);

		$data = array('count'=>$results,'showAlert'=>$showAlert);
		return $data;
		//echo json_encode($data);
		//exit;

	}

	/**
	 * Method to delete the notification for request deny
	 */
	public function hideNotification()
	{
		//set notification
		$doldCount = $this->Session->read('doldCount');
		if ($doldCount>0) {
			$dnewCount = $doldCount-1;
			$this->Session->write('doldCount',$dnewCount);
		}
		$id = $this->request->data['id'];
		$query = $this->Chat->delete(array('Chat.id'=>$id));
		if ($query) {
			echo "true";
			exit;
		}
		echo "false";
		exit;
	}

	/**
	 * Method to get Admin DB setting
	 */
	public function getSectionType()
	{

		//get current login user
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course_name_explode);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$result = $this->PleSetting->find('first',array('conditions'=>array('PleSetting.setting_type'=>'section', "PleSetting.course"=>$course_name,"PleSetting.section"=>$course_section)));
		
		//return secion setting
		if(count($result))
			echo $result['PleSetting']['setting_value'];
		else
			echo 1;
		exit;
	}

	/**
	 * Method to get User first name and last from openfire
	 * @param username
	 * return string
	 */
	public function __getUserNickName($userName)
	{
		$result = $this->ChatUser->find('first',array('conditions'=>array('ChatUser.username'=>$userName),
				'fields'=>array('ChatUser.name','ChatUser.email')));

		//check for Nick Name , If nick name is null then it will return userName
		if ($result['ChatUser']['name']=="") {
			$data['name'] =  $userName;
		} else {
			$data['name'] =  $result['ChatUser']['name'];
		}
		return $data['name'];
	}

	/**
	 * Method to get userType student/instructor
	 */
	public function getUserType()
	{
		$user = $this->request['data']['userType'];
		$gid = $this->request['data']['gid'];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($gid);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$result['PleUser']['user_type']="";
		$checkUser = $this->PleUser->find('count',array('conditions'=>array('PleUser.midasId'=>$user,'PleUser.course'=>$course_name)));
		if ($checkUser==1) {
			$result = $this->PleUser->find('first',array('conditions'=>array('PleUser.midasId'=>$user,'PleUser.course'=>$course_name),'fields'=>'PleUser.user_type'));
		}
		echo ucfirst($result['PleUser']['user_type']);
		exit;
	}

	/**
	 * Finding the rosters
	 */
	public function getRoasterUser(){
		$user = $this->request['data']['userType'];
		$gid = $this->request['data']['gid'];

        //get Course and section name
        $course_info = $this->getCourseNameOfUser($gid);
        $course_name = $course_info->course_name;
        $course_section = $course_info->section_name;		
		//get section setting to check if allsection
		$result = $this->PleSetting->find('first',array('conditions'=>array('PleSetting.course'=>$course_name,'PleSetting.section'=>$course_section)));
		if ($result) {
		 $setting = $result['PleSetting']['setting_value'];
		 echo $setting;
		}
		exit;
	}


	/**
	 * Method to mark notification as read
	 */
	public function markNotificationAsRead()
	{
		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$requests = array();
		
		//finding the current setting of the admin(in section/all section)
		$result  = $this->__getDbSetting($user_course_section);
		
		//set notification
		$this->Session->write('oldCount',0);
		
		//get current login user
		$user = $this->Session->read('UserData.userName');
		if($result == 2) { // for all-section setting
			$this->Chat->updateAll(
					array('Chat.pis_read' => 1),
					array('Chat.chat_to' => $user,  "Chat.to_course_section LIKE"=> $course_name."%")
			);
		}
		if ($result == 1) { //for in-section setting

			$this->Chat->updateAll(
					array('Chat.pis_read' => 1),
					array('Chat.chat_to' => $user, "Chat.from_course_section"=>$user_course_section, "Chat.to_course_section"=>$user_course_section)
			);
		}
		echo "true";
		exit;
	}

	/**
	 * Method to mark Deny notification as read
	 */
	public function markDenyNotificationAsRead() {
		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$requests = array();
		
		//finding the current setting of the admin(in section/all section)
		$result  = $this->__getDbSetting($user_course_section);
		
		//set notification
		$this->Session->write('doldCount',0);
		
		//get current login user
		$user = $this->Session->read('UserData.userName');
		if ($result == 2) { // for all-section setting
			$this->Chat->updateAll(
					array('Chat.dis_read' => 1),
					array('Chat.chat_from' => $user,  'OR'=>array('Chat.from_course_section LIKE '=>$course_name."%", 'Chat.to_course_section LIKE '=>$course_name."%"))
			);
		}
		if ($result == 1) { //for in-section setting

			$this->Chat->updateAll(
					array('Chat.dis_read' => 1),
					array('Chat.chat_from' => $user, "Chat.from_course_section"=>$user_course_section, "Chat.to_course_section"=>$user_course_section)
			);
		}
		echo "true";
		exit;
	}

	/**
	 * function(ajax call) for saving the data for invited users for a chat room
	 * @params chatroom, invited users
	 * @return jsonEncoded array
	 */
	public function invitedUsers()
	{
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$chat_room = $this->request->data['chat_room_name'];
		$chat_room_explore = @explode('@', $chat_room);
		$invited_room_users = $this->request->data['iniviteusers'];
		$invites = array();
		$invites = @explode(',', $invited_room_users);
		$data = array();
		foreach (@$invites as $invited_users) {
			$invited_users_name = @explode("@", $invited_users);
			
			//checking the user is already invited for the same group and not invited yet.
			$requested_data = $this->Chat->find('first', array('conditions'=>
					array("Chat.chat_from"=>$user, "Chat.chat_to"=> $invited_users_name[0], "Chat.room_name"=> $chat_room_explore[0], "Chat.status"=> 0)));
			if (!count($requested_data)) {
				
				// Create: id isn't set or is null
				$this->Chat->create();
				$data['Chat']['chat_from'] = $user; // test to be changed with logged-in user name
				$data['Chat']['chat_to'] = $invited_users_name[0];
				$data['Chat']['room_name'] = $chat_room_explore[0];
				$data['Chat']['from_course_section'] = $userCourse[0];
				$data['Chat']['to_course_section'] = trim($invited_users_name[1], ' ');
				$data['Chat']['status'] = 0;
				$data['Chat']['request_date'] = time();
				$this->Chat->save($data);
			}
		}
		echo json_encode($chat_room);
		exit;
	}

   /**
    * function(ajax call) for finding the current users of the chat room
	* those are using the chat room
	* @params chat_room
	* @return jsonEncoded array
	*/
	public function getCurrentRoomUsers()
	{
		$chat_room = $this->request->data['chatroom_name'];
		$chat_room_explore = @explode('@', $chat_room); //removing the  service
		$current_room_users = array();
		$unique_users = array();
		if (!empty($chat_room)) {
			$response_data = $this->Chat->find('all', array('conditions'=>array("OR"=> array("Chat.status"=>array(0,2)),
					"Chat.room_name"=> $chat_room_explore[0]))); //finding the users those are requested or joined the room.
			foreach (@$response_data as $current_users) {
				$current_room_users[] = $current_users['Chat']['chat_from'];
				$current_room_users[] = $current_users['Chat']['chat_to'];
			}
			$unique_users = array_unique($current_room_users);
			$unique_users = array_diff($unique_users, array("", "-1"));
		}
		$sd = array();
		foreach ($unique_users as $unique_users1) {
			$sd[] = $unique_users1;
		}
		echo json_encode($sd);
		exit;
	}

   /**
	* function(ajax call) for finding the current users of the chat room
	*  those are using the chat room
	*  @params chatroomname
	*  @return array
	*/
	public function getRoomsUsers()
	{
		$chat_rooms = $this->request->data['chatroomname'];
		$chat_room_explored = @explode('@', $chat_rooms); //removing the  service
		$current_room_users = array();
		$unique_users = array();
		if (!empty($chat_rooms)) {
			$response_data = $this->Chat->find('all', array('conditions'=>array("OR"=> array("Chat.status"=>array(2)),
					"Chat.room_name"=> $chat_room_explored[0]))); //finding the users those are requested or joined the room.
			foreach (@$response_data as $current_users) {
				$current_room_users[] = $current_users['Chat']['chat_from'];
				$current_room_users[] = $current_users['Chat']['chat_to'];
			}
			$unique_users = array_unique($current_room_users);
			$unique_users = array_diff($unique_users, array("", "-1"));
		}
		$resultArray = array();
		foreach ($unique_users as $unique_users1) {
			$resultArray[] = $unique_users1;
		}
		
		//second data
		
		$current_room_users_new = array();
		$unique_users_new = array();
		if (!empty($chat_rooms)) {
			$response_data1 = $this->Chat->find('all', array('conditions'=>array("OR"=> array("Chat.status"=>array(0,2)),
					"Chat.room_name"=> $chat_room_explored[0]))); //finding the users those are requested or joined the room.
			foreach (@$response_data1 as $current_users1) {
				$current_room_users_new[] = $current_users1['Chat']['chat_from'];
				$current_room_users_new[] = $current_users1['Chat']['chat_to'];
			}
			$unique_users_new = array_unique($current_room_users_new);
			$unique_users_new = array_diff($unique_users_new, array("", "-1"));
		}
		$resultArray1 = array();
		foreach ($unique_users_new as $unique_users_new1) {
			$resultArray1[] = $unique_users_new1;
		}
		
		$final_array = array();
		$final_array['getroomusers'] = $resultArray;
		$final_array['showinvitedusers'] = $resultArray1; 
		//second data end
		echo json_encode($final_array);
		exit;
	}
	
   /**
    * function(ajax call) for finding the current users of the chat room
	* those are using the chat room
	* @params chatroomname
	* @return string
	*/
	public function getRoomsUsersInvited()
	{
		$chat_rooms = $this->request->data['chatroomname'];
		$chat_room_explored = @explode('@', $chat_rooms); //removing the  service
		$current_room_users = array();
		$unique_users = array();
		if (!empty($chat_rooms)) {
			$response_data = $this->Chat->find('all', array('conditions'=>array("OR"=> array("Chat.status"=>array(0,2)),
					"Chat.room_name"=> $chat_room_explored[0]))); //finding the users those are requested or joined the room.
			foreach (@$response_data as $current_users) {
				$current_room_users[] = $current_users['Chat']['chat_from'];
				$current_room_users[] = $current_users['Chat']['chat_to'];
			}
			$unique_users = array_unique($current_room_users);
			$unique_users = array_diff($unique_users, array("", "-1"));
		}
		$resultArray = array();
		foreach ($unique_users as $unique_users1) {
			$resultArray[] = $unique_users1;
		}
		$final_array = array();
		$final_array['showinvitedusers'] = $resultArray;
		//second data end
		echo json_encode($final_array);
		exit;
	}

   /**
	* function for sending the chat scipt on the user email
	* @params chat_data
	* @return string
	*/
	public function sendNewUserMail()
	{
		//get current login user
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		//finding the email id of the user for sending the chat script on mail..
		$email_address = $this->EmailUser->find('first', array('conditions'=>array('EmailUser.midas_id'=>$user), 'fields'=>array('EmailUser.email')));
		$this->Email->layout = 'chat'; //view/Layouts/Emails/html
		$chat_data = $_POST['chat_html'];
		$this->set('content', $chat_data);
		$this->Email->to = $email_address['EmailUser']['email'];
		$this->Email->subject = 'Welcome to Chat';
		$this->Email->from = Configure::read('mail-from');
		$this->Email->template = 'chat';
		
		//Send as 'html', 'text' or 'both' (default is 'text') because we like to send pretty mail
		$this->Email->sendAs = 'both';
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
		$this->Email->send($chat_data);
		echo "send chat in mail";
		exit;
	}

   /**
	* Getting the user firstname and lastname from username
	* @params usename from session
	*/
	public function getUserName()
	{
		//get's current login user
		$user = $this->Session->read('UserData.userName');
		
		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$name = $this->PleUser->find('first', array('conditions'=>array('PleUser.course'=>$course_name, 'PleUser.userName'=>$user), 'fields'=>array('PleUser.name')));
		return @$name['PleUser']['name'];
	}
	
	/**
	 * Making the log file for the response from openfire via gab js(strophe)
	 * @ajax call
	 * @param none
	 * @return none
	 */
	public function generateConnectionLog()
	{
		$data = $this->request['data'];
		$userName = $data['jid'];
		$response = $data['response'];
		$time = time();
		$msg = "Request on ".date('m-d-y H:i:s')." by ".$userName." Reponse is ".$response." \n";
		//error_log($msg, 1, "yogendra.singh@daffodilsw.com", 'From: abhishek.gupta@daffodilsw.com');
		$logpath =  '../'.WEBROOT_DIR."/files/plelogs/chat-errors.log";
		error_log($msg, 3, $logpath); //writing the logs..
		exit;
	}
	
	/**
	 * Making the log file for the response from openfire via groupie js(strophe)
	 * @ajax call
	 * @param none
	 * @return none
	 */
	public function generateGroupConnectionLog()
	{
		$data = $this->request['data'];
		$userName = $data['jid'];
		$response = $data['response'];
		$time = time();
		$msg = "Request on ".date('m-d-y H:i:s')." by ".$userName." Reponse is ".$response." \n";
		//error_log($msg, 1, "yogendra.singh@daffodilsw.com", 'From: abhishek.gupta@daffodilsw.com');
		$logpath =  '../'.WEBROOT_DIR."/files/plelogs/chat-group-errors.log";
		error_log($msg, 3, $logpath); //writing the logs..
		exit;
	}
	
	/**
	 * Checking the who's online availabilty and is not disabled
	 * @params void
	 * @retutn boolean
	 */
	private function _checkOnlineAvailabilty()
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
	
		
		//finding the current setting of the who's online setting (enable/disable)
		$setting_result = $this->PleSetting->find('first', array('conditions'=>array('PleSetting.course'=>$course_info->course_name,
				'PleSetting.section'=>$course_info->section_name), 'fields'=>array('PleSetting.setting_value')));
		if(count($setting_result)>0) {
		if ($setting_result['PleSetting']['setting_value'] == 3)
			return true;
			return false;
		}
		return false;
	}
	
	/**
	 * Method for getting current user courseName
	 */
	public function getChatCourseName() {
		//get current login user
		$userCourses = $this->Session->read('UserData.usersCourses');
		return $userCourses[0];
		exit;
	}

	/**
	 * Get insection and all section setting
	 */
	public function getChatSectionType()
	{
		//get current login user
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];
	
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course_name_explode);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$result = $this->PleSetting->find('first',array('conditions'=>array('PleSetting.setting_type'=>'section', "PleSetting.course"=>$course_name,"PleSetting.section"=>$course_section)));
	
		//return secion setting
		if(count($result))
			return $result['PleSetting']['setting_value'];
		else
			return 1;
		exit;
	}
	
	/**
	 * Getting the users by  current logged-in user's courseName
	 * @param void
	 * @return string
	 */
	public function getSameCourseUsersList()
	{
		$courses = $this->Session->read('UserData.usersCourses');
		$user_course = $courses[0];
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$user = array();
		$results = $this->PleUser->find('all',array('conditions'=>array('course'=>$course_name),
				'fields'=>array('PleUser.midasId')
		));
	
		foreach ($results as $result) {
			$user[] = $result['PleUser']['midasId'];
		}
        $user_list = implode(',', $user);
        return $user_list;
	}
	
	/**
	 * Method to get chat userType student/instructor
	 */
	public function getChatUserType()
	{
		//get current login user
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];
	
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course_name_explode);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$result = array();
		$checkUser = $this->PleUser->find('count',array('conditions'=>array('PleUser.course'=>$course_name, 'PleUser.user_type'=>'instructor')));
	
		if ($checkUser) {
			$result = $this->PleUser->find('all',array('conditions'=>array('PleUser.course'=>$course_name, 'PleUser.user_type'=>'instructor'),'fields'=>array('PleUser.midasId', 'PleUser.course', 'PleUser.section')));
		}

		return $result;
	}
	
	/**
	 * Finding the rosters
	 */
	public function getChatRoasterUser()
	{
		$result = array();
		//get current login user
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];
	
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course_name_explode);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		//get section setting to check if allsection
		$result = $this->PleSetting->find('all',array('conditions'=>array('PleSetting.course'=>$course_name), 'fields' => array('PleSetting.course', 'PleSetting.setting_value', 'PleSetting.section')));
		return $result;
	}
	
	/**
	 * saving the logs data of current online users for logs
	 * @param void
	 * @return boolean
	 */
	private function _saveCurrentOnlineLogs()
	{
		$data = array();
		
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourses = $this->Session->read('UserData.usersCourses');
		$course_name_explode = $userCourses[0];
		
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course_name_explode);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		//getting session info
		$session_info = $this->getSessionNameOfUser($course_name_explode);
		$session_name = $session_info->session_name;
		//checking the user is already online for the same course.
		$result_data = $this->ChatCurrentOnlineLog->find('first', array('conditions'=>
				array("ChatCurrentOnlineLog.midas_id"=>$user, "ChatCurrentOnlineLog.course"=> $course_name, "ChatCurrentOnlineLog.section"=> $course_section, "ChatCurrentOnlineLog.session"=> $session_name)));
		if (!count($result_data)) {
		
			// Create: id isn't set or is null
			$this->ChatCurrentOnlineLog->create();
			$data['ChatCurrentOnlineLog']['midas_id']   = $user; // test to be changed with logged-in user name
			$data['ChatCurrentOnlineLog']['course']     = $course_name;
			$data['ChatCurrentOnlineLog']['section']    = $course_section;
			$data['ChatCurrentOnlineLog']['session']    = $session_name;
			$data['ChatCurrentOnlineLog']['time']       = time();
			$this->ChatCurrentOnlineLog->save($data);
		} else {
			$this->ChatCurrentOnlineLog->id       = $result_data['ChatCurrentOnlineLog']['id'];
			$data['ChatCurrentOnlineLog']['time'] = time();
			$this->ChatCurrentOnlineLog->save($data);
		}
		return true;
	}
	
	/**
	 * clear the current online user logs
	 * ajax call
	 * @return none
	 */
	public function clearCurrentOnlineLogs()
	{
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
		$result_data   = $this->ChatCurrentOnlineLog->find('first', array('conditions'=>
				array("ChatCurrentOnlineLog.midas_id"=>$user, "ChatCurrentOnlineLog.course"=> $course_name, "ChatCurrentOnlineLog.section"=> $course_section, "ChatCurrentOnlineLog.session"=> $session_name)));
		$this->ChatCurrentOnlineLog->delete($result_data['ChatCurrentOnlineLog']['id']);
	}
	
	/**
	 * saving the data for chat session logs
	 * @param int $chat_id
	 * @param string $room_name
	 */
	private function _saveChatSessionLogs($chat_id, $room_name, $type)
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
		
		//prepare the data to be saved.
		$data['ChatSessionLog']['chat_id']         = $chat_id;
		$data['ChatSessionLog']['chat_name']       = $room_name;
		$data['ChatSessionLog']['midas_id']        = $user;
		$data['ChatSessionLog']['time']            = time();
		$data['ChatSessionLog']['course']          = $course_name;
		$data['ChatSessionLog']['section']         = $course_section;
		$data['ChatSessionLog']['session']         = $session_name;
		$data['ChatSessionLog']['chat_type']       = 1;
		$data['ChatSessionLog']['type']            = $type;
		$this->ChatSessionLog->create();
		$this->ChatSessionLog->save($data);
		return $this->ChatSessionLog->id;
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
		return $data;
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
	 * Common method to get notifications count
	 */
	public function getRequestsAvailableCount()
	{
		$pending_req['getpendingrequestcount'] = $this->getPendingRequestsCount();
		
		$pending_req['pendingrequestcount'] = $this->pendingRequestsCount();
		
		$pending_req['getdeniedchatmsgcount'] = $this->getDeniedChatMsgCount();
		
		$pending_req['getmeetingrequestcount'] = $this->getMeetingRequestsCount();
		
		$pending_req['onlineuserlist'] = $this->getOnlineCourseUsersList(); //latest line edit
		echo json_encode($pending_req);
		exit;
	}
	
	/**
	 * Getting the users by  current logged-in user's courseName
	 * @param void
	 * @return string
	 */
	public function getOnlineCourseUsersList()
	{
		$courses = $this->Session->read('UserData.usersCourses');
		$user_course = $courses[0];
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$user = array();
		$results = $this->User->find('all',array('conditions'=>array('course'=>$course_name),
				'fields'=>array('User.midasId')
		));
	
		foreach ($results as $result) {
			$user[] = $result['User']['midasId'];
		}
		$user_list = implode(',', $user);
		return $user_list;
	}
}