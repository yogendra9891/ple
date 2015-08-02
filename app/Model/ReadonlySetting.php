<?php
/**
 * model for handling the read only setting in forum for Properties
 */
App::uses('AppModel','Model');

class ReadonlySetting extends AppModel
{
	 public $useTable = 'ple_contentpage_ro_setting'; 
}