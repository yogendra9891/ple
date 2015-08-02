<?php
/**
 * Model for Email users
 */
App::uses('AppModel','Model');

class EmailUser extends AppModel
{
	// This model uses a database table 'ple_user_map_email'
	public $useTable = 'ple_user_map_email';
}