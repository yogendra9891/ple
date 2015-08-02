<?php
/**
 * Model for handling the ple courses users.
 */
App::uses('AppModel','Model');

class Course extends AppModel
{
	// This model uses a database table 'ple_courses'
	 public $useDbConfig = 'pleserver';
	 public $useTable = 'ple_courses'; 
}
