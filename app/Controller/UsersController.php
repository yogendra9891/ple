<?php
/**
 * User management controller.
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
 * User management controller yogi + abhishek
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class UsersController extends AppController {

	
	public $uses = array('User', 'Group', 'GroupProp', 'GroupUser', 'Chat','PleUser', 'PleSetting', 'ChatOnlineLog');

     /**
	 * Method to initialise the bosh url
	 */
	public function beforeFilter()
	{
	//get chatServer host url global setting from bootstrap.php
	$boshUrl = Configure::read('bosh_url');
	//get and set site url
       $siteUrl = Configure::read('site_url');
       $this->set('siteUrl',$siteUrl);
       $this->set('boshUrl',$boshUrl);
	}
       
     /**
	 * Method to check the user Login session
	 * @param userId
	 * @return boolean true,false
	 * @throws NotFoundException When the view file could not be found
	 *	or MissingViewException in debug mode.
	 */
	public function __checkLoginSession($uid=null)
	{
		//check for valid request
		try {
			//check for valid userId
			if ($uid) {
				// create a new cURL resource
				$ch = curl_init();
				$timeout=5;
				$data = array('uid' =>$uid);
				// set URL and other appropriate options
				curl_setopt($ch,CURLOPT_URL, Configure::read('site_url'));
				//TRUE to do a regular HTTP POST.
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
				//TRUE to return the transfer as a string of the return value
				curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
				curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
				// grab URL and pass it to the browser
				$data = curl_exec($ch);
				// close cURL resource, and free up system resources
				curl_close($ch);
				//set true to convert into an array
				$decode_data = json_decode($data,'true');
				//check for true or false
				if($decode_data['statusCode'] == '1'){
					return "true";
				}else{
					return "false";
				}
			} else {
				throw new NotFoundException('Could not find that User');
			}
		}
		catch (NotFoundException $e) {
			if (Configure::read('debug')) {
				throw $e;
			}
			throw new NotFoundException($e);
		}
		exit;

	}
   /**
    * 
    * @param varchar $user
    * @return none
    */
	public function chat($user){
		$this->set('user', $user);
	}
	
	/**
	 * function for first call from PLE site
	 * @param userObject
	 * @return none
	 */
	public function login($ruserobj=null){
		//$data = $this->request->data;
		
		if($ruserobj){
			//decode the bash64 encoded $ruserobj
			$ruserobj = base64_decode($ruserobj);
			
			//json decode
			$ruserdecodeObj = json_decode($ruserobj);
			$user = @$ruserdecodeObj->userName;
			$myCourse = @$ruserdecodeObj->course;
			$userType = @$ruserdecodeObj->userType;
			$useremail =  @$ruserdecodeObj->email;
			//@TODO we will change it by the data from PLE app of the current logged in user.
			$proposed_coursers = $myCourse;
			$explored_courses = explode('/', $proposed_coursers);
			$course_data = $data['user']['course'] = $proposed_coursers;
			
			//get Course and section name
			$course_info = $this->getCourseNameOfUser($course_data);

			$course_name = $course_info->course_name;
			$course_section = $course_info->section_name;
			$midasId = $data['user']['midasId'] = $user;
			$userType = $userType;
			$name = $user;
			$email = $useremail;
			$chat_password = Configure::read('chat_password');
			//prepare an array for saving the data in local DB.
			$userData = array("userName"=>trim(strtolower($user)),
					"midasId"=>trim(strtolower($user)),
					"course"=>trim($course_name),
					"section"=>trim($course_section),
					"password"=>$chat_password,
					"user_type"=>trim($userType),
					"name"=>trim($name),
					"email"=>trim($email)
			);
			foreach (@$explored_courses as $duplicate_courses) {
				$this->__assignGroup($duplicate_courses); //checking the group is exists in the chat server. if not save it in chat server.
			}
			//finding the groups(courses) of the user those are already assigned to user
			$assigned_group = array();
			$assigned_groups_combination = array();
			$assigned_group = $this->userGroup($user);
			$assigned_groups_combination = $assigned_group;
			$assigned_groups_combination[] = $explored_courses[0];
			$implode_courses =  implode(',', @$assigned_groups_combination);
			
			//register user in ple/daffodil server
			$regisetUser = $this->__registerPleUser($userData);
			if ($regisetUser) {
			//register the user in Openfire
			$result = $this->__registerUserInOpenfire($implode_courses, $userData, $assigned_group);

			if ($result) {
				//saving the PLE user in our local database.
				//check if user is already login
				$isLogin = $this->User->find('count',array('conditions'=>array('midasId'=>$midasId,'course'=>$course_name)));
				//if user is already logged in then it remove the prevoius entry
				if ($isLogin == 1) {
					$isLogin = $this->User->deleteAll(array('midasId'=>$midasId,'course'=>$course_name));
				}
				$this->User->save($userData);
				//set the user session
				$this->Session->write('UserData.userName', $user);
				//	$this->redirect(array("controller"=>"chats","action" => 'home',$user));
				$this->Session->write('UserData.usersCourses', $explored_courses);
				$this->Session->write('UserData.userType', $userType);
				
				//check if online avaibality is on or off
				//checking who's online is disabled
				$availability = $this->_checkOnlineAvailabilty();
				if(!$availability) {
					$this->_onlinePresenceLog();
				}
				
				$this->redirect(array('controller' => 'chats', 'action' => 'home', $user, $explored_courses[0]));
			} else
			  throw new NotFoundException('Unable to register the user to chat server');
			} else {
				throw new NotFoundException('Unable to register the user to ple/daffodil server');
			}
		}
	}
	
	/**
	 * Method for register a user in openFire(chat server)
	 * @params courseName, userData object.
	 * @return boolean
	 */
	public function __registerUserInOpenfire($course, $userData, $assigned_group){

		// create a new CURL resource
		$ch = curl_init();
		$timeout = 5;
		//get userServiceCode global setting from bootstrap.php
		$userServiceCode = Configure::read('userservice_token');
		
		//get chatServer host url global setting from bootstrap.php
		$chatServerHost = Configure::read('chatserver_host');
		$chat_password = Configure::read('chat_password');
		//vGbHPOcs
		$url1 = urlencode($chatServerHost."/plugins/userService/userservice?type=add&secret=".$userServiceCode."&username=".$userData['userName'].
		"&password=".$chat_password."&name=".$userData['userName']."&groups=".$course);
		$course = urlencode($course);
		$course =   str_replace( " ", "+", $course ); //removing the '+' from the encoded url by " ".
		$username = $userData['userName'];
		if(count($assigned_group))
		$url = $chatServerHost."/plugins/userService/userservice?type=update&secret=".$userServiceCode."&username=".$username.
                "&password=".$chat_password."&name=".$username."&groups=".$course;
		else
		$url = $chatServerHost."/plugins/userService/userservice?type=add&secret=".$userServiceCode."&username=".$username.
                "&password=".$chat_password."&name=".$username."&groups=".$course;
		// set URL and other appropriate options
		curl_setopt($ch,CURLOPT_URL,$url);
		//TRUE to do a regular HTTP POST.
		curl_setopt($ch, CURLOPT_POST, 1);
		//	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		//TRUE to return the transfer as a string of the return value
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
		// grab URL and pass it to the browser
		$data = curl_exec($ch);
		// close cURL resource, and free up system resources
		curl_close($ch);
		//handling for user is registered(new/exists) or not in openfire
		if(!($data == 'ok' || $data == 'UserAlreadyExistsException'))
		return true;
		else
		return false;
	}
	
	/**
	 * function for checking the group/section for the user.
	 * @params section of a user
	 * @return boolean
	 */
	private function __assignGroup($course)
	{
		$groupsResult = $this->Group->find('all');
		$trimedSection = trim($course, ' ');//remove the spaces from both side
		$i = 0;
		foreach($groupsResult as $groups)
		{
			if($groups["Group"]['groupName'] == $trimedSection)
			{
				$i = 1; //if section/group(course) exists in openfire chat server..
				break;
			}
		}
		if(!$i)
		{
			//prepare the array for saving the data in openfire 'ofGroup' table
			$groupData = array("groupName"=> $trimedSection, "description"=> 'Group for '.$trimedSection.' users');
			$groupDataProp1 = array("groupName"=> $trimedSection, "name"=> "sharedRoster.displayName", "propValue"=> $trimedSection);
			$groupDataProp2 = array("groupName"=> $trimedSection, "name"=> "sharedRoster.groupList", "propValue"=> '');
			$groupDataProp3 = array("groupName"=> $trimedSection, "name"=> "sharedRoster.showInRoster", "propValue"=> 'everybody');
			$this->Group->save($groupData);
			$this->GroupProp->saveGroupProp($groupDataProp1, $groupDataProp2, $groupDataProp3);
		}
		return true;
	}

	/*
	 * function for logout the user from PLE app
	 * @TODO also logout from Openfire.
	 */
	public function logOut()
	{
		
		//midasID/Username will be provided from PLE app
		$courses = $this->Session->read('UserData.usersCourses');
		$user_course = $courses[0];

		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course);
		
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;

		$midasId = $this->Session->read('UserData.userName');
	
		$userName = $this->Session->read('UserData.userName');
	
		//remove from the users table
		if($course_name != '')
		$this->User->deleteAll(array('midasId'=>$midasId,'course'=>$course_name));
		//leave all attending rooms.
	    
	    $resp = $this->__leaveRoom();
	    if($resp)
		@$this->Session->destroy();
	    $logout_url = Configure::read('logout_url');
	    return	$this->redirect($logout_url);
	}
	
	/*
	 * function for handling the redirection for the courses
	 * @params courses
	 */
	public function user_courses()
	{
		$userCourses = $this->Session->read('UserData.usersCourses');
		$this->set('user', $this->Session->read('UserData.userName'));
		$this->set('usersCourses', $userCourses);
	}

	/**
	 * Leave all room when the user get logout
	 * @param none
	 * @return boolean
	 */
	public function __leaveRoom()
	{

		//get current login user
		$user = $this->Session->read('UserData.userName');
		//get active chats
		$myChats = $this->Chat->find('all',array(
               'conditions'=>array("OR"=>
		array("Chat.chat_to"=>$user,'Chat.chat_from'=>$user))
		));
	
		foreach ($myChats as $myChat) {

			$invite['Chat']['id'] = $myChat['Chat']['id'];
			if($myChat['Chat']['chat_from'] == $user){
				$invite['Chat']['chat_from'] = "-1";
			}elseif($myChat['Chat']['chat_to'] == $user){
				$invite['Chat']['chat_to'] = "-1";
			}
			// $invite['Chat']['status'] = "2";
			if($myChat['Chat']['status']==2){
				$result = $this->Chat->save($invite);
			}
			unset($invite);
		}
		return true;
	}
	
	/**
	 * Getting the users by courseName ajax call
	 * @param jid
	 * @return string
	 */
	public function getSameCourseUsers(){
		$jid_remote = $this->request->data['jid'];
		$jid = explode('@',$jid_remote);
		$courses = $this->Session->read('UserData.usersCourses');
		$user_course = $courses[0];
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		
		$results = $this->User->find('all',array('conditions'=>array('course'=>$course_name),
		'fields'=>array('User.midasId','User.course','User.section')
		));
		
		foreach ($results as $result) {
			$user[] = $result['User']['midasId'];
		}

		if (in_array($jid[0],$user)) {
			echo "found";
			exit;
		}
		echo "notfound";
		exit;
	}
	
	
	/**
	 * Getting the user assigned group from chat server(course name
	 * @params username
	 * @return array
	 */
	 public function userGroup($user)
	 {
	 	$usergroups = array();
	 	$assigned_groups = array();
	 	$usergroups = $this->GroupUser->find('all', array("conditions"=>array('GroupUser.username'=>$user)));
	 	if (count($usergroups))
	 	 foreach ($usergroups as $groups)
	 	  $assigned_groups[] = $groups['GroupUser']['groupName'];
	 	return $assigned_groups;
	 }
	 
	 /**
	  * Method to register user in PLE.
	  * User will get register in every login, to get the update if user has changed his profile
	  * from ple site.
	  * @param user info
	  * @return boolean
	  */
	 public function __registerPleUser($userData)
	 {
	 	if ($userData) 
	 	{
	 		//check if user is already registered
	 		$is_register = $this->PleUser->find('first',array('conditions'=>array('midasId'=>$userData['midasId'],'course'=>$userData['course']),'fields'=>array('id')));
	 		//check if id exist
	 		if ($is_register['PleUser']['id']) {
	 			$userData['id'] = $is_register['PleUser']['id'];
	 			$this->PleUser->save($userData);
	 		} else {
	 			$this->PleUser->save($userData);
	 		}
	 		return true;
	 	}
	 	return false;
	 }
	 
	 /**
	 * Checking the user is online (ajax call)
	 * @params username
	 * @return string
	 */
	 public function getUserStatusData()
	 {
	 	//get's current login user
	 	$user = $this->Session->read('UserData.userName');
	 	//get the user course name.
	 	$userCourse = $this->Session->read('UserData.usersCourses');
	 	$user_course_section = $userCourse[0];
	 	//get Course and section name
	 	$course_info = $this->getCourseNameOfUser($user_course_section);
	 	$user_exploded_course = $course_info->course_name;
	 	$course_section = $course_info->section_name;
	 	$jid_remote = $this->request->data['jid'];
	 	$jid = explode('@',$jid_remote);
	 	$result = $this->User->find('count', array('conditions'=>array('User.course'=>$user_exploded_course, 'User.userName'=>$jid[0])));
	 	if($result==0)
	 		echo "logout";
	 	else
	 		echo "login";
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
	  * Create log history for the user presence for chat
	  * @return void
	  */
	 private function _onlinePresenceLog()
	 {
	 	//get current login user
	 	$user = $this->Session->read('UserData.userName');
	 	$userCourses = $this->Session->read('UserData.usersCourses');
	 	$course_name_explode = $userCourses[0];
	 
	 	//get Course and section name
	 	$course_info = $this->getCourseNameOfUser($course_name_explode);
	 	$course_name = $course_info->course_name;
	 	$section_name = $course_info->section_name;
	 
	 	//get session name
	 	$session_info = $this->getSessionNameOfUser($course_name_explode);
	 	$session_name = $session_info->session_name;
	 
	 	$this->ChatOnlineLog->create();
	 	//create data array
	 	$data['ChatOnlineLog']['midas_id'] = $user;
	 	$data['ChatOnlineLog']['time'] = time(); //current time
	 	$data['ChatOnlineLog']['course'] = $course_name;
	 	$data['ChatOnlineLog']['section'] = $section_name;
	 	$data['ChatOnlineLog']['session'] = $session_name;
	 	$log_err = $this->ChatOnlineLog->save($data);
	 
	 }
}


