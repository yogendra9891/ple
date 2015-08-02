<?php
/**
 * Model for handling the chat session user logs.
 */
App::uses('AppModel','Model');

class ChatSessionLog extends AppModel
{
	// This model uses a database table 'ple_chat_session_logs'
	public $useTable = 'ple_chat_session_logs'; 
}