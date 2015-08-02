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
 * Application Shell
 *
 * Add your application-wide methods in the class below, your shells
 * will inherit them.
 *
 * @package       app.Console.Command
 */
class EmailShell extends Shell 
{

//including the model.
public $uses = array('OduMailQueue', 'OduMailFailure', 'PleAssignmentReminder', 'PleLastReminderSent', 'AssignmentMailFailure', 'PleUser');

/**
 * Default method for sheel
 */
public function main()
{
   //get odu mail data	
   $results = $this->OduMailQueue->find('all');
   
   foreach ( $results as $result ) {
	   	
	   // call email  function	
	   $resp = $this->sendNotification($result['OduMailQueue']['email'], $result['OduMailQueue']['subject'], $result['OduMailQueue']['mail_data']);
	   
	   //check if notification sent @TODO
	   
	   //email success case
	   if ( $resp ) {
	   	//remove the notification from odu mail queue table
	   	$this->removeOduEmailQueue($result['OduMailQueue']['id']);
		
		//create the CSV user data array 
	   	$csv_data = array('email'=>$result['OduMailQueue']['email'], 'subject'=> $result['OduMailQueue']['subject'], 'mail_data'=> $result['OduMailQueue']['mail_data']);
	   	
	   	//write the csv
	   	$this->writeCsv($csv_data);
	   	
	   	//unset the csv data array
	   	unset($csv_data);
     } else { //email failure case handling
     	$data = array();
     	$data['OduMailFailure']['email']     = $result['OduMailQueue']['email'];
     	$data['OduMailFailure']['subject']   = $result['OduMailQueue']['subject'];
     	$data['OduMailFailure']['mail_data'] = $result['OduMailQueue']['mail_data'];
     	$this->OduMailFailure->create();
     	$this->OduMailFailure->save($data); //saving data in failure case in odu_mail_failure table for further trail 
     	//remove the notification from ODU mail queue table
     	$this->removeOduEmailQueue($result['OduMailQueue']['id']);
     }
   }
 }
 
 
 /**
  * send notification to the email account
  * @param array, string
  * @return boolean
  */
 private function sendNotification($email, $subject, $mail_data)
 {
 	App::uses('CakeEmail', 'Network/Email');
 	$arr = Configure::read('smtpparam');
 	$email_from = Configure::read('email_from');//in bootstrap file
 	$email_title = Configure::read('email_title');//in bootstrap file
 	$reply_to = Configure::read('reply_to');//in bootstrap file
 	$Email = new CakeEmail();
 	$Email->config($arr) //config is define in app/config/email.php:: using default setting
 	->from(array($email_from => $email_title))
 	->to($email)
 	->replyTo($reply_to)
 	->subject($subject)
 	->emailFormat('html');
 	if ($Email->send($mail_data))
     return true;
 	 return false;  
 }
 
 /**
  * remove the entry from db
  * @param int $id
  * @return boolean
  */
 private function removeOduEmailQueue( $id )
 {  
 	$this->OduMailQueue->delete($id);
 	return true;
 }
 
 /**
  * remove the entry from db for failure ODU mail
  * @param int $id
  * @return boolean
  */
 private function removeOduEmailFailure( $id )
 {
 	$this->OduMailFailure->delete($id);
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
 	$filename = "email_post_notification_".date("Y.m.d").".csv";
 	
 	//check if file exist
    if (file_exists($file_path.$filename)) {	
    $fp = fopen($file_path.$filename, 'a'); //get the file object
    fputcsv($fp, $data); //write the file
    } else {
    	$fp = fopen($file_path.$filename, 'a');
    	$head_data = array("Email","Subject","Mail_data");
    	fputcsv($fp, $head_data);
    	fputcsv($fp, $data);
    }
    fclose($fp); //close the file
    return true;
 }

 /**
  * Sending the failed mail notification of posts
  * @params none
  * @return boolean
  */
 public function sendFailMailNotification()
 {
 	//get failed odu mail data
 	$results = $this->OduMailFailure->find('all');
 	foreach ( $results as $result ) {
 	
 		// call email  function
 		$resp = $this->sendNotification($result['OduMailFailure']['email'], $result['OduMailFailure']['subject'], $result['OduMailFailure']['mail_data']);
 	
 		//email success case
 		if ( $resp ) {
 			//remove the notification from odu mail failure table
 			$this->removeOduEmailFailure($result['OduMailFailure']['id']);
 	
 			//create the CSV user data array
 			$csv_data = array('email'=>$result['OduMailFailure']['email'], 'subject'=> $result['OduMailFailure']['subject'], 'mail_data'=> $result['OduMailFailure']['mail_data']);
 	
 			//write the csv
 			$this->writeCsv($csv_data);
 	
 			//unset the csv data array
 			unset($csv_data);
 		}
 	}
 }
 
