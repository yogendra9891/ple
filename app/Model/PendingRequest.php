<?php
/**
 * model for handling the group/section in openfire(chat server) for Properties
 */
App::uses('AppModel','Model');

class PendingRequest extends AppModel
{
	// This model uses a database table 'chat_invited_users'
	 public $useTable = 'chat_pending_requests'; 
}