<?php
/**
 * Model for twiiter users
 */
App::uses('AppModel','Model');

class TwitterUser extends AppModel
{
	 // This model uses a database table 'ple_user_map_twitter'
	 public $useTable = 'ple_user_map_twitter';
}
