<?php
//Model for handing the meeting users
App::uses('AppModel','Model');

class MeetingUser extends AppModel
{
	// Table Name
	public $useTable = 'chat_meeting_users';
	public $cacheQueries = false;
}