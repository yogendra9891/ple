<?php
/**
 * Model for handling the chat users.
 */
App::uses('AppModel','Model');

class Chat extends AppModel
{
	// This model uses a database table 'chat_invited_users'
	 public $useTable = 'chat_invited_users'; 
}
