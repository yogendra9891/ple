<?php
/**
 * Model for ContentPage page structure.
 */
App::uses('AppModel','Model');

class ContentPageStructure extends AppModel
{
	// defining the different database from default database(may be on different server)
	// defined in database config file.
	public $useDbConfig = 'odu';
	public $useTable = 'ple_content_page_structure';
}