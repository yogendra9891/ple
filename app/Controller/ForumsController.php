<?php
/**
 * Forum controller.
 *
 * This file will render views from views/Forum/
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
App::uses('ForumChildrenController', 'Controller');
App::import('Helper', 'Form');
/**
 * ForumUser management controller abhi + yogi
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ForumsController extends ForumChildrenController
{

	//The $uses attribute states which model(s) the will be available to the controller:
	public $uses = array('Comment', 'Forum', 'RatePost', 'PleUser', 'AccessQuestion', 'PleSetting',
			              'PleForumSetting', 'PleForumSubscription', 'RateComment', 'AccessReply', 
			              'ContentPageSetting', 'TwitterUser', 'FacebookUser', 'ReadonlySetting', 'EmailUser',
						  'OduMailQueue', 'PleForumAvailability'
			             );
	public $components = array('Paginator', 'Email', 'TwitterNotification', 'FacebookNotification');
	
	/**
	 * Method to check the user login
	 * Also checking the forum is enable+available for the current date
	 */
	public function beforeFilter()
	{
		//get user session
		$user = $this->Session->read('UserData.userName');
		if ($user=="") {
            	$logout_url = Configure::read('logout_url');
                return	$this->redirect($logout_url);
		}

	}

	/**
	 * Method to render the home page when form users get logged in
	 * @param none
	 */
	public function home() {
		//set the layout
		$this->layout = "forum";
	}

	/**
	 * Method to ask questions on forum/course content page
	 * list of the questions(posts)
	 * @param contentpageid
	 * @return rendering the layout
	 */
	public function forumlist($contentPageId = null)
	{
	    //set the layout
		$this->layout = "forummain";
		//code start for enable and diable and also for date between check
		//finding the user type
		$user_type = $this->Session->read('UserData.userType');
		//checking the forum is not disabled for Student user by Instruntor, this case is for only student type users.
		$checkForumAvailabilty = $this->__checkForumAvailabilty($contentPageId);
		$user_can_post = 0;
		$userType = $this->Session->read('UserData.userType');
        if ((in_array(3, $checkForumAvailabilty)) && ($user_type == 'student')) {
        	//$this->Session->setFlash('Forum is not available, may be disabled by Instructor');
			$this->render('forumUnavailable');
        } else if (in_array(1, $checkForumAvailabilty)) { // for post
        	$user_can_post = 1;
        } else if (in_array(4, $checkForumAvailabilty)) { // for read only
        	
        } else if (in_array(2, $checkForumAvailabilty)) { // for replies
        	
        } else if($user_type == 'student') {
        	$this->render('forumUnavailable');
        }
		//code end for enable and diable and also for date between check
		
		
		$this->Forum->virtualFields = array(
				'pin_sort' => 'QuestionAccess.is_pin',
				'is_read_sort' => 'QuestionAccess.is_read',
				'is_flag_sort' => 'QuestionAccess.is_flag',
				'author_sort' => 'pleuser.name'
		);
		if ($this->request->is('post')) {
			if($this->request->data['forums']['contId'] != ""){
				$contentPageId = $this->request->data['forums']['contId'];
			}
			//prepare the data..
			if($this->request->data['submit'] == 'Ask')
				$this->request->data['forums']['is_draft'] = 0;
			elseif($this->request->data['submit'] == 'Save')
			$this->request->data['forums']['is_draft'] = 1;
			$this->request->data['forums']['post_date']= time();
			$this->request->data['forums']['user_type'] = $userType; //@TODo we have to change this by varchar => student, Instructor
			$this->request->data['forums']['post_by'] = $this->Session->read('UserData.userName');
			$this->request->data['forums']['is_reply'] = 0;
			$course = $this->Session->read('UserData.usersCourses'); // is an array..
			//$explored_course = explode('-', $course[0]);
			//get Course and section name
			$course_info = $this->getCourseNameOfUser($course[0]);
			
			$this->request->data['forums']['contentpage_id'] = $contentPageId; //this will be changed by content page id.
			$this->request->data['forums']['user_coursename'] = $course_info->course_name;
			$this->request->data['forums']['user_sectionname'] = $course_info->section_name;
			if (!$this->Forum->save($this->request->data['forums'])) {
				$this->Session->setFlash('Your posts is not saved, try again');
				$this->redirect(array('controller'=>'forums', 'action'=> 'askQuestion'));
			} else {
				if($this->request->data['submit'] == 'Ask')
				  $this->__sendNewPostsNotification($this->Forum->id,$contentPageId);//sending new post notification according to the enabling the setting by users.
				$this->Session->setFlash('Your post saved successfully.');
				$this->redirect(array('controller'=>'forums', 'action'=> 'askQuestion',$contentPageId));
			}
		}
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $contentPageId; //@TODO we have to change it by the session value.
		//handling for insection-allsection  for forum..
		$setting_result = $this->__findForumSetting($course_info, $contentPageId);
		if ($setting_result == 2) { //all-section handling, course should be same...
			$options['conditions'][] = array('Forum.user_coursename'=> $course_info->course_name, 'Forum.contentpage_id'=>$contentpage_id);
			$postoptions['recursive'] = 0;
			$postoptions['conditions'][] = array('NOT'=>array('Forum.post_by'=>$user),'Forum.user_coursename'=> $course_info->course_name, 'Forum.contentpage_id'=>$contentpage_id, 'Forum.is_draft'=>1);
			$postoptions['fields'] = array('Forum.id');
		} else { //in-section handling, course and section should be same...
			$options['conditions'][] = array('Forum.user_coursename'=> $course_info->course_name, 'Forum.user_sectionname'=> $course_info->section_name, 'Forum.contentpage_id'=>$contentpage_id);
			$postoptions['recursive'] = 0;
			$postoptions['conditions'][] = array('NOT'=>array('Forum.post_by'=>$user),'Forum.user_coursename'=> $course_info->course_name, 'Forum.user_sectionname'=> $course_info->section_name, 'Forum.contentpage_id'=>$course_info->section_name, 'Forum.is_draft'=>1);
			$postoptions['fields'] = array('Forum.id');
		}
			
		$limit = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		//finding the posts id those are draft and draft by the not logged user..
		$posts_ids = $this->Forum->find('all', $postoptions);
		$question_ids = array();
		foreach ($posts_ids as $postids_data) {
			$question_ids[] = $postids_data['Forum']['id'];
		}
		$options['recursive'] = 0;
		$options['conditions'][] = array('NOT'=> array('Forum.id'=>$question_ids)); // handling for those are draft and not of the current users..
		$options['fields'] = array('Forum.*', 'QuestionAccess.is_pin', 'QuestionAccess.is_flag', 'QuestionAccess.user_id', 'QuestionAccess.id', 'pleuser.name');
		$options['joins'][] = array(
				'table' => 'ple_questions_access',
				'alias' => 'QuestionAccess',
				'type' => 'LEFT',
				'conditions'=> array(
						'Forum.id = QuestionAccess.question_id', 'QuestionAccess.user_id'=>$user
				)
		);
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'pleuser',
				'type' => 'INNER',
				'conditions'=> array(
						'Forum.post_by = pleuser.userName', 'pleuser.course'=>$course_info->course_name
				)
		);
		$options['limit'] = $limit;
		$options['order'] = array( 'pin_sort'=> 'desc', 'is_read_sort'=> 'asc', 'Forum.id'=>'desc'); //virtual fields define above..
		$this->Paginator->settings = $options;
		$data = $this->Paginator->paginate('Forum');
		$this->set('contentPageId',$contentPageId);
		$data1 = array();
		//set the user can post 
		$this->set('user_can_post', $user_can_post);
		$this->set('posts', $data1);
	}
	
	/**
	 * List search results
	 * list of the questions(posts)
	 * @params contentpageid
	 */
	public function forumFilter($contentPageId = null)
	{
		//set the layout
		$this->layout = "forum";
		$this->Forum->virtualFields = array(
				'pin_sort' => 'QuestionAccess.is_pin',
				'is_read_sort' => 'QuestionAccess.is_read',
				'is_flag_sort' => 'QuestionAccess.is_flag',
				'author_sort' => 'pleuser.name'
		);
		if ($this->request->is('post')) {
			if ($this->request->data['forums']['contId'] != "") {
				$contentPageId = $this->request->data['forums']['contId'];
			}
			//prepare the data..
			if($this->request->data['submit'] == 'Ask')
				$this->request->data['forums']['is_draft'] = 0;
			elseif ($this->request->data['submit'] == 'Save')
			$this->request->data['forums']['is_draft'] = 1;
			$this->request->data['forums']['post_date']= time();
			$this->request->data['forums']['user_type'] = $this->Session->read('UserData.userType'); //@TODo we have to change this by varchar => student, Instructor
			$this->request->data['forums']['post_by'] = $this->Session->read('UserData.userName');
			$this->request->data['forums']['is_reply'] = 0;
			$course = $this->Session->read('UserData.usersCourses'); // is an array..
			//$explored_course = explode('-', $course[0]);
			//get Course and section name
			$course_info = $this->getCourseNameOfUser($course[0]);
			
			$this->request->data['forums']['contentpage_id'] = $contentPageId; //this will be changed by content page id.
			$this->request->data['forums']['user_coursename'] = $course_info->course_name;
			$this->request->data['forums']['user_sectionname'] = $course_info->section_name;
			if (!$this->Forum->save($this->request->data['forums'])) {
				$this->Session->setFlash('Your posts is not saved, try again');
				$this->redirect(array('controller'=>'forums', 'action'=> 'askQuestion'));
			} else {
				if($this->request->data['submit'] == 'Ask')
					$this->__sendNewPostsNotification($this->Forum->id,$contentPageId);//sending new post notification according to the enabling the setting by users.
				$this->Session->setFlash('Your post saved successfully.');
				$this->redirect(array('controller'=>'forums', 'action'=> 'askQuestion',$contentPageId));
			}
		}
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $contentPageId; //@TODO we have to change it by the session value.
		//handling for insection-allsection  for forum..
		$setting_result = $this->__findForumSetting($course_info, $contentPageId);
		if ($setting_result == 2) { //all-section handling, course should be same...
			$options['conditions'][] = array('Forum.user_coursename'=> $course_info->course_name, 'Forum.contentpage_id'=>$contentpage_id);
			$postoptions['recursive'] = 0;
			$postoptions['conditions'][] = array('NOT'=>array('Forum.post_by'=>$user),'Forum.user_coursename'=> $course_info->course_name, 'Forum.contentpage_id'=>$contentpage_id, 'Forum.is_draft'=>1);
			$postoptions['fields'] = array('Forum.id');
		} else { //in-section handling, course and section should be same...
			$options['conditions'][] = array('Forum.user_coursename'=> $course_info->course_name, 'Forum.user_sectionname'=> $course_info->section_name, 'Forum.contentpage_id'=>$contentpage_id);
			$postoptions['recursive'] = 0;
			$postoptions['conditions'][] = array('NOT'=>array('Forum.post_by'=>$user),'Forum.user_coursename'=> $course_info->course_name, 'Forum.user_sectionname'=> $course_info->section_name, 'Forum.contentpage_id'=>$contentpage_id, 'Forum.is_draft'=>1);
			$postoptions['fields'] = array('Forum.id');
		}
	
		$limit = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		//finding the posts id those are draft and draft by the not logged user..
		$posts_ids = $this->Forum->find('all', $postoptions);
		$question_ids = array();
		foreach ($posts_ids as $postids_data) {
			$question_ids[] = $postids_data['Forum']['id'];
		}
		$options['recursive'] = 0;
		$options['conditions'][] = array('NOT'=> array('Forum.id'=>$question_ids)); // handling for those are draft and not of the current users..
		$options['fields'] = array('Forum.*', 'QuestionAccess.is_pin', 'QuestionAccess.is_flag', 'QuestionAccess.user_id', 'QuestionAccess.id', 'pleuser.name');
		$options['joins'][] = array(
				'table' => 'ple_questions_access',
				'alias' => 'QuestionAccess',
				'type' => 'LEFT',
				'conditions'=> array(
						'Forum.id = QuestionAccess.question_id', 'QuestionAccess.user_id'=>$user
				)
		);
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'pleuser',
				'type' => 'INNER',
				'conditions'=> array(
						'Forum.post_by = pleuser.userName', 'pleuser.course'=>$course_info->course_name
				)
		);
		$options['limit'] = $limit;
		$options['order'] = array( 'pin_sort'=> 'desc', 'is_read_sort'=> 'asc', 'Forum.id'=>'desc'); //virtual fields define above..
		$this->Paginator->settings = $options;
		$data = $this->Paginator->paginate('Forum');
		$this->set('contentPageId',$contentPageId);
		$data1 = array();
		$this->set('posts', $data1);
	}
	
	/**
	 * Method to ask questions on forum/course content page
	 * list of the questions(posts)
	 * @param contentpageid
	 */
	public function askQuestion($contentPageId = null)
	{
		//set the layout
		$this->layout = "forum";
		$this->Forum->virtualFields = array(
				'pin_sort' => 'QuestionAccess.is_pin',
				'is_read_sort' => 'QuestionAccess.is_read',
				'is_flag_sort' => 'QuestionAccess.is_flag',
				'author_sort' => 'pleuser.name'
		);
		if ($this->request->is('post')) {
			if($this->request->data['forums']['contId'] != ""){
				$contentPageId = $this->request->data['forums']['contId'];
			}
			//prepare the data..
			if ($this->request->data['submit'] == 'Ask')
				$this->request->data['forums']['is_draft'] = 0;
			elseif ($this->request->data['submit'] == 'Save')
			$this->request->data['forums']['is_draft'] = 1;
			$this->request->data['forums']['post_date']= time();
			$this->request->data['forums']['user_type'] = $this->Session->read('UserData.userType'); //@TODo we have to change this by varchar => student, Instructor
			$this->request->data['forums']['post_by'] = $this->Session->read('UserData.userName');
			//check for subject length should be less than 4000.
			$this->request->data['forums']['post_subject'] = substr($this->request->data['forums']['post_subject'], 0,3999);
			$this->request->data['forums']['is_reply'] = 0;
			$this->request->data['forums']['post_type'] = 'question';
			$course = $this->Session->read('UserData.usersCourses'); // is an array..
			//$explored_course = explode('-', $course[0]);
			//get Course and section name
			$course_info = $this->getCourseNameOfUser($course[0]);
			
			$this->request->data['forums']['contentpage_id'] = $contentPageId; //this will be changed by content page id.
			$this->request->data['forums']['user_coursename'] = $course_info->course_name;
			$this->request->data['forums']['user_sectionname'] = $course_info->section_name;
			if (!$this->Forum->save($this->request->data['forums'])) {
				$this->Session->setFlash('Your posts is not saved, try again');
				$this->redirect(array('controller'=>'forums', 'action'=> 'forumFilter'));
			}
			else {
			//get last inserted id
			$lastqtId = $this->Forum->getInsertID();
			//mark the question as read by author
				$this->__markReadQuestion($lastqtId);
				if ($this->request->data['submit'] == 'Ask') {
				
				    //send Twitter notification 
					$this->__sendNewPostsTwitterNotification($this->Forum->id, $contentPageId);
					
				    //send Facebook notification
				    $this->__sendNewPostsFacebookNotification($this->Forum->id, $contentPageId);
					
					//send ODU email notification
					$this->__sendNewPostsNotification($this->Forum->id, $contentPageId);//sending new post notification according to the enabling the setting by users.
				}
				$this->Session->setFlash('Your post saved successfully.');
				$this->redirect(array('controller'=>'forums', 'action'=> 'forumFilter',$contentPageId));
			}
		}
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $contentPageId; //@TODO we have to change it by the session value.
		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($contentPageId);
		
		$options['conditions'][] = array('Forum.user_coursename'=> $course_info->course_name, 'Forum.user_sectionname'=> $sections_list, 'Forum.contentpage_id'=>$contentpage_id);
		 			$postoptions['recursive'] = 0;
		 			$postoptions['conditions'][] = array('NOT'=>array('Forum.post_by'=>$user),'Forum.user_coursename'=> $course_info->course_name, 'Forum.user_sectionname'=> $sections_list, 'Forum.contentpage_id'=>$contentpage_id, 'Forum.is_draft'=>1);
		 			$postoptions['fields'] = array('Forum.id');
					
		//handling for insection-allsection  for forum..
		
		$limit = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		//finding the posts id those are draft and draft by the not logged user..
		$posts_ids = $this->Forum->find('all', $postoptions);
		$question_ids = array();
		foreach ($posts_ids as $postids_data) {
			$question_ids[] = $postids_data['Forum']['id'];
		}
	    //check the post type
		$options['conditions'][] = array('Forum.post_type'=>'question');
		$options['conditions'][] = array('NOT'=> array('Forum.id'=>$question_ids)); // handling for those are draft and not of the current users..
		$options['fields'] = array('Forum.*', 'QuestionAccess.is_pin', 'QuestionAccess.is_flag', 'QuestionAccess.user_id', 'QuestionAccess.id', 'pleuser.name');
		$options['joins'][] = array(
				'table' => 'ple_questions_access',
				'alias' => 'QuestionAccess',
				'type' => 'LEFT',
				'conditions'=> array(
						'Forum.id = QuestionAccess.question_id', 'QuestionAccess.user_id'=>$user
				)
		);
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'pleuser',
				'type' => 'INNER',
				'conditions'=> array(
						'Forum.post_by = pleuser.userName', 'pleuser.course'=>$course_info->course_name
				)
		);
		$options['limit'] = $limit;
		$options['order'] = array( 'pin_sort'=> 'desc', 'is_read_sort'=> 'desc', 'Forum.id'=>'desc'); //virtual fields define above..
		$this->Paginator->settings = $options;
		$data = $this->Paginator->paginate('Forum');
		
		// code start for sorting of pin, unread, read.
		$allresult = $data;
		if (!@$this->request->params['named']['sort']) {
			$pinnedArray = array();
			$unPinnedArray = array();
			foreach ($allresult as $rest) {
				if ($rest['Forum']['pin_sort'] == 1) {
					$pinnedArray[] = $rest;
				} else {
					$unPinnedArray[] = $rest;
				}
			}
			usort($unPinnedArray, array($this,"sortReadUnread")); //sorting the array by read and unread..
			$unReadArray = array();
			$readArray = array();
			if (count($unPinnedArray)) {
				foreach ($unPinnedArray as $d) {
					if($d['Forum']['is_read_sort'] == 1)
						$readArray[]= $d;
					else
						$unReadArray[] = $d;
				}
			}
			if(count($unReadArray))
				usort($unReadArray, array($this,"orderUnreadById")); //sorting the unread posts by id(desc)
			if(count($readArray))
				usort($readArray, array($this,"orderReadById"));  //sorting the read posts by id(desc)
			$data1 = array_merge($pinnedArray, $unReadArray);  //merging the result pin and unread posts
			$data2 = array_merge($data1, $readArray); //merging the pin+unread with read posts.
			// code end for sorting of pin, unread and read.
		} else
			$data2 = $data;
		$this->set('contentPageId',$contentPageId);
		
		$this->set('posts', $data2);
	}
	
	/**
	 *Sorting the result of read/unread posts by id desc
	 *@params array
	 *@return array
	 */
	function sortReadUnread($a, $b)
	{
		return $a['Forum']["is_read_sort"] - $b['Forum']["is_read_sort"];
	}
	
	/**
	 *Sorting the result of unread posts by id desc
	 *@params array
	 *@return array
	*/
	function orderUnreadById($c, $d)
	{
		return $d['Forum']["id"] - $c['Forum']["id"];
	}
	
	/**
	 * Sorting the result of read posts by id desc
	 * @params array
	 * @return array
	*/
	function orderReadById($e, $f) 
	{
		return $f['Forum']["id"] - $e['Forum']["id"];
	}
	
	/**
	 * Method to reply Questions
	 * @param int question id.
	 */
	public function replyQuestion($qid,$contentPageId)
	{
		//set the layout
		$this->layout = "forum";
		//making this question status as read
		$this->__markReadQuestion($qid);
		//get parent Question
		$parentQuestion = $this->Forum->find('first',array('conditions'=>array('Forum.id'=>$qid)));
		if ($parentQuestion) {
			$pname = $this->getUserProfileName($parentQuestion['Forum']['post_by']);
			$parentQuestion['Forum']['post_by'] = $pname;
			//pr($parentQuestion);
			if ($parentQuestion)
				$this->set('quesComts',$parentQuestion);
			//get Rating count
			$ratingCount = $this->__getRateCount($qid);
			$this->set('ratingCount',$ratingCount);
			$limit = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
			//get draft commments by other users
			$draftCmts = $this->__getDraftCmts($qid);
			
			//get section list
			//get allsection setting sections for same course
			$sections_list = $this->__allReplySections($contentPageId);
			
			//get comments
			//Use the different query to get comment to implement pagination
		
			$this->Paginator->settings = array('conditions'=>array('NOT'=>array('Forum.id'=>$draftCmts), 'Forum.user_sectionname'=> $sections_list, 'Forum.question_id'=>$qid,'Forum.parent_reply_id'=>0),'limit' => $limit);
			
			$parentComments = $this->Paginator->paginate('Forum');
			
			$this->set('Comts',$parentComments);
			$this->set('contentPageId',$contentPageId);
		} else {
			$this->Session->setFlash(__('This question has removed by admin.'));
			$this->redirect('askQuestion/'.$contentPageId);
		}
	}

    /**
     * Get draft comments on questions 
     * by other users
     * @params question id
     * @return array
     */
    public function __getDraftCmts($qid)
    {
		//get current login user object.
		$draftCmtId = array();
		$user = $this->Session->read('UserData.userName');
		$cmtoptions['conditions'][] = array('NOT'=>array('Forum.post_by'=>$user),'Forum.is_draft'=>1,'Forum.question_id'=>$qid,'Forum.post_type'=>'comment');
		$cmtoptions['fields'] = array('Forum.id');
		//pr($cmtoptions);
		$draftCmts = $this->Forum->find('all',$cmtoptions);
		foreach ($draftCmts as $draftCmt) {
			$draftCmtId[] = $draftCmt['Forum']['id'];
		}
		return $draftCmtId;
	}
	
	/**
	 * Method to submit the answer for parent question
	 */
	public function  submitComment() 
	{
	
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$user_type = $this->Session->read('UserData.userType');
		
		//check for post value
		if ($this->request->is('post')) {
			$data = $this->request['data'];
            $contentPageId = $data['Forum']['contId'];
            
            //check if comment is not empty
			if (trim($data['Forum']['comment'])=="") {
				$this->redirect('replyQuestion/'.$data['Forum']['fid']);
			}
			
			//get parent ancestors id
			$parentAnsc = $this->Forum->find('first',array('conditions'=>array('Forum.id'=>$data['Forum']['rid']),'fields'=>array('ancestor_id')));
			
			//check if ancestor exist
			if (!$parentAnsc) {
				$updatedParentAnscVal = $data['Forum']['rid'];
			} else {
				$parentAnscVal = $parentAnsc['Forum']['ancestor_id'];
				$updatedParentAnscVal = $parentAnscVal.",".$data['Forum']['rid'];
			}
			

            $data['Forum']['question_id'] = $data['Forum']['fid'];
			$data['Forum']['parent_reply_id'] = $data['Forum']['rid'];
			$data['Forum']['post_subject'] = 'dfg';
			$data['Forum']['post_body'] = $data['Forum']['comment'];
			$data['Forum']['post_date'] = time();
			$data['Forum']['post_by'] = $user;
			$data['Forum']['user_coursename'] = $course_info->course_name;
			$data['Forum']['user_sectionname'] = $course_info->section_name;
			$data['Forum']['contentpage_id'] = $contentPageId;
			$data['Forum']['ancestor_id'] = $updatedParentAnscVal;
			$data['Forum']['is_draft'] = 0;
			$data['Forum']['post_type'] = 'comment';
			$data['Forum']['user_type'] = $user_type; //@TODo we have to change this by varchar => student, Instructor
			$data['Forum']['post_subject'] = $data['Forum']['re'];
			
			if ($data['button_type']=="Save") {
				$data['Forum']['is_draft'] = 1;
			}
			$data['Forum']['is_reply'] = 1;
           
			$saveRecord = $this->Forum->save($data);
			$lastCommentId = $this->Forum->getInsertID();
			if ($saveRecord) {
				$this->Forum->create();
				$dataForum['Forum']['id'] = $data['Forum']['fid'];
				$dataForum['Forum']['is_reply'] = 1;
				$result = $this->Forum->save($dataForum);
				if ($result) {
					    //check if user has subscribed the Question
						//send notification
						//send notification for publish comment
						if ($data['Forum']['is_draft'] == 0) {
						//send twitter notification
						$this->__sendReplyPostsTwitterNotification($data['Forum']['fid'],$lastCommentId,$contentPageId);
						
						//send facebook Notification..
						$this->__sendReplyPostsFacebookNotification($data['Forum']['fid'],$lastCommentId,$contentPageId);
						
						//send odu notification
						$this->__sendReplyPostsNotification($data['Forum']['fid'],$lastCommentId,$contentPageId);
						}
					//mark comment as read	
					$this->__markDefaultRead($data['Forum']['fid'], $lastCommentId);
				}
			}
			$this->Session->setFlash(__('You have replied successfully.'));
			$this->redirect('replyQuestion/'.$data['Forum']['fid'].'/'.$contentPageId.'/page:'.$data['Forum']['cpage']);

		}
	}
	
	/**
	 * Edit drafted comment through ajax
	 * @return edited time
	 */
	public function editComment()
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		//check for value
		if ($this->request->is('post')) {
			$data = $this->request['data'];
		
			$this->Forum->create();
		    $data['Forum']['id'] = $data['comment_id'];
			$data['Forum']['post_body'] = $data['content'];
			$data['Forum']['post_date'] = time();
			//mark the reply as draft
			$data['Forum']['is_draft'] = 1;
			$saveRecord = $this->Forum->save($data);
			//get current time
			$msg = "posted on". date('m-d-Y: h:i A',$data['Forum']['post_date']);
			echo $msg;
			exit;
		
		}
	}

	/**
	 * Method to load the parent commants from the child comment id
	 * @param int $id
	 * @return array
	 */
	public function loadAncestorComments($id)
	{
		$result2 = array();
		$result = $this->Comment->find('first',array('conditions'=>array('Comment.id'=>$id),'fields'=>array('ancestor_id')));
		$anscIds = $result['Comment']['ancestor_id'];
		$anscIdsExplode = explode(',',$anscIds);
		//only show the last ancestor
		$lastElement = end($anscIdsExplode);
		if ($lastElement != 0) {
			$result2[] = $this->Comment->find('first',array('conditions'=>array('Comment.id'=>$lastElement)));
		}
		return $result2;
	}
	
    /**
	 * load the child comments from the parent comment id
	 * @param int $id
	 * @return array
	 */
	function loadChildComments($id=null,$currentPage=null,$forumId=null,$forumSubj=null,$contentPageId=null)
	{
	    //get current login user object.
		$edit_button = '';
		$user = $this->Session->read('UserData.userName');
		
		//finding the user type
		$user_type = $this->Session->read('UserData.userType');		
		
	    //get read only setting
		$readOnly = $this->getReadOnlySetting($contentPageId);
		
		//get read only setting
		$replySetting = $this->getReplyDateSetting($contentPageId);
	    
		//4/23/2014 if readonly and reply date lie at same time interval then reply date will get priority (user can reply) 
		if( ($readOnly == 1 && $replySetting ==1) || ($user_type == 'instructor') )
			$readOnly = 0;
		
		//get helper object
		$view = new View($this);
		$Form = $view->loadHelper('Form');
		$Js = $view->loadHelper('Js');
		$results = array();
		$buttonHtml = '';
		
		//get info
		$results = $this->Forum->find('first',array('conditions'=>array('Forum.id'=>$id)));
       
		if ($results) {
			$is_draft = $results['Forum']['is_draft'];
			
			//check for draft and readOnly setting
			if ($is_draft == 1  && $readOnly == 0) {
				$buttonHtml = '<input title="Publish your draft reply" type="image" src="'.$this->webroot.'img/publish.png" onClick="publishComment('.$results['Forum']['id'].','.$forumId.','.$this->webroot.',\''.$contentPageId.'\')" value="Draft" /><input type="image" src="'.$this->webroot.'img/editpost.png" onClick="saveReplyAjax('.$forumId.','.$results['Forum']['id'].');" value="Edit"/>';
			} else {
				//check if comment is last comment for author
				$is_reply = $this->getReplyParent($results['Forum']['id']);
				
				if(($is_reply == 0 && $results['Forum']['post_by'] == $user) && (($readOnly == 0 && $replySetting == 1) || ($user_type == 'instructor'))){
					$edit_button = '<input type="image" src="'.$this->webroot.'img/editpost.png" onClick="editReplyToggle('.$forumId.','.$results['Forum']['id'].');" value="Edit"/>';
				}
			}
			
			$read_access = $this->__checkReadAccess($forumId, $results['Forum']['id']);
			$readButtonHtml = '';
			if(!$read_access)
				$readButtonHtml = '<input type="image" src="'.$this->webroot.'img/mark_read_small.png" id="reply_read_'.$results['Forum']['id'].'" class="mark-read-reply" onClick="readComment('.$this->webroot.','.$forumId.','.$results['Forum']['id'].',\''.$contentPageId.'\')" value="Mark Read" title="Mark as read"/>';
			$totalUserVoted = $this->__getUserVoted($results['Forum']['id']);
			$avgCommentRate = $this->__getCommentRateCount($results['Forum']['id']);
			$isVoted = $this->__checkIfUserVotedComment($results['Forum']['id']);
			if ($isVoted == 1) {
				$chtml = 'disabled="disabled"';
			} else {
				$chtml='';
			}
			//echo $this->Form->create('Forum', array('action' => 'submitComment'));
			echo "<li class='cmmnt'>";
			echo '<div class="cmmnt-content">';
			echo '<header>';
			if ( ($readButtonHtml != '') && ( ($replySetting == 1) || ($user_type == 'instructor') ) )
			echo '<span class="cmtread">'.$readButtonHtml.'</span>';
			echo '<span  class="userlink user-rep">RE:'.base64_decode($forumSubj).' 
			</span> - <span class="pubdate" id="pubdateId-'.$results['Forum']['id'].'">posted on '. date('m-d-Y: h:i A',$results['Forum']['post_date']).'
			</span> <span class="pubdate"><b>By '.ucfirst($this->requestAction('forums/getUserProfileName/'.$results['Forum']['post_by'])).'
			</b></span><span class="cmtdraft" id="cmtdraftId'.$results['Forum']['id'].'">'.$buttonHtml.$edit_button.'</span>';
			
			echo '</header>';
			
			//user can edit his draft reply
			echo '<div id="edit-reply-comment_'.$results['Forum']['id'].'" class="edit-reply-comment">';
			
			echo $Form->create('Forum', array('action' => 'editComment'));
			echo $Form->input('cpage', array('value'=>$currentPage, 'type'=>'hidden'));
			echo $Form->input('fid', array('value'=>$forumId, 'type'=>'hidden'));
			echo $Form->input('rid', array('value'=>$results['Forum']['id'], 'type'=>'hidden'));
			echo $Form->input('RE:',array('type'=>'text','size' => '75','value'=>base64_decode($forumSubj),'disabled' => TRUE));
			echo $Form->input('re',array('type'=>'hidden','size' => '75','value'=>base64_decode($forumSubj)));
			echo '<div id="reply3"'.$results['Forum']['id'].' class="error-msg"></div>';
			
			
			echo $Form->textarea('comment', array('rows' => '5', 'cols' => '55','value'=>$results['Forum']['post_body'],'class'=>'ckeditor replybox'.$results['Forum']['id'],'id'=>'edit-cmt-'.$results['Forum']['id']));
			echo $Form->button('Reply', array('class'=>'gobutton', 'id'=>'reply_'.$results['Forum']['id'], 'type' => 'button','onClick'=>"publishReplyComment('".$results['Forum']['id']."','".$forumId."','".$this->webroot."','".$contentPageId."')"));
			echo $Form->button('Save', array('class'=>'gobutton', 'id'=>'save_'.$results['Forum']['id'], 'type' => 'button','onclick'=> "saveDraftAjax('".$this->webroot."',".$results['Forum']['id'].");"));
			echo $Form->button('Preview', array('class'=>'gobutton','type' => 'button','title' => 'Preview the textarea content', 'onclick'=> "ShowEditReplyPreview(".$results['Forum']['id'].");"));
			echo $Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden'));
			echo $Form->end();
			
			echo '</div>';
			//end of user can edit his draft reply
			//echo "<div class='aut'>".@$results['Comment']['id']."</div>";
            echo "<div class='comment-body' id='comment-body_".$results['Forum']['id']."'>".@$results['Forum']['post_body']."</div>";
			if(($readOnly == 0 && $replySetting == 1) || ($user_type == 'instructor')){
			echo $Form->create('Forum', array('action' => 'rateComment','id'=>'commentrate'.$results['Forum']['id']));
			echo '<div class="Clear vote-area">';
			if ($isVoted == 1) {
			if($avgCommentRate == 1){
			 echo '<input class="star required" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="1" checked="checked" disabled="disabled"/>';
			} else {
			 echo '<input class="star required" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="1" disabled="disabled"/>';
			}
			if ($avgCommentRate == 2) {
			 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="2" checked="checked" disabled="disabled"/>';
			} else {
			 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="2"  disabled="disabled"/>';
			}
			if ($avgCommentRate == 3) {
			 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="3" checked="checked" disabled="disabled"/>';
			} else {
			 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="3" disabled="disabled"/>';
			}
			if ($avgCommentRate == 4) {
			 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="4" checked="checked" disabled="disabled"/>';
			} else {
			 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="4"  disabled="disabled"/>';
			}
			if($avgCommentRate == 5) {
			 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="5" checked="checked" disabled="disabled"/>';
			} else {
			 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="5" disabled="disabled"/>';
			}
			} else {
				if ($avgCommentRate == 1) {
				 echo '<input class="star required" type="radio" name="cmt-rating'.$results['Forum']['id'].'" checked="checked" value="1" />';
				} else {
					echo '<input class="star required" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="1" />';
				}
				if ($avgCommentRate == 2) {
				 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" checked="checked" value="2" />';
				} else {
				 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="2" />';
				}
				if ($avgCommentRate == 3) {
				 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" checked="checked" value="3" />';
				}else {
				 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="3" />';
				}
				if ($avgCommentRate == 4) {
				 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" checked="checked" value="4" />';
				} else{
				 echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="4" />';
				}
				if($avgCommentRate == 5){
				echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" checked="checked" value="5" />';
				} else {
					echo '<input class="star" type="radio" name="cmt-rating'.$results['Forum']['id'].'" value="5" />';
				}
			}
			echo '</div>';
			echo $Form->input('questionId', array('value'=>$forumId, 'type'=>'hidden'));
			echo $Form->input('commentId', array('value'=>$results['Forum']['id'], 'type'=>'hidden'));
			echo $Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden'));
		    
			//hide vote button if user has already voted the comment
		    if ($isVoted == 0) {
			 echo $Form->submit('Rate',array('id'=>'vote'.$results['Forum']['id'],'class'=>'ratebutton', 'title' => 'Rate reply'));
		    }
		    echo "<div class='cmt-count' id='cmt-countid".$results['Forum']['id']."'><input type='hidden' value='".$totalUserVoted."'  id='cmt-counttext".$results['Forum']['id']."'/>". $totalUserVoted." Votes </div>";
			echo $Form->end();
			}
			//echo "<a href='javascript: showReplyBox(".$results['Comment']['id'].");>Reply</a>";
			if ($is_draft != 1 && ( ($readOnly == 0 && $replySetting == 1) || ($user_type == 'instructor') )) {
			 echo "<div style='clear:both;' class='replyLink-class' id='replyLink-".$results['Forum']['id']."'><a style='color:#4C79AB' href='javascript: showReplyBox($id)'>Reply</a></div>";
            }
			
			//check for read only
            if($readOnly == 0 ){
			echo '<div id="reply-comment_'.$results['Forum']['id'].'" class="reply-comment" >';
			
			echo $Form->create('Forum', array('action' => 'submitComment'));
			echo $Form->input('cpage', array('value'=>$currentPage, 'type'=>'hidden'));
			echo $Form->input('fid', array('value'=>$forumId, 'type'=>'hidden'));
			echo $Form->input('rid', array('value'=>$results['Forum']['id'], 'type'=>'hidden'));
			echo $Form->input('RE:',array('type'=>'text','size' => '75','value'=>base64_decode($forumSubj),'disabled' => TRUE));
			echo $Form->input('re',array('type'=>'hidden','size' => '75','value'=>base64_decode($forumSubj)));
			echo '<div id="reply3"'.$results['Forum']['id'].' class="error-msg"></div>';
			
			
			echo $Form->textarea('comment', array('rows' => '5', 'cols' => '55','class'=>'ckeditor replybox'.$results['Forum']['id'],'id'=>'rep1'.$results['Forum']['id']));
			echo $Form->submit('Reply', array('div'=>true, 'name'=>'button_type','class' => 'qreply gobutton', 'title' => 'Reply', 'onclick' => "return checkValidation2(".$results['Forum']['id'].");"));
			echo $Form->submit('Save', array('div'=>true, 'name'=>'button_type','class' => 'gobutton','title' => 'Save as draft', 'onclick' => "return checkValidation2(".$results['Forum']['id'].");"));
			echo $Form->button('Preview', array('class'=>'gobutton','type' => 'button', 'title' => 'Preview the textarea content', 'onclick'=> "ShowReplyPreview1(".$results['Forum']['id'].");"));
			echo $Form->input('contId', array('value'=>$contentPageId, 'type'=>'hidden'));
			echo $Form->end();
		
			echo '</div>';
			}
			
			// start rating
			$data = $Js->get('#commentrate'.$results['Forum']['id'])->serializeForm(array('isForm' => true, 'inline' => true));
			$Js->get('#commentrate'.$results['Forum']['id'])->event(
					'submit',
					$Js->request(
							array('action' => 'rateComment', 'controller' => 'Forums'),
							array(
									//'update' => '#online-msg',
									'data' => $data,
									'async' => true,
									'dataExpression'=>true,
									'method' => 'POST',
									//'before'=>'before()',
									//'complete'=>'complete('.$results["Comment"]['id'].')'
									'success'=> "checkData(data,".$results['Forum']['id'].")"
							)
					)
			);
			echo $Js->writeBuffer();
			//end of rating
		}
		//check if child comments
		$draftCmts = $this->__getDraftCmts($forumId);
		
		//get allsection setting sections for same course
		$sections_list = $this->__allReplySections($contentPageId);
		
		$results_count = $this->Forum->find('count',array('conditions'=>array('NOT'=>array('Forum.id'=>$draftCmts),'Forum.parent_reply_id'=>$id, 'Forum.user_sectionname'=> $sections_list)));

		if ($results_count>0) {
			$results2 = $this->Forum->find('all',array('conditions'=>array('NOT'=>array('Forum.id'=>$draftCmts),'Forum.parent_reply_id'=>$id, 'Forum.user_sectionname'=> $sections_list)));
			foreach ($results2 as $result) {
				echo "<ul>";
				$this->loadChildComments($result['Forum']['id'],$currentPage,$forumId,$forumSubj,$contentPageId);
				echo "</ul>";
			}
		}
		echo '</div>';
		echo "<li>";
	}

	/**
	 * Method to rate post
	 * @param post id
	 */
	public function ratePost() 
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		//get rate data
		$data = $this->request['data'];
	
		$contentPageId = $data['Forum']['contId'];
		
		if ($data['post-rating']) {
			$data['RatePost']['question_id']=$data['Forum']['id'];
			$data['RatePost']['rate_by']=$user;
			$data['RatePost']['rate']=$data['post-rating'];
			$data['RatePost']['date']=time();
			$data['RatePost']['course_name']=$course_info->course_name;
			$data['RatePost']['section_name']=$course_info->section_name;
			$data['RatePost']['content_page_id']=$contentPageId;
			$this->RatePost->save($data);
			$this->Session->setFlash(__('Question rated successfully.'));
			$this->redirect('replyQuestion/'.$data['Forum']['id']."/".$contentPageId);
		}
		$this->Session->setFlash(__('Please select the stars to vote.'));
		
		$this->redirect('replyQuestion/'.$data['Forum']['id']."/".$contentPageId);
	}

	/**
	 * rate Comment ajax call
	 * @param request data
	 * @return void
	 */
	public function rateComment()
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		//get rate data
		$data = $this->request['data'];

		$cmtId = $data['Forum']['commentId'];
		if (isset($data['cmt-rating'.$cmtId])) {
		$rate = $data['cmt-rating'.$cmtId];
		$qid = $data['Forum']['questionId'];
		$contentPageId = $data['Forum']['contId'];
		if ($data) {
			$data['RateComment']['question_id']=$qid;
			$data['RateComment']['comment_id']=$cmtId;
			$data['RateComment']['question_id']=$qid;
			$data['RateComment']['rate_by']=$user;
			$data['RateComment']['rate']=$rate;
			$data['RateComment']['date']=time();
			$data['RateComment']['course_name']=$course_info->course_name;
			$data['RateComment']['section_name']=$course_info->section_name;
			$data['RateComment']['content_page_id']=$contentPageId;
			$result = $this->RateComment->save($data);
			echo 'valid';
		    exit;
		}
		}
		echo "invalid";
		exit;
	}
	
	/**
	 * Check if current user has rated the comment
	 * @param int
	 * @return string
	 */
	public function __checkIfUserVotedComment($commentId)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$chekVote = $this->RateComment->find('count',array('conditions'=>array('RateComment.rate_by'=>$user,'RateComment.comment_id'=>$commentId)));
		if ($chekVote) {
			return 1;
		}
		return 0;
	}
	
	/**
	 * Method to get rate percantage out of 5
	 * @param question id
	 * @return overAll rate
	 */
	public function __getRateCount1($id)
	{
		$maxRate = 5;
		$totalRate = 0;
		
		//load rating
		$results = $this->RatePost->find('all',array('conditions'=>array('RatePost.question_id'=>$id),'fields'=>array('RatePost.id','RatePost.rate')));
		
		//user count who rate the post
		$userCount = count($results);
		
		//total rating count
		foreach ($results as $result) {
			$totalRate = $totalRate+$result['RatePost']['rate'];
		}
			
		@$avgRating = round($totalRate/$userCount);
		return $avgRating;
	}

	/**
	 * Method to get rate count of question by login user
	 * @param question id
	 * @return overAll rate
	 */
	public function __getRateCount($id)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$maxRate = 5;
		$totalRate = 0;
		
		//load rating
		$results = $this->RatePost->find('first',array('conditions'=>array('RatePost.question_id'=>$id,'rate_by'=>$user),'fields'=>array('RatePost.id','RatePost.rate')));
		if($results)
			return $results['RatePost']['rate'];
		return 0;
	}
	
	/**
	 * Method to get rate percantage out of 5
	 * @param comment id
	 * @return overAll rate
	 */
	public function __getCommentRateCount($id)
	{
		$maxRate = 5;
		$totalRate = 0;
		
		//load rating
		$results = $this->RateComment->find('all',array('conditions'=>array('RateComment.comment_id'=>$id),'fields'=>array('RateComment.id','RateComment.rate')));
		
		//user count who rate the post
		$userCount = count($results);
		
		//total rating count
		foreach ($results as $result) {
			$totalRate = $totalRate+$result['RateComment']['rate'];
		}
	
		@$avgRating = round($totalRate/$userCount);
		return $avgRating;
	}

	/**
	 * Check user vote
	 * @param post id
	 * @return boolean
	 */
	public function checkUserVote($id)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		
		//load rating
		$results = $this->RatePost->find('count',array('conditions'=>array('RatePost.question_id'=>$id,'RatePost.rate_by'=>$user)));
		if ($results==0) {
			return false;
		} else {
			return true;
		}
			
	}
	
	/**
	 * Get Total users voted the comment
	 */
	public function __getUserVoted($cmtId)
	{
		
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCount = $this->RateComment->find('count',array('conditions'=>array('RateComment.comment_id'=>$cmtId),'fields'=>array('RateComment.id','RateComment.rate')));
	    if ($userCount) {
	    	return $userCount;
	    }
	     return 0;
	}

	/**
	 * Edit user Comment
	 * @param post id
	 * @return boolean
	 */
	public function editQuestion() 
	{
		$question_id = $this->request['data']['Forum']['id'];
		$question_body = $this->request['data']['Forum']['editComment'];
		$contentPageId = $this->request['data']['Forum']['contId'];
		$data['Forum']['id']= $question_id;
		$data['Forum']['post_date']= time();
		$data['Forum']['post_subject']= $this->request['data']['editSubject'];
		$data['Forum']['post_body']= $question_body;
		
		//check if some one has already commented the question
		$checkComment = $this->Forum->find('first', array('conditions'=>array('Forum.id'=>$question_id),'fields'=>array('Forum.is_reply')));
		if ($checkComment['Forum']['is_reply']==1) {
			$this->Session->setFlash(__('Some one has commentd on question. You can not edit question now !!'));
		} else {
			$this->Forum->save($data);
		}
		$this->redirect('replyQuestion/'.$question_id.'/'.$contentPageId);
	}

	/**
	 * Check if question has replied. if question has not
	 * replied then author can edit his question
	 * if replied then return true
	 * @param question id
	 */
	public function checkQuestionReply($id)
	{
		$result = $this->Forum->find('first',array('conditions'=>array('Forum.id'=>$id),'fields'=>array('post_by','id','is_reply','user_coursename', 'user_sectionname')));
		$courseName = $result['Forum']['user_coursename'];
		$sectionName = $result['Forum']['user_sectionname'];

		//get instrucor userName
		//a single section can have multiple instructor
		$instructors = $this->PleUser->find('all',array('conditions'=>array('PleUser.course'=>$courseName,'PleUser.section'=>$sectionName,'PleUser.user_type'=>'instructor'),'fields'=>array('userName')));

		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$result['Forum']['cUser']=$user;
		$result['Forum']['instructors']=$instructors;
		return $result['Forum'];
	}

	/**
	 * Delete Question
	 * Only instructor of that course will be able to delete
	 * @param question id
	 * @return none
	 */
	public function removeQuestion($id, $content_pageid)
	{
		if ($id) {
			$result = $this->Forum->delete($id);
			$this->redirect('askQuestion/'.$content_pageid);
		}
		$this->redirect('replyQuestion/'.$id.'/'.$content_pageid);
	}

	/**
	 *Filter Questions
	 *@param none
	 *@return none
	 */
	public function filterQuestions()
	{

		$this->Forum->virtualFields = array(
				'author_sort' => 'pleuser.name',
				'is_flag_sort' => 'QuestionAccess2.is_flag'
		);
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$contentpage_id = $this->request->query['contId'];
		$ids = array();
		
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$time = $this->request->query['ques_from'];
		
		//initialise the array
		$queryarray = array();
		
		//set the limit for pagination
		$options['limit'] = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		
		//check for Question Subject
		if ($this->request->query['post_subject'] !="") {

			$subject = $this->request->query['post_subject'];
			$options['conditions'][] = array('Forum.post_subject LIKE'=>'%'.$subject.'%');

		}
		
		//check for Question status
		if ($this->request->query['ques_status'] !="") {
			
			//check for draft
			//List only current user login questions
			if ($this->request->query['ques_status'] == 1) {
					
				$is_draft = $this->request->query['ques_status'];
				$options['conditions'][] = array('Forum.is_draft'=>$is_draft,'Forum.post_by'=>$user);
			}
			
			//check for published
			//list all users questions
			if ($this->request->query['ques_status'] == 0) {
					
				$is_draft = $this->request->query['ques_status'];
				$options['conditions'][] = array('Forum.is_draft'=>$is_draft);
			}
		}
		
		//check for flag
		//list only current user login questions
		if ($this->request->query['ques_flag'] !=0 ) {

			$options['conditions'][] = array(
					
					//'AccessQuestion.is_flag' => 1
			);

			$options['joins'][] =
			array('table' => 'ple_questions_access',
					'alias' => 'qa1',
					'type' => 'INNER',
					'conditions' => array(
							'qa1.question_id = Forum.id','qa1.is_flag' =>1,'qa1.user_id'=>$user)
			)
			;
		}
			
		//check for read/unread
		if ($this->request->query['ques_type'] !="" ) {
			
			//check for read
			if ($this->request->query['ques_type'] ==1 ) {
				$qtype = $this->request->query['ques_type'];
				$options['conditions'][] = array(
						//'AccessQuestion.is_flag' => 1
				);

				$options['joins'][] =
				array('table' => 'ple_questions_access',
						'alias' => 'qa2',
						'type' => 'INNER',
						'conditions' => array(
								'qa2.question_id = Forum.id','qa2.is_read' =>$qtype,'qa2.user_id'=>$user)
				)
				;
			}
			//check for unread
			if ($this->request->query['ques_type'] ==0 ) {

				//get read posts id
				$results = $this->AccessQuestion->find('all',array('conditions'=>array('user_id'=>$user,'is_read'=>1),'fields'=>array('AccessQuestion.question_id')));
				foreach ($results as $res) {
					$ids[] = $res['AccessQuestion']['question_id'];
				}

				$qtype = $this->request->query['ques_type'];
				$options['conditions'][] = array(
		    "NOT" => array("Forum.id" => $ids)
				);
					
			}
		}

		//check for start time
		if ($this->request->query['ques_from'] !="" ) {

			$fromTime = strtotime($this->request->query['ques_from']);
			//current time
			$ctime = time();
			$qtype = $this->request->query['ques_type'];
			$options['conditions'][] = array(
					'Forum.post_date >=' => $fromTime
			);

		}

		//check for end time
		if ($this->request->query['ques_to'] !="" ) {

			$toTime = strtotime($this->request->query['ques_to']);
			//current time
			$ctime = time();
			$qtype = $this->request->query['ques_type'];
			$options['conditions'][] = array(
					'Forum.post_date <=' => $toTime
			);

		}

		//check for author
		if (!empty($this->request->query['post_by'])) {
			$options['conditions'][] = array(
					'Forum.post_by' => $this->request->query['post_by']
			);
		}

		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($contentpage_id);
		
		//handling for insection-allsection  for forum..
		$setting_result = $this->__findForumSetting($course_info,$contentpage_id);
        //set condition so that user will get post of his section and the other sections having all section setting.
		$options['conditions'][] = array(
		 					'Forum.user_coursename'=>$course_info->course_name,
						   'Forum.contentpage_id'=>$contentpage_id, 'Forum.user_sectionname'=>$sections_list
					);
					
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'pleuser',
				'type' => 'INNER',
				'conditions'=> array(
						'Forum.post_by = pleuser.userName','pleuser.course'=>$course_info->course_name
				)
		);
		//code for sorting the posts default is_pin
		$options['joins'][] =
		array('table' => 'ple_questions_access',
				'alias' => 'QuestionAccess2',
				'type' => 'LEFT',
				'conditions' => array(
						'Forum.id = QuestionAccess2.question_id', 'QuestionAccess2.user_id'=>$user)
		);

		//set condition for draft questions
		$postoptions['conditions'][] = array('NOT'=>array('Forum.post_by'=>$user),'Forum.user_coursename'=> $course_info->course_name, 'Forum.user_sectionname'=> $sections_list, 'Forum.contentpage_id'=>$contentpage_id, 'Forum.is_draft'=>1);
		$postoptions['fields'] = array('Forum.id');
		
		//finding the posts id those are draft and draft by the not logged user..
		$posts_ids = $this->Forum->find('all', $postoptions);
		$question_ids = array();
		foreach ($posts_ids as $postids_data)
		{
			$question_ids[] = $postids_data['Forum']['id'];
		}
		$options['conditions'][] = array('NOT'=> array('Forum.id'=>$question_ids)); // handling for those are draft and not of the current users..

		$options['fields'] = array('pleuser.name','Forum.post_date', 'Forum.is_draft', 'Forum.post_body', 'Forum.post_by', 'Forum.post_subject','Forum.question_id','Forum.post_type');
		//Use the different query to get comment to implement pagination
		$this->Paginator->settings = $options;
		$searchResults = $this->Paginator->paginate('Forum');
		
		$this->set('posts', $searchResults);
		$this->set('contentPageId', $contentpage_id);
		$this->layout = 'forum';
		$this->render('forum_filter');
	}
	
	/**
	 * get section based on all section setting 
	 * @param none
	 * @return array
	 */
	public function __allSectionsNotUsed()
	{
		//current user course
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$sections = $this->PleForumSetting->find('all',array('conditions'=>array('PleForumSetting.course'=>$course_info->course_name,'PleForumSetting.setting_value'=>2),'fields'=>array('section')));
		foreach ($sections as $section) {
			$sectionList[] = trim($section['PleForumSetting']['section']);
		}
		
		//add current user login section
		$sectionList[] = $course_info->section_name;
		$tz = array_unique($sectionList);
		return $tz;
	}

	/**
	 * get section based on all section setting and if content page lie in that date
	 * @param string
	 * @return array
	 */
