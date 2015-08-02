<?php
/**
 * Model for handling the chat users.
 */
App::uses('AppModel','Model');

class Term extends AppModel
{
	// This model uses a database table 'ple_terms'
	 public $useDbConfig = 'pleserver';
	 public $useTable = 'ple_terms';
}
