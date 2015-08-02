<?php
/**
 * model for handling the group/section in openfire(chat server)
 */
App::uses('AppModel','Model');

class Group extends AppModel
{
	// defining the different database from default database
	public $useDbConfig = 'openfire';
	// Table Name
	public $useTable = 'ofGroup';
	public $primaryKey = '';
	public $cacheQueries = false;

}