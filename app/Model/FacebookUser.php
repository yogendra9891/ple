<?php
/**
 * Model for Facebook users
 */
App::uses('AppModel','Model');

class FacebookUser extends AppModel
{
	// This model uses a database table 'ple_user_map_facebook'
	public $useTable = 'ple_user_map_facebook';
}