<?php
/**
 * Model for Twitter mail
 */
App::uses('AppModel','Model');

class TwitterMailQueue extends AppModel
{
	public $useTable = 'ple_post_twitter_queue';
}