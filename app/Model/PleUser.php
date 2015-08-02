<?php
/**
 * Model for User registration handling
 */
App::uses('AppModel','Model');

class PleUser extends AppModel
{
	public $useTable = "ple_register_users";
}