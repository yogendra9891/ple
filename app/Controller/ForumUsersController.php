<?php
/**
 * User management controller.
 *
 * This file will render views from views/ForumUsers/
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
 * ForumUser management controller yogi + abhishek
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ForumUsersController extends AppController {
	
	public $uses = array('ForumUser','PleUser');
	
	/**
	 * Method to get the user logged in forum
	 * @param string $ruserobj
	 */
	public function login($ruserobj=null)
	{
		$data = $this->request['data'];
		if ($data) {
			//decode the bash64 encoded $ruserobj
			//$ruserobj = base64_decode($ruserobj);
			
			//json decode
			//$ruserdecodeObj = json_decode($ruserobj);
			//$user = $ruserdecodeObj->userName;
			//$myCourse = $ruserdecodeObj->course;
			 $user = $data['forumuser']['userName'];
			 $myCourse = $data['forumuser']['Course'];
			
			//@TODO we will change it by the data from PLE app of the current logged in user.
			$proposed_coursers = $myCourse;
			$explored_courses = explode('/', $proposed_coursers);
			$course_data = $data['user']['course'] = $proposed_coursers;
			//get explode the Course by "-" 
			$course_info = explode("-",$course_data);
			$course_name = $course_info[0];
			$course_section = $course_info[1];
			$midasId = $data['user']['midasId'] = $user;
			$userType = "student";
			$name = $user;
		//	$email = "test1@test.com";
			//prepare an array for saving the data in local DB.
			//$userData = array("userName"=>$user, "midasId"=>$user, "course"=>$course_name, "section"=>$course_section, "password"=>123456);
			$userData = array("userName"=>trim($user),
					"midasId"=>trim($user),
					"course"=>trim($course_name),
					"section"=>trim($course_section),
					"password"=>123456,
					"user_type"=>trim($userType),
					"name"=>trim($name)
					//,
			//		"email"=>trim($email)
			);
			//register user in ple/daffodil server
			$regisetUser = $this->__registerPleUser($userData);
			if ($regisetUser) {
				//saving the PLE user in our local database.
				//check if user is already login
				$isLogin = $this->ForumUser->find('count',array('conditions'=>array('midasId'=>$midasId,'course'=>$course_name)));
				//if user is already logged in then it remove the prevoius entry
				if ($isLogin == 1) {
					$isLogin = $this->ForumUser->deleteAll(array('midasId'=>$midasId,'course'=>$course_name));
				}
				$this->ForumUser->save($userData);
				//set the user session
				$this->Session->write('UserData.userName', $user);
				$this->Session->write('UserData.usersCourses', $explored_courses);
				$this->redirect(array('controller' => 'forums', 'action' => 'home'));
			}
			
		}
	}
	
	/**
	  * Method to register user in PLE.
	  * User will get register in every login, to get the update if user has changed his profile 
	  * from ple site.
	  * @param user info
	  */
	 public function __registerPleUser($userData)
	 {
	 	if ($userData) {
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
	
}
?>