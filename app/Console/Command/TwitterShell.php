<?php
/**
 * AppShell file
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
 * Application Shell for twitter notifications
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class TwitterShell extends Shell
{
	//uses the model.
    public $uses = array('TwitterMailQueue', 'TwitterMailFailure', 'PleAssignmentReminder', 'PleLastReminderSent', 'AssignmentTwitterFailure', 'PleUser', 'TwitterUser');

/**
 * Default method for sheel
 */
public function main()
{
   //get twitter mail data	
   $results = $this->TwitterMailQueue->find('all');
   
   foreach ( $results as $result ) {
	   // call twitter function	
	   $resp = $this->sendNotification($result['TwitterMailQueue']['twitter_id'], $result['TwitterMailQueue']['mail_data']);
	  
	   if ( $resp == 1 ) {
	   	//remove the notification from twitter mail queue table
	   	$this->removeTwitterQueue($result['TwitterMailQueue']['id']);
		
		//create the CSV user data array
	   	$csv_data = array('twitter_id'=>$result['TwitterMailQueue']['twitter_id'], 'content'=> $result['TwitterMailQueue']['mail_data']);

	   	//write the csv
	   	$this->writeCsv($csv_data);
	   } else if ( $resp == 0 ) {
	   	$data = array();
	   	$data['TwitterMailFailure']['twitter_id']   = $result['TwitterMailQueue']['twitter_id'];
	   	$data['TwitterMailFailure']['mail_data']     = $result['TwitterMailQueue']['mail_data'];
	   	$this->TwitterMailFailure->create();
	   	$this->TwitterMailFailure->save($data); //saving data in failure case in twitter_mail_failure table for further trail   	
	   } else if ( $resp == 2 ) {  //twitter app not authentic case(can be used for future for notification on dashboard)
	   	
	   }
   }
 }
 
 /**
  * Authenticate the ple user
  */
 private function twitterAuth()
 {
 	//Load the app/Vendor/twitter/twitteroauth/twitteroauth.php
 	App::import('Vendor', 'twitter', array('file' => 'twitter' . DS . 'twitteroauth' . DS . 'twitteroauth.php'));
 
 	//Get user access tokens from bootstrap.
 	$oauth_token = Configure::read('oauth_token');
 	$oauth_token_secret = Configure::read('oauth_token_secret');
 
 	//get conmsumer key, consumer secret key
 	$consumer_key = Configure::read('CONSUMER_KEY');
 	$consumer_secret = Configure::read('CONSUMER_SECRET');
 
 	//Create a TwitterOauth object with consumer/user tokens.
 	$connection = new TwitterOAuth( $consumer_key, $consumer_secret, $oauth_token, $oauth_token_secret );
 	return $connection;
 }
 
 /**
  * send notification to the twitter account
  * @param array, string
  * @return boolean
  */
 private function sendNotification($twitter_id, $message_string)
 {
 	//get connection object
 	$connection = $this->twitterAuth();
 	$options = array("user_id" => $twitter_id, "text" => substr($message_string, 0, 130));
 	$msg = $connection->post('direct_messages/new', $options);
 	
 	if (isset($msg->id)) { //@TODO check for message sent
 		return 1;
 	} else if($msg->errors[0]->code == 150) {
 		return 2; //app not following case
 	} else {
 		return 0; //message not sent case
 	}
 }
 
 /**
  * remove the entry from db
  * @param int $id
  * @return boolean
  */
 private function removeTwitterQueue( $id )
 {  
 	$this->TwitterMailQueue->delete($id);
 	return true;
 }

 /**
  * remove the entry from db for failure message sent
  * @param int $id
  * @return boolean
  */
 private function _removeTwitterFailure( $id )
 {
 	$this->TwitterMailFailure->delete($id);
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
 	$filename = "twitter_post_notification_".date("Y.m.d").".csv";
 
 	//check if file exist
 	if (file_exists($file_path.$filename)) {
 		$fp = fopen($file_path.$filename, 'a'); //get the file object
 		fputcsv($fp, $data); //write the file
 	} else {
 		$fp = fopen($file_path.$filename, 'a');
 		$head_data = array("twitter_id","content");
 		fputcsv($fp, $head_data);
 		fputcsv($fp, $data);
 	}
 	fclose($fp); //close the file
 	return true;
 }
 
 /**
  * Sending the failed twitter notification of posts
  * @params none
  * @return boolean
  */
 public function sendFailTwitterNotification()
 {
 	//get twitter mail users and data
 	$results = $this->TwitterMailFailure->find('all');
 	foreach ( $results as $result ) {
 
 		// call twitter function
 		$resp = $this->sendNotification($result['TwitterMailFailure']['twitter_id'], $result['TwitterMailFailure']['mail_data']);
 
 		if ( $resp == 1 ) { //success case
 			//remove the notification from twitter mail queue table
 			$this->_removeTwitterFailure($result['TwitterMailFailure']['id']);
 
 			//create the CSV user data array
 			$csv_data = array('twitter_id'=>$result['TwitterMailFailure']['twitter_id'], 'content'=> $result['TwitterMailFailure']['mail_data']);
 
 			//write the csv
 			$this->writeCsv($csv_data);
 			//unset the csv data array
 			unset($csv_data);
 		} else if ($resp == 2) { //twitter app not following case(can be used for future for notification on dashboard)
 
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
 	$this->PleAssignmentReminder->virtualFields = array('tid' => 'PleUserMapTwitter.twitterId');
 
 	//get last sent id
 	$last_sent_id = $this->PleLastReminderSent->find('first',array('conditions' => array('PleLastReminderSent.date' => $ctime, 'PleLastReminderSent.type' => 'twitter')));
 
 	if( count($last_sent_id) > 0 ) {
 		$options['conditions'][] = array('PleAssignmentReminder.id >' => $last_sent_id['PleLastReminderSent']['last_sent_rid']);
 	}
 
 	//get appController class object
 	$obj = new AppController();
 	$assignments = $obj->getAssignmentConstraints();
 
 	//get today assignments
 
 	$options['conditions'][] = $assignments;
 	$options['fields'] = array('id', 'user_id', 'assignment_uuid', 'assignment_title', 'due_date', 'course_id');
 	$options['order'] = array('PleAssignmentReminder.id ASC');
 
 	//execute query
 	$assignmnet_details = $this->PleAssignmentReminder->find('all', $options);
 	
 
 	//send twitter reminder
 	foreach( $assignmnet_details as $assignmnet_detail ) {
	    $user_id = $assignmnet_detail['PleAssignmentReminder']['user_id'];
 		//$to_twitter = $assignmnet_detail['PleAssignmentReminder']['tid'];
 		$body = $assignmnet_detail['PleAssignmentReminder']['assignment_title'];
		$course_id = $assignmnet_detail['PleAssignmentReminder']['course_id'];
 		
		//get twitter users array if user is instructor
 		$twitter_users_array = $this->getChildren( $user_id, $course_id );
		
 		//set display date for assignments
 		$originalDate = $assignmnet_detail['PleAssignmentReminder']['due_date'];
		if($originalDate != ""){
 		$newDate = date("F d, Y", strtotime($originalDate));
 		$due_date = " due on $newDate";
		}else{
		 	$due_date = " is due on NA";
		 }
 		
 		//compose mail date
 		$mail_data = "Assignment Reminder! $course_id. Your assignment, $body, $due_date.";
 		$subject = $course_id." - ".$body;
        
		//send the reminder to multiple users
 		foreach ($twitter_users_array as $to_twitter_data ) {
		$to_twitter = $to_twitter_data['twitter_id'];
 		$to_id = $to_twitter_data['id'];
 		$send_twitter = $this->sendNotification( $to_twitter, $mail_data );
 
 		//check for if facebook reminder sent
 		if ( $send_twitter == 1) {
 
 			//remove the previous entry of current date
 			$this->PleLastReminderSent->deleteAll(array('PleLastReminderSent.date'=>$ctime, 'PleLastReminderSent.type'=>'twitter'));
 			$this->PleLastReminderSent->create();
 
 			//update the table for sent facebook reminder
 			$data['PleLastReminderSent']['last_sent_rid'] = $assignmnet_detail['PleAssignmentReminder']['id'];
 			$data['PleLastReminderSent']['type'] = 'twitter';
 			$data['PleLastReminderSent']['date'] = $ctime;
 			$this->PleLastReminderSent->save($data);
 
 			//create the CSV user data array
 			$csv_data = array('id'=>$to_id, 'tid'=>$to_twitter, 'mail_data'=> $mail_data);
 
 			//write the csv
 			$this->writeTwitterCsv($csv_data);
 
 			//unset the csv data array
 			unset($csv_data);
 		} else if ( $send_twitter == 2) { //twitter app not following case(can be used for future for notification on dashboard)
 			
 		} else {
 			//handling for twitter reminder failure
	 		$tw_data = array();
	 		$tw_data['AssignmentTwitterFailure']['twitter_id'] = $to_twitter;
	 		$tw_data['AssignmentTwitterFailure']['mail_data'] = $mail_data;
	 		$this->AssignmentTwitterFailure->create();
	 		$this->AssignmentTwitterFailure->save($tw_data);
 		}
		}
 	}
 }

 /**
  * Sending the failed twitter notification of assignments
  * @params none
  * @return boolean
  */
 public function sendFailTwitterAssignmentNotification()
 {
 	//get facebook mail users and data
 	$results = $this->AssignmentTwitterFailure->find('all');
 	foreach ( $results as $result ) {
 
 		// call facebook function
 		$resp = $this->sendNotification($result['AssignmentTwitterFailure']['twitter_id'], $result['AssignmentTwitterFailure']['mail_data']);
 
 		if ( $resp == 1 ) { //success case
 			//remove the notification from facebook mail queue table
 			$this->_removeTwitterAssignmentFailure($result['AssignmentTwitterFailure']['id']);
 
 			//create the CSV user data array
 			$csv_data = array('tid'=>$result['AssignmentTwitterFailure']['twitter_id'], 'mail_data'=> $result['AssignmentTwitterFailure']['mail_data']);
 
 			//write the csv
 			$this->writeTwitterCsv($csv_data);
 
 			//unset the csv data array
 			unset($csv_data);
 		} else if ($resp == 2) { //app not authentic case(can be used for future for notification on dashboard)
 
 		}
 	}
 }
 
 /**
  * remove the entry from db for twitter failure message sent for assignment
  * @param int $id
  * @return boolean
  */
 private function _removeTwitterAssignmentFailure( $id )
 {
 	$this->AssignmentTwitterFailure->delete($id);
 	return true;
 }
 
 
 /**
  * Dynamically generates a .csv file
  * @param array $data
  * @return boolean
  */
 public function writeTwitterCsv($data)
 {
 	//create a file
 	$file_path = WEBROOT_DIR."/files/assignmentReminder/";
 	$filename = "twitter_reminder_notification_".date("Y.m.d").".csv";
 
 	//check if file exist
 	if (file_exists($file_path.$filename)) {
 		$fp = fopen($file_path.$filename, 'a'); //get the file object
 		fputcsv($fp, $data); //write the file
 	} else {
 		$fp = fopen($file_path.$filename, 'a');
 		$head_data = array("id", "twitter_id", "content");
 		fputcsv($fp, $head_data);
 		fputcsv($fp, $data);
 	}
 	fclose($fp); //close the file
 	return true;
 }
 
  /**
  * Get twittrer id
  * @param string $user_id
  * @param string $course_id
  * @return array
  */
 private function getChildren( $user_id, $course_id )
 {
 	$twitters = array();
 
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
 
 		//get twitter id from the user setting for twitter reminder
 		$this->PleUser->virtualFields = array('map_twitter_id' => 'PleUserMapTwitter.twitterId');
 
 		//get today assignments
 		$assignment_options[] = array(
 				'PleUser.midasId = PleUserMapTwitter.midasId',
 		);
 		$options['conditions'][] =   array('PleUser.course' => $course_info->course_name, 'PleUser.section' => $course_info->section_name);
 		$options['fields'] = array('midasId','map_twitter_id');
 		$options['joins'][] = array(
 				'table' => 'ple_user_map_twitter',
 				'alias' => 'PleUserMapTwitter',
 				'type' => 'INNER',
 				'conditions'=> $assignment_options
 		);
 
 		//get the students of the instructor
 		$notified_users = $this->PleUser->find('all', $options);
 
 		//prepare twitter array
 		foreach ($notified_users as $notified_user) {
 			$twitter['twitter_id'] = $notified_user['PleUser']['map_twitter_id'];
 			$twitter['id'] = $notified_user['PleUser']['midasId'];
 			$twitters[] = $twitter;
 		}
 		return $twitters;
 		exit;
 	} else {
 		//if user type is student
 		unset($options);
 		$options = array();
        //create array for query conditions
 		$options['conditions'][] = array('TwitterUser.midasId' => $user_id);
 		$options['fields'] = array('midasId','twitterId');
 		$notified_users = $this->TwitterUser->find('first', $options);
 		
 		//check if user exits
 		if (count($notified_users) == 0 ) {
 			return $twitters;
 		}
 		$twitter['twitter_id'] = $notified_users['TwitterUser']['twitterId'];
 	    $twitter['id'] = $notified_users['TwitterUser']['midasId'];
 	    $twitters[] = $twitter;
 	    return $twitters;
 	}
 
 }
}
