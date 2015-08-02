<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
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
 * @author        abhi+yogi
 */
App::uses('AppController', 'Controller');

/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       app.Controller
 * @link http://book.cakephp.org/2.0/en/controllers/pages-controller.html
 */
class PostsController extends AppController {

/**
 * This controller does not use a model
 *
 * @var array
 */
	public $uses = array('Forum', 'PleAssignmentReminder');
	public $helpers = array('Rss', 'Text');
	public $components = array ('RequestHandler');

	/**
	 * Returns an array of all public posts less than one month old, orderd by date
	 * @param int
	 * @param string
	 * @return unknown
	 */ 
	function index($count=null, $course=null) {
		if(!$count) $count=5;
		$this->Forum->recursive = 0;
		$options['conditions'][] = array('Forum.user_coursename'=>$course);
		$options['order'] = array('Forum.id desc');
		$options['limit'] = $count;
		$posts = $this->Forum->find('all', $options);
		$this->set('title_for_layout', 'PLE Posts Notification');
        if(isset($this->params['requested'])) {
          return $posts;
        }
        $this->set('posts',$posts );
	}
	
	/**
	 * Showing the facebook notification
	 * @param string $msg
	 * @return 
	 */
	public function showNotification($msg)
	{
		//we can create the layout/view for this.
		echo base64_decode($msg); exit;
	}
	
	/**
	 * Redirecting the user to the login screen
	 */
	public function logOut($id = null)
	{
		$logout_url = Configure::read('logout_url');
		$this->redirect($logout_url);
	}
	
	/**
	 * Finding the asignment reminder data(making the rss feed url.) using the default layout(rss)
	 * @param string $course
	 * @return array
	 */
	public function assignmentReminder($course=null, $user_id=null)
	{
		//finding the assignment criteria for day before, week before, custom date. 
		$assignment_crieteria = $this->getAssignmentConstraints();
		$options['conditions'][] = array('PleAssignmentReminder.course_id LIKE'=>$course.'%', 'PleAssignmentReminder.user_id' =>$user_id); //check for course name
		$options['conditions'][] = $assignment_crieteria;
		$options['order'] = array('PleAssignmentReminder.due_date desc');
		$assignment_detail = $this->PleAssignmentReminder->find('all', $options);
		$this->set('title_for_layout', 'PLE Assignment Reminder');
		$this->set('assignment',$assignment_detail );
	}
	
}