// 	private function __allSections($content_page_id=null)
// 	{
// 	    //initialise the array
// 		$result_list = array();
// 		$section_list = array();
		
// 		//current user course
// 		$user_course = $this->Session->read('UserData.usersCourses');
// 		$user_course_section = $user_course[0];
// 		$user_exploded_course = explode('-', $user_course_section);
		
// 		//get section on the basis of content page id @2/21/2014
// 		$sections = $this->PleForumSetting->find('all',array('conditions'=>array('PleForumSetting.course'=>$user_exploded_course[0],'PleForumSetting.setting_value'=>2, 'PleForumSetting.contentpage_id' => $content_page_id),'fields'=>array('section')));
// 		foreach($sections as $section){
// 			$section_list[] = trim($section['PleForumSetting']['section']);
// 		}
// 		//add current user login section
// 		$section_list[] = $user_exploded_course[1];
// 		$unique_sections = array_unique($section_list);
		
// 		//get current time
// 	    $ctime = time();
		
// 	    //get sections on the basis of content page date setting 
// 		$results = $this->ContentPageSetting->find('all',array('conditions'=>
// 				array(
// 						'ContentPageSetting.course'=>$user_exploded_course[0],
// 						'ContentPageSetting.contentpage_id'=>$content_page_id,
// 						'ContentPageSetting.section'=>$unique_sections,
// 						'ContentPageSetting.start_date <='=>$ctime,
// 						'ContentPageSetting.end_date >='=>$ctime
// 						)));
// 		foreach ($results as $result) {
// 			$result_list[] = trim($result['ContentPageSetting']['section']);
// 		}
		
