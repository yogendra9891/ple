<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	
	public $uses = array('PleSetting', 'ReminderSetting');
	/*
	 * function for finding the db setting done by admin for a particular course
	 */
	public function __getDbSetting($user_exploded_course)
	{ 
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_exploded_course);
		$course_name = $course_info->course_name;
		$course_section = $course_info->section_name;
		$setting_result = $this->PleSetting->find('first', array("conditions"=> array("PleSetting.course"=> $course_name, "PleSetting.section"=> $course_section)));
		//if setting is done for a course then return the same else assume it will be in-section.
		if(count($setting_result))
		return $setting_result['PleSetting']['setting_value'];
	    return "1";
	}
	
	public function appError1(){
		$this->redirect(array('controller'=>'errors', 'action'=> 'notFound'));
	}
	
	/**
	 * Get notification setting for the current login users
	 * @param contentPageId
	 * @return array
	 */
	public function __getNotificationSetting( $contentPageId, $userName, $section )
	{    
		//initialise array
		$results = array();
		//get the user course name.
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		$course_info = $this->getCourseNameOfUser($user_course_section);
		$users_section = $course_info->section_name; //section name
		$users_course = $course_info->course_name; //course name

		//check if setting exist
		//get setting count
		$resultsCount = $this->ReminderSetting->find('count',array('conditions'=>
				  array('ReminderSetting.user_name'=>$userName,
						'ReminderSetting.content_page_id'=>$contentPageId,
						'ReminderSetting.section'=>$section,
						'ReminderSetting.course'=>$users_course
				)));

		if ($resultsCount) {
			//get setting
			$results = $this->ReminderSetting->find('first',array('conditions'=>
					  array('ReminderSetting.user_name'=>$userName,
							'ReminderSetting.content_page_id'=>$contentPageId,
							'ReminderSetting.section'=>$section,
							'ReminderSetting.course'=>$users_course
					)));
			$notification['emailSetting'] = $results['ReminderSetting']['is_email'];
			$notification['feedSetting'] = $results['ReminderSetting']['is_feed_reader'];
			$notification['facebookSetting'] = $results['ReminderSetting']['is_facebook'];
			$notification['twitterSetting'] = $results['ReminderSetting']['is_twitter'];
		} else {
			//default seeting will be email
			$notification['emailSetting'] = 1;
			$notification['facebookSetting'] = 0;
			$notification['twitterSetting'] = 0;
		}
		return $notification;
	}
	
        /**
        * Defining the assignment criteria.
        * @NOTE For the day before reminder, We assume 24 Hrs before of due date time.
        * @NOTE For the week before reminder, We assume the 24*7 Hrs before due date time and it will be visible for next 24 hrs.
        * @NOTE For the custom date, We assume that reminder will be set when custom date will lies in today start date(12 AM) and end date (11:59:59 PM).
        * @param void
        * @return array
        */
	public function getAssignmentConstraints()
	{
		$current_date = date('Y-m-d');
		$date = new DateTime($current_date);
		$date->modify('+1 day');
		$current_time = date('Y-m-d H:i:s'); //getting the current date time(time consider).
//		$current_time = date('Y-m-d'); //getting the current date.
		$assignment_crieteria = array('OR'=>array(
				array( "DATEADD( day, -1, PleAssignmentReminder.due_date) <=" =>$current_time, 'PleAssignmentReminder.due_date >=' =>$current_time, 'PleAssignmentReminder.remind_day_before'=>1), //day before.
				array( "DATEADD( day, -7, PleAssignmentReminder.due_date) <=" =>$current_time, "DATEADD( day, -6, PleAssignmentReminder.due_date) >=" =>$current_time, 'PleAssignmentReminder.remind_week_before'=>1), //week before.
				//array( "PleAssignmentReminder.remind_custom_date >=" =>$current_date, 'PleAssignmentReminder.remind_custom_date <' =>$date->format('Y-m-d'), 'PleAssignmentReminder.remind_day_of'=>1) //custom date.
				array( "PleAssignmentReminder.remind_custom_date >=" =>$current_date, 'PleAssignmentReminder.remind_custom_date <' =>$date->format('Y-m-d')), //custom date.
				array( "PleAssignmentReminder.due_date >=" =>$current_date, 'PleAssignmentReminder.due_date <' =>$date->format('Y-m-d'), 'PleAssignmentReminder.remind_day_of'=>1) //due date.
		)
		);
		return $assignment_crieteria;
	}
	
	/**
	 * Get the course name of logged in user
	 * @param course info
	 * @return object array;
	 */
	public function getCourseNameOfUser( $cs_info )
	{
		$course_separator = Configure::read('course_separator');
		$course_detail = new stdClass(); //initialise the object array.
		$course_info = explode($course_separator, $cs_info); //explode the array.
	
		//bind all in an array
		$course_detail->course_name = $course_info[0];
		$course_detail->section_name = $course_info[1];
	
		return $course_detail;
	}
	
	/**
	 * Get assignment link
	 * @param int assignment id
	 * @return string
	 */
	public function getAssignmentLink( $aid )
	{
		$ple_site_url = Configure::read('odu_url1');
		$new_url = $ple_site_url."/assignments/".$aid;
		return $new_url;
	}
	
	/**
	 * Get forum page link
	 * @param int content page id
	 * @return string
	 */
	public function getForumPageLink($content_page_id)
	{
		$ple_app_url = Configure::read('site_url');
		$forum_page_url = $ple_app_url."/forums/forumlist/".$content_page_id;
		return $forum_page_url;
	}
	
	/**
	 * Get the session name of logged in user
	 * @param course info
	 * @return object array;
	 */
	public function getSessionNameOfUser( $cs_info )
	{
		$course_separator = Configure::read('session_separator');
		$course_detail = new stdClass(); //initialise the object array.
		$course_info = explode($course_separator, $cs_info); //explode the array.
	
		//bind all in an array
		$course_detail->session_name = $course_info[0];
		return $course_detail;
	}
	
}
