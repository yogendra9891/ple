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
 * Dashboard logs management controller yogi + abhi
 *
 * @package       app.Controllert
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class DashboardReportsController extends AppController
{
	
	//get model object
	public $uses = array( 'PleUser', 'DashboardActiveSettingLogs', 'DashboardNotificationReminderSettingLogs', 'Course', 'Term', 'AssignmentReminderLog', 'OnlineSettingLog');
	public $components = array('Paginator');
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
		//set the layout
		$this->layout='report';
	}
	
	
	/**
	 * finding the logs for dashboard active post/forum setting
	 * @params void
	 * @return void
	 */
	public function activePostForumReport()
	{
		$options = array();
		
		//set default value
		$this->set('selected_user_type','');
		$this->set('selected_date_filter_type','');
		$this->set('selected_term_filter_type','');
		$this->set('datepickerstartday', '');
		$this->set('datepickerendday', '');
		$this->set('selected_course', '');
		
		$this->DashboardActiveSettingLogs->virtualFields = array(
				'name'      => 'PleRegisterUsers.name',
				'user_type' => 'PleRegisterUsers.user_type'
		);
		
		if($this->request->query){
		
			$data = $this->request->query;
		
			//get user type
			//0=>All, 1=>Instructor, 2=>Student
			$user_type = $data['usertype'];
		
			//get filter type
			//1=>time of day, 2=>day of week, 3=>date range
			$filter_type = (empty($data['filter_type'])) ? 0 : $data['filter_type'];
		
			//get terms
			$term = (empty($data['terms'])) ? 0 : $data['terms'];
		
			//get course
			$course = (empty($data['courses'])) ? 0 : $data['courses'];
		
			//check for user type
			if($user_type){
				$user_type_string = "instructor";
				if($user_type == 2){
					$user_type_string = "student";
				}
				$options['conditions'][] = array('PleRegisterUsers.user_type'=>$user_type_string);
				$this->set('selected_user_type', $user_type);
			}
		
			//check for date selection
			if($filter_type){
				$this->set('selected_date_filter_type',$filter_type);
				//check for date selection type
	
				if($filter_type == 3){
					$start_date = $data['datepicker-startday'];
					$end_date = $data['datepicker-endday'];
		
					$unix_start_time = strtotime($start_date);
					$unix_end_time = strtotime($end_date);
		
					$options['conditions'][] = array('DashboardActiveSettingLogs.time >='=>$unix_start_time, 'DashboardActiveSettingLogs.time <='=>$unix_end_time,);
					$this->set('datepickerstartday', $start_date);
					$this->set('datepickerendday', $end_date);
				}
		
			}
		
			//check for terms
			if($term) {
				$options['conditions'][] = array('DashboardActiveSettingLogs.session'=>$term);
				$this->set('selected_term_filter_type',$term);
			}
		
			//check for terms
			if($course) {
				$options['conditions'][] = array('DashboardActiveSettingLogs.course'=>$course);
				$this->set('selected_course', $course);
			}
		
		}
		
		$user_options[] = array(
				'DashboardActiveSettingLogs.midas_id = PleRegisterUsers.midasId', 'PleRegisterUsers.course = DashboardActiveSettingLogs.course'
		);
		
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'PleRegisterUsers',
				'type' => 'INNER',
				'conditions'=> $user_options
		);
		$options['limit'] = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		$options['fields'] = array('DashboardActiveSettingLogs.*');
		$this->Paginator->settings = $options;
		$activeResults = $this->Paginator->paginate('DashboardActiveSettingLogs');
		$this->set('dashboardactive_logs_results', $activeResults);
	}

	/**
	 * finding the logs for dashboard active post/forum setting
	 * @params void
	 * @return void
	 */
	public function notificationReminderSettingReport()
	{
		$options = array();
		
		//set default value
		$this->set('selected_user_type','');
		$this->set('selected_date_filter_type','');
		$this->set('selected_term_filter_type','');
		$this->set('datepickerstartday', '');
		$this->set('datepickerendday', '');
		$this->set('selected_course', '');
		
		$this->DashboardNotificationReminderSettingLogs->virtualFields = array(
				'name'      => 'PleRegisterUsers.name',
				'user_type' => 'PleRegisterUsers.user_type'
		);
		
		if($this->request->query){
		
			$data = $this->request->query;
		
			//get user type
			//0=>All, 1=>Instructor, 2=>Student
			$user_type = $data['usertype'];
		
			//get filter type
			//1=>time of day, 2=>day of week, 3=>date range
			$filter_type = (empty($data['filter_type'])) ? 0 : $data['filter_type'];
		
			//get terms
			$term = (empty($data['terms'])) ? 0 : $data['terms'];
		
			//get course
			$course = (empty($data['courses'])) ? 0 : $data['courses'];
		
			//check for user type
			if($user_type){
				$user_type_string = "instructor";
				if($user_type == 2){
					$user_type_string = "student";
				}
				$options['conditions'][] = array('PleRegisterUsers.user_type'=>$user_type_string);
				$this->set('selected_user_type', $user_type);
			}
		
			//check for date selection
			if($filter_type){
				$this->set('selected_date_filter_type',$filter_type);
				//check for date selection type
		
				if($filter_type == 3){
					$start_date = $data['datepicker-startday'];
					$end_date = $data['datepicker-endday'];
		
					$unix_start_time = strtotime($start_date);
					$unix_end_time = strtotime($end_date);
		
					$options['conditions'][] = array('DashboardNotificationReminderSettingLogs.time >='=>$unix_start_time, 'DashboardNotificationReminderSettingLogs.time <='=>$unix_end_time,);
					$this->set('datepickerstartday', $start_date);
					$this->set('datepickerendday', $end_date);
				}
		
			}
		
			//check for terms
			if($term) {
				$options['conditions'][] = array('DashboardNotificationReminderSettingLogs.session'=>$term);
				$this->set('selected_term_filter_type',$term);
			}
		
			//check for terms
			if($course) {
				$options['conditions'][] = array('DashboardNotificationReminderSettingLogs.course'=>$course);
				$this->set('selected_course', $course);
			}
		
		}
		
		$user_options[] = array(
				'DashboardNotificationReminderSettingLogs.midas_id = PleRegisterUsers.midasId', 'PleRegisterUsers.course = DashboardNotificationReminderSettingLogs.course'
		);
		
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'PleRegisterUsers',
				'type' => 'INNER',
				'conditions'=> $user_options
		);
		$options['limit'] = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		$options['fields'] = array('DashboardNotificationReminderSettingLogs.*');
		$this->Paginator->settings = $options;
		$activeResults = $this->Paginator->paginate('DashboardNotificationReminderSettingLogs');
		$this->set('dashboard_reminder_logs_results', $activeResults);
		
	}
	
	/**
	 * Create the assignment setting log
	 */
	public function assignmentReminderSetting()
	{
		$options = array();
		
		//set default value
		$this->set('selected_user_type','');
		$this->set('selected_date_filter_type','');
		$this->set('selected_term_filter_type','');
		$this->set('datepickertime', '');
		$this->set('datepickerday', '');
		$this->set('datepickerstartday', '');
		$this->set('datepickerendday', '');
		$this->set('selected_course', '');
		
		
		$this->AssignmentReminderLog->virtualFields = array(
				'name' => 'PleRegisterUsers.name',
				'user_type' => 'PleRegisterUsers.user_type'
		);
		
		if($this->request->query){
		
			$data = $this->request->query;
		
			$time = strtotime($data['datepicker-time']);
		
		
			//get user type
			//0=>All, 1=>Instructor, 2=>Student
			$user_type = $data['usertype'];
		
			//get filter type
			//1=>time of day, 2=>day of week, 3=>date range
			$filter_type = (empty($data['filter_type'])) ? 0 : $data['filter_type'];
		
			//get terms
			$term = (empty($data['terms'])) ? 0 : $data['terms'];
		
			//get course
			$course = (empty($data['courses'])) ? 0 : $data['courses'];
		
		
		
			//check for user type
			if($user_type){
				$user_type_string = "instructor";
				if($user_type == 2){
					$user_type_string = "student";
				}
		
				$options['conditions'][] = array('PleRegisterUsers.user_type'=>$user_type_string);
				$this->set('selected_user_type', $user_type);
			}
		
		
			//check for date selection
			if($filter_type){
				$this->set('selected_date_filter_type',$filter_type);
				//check for date selection type
				if($filter_type == 1){
					$start_date = $data['datepicker-time'];
					$unix_start_time = strtotime($start_date);
					$unix_end_time = $unix_start_time + (60); //for one minute
					$options['conditions'][] = array('AssignmentReminderLog.time >='=>$unix_start_time, 'AssignmentReminderLog.time <='=>$unix_end_time,);
					$this->set('datepickertime', $start_date);
				}
		
				if($filter_type == 2){
					$start_date = $data['datepicker-day'];
					$unix_start_time = strtotime($start_date);
					$unix_end_time = $unix_start_time + (24*3600); //for one day
					$options['conditions'][] = array('AssignmentReminderLog.time >='=>$unix_start_time, 'AssignmentReminderLog.time <='=>$unix_end_time,);
					$this->set('datepickerday', $start_date);
				}
		
				if($filter_type == 3){
					$start_date = $data['datepicker-startday'];
					$end_date = $data['datepicker-endday'];
		
					$unix_start_time = strtotime($start_date);
					$unix_end_time = strtotime($end_date);
		
					$options['conditions'][] = array('AssignmentReminderLog.time >='=>$unix_start_time, 'AssignmentReminderLog.time <='=>$unix_end_time,);
					$this->set('datepickerstartday', $start_date);
					$this->set('datepickerendday', $end_date);
				}
		
			}
		
			//check for terms
			if($term) {
				$options['conditions'][] = array('AssignmentReminderLog.session'=>$term);
				$this->set('selected_term_filter_type',$term);
			}
		
			//check for terms
			if($course) {
				$options['conditions'][] = array('AssignmentReminderLog.course'=>$course);
				$this->set('selected_course', $course);
			}
		
		}
		
		$user_options[] = array(
				'AssignmentReminderLog.midas_id = PleRegisterUsers.midasId', 'PleRegisterUsers.course = AssignmentReminderLog.course'
		);
		
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'PleRegisterUsers',
				'type' => 'INNER',
				'conditions'=> $user_options
		);
		$options['limit'] = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		$options['fields'] = array('AssignmentReminderLog.*');
		$this->Paginator->settings = $options;
		$searchResults = $this->Paginator->paginate('AssignmentReminderLog');
		
		$this->set('datas', $searchResults);
	}
	
	
	/**
	 * Create the community setting log
	 */
	public function communitySetting()
	{
		$options = array();
	
		//set default value
		$this->set('selected_user_type','');
		$this->set('selected_date_filter_type','');
		$this->set('selected_term_filter_type','');
		$this->set('datepickertime', '');
		$this->set('datepickerday', '');
		$this->set('datepickerstartday', '');
		$this->set('datepickerendday', '');
		$this->set('selected_course', '');
	
	
		$this->OnlineSettingLog->virtualFields = array(
				'name' => 'PleRegisterUsers.name',
				'user_type' => 'PleRegisterUsers.user_type'
		);
	
		if($this->request->query){
	
			$data = $this->request->query;
	
			$time = strtotime($data['datepicker-time']);
	
	
			//get user type
			//0=>All, 1=>Instructor, 2=>Student
			$user_type = $data['usertype'];
	
			//get filter type
			//1=>time of day, 2=>day of week, 3=>date range
			$filter_type = (empty($data['filter_type'])) ? 0 : $data['filter_type'];
	
			//get terms
			$term = (empty($data['terms'])) ? 0 : $data['terms'];
	
			//get course
			$course = (empty($data['courses'])) ? 0 : $data['courses'];
	
	
	
			//check for user type
			if($user_type){
				$user_type_string = "instructor";
				if($user_type == 2){
					$user_type_string = "student";
				}
	
				$options['conditions'][] = array('PleRegisterUsers.user_type'=>$user_type_string);
				$this->set('selected_user_type', $user_type);
			}
	
	
			//check for date selection
			if($filter_type){
				$this->set('selected_date_filter_type',$filter_type);
				//check for date selection type
				if($filter_type == 1){
					$start_date = $data['datepicker-time'];
					$unix_start_time = strtotime($start_date);
					$unix_end_time = $unix_start_time + (60); //for one minute
					$options['conditions'][] = array('OnlineSettingLog.time >='=>$unix_start_time, 'OnlineSettingLog.time <='=>$unix_end_time,);
					$this->set('datepickertime', $start_date);
				}
	
				if($filter_type == 2){
					$start_date = $data['datepicker-day'];
					$unix_start_time = strtotime($start_date);
					$unix_end_time = $unix_start_time + (24*3600); //for one day
					$options['conditions'][] = array('OnlineSettingLog.time >='=>$unix_start_time, 'OnlineSettingLog.time <='=>$unix_end_time,);
					$this->set('datepickerday', $start_date);
				}
	
				if($filter_type == 3){
					$start_date = $data['datepicker-startday'];
					$end_date = $data['datepicker-endday'];
	
					$unix_start_time = strtotime($start_date);
					$unix_end_time = strtotime($end_date);
	
					$options['conditions'][] = array('OnlineSettingLog.time >='=>$unix_start_time, 'OnlineSettingLog.time <='=>$unix_end_time,);
					$this->set('datepickerstartday', $start_date);
					$this->set('datepickerendday', $end_date);
				}
	
			}
	
			//check for terms
			if($term) {
				$options['conditions'][] = array('OnlineSettingLog.session'=>$term);
				$this->set('selected_term_filter_type',$term);
			}
	
			//check for terms
			if($course) {
				$options['conditions'][] = array('OnlineSettingLog.course'=>$course);
				$this->set('selected_course', $course);
			}
	
		}
	
		$user_options[] = array(
				'OnlineSettingLog.midas_id = PleRegisterUsers.midasId', 'PleRegisterUsers.course = OnlineSettingLog.course'
		);
	
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'PleRegisterUsers',
				'type' => 'INNER',
				'conditions'=> $user_options
		);
		$options['limit'] = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		$options['fields'] = array('OnlineSettingLog.*');
		$this->Paginator->settings = $options;
		$searchResults = $this->Paginator->paginate('OnlineSettingLog');
		$this->set('datas', $searchResults);
	}
}