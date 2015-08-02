<?php
/**
 * Model for Facebook mail
 */
App::uses('AppModel','Model');

class FacebookMailQueue extends AppModel
{
	public $useTable = 'ple_post_facebook_queue';
}