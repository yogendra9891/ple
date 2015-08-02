<?php
/**
 * model for handling the assignments
 */
App::uses('AppModel','Model');

class PleAssignment extends AppModel
{
	// defining the different database from default database
	public $useDbConfig = 'pleserver';
	// Table Name
	public $useTable = 'ple_assignments';
	public $primaryKey = '';
	public $cacheQueries = false;

}