<?php

App::uses('AppModel','Model');

class ChatUser extends AppModel
{
	// defining the different database from default database
	public $useDbConfig = 'openfire';
	// Table Name
	public $useTable = 'ofUser';
	public $primaryKey = '';
	public $cacheQueries = false;
}