<?php
/**
 * Model for handling the current online user logs.
 */
App::uses('AppModel','Model');

class ChatCurrentOnlineLog extends AppModel
{
	// This model uses a database table 'ple_current_online_user_logs'
	public $useTable = 'ple_current_online_user_logs'; 
}