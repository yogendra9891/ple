<?php
/**
 * Method to make the rss for assignment reminders
 * @params array
 * @return array
 */
//include appcontroller class
App::uses('AppController', 'Controller');

/**
 * making the RSS feed url.
 * @param array $item
 * @return multitype:string multitype:string NULL
 */
function transformRss($item) 
{
	$assignment_url = getAssignmentLink($item['PleAssignmentReminder']['id']);
	return array('title' => 'ASSIGNMENT REMINDER: '.$item['PleAssignmentReminder']['course_id'].' - '.ucfirst($item['PleAssignmentReminder']['assignment_title']),
		'link' => $assignment_url,
		'guid' => array('controller' => 'assignments', 'action' => 'logOut', $item['PleAssignmentReminder']['id']),
		'description' => 'Your assignment, <b>'.substr(ucfirst(trim($item['PleAssignmentReminder']['assignment_title'])), 0, 100). ', </b>is due on '. date('d-m-Y h:i A',strtotime($item['PleAssignmentReminder']['due_date'])).'.',
		'author' => ucfirst($item['Forum']['post_by']),
		'pubDate' => date('d-m-Y h:i A', strtotime($item['PleAssignmentReminder']['due_date'])),	
	);
}

/**
 * Finding the assignment page link
 * @param int $aid
 * @return string
 */
function getAssignmentLink( $aid )
{
	$link = AppController::getAssignmentLink($aid);
	return $link;
}

//making the rss feed of assignments coming from posts controller.
$this->set('items', $this->Rss->items($assignment, 'transformRss'));
//$this->set('channelData', $channelData);
?>