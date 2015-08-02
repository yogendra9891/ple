<?php
/**
 * FacebookShell file
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
 * @since         CakePHP(tm) v 2.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Shell', 'Console');
App::uses('Component', 'Controller');

//include appcontroller class
App::uses('AppController', 'Controller');
/**
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 * sending the botification on facebook
 *
 * @package       app.Console.Command
 */
class FacebookShell extends Shell
{

	//uses the model.
	public $uses = array('FacebookMailQueue', 'FacebookMailFailure', 'PleAssignmentReminder', 'PleLastReminderSent', 'AssignmentFacebookFailure', 'PleUser', 'FacebookUser');

	/**
	 * Default method for shell
	 */
	public function main()
	{
		//get facebook mail users and data
		$results = $this->FacebookMailQueue->find('all');
		 
		foreach ( $results as $result ) {

			// call facebook function
			$resp = $this->_sendNotification($result['FacebookMailQueue']['facebook_id'], $result['FacebookMailQueue']['mail_data']);
			 
			//check if notification sent @TODO
			 
			if ( $resp == 1 ) { //success case
				//remove the notification from facebook mail queue table
				$this->_removeFacebookQueue($result['FacebookMailQueue']['id']);
				
				//create the CSV user data array
				$csv_data = array('facebook_id'=>$result['FacebookMailQueue']['facebook_id'], 'content'=> $result['FacebookMailQueue']['mail_data']);
				
				//write the csv
				$this->writeCsv($csv_data);
				//unset the csv data array
				unset($csv_data);
			} else if ($resp == 0) { //failure case
				$data = array();
				$data['FacebookMailFailure']['facebook_id']   = $result['FacebookMailQueue']['facebook_id'];
				$data['FacebookMailFailure']['mail_data']     = $result['FacebookMailQueue']['mail_data'];
				$this->FacebookMailFailure->create();
				$this->FacebookMailFailure->save($data); //saving data in failure case in facebook_mail_failure table for further trail				
			} else if ($resp == 2) { //facebook app not authentic case(can be used for future for notification on dashboard)
				
			}
		}
	}

	/**
	 * Authenticate the ple facebook user
	 * getting facebook object by configuration
	 */
	private function _facebookAuth()
	{
		//Load the app/Vendor/Facebook/facebook.php
		App::import('Vendor', 'Facebook', array('file' =>  'Facebook' . DS . 'facebook.php'));

		//getting the facebook appid, app secret from bootstrap
		$app_id = Configure::read('APPID');
		$app_secret = Configure::read('APPSECRET');

		//getting the facebook object
		$facebook_object = new Facebook(array( 'appId'  => $app_id, 'secret' => $app_secret));
		return $facebook_object;
	}

	/**
	 * send notification to the facebook account
	 * @param array, string
	 * @return boolean
	 */
	private function _sendNotification($facebook_id, $message_string)
	{
		//get connection object
		$facebook = $this->_facebookAuth();
		//getting the facebook appid, app secret from bootstrap
		$app_id = Configure::read('APPID');
		$app_secret = Configure::read('APPSECRET');

		//create the access token by combination of appid and app secret.
		$app_access_token = $app_id . '|' . $app_secret;

		//sending the message to a user..
		$authentic = $this->_getFacebookAuthenticInfo($facebook_id);
		if ($authentic) {
			$response = $facebook->api( '/'.$facebook_id.'/notifications', 'POST', array(
						'template' => substr($message_string, 0, 179),
						'href' => base64_encode($message_string),
						'access_token' => $app_access_token
				));
		     //check if message sent or not
		     if (isset($response['success']) == 1)
		       return 1; //success case
		       return 0; //failure case
		} else return 2; //Facebook app not authentic case
	}
	
