<?php
/**
 * Model for Facebook message failure handling.
 */
App::uses('AppModel','Model');

class FacebookMailFailure extends AppModel
{
	public $useTable = 'ple_post_facebook_failure';
}