 /**
  * Send the assignment notification from cron job
  * @param void
  * @return none
  */
 public function sendAssignmentNotification()
 {
 	$ctime = date('Y-m-d'); //get current day
 	
 	//get email id from the user setting for email reminder
 	$this->PleAssignmentReminder->virtualFields = array('email' => 'PleUserMapEmail.email');
 	
   //get last sent id
 	$last_sent_id = $this->PleLastReminderSent->find('first',array('conditions' => array('PleLastReminderSent.date' => $ctime, 'PleLastReminderSent.type' => 'email')));
 	
 	if( count($last_sent_id) > 0 ) {
 		$options['conditions'][] = array('PleAssignmentReminder.id >' => $last_sent_id['PleLastReminderSent']['last_sent_rid']);
 	}
 	
   //get appController class object
   $obj = new AppController();
   $assignments = $obj->getAssignmentConstraints();
   
   //get today assignments
    $assignment_options[] = array(
    		'PleAssignmentReminder.user_id = PleUserMapEmail.midas_id',
    );
   $options['conditions'][] = $assignments;
   $options['fields'] = array('id', 'user_id', 'assignment_uuid', 'assignment_title', 'due_date', 'email', 'course_id');
   $options['joins'][] = array(
   		'table' => 'ple_user_map_email',
   		'alias' => 'PleUserMapEmail',
   		'type' => 'INNER',
   		'conditions'=> $assignment_options
   );
   $options['order'] = array('PleAssignmentReminder.id ASC');
   
   //execute query
   $assignmnet_details = $this->PleAssignmentReminder->find('all', $options);

   //send email
   foreach ( $assignmnet_details as $assignmnet_detail ) {
         $user_id = $assignmnet_detail['PleAssignmentReminder']['user_id'];
   	     $parent_email = $assignmnet_detail['PleAssignmentReminder']['email'];
   	     $body = $assignmnet_detail['PleAssignmentReminder']['assignment_title'];
		 $course_id = $assignmnet_detail['PleAssignmentReminder']['course_id'];
		 
		 //get email array if user is instructor
   	     $email_array = $this->getChildren( $user_id, $course_id, $parent_email); 
		 
		  //set display date for assignments
		 $originalDate = $assignmnet_detail['PleAssignmentReminder']['due_date'];
		 if($originalDate != ""){
		 $newDate = date("F d, Y", strtotime($originalDate));
		 $due_date = " is due on <b>$newDate</b>";
		 }else{
		 	$due_date = " is due on <b>NA</b>";
		 }
		 
   	     //compose mail data
   	     $mail_data = "<div style ='color:#1F497D'><b>Assignment Reminder!</b><br /><br />$course_id<br /><br /><br />Your assignment, <b>$body</b>, $due_date.<br /></div>";
   	     $subject = $course_id." - ".$body;
		 
		 foreach ($email_array as $to_email_data ) {
		 $to_email = $to_email_data['email'];
   	     $to_id = $to_email_data['id'];
   	     $send_email = $this->sendNotification( $to_email, $subject, $mail_data );
   	     
   	     //check for if email sent
   	     if ( $send_email ) {

   	     	//remove the previous entry of current date
   	     	$this->PleLastReminderSent->deleteAll(array('PleLastReminderSent.date'=>$ctime, 'PleLastReminderSent.type'=>'email'));
   	     	$this->PleLastReminderSent->create();
   	     	
   	        //update the table for sent email
   	        $data['PleLastReminderSent']['last_sent_rid'] = $assignmnet_detail['PleAssignmentReminder']['id'];
   	        $data['PleLastReminderSent']['type'] = 'email';
   	        $data['PleLastReminderSent']['date'] = $ctime;
   	        $this->PleLastReminderSent->save($data);

   	        //create the CSV user data array
   	        $csv_data = array('user_id'=>$to_id, 'email'=>$to_email, 'subject'=> $subject, 'mail_data'=> $mail_data);
   	        
   	        //write the csv
   	        $this->writeAssignmentCsv($csv_data);
   	        
   	        //unset the csv data array
   	        unset($csv_data);
   	     } else {
   	     	//handling for email failure
   	     	$email_data = array();
   	     	$email_data['AssignmentMailFailure']['email'] = $to_email;
   	     	$email_data['AssignmentMailFailure']['subject'] = $subject;
   	     	$email_data['AssignmentMailFailure']['mail_data'] = $mail_data;
   	     	$this->AssignmentMailFailure->create();
   	     	$this->AssignmentMailFailure->save($email_data);
   	     }
		 }
   }
   
 }