	/**
	 * Getting the facebook app authentic info for a user
	 * @param int
	 * @return int
	 */
	private function _getFacebookAuthenticInfo($fb_uid)
	{
		//getting the facebook object
		$facebook = $this->_facebookAuth();
		$result = $facebook->api(array(
				'method' => 'fql.query',
				'query' => "SELECT is_app_user FROM user WHERE uid=".$fb_uid
		));
	
// 		$is_installed = $result[0]['is_app_user'];
// 		if ($is_installed)
// 			return 1; //user already authenticated PLE app
// 		return 0; //user didn't yet authenticate PLE app
		if (count($result)) {
			$is_installed = $result[0]['is_app_user'];
			if ($is_installed)
				return 1; //user already authenticated PLE app
			return 0; //user didn't yet authenticate PLE app
		} return 0;
	}
	
	/**
	 * remove the entry from db for posts
	 * @param int $id
	 * @return boolean
	 */
	private function _removeFacebookQueue( $id )
	{
		$this->FacebookMailQueue->delete($id);
		return true;
	}

	/**
	 * remove the entry from db for facebook failure message sent for posts
	 * @param int $id
	 * @return boolean
	 */
	private function _removeFacebookFailure( $id )
	{
		$this->FacebookMailFailure->delete($id);
		return true;
	}
	/**
	 * Dynamically generates a .csv file
	 * @param array $data
	 * @return boolean
	 */
	public function writeCsv($data)
	{
		//create a file
		$file_path = WEBROOT_DIR."/files/postnotification/";
		$filename = "facebook_post_notification_".date("Y.m.d").".csv";
	
		//check if file exist
		if (file_exists($file_path.$filename)) {
			$fp = fopen($file_path.$filename, 'a'); //get the file object
			fputcsv($fp, $data); //write the file
		} else {
			$fp = fopen($file_path.$filename, 'a');
			$head_data = array("facebook_id","content");
			fputcsv($fp, $head_data);
			fputcsv($fp, $data);
		}
		fclose($fp); //close the file
		return true;
	}
	
	/**
	 * Sending the failed facebook notification of posts
	 * @params none
	 * @return boolean
	 */
	public function sendFailFacebookPostsNotification()
	{
		//get facebook mail users and data
		$results = $this->FacebookMailFailure->find('all');
		foreach ( $results as $result ) {

			// call facebook function
			$resp = $this->_sendNotification($result['FacebookMailFailure']['facebook_id'], $result['FacebookMailFailure']['mail_data']);
		 
			if ( $resp == 1 ) { //success case
				//remove the notification from facebook mail queue table
				$this->_removeFacebookFailure($result['FacebookMailFailure']['id']);
				
				//create the CSV user data array
				$csv_data = array('facebook_id'=>$result['FacebookMailFailure']['facebook_id'], 'content'=> $result['FacebookMailFailure']['mail_data']);
				
				//write the csv
				$this->writeCsv($csv_data);
				//unset the csv data array
				unset($csv_data);
			} else if ($resp == 2) { //app not authentic case(can be used for future for notification on dashboard)
				
			}
		}
	 }	
	 