// 		//remove duplicate section if exist
// 		$result_sections = array_unique($result_list);
// 		return $result_sections;
// 	}

	/**
	 * get section based on all section setting and if content page lie in that date
	 * @param contentPageId
	 * @return array
	 */
	public function __allSections($contentPageId = null) {
		$resultList = array();
		$result_list_not_exist = array();
		$results_exits = array();
		$sectionList = array();
		//current user course
		//$contentPageId = 'topic1';
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		$course_info = $this->getCourseNameOfUser($user_course_section);
	
		$sections = $this->PleForumSetting->find('all', array('conditions' => array('PleForumSetting.course' => $course_info->course_name, 'PleForumSetting.setting_value' => 2, 'PleForumSetting.contentpage_id' => $contentPageId), 'fields' => array('course', 'section')));
		foreach ($sections as $section) {
			$sectionList[] = trim($section['PleForumSetting']['course']) . '-' . trim($section['PleForumSetting']['section']);
		}
		//add current user login section
		$sectionList[] = $user_course_section;
		$tzs = array_unique($sectionList);
      
		//START
		//check if record exists
		$results_exits = $this->PleForumAvailability->find('list', array('conditions' =>array(
				'PleForumAvailability.course_id' => $tzs,
				'PleForumAvailability.uuid' => $contentPageId,
				'PleForumAvailability.type' => 'contentpage'
		),
				'fields'=>array('PleForumAvailability.course_id')));
		
		//get the cours_id whose setting is not set
		$result_not_extsts = array_diff($tzs, $results_exits);
		
		//get section list of  content page for which setting is not set.
		foreach($result_not_extsts as $result_not_extst) {
			$course_not_exist = explode('-', trim($result_not_extst));//@TODO need to work
			$result_list_not_exist[] = $course_not_exist[1]; //get section name
		}
		//END
		
		//get current time
		$ctime = date('Y-m-d H:i:s');
		//get sections on the basis of content page date setting
		$results = $this->PleForumAvailability->find('all', array('conditions' =>
				array(
						'PleForumAvailability.course_id' => $tzs,
						'PleForumAvailability.uuid' => $contentPageId,
						'PleForumAvailability.type' => 'contentpage',
						//'PleForumAvailability.post_begin_date <=' => $ctime,
						'PleForumAvailability.post_end_date >=' => $ctime,
						array('OR'=>array('PleForumAvailability.post_begin_date <='=>$ctime, 'PleForumAvailability.post_begin_date ='=>NULL))
				)));
		
		foreach ($results as $result) {
			$alter_course = explode('-', trim($result['PleForumAvailability']['course_id']));//@TODO need to work
			$resultList[] = $alter_course[1]; //get section name
		}
		
		//merge the result with not exist section for which setting is not set
		$result_list_updated = array_merge($resultList, $result_list_not_exist);
		
		//HANDLING OF DUPLICACY..
		$tyzs = array_unique($result_list_updated);
		return $tyzs;
	}

	/**
	 * get section based on all section setting and if content page lie in that date
	 * @param contentPageId
	 * @return array
	 */
	public function __allPostSections($contentPageId = null) {
		$resultList = array();
		$result_list_not_exist = array();
		$results_exits = array();
		$sectionList = array();
		//current user course
		//$contentPageId = 'topic1';
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		$course_info = $this->getCourseNameOfUser($user_course_section);
	
		$sections = $this->PleForumSetting->find('all', array('conditions' => array('PleForumSetting.course' => $course_info->course_name, 'PleForumSetting.setting_value' => 2, 'PleForumSetting.contentpage_id' => $contentPageId), 'fields' => array('course', 'section')));
		foreach ($sections as $section) {
			$sectionList[] = trim($section['PleForumSetting']['course']) . '-' . trim($section['PleForumSetting']['section']);
		}
		//add current user login section
		$sectionList[] = $user_course_section;
		$tzs = array_unique($sectionList);
	
		foreach ($tzs as $tzs_spilt) {
			$alter_course = explode('-', trim($tzs_spilt));
			$tzsList[] = $alter_course[1];  //get section name
		}
	
	
		//START
		//check if record exists
		$results_exits = $this->PleForumAvailability->find('list', array('conditions' =>array(
				'PleForumAvailability.course_id' => $tzs,
				'PleForumAvailability.uuid' => $contentPageId,
				'PleForumAvailability.type' => 'contentpage'
		),
				'fields'=>array('PleForumAvailability.course_id')));
	
		//get the cours_id whose setting is not set
		$result_not_extsts = array_diff($tzs, $results_exits);
	
		//get section list of  content page for which setting is not set.
		foreach($result_not_extsts as $result_not_extst) {
			$course_not_exist = explode('-', trim($result_not_extst));//@TODO need to work
			$result_list_not_exist[] = $course_not_exist[1]; //get section name
		}
		//END

		//merge the result with not exist section for which setting is not set
		$result_list_updated = array_merge($tzsList, $result_list_not_exist);
	
		//HANDLING OF DUPLICACY..
		$tyzs = array_unique($result_list_updated);
		return $tyzs;
	}
	
	/**
	 * get section based on all section setting and if content page lie in that date
	 * @param contentPageId
	 * @return array
	 */
