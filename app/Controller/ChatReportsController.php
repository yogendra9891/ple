<?php
/**
 * ChatReports controller.
 *
 * This file will render views from views/ChatReports/
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
 * Chat Reports management controller abhi + yogi
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ChatReportsController extends AppController
{
	
	//The $uses attribute states which model(s) the will be available to the controller:
	public $uses = array('Chat', 'ChatUser', 'PleUser', 'EmailUser', 'User', 'ChatCurrentOnlineLog', 'ChatSessionLog', 'Course', 'Term','ChatOnlineLog','MeetingInviteLog');
	public $components = array('Email', 'Paginator');

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
	 * listing of the current online users for a term/course
	 * @params void
	 * @return void
	 */
	public function currentOnlineReport()
	{
		$this->ChatCurrentOnlineLog->virtualFields = array(
				'user_name' => 'pleuser.name',
				'user_role' => 'pleuser.user_type'
		);
		if ($this->request->is('post')) {
			$url = array('action'=>'currentOnlineReport');
			$filters = array();
			if (!empty($this->request->data['chatreports']['term']))
				$filters['term'] = $this->request->data['chatreports']['term'];
			if (!empty($this->request->data['chatreports']['course']))
				$filters['course'] = $this->request->data['chatreports']['course'];
			if (!empty($this->request->data['chatreports']['membertype']))
				$filters['membertype'] = $this->request->data['chatreports']['membertype'];
			//redirect user to the currentOnlineReport page including the selected filters, making url as get request.
			$this->redirect(array_merge($url, $filters));
		}
		//check filters on passedArgs
		if (isset($this->passedArgs['term']) && !empty($this->passedArgs['term'])) {
			$options['conditions'][] = array('ChatCurrentOnlineLog.session'=>$this->passedArgs['term']);
		}
		if (isset($this->passedArgs['course']) && !empty($this->passedArgs['course'])) {
			$options['conditions'][] = array('ChatCurrentOnlineLog.course'=>$this->passedArgs['course']);
		}
		if (isset($this->passedArgs['membertype']) && !empty($this->passedArgs['membertype'])) {
			$options['conditions'][] = array('pleuser.user_type'=>$this->passedArgs['membertype']);
		}
        		
		$limit = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		$options['limit'] = $limit;
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'pleuser',
				'type' => 'INNER',
				'conditions'=> array(
						'ChatCurrentOnlineLog.midas_id = pleuser.midasId',
						'ChatCurrentOnlineLog.course = pleuser.course',
				)
		);
		$options['fields'] = array('ChatCurrentOnlineLog.*');
		$this->Paginator->settings = $options;
		$data = $this->Paginator->paginate('ChatCurrentOnlineLog');
		$this->set('online_logs_results', $data);
	}
	/**
	 * getting the courses on term basis
	 */
	public function getCoursesNameArray($term_id = '')
	{
		if (!empty($term_id))
			$options['conditions'][] = array('Course.term_uuid'=>$term_id);
		$options['fields'] = array('Course.course_uuid');
		$courses = $this->Course->find('all', $options);
		$course_result = array();
		foreach ($courses  as $course) {
			$course_result[$course['Course']['course_uuid']] = $course['Course']['course_uuid'];
		}
		return $course_result;
	}
	
	/**
	 * getting the term on
	 */
	public function getTermName()
	{
		$terms = $this->Term->find('all');
		$term_result = array();
		foreach ($terms  as $term) {
			$term_result[$term['Term']['term_uuid']] = $term['Term']['term_uuid'];
		}
		return $term_result;
	}

	/**
	 * getting the courses on term basis
	 * @ajax call
	 */
	public function getCoursesNameByTerm()
	{
		$term_name = $this->request->data['term'];
		if (!empty($term_name))
		 $options['conditions'][] = array('Course.term_uuid' => $term_name);
		$options['fields'] = array('Course.course_uuid');
		$courses   = $this->Course->find('all', $options);
		echo "<select name='course'>
		<option value=''>-Select Course-</option>";
		foreach ($courses as $course) { 
		  echo "<option value='".$course['Course']['course_uuid']."'>".$course['Course']['course_uuid']."</option>";
		}
		echo "</select>";
		exit;
	}
	/**
    * Chat session logs
    * @param void
    * @return layout
    */
	public function chatSessionReport()
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
       
        $this->ChatSessionLog->virtualFields = array(
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
                    $options['conditions'][] = array('ChatSessionLog.time >='=>$unix_start_time, 'ChatSessionLog.time <='=>$unix_end_time,);
                    $this->set('datepickertime', $start_date);
                }

                if($filter_type == 2){
                    $start_date = $data['datepicker-day'];
                    $unix_start_time = strtotime($start_date);
                    $unix_end_time = $unix_start_time + (24*3600); //for one day
                    $options['conditions'][] = array('ChatSessionLog.time >='=>$unix_start_time, 'ChatSessionLog.time <='=>$unix_end_time,);
                    $this->set('datepickerday', $start_date);
                }

                if($filter_type == 3){
                    $start_date = $data['datepicker-startday'];
                    $end_date = $data['datepicker-endday'];
                        
                    $unix_start_time = strtotime($start_date);
                    $unix_end_time = strtotime($end_date);
                        
                    $options['conditions'][] = array('ChatSessionLog.time >='=>$unix_start_time, 'ChatSessionLog.time <='=>$unix_end_time,);
                    $this->set('datepickerstartday', $start_date);
                    $this->set('datepickerendday', $end_date);
                }

            }
                
            //check for terms
            if($term) {
                $options['conditions'][] = array('ChatSessionLog.session'=>$term);
                $this->set('selected_term_filter_type',$term);
            }
                
            //check for terms
            if($course) {
                $options['conditions'][] = array('ChatSessionLog.course'=>$course);
                $this->set('selected_course', $course);
            }

        }
        
        $user_options[] = array(
                'ChatSessionLog.midas_id = PleRegisterUsers.midasId', 'PleRegisterUsers.course = ChatSessionLog.course'
        );

        $options['joins'][] = array(
                'table' => 'ple_register_users',
                'alias' => 'PleRegisterUsers',
                'type' => 'INNER',
                'conditions'=> $user_options
        );
        $options['limit'] = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
        $options['fields'] = array('ChatSessionLog.*');
        $this->Paginator->settings = $options;
        $searchResults = $this->Paginator->paginate('ChatSessionLog');
        $this->set('online_logs_results', $searchResults);
	
	}
	
	
	/**
	 *Abhishek
	 */
	/**
	 * Generate the report of online users
	 */
	public function trackingMemberOnline()
	{
		$this->layout="report";
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
		
		
		$this->ChatOnlineLog->virtualFields = array(
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
					$options['conditions'][] = array('ChatOnlineLog.time >='=>$unix_start_time, 'ChatOnlineLog.time <='=>$unix_end_time,);
					$this->set('datepickertime', $start_date);
				}

				if($filter_type == 2){
					$start_date = $data['datepicker-day'];
					$unix_start_time = strtotime($start_date);
					$unix_end_time = $unix_start_time + (24*3600); //for one day
					$options['conditions'][] = array('ChatOnlineLog.time >='=>$unix_start_time, 'ChatOnlineLog.time <='=>$unix_end_time,);
					$this->set('datepickerday', $start_date);
				}

				if($filter_type == 3){
					$start_date = $data['datepicker-startday'];
					$end_date = $data['datepicker-endday'];
						
					$unix_start_time = strtotime($start_date);
					$unix_end_time = strtotime($end_date);
						
					$options['conditions'][] = array('ChatOnlineLog.time >='=>$unix_start_time, 'ChatOnlineLog.time <='=>$unix_end_time,);
					$this->set('datepickerstartday', $start_date);
					$this->set('datepickerendday', $end_date);
				}

			}
				
			//check for terms
			if($term) {
				$options['conditions'][] = array('ChatOnlineLog.session'=>$term);
				$this->set('selected_term_filter_type',$term);
			}
				
			//check for terms
			if($course) {
				$options['conditions'][] = array('ChatOnlineLog.course'=>$course);
				$this->set('selected_course', $course);
			}

		}
		
		$user_options[] = array(
				'ChatOnlineLog.midas_id = PleRegisterUsers.midasId', 'PleRegisterUsers.course = ChatOnlineLog.course'
		);

		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'PleRegisterUsers',
				'type' => 'INNER',
				'conditions'=> $user_options
		);
		$options['limit'] = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		$options['fields'] = array('ChatOnlineLog.*');
		$this->Paginator->settings = $options;
		$searchResults = $this->Paginator->paginate('ChatOnlineLog');
		$this->set('datas', $searchResults);
	}


	/**
	 * getting the courses on term basis
	 */
	public function getCoursesName($term_uuid)
	{

		$course_info = array();
		if($term_uuid != 0 )
			$options['conditions'][] = array('term_uuid'=>$term_uuid);

		$options['fields'] = array('course_uuid');

		$courses = $this->Course->find('all',$options);
		foreach($courses as $course){
			$course_info[$course['Course']['course_uuid']] = $course['Course']['course_uuid'];
		}
		return $course_info;
	}

	/**
	 * Getting the all courses
	 */
	public function getAllCourses()
	{
		$options = array();
		if( $this->request->query){
		$term_uuid = $this->request->query['terms'];
		if($term_uuid) {
			$options['conditions'][] = array('term_uuid'=>$term_uuid);
		}
		}
		
		$course_info = array();
		//$options['fields'] = array('fields'=>array('course_uuid'));
		$courses = $this->Course->find('all',$options);
		
		foreach($courses as $course){
			$course_info[$course['Course']['course_uuid']] = $course['Course']['course_uuid'];
		}
		return $course_info;
	}

	/**
	 * getting the term name
	 */
	public function getTermName_old()
	{
		$terms = $this->Term->find('all');
		foreach($terms as $term){
			$term_info[$term['Term']['term_uuid']] = $term['Term']['term_uuid'];
		}
		return $term_info;
	}

	/**
	 * Course html on ajax request
	 */
	function showCourseHtml()
	{
		$data = $this->request->data;
		$term_id = $data['term_uuid'];
		if($term_id==""){
			$term_id = 0;
		}
		//get course name
		$courses = $this->getCoursesName($term_id);

		//get helper object
		$view = new View($this);
		$Form = $view->loadHelper('Form');
		$Js = $view->loadHelper('Js');

		$course_html =  $Form->input('courses', array('div'=>'control-group',
				'type' => 'select',
				//'selected'=>$post_ques_by,
				'name'=>'courses',
				'options' =>$courses,
				'empty' => 'All',
				'label' => 'Courses',
				'class'=>'control-label'
		));
		echo $course_html;
		exit;
	}
	
	
	
	/**
	 * Generate the meeting reports
	 */
	public function meetingInvite()
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
		
		
		$this->MeetingInviteLog->virtualFields = array(
				'name' => 'PleRegisterUsers.name',
                'role' =>  'PleRegisterUsers.user_type'
		);
		
		if($this->request->query){
				
			$data = $this->request->query;
			 
			$time = strtotime($data['datepicker-time']);
			
				
			//get filter type
			//1=>time of day, 2=>day of week, 3=>date range
			$filter_type = (empty($data['filter_type'])) ? 0 : $data['filter_type'];
				
			//get terms
			$term = (empty($data['terms'])) ? 0 : $data['terms'];
				
			//get course
			$course = (empty($data['courses'])) ? 0 : $data['courses'];
				
				
				
			//check for date selection
			if($filter_type){
				$this->set('selected_date_filter_type',$filter_type);
				//check for date selection type
				if($filter_type == 1){
					$start_date = $data['datepicker-time'];
					$unix_start_time = strtotime($start_date);
					$unix_end_time = $unix_start_time + (60); //for one minute
					$options['conditions'][] = array('MeetingInviteLog.time >='=>$unix_start_time, 'MeetingInviteLog.time <='=>$unix_end_time,);
					$this->set('datepickertime', $start_date);
				}

				if($filter_type == 2){
					$start_date = $data['datepicker-day'];
					$unix_start_time = strtotime($start_date);
					$unix_end_time = $unix_start_time + (24*3600); //for one day
					$options['conditions'][] = array('MeetingInviteLog.time >='=>$unix_start_time, 'MeetingInviteLog.time <='=>$unix_end_time,);
					$this->set('datepickerday', $start_date);
				}

				if($filter_type == 3){
					$start_date = $data['datepicker-startday'];
					$end_date = $data['datepicker-endday'];
						
					$unix_start_time = strtotime($start_date);
					$unix_end_time = strtotime($end_date);
						
					$options['conditions'][] = array('MeetingInviteLog.time >='=>$unix_start_time, 'MeetingInviteLog.time <='=>$unix_end_time,);
					$this->set('datepickerstartday', $start_date);
					$this->set('datepickerendday', $end_date);
				}

			}
				
			//check for terms
			if($term) {
				$options['conditions'][] = array('MeetingInviteLog.session'=>$term);
				$this->set('selected_term_filter_type',$term);
			}
				
			//check for terms
			if($course) {
				$options['conditions'][] = array('MeetingInviteLog.course'=>$course);
				$this->set('selected_course', $course);
			}

		}
		
		$user_options[] = array(
				'MeetingInviteLog.midas_id = PleRegisterUsers.midasId', 'PleRegisterUsers.course = MeetingInviteLog.course'
		);

		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'PleRegisterUsers',
				'type' => 'INNER',
				'conditions'=> $user_options
		);
        
		$options['limit'] = 5; //define in bootstrap.php in config(default is 5, can be changed.)
		$options['fields'] = array('MeetingInviteLog.*');  
  
		$this->Paginator->settings = $options;
		$searchResults = $this->Paginator->paginate('MeetingInviteLog');
       
		$this->set('datas', $searchResults);
	}

}