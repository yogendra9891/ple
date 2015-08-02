<?php
/**
 * Model for Odu mail
 */
App::uses('AppModel','Model');

class OduMailQueue extends AppModel
{
	public $useTable = 'ple_post_mail_queue';
}