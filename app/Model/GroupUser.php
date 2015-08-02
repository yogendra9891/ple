<?php
/**
 * model for handling the group/section users in openfire(chat server) for Properties
 */
App::uses('AppModel','Model');

class GroupUser extends AppModel
{
	// defining the different database from default database
	public $useDbConfig = 'openfire';
	// Table Name
	public $useTable = 'ofGroupUser';
	public $primaryKey = '';
	public $cacheQueries = false;
}