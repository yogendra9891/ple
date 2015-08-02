<?php
/**
 * model for handling the forum available date setting.
 */
App::uses('AppModel','Model');

class PleForumAvailabilityNew extends AppModel
{
	// defining the different database from default database(may be on different server)
	// defined in database config file.
	public $useTable = 'ple_page_forum_availability_new';
}