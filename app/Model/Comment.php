<?php
/**
 * Model for handling the forum users
 * users table is common for chat and forum usres.
 */
App::uses('AppModel','Model');

class Comment extends AppModel
{
	//Table Name
	public $useTable = 'ple_questions_thread';
}