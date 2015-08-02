<?php
/**
 * Model for Twitter message failure handling
 */
App::uses('AppModel','Model');

class TwitterMailFailure extends AppModel
{
	public $useTable = 'ple_post_twitter_failure';
}