	/**
	 * Send the assignment notification from cron job
	 * @param void
	 * @return boolean
	 */
	public function sendAssignmentNotification()
	{
		$ctime = date('Y-m-d'); //get current day
		
		//get facebook id from the user setting for facebook reminder
		$this->PleAssignmentReminder->virtualFields = array('fid' => 'PleUserMapFacebook.facebook_id');
		
		//get last sent id
		$last_sent_id = $this->PleLastReminderSent->find('first',array('conditions' => array('PleLastReminderSent.date' => $ctime, 'PleLastReminderSent.type' => 'fb')));
		
		if( count($last_sent_id) > 0 ) {
			$options['conditions'][] = array('PleAssignmentReminder.id >' => $last_sent_id['PleLastReminderSent']['last_sent_rid']);
		}
		
		//get appController class object
		$obj = new AppController();
		$assignments = $obj->getAssignmentConstraints();
		
		//get today assignments
		//$assignment_options[] = array(
		//		'PleAssignmentReminder.user_id = PleUserMapFacebook.midas_id',
		//);
		$options['conditions'][] = $assignments;
		$options['fields'] = array('id', 'user_id', 'assignment_uuid', 'assignment_title', 'due_date', 'course_id');
		//$options['joins'][] = array(
		//		'table' => 'ple_user_map_facebook',
		//		'alias' => 'PleUserMapFacebook',
		//		'type' => 'INNER',
		//		'conditions'=> $assignment_options
		//);
		$options['order'] = array('PleAssignmentReminder.id ASC');
		
		//execute query
		$assignmnet_details = $this->PleAssignmentReminder->find('all', $options);
	  
		//send facebook reminder
		foreach( $assignmnet_details as $assignmnet_detail ) {
		    $user_id = $assignmnet_detail['PleAssignmentReminder']['user_id'];
			//$parent_fb = $assignmnet_detail['PleAssignmentReminder']['fid'];
			$body = $assignmnet_detail['PleAssignmentReminder']['assignment_title'];
			$course_id = $assignmnet_detail['PleAssignmentReminder']['course_id'];
			
			//get facebook users array if user is instructor
			$fb_users_array = $this->getChildren( $user_id, $course_id );
			
			//set display date for assignments
			$originalDate = $assignmnet_detail['PleAssignmentReminder']['due_date'];
			if($originalDate != ""){
			$newDate = date("F d, Y", strtotime($originalDate));
			$due_date = " due on $newDate";
			} else{
		 	$due_date = " is due on NA";
		    }
			
			//compose mail date
			$mail_data = "Assignment Reminder! $course_id. Your assignment, $body, $due_date.";
			$subject = $course_id." - ".$body;
			//send the reminder to multiple users
			foreach ($fb_users_array as $to_fb_data ) {
			$to_fb = $to_fb_data['fid'];
			$to_id = $to_fb_data['id'];
			
			$send_fb = $this->_sendNotification( $to_fb, $mail_data );
		
			//check for if facebook reminder sent
			if ( $send_fb == 1 ) {
		
				//remove the previous entry of current date
				$this->PleLastReminderSent->deleteAll(array('PleLastReminderSent.date'=>$ctime, 'PleLastReminderSent.type'=>'fb'));
				$this->PleLastReminderSent->create();
		
				//update the table for sent facebook reminder
				$data['PleLastReminderSent']['last_sent_rid'] = $assignmnet_detail['PleAssignmentReminder']['id'];
				$data['PleLastReminderSent']['type'] = 'fb';
				$data['PleLastReminderSent']['date'] = $ctime;
				$this->PleLastReminderSent->save($data);
		
				//create the CSV user data array
				$csv_data = array('id'=>$to_id, 'fid'=>$to_fb, 'mail_data'=> $mail_data);
		
				//write the csv
				$this->writeFbCsv($csv_data);
		
				//unset the csv data array
				unset($csv_data);
			} else if ( $send_fb == 2) {  //app not authentic case(can be used for future for notification on dashboard)

			} else {
				//handling for facebook reminder failure
				$fb_data = array();
				$fb_data['AssignmentFacebookFailure']['facebook_id'] = $to_fb;
				$fb_data['AssignmentFacebookFailure']['mail_data'] = $mail_data;
				$this->AssignmentFacebookFailure->create();
				$this->AssignmentFacebookFailure->save($fb_data);				
			}
			}
		}
	}

	/**
	 * Sending the failed facebook notification of assignments
	 * @params none
	 * @return boolean
	 */
	public function sendFailFacebookAssignmentNotification()
	{
		//get facebook mail users and data
		$results = $this->AssignmentFacebookFailure->find('all');
		foreach ( $results as $result ) {
	
			// call facebook function
			$resp = $this->_sendNotification($result['AssignmentFacebookFailure']['facebook_id'], $result['AssignmentFacebookFailure']['mail_data']);
	
			if ( $resp == 1 ) { //success case
				//remove the notification from facebook mail queue table
				$this->_removeFacebookAssignmentFailure($result['AssignmentFacebookFailure']['id']);
	
				//create the CSV user data array
				$csv_data = array('fid'=>$result['AssignmentFacebookFailure']['facebook_id'], 'mail_data'=> $result['AssignmentFacebookFailure']['mail_data']);
		
				//write the csv
				$this->writeFbCsv($csv_data);
		
				//unset the csv data array
				unset($csv_data);
			} else if ($resp == 2) { //app not authentic case(can be used for future for notification on dashboard)
	
			}
		}
	}
	