// 	private function __allReplySections($content_page_id=null)
// 	{
// 		$result_list = array();
// 		$section_list = array();
		
// 		//current user course
// 		$user_course = $this->Session->read('UserData.usersCourses');
// 		$user_course_section = $user_course[0];
// 		$user_exploded_course = explode('-', $user_course_section);
		
// 		//get section on the basis of content page id @2/21/2014
// 		$sections = $this->PleForumSetting->find('all',array('conditions'=>array('PleForumSetting.course'=>$user_exploded_course[0],'PleForumSetting.setting_value'=>2, 'PleForumSetting.contentpage_id' => $content_page_id),'fields'=>array('section')));
// 		foreach($sections as $section){
// 			$section_list[] = trim($section['PleForumSetting']['section']);
// 		}
		
// 		//add current user login section
// 		$section_list[] = $user_exploded_course[1];
// 		$tzs = array_unique($section_list);
	
// 		//get current time
// 		$ctime = time();
// 		//get sections on the basis of content page date setting
// 		$results = $this->ContentPageSetting->find('all',array('conditions'=>
// 				array(
// 						'ContentPageSetting.course'=>$user_exploded_course[0],
// 						'ContentPageSetting.contentpage_id'=>$content_page_id,
// 						'ContentPageSetting.section'=>$tzs,
// 						'ContentPageSetting.rstart_date <='=>$ctime,
// 						'ContentPageSetting.rend_date >='=>$ctime
// 				)));
// 		foreach ($results as $result) {
// 			$result_list[] = trim($result['ContentPageSetting']['section']);
// 		}
// 		//remove duplicate section if exist
// 		$tyzs = array_unique($result_list);
// 		return $tyzs;
// 	}
	private function __allReplySections($contentPageId=null)
	{
		$resultList = array();
        $result_list_not_exist = array();
        $results_exits = array();
        $sectionList = array();
		//current user course
		//$contentPageId = 'topic1';
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		//$user_exploded_course = explode('-', $user_course_section);
		$sections = $this->PleForumSetting->find('all', array('conditions' => array('PleForumSetting.course' => $course_info->course_name, 'PleForumSetting.setting_value' => 2, 'PleForumSetting.contentpage_id' => $contentPageId), 'fields' => array('course', 'section')));
		foreach ($sections as $section) {
			$sectionList[] = trim($section['PleForumSetting']['course']) . '-' . trim($section['PleForumSetting']['section']);
		}
		//add current user login section
		$sectionList[] = $user_course_section;
		$tzs = array_unique($sectionList);
		
		foreach ($tzs as $tzs_spilt) {
			$alter_course = explode('-', trim($tzs_spilt));
			$tzsList[] = $alter_course[1];  //get section name
		}
		
		//START
		//check if record exists
		$results_exits = $this->PleForumAvailability->find('list', array('conditions' =>array(
				'PleForumAvailability.course_id' => $tzs,
				'PleForumAvailability.uuid' => $contentPageId,
				'PleForumAvailability.type' => 'contentpage'
		),
				'fields'=>array('PleForumAvailability.course_id')));
		
		//get the cours_id whose setting is not set
		$result_not_extsts = array_diff($tzs, $results_exits);
		
		//get section list of  content page for which setting is not set.
		foreach($result_not_extsts as $result_not_extst) {
			$course_not_exist = explode('-', trim($result_not_extst));//@TODO need to work
			$result_list_not_exist[] = $course_not_exist[1]; //get section name
		}
		//END
		
// 		//get current time
// 		$ctime = date('Y-m-d H:i:s');
		
// 		//get sections on the basis of content page date setting
// 		$results = $this->PleForumAvailability->find('all', array('conditions' =>
// 				array(
// 						'PleForumAvailability.course_id' => $tzs,
// 						'PleForumAvailability.uuid' => $contentPageId,
// 						//'PleForumAvailability.reply_begin_date <=' => $ctime,
// 						'PleForumAvailability.reply_end_date >=' => $ctime,
// 						array('OR'=>array('PleForumAvailability.reply_begin_date <='=>$ctime, 'PleForumAvailability.reply_begin_date ='=>NULL))
// 				)));
// 		foreach ($results as $result) {
// 			$alter_course = explode('-', trim($result['PleForumAvailability']['course_id']));
// 			$resultList[] = $alter_course[1];  //get section name
// 		}
		
		//merge the result with not exist section for which setting is not set
		$result_list_updated = array_merge($tzsList, $result_list_not_exist);
		
		
		//HANDLING OF DUPLICACY..
		$tyzs = array_unique($result_list_updated);
		
		return $tyzs;
	}
		
	/**
	 * Seach the questions according to title,body,author
	 * @param none
	 * @return none
	 */
	public function searchAll()
	{
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$this->Forum->virtualFields = array(
				'author_sort' => 'pleuser.name',
				'is_flag_sort' => 'QuestionAccess1.is_flag'
		);
		//get form data
		$searchData="";
		$contentpage_id = "";
		//initialise the search array
		$userSearchArray = array();
		//get current user login name
		$user = $this->Session->read('UserData.userName');
		$contentpage_id = $_GET['contId'];
		//$contentpage_id = $_GET['contId'];
		//check if user has submitted the form
		if ($this->request->query['searchData']) {
			$searchData =$this->request->query['searchData'];
			$contentpage_id = $_GET['contId'];
			
			//create the search array
			$userSearchArray[] = array('Forum.post_subject LIKE' => '%'.$searchData.'%');
			$userSearchArray[] = array('Forum.post_body LIKE' => '%'.$searchData.'%');
			//get name from uid
			$names = $this->PleUser->find('all',array('conditions'=>array('PleUser.name LIKE'=>'%'.$searchData.'%')));
			foreach($names as $name){
				$userSearchArray[] = array('Forum.post_by LIKE' => '%'.$name['PleUser']['userName'].'%');
			}
		} else {
			$searchData="";
		}
		$search['conditions'][] =  array('OR' => $userSearchArray
		);
		$search['conditions'][] = array(
				'Forum.is_draft'=>0,
		);

		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($contentpage_id);
		$search['conditions'][] = array(
							'Forum.user_coursename'=>$course_info->course_name,
		 					'Forum.contentpage_id'=>$contentpage_id, 'Forum.user_sectionname'=>$sections_list
				);

		$search['limit'] = Configure::read('limit'); //define in bootstrap.php in config(default is 5, can be changed.)
		$search['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'pleuser',
				'type' => 'INNER',
				'conditions'=> array(
						'Forum.post_by = pleuser.userName','pleuser.course'=>$course_info->course_name
				)
		);
		$search['joins'][] = array(
				'table' => 'ple_questions_access',
				'alias' => 'QuestionAccess1',
				'type' => 'LEFT',
				'conditions'=> array(
						'Forum.id = QuestionAccess1.question_id', 'QuestionAccess1.user_id'=>$user
				)
		);
		$search['fields'] = array('pleuser.name','Forum.post_date', 'Forum.is_draft', 'Forum.post_body', 'Forum.post_by', 'Forum.post_subject','Forum.question_id','Forum.post_type');
		//Use the different query to get comment to implement pagination
		$this->Paginator->settings = $search;
		$searchResults = $this->Paginator->paginate('Forum');
		$this->set('posts', $searchResults);
		$this->set('contentPageId', $contentpage_id);
		$this->layout = 'forum';
		$this->render('forum_filter');
	}
	
	/**
	 * get the first and last name of the user
	 * @param userId/midasId
	 * @return int
	 */
	public function getUserProfileName($uid)
	{
		$pname = $this->PleUser->find('first',array('conditions'=>array('userName'=>$uid),'fields'=>array('PleUser.name')));

		if ($pname) {
			return $pname['PleUser']['name'];
		}
		return $uid;
	}
	
	/**
	 * Count the number of user casted the vote
	 * @param unknown_type $id
	 * @return int
	 */
	public function getUserVoteCount($id)
	{
		$userCount = $this->RatePost->find('count',array('conditions'=>array('question_id'=>$id)));
		return $userCount;
	}
	
	/**
	 * Sending the Reply Email notifications to users those Subscription setting is on
	 * @params post id
	 * @return boolean
	 */
	private function __sendReplyPostsNotification($post_id, $reply_id, $contentPageId)
	{
      
		$this->Forum->virtualFields = array(); //define for making these blank.
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		//$contentpage_id = $explored_course[0]; //@TODO we have to change it by the session value.
		
		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($contentPageId);
					$forumoptions[] = array(
							'EmailUser.midas_id = PleForumSubscription.user_id',
							'PleForumSubscription.user_coursename'=>$course_info->course_name,
							'PleForumSubscription.contentpage_id'=>$contentPageId,
							'PleForumSubscription.user_sectionname'=>$sections_list,
							'PleForumSubscription.subscription_type'=>0
					);
		$options['conditions'][] = array('PleForumSubscription.setting_value'=>1, 'EmailUser.midas_id !='=>$user); // handling for those users except current logged-in are enabled setting for receving the notification.
		$options['joins'][] = array(
				'table' => 'ple_forum_subscription_setting',
				'alias' => 'PleForumSubscription',
				'type' => 'INNER',
				'conditions'=> $forumoptions
		);
		$options['fields'] = array( 'EmailUser.*' );

		$users_list  = $this->EmailUser->find('all', $options);

		$emails = array();
		foreach ($users_list as $list) {
		 //check if user has email notification enabled
	     $notificationType = $this->__getNotificationSetting($contentPageId, $list['EmailUser']['midas_id'], $list['EmailUser']['section']);
	     if ( $notificationType['emailSetting'] == 1 ){
		  $emails[] = $list['EmailUser']['email'];
	     }
		}
		
		if(count($emails)): // If any user wants then we will send mail o/w not.
		$this->Email->layout = 'postmaillayout'; //view/Layouts/Emails/html/postmaillayout.php
		//Note: As we have defined $this->Email->sendAs as 'html', so this file should be only in html folder, if pass 'both' then should be in text and html folder also.
		//get parent question and reply
		$question['fields'] = array( 'Forum.*','Forum.id','Forum.post_body','Forum.post_date','Forum.post_by');
		$question['conditions'][]=array('Forum.id'=>$reply_id);
	

		$post_data = $this->Forum->find('first',$question);
		//get post author name
		$post_author = $this->getUserName($post_data['Forum']['post_by']);

		//get the post body
		$post_body = $post_data['Forum']['post_body'];
		$post_type = " -RE:";
		//get odu server url
		$odu_url = Configure::read('odu_url');
		$subject = ucfirst($post_data['Forum']['user_coursename']).'-'.ucfirst($post_data['Forum']['user_sectionname']).$post_type.
		ucfirst($post_data['Forum']['post_subject']).' posted by '. ucfirst($post_author);
		
		$parentQuestion = '<b>'.ucfirst($post_data['Forum']['user_coursename']).'-'.ucfirst($post_data['Forum']['user_sectionname']).'</b>'. $post_type.
		ucfirst($post_data['Forum']['post_subject']).' posted by <b>'. ucfirst($post_author).'</b>';
		$parentQuestion .= "<br />".$post_body." <br /><br />You can access the discussion for this post with the following link. ";
		$parentQuestion .= $odu_url."/forums/forumlist/".$contentPageId;
		//$parentQuestion = "A new comment is posted on <br />".date('m-d-Y: h:i A',$post_data['Forum']['post_date']).trim(substr($post_data['Forum']['post_body'],0,30))."...";
		//$parentQuestion .= "<br />For Question ".$post_data['Forum']['post_subject'];

		$maildata = $parentQuestion;
		//$this->set('content', $maildata);
		//$this->Email->to = $emails;
		//$subject = 'New Post Added with Subject('.ucfirst($post_data['Forum']['post_subject']).')';
		//$this->Email->subject = 'New Comment Added with Subject('.ucfirst($post_data['Forum']['post_subject']).')';
		//$this->Email->from = Configure::read('mail-from');
		//$this->Email->template = 'postmail'; //view/Emails/html/postmail.php
		//Note: As we have defined $this->Email->sendAs as 'html', so this file should be only in html folder, if pass 'both' then should be in text and html folder also.
		//Send as 'html', 'text' or 'both' (default is 'text') because we like to send pretty mail
		//$this->Email->sendAs = 'html';
		// setting for smtp set the parameter
		//$smtparray     = Configure::read('smtpparam');

		//$this->Email->smtpOptions = array(
		//		'port'=> $smtparray['port'],
		//		'timeout'=> $smtparray['timeout'],
		//		'host' => $smtparray['host'],
		//		'username'=> $smtparray['username'],
		//		'password'=> $smtparray['password'],
		//);

		//save for mail queue
		$this->saveOduEmailQueue( $emails, $subject, $maildata);
		
		/* Set delivery method */
		//$this->Email->delivery = 'smtp';
		//	if ( $this->Email->send($maildata) ) {
		//	return true;
		//} else {
		//	return true;
		//}
		endif;
	}
	
	/**
	 * Mark draft comment as published ajax call
	 * @param int, int
	 * @return boolean
	 */
	public function publishComment()
	{
	
		$data = $this->request['data'];
		$comment_id = $data['comment_id'];
		$qid = $data['qid'];
		$contentPageId = $data['contentPageId'];
		$data['id'] = $comment_id;
		$data['is_draft'] = 0;
		//query to publish the comment
		$result = $this->Forum->save($data);
		if ($result) {
		    //send twitter notification
			$this->__sendReplyPostsTwitterNotification($qid,$comment_id,$contentPageId);
			
			//send facebook notification
			$this->__sendReplyPostsFacebookNotification($qid,$comment_id,$contentPageId);
			
			//send odu notification
			$this->__sendReplyPostsNotification($qid,$comment_id,$contentPageId);
		}
		exit;
	}
	
	/**
	 * Method to get rate percantage out of 5
	 * @param question id
	 * @return overAll rate
	 */
	public function getOverallRate($id)
	{
		$maxRate = 5;
		$totalRate = 0;
		//load rating
		$results = $this->RatePost->find('all',array('conditions'=>array('RatePost.question_id'=>$id),'fields'=>array('RatePost.id','RatePost.rate')));
		//user count who rate the post
		$userCount = count($results);
		//total rating count
		foreach ($results as $result) {
			$totalRate = $totalRate+$result['RatePost']['rate'];
		}

		@$avgRating = round($totalRate/$userCount);
		return $avgRating;
	}
	
	/**
	 * Method for pinned/unpinned a question(post) ajax call
	 * @params post id
	 * @return boolean
	 */
	public function pinunpinQuestion()
	{
		if ($this->request->is('post')) {
			//get current login user object.
			$user = $this->Session->read('UserData.userName');
			$userCourse = $this->Session->read('UserData.usersCourses');
			$user_course_section = $userCourse[0];
			//$user_exploded_course = explode('-', $user_course_section);
			//get user course-section info
			$course_info = $this->getCourseNameOfUser($user_course_section);
			
			$question_id = $this->request['data']['question_id'];
			$pinunpin_title = $this->request['data']['title'];
			if ($pinunpin_title == 'pin post')
				$data['AccessQuestion']['is_pin'] = 1;
			else
				$data['AccessQuestion']['is_pin'] = 0;
			//checking the entry is already is in DB..
			$dataexists = $this->AccessQuestion->find('first', array('conditions'=>array('AccessQuestion.question_id'=>$question_id, 'AccessQuestion.user_id'=>$user, 'AccessQuestion.course_name'=>$course_info->course_name)));
			if($dataexists['AccessQuestion']['id']):
			//preparing the data for saving if row is already exists..
			$data['AccessQuestion']['id'] = $dataexists['AccessQuestion']['id'];
			else:
			//preparing the data for saving if row is not already exists..
			$data['AccessQuestion']['question_id'] = $question_id;
			$data['AccessQuestion']['user_id'] = $user;
			$data['AccessQuestion']['course_name'] = $course_info->course_name;
			$data['AccessQuestion']['section_name'] = $course_info->section_name;
			endif;
			if ($this->AccessQuestion->save($data)) {
				echo @$this->AccessQuestion->id;
				exit;
			} else {
				echo @$this->AccessQuestion->id;
				exit;
			}
		} else {
			echo @$this->AccessQuestion->id;
			exit;
		}
	}
	
	/**
	 * Checking for a question(post) is pinned by a user
	 * @params $question_id
	 * @return boolean(1/0)
	 */
	public function checkPostPin($question_id)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$post_access_data = $this->AccessQuestion->find('first', array('conditions'=>array('AccessQuestion.user_id'=>$user, 'AccessQuestion.question_id'=> $question_id, 'AccessQuestion.course_name'=>$course_info->course_name)));
		return @$post_access_data['AccessQuestion']['is_pin'];
	}
	
	/**
	 * Method for flag/unflag a question(post) ajax call
	 * @params post id
	 * @return int
	 */
	public function flagunflagQuestion()
	{
		if ($this->request->is('post')) {
			//get current login user object.
			$user = $this->Session->read('UserData.userName');
			$userCourse = $this->Session->read('UserData.usersCourses');
			$user_course_section = $userCourse[0];
			//$user_exploded_course = explode('-', $user_course_section);
			//get user course-section info
			$course_info = $this->getCourseNameOfUser($user_course_section);
			
			$question_id = $this->request['data']['question_id'];
			$flagunflag_title = $this->request['data']['title'];
			if($flagunflag_title == 'flag post')
				$data['AccessQuestion']['is_flag'] = 1;
			else
				$data['AccessQuestion']['is_flag'] = 0;
			//checking the entry is already is in DB..
			$dataexists = $this->AccessQuestion->find('first', array('conditions'=>array('AccessQuestion.question_id'=>$question_id, 'AccessQuestion.user_id'=>$user, 'AccessQuestion.course_name'=>$course_info->course_name)));
			if($dataexists['AccessQuestion']['id']):
			//preparing the data for saving if row is already exists..
			$data['AccessQuestion']['id'] = $dataexists['AccessQuestion']['id'];
			else:
			//preparing the data for saving if row is not already exists..
			$data['AccessQuestion']['question_id'] = $question_id;
			$data['AccessQuestion']['user_id'] = $user;
			$data['AccessQuestion']['course_name'] = $course_info->course_name;
			$data['AccessQuestion']['section_name'] = $course_info->section_name;
			endif;
			if ($this->AccessQuestion->save($data)) {
				echo @$this->AccessQuestion->id;
				exit;
			} else {
				echo @$this->AccessQuestion->id;
				exit;
			}
		} else {
			echo @$this->AccessQuestion->id;
			exit;

		}
	}

	/**
	 * Checking for a question(post) is flagged by a user
	 * @params $question_id
	 * @return boolean
	 */
	public function checkPostFlag($question_id)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$post_access_data = $this->AccessQuestion->find('first', array('conditions'=>array('AccessQuestion.user_id'=>$user, 'AccessQuestion.question_id'=> $question_id, 'AccessQuestion.course_name'=>$course_info->course_name)));
		return @$post_access_data['AccessQuestion']['is_flag'];
	}
	/**
	 * Making a post publish.. ajax call
	 * @params post id
	 * @return int
	 */
	public function publishPost()
	{
		if ($this->request->is('post')) {
			//get current login user object.
			$user = $this->Session->read('UserData.userName');
			$userCourse = $this->Session->read('UserData.usersCourses');
			$user_course_section = $userCourse[0];
			//$user_exploded_course = explode('-', $user_course_section);
			//get user course-section info
			$course_info = $this->getCourseNameOfUser($user_course_section);
			
			$question_id = $this->request['data']['question_id'];
			$contentpage_id = $this->request['data']['contentpage_id'];
			//preparing the data for saving if row is not already exists..
			$data['Forum']['id'] = $question_id;
			$data['Forum']['is_draft'] = 0;
			if ($this->Forum->save($data)) {
				$this->__sendNewPostsNotification($this->Forum->id, $contentpage_id);//sending new post notification according to the enabling the setting by users.
				$this->__sendNewPostsTwitterNotification($this->Forum->id, $contentpage_id);//sending new post notification via twitter according to the enabling the setting by users.
				$this->__sendNewPostsFacebookNotification($this->Forum->id, $contentpage_id);//sending new post notification via facebook according to the enabling the setting by users.
				echo @$this->Forum->id;
				exit;
			} else {
				echo @$this->Forum->id;
				exit;
			}
		} else {
			echo @$this->Forum->id;
			exit;
		}
	}
	
	/**
	 * Making the question(post) as status as read
	 * @params question_id
	 * @return boolean
	 */
	private function __markReadQuestion($qid)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$result = $this->Forum->find('count', array('conditions'=>array('Forum.id'=>$qid)));
		if($result):
		// if question is exists then it will mark as read.
		//finding the entry from db on user and question basis..
		$dataexists = $this->AccessQuestion->find('first', array('conditions'=>array('AccessQuestion.question_id'=>$qid, 'AccessQuestion.user_id'=>$user, 'AccessQuestion.course_name'=>$course_info->course_name)));
		if(@$dataexists['AccessQuestion']['id']):
		//preparing the data for saving if row is already exists..
		$data['AccessQuestion']['id'] = $dataexists['AccessQuestion']['id'];
		$data['AccessQuestion']['is_read'] = 1;
		$this->AccessQuestion->save($data);
		else:
		//preparing the data for saving if row is not already exists..
		$data['AccessQuestion']['question_id'] = $qid;
		$data['AccessQuestion']['user_id'] = $user;
		$data['AccessQuestion']['course_name'] = $course_info->course_name;
		$data['AccessQuestion']['section_name'] = $course_info->section_name;
		$data['AccessQuestion']['is_read'] = 1;
		$this->AccessQuestion->create();
		$this->AccessQuestion->save($data);
		endif;
		endif;
		return true;
	}
	
	/**
	 * Finding the insection-allsection setting for the course
	* @params course-section
	* @return string
	*/
	private function __findForumSetting($course_info, $contentPageId)
	{
		$result = $this->PleForumSetting->find('first', array('conditions'=>array('PleForumSetting.course'=>$course_info->course_name, 'PleForumSetting.contentpage_id'=>$contentPageId), 'fileds'=>array('PleForumSetting.setting_value')));
		if(@$result['PleForumSetting']['setting_value'])
			return $result['PleForumSetting']['setting_value'];
		return 2; //by default we are assuming it is the all section setting
	}
	/**
	 * Sending the Email notifications to users those Subscription setting is on
	 * @params post id
	 * @return boolean
	 */
	private function __sendNewPostsNotification($post_id,$contentPageId)
	{
		$this->Forum->virtualFields = array(); //define for making these blank.
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $contentPageId; //@TODO we have to change it by the session value.
		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($contentPageId);
		$forumoptions[] = array(
						'EmailUser.midas_id = PleForumSubscription.user_id', 'PleForumSubscription.user_coursename'=>$course_info->course_name,
						'PleForumSubscription.contentpage_id'=>$contentPageId, 'PleForumSubscription.user_sectionname'=>$sections_list, 'PleForumSubscription.subscription_type'=>0
					);
		$options['conditions'][] = array('PleForumSubscription.setting_value'=>1, 'EmailUser.midas_id !='=>$user); // handling for those users except current logged-in are enabled setting for receving the notification.
		$options['joins'][] = array(
				'table' => 'ple_forum_subscription_setting',
				'alias' => 'PleForumSubscription',
				'type' => 'INNER',
				'conditions'=> $forumoptions
		);
		$options['fields'] = array( 'EmailUser.*' );
		$users_list  = $this->EmailUser->find('all', $options);
		
		$emails = array();
		foreach ($users_list as $list) {
		 //check if user has email notification enabled
	     $notificationType = $this->__getNotificationSetting($contentPageId, $list['EmailUser']['midas_id'], $list['EmailUser']['section']);
	     if ( $notificationType['emailSetting'] == 1 ) {
		  $emails[] = $list['EmailUser']['email'];
	     }
		}
	
		if (count($emails)): // If any user wants then we will send mail o/w not.
		$this->Email->layout = 'postmaillayout'; //view/Layouts/Emails/html/postmaillayout.php
		//Note: As we have defined $this->Email->sendAs as 'html', so this file should be only in html folder, if pass 'both' then should be in text and html folder also.
		$this->Forum->id = $post_id;
		$post_data = $this->Forum->read();
		//get post author name 
		$post_author = $this->getUserName($post_data['Forum']['post_by']);
		//$maildata1 ='A New Post with Subject "'.ucfirst($post_data['Forum']['post_subject']).'" is post by user '.ucfirst($post_data['Forum']['post_by']); //mail content prepare here.
		//$maildata1 .= '<br>Course: '.ucfirst($post_data['Forum']['user_coursename']).'<br> Content Page: '.ucfirst($post_data['Forum']['contentpage_id']);
		
		
		//$this->set('content', $maildata);
		//$this->Email->to = $emails;
		$post_type = ($post_data['Forum']['post_type'] == 'comment') ? ' -RE:':' :';
		//get the post body
		$post_body = $post_data['Forum']['post_body'];
		
		//get odu server url
		$odu_url = Configure::read('odu_url');
		$subject = ucfirst($post_data['Forum']['user_coursename']).'-'.ucfirst($post_data['Forum']['user_sectionname']).$post_type.
		           ucfirst($post_data['Forum']['post_subject']).' posted by '. ucfirst($post_author);

	    $maildata = '<b>'.ucfirst($post_data['Forum']['user_coursename']).'-'.ucfirst($post_data['Forum']['user_sectionname']).'</b>'.$post_type.
		            ucfirst($post_data['Forum']['post_subject']).' posted by <b>'. ucfirst($post_author).'</b>';
		$maildata .= "<br />".$post_body." <br /><br />You can access the discussion for this post with the following link. ";
		$maildata .= $odu_url."/forums/forumlist/".$contentpage_id;
		
		//save for mail queue
		$this->saveOduEmailQueue( $emails, $subject, $maildata);
		endif;
	}
	
	/**
	 * finding the registered users in the same course
	 * Show the registered user for filer in drop down
	 * @params contentpageid
	 * @return array
	 */
	public function findRegisteredUsers($contentPageId=null)
	{
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $contentPageId; //@TODO we have to change it by the session value.
		//get allsection setting sections for same course
		$sections_list = $this->__allSections($contentPageId);
		$options['conditions'][] = array('PleUser.course'=>$course_info->course_name, 'PleUser.section'=>$sections_list);
		return $this->PleUser->find('all', $options);
	}
	
	/**
	 * Making the subscription for a forum
	 * @params contentpage_id, course,
	 * @return none
	 */
	public function subscribeForum()
	{
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
	//	$contentpage_id = $explored_course[0]; //@TODO we have to change it by the session value.
		$value = $this->request->data['subscribe_value'];
		$contentPageId = $this->request->data['forums']['contId'];
	
		if($value)
			$data['PleForumSubscription']['setting_value'] = 0;
		else
			$data['PleForumSubscription']['setting_value'] = 1;
		$result = $this->PleForumSubscription->find('first', array('conditions'=>array('PleForumSubscription.user_id'=>$user, 'PleForumSubscription.user_coursename'=>$course_info->course_name, 'PleForumSubscription.contentpage_id'=>$contentPageId)));
		if($result)
			$data['PleForumSubscription']['id'] = $result['PleForumSubscription']['id'];
		else {
			$data['PleForumSubscription']['user_id'] = $user;
			$data['PleForumSubscription']['user_coursename'] = $course_info->course_name;
			$data['PleForumSubscription']['user_sectionname'] = $course_info->section_name;
			$data['PleForumSubscription']['contentpage_id'] = $contentPageId;
		}
		$this->PleForumSubscription->save($data);
		if ($value) {
			$this->__sendSubscriptionNotification($value,$contentPageId);
			$this->Session->setFlash('You have unsubscribed to this forum');
		} else {
			$this->__sendSubscriptionNotification($value,$contentPageId);
			$this->Session->setFlash('You have subscribed to this forum');
		}
		$this->redirect(array('controller'=>'forums', 'action'=>'forumlist',$contentPageId));
	}
	
	/**
	 * Finding the setting value for a user of the subscription
	 * @params none
	 * @return int
	 */
	public function subscribeForumValue($contentPageId = null)
	{
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $contentPageId; //@TODO we have to change it by the session value.
		$result = $this->PleForumSubscription->find('first', array('conditions'=>array('PleForumSubscription.user_id'=>$user, 'PleForumSubscription.user_coursename'=>$course_info->course_name, 'PleForumSubscription.contentpage_id'=>$contentpage_id)));
		if($result)
			return $result['PleForumSubscription']['setting_value'];
		return 0;
	}
	
	/**
	 * sending the subscription/unsubscription notification to the user
	 * @params value(subscribed/unsubscribed)
	 * @return boolean
	 */
	private function __sendSubscriptionNotification($value,$contentPageId)
	{
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $contentPageId; //@TODO we have to change it by the session value.

		$options['conditions'][] = array('EmailUser.midas_id'=>$user);
		//$options['conditions'][] = array('EmailUser.course'=>$course_info->course_name, 'EmailUser.midas_id'=>$user);
		$users_data  = $this->EmailUser->find('first', $options);
		$email = $users_data['EmailUser']['email'];
		
		if($value)
			$subscribed = 'unsubscribed';
		else
			$subscribed = 'subscribed';
		$this->Email->layout = 'subscriptionmaillayout'; //view/Layouts/Emails/html/subscriptionmaillayout.php
		//Note: As we have defined $this->Email->sendAs as 'html', so this file should be only in html folder, if pass 'both' then should be in text and html folder also.
		$maildata = 'Hello '.ucfirst($users_data['EmailUser']['midas_id']).'<br><br>';
		$maildata .= 'You have '.$subscribed .' forum of content page id "'.ucfirst($contentPageId). '" of course "'.ucfirst($course_info->course_name).'".'; //mail content prepare here.
		$this->set('content', $maildata);
		$this->Email->to = $email;
		$this->Email->subject = 'Subscription Info';
		$this->Email->from = Configure::read('mail-from');
		$this->Email->template = 'subscriptionmail'; //view/Emails/html/subscriptionmail.php
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
	 * Markig all the replies as read/unread
	 * @ajax call
	 * @params question_id
	 * @return boolean
	*/
	public function markReadUnreadReply()
	{
		if ($this->request->is('post')) {
			//get current login user object.
			$user = $this->Session->read('UserData.userName');
			$userCourse = $this->Session->read('UserData.usersCourses');
			$user_course_section = $userCourse[0];
		    //$user_exploded_course = explode('-', $user_course_section);
			//get user course-section info
			$course_info = $this->getCourseNameOfUser($user_course_section);
			
			$question_id = $this->request['data']['question_id'];
			$question_title = $this->request['data']['title'];
			//finding the all replies for the question.
			$result = $this->Forum->find('all',array('conditions'=>array('Forum.question_id'=>$question_id),'fields'=>array('id')));
			$allreplies = array();
			foreach ($result as $replylist) {
				$allreplies[] = $replylist['Forum']['id'];
			}
			//finding all the read/unread replies list for the current question.
			$readunreadreplies = $this->AccessQuestion->find('all',array('conditions'=>array('AccessQuestion.parent_id'=>$question_id, 'AccessQuestion.user_id'=>$user)));
			$readarray = array();
			$unreadarray = array();
			foreach ($readunreadreplies as $alllist) {
				if ($alllist['AccessQuestion']['is_read'] == 1){
					$readarray[] = $alllist['AccessQuestion']['question_id'];
				} else {
					$unreadarray[] = $alllist['AccessQuestion']['question_id'];
				}
			}
			//marking the unread replies as read.
			$this->AccessQuestion->updateAll(array('AccessQuestion.is_read' => 1, 'AccessQuestion.post_type' => "'comment'"),
					array('AccessQuestion.question_id' => $unreadarray));
			$newreplieslist = array_diff($allreplies, $readarray);
			//marking the rest of the replies as read.
			foreach ($newreplieslist as $newreplies) {
				$newdata = array();
				$newdata['AccessQuestion']['user_id'] = $user;
				$newdata['AccessQuestion']['parent_id'] = $question_id;
				$newdata['AccessQuestion']['question_id'] = $newreplies;
				$newdata['AccessQuestion']['course_name'] = $course_info->course_name;
				$newdata['AccessQuestion']['section_name'] = $course_info->section_name;
				$newdata['AccessQuestion']['is_read'] = 1;
				$newdata['AccessQuestion']['post_type'] = 'comment';
				$this->AccessQuestion->create();
				if (!$this->AccessQuestion->save($newdata)) {
					$this->AccessQuestion->save($newdata); //again save function call, we can remove this line
				}
			}
			echo "true";
			exit;
		}
	}
		
	/**
	 * Checking we have to show the mark all read option or not on UI
	 * @params $question_id
	 * @return int
	 */
	public function showReadUnreadOption($question_id, $contentPageId)
	{
		
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		//get allsection setting sections for same course
		//$sections_list = $this->__allSections($contentPageId);
		$sections_list = $this->__allReplySections($contentPageId);
		//finding the all replies for the question.
		$result = $this->Forum->find('all',array('conditions'=>array('Forum.question_id'=>$question_id, 'Forum.user_sectionname'=>$sections_list, 'Forum.is_draft!=1'),'fields'=>array('id')));
		$allreplies = array();
		foreach ($result as $replylist) {
			$allreplies[] = $replylist['Forum']['id'];
		}
		//finding all the read/unread replies list for the current question.
		$readunreadreplies = $this->AccessQuestion->find('all',array('conditions'=>array('AccessQuestion.parent_id'=>$question_id, 'AccessQuestion.section_name'=>$sections_list, 'AccessQuestion.user_id'=>$user)));
		$readarray = array();
		$unreadarray = array();
		foreach ($readunreadreplies as $alllist) {
			if ($alllist['AccessQuestion']['is_read'] == 1) {
				$readarray[] = $alllist['AccessQuestion']['question_id'];
			} else {
				$unreadarray[] = $alllist['AccessQuestion']['question_id'];
			}
		}
		$newreplieslist = array_diff($allreplies, $readarray);
	
		$lastunaccessarray = array_merge($newreplieslist, $unreadarray);
		$unquiearray = array_unique($lastunaccessarray);
		return count($unquiearray);
	}
	
	/**
	 * Checking the Reply access read/unread
	 * $params $reply_id(commnet_id)
	 * @return boolean
	 */
	private function __checkReadAccess($parent_id, $question_id)
	{ 
		//get user session data
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$readunreadreplies = $this->AccessQuestion->find('first', array('conditions'=>array('AccessQuestion.question_id'=>$question_id, 'AccessQuestion.parent_id'=>$parent_id, 'AccessQuestion.user_id'=>$user)));
		if (count(@$readunreadreplies)) {
			if($readunreadreplies['AccessQuestion']['is_read'])
				return 1;
			else
				return 0;
		}
		return 0;	
	}
		
	/**
	 * marking read to a particular reply
	 * @params question_id(reply_id), parent_id(main question id)
	 * @return json array
	*/
	public function markReadComment()
	{
		//get user session data
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$question_id = $this->request['data']['question_id'];
		$comment_id = $this->request['data']['comment_id'];
		$content_page_id = $this->request['data']['content_id'];
		$dataarray = array();
		$dataarray['AccessQuestion']['question_id'] = $comment_id;
		$dataarray['AccessQuestion']['parent_id'] = $question_id;
		$dataarray['AccessQuestion']['is_read'] = 1;
		$dataarray['AccessQuestion']['user_id'] = $user;
		$dataarray['AccessQuestion']['post_type'] = 'comment';
		$dataarray['AccessQuestion']['course_name'] = $course_info->course_name;
		$dataarray['AccessQuestion']['section_name'] = $course_info->section_name;
		$readunreadreplies = $this->AccessQuestion->find('first',array('conditions'=>array('AccessQuestion.question_id'=>$comment_id, 'AccessQuestion.parent_id'=>$question_id, 'AccessQuestion.user_id'=>$user)));
		if (count($readunreadreplies)) {
			$this->AccessQuestion->id  = $readunreadreplies['AccessQuestion']['id'];
		}
		$result_array = array();
		//saving the access for a user of a reply
		if ($this->AccessQuestion->save($dataarray)) {
			//below showReadUnreadOption function is calling from outside also thats why we have define as public.
			$unread_count  = $this->showReadUnreadOption($question_id, $content_page_id); //function is calling in both block because we are marking a reply as read in if clause
			$result_array['unread_count'] = $unread_count;
			$result_array['message'] = "true";
			echo json_encode($result_array);
		} else {	
			$unread_count  = $this->showReadUnreadOption($question_id, $content_page_id);
			$result_array['unread_count'] = $unread_count;
			$result_array['message'] = "false";
			echo json_encode($result_array);
		}
		exit;
	}
	
	/**
	 * Marking a question default as read for the current user
	 * @params question_id, reply_id
	 * @return boolean
	 */
	private function __markDefaultRead($question_id, $reply_id)
	{
		//get user session data
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$dataarray = array();
		$dataarray['AccessQuestion']['question_id'] = $reply_id;
		$dataarray['AccessQuestion']['is_read'] = 1;
		$dataarray['AccessQuestion']['parent_id'] = $question_id;
		$dataarray['AccessQuestion']['post_type'] = 'comment';
		$dataarray['AccessQuestion']['user_id'] = $user;
		$dataarray['AccessQuestion']['course_name'] = $course_info->course_name;
		$dataarray['AccessQuestion']['section_name'] = $course_info->section_name;
		if (!$this->AccessQuestion->save($dataarray)) {
			$this->AccessQuestion->save($dataarray); //if any condition occur and data is not saved, we can make save it again
		}
		return true;
	}
	
	/**
	 * Finding the latest reply for a post
	 * @params postid
	 * return type array
	 */
	public function getLatestReply($post_id, $contentPageId)
	{   
		$user = $this->Session->read('UserData.userName'); 
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $contentPageId; //@TODO we have to change it by the session value.
		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($contentPageId);	

		//$postoptions['recursive'] = 0;
		$postoptions['conditions'][] = array('NOT'=>array('Forum.post_by'=>$user),'Forum.user_coursename'=> $course_info->course_name, 'Forum.user_sectionname'=> $sections_list, 'Forum.contentpage_id'=>$contentpage_id, 'Forum.is_draft'=>1);
		$postoptions['fields'] = array('Forum.id');
		
		//handling for insection-allsection  for forum..
		$limit = 1; //define in bootstrap.php in config(default is 5, can be changed.)
		//finding the posts id those are draft and draft by the not logged user..
		$posts_ids = $this->Forum->find('all', $postoptions);
		$question_ids = array();
		foreach ($posts_ids as $postids_data)
		{
			$question_ids[] = $postids_data['Forum']['id'];
		}
		//check the post type
		$options['conditions'][] = array('Forum.user_coursename'=> $course_info->course_name, 'Forum.user_sectionname'=> $sections_list, 'Forum.contentpage_id'=>$contentpage_id);
		$options['conditions'][] = array('Forum.post_type'=>'comment', 'Forum.question_id'=>$post_id);
		$options['conditions'][] = array('NOT'=> array('Forum.id'=>$question_ids)); // handling for those are draft and not of the current users..
		$options['fields'] = array('Forum.id', 'Forum.post_by', 'Forum.post_date', 'Forum.post_subject', 'Forum.post_body', 'pleuser.name');
		$options['joins'][] = array(
				'table' => 'ple_register_users',
				'alias' => 'pleuser',
				'type' => 'INNER',
				'conditions'=> array(
						'Forum.post_by = pleuser.userName', 'pleuser.course'=>$course_info->course_name
				)
		);
		$options['recursive'] = 0;
		$options['order'] = array('Forum.id'=>'desc');
		$options['limit'] = $limit;
		$return_data = $this->Forum->find('all', $options);
		return $return_data;
	}
	
	/**
	 * Checking the forum availabilty and in between the current date
	 * @params contentpage id
	 * @retutn boolean
	 */
	private function __checkForumAvailabilty($contentPageId)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$userCourse = $this->Session->read('UserData.usersCourses');
		$user_course_section = $userCourse[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get Course and section name
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$available_array_result = array();
		//finding the current setting of the forum (enable/disable)
		$setting_result = $this->PleForumSetting->find('first', array('conditions'=>array('PleForumSetting.course'=>$course_info->course_name, 'PleForumSetting.section'=>$course_info->section_name, 'PleForumSetting.contentpage_id'=>$contentPageId), 'fields'=>array('PleForumSetting.setting_value')));
		if (@$setting_result['PleForumSetting']['setting_value'] != 3) {
			//get current datetime
			$ctime = date('Y-m-d H:i:s');
			//this check is working on a different db configuration.
			//get sections on the basis of content page date setting
			$results = $this->PleForumAvailability->find('first', array('conditions'=>
					array(
							'PleForumAvailability.course_id'=>$user_course_section,
							'PleForumAvailability.uuid'=>$contentPageId,
							'PleForumAvailability.type' => 'contentpage',
							//'PleForumAvailability.post_begin_date <='=>$ctime,
							'PleForumAvailability.post_end_date >='=>$ctime,
							array('OR'=>array('PleForumAvailability.post_begin_date <='=>$ctime, 'PleForumAvailability.post_begin_date ='=>NULL))
					)));
			if(count(@$results['PleForumAvailability']))
				$available_array_result[] = 1; //user can ask a new question on the forum
            
			//check read only setting.
			$read_only_results = $this->PleForumAvailability->find('first', array('conditions'=>
					array(
							'PleForumAvailability.course_id'=>$user_course_section,
							'PleForumAvailability.uuid'=>$contentPageId,
							'PleForumAvailability.type' => 'contentpage',
						//	'PleForumAvailability.read_only_begin_date <='=>$ctime,
							'PleForumAvailability.read_only_end_date >='=>$ctime,
							array('OR'=>array('PleForumAvailability.read_only_begin_date <='=>$ctime, 'PleForumAvailability.read_only_begin_date ='=>NULL))
					)));
			if(count(@$read_only_results['PleForumAvailability']))
				$available_array_result[] = 4; //user can ask a new question on the forum	

			//check reply only setting.
			$reply_only_results = $this->PleForumAvailability->find('first', array('conditions'=>
					array(
							'PleForumAvailability.course_id'=>$user_course_section,
							'PleForumAvailability.uuid'=>$contentPageId,
							'PleForumAvailability.type' => 'contentpage',
						//	'PleForumAvailability.reply_begin_date <='=>$ctime,
							'PleForumAvailability.reply_end_date >='=>$ctime,
							array('OR'=>array('PleForumAvailability.reply_begin_date <='=>$ctime, 'PleForumAvailability.reply_begin_date ='=>NULL))
					)));
			if(count(@$reply_only_results['PleForumAvailability']))
				$available_array_result[] = 2; //user can ask a new question on the forum
			
		} else {
			$available_array_result[] = 3;
		}
		return $available_array_result;
	}
	
	/**
	 * Sending the twitter notifications to users those Subscription setting is on
	 * @params post id, contentPagId
	 * @return boolean
	 */
	private function __sendNewPostsTwitterNotification($post_id, $content_page_id)
	{
		$this->Forum->virtualFields = array(); //define for making these blank.
		
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array, getting from session..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $content_page_id; //@TODO we have to change it by the session value.
		
		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($content_page_id);
		
		//handling for insection-allsection  for forum..
		$forumoptions[] = array(
				'PleUser.userName = PleForumSubscription.user_id', 'PleForumSubscription.user_coursename'=>$course_info->course_name,
				'PleForumSubscription.contentpage_id'=>$content_page_id, 'PleForumSubscription.user_sectionname'=>$sections_list, 'PleForumSubscription.subscription_type'=>0
		);
		
		// handling for those users except current logged-in are enabled setting for receving the notification.
		$options['conditions'][] = array('PleForumSubscription.setting_value'=>1, 'PleUser.userName !='=>$user, 'PleUser.course '=>$course_info->course_name);
		$options['joins'][] = array(
				'table' => 'ple_forum_subscription_setting',
				'alias' => 'PleForumSubscription',
				'type' => 'INNER',
				'conditions'=> $forumoptions
		);
		$options['fields'] = array( 'PleUser.*' );
		$users_list  = $this->PleUser->find('all', $options);
		$midas_id = array();
		foreach ($users_list as $list) {
			//check if user has twitter notification enabled
			$notification_type = $this->__getNotificationSetting($content_page_id, $list['PleUser']['userName'], $list['PleUser']['section']);
			if ( $notification_type['twitterSetting'] == 1 ) {
				$midas_id[] = $list['PleUser']['userName'];
			}
		}
		
	   //initialize users array
	   $twitter_id = array();
	   
	   //get twitter name for the midas Id
	   $twitter_names = $this->TwitterUser->find('all',array('conditions'=>array('TwitterUser.midasId'=>$midas_id)));
	   foreach ( $twitter_names as $twitter_name ) {
	   	$twitter_id[] = $twitter_name['TwitterUser']['twitterId'];
	   }
	   
	   //get message content
	   $this->Forum->id = $post_id;
	   $post_data = $this->Forum->read();
	   //get post author name
	   $post_author = $this->getUserName($post_data['Forum']['post_by']);
	   //mail content prepare here.
	   //$mail_data ='A New Post with Subject "'.ucfirst($post_data['Forum']['post_subject']).'" is post by user '.ucfirst($post_data['Forum']['post_by']);
	   //$mail_data .= '. Course: '.ucfirst($post_data['Forum']['user_coursename']).'. Content Page: '.ucfirst($post_data['Forum']['contentpage_id']);
	   $mail_data = ucfirst($post_data['Forum']['user_coursename']).'-'.ucfirst($post_data['Forum']['user_sectionname']).
	   ucfirst($post_data['Forum']['post_subject']).' posted by '. ucfirst($post_author);
	   
	   //calling function of Twitter component in component folder.
	   $twit_result = $this->TwitterNotification->sendNotification($twitter_id, $mail_data);
	   return true;
	}
	
	/**
	 * Sending the facebook notifications to users those Subscription setting is on
	 * @params post id, contentPagId
	 * @return boolean
	 */
	private function __sendNewPostsFacebookNotification($post_id, $content_page_id)
	{
		$this->Forum->virtualFields = array(); //define for making these blank.
		
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $content_page_id; //@TODO we have to change it by the session value.
		
		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($content_page_id);
		//handling for insection-allsection  for forum..
		$forumoptions[] = array(
				'PleUser.userName = PleForumSubscription.user_id', 'PleForumSubscription.user_coursename'=>$course_info->course_name,
				'PleForumSubscription.contentpage_id'=>$content_page_id, 'PleForumSubscription.user_sectionname'=>$sections_list, 'PleForumSubscription.subscription_type'=>0
		);
		
		// handling for those users except current logged-in are enabled setting for receving the notification.
		$options['conditions'][] = array('PleForumSubscription.setting_value'=>1, 'PleUser.userName !='=>$user, 'PleUser.course '=>$course_info->course_name); 
		$options['joins'][] = array(
				'table' => 'ple_forum_subscription_setting',
				'alias' => 'PleForumSubscription',
				'type' => 'INNER',
				'conditions'=> $forumoptions
		);
		$options['fields'] = array( 'PleUser.*' );
		$users_list  = $this->PleUser->find('all', $options);
		
		//initialize user array
		$midas_id = array();
		//pr($users_list); exit;
		foreach ($users_list as $list) {
			//check if user has facebook notification enabled
			$notification_type = $this->__getNotificationSetting($content_page_id, $list['PleUser']['userName'], $list['PleUser']['section']);
			if ( $notification_type['facebookSetting'] == 1 ) {
				$midas_id[] = $list['PleUser']['userName'];
			}
		}

		//initialize users array
		$facebook_id = array();
		
		//get twitter name for the midas Id
		$facebok_names = $this->FacebookUser->find('all',array('conditions'=>array('FacebookUser.midas_id'=>$midas_id)));
		foreach ( $facebok_names as $facebook_name ) {
			$facebook_id[] = $facebook_name['FacebookUser']['facebook_id'];
		}
	
		//get message content
		$this->Forum->id = $post_id;
		$post_data = $this->Forum->read();
		//get post author name
	    $post_author = $this->getUserName($post_data['Forum']['post_by']);
		//mail content prepare here.
		//$mail_data ='A New Post with Subject "'.ucfirst($post_data['Forum']['post_subject']).'" is post by user '.ucfirst($post_data['Forum']['post_by']);
		//$mail_data .= '. Course: '.ucfirst($post_data['Forum']['user_coursename']).'. Content Page: '.ucfirst($post_data['Forum']['contentpage_id']);
		$mail_data = ucfirst($post_data['Forum']['user_coursename']).'-'.ucfirst($post_data['Forum']['user_sectionname'])."  ".
	    ucfirst($post_data['Forum']['post_subject']).' posted by '. ucfirst($post_author);
	   
		//calling function of Facebook component.
		$facebook_result = $this->FacebookNotification->sendNotification($facebook_id, $mail_data);
		return true;
	}
	
	/**
	 * Sending the Reply Twitter notifications to users those Subscription setting is on
	 * @params post id
	 * @return boolean
	 */
	private function __sendReplyPostsTwitterNotification($post_id, $reply_id, $content_page_id)
	{
		$this->Forum->virtualFields = array(); //define for making these blank.
		
		//get user object from session
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $content_page_id; //@TODO we have to change it by the session value.
	
		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($content_page_id);
		$forumoptions[] = array(
				'PleUser.userName = PleForumSubscription.user_id',
				'PleForumSubscription.user_coursename'=>$course_info->course_name,
				'PleForumSubscription.contentpage_id'=>$content_page_id,
				'PleForumSubscription.user_sectionname'=>$sections_list,
				'PleForumSubscription.subscription_type'=>0
		);
		
		// handling for those users except current logged-in are enabled setting for receving the notification.
		$options['conditions'][] = array('PleForumSubscription.setting_value'=>1, 'PleUser.userName !='=>$user, 'PleUser.course '=>$course_info->course_name);
		$options['joins'][] = array(
				'table' => 'ple_forum_subscription_setting',
				'alias' => 'PleForumSubscription',
				'type' => 'INNER',
				'conditions'=> $forumoptions
		);
		$options['fields'] = array( 'PleUser.*' );
		$users_list  = $this->PleUser->find('all', $options);
	
		//initialize users array
		$midas_id = array();
		foreach ($users_list as $list) {
			//check if user has email notification enabled
			$notification_type = $this->__getNotificationSetting($content_page_id, $list['PleUser']['userName'], $list['PleUser']['section']);
			if ( $notification_type['twitterSetting'] == 1 ){
				$midas_id[] = $list['PleUser']['userName'];
			}
		}
		
		//users array
		$twitter_id = array();
		
		//get twitter name for the midas Id
		$twitter_names = $this->TwitterUser->find('all',array('conditions'=>array('TwitterUser.midasId'=>$midas_id)));
		foreach ( $twitter_names as $twitter_name ) {
			$twitter_id[] = $twitter_name['TwitterUser']['twitterId'];
		}
		
		//get message content
		$this->Forum->id = $post_id;
		$post_data = $this->Forum->read();
		//get post author name
	    $post_author = $this->getUserName($post_data['Forum']['post_by']);
		//mail content prepare here.
		//$mail_data ='A New Post with Subject "'.ucfirst($post_data['Forum']['post_subject']).'" replied by user '.ucfirst($post_data['Forum']['post_by']);
		//$mail_data .= '. Course: '.ucfirst($post_data['Forum']['user_coursename']).'. Content Page: '.ucfirst($post_data['Forum']['contentpage_id']);
		$post_type = " -RE: ";
		$mail_data = ucfirst($post_data['Forum']['user_coursename']).'-'.ucfirst($post_data['Forum']['user_sectionname']).$post_type.
		ucfirst($post_data['Forum']['post_subject']).' posted by '. ucfirst($post_author);
		
		//calling function of Twitter component.
		$twit_result = $this->TwitterNotification->sendNotification($twitter_id, $mail_data);
		return true;
	}
	
	/**
	 * Sending the Reply Facebook notifications to users those Subscription setting is on
	 * @params post id
	 * @return boolean
	 */
	private function __sendReplyPostsFacebookNotification($post_id, $reply_id, $content_page_id)
	{
	
		$this->Forum->virtualFields = array(); //define for making these blank.
		
		//get user object from session
		$user = $this->Session->read('UserData.userName');
		$course = $this->Session->read('UserData.usersCourses'); // is an array..
		//$explored_course = explode('-', $course[0]);//separate to course and section by '-' character.
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($course[0]);
		
		$contentpage_id = $content_page_id; //@TODO we have to change it by the session value.
	
		//get allsection setting sections for same course
		$sections_list = $this->__allPostSections($content_page_id);
		$forumoptions[] = array(
				'PleUser.userName = PleForumSubscription.user_id',
				'PleForumSubscription.user_coursename'=>$course_info->course_name,
				'PleForumSubscription.contentpage_id'=>$content_page_id,
				'PleForumSubscription.user_sectionname'=>$sections_list,
				'PleForumSubscription.subscription_type'=>0
		);
		
		// handling for those users except current logged-in are enabled setting for receving the notification.
		$options['conditions'][] = array('PleForumSubscription.setting_value'=>1, 'PleUser.userName !='=>$user, 'PleUser.course '=>$course_info->course_name);
		$options['joins'][] = array(
				'table' => 'ple_forum_subscription_setting',
				'alias' => 'PleForumSubscription',
				'type' => 'INNER',
				'conditions'=> $forumoptions
		);
		$options['fields'] = array( 'PleUser.*' );
		$users_list  = $this->PleUser->find('all', $options);
	
		//initialize users array
		$midas_id = array();
		foreach ($users_list as $list) {
			//check if user has email notification enabled
			$notification_type = $this->__getNotificationSetting($content_page_id, $list['PleUser']['userName'], $list['PleUser']['section']);
			if ( $notification_type['facebookSetting'] == 1 ) {
				$midas_id[] = $list['PleUser']['userName'];
			}
		}
	    //users array for notification
		$facebook_ids = array();
		
		//get twitter name for the midas Id
		$facebook_names = $this->FacebookUser->find('all',array('conditions'=>array('FacebookUser.midas_id'=>$midas_id)));
		foreach ( $facebook_names as $facebook_name ) {
			$facebook_ids[] = $facebook_name['FacebookUser']['facebook_id'];
		}
	
		//get message content
		$this->Forum->id = $post_id;
		$post_data = $this->Forum->read();
		//get post author name
	    $post_author = $this->getUserName($post_data['Forum']['post_by']);
		//mail content prepare here.
		//$mail_data ='A New Post with Subject "'.ucfirst($post_data['Forum']['post_subject']).'" replied by user '.ucfirst($post_data['Forum']['post_by']);
		//$mail_data .= '. Course: '.ucfirst($post_data['Forum']['user_coursename']).'. Content Page: '.ucfirst($post_data['Forum']['contentpage_id']);
		$post_type = " -RE: ";
		$mail_data = ucfirst($post_data['Forum']['user_coursename']).'-'.ucfirst($post_data['Forum']['user_sectionname']).$post_type.
		ucfirst($post_data['Forum']['post_subject']).' posted by '. ucfirst($post_author);
		
		//calling function of Facebook component.
		$facebook_result = $this->FacebookNotification->sendNotification($facebook_ids, $mail_data);
		return true;
	}
	
	/**
	 * publish and save the edited comment as published ajax call
	 * @param comment array
	 * @return string
	 */
	public function publishReplyComment()
	{
		$data = $this->request['data'];
		$comment_id = $data['comment_id'];
		$qid = $data['qid'];
		$contentPageId = $data['contentPageId'];
		$data['id'] = $comment_id;
		$data['is_draft'] = 0;
		$data['post_body'] = $data['content'];
	
		//query to publish the comment
		$result = $this->Forum->save($data);
		if ($result) {
			//send twitter notification
			$this->__sendReplyPostsTwitterNotification($qid,$comment_id,$contentPageId);
			//send facebook notification
			$this->__sendReplyPostsFacebookNotification($qid, $comment_id, $contentPageId);
			//send odu notification
			$this->__sendReplyPostsNotification($qid,$comment_id,$contentPageId);
		}
		//get current time
		$data['Forum']['post_date'] = time();
		$msg = "posted on". date('m-d-Y: h:i A',$data['Forum']['post_date']);
		echo $msg;
		exit;
	}
	
	/**
	 * Save the mail data in odu mail queue table
	 * @param array $email
	 * @param string $subject
	 * @param string $mail_data
	 * return boolean
	 */
	private function saveOduEmailQueue( $emails, $subject, $mail_data)
	{
	
		foreach( $emails as $email ) {
			$this->OduMailQueue->create();
			$data['OduMailQueue']['email'] = $email;
			$data['OduMailQueue']['subject'] = $subject;
			$data['OduMailQueue']['mail_data'] = $mail_data;
			$this->OduMailQueue->save($data);
		}
		return true;
		
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
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$name = $this->PleUser->find('first', array('conditions'=>array('PleUser.course'=>$course_info->course_name, 'PleUser.userName'=>$user), 'fields'=>array('PleUser.name')));
		return @$name['PleUser']['name'];
	}
}

?>