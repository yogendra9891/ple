<?php
//Model for handing the meeting info
App::uses('AppModel','Model');

class MeetingInfo extends AppModel
{
	// Table Name
	public $useTable = 'chat_meeting_info';
	public $cacheQueries = false;
}