	/**
	 * remove the entry from db for facebook failure message sent for assignment
	 * @param int $id
	 * @return boolean
	 */
	private function _removeFacebookAssignmentFailure( $id )
	{
		$this->AssignmentFacebookFailure->delete($id);
		return true;
	}
	
	/**
	 * Dynamically generates a .csv file
	 * @param array $data
	 * @return boolean
	 */
	public function writeFbCsv($data)
	{
		//create a file
		$file_path = WEBROOT_DIR."/files/assignmentReminder/";
		$filename = "facebook_reminder_notification_".date("Y.m.d").".csv";
	
		//check if file exist
		if (file_exists($file_path.$filename)) {
			$fp = fopen($file_path.$filename, 'a'); //get the file object
			fputcsv($fp, $data); //write the file
		} else {
			$fp = fopen($file_path.$filename, 'a');
			$head_data = array("id", "facebook_id", "content");
			fputcsv($fp, $head_data);
			fputcsv($fp, $data);
		}
		fclose($fp); //close the file
		return true;
	}
	
	/**
	 * Get student facebook id if user is instructor
	 * @param string $user_id
	 * @param string $course_id
	 * @return array
	 */
	private function getChildren( $user_id, $course_id )
	{
		$facebooks = array();
		//get course and section name
		//get appController class object
		$obj = new AppController();
		$course_info = $obj->getCourseNameOfUser( $course_id );
	
		$user_info = $this->PleUser->find('first', array('conditions' =>
				array('PleUser.midasId' => $user_id, 'PleUser.course' => $course_info->course_name, 'PleUser.section' => $course_info->section_name),
				'fields' => array('user_type')));
	
		$user_type = $user_info['PleUser']['user_type'];
	
		//check for user type
		if ($user_type == 'instructor') //@todo need to call instructor name from configuration file
		{
			$notified_users = array();
	
			//get facebook id from the user setting for facebook reminder
			$this->PleUser->virtualFields = array('map_fid' => 'PleUserMapFacebook.facebook_id');
	
			//get today assignments
			$assignment_options[] = array(
					'PleUser.midasId = PleUserMapFacebook.midas_id',
			);
			$options['conditions'][] =   array('PleUser.course' => $course_info->course_name, 'PleUser.section' => $course_info->section_name);
			$options['fields'] = array('midasId','map_fid');
			$options['joins'][] = array(
				'table' => 'ple_user_map_facebook',
				'alias' => 'PleUserMapFacebook',
				'type' => 'INNER',
				'conditions'=> $assignment_options
		    );
	
			//get the students of the instructor
			$notified_users = $this->PleUser->find('all', $options);
	
			//prepare facebook array
			foreach ($notified_users as $notified_user) {
				$facebook['fid'] = $notified_user['PleUser']['map_fid'];
				$facebook['id'] = $notified_user['PleUser']['midasId'];
				$facebooks[] = $facebook;
			}
	
			return $facebooks;
			exit;
		} else {
 		//if user type is student
 		unset($options);
 		$options = array();
        //create array for query conditions
 		$options['conditions'][] = array('FacebookUser.midas_id' => $user_id);
 		$options['fields'] = array('midas_id','facebook_id');
 		$notified_users = $this->FacebookUser->find('first', $options);
 		
 		//check if user exits
 		if (count($notified_users) == 0 ) {
 			return $facebooks;
 		}
 		$facebook['fid'] = $notified_users['FacebookUser']['facebook_id'];
 	    $facebook['id'] = $notified_users['FacebookUser']['midas_id'];
 	    $facebooks[] = $facebook;
 	    return $facebooks;
 	}
	}
}
