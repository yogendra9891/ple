<?php
/**
 * User management controller.
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
App::uses('AppController', 'Controller');
App::import('Helper', 'Form');
/**
 * ForumUser management controller abhi + yogi
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class ForumChildrenController extends AppController
{

	//The $uses attribute states which model(s) the will be available to the controller:
	public $uses = array('Comment', 'Forum', 'RatePost', 'PleUser', 'AccessQuestion', 'PleSetting',
			'PleForumSetting', 'PleForumSubscription', 'RateComment', 'AccessReply',
			'ContentPageSetting', 'TwitterUser', 'ReadonlySetting', 'PleForumAvailability'
	);

	/**
	 * check if there is reply for a comment
	 * @param int
	 * return int(0 or more)
	 */
	public function getReplyParent($forum_id)
	{
		$is_reply = $this->Forum->find('count', array('conditions'=>
				array('Forum.parent_reply_id '=>$forum_id,
						'Forum.is_draft'=>0
				)
		)
		);
		return $is_reply;
	}

	/**
	 * Get read only setting for content page
	 * @param string, int
	 * @return int
	 */
	public function getReadOnlySetting($contentpage_id, $forum_id=null)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$user_course = $this->Session->read('UserData.usersCourses');
		$user_course_section = $user_course[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$course_name = $course_info->course_name;
		$section_name = $course_info->section_name;
        
		//get current datetime
		$ctime  = date('Y-m-d H:i:s');
		$result = $this->PleForumAvailability->find('count', array('conditions' =>array(
				  		 'PleForumAvailability.course_id'=>$user_course_section,
						 'PleForumAvailability.uuid'=>$contentpage_id,
						 'PleForumAvailability.type'=>'contentpage',
						// 'PleForumAvailability.read_only_begin_date <='=>$ctime,
				          array('OR'=>array('PleForumAvailability.read_only_begin_date <='=>$ctime, 'PleForumAvailability.read_only_begin_date ='=>NULL)),
						 'PleForumAvailability.read_only_end_date >='=>$ctime
				)));

		//check if result value is 0
		$return_val = ($result==0) ? 0 : 1;
		
		//return the count value
		return $return_val;
	}
	
	/**
	 * 
	 */
	public function getReplyDateSetting($contentpage_id, $forum_id=null)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$user_course = $this->Session->read('UserData.usersCourses');
		$user_course_section = $user_course[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
		
		$course_name = $course_info->course_name;
		$section_name = $course_info->section_name;
		
		//get current datetime
		$ctime  = date('Y-m-d H:i:s');
		$result = $this->PleForumAvailability->find('count', array('conditions' =>array(
				'PleForumAvailability.course_id'=>$user_course_section,
				'PleForumAvailability.uuid'=>$contentpage_id,
				'PleForumAvailability.type'=>'contentpage',
				//'PleForumAvailability.reply_begin_date <='=>$ctime,
				array('OR'=>array('PleForumAvailability.reply_begin_date <='=>$ctime, 'PleForumAvailability.reply_begin_date ='=>NULL)),
				'PleForumAvailability.reply_end_date >='=>$ctime
		)));
		
		
		//check if result value is 0
		$return_val = ($result==0) ? 0 : 1;
		
		//return the count value
		return $return_val;
	}
	
	/**
	 * Get read only setting for content page
	 * @param string, int
	 * @return int
	 */
	public function getPostSetting($contentpage_id, $forum_id=null)
	{
		//get current login user object.
		$user = $this->Session->read('UserData.userName');
		$user_course = $this->Session->read('UserData.usersCourses');
		$user_course_section = $user_course[0];
		//$user_exploded_course = explode('-', $user_course_section);
		//get user course-section info
		$course_info = $this->getCourseNameOfUser($user_course_section);
	
		$course_name = $course_info->course_name;
		$section_name = $course_info->section_name;
	
		//get current datetime
		$ctime  = date('Y-m-d H:i:s');
		$result = $this->PleForumAvailability->find('count', array('conditions' =>array(
							'PleForumAvailability.course_id'=>$user_course_section,
							'PleForumAvailability.uuid'=>$contentpage_id,
							'PleForumAvailability.type' => 'contentpage',
							//'PleForumAvailability.post_begin_date <='=>$ctime,
							'PleForumAvailability.post_end_date >='=>$ctime,
							array('OR'=>array('PleForumAvailability.post_begin_date <='=>$ctime, 'PleForumAvailability.post_begin_date ='=>NULL))
		)));
	
		//check if result value is 0
		$return_val = ($result==0) ? 0 : 1;
	
		//return the count value
		return $return_val;
	}	
}