 /**
  * Sending the failed mail notification of assignments
  * @params none
  * @return boolean
  */
 public function sendFailAssignmentMailNotification()
 {
 	//get failed odu mail data
 	$results = $this->AssignmentMailFailure->find('all');
 	foreach ( $results as $result ) {
 
 		// call email  function
 		$resp = $this->sendNotification($result['AssignmentMailFailure']['email'], $result['AssignmentMailFailure']['subject'], $result['AssignmentMailFailure']['mail_data']);
 
 		//email success case
 		if ( $resp ) {
 			//remove the notification from odu mail failure table
 			$this->_removeAssignmentEmailFailure($result['AssignmentMailFailure']['id']);
 
   	        //create the CSV user data array
   	        $csv_data = array('email'=>$result['AssignmentMailFailure']['email'], 'subject'=> $result['AssignmentMailFailure']['subject'], 'mail_data'=> $result['AssignmentMailFailure']['mail_data']);
   	        
   	        //write the csv
   	        $this->writeAssignmentCsv($csv_data);
   	        
   	        //unset the csv data array
   	        unset($csv_data);
 		}
 	}
 }
 
 /**
  * remove the entry from db for failure assignment mail
  * @param int $id
  * @return boolean
  */
 private function _removeAssignmentEmailFailure( $id )
 {
 	$this->AssignmentMailFailure->delete($id);
 	return true;
 }
 
 /**
  * Dynamically generates a .csv file
  * @param array $data
  * @return boolean
  */
 public function writeAssignmentCsv($data)
 {
 	//create a file
 	$file_path = WEBROOT_DIR."/files/assignmentReminder/";
 	$filename = "assignment_reminder_".date("Y.m.d").".csv";
 
 	//check if file exist
 	if (file_exists($file_path.$filename)) {
 		$fp = fopen($file_path.$filename, 'a'); //get the file object
 		fputcsv($fp, $data); //write the file
 	} else {
 		$fp = fopen($file_path.$filename, 'a');
 		$head_data = array("id", "Email", "Subject", "Mail_data");
 		fputcsv($fp, $head_data);
 		fputcsv($fp, $data);
 	}
 	fclose($fp); //close the file
 	return true;
 }
 
 /**
  * Get student email id if user is instructor
  * @param string $user_id
  * @param string $course_id
  * @param string parent email id
  * @return array
  */
 private function getChildren( $user_id, $course_id, $parent_email )
 {
 	$emails = array();
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
 		
 		//get email id from the user setting for email reminder
 		$this->PleUser->virtualFields = array('map_email' => 'PleUserMapEmail.email');
 		
 		//get today assignments
 		$assignment_options[] = array(
 				'PleUser.midasId = PleUserMapEmail.midas_id',
 		);
 		$options['conditions'][] =   array('PleUser.course' => $course_info->course_name, 'PleUser.section' => $course_info->section_name);
 		$options['fields'] = array('midasId','map_email');
 		$options['joins'][] = array(
 				'table' => 'ple_user_map_email',
 				'alias' => 'PleUserMapEmail',
 				'type' => 'INNER',
 				'conditions'=> $assignment_options
 		);
 		
 		//get the students of the instructor
 		$notified_users = $this->PleUser->find('all', $options);
 		
 		//prepare email array
 		foreach ($notified_users as $notified_user) {
 			$email['email'] = $notified_user['PleUser']['map_email'];
 			$email['id'] = $notified_user['PleUser']['midasId'];
 			$emails[] = $email;
 		}
 		
 		return $emails;
 		exit;
 	}
 	
 	//handling for student
 	unset($emails); //unset the array before array initialisation
 	$email['email'] = $parent_email;
 	$email['id'] = $user_id;
 	$emails[] = $email;
 	return $emails;
 }

 
}
