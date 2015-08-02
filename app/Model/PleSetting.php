<?php
/**
 * model for handling the group/section in openfire(chat server) for Properties
 */
App::uses('AppModel','Model');

class PleSetting extends AppModel
{
	// This model uses a database table 'chat_invited_users'
	 public $useTable = 'ple_settings'